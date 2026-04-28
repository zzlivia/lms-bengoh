document.addEventListener("DOMContentLoaded", function () {
    // --- Alert Logic ---
    setTimeout(function () {
        let alert = document.getElementById('alertBox');
        if (alert) {
            alert.classList.remove('show');
            alert.classList.add('hide');
            setTimeout(() => alert.remove(), 500);
        }
    }, 3000);

    // --- Progress Tracking Logic ---
    const mcqButton = document.getElementById('toMcqBtn');
    // Use a fallback to get the Lecture ID if dataset isn't set
    const lectID = document.body.dataset.lectureId || document.getElementById('currentLectID')?.value;

    function saveAndRedirect(targetUrl) {
        fetch(`/mark-complete/${lectID}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log("Progress saved.");
            // NOW redirect because we know the DB is ready
            window.location.href = targetUrl;
        })
        .catch(error => {
            console.error('Error saving progress:', error);
            // Redirect anyway so the user isn't stuck, 
            // though the PHP check might still fail if DB didn't update
            window.location.href = targetUrl;
        });
    }

    if (mcqButton) {
        mcqButton.addEventListener('click', function(event) {
            // 1. Stop the browser from following the link immediately
            event.preventDefault();
            
            // 2. Get the URL from the button's href attribute
            const targetUrl = this.getAttribute('href');
            
            // 3. Save to DB first, then move to next page
            saveAndRedirect(targetUrl);
        });
    }

    // --- Hook for your Timer ---
    // If you have a timer function elsewhere, call saveAndRedirect(null) 
    // when it reaches 0:00 just to sync the DB in the background.
});