const dropZone = document.getElementById('dropZone');
const imageInput = document.getElementById('imageInput');
const preview = document.getElementById('dropPreview');

if (dropZone && imageInput && preview) {
    dropZone.addEventListener('click', () => imageInput.click());
    dropZone.addEventListener('dragover', (event) => {
        event.preventDefault();
        dropZone.classList.add('dragover');
    });
    dropZone.addEventListener('dragleave', () => dropZone.classList.remove('dragover'));
    dropZone.addEventListener('drop', (event) => {
        event.preventDefault();
        dropZone.classList.remove('dragover');
        const file = event.dataTransfer.files[0];
        if (file) {
            showPreview(file);
            setFile(file);
        }
    });
    imageInput.addEventListener('change', () => {
        if (imageInput.files[0]) showPreview(imageInput.files[0]);
    });
}

function showPreview(file) {
    const reader = new FileReader();
    reader.onload = (event) => {
        preview.src = event.target.result;
        preview.style.display = 'block';
    };
    reader.readAsDataURL(file);
}

function setFile(file) {
    const dataTransfer = new DataTransfer();
    dataTransfer.items.add(file);
    imageInput.files = dataTransfer.files;
}
