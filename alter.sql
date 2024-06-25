DELIMITER //

CREATE FUNCTION TotalInvoiced(client_id INT) RETURNS DECIMAL(10, 2)
BEGIN
    DECLARE total DECIMAL(10, 2);
    SELECT IFNULL(SUM(amount), 0) INTO total
    FROM invoices
    WHERE client_id = client_id;
    RETURN total;
END //

CREATE FUNCTION TotalPaid(client_id INT) RETURNS DECIMAL(10, 2)
BEGIN
    DECLARE total DECIMAL(10, 2);
    SELECT IFNULL(SUM(r.amount_paid), 0) INTO total
    FROM invoices i
    JOIN receipts r ON i.invoice_id = r.invoice_id
    WHERE i.client_id = client_id;
    RETURN total;
END //

CREATE FUNCTION BalanceDue(client_id INT) RETURNS DECIMAL(10, 2)
BEGIN
    RETURN TotalInvoiced(client_id) - TotalPaid(client_id);
END //

DELIMITER ;



DELIMITER //

CREATE PROCEDURE GetClientSummary()
BEGIN
    SELECT 
        c.client_id,
        c.client_name,
        TotalInvoiced(c.client_id) AS total_invoiced,
        TotalPaid(c.client_id) AS total_paid,
        BalanceDue(c.client_id) AS balance_due
    FROM 
        clients c;
END //

DELIMITER ;