document.addEventListener("DOMContentLoaded", function () {
    //Existing Alert Logic
    setTimeout(function () {
        let alert = document.getElementById('alertBox');
        if (alert) {
            alert.classList.remove('show');
            alert.classList.add('hide');
            setTimeout(() => alert.remove(), 500);
        }
    }, 3000);

    //Progress Tracking Logic
    //"To MCQ Questions" button or the timer itself
    const mcqButton = document.getElementById('toMcqBtn'); // Add this ID to your HTML button
    const lectID = document.body.dataset.lectureId; // Best way: put id in <body data-lecture-id="{{$current->lectID}}">

    function saveProgress() {
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
            if (data.status === 'saved') {
                console.log("Lecture progress saved to database.");
                // Now that it's saved, the popup won't appear when they click
            }
        })
        .catch(error => console.error('Error:', error));
    }

    // Trigger saveProgress when the timer hits 0:00 (Hook this into your existing timer)
    // For now, let's also trigger it when they click the MCQ button just in case
    if (mcqButton) {
        mcqButton.addEventListener('click', function() {
             saveProgress(); 
        });
    }
});