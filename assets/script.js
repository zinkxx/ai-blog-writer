document.addEventListener("DOMContentLoaded", function() {
    const generateBtn = document.getElementById("generate-ai-content");
    const resultArea = document.getElementById("ai-generated-content");
    const topicInput = document.getElementById("ai-topic");

    generateBtn.addEventListener("click", function() {
        if (!topicInput.value) {
            alert("Lütfen bir konu girin!");
            return;
        }

        generateBtn.innerText = "Oluşturuluyor...";
        generateBtn.disabled = true;

        fetch(ajaxurl, {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `action=generate_ai_content&prompt=${encodeURIComponent(topicInput.value)}`
        })
        .then(response => response.json())
        .then(data => {
            resultArea.value = data.content;
            generateBtn.innerText = "İçerik Üret";
            generateBtn.disabled = false;
        })
        .catch(error => {
            console.error("Hata:", error);
            alert("İçerik üretme sırasında bir hata oluştu.");
            generateBtn.innerText = "İçerik Üret";
            generateBtn.disabled = false;
        });
    });
});
