<?php
// Na9raw el data lli jaya mel JavaScript
$content = json_decode(file_get_contents('php://input'), true);

if (isset($content['user']) && isset($content['text'])) {
    
    // T7OTT EL WEBHOOK REAL MTE3EK HNA BARK !
    $webhookurl = "https://discord.com/api/webhooks/YOUR_REAL_WEBHOOK_HERE";

    // Nzayno el msg lli bech yemshi l-Discord
    $msg_discord = "**Esm el client:** " . $content['user'] . "\n**El Message:** " . $content['text'];

    $json_data = json_encode([
        "content" => $msg_discord,
        "username" => "Bot Site Sécurisé"
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

    // Envoi l-Discord via cURL
    $ch = curl_init($webhookurl);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    curl_exec($ch);
    curl_close($ch);
    
    // Nraj3o lil JavaScript ennu el 5edma mshét mrigla
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => "Données incomplètes"]);
}
?>
