document.addEventListener("DOMContentLoaded", function () {

    /* tab switch process */
    const urlParams = new URLSearchParams(window.location.search);
    const tabTarget = urlParams.get('tab');

    const tabMap = {
        'course': '#course-tab',
        'module': '#module-tab',
        'lecture': '#lecture-tab',
        'section': '#section-tab',
        'mcq': '#mcq-tab'
    };

    if (tabTarget && tabMap[tabTarget]) {
        let triggerEl = document.querySelector(tabMap[tabTarget]);
        if (triggerEl) {
            new bootstrap.Tab(triggerEl).show();
        }
    }

    /* file preview */
    const fileInput = document.querySelector('input[name="section_file"]');

    if (fileInput) {
        fileInput.addEventListener("change", function () {
            const file = this.files[0];
            if (!file) return;

            const url = URL.createObjectURL(file);
            const previewContent = document.getElementById("previewContent");

            if (!previewContent) return;

            if (file.type.startsWith("image")) {
                previewContent.innerHTML = `<img src="${url}" style="max-width:300px;">`;
            }

            if (file.type === "application/pdf") {
                previewContent.innerHTML = `<iframe src="${url}" width="100%" height="300"></iframe>`;
            }
        });
    }

    /* view section modal */
    document.querySelectorAll('.viewSectionBtn').forEach(button => {
        button.addEventListener('click', function () {

            let title = this.getAttribute('data-title');
            let content = this.getAttribute('data-content');

            document.getElementById('viewTitle').innerText = title;
            document.getElementById('viewContent').innerHTML = content;

            let modal = new bootstrap.Modal(document.getElementById('viewSectionModal'));
            modal.show();
        });
    });

    /* edit section modal */
    document.querySelectorAll('.editSectionBtn').forEach(button => {
        button.addEventListener('click', function () {

            let id = this.getAttribute('data-id');
            let title = this.getAttribute('data-title');
            let content = this.getAttribute('data-content');
            let type = this.getAttribute('data-type');

            document.getElementById('editTitle').value = title;
            document.getElementById('editContent').value = content;
            document.getElementById('editType').value = type;

            document.getElementById('editSectionForm').action =
                `/admin/section/update/${id}`;

            let modal = new bootstrap.Modal(document.getElementById('editSectionModal'));
            modal.show();
        });
    });

});


/* add mcq questions */
let questionIndex = 1;

function addQuestion() {

    let container = document.getElementById('questions-container');

    let html = `
    <div class="question-block border p-3 mb-3 rounded position-relative">

        <!-- DELETE BUTTON -->
        <button type="button" 
                class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2"
                onclick="this.parentElement.remove()">
            ❌
        </button>

        <label>Question</label>
        <input type="text" name="questions[${questionIndex}][text]" class="form-control mb-2" required>

        ${[1,2,3,4].map((num) => `
            <input type="text" 
                name="questions[${questionIndex}][answers][]" 
                class="form-control mb-2" 
                placeholder="Answer ${num}" required>
        `).join('')}

        <label>Correct Answer</label>
        <select name="questions[${questionIndex}][correct]" class="form-control">
            <option value="0">Answer 1</option>
            <option value="1">Answer 2</option>
            <option value="2">Answer 3</option>
            <option value="3">Answer 4</option>
        </select>

    </div>
    `;

    container.insertAdjacentHTML('beforeend', html);
    questionIndex++;
}