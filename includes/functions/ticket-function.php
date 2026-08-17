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
       -----------------------------------------------------------
       $attachment ay OPTIONAL — relative path lang (hal.
       "attachment/somefile_20260817_..._a1b2c3d4.pdf"), na
       kung saan physically na-store na ang file (hal. C:\xampp\
       htdocs\ticketing\attachment) noong pinoproseso sa
       form-control.php. Kung walang na-upload, null lang.
    ========================================================== */

    public function createTicket(
        string $username,
        string $department,
        string $subject,
        string $description,
        string $priority = 'Low',
        string $status = 'Pending',
        ?string $attachment = null
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
                attachment,
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
                :attachment,
                NOW(),
                NULL
            )
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':username' => $username,
            ':department' => $department,
            ':subject' => $subject,
            ':description' => $description,
            ':priority' => $priority,
            ':status' => $status,
            ':attachment' => $attachment
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
                attachment,
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
                attachment,
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
       -----------------------------------------------------------
       $attachment dito ay OPTIONAL din — kung null ang ipasa,
       hindi galawin/hindi papalitan ang existing attachment
       (COALESCE), kaya hindi mo kailangang laging magpasa ng
       bagong file kada pag-edit ng ticket.
    ========================================================== */

    public function updateTicket(
        int $ticketId,
        string $department,
        string $subject,
        string $description,
        string $priority,
        string $status,
        ?string $resolution = null,
        ?string $attachment = null
    ): bool {
        $sql = "
            UPDATE {$this->table}
            SET
                department = :department,
                subject = :subject,
                description = :description,
                priority = :priority,
                status = :status,
                resolution = :resolution,
                attachment = COALESCE(:attachment, attachment)
            WHERE ticket_id = :ticket_id
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':department' => $department,
            ':subject' => $subject,
            ':description' => $description,
            ':priority' => $priority,
            ':status' => $status,
            ':resolution' => $resolution,
            ':attachment' => $attachment,
            ':ticket_id' => $ticketId
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

    public function updateStatus(int $ticketId, string $status): bool
    {
        $sql = "
            UPDATE {$this->table}
            SET status = :status
            WHERE ticket_id = :ticket_id
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':status' => $status,
            ':ticket_id' => $ticketId
        ]);
    }

    /* =========================================================
       RESOLVE TICKET
       -----------------------------------------------------------
       $priority ay OPTIONAL — kapag may pinili ang admin sa
       priority dropdown (Low/Medium/Critical) bago mag-submit ng
       response, sabay itong nag-uupdate sa priority column.
       Kung null/wala, hindi ginagalaw ang existing priority.
    ========================================================== */

    public function resolveTicket(int $ticketId, string $resolution, ?string $priority = null): bool
    {
        if ($priority !== null && $priority !== '') {

            $sql = "
                UPDATE {$this->table}
                SET
                    status = 'Resolved',
                    resolution = :resolution,
                    priority = :priority,
                    resolve_at = NOW()
                WHERE ticket_id = :ticket_id
            ";

            $stmt = $this->db->prepare($sql);

            return $stmt->execute([
                ':resolution' => $resolution,
                ':priority'   => $priority,
                ':ticket_id'  => $ticketId
            ]);
        }

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
            ':ticket_id' => $ticketId
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
                attachment,
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
                attachment,
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

    /* =========================================================
       GET RESOLVED TICKETS BY DATE RANGE AND SORT
       -------------------------------------------------------
       Date filter and sorting are both based on resolve_at.
       oldest = ASC
       latest = DESC
    ========================================================== */

    public function getResolvedTicketsByDateRange(
        string $from,
        string $to,
        string $sort = 'latest'
    ): array {
        $order = $sort === 'oldest' ? 'ASC' : 'DESC';

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
                attachment,
                created_at,
                resolve_at
            FROM {$this->table}
            WHERE status = 'Resolved'
              AND resolve_at IS NOT NULL
              AND resolve_at >= :date_from
              AND resolve_at < DATE_ADD(:date_to, INTERVAL 1 DAY)
            ORDER BY resolve_at {$order}
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':date_from' => $from . ' 00:00:00',
            ':date_to' => $to
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}