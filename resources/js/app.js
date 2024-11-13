require('./bootstrap');

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.delete-movie').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const movieTitle = this.getAttribute('data-movie-title');
            if (confirm(`"${movieTitle}" を削除してもよろしいですか？`)) {
                this.closest('form').submit();
            }
        });
    });
});

document.addEventListener('DOMContentLoaded', (event) => {
    const form = document.querySelector('form');
    const radios = form.querySelectorAll('input[type="radio"]');

    radios.forEach(radio => {
        radio.addEventListener('change', () => {
            form.submit();
        });
    });
});