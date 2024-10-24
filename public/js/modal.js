document.querySelector('.close').addEventListener('click', function() {
    document.getElementById('movie-modal').style.display = 'none';
});

window.addEventListener('click', function(event) {
    const modal = document.getElementById('movie-modal');
    if (event.target === modal) {
        modal.style.display = 'none';
    }
});

document.querySelectorAll('.open-modal-btn').forEach(button => {
    button.addEventListener('click', modalCreator);
});