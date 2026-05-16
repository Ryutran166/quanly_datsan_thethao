<?php
namespace Nhom2\QuanlyDatsanThethao\Models;

use PDO;

class ServicesModel
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /** @return array<int, array<string,mixed>> */
    public function getCourtsByOwner(int $ownerId): array
    {
        $stmt = $this->pdo->prepare("SELECT id, name FROM courts WHERE owner_id = :owner_id ORDER BY id DESC");
        $stmt->execute([':owner_id' => $ownerId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /** @return array<int, array<string,mixed>> */
    public function getOwnerServices(int $ownerId, array $filters = [], int $page = 1, int $perPage = 10, int &$total = 0): array
    {
        $keyword = trim((string)($filters['keyword'] ?? ''));
        $status = trim((string)($filters['status'] ?? ''));

        $where = ["c.owner_id = :owner_id"];
        $params = [':owner_id' => $ownerId];

        if ($keyword !== '') {
            $where[] = "(s.service_name LIKE :kw OR s.description LIKE :kw)";
            $params[':kw'] = '%' . $keyword . '%';
        }

        if ($status !== '' && in_array($status, ['active', 'inactive'], true)) {
            $where[] = "s.status = :status";
            $params[':status'] = $status;
        }

        $whereSql = implode(' AND ', $where);

        $countSql = "SELECT COUNT(*) AS total
                      FROM services s
                      JOIN courts c ON s.court_id = c.id
                      WHERE {$whereSql}";
        $countStmt = $this->pdo->prepare($countSql);
        $countStmt->execute($params);
        $total = (int)($countStmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0);

        $page = max(1, $page);
        $offset = max(0, ($page - 1) * $perPage);

        $sql = "SELECT
                    s.id,
                    s.court_id,
                    s.service_name,
                    s.price,
                    s.description,
                    s.image,
                    s.status,
                    s.created_at,
                    c.name AS court_name
                FROM services s
                JOIN courts c ON s.court_id = c.id
                WHERE {$whereSql}
                ORDER BY s.created_at DESC, s.id DESC
                LIMIT :limit OFFSET :offset";

        $stmt = $this->pdo->prepare($sql);
        foreach ($params as $k => $v) {
            $stmt->bindValue($k, $v);
        }
        $stmt->bindValue(':limit', (int)$perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getServiceByIdForOwner(int $serviceId, int $ownerId): ?array
    {
        $sql = "SELECT
                    s.*,
                    c.name AS court_name
                FROM services s
                JOIN courts c ON s.court_id = c.id
                WHERE s.id = :service_id AND c.owner_id = :owner_id
                LIMIT 1";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':service_id' => $serviceId, ':owner_id' => $ownerId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public function createService(array $data): int
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO services (court_id, service_name, price, description, image, status)
             VALUES (:court_id, :service_name, :price, :description, :image, :status)"
        );

        $stmt->execute([
            ':court_id' => (int)$data['court_id'],
            ':service_name' => $data['service_name'],
            ':price' => (float)$data['price'],
            ':description' => $data['description'] ?? null,
            ':image' => $data['image'] ?? null,
            ':status' => $data['status'] ?? 'active',
        ]);

        return (int)$this->pdo->lastInsertId();
    }

    public function updateService(int $serviceId, array $data): bool
    {
        $stmt = $this->pdo->prepare(
            "UPDATE services
             SET court_id = :court_id,
                 service_name = :service_name,
                 price = :price,
                 description = :description,
                 image = :image,
                 status = :status,
                 updated_at = NOW()
             WHERE id = :id"
        );

        return $stmt->execute([
            ':id' => $serviceId,
            ':court_id' => (int)$data['court_id'],
            ':service_name' => $data['service_name'],
            ':price' => (float)$data['price'],
            ':description' => $data['description'] ?? null,
            ':image' => $data['image'] ?? null,
            ':status' => $data['status'] ?? 'active',
        ]);
    }

    public function deleteService(int $serviceId): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM services WHERE id = :id");
        return $stmt->execute([':id' => $serviceId]);
    }

    /** @return array<int, array<string,mixed>> */
    public function getActiveServicesByCourt(int $courtId): array
    {
        $stmt = $this->pdo->prepare(
            "SELECT id, service_name, price, description, image
             FROM services
             WHERE court_id = :court_id AND status = 'active'
             ORDER BY created_at DESC, id DESC"
        );
        $stmt->execute([':court_id' => $courtId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

