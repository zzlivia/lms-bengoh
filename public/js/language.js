let selectedLang = localStorage.getItem('lang') || 'en-US';
let selectedLangLabel = localStorage.getItem('langLabel') || 'English';

function setLanguage(lang, label) {
    selectedLang = lang;
    selectedLangLabel = label;

    localStorage.setItem('lang', lang);
    localStorage.setItem('langLabel', label);

    updateLanguageUI();
}

function updateLanguageUI() {
    const langDisplay = document.getElementById("currentLang");
    if (langDisplay) {
        langDisplay.innerText = selectedLangLabel;
    }
}

function speakQuestion() {
    const text = document.getElementById("questionText")?.innerText;

    if (!text) return;

    const speech = new SpeechSynthesisUtterance(text);
    speech.lang = localStorage.getItem('lang') || 'en-US';

    window.speechSynthesis.cancel();
    window.speechSynthesis.speak(speech);
}

document.addEventListener("DOMContentLoaded", function () {
    updateLanguageUI();
});