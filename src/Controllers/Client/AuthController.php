<?php

namespace Nhom2\QuanlyDatsanThethao\Controllers\Client;

use Nhom2\QuanlyDatsanThethao\Models\UserModel;

class AuthController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function showLoginForm()
    {
        require_once PROJECT_ROOT . '/views/client/auth/login.php';
    }

    public function showRegisterForm()
    {
        require_once PROJECT_ROOT . '/views/client/auth/register.php';
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /login");
            exit();
        }

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            header("Location: /login?error=missing_fields");
            exit();
        }

        $user = $this->userModel->findUserByEmail($email);

        if (!$user || !password_verify($password, $user['password'])) {
            header("Location: /login?error=invalid_credentials");
            exit();
        }

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_role'] = $user['role'] ?? 'user';

        header("Location: /");
        exit();
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /register");
            exit();
        }

        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $phone = $_POST['phone'] ?? null;

        if (empty($name) || empty($email) || empty($password)) {
            header("Location: /register?error=missing_fields");
            exit();
        }

        if ($this->userModel->findUserByEmail($email)) {
            header("Location: /register?error=email_exists");
            exit();
        }

        if ($this->userModel->createUser($name, $email, $password, $phone)) {
            header("Location: /login?status=registered");
            exit();
        }

        header("Location: /register?error=registration_failed");
        exit();
    }

    public function logout()
    {
        session_destroy();
        header("Location: /");
        exit();
    }
}
