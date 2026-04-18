let selectedLang = localStorage.getItem("lang") || "en-US";
let selectedLangLabel = localStorage.getItem("langLabel") || "English";
let voices = [];

function loadVoices() {
    voices = speechSynthesis.getVoices();
}

speechSynthesis.onvoiceschanged = loadVoices;

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

function speakQuestion(index) {
    const text = document.getElementById("questionText" + index)?.innerText;

    if (!text) return;

    const speech = new SpeechSynthesisUtterance(text);
    speech.lang = localStorage.getItem('lang') || 'en-US';

    //assign correct voice
    const selectedVoice = voices.find(v => v.lang === speech.lang);
    if (selectedVoice) {
        speech.voice = selectedVoice;
    }

    window.speechSynthesis.cancel();
    window.speechSynthesis.speak(speech);
}

document.addEventListener("DOMContentLoaded", function () {
    updateLanguageUI();
});