<?php
/*
Plugin Name: AI Blog Writer
Plugin URI: https://github.com/zinkxx/ai-blog-writer
Description: OpenAI destekli blog yazı üretici eklentisi. SEO uyumlu başlık, meta açıklama ve içerik oluşturur.
Version: 1.1.0
Author: DevTechnic
Author URI: https://devtechnic.online
License: MIT
*/

if (!defined('ABSPATH')) {
    exit; // Doğrudan erişimi engelle
}

// Gerekli dosyaları dahil et
require_once plugin_dir_path(__FILE__) . 'includes/ai-api.php';
require_once plugin_dir_path(__FILE__) . 'includes/seo-optimizer.php';
require_once plugin_dir_path(__FILE__) . 'includes/logger.php';
require_once plugin_dir_path(__FILE__) . 'includes/settings.php'; // Yeni ayarlar sayfası

// Admin panel menüsünü ekle
function ai_blog_writer_menu() {
    add_menu_page(
        'AI Blog Writer',
        'AI Blog Writer',
        'manage_options',
        'ai-blog-writer',
        'ai_blog_writer_admin_page',
        'dashicons-edit',
        20
    );
    add_submenu_page(
        'ai-blog-writer',
        'Ayarlar',
        'Ayarlar',
        'manage_options',
        'ai-blog-writer-settings',
        'ai_blog_writer_settings_page'
    );
}
add_action('admin_menu', 'ai_blog_writer_menu');

// Admin panel sayfası
function ai_blog_writer_admin_page() {
    include plugin_dir_path(__FILE__) . 'templates/admin-page.php';
}

// Ayarlar sayfası
function ai_blog_writer_settings_page() {
    include plugin_dir_path(__FILE__) . 'templates/settings-page.php';
}

// AJAX içerik üretme işlemi
add_action('wp_ajax_generate_ai_content', 'generate_ai_content');
function generate_ai_content() {
    $content = isset($_POST['content']) ? sanitize_text_field($_POST['content']) : '';
    
    if (empty($content)) {
        wp_send_json_error(['message' => 'İçerik boş olamaz.']);
    }
    
    $ai_api = new AI_API('YOUR_OPENAI_API_KEY');
    $seo_optimizer = new AI_SEO_Optimizer('YOUR_OPENAI_API_KEY');
    
    $generated_text = $ai_api->generate_text($content);
    $seo_title = $seo_optimizer->generate_title($generated_text);
    $seo_description = $seo_optimizer->generate_meta_description($generated_text);
    $seo_keywords = $seo_optimizer->generate_keywords($generated_text);
    
    AI_Logger::log("Yeni içerik üretildi: $generated_text");
    
    wp_send_json_success([
        'content' => $generated_text,
        'title' => $seo_title,
        'description' => $seo_description,
        'keywords' => $seo_keywords
    ]);
}

// includes/logger.php
class AI_Logger {
    public static function log($message) {
        $log_file = plugin_dir_path(__FILE__) . '../logs/ai-writer.log';
        $log_message = date('Y-m-d H:i:s') . " - " . $message . "\n";
        file_put_contents($log_file, $log_message, FILE_APPEND);
    }
}

// assets/script.js
document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('generate-content-btn').addEventListener('click', function () {
        let content = document.getElementById('content-input').value;
        let data = new FormData();
        data.append('action', 'generate_ai_content');
        data.append('content', content);
        
        fetch(ajaxurl, {
            method: 'POST',
            body: data
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('generated-content').innerText = data.data.content;
            document.getElementById('seo-title').innerText = data.data.title;
            document.getElementById('seo-description').innerText = data.data.description;
            document.getElementById('seo-keywords').innerText = data.data.keywords;
            console.log('AI içerik üretildi:', data);
        });
    });
});
