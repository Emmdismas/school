// public/js/scripts.js
document.addEventListener('DOMContentLoaded', function () {
    const photoInput = document.querySelector('input[name="photo"]');
    const photoPreview = document.createElement('img');
    photoPreview.style.display = 'none';
    photoPreview.style.maxWidth = '150px';
    document.body.appendChild(photoPreview);

    photoInput.addEventListener('change', function () {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (event) {
                photoPreview.src = event.target.result;
                photoPreview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });
});

// public/js/scripts.js (Add to the previous script)
document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');
    const photoInput = document.querySelector('input[name="photo"]');

    form.addEventListener('submit', function (event) {
        const file = photoInput.files[0];

        if (file && file.size > 2 * 1024 * 1024) { // 2MB limit
            alert('The photo size must not exceed 2MB.');
            event.preventDefault(); // Prevent form submission
        }
    });
});
