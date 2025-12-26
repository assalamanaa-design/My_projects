document.addEventListener("DOMContentLoaded", function () {
    new Chart(document.getElementById('savingsChart').getContext('2d'), {
        type: 'line',
        data: { labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai'], datasets: [{
            label: 'Économies', data: [20, 30, 50, 40, 60], borderColor: '#007BFF',
            backgroundColor: 'rgba(0, 123, 255, 0.2)', fill: true, tension: 0.4
        }]},
        options: { responsive: true, maintainAspectRatio: false, scales: { y: { beginAtZero: true } } }
    });
    new Chart(document.getElementById('expensesChart').getContext('2d'), {
        type: 'bar',
        data: { labels: ['Semaine 1', 'Semaine 2', 'Semaine 3', 'Semaine 4'], datasets: [{
            label: 'Dépenses', data: [400, 600, 800, 700], backgroundColor: '#FF5733'
        }]},
        options: { responsive: true, maintainAspectRatio: false, scales: { y: { beginAtZero: true } } }
    });
});
