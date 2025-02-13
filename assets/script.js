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
