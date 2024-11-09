<?php

class EmployeeModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database(); // Asumsi Anda punya kelas Database untuk koneksi DB
    }

    public function findUserByResetToken($resetToken)
    {
        $this->db->query('SELECT * FROM employee WHERE ResetToken = :resetToken AND TokenExpiry > NOW()');
        $this->db->bind(':resetToken', $resetToken);
        return $this->db->single();
    }

    public function findUserByEmail($email)
    {
        $this->db->query('SELECT * FROM employee WHERE Email = :email');
        $this->db->bind(':email', $email);
        return $this->db->single();
    }

    public function storeResetToken($email, $resetToken)
    {
        // Query untuk menyimpan token reset
        $this->db->query('UPDATE employee SET ResetToken = :resetToken, TokenExpiry = :expiry WHERE Email = :email');
        $this->db->bind(':resetToken', $resetToken);

        // Set token kadaluarsa (misalnya, 1 jam dari sekarang)
        $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));
        $this->db->bind(':expiry', $expiry);
        $this->db->bind(':email', $email);

        return $this->db->execute();
    }

    public function updatePassword($employeeId, $newPassword)
    {
        $this->db->query('UPDATE employee SET Password = :password, ResetToken = NULL, TokenExpiry = NULL WHERE EmployeeId = :employeeId');
        $this->db->bind(':password', $newPassword);
        $this->db->bind(':employeeId', $employeeId);

        return $this->db->execute();
    }
}
