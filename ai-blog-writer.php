<?php
/**
 * Plugin Name: AI Blog Writer
 * Plugin URI:  https://devtechnic.online
 * Description: Yapay zeka destekli otomatik blog yazı üretici eklentisi.
 * Version: 1.0
 * Author: Zinkx
 * Author URI: https://github.com/zinkxx
 */

if (!defined('ABSPATH')) exit;

// Admin menü ekleme
function ai_blog_writer_menu() {
    add_menu_page(
        'AI Blog Writer', 
        'AI Blog Writer', 
        'manage_options', 
        'ai-blog-writer', 
        'ai_blog_writer_admin_page', 
        'dashicons-edit', 
        25
    );
}
add_action('admin_menu', 'ai_blog_writer_menu');

function ai_blog_writer_admin_page() {
    include plugin_dir_path(__FILE__) . 'admin/settings.php';
}
