<?php
// src/Controllers/CourtsController.php

namespace Nhom2\QuanlyDatsanThethao\Controllers;

use Nhom2\QuanlyDatsanThethao\Models\CourtsModel;

class CourtsController
{
    private $courtsModel;

    public function __construct()
    {
        $this->courtsModel = new CourtsModel();
    }

    /* =============================
       DANH SÁCH SÂN
    ============================== */
    public function index()
    {
        $keyword = $_GET['keyword'] ?? null;

        $courts = $this->courtsModel->getAllCourts($keyword);

        require_once PROJECT_ROOT . '/views/Courts/CourtsList.php';
    }

    /* =============================
       FORM THÊM
    ============================== */
    public function create()
    {
        require_once PROJECT_ROOT . '/views/layout/header.php';
        require_once PROJECT_ROOT . '/views/Courts/CourtsCreate.php';
        require_once PROJECT_ROOT . '/views/layout/footer.php';
    }

    /* =============================
       INSERT
    ============================== */
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $this->courtsModel->addCourts([
                'name'      => $_POST['name'],
                'price'     => $_POST['price'],
                'status'    => 'available',
                'image_url' => $_POST['image_url']
            ]);
        }

        header("Location:index.php");
        exit();
    }

    /* =============================
       FORM EDIT
    ============================== */
    public function edit()
    {
        $id = $_GET['id'];

        $court = $this->courtsModel->getCourtById($id);

        require_once PROJECT_ROOT . '/views/layout/header.php';
        require_once PROJECT_ROOT . '/views/Courts/CourtsEdit.php';
        require_once PROJECT_ROOT . '/views/layout/footer.php';
    }

    /* =============================
       UPDATE
    ============================== */
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $id = $_POST['id'];

            $data = [
                'name' => $_POST['name'],
                'price' => $_POST['price'],
                'status' => $_POST['status'],
                'image_url' => $_POST['image_url']
            ];

            $this->courtsModel->updateCourt($id, $data);
        }

        header("Location:index.php");
        exit();
    }

    /* =============================
       DELETE
    ============================== */
    public function delete()
    {
        $id = $_GET['id'];

        $this->courtsModel->deleteCourt($id);

        header("Location:index.php");
        exit();
    }

    /* =============================
       BOOKING PAGE
    ============================== */
    public function booking()
    {
        $id = $_GET['id'];

        $court = $this->courtsModel->getCourtById($id);

        require_once PROJECT_ROOT . '/views/layout/header.php';
        require_once PROJECT_ROOT . '/views/Courts/CourtsBooking.php';
        require_once PROJECT_ROOT . '/views/layout/footer.php';
    }

    public function confirm_booking()
    {
        echo "Đặt sân thành công";
    }
}