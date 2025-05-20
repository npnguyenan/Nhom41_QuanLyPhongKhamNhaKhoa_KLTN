
<?php
// Lấy message từ người dùng
$userMessage = $_POST['message'] ?? '';

// API KEY của bạn từ OpenRouter
$apiKey = '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';  

// Gửi đến model (ví dụ: `mistralai/mistral-7b-instruct`)
$data = [
    "model" => "mistralai/mistral-7b-instruct",
    "messages" => [
        ["role" => "system", "content" => "Bạn là trợ lý nha khoa thân thiện."],
        ["role" => "user", "content" => $userMessage]
    ]
];

// Gọi API
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://openrouter.ai/api/v1/chat/completions");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Authorization: Bearer $apiKey",
    "HTTP-Referer: http://localhost", // thay bằng domain thật nếu có
    "X-Title: NhaKhoaChatBot"
]);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

$response = curl_exec($ch);
curl_close($ch);

// Hiển thị nội dung
$json = json_decode($response, true);
echo $json['choices'][0]['message']['content'] ?? 'Xin lỗi, tôi chưa hiểu câu hỏi của bạn.';
?>
