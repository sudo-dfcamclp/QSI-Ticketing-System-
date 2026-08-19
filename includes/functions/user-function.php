
<?php

require_once __DIR__ . '/../config/config.php';

class Users
{
    private PDO $db;
    private string $table = 'users';

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    | Create a new user. Defaults to user_type "admin" and status
    | "pending" (self-registration, e.g. register.php) — pag super_admin
    | ang gumawa ng account (Add User sa Manage Users), "active" agad
    | ang ipinapasa dito mula sa control file.
    */
    public function create(
        string $f_name,
        string $l_name,
        string $username,
        string $gmail,
        string $password,
        string $user_type = 'admin',
        string $status = 'pending'
    ): bool {
        $sql = "INSERT INTO {$this->table}
                (f_name, l_name, username, gmail, password, user_type, status)
                VALUES
                (:f_name, :l_name, :username, :gmail, :password, :user_type, :status)";

        $stmt = $this->db->prepare($sql);

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        return $stmt->execute([
            ':f_name'    => $f_name,
            ':l_name'    => $l_name,
            ':username'  => $username,
            ':gmail'     => $gmail,
            ':password'  => $passwordHash,
            ':user_type' => $user_type,
            ':status'    => $status
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | READ - ALL USERS
    |--------------------------------------------------------------------------
    */
    public function getAll(): array
    {
        $sql = "SELECT
                    user_id,
                    f_name,
                    l_name,
                    username,
                    gmail,
                    user_type,
                    status,
                    created_at
                FROM {$this->table}
                ORDER BY user_id DESC";

        $stmt = $this->db->query($sql);

        return $stmt->fetchAll();
    }

    /*
    |--------------------------------------------------------------------------
    | READ - SINGLE USER
    |--------------------------------------------------------------------------
    */
    public function getById(int $user_id): ?array
    {
        $sql = "SELECT
                    user_id,
                    f_name,
                    l_name,
                    username,
                    gmail,
                    user_type,
                    status,
                    created_at
                FROM {$this->table}
                WHERE user_id = :user_id
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':user_id' => $user_id
        ]);

        $user = $stmt->fetch();

        return $user ?: null;
    }

    /*
    |--------------------------------------------------------------------------
    | READ - BY USERNAME
    |--------------------------------------------------------------------------
    */
    public function getByUsername(string $username): ?array
    {
        $sql = "SELECT
                    user_id,
                    f_name,
                    l_name,
                    username,
                    gmail,
                    password,
                    user_type,
                    status,
                    created_at
                FROM {$this->table}
                WHERE username = :username
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':username' => $username
        ]);

        $user = $stmt->fetch();

        return $user ?: null;
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    | Update user information.
    | Password is optional. If empty, the existing password remains unchanged.
    */
    public function update(
        int $user_id,
        string $f_name,
        string $l_name,
        string $username,
        string $gmail,
        ?string $password = null
    ): bool {

        if ($password !== null && $password !== '') {

            $sql = "UPDATE {$this->table}
                    SET
                        f_name = :f_name,
                        l_name = :l_name,
                        username = :username,
                        gmail = :gmail,
                        password = :password
                    WHERE user_id = :user_id";

            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            $params = [
                ':f_name'   => $f_name,
                ':l_name'   => $l_name,
                ':username' => $username,
                ':gmail'    => $gmail,
                ':password' => $passwordHash,
                ':user_id'  => $user_id
            ];

        } else {

            $sql = "UPDATE {$this->table}
                    SET
                        f_name = :f_name,
                        l_name = :l_name,
                        username = :username,
                        gmail = :gmail
                    WHERE user_id = :user_id";

            $params = [
                ':f_name'   => $f_name,
                ':l_name'   => $l_name,
                ':username' => $username,
                ':gmail'    => $gmail,
                ':user_id'  => $user_id
            ];
        }

        $stmt = $this->db->prepare($sql);

        return $stmt->execute($params);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE STATUS
    |--------------------------------------------------------------------------
    | Ginagamit ng Enable/Disable na dropdown action sa Manage Users.
    | Allowed values lang: pending, active, disable.
    */
    public function updateStatus(int $user_id, string $status): bool
    {
        $allowed = ['pending', 'active', 'disable'];

        if (!in_array($status, $allowed, true)) {
            return false;
        }

        $sql = "UPDATE {$this->table}
                SET status = :status
                WHERE user_id = :user_id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':status'  => $status,
            ':user_id' => $user_id
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */
    public function delete(int $user_id): bool
    {
        $sql = "DELETE FROM {$this->table}
                WHERE user_id = :user_id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':user_id' => $user_id
        ]);
    }
}


/*
|--------------------------------------------------------------------------
| CREATE USERS OBJECT
|--------------------------------------------------------------------------
*/

$users = new Users($db);

