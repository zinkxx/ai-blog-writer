<?php
if (!defined('ABSPATH')) exit;
header("Content-Type: application/json");

require_once plugin_dir_path(__FILE__) . '../includes/ai-api.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['prompt'])) {
    $prompt = sanitize_text_field($_POST['prompt']);
    $response = generate_ai_content($prompt, 700);
    echo json_encode(['content' => trim($response)]);
    exit;
}
?>
