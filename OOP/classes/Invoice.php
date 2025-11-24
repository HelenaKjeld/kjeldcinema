<?php
require_once __DIR__ . '/BaseModel.php';


class Invoice extends BaseModel
{
    protected $table = 'invoice';
    protected $invoiceKey = 'InvoiceID';


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
            ':Status' => 'pending',
            ':BilledEmail' => $billedEmail
        ]);

        $sql = "
            INSERT INTO invoice (InvoiceNumber, TicketID, FullAmount, Status, DueDate, BilledEmail)
            VALUES (?, ?, ?, 'pending', ?, ?)
        ";

        $ok = $stmt->execute();
        $invoiceId = $stmt->insert_id;
        $stmt->close();

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
}
