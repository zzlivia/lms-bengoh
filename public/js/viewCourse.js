document.addEventListener("DOMContentLoaded", function () {
    setTimeout(function () {
        let alert = document.getElementById('alertBox');
        if (alert) {
            alert.classList.remove('show'); // fade out
            alert.classList.add('hide');

            setTimeout(() => alert.remove(), 500);
        }
    }, 3000);
});