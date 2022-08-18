const photowisuda = document.getElementById('photo');
    const imagePreview = document.getElementById('image-preview');
    let imageResult = document.querySelector('.image-preview__image')
    const textPreview = imagePreview.querySelector('.image-preview__text');

    photowisuda.addEventListener('change', function() {
        
        const file = this.files[0];

        if (file) {
            const reader = new FileReader();

            textPreview.style.display = 'none';
            imageResult.style.display = 'block';
            imagePreview.style.border = '0'
            reader.addEventListener('load', function() {
                imageResult.setAttribute('src', this.result);
            });

            reader.readAsDataURL(file);
        } else {
            textPreview.style.display = null;
            imageResult.style.display = null;
            imagePreview.style.border = '2px solid #dddddd'

            imageResult.setAttribute('src', '')
        }
    });

    const burger = document.getElementById('burger');
    const sidebar = document.getElementById('sidebar');

    burger.addEventListener('click', () => {
        sidebar.classList.toggle('hidden');
    });

