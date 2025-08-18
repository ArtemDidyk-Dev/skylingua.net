document.addEventListener('DOMContentLoaded', function() {
    let projectAddFavoriteButtons = document.querySelectorAll('.projectAddFavorite');
    projectAddFavoriteButtons.forEach(function(button) {
        button.addEventListener('click', function(event) {
            event.preventDefault();

            if (button.classList.contains('favourited')) {
                button.classList.remove('favourited');
            } else {
                button.classList.add('favourited');
            }
            let freelancer_id = button.getAttribute('data-project_id');
            fetch('{{ route('frontend.ajax_add_freelancer_favourites') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        employer_id: {{ auth()->id() }},
                        freelancer_id: freelancer_id,
                    }),
                })
                .then(response => response.json())
        });
    });
});