<?php
require_once __DIR__ . '/../config/config.php';

class Ticket
{
    private PDO $db;
    private string $table = 'ticket';

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }


    /* =========================================================
       CREATE TICKET
    ========================================================== */

    public function createTicket(
        string $username,
        string $department,
        string $subject,
        string $description,
        string $priority = 'Normal',
        string $status = 'Pending'
    ): bool {
        $sql = "
            INSERT INTO {$this->table}
            (
                username,
                department,
                subject,
                description,
                priority,
                status,
                resolution,
                created_at,
                resolve_at
            )
            VALUES
            (
                :username,
                :department,
                :subject,
                :description,
                :priority,
                :status,
                NULL,
                NOW(),
                NULL
            )
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':username'    => $username,
            ':department'  => $department,
            ':subject'     => $subject,
            ':description' => $description,
            ':priority'    => $priority,
            ':status'      => $status
        ]);
    }


    /* =========================================================
       GET ALL TICKETS
    ========================================================== */

    public function getAllTickets(): array
    {
        $sql = "
            SELECT
                ticket_id,
                username,
                department,
                subject,
                description,
                priority,
                status,
                resolution,
                created_at,
                resolve_at
            FROM {$this->table}
            ORDER BY created_at DESC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    /* =========================================================
       GET TICKET BY ID
    ========================================================== */

    public function getTicketById(int $ticketId): ?array
    {
        $sql = "
            SELECT
                ticket_id,
                username,
                department,
                subject,
                description,
                priority,
                status,
                resolution,
                created_at,
                resolve_at
            FROM {$this->table}
            WHERE ticket_id = :ticket_id
            LIMIT 1
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':ticket_id' => $ticketId
        ]);

        $ticket = $stmt->fetch(PDO::FETCH_ASSOC);

        return $ticket ?: null;
    }


    /* =========================================================
       UPDATE TICKET
    ========================================================== */

    public function updateTicket(
        int $ticketId,
        string $department,
        string $subject,
        string $description,
        string $priority,
        string $status,
        ?string $resolution = null
    ): bool {
        $sql = "
            UPDATE {$this->table}
            SET
                department = :department,
                subject = :subject,
                description = :description,
                priority = :priority,
                status = :status,
                resolution = :resolution
            WHERE ticket_id = :ticket_id
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':department'  => $department,
            ':subject'     => $subject,
            ':description' => $description,
            ':priority'    => $priority,
            ':status'      => $status,
            ':resolution'  => $resolution,
            ':ticket_id'   => $ticketId
        ]);
    }


    /* =========================================================
       DELETE TICKET
    ========================================================== */

    public function deleteTicket(int $ticketId): bool
    {
        $sql = "
            DELETE FROM {$this->table}
            WHERE ticket_id = :ticket_id
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':ticket_id' => $ticketId
        ]);
    }


    /* =========================================================
       UPDATE STATUS
    ========================================================== */

    public function updateStatus(
        int $ticketId,
        string $status
    ): bool {
        $sql = "
            UPDATE {$this->table}
            SET status = :status
            WHERE ticket_id = :ticket_id
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':status'    => $status,
            ':ticket_id' => $ticketId
        ]);
    }


    /* =========================================================
       RESOLVE TICKET
    ========================================================== */

    public function resolveTicket(
        int $ticketId,
        string $resolution
    ): bool {
        $sql = "
            UPDATE {$this->table}
            SET
                status = 'Resolved',
                resolution = :resolution,
                resolve_at = NOW()
            WHERE ticket_id = :ticket_id
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':resolution' => $resolution,
            ':ticket_id'  => $ticketId
        ]);
    }


    /* =========================================================
       COUNT ALL TICKETS
    ========================================================== */

    public function countTickets(): int
    {
        $sql = "
            SELECT COUNT(*)
            FROM {$this->table}
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return (int) $stmt->fetchColumn();
    }


    /* =========================================================
       COUNT BY STATUS
    ========================================================== */

    public function countByStatus(string $status): int
    {
        $sql = "
            SELECT COUNT(*)
            FROM {$this->table}
            WHERE status = :status
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':status' => $status
        ]);

        return (int) $stmt->fetchColumn();
    }


    /* =========================================================
       GET TICKETS BY USERNAME
    ========================================================== */

    public function getTicketsByUsername(string $username): array
    {
        $sql = "
            SELECT
                ticket_id,
                username,
                department,
                subject,
                description,
                priority,
                status,
                resolution,
                created_at,
                resolve_at
            FROM {$this->table}
            WHERE username = :username
            ORDER BY created_at DESC
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':username' => $username
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    /* =========================================================
       GET TICKETS BY STATUS
    ========================================================== */

    public function getTicketsByStatus(string $status): array
    {
        $sql = "
            SELECT
                ticket_id,
                username,
                department,
                subject,
                description,
                priority,
                status,
                resolution,
                created_at,
                resolve_at
            FROM {$this->table}
            WHERE status = :status
            ORDER BY created_at DESC
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':status' => $status
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}