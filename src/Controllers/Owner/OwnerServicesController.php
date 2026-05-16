<?php

namespace Nhom2\QuanlyDatsanThethao\Controllers\Owner;

use Nhom2\QuanlyDatsanThethao\Controllers\BaseController;
use Nhom2\QuanlyDatsanThethao\Database;
use Nhom2\QuanlyDatsanThethao\Models\ServicesModel;
use PDO;

class OwnerServicesController extends BaseController
{
    private ServicesModel $servicesModel;
    private PDO $pdo;

    public function __construct()
    {
        parent::__construct();
        $this->pdo = Database::getInstance()->getConnection();
        $this->servicesModel = new ServicesModel($this->pdo);
    }

    private function requireOwner(): int
    {
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'owner') {
            header('Location: index.php');
            exit();
        }
        return (int)($_SESSION['user_id'] ?? 0);
    }

    private function getCourtIdBelongsToOwner(int $courtId, int $ownerId): bool
    {
        $stmt = $this->pdo->prepare('SELECT id FROM courts WHERE id = :court_id AND owner_id = :owner_id LIMIT 1');
        $stmt->execute([':court_id' => $courtId, ':owner_id' => $ownerId]);
        return (bool)$stmt->fetch(PDO::FETCH_ASSOC);
    }

    // DANH SÁCH (filter theo court_id)
    public function index(): void
    {
        $ownerId = $this->requireOwner();

        $courtId = (int)($_GET['court_id'] ?? 0);
        if ($courtId <= 0 || !$this->getCourtIdBelongsToOwner($courtId, $ownerId)) {
            header('Location: index.php?action=owner_my_courts');
            exit();
        }

        $filters = [
            'keyword' => trim((string)($_GET['keyword'] ?? '')),
            'status' => trim((string)($_GET['status'] ?? '')),
        ];
        $page = max(1, (int)($_GET['page'] ?? 1));
        $perPage = 10;
        $total = 0;

        // NOTE: ServicesModel hiện tại lọc theo owner_id + keyword/status.
        // Module services management yêu cầu theo court_id, nên ta lọc thêm trong controller.
        $servicesAll = $this->servicesModel->getOwnerServices($ownerId, $filters, $page, $perPage, $total);

        // Lọc đúng court_id
        $services = array_values(array_filter($servicesAll, fn($s) => (int)($s['court_id'] ?? 0) === $courtId));

        // Court name để hiển thị
        $courtName = null;
        $stmtCourt = $this->pdo->prepare('SELECT name FROM courts WHERE id = :id AND owner_id = :owner_id LIMIT 1');
        $stmtCourt->execute([':id' => $courtId, ':owner_id' => $ownerId]);
        $courtName = $stmtCourt->fetch(PDO::FETCH_ASSOC)['name'] ?? null;

        $totalPages = 1;

        $court = ['id' => $courtId, 'name' => $courtName];

        require_once PROJECT_ROOT . '/views/owner/services/OwnerServicesList.php';
    }

    public function create(): void
    {
        $ownerId = $this->requireOwner();

        $courtId = (int)($_GET['court_id'] ?? 0);
        if ($courtId <= 0 || !$this->getCourtIdBelongsToOwner($courtId, $ownerId)) {
            header('Location: index.php?action=owner_my_courts');
            exit();
        }

        require_once PROJECT_ROOT . '/views/owner/services/OwnerServiceCreate.php';
    }

    public function store(): void
    {
        $ownerId = $this->requireOwner();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?action=owner_services');
            exit();
        }

        $courtId = (int)($_POST['court_id'] ?? 0);
        if ($courtId <= 0 || !$this->getCourtIdBelongsToOwner($courtId, $ownerId)) {
            header('Location: index.php?action=owner_my_courts');
            exit();
        }

        $serviceName = trim((string)($_POST['service_name'] ?? ''));
        $price = (float)($_POST['price'] ?? 0);
        $description = trim((string)($_POST['description'] ?? ''));
        $status = trim((string)($_POST['status'] ?? 'active'));
        if (!in_array($status, ['active', 'inactive'], true)) {
            $status = 'active';
        }

        if ($serviceName === '' || $price <= 0) {
            header('Location: index.php?action=owner_service_create&court_id=' . $courtId . '&error=invalid_input');
            exit();
        }

        $this->servicesModel->createService([
            'court_id' => $courtId,
            'service_name' => $serviceName,
            'price' => $price,
            'description' => $description !== '' ? $description : null,
            'status' => $status,
            'image' => null,
        ]);

        header('Location: index.php?action=owner_services&court_id=' . $courtId . '&success=created');
        exit();
    }

    public function edit(): void
    {
        $ownerId = $this->requireOwner();

        $serviceId = (int)($_GET['id'] ?? 0);
        if ($serviceId <= 0) {
            header('Location: index.php?action=owner_services');
            exit();
        }

        // Tìm service theo owner bằng cách kiểm tra court thuộc owner
        // Lấy service trước, rồi check.
        $tmp = null;
        $stmt = $this->pdo->prepare('SELECT s.* , c.owner_id FROM services s JOIN courts c ON s.court_id = c.id WHERE s.id = :id LIMIT 1');
        $stmt->execute([':id' => $serviceId]);
        $tmp = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$tmp || (int)$tmp['owner_id'] !== $ownerId) {
            header('Location: index.php?action=owner_services');
            exit();
        }

        $service = $tmp;
        $courtId = (int)$service['court_id'];

        require_once PROJECT_ROOT . '/views/owner/services/OwnerServiceEdit.php';
    }

    public function update(): void
    {
        $ownerId = $this->requireOwner();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?action=owner_services');
            exit();
        }

        $serviceId = (int)($_POST['id'] ?? 0);
        if ($serviceId <= 0) {
            header('Location: index.php?action=owner_services');
            exit();
        }

        $service = $this->servicesModel->getServiceByIdForOwner($serviceId, $ownerId);
        if (!$service) {
            header('Location: index.php?action=owner_services');
            exit();
        }

        $courtId = (int)($_POST['court_id'] ?? (int)$service['court_id']);
        if ($courtId <= 0 || !$this->getCourtIdBelongsToOwner($courtId, $ownerId)) {
            header('Location: index.php?action=owner_my_courts');
            exit();
        }

        $serviceName = trim((string)($_POST['service_name'] ?? ''));
        $price = (float)($_POST['price'] ?? 0);
        $description = trim((string)($_POST['description'] ?? ''));
        $status = trim((string)($_POST['status'] ?? $service['status'] ?? 'active'));
        if (!in_array($status, ['active', 'inactive'], true)) {
            $status = 'active';
        }

        if ($serviceName === '' || $price <= 0) {
            header('Location: index.php?action=owner_service_edit&id=' . $serviceId . '&error=invalid_input');
            exit();
        }

        $this->servicesModel->updateService($serviceId, [
            'court_id' => $courtId,
            'service_name' => $serviceName,
            'price' => $price,
            'description' => $description !== '' ? $description : null,
            'status' => $status,
            'image' => null,
        ]);

        header('Location: index.php?action=owner_services&court_id=' . $courtId . '&success=updated');
        exit();
    }

    public function delete(): void
    {
        $ownerId = $this->requireOwner();

        $serviceId = (int)($_GET['id'] ?? 0);
        if ($serviceId <= 0) {
            header('Location: index.php?action=owner_services');
            exit();
        }

        $service = $this->servicesModel->getServiceByIdForOwner($serviceId, $ownerId);
        if (!$service) {
            header('Location: index.php?action=owner_services');
            exit();
        }

        $courtId = (int)$service['court_id'];
        $this->servicesModel->deleteService($serviceId);

        header('Location: index.php?action=owner_services&court_id=' . $courtId . '&success=deleted');
        exit();
    }

    public function toggleStatus(): void
    {
        $ownerId = $this->requireOwner();

        $serviceId = (int)($_GET['id'] ?? 0);
        if ($serviceId <= 0) {
            header('Location: index.php?action=owner_services');
            exit();
        }

        $service = $this->servicesModel->getServiceByIdForOwner($serviceId, $ownerId);
        if (!$service) {
            header('Location: index.php?action=owner_services');
            exit();
        }

        $courtId = (int)$service['court_id'];
        $newStatus = (($service['status'] ?? 'active') === 'active') ? 'inactive' : 'active';

        $this->servicesModel->updateService($serviceId, [
            'court_id' => $courtId,
            'service_name' => $service['service_name'],
            'price' => (float)$service['price'],
            'description' => $service['description'],
            'status' => $newStatus,
            'image' => $service['image'],
        ]);

        header('Location: index.php?action=owner_services&court_id=' . $courtId . '&success=status_changed');
        exit();
    }
}

