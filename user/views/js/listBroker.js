 function toggleMoreOptions(button) {
        const moreOptions = button.previousElementSibling;
        const showText = button.querySelector('.show-text');
        const hideText = button.querySelector('.hide-text');
        const icon = button.querySelector('i');

        if (moreOptions.style.display === 'none') {
            moreOptions.style.display = 'block';
            showText.style.display = 'none';
            hideText.style.display = 'inline';
            button.classList.add('expanded');
        } else {
            moreOptions.style.display = 'none';
            showText.style.display = 'inline';
            hideText.style.display = 'none';
            button.classList.remove('expanded');
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const moreOptions = document.querySelector('.more-options');
        if (moreOptions) {
            const checkedHidden = moreOptions.querySelectorAll('input[type="checkbox"]:checked');
            if (checkedHidden.length > 0) {
                const showMoreBtn = moreOptions.nextElementSibling;
                if (showMoreBtn && showMoreBtn.classList.contains('show-more-btn')) {
                    toggleMoreOptions(showMoreBtn);
                }
            }
        }
    });