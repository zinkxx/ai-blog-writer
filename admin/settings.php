<?php
if (!defined('ABSPATH')) exit;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['api_key'])) {
    update_option('ai_blog_api_key', sanitize_text_field($_POST['api_key']));
    echo "<div class='updated'><p>API Anahtarı Kaydedildi!</p></div>";
}
?>

<div class="wrap">
    <h2>AI Blog Writer Ayarları</h2>
    <form method="post">
        <label for="api_key">OpenAI API Anahtarı:</label>
        <input type="text" name="api_key" value="<?php echo get_option('ai_blog_api_key'); ?>" style="width: 100%;">
        <button type="submit" class="button button-primary">Kaydet</button>
    </form>
</div>
