<?php
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $to = "info@reaktiv-kuhl.de";
    $subject = "Neue Terminanfrage über die Website";
    
    $name = htmlspecialchars($_POST['name'] ?? '');
    $kontakt = htmlspecialchars($_POST['kontakt'] ?? '');
    $nachricht = htmlspecialchars($_POST['nachricht'] ?? '');
    
    if (empty($name) || empty($kontakt) || empty($nachricht)) {
        echo json_encode(["status" => "error", "message" => "Bitte füllen Sie alle Felder aus."]);
        exit;
    }

    $body = "Name: $name\nKontakt: $kontakt\n\nAnliegen:\n$nachricht";
    $headers = "From: noreply@reaktiv-kuhl.de\r\nReply-To: $kontakt";

    if (mail($to, $subject, $body, $headers)) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Mail konnte nicht gesendet werden."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Ungültige Anfrage."]);
}
?>