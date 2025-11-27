<?php
require_once __DIR__ . '/BaseModel.php';


class Invoice extends BaseModel
{
    protected $table = 'invoice';
    protected $primaryKey = 'InvoiceID';


    public function generateInvoiceNumber(int $ticketId): string
    {
        $datePart   = date('Ymd');
        $ticketPart = str_pad((string)$ticketId, 4, '0', STR_PAD_LEFT);
        $randPart   = strtoupper(bin2hex(random_bytes(2))); // 4 hex chars

        return "INV-{$datePart}-{$ticketPart}-{$randPart}";
    }

    /**
     * Create an invoice row for a given ticket.
     * Returns the new InvoiceID.
     */
    public function createForTicket(
        int $ticketID,
        float $fullAmount,
        ?string $billedEmail = null
    ): int {
        $invoiceNumber = $this->generateInvoiceNumber($ticketID);

        $sql = "INSERT INTO invoice (InvoiceNumber, TicketID, FullAmount, Status, BilledEmail)
          VALUES (:InvoiceNumber, :TicketID, :FullAmount, :Status, :BilledEmail)";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':InvoiceNumber' => $invoiceNumber,
            ':TicketID' => $ticketID,
            ':FullAmount' =>  $fullAmount,
            ':Status' => 'paid',
            ':BilledEmail' => $billedEmail
        ]);

        $invoiceId = $this->db->lastInsertId();
        return $invoiceId;
    }

    /**
     * Optionally: update FilePath later if you generate a PDF.
     */
    public function setFilePath(int $invoiceId, string $filePath): bool
    {
        $sql = "UPDATE invoice SET FilePath = ? WHERE InvoiceID = ?";
        $stmt = $this->db->prepare($sql);
        if (!$stmt) {
            throw new RuntimeException('Failed to prepare FilePath update: ' . $this->db->error);
        }

        $stmt->bind_param('si', $filePath, $invoiceId);
        $ok = $stmt->execute();
        $stmt->close();

        return $ok;
    }

    public function __destruct()
    {
        if (isset($this->conn)) {
            $this->db->close();
        }
    }


    public function findWithDetails($invoiceId)
{
    $sql = "
        SELECT 
            i.*, 
            m.Titel AS MovieTitle,
            s.Name AS ShowroomName,
            sh.DATE AS ShowingDate,
            sh.Time AS ShowingTime,
            t.TicketID
        FROM invoice i
        LEFT JOIN ticket t ON i.TicketID = t.TicketID
        LEFT JOIN showing sh ON t.ShowingID = sh.ShowingID
        LEFT JOIN movie m ON sh.MovieID = m.MovieID
        LEFT JOIN showroom s ON sh.ShowroomID = s.ShowroomID
        WHERE i.InvoiceID = :invoiceId
        LIMIT 1
    ";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([':invoiceId' => $invoiceId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
}
