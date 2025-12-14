<?php
$PAYSTACK_SECRET = "sk_live_xxxxxxxxxxxxxx";

// Read payload
$input = file_get_contents("php://input");
$signature = $_SERVER["HTTP_X_PAYSTACK_SIGNATURE"] ?? "";

if ($signature !== hash_hmac("sha512", $input, $PAYSTACK_SECRET)) {
    http_response_code(401);
    exit("Invalid signature");
}

$data = json_decode($input, true);

if ($data["event"] !== "charge.success") exit("Ignored");

// Payment data
$ref = $data["data"]["reference"];
$amount = $data["data"]["amount"] / 100;
$paidAt = $data["data"]["paid_at"];

// SQLite (Railway)
$db = new SQLite3("payments.db");

$stmt = $db->prepare("
    INSERT OR REPLACE INTO payments
    (reference, amount, status, paid_at)
    VALUES (:ref, :amount, 'success', :paid_at)
");

$stmt->bindValue(":ref", $ref);
$stmt->bindValue(":amount", $amount);
$stmt->bindValue(":paid_at", $paidAt);
$stmt->execute();

http_response_code(200);
echo "OK";
