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