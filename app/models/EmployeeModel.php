<?php

class EmployeeModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database(); // Assuming you have a Database class for DB connection
    }

    public function findUserByEmail($email)
    {
        $this->db->query('SELECT * FROM employee WHERE Email = :email');
        $this->db->bind(':email', $email);
        return $this->db->single();
    }
}
?>
