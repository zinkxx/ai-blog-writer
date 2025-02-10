<?php
if (!defined('ABSPATH')) exit;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['content'])) {
    $new_post = [
        'post_title' => sanitize_text_field($_POST['title']),
        'post_content' => wp_kses_post($_POST['content']),
        'post_status' => 'publish',
        'post_author' => get_current_user_id()
    ];
    wp_insert_post($new_post);
    echo "<div class='updated'><p>Makale başarıyla yayınlandı!</p></div>";
}
?>

<div class="wrap">
    <h2>AI Blog Yazı Editörü</h2>
    <form method="post">
        <label>Başlık:</label>
        <input type="text" name="title" required style="width: 100%;">

        <label>İçerik:</label>
        <textarea name="content" rows="10" style="width: 100%;"><?php echo generate_ai_content("WordPress için en iyi SEO ipuçları", 700); ?></textarea>

        <button type="submit" class="button button-primary">Yayınla</button>
    </form>
</div>
