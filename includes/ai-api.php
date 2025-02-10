<?php
if (!defined('ABSPATH')) exit;

function generate_ai_content($prompt, $max_tokens = 500) {
    $api_key = get_option('ai_blog_api_key');
    if (!$api_key) return "API Anahtarı Eksik!";

    $url = "https://api.openai.com/v1/completions";
    $headers = [
        "Authorization: Bearer $api_key",
        "Content-Type: application/json"
    ];

    $data = [
        "model" => "gpt-4",
        "prompt" => $prompt,
        "max_tokens" => $max_tokens,
        "temperature" => 0.7
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true)['choices'][0]['text'] ?? "Hata oluştu!";
}
?>
