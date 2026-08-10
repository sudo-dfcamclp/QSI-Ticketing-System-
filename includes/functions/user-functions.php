<?php
/* =============================================
   users.php - Reusable FETCH for dbo.USERS
   Connects via your existing db.php ($conn)
   ============================================= */
require_once __DIR__ . '/db.php';

class Users
{
    private $db;
    private $table = 'dbo.USERS';
    private $cols  = 'USER_ID, USERNAME, PASSWORD, ROLE, ACTIVE, LOCKEDOUT';

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAll() // Fetch all users
    {
        $stmt = $this->db->prepare("SELECT {$this->cols} FROM {$this->table} ORDER BY USERNAME");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) // Fetch 1 user by USER_ID
    {
        $stmt = $this->db->prepare("SELECT {$this->cols} FROM {$this->table} WHERE USER_ID = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByUsername($username) // Fetch 1 user by USERNAME
    {
        $stmt = $this->db->prepare("SELECT {$this->cols} FROM {$this->table} WHERE USERNAME = ?");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>