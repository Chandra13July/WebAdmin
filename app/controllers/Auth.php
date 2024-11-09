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

    public function forgotPasswordAdmin()
    {
        $this->view('layout/header');
        $this->view('auth/forgotPasswordAdmin');
    }

    public function resetPasswordAdmin()
    {
        $this->view('layout/header');
        $this->view('auth/resetPasswordAdmin');
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
                $_SESSION['redirect_url'] = ($user['RoleId'] == '1') ? '/admin/dashboard' : '/admin/order';
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

    // Fungsi untuk mengirim token reset kata sandi
    public function btnForgotPasswordAdmin()
    {
        $email = trim($_POST['email']);

        if (empty($email)) {
            $_SESSION['error'] = "Email harus diisi!";
            header('Location: ' . BASEURL . '/auth/forgotPasswordAdmin');
            exit;
        }

        $user = $this->EmployeeModel->findUserByEmail($email);

        if ($user) {
            // Membuat token reset
            $resetToken = bin2hex(random_bytes(32));
            $this->EmployeeModel->storeResetToken($email, $resetToken);

            // Set notifikasi sukses
            $_SESSION['success'] = "Link reset password telah dikirimkan ke email Anda. Anda akan diarahkan ke form reset password.";
            header('Location: ' . BASEURL . '/auth/forgotPasswordAdmin');
            exit;
        } else {
            $_SESSION['error'] = "Email tidak ditemukan!";
            header('Location: ' . BASEURL . '/auth/forgotPasswordAdmin');
            exit;
        }
    }

    // Fungsi untuk reset kata sandi
    public function btnResetPasswordAdmin()
    {
        if (!isset($_GET['token'])) {
            $_SESSION['error'] = "Token reset tidak ditemukan!";
            header('Location: ' . BASEURL . '/auth/forgotPasswordAdmin');
            exit;
        }

        $resetToken = $_GET['token'];
        $newPassword = $_POST['password'];
        $confirmPassword = $_POST['confirm-password'];

        // Validasi input password
        if (empty($newPassword) || empty($confirmPassword)) {
            $_SESSION['error'] = "Password baru harus diisi!";
            header('Location: ' . BASEURL . '/auth/resetPasswordAdmin');
            exit;
        }

        if ($newPassword !== $confirmPassword) {
            $_SESSION['error'] = "Password baru dan konfirmasi password tidak cocok!";
            header('Location: ' . BASEURL . '/auth/resetPasswordAdmin');
            exit;
        }

        // Validasi token dan reset password
        $user = $this->EmployeeModel->findUserByResetToken($resetToken);

        if ($user) {
            // Update password
            $this->EmployeeModel->updatePassword($user['EmployeeId'], password_hash($newPassword, PASSWORD_DEFAULT));

            // Set notifikasi sukses
            $_SESSION['success'] = "Password Anda berhasil direset. Silakan login.";
            header('Location: ' . BASEURL . '/auth/loginAdmin');
            exit;
        } else {
            $_SESSION['error'] = "Token reset tidak valid!";
            header('Location: ' . BASEURL . '/auth/resetPasswordAdmin');
            exit;
        }
    }
}
