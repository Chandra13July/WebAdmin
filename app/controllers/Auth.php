<?php

class Auth extends Controller
{
    private $EmployeeModel;

    public function __construct()
    {
        $this->EmployeeModel = $this->model('EmployeeModel');
    }

    public function loginAdmin()
    {
        $this->view('layout/header');
        $this->view('auth/loginAdmin');
    }

    public function btnLoginAdmin()
    {
        $email = trim($_POST['email']);
        $password = $_POST['password'];

        // Validasi input email dan password
        if (empty($email) || empty($password)) {
            $_SESSION['error'] = "Email dan password harus diisi!";
            header('Location: ' . BASEURL . '/auth/loginAdmin');
            exit;
        }

        // Cari pengguna berdasarkan email
        $user = $this->EmployeeModel->findUserByEmail($email);

        if ($user) {
            // Verifikasi kata sandi
            if (password_verify($password, $user['Password'])) {
                // Set variabel sesi
                unset($_SESSION['error']);
                unset($_SESSION['login_data']);
                $_SESSION['user_id'] = $user['EmployeeId']; // Gunakan EmployeeId
                $_SESSION['username'] = $user['Username'];
                $_SESSION['ImageUrl'] = $user['ImageUrl'] ?? BASEURL . '/img/customer/User.png'; // Set ImageUrl di sesi

                // Tentukan peran pengguna berdasarkan RoleId
                $role = ($user['RoleId'] == '1') ? 'Admin' : (($user['RoleId'] == '2') ? 'Kasir' : 'Pengguna');

                // Set pesan sukses dengan username dan peran
                $_SESSION['success'] = "{$user['Username']} berhasil login sebagai {$role}!";

                // Tentukan URL pengalihan berdasarkan RoleId
                $_SESSION['redirect_url'] = ($user['RoleId'] == '1') ? '/admin/dashboard' : '/admin/order';

                // Redirect ke halaman yang sesuai
                header('Location: ' . BASEURL . '/auth/loginAdmin');
                exit;
            } else {
                $_SESSION['error'] = "Password salah!";
                header('Location: ' . BASEURL . '/auth/loginAdmin');
                exit;
            }
        } else {
            $_SESSION['error'] = "Email tidak ditemukan!";
            header('Location: ' . BASEURL . '/auth/loginAdmin');
            exit;
        }
    }

    public function logout()
    {
        session_destroy();
        header('Location: ' . BASEURL . '/auth/login');
        exit();
    }
}
