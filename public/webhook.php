<?php
require "../core/db.php";

$secret = $_ENV['PAYSTACK_SECRET'];

$payload = file_get_contents("php://input");
$signature = $_SERVER['HTTP_X_PAYSTACK_SIGNATURE'] ?? '';

if ($signature !== hash_hmac("sha512", $payload, $secret)) {
    http_response_code(401);
    exit;
}

$data = json_decode($payload, true);
if ($data['event'] !== 'charge.success') exit;

$ref = $data['data']['reference'];
$amount = $data['data']['amount'] / 100;
$paidAt = $data['data']['paid_at'];

$stmt = $DB->prepare("
INSERT INTO payments (reference, amount, status, paid_at)
VALUES (:r, :a, 'success', :p)
ON CONFLICT (reference)
DO UPDATE SET status='success', paid_at=:p
");

$stmt->execute([
    ":r" => $ref,
    ":a" => $amount,
    ":p" => $paidAt
]);

http_response_code(200);
echo "OK";
