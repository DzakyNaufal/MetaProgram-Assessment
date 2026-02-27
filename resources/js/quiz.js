// Quiz logic and Chart.js implementation

document.addEventListener('DOMContentLoaded', function() {
    // Handle quiz form submission
    const quizForm = document.getElementById('quiz-form');
    if (quizForm) {
        quizForm.addEventListener('submit', function(e) {
            e.preventDefault();

            // Disable submit button to prevent double submission
            const submitButton = quizForm.querySelector('button[type="submit"]');
            submitButton.disabled = true;
            submitButton.textContent = 'Memproses...';

            // Get form data
            const formData = new FormData(quizForm);

            // Send AJAX request
            fetch(quizForm.getAttribute('action'), {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                // Check if response is ok (status 200-299)
                if (!response.ok) {
                    return response.text().then(text => {
                        throw new Error('Server error: ' + response.status + ' - ' + text);
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Redirect to result page
                    window.location.href = data.redirect_url || document.querySelector('meta[name="app-url"]').getAttribute('content') + '/courses/result/' + data.quiz_attempt_id;
                } else {
                    alert('Error: ' + (data.error || 'Terjadi kesalahan. Silakan coba lagi.'));
                    submitButton.disabled = false;
                    submitButton.textContent = 'Submit Jawaban';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan: ' + error.message);
                submitButton.disabled = false;
                submitButton.textContent = 'Submit Jawaban';
            });
        });
    }

    // Initialize charts if on results page
    const talentChartCanvas = document.getElementById('talentChart');
    if (talentChartCanvas) {
        initializeTalentChart(talentChartCanvas);
    }
});

function initializeTalentChart(canvas) {
    const ctx = canvas.getContext('2d');

    // Define colors for each talent type
    const backgroundColors = {
        'RES': '#3498db', // Realistic
        'CON': '#e74c3c', // Conventional
        'EXP': '#2ecc71', // Experimental
        'ANA': '#f39c12'  // Analytical
    };

    // Get data from data attributes or use defaults
    const labels = canvas.getAttribute('data-labels') ?
        JSON.parse(canvas.getAttribute('data-labels')) :
        ['Realistik', 'Konvensional', 'Eksperimental', 'Analitis'];

    const data = canvas.getAttribute('data-values') ?
        JSON.parse(canvas.getAttribute('data-values')) :
        [0, 0, 0, 0];

    const backgroundColor = [
        backgroundColors['RES'],
        backgroundColors['CON'],
        backgroundColors['EXP'],
        backgroundColors['ANA']
    ];

    // Create the pie chart
    const talentChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                data: data,
                backgroundColor: backgroundColor,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                },
                title: {
                    display: true,
                    text: 'Distribusi Tipe Bakat'
                }
            }
        }
    });
}
