<?php
// منع الدخول المباشر للملف وسماح فقط بطلب POST من الموقع متاحك
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('HTTP/1.1 403 Forbidden');
    exit('Access Denied');
}


$raw_json = file_get_contents('php://input');

// نتأكدو إنو الـ سورس موش فارغ
if (empty($raw_json)) {
    header('HTTP/1.1 400 Bad Request');
    exit('Invalid Data');
}

// الـ Webhook متاحكم (مخفي تماماً في السيرفر)
$webhook_url = 'https://canary.discord.com/api/webhooks/1514748698918260919/MQ00J75z635Xo6UFn3YOARzHyYjf2f4TTQ5UjAv9wLIRiV2G9aONEprhQs75jaJjav5D';

// إرسال البيانات إلى ديسكورد عبر cURL
$ch = curl_init($webhook_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
curl_setopt($ch, CURLOPT_POSTFIELDS, $raw_json); 


curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);


if ($http_code >= 200 && $http_code < 300) {
    header('Content-Type: application/json');
    echo json_encode(['status' => 'success']);
} else {
    header('HTTP/1.1 500 Internal Server Error');
    echo json_encode(['status' => 'error', 'discord_response' => $response]);
}
?>
