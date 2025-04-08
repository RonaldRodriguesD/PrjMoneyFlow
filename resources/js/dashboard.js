import Chart from 'chart.js/auto';

document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('evolucaoMensal');
    if (!ctx) return;

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['out. de 2024', 'nov. de 2024', 'dez. de 2024', 'jan. de 2025', 'fev. de 2025', 'mar. de 2025'],
            datasets: [{
                label: 'Receitas',
                data: [0, 0, 0, 0, 0, 0],
                borderColor: '#10B981',
                backgroundColor: '#D1FAE5',
                fill: true
            },
            {
                label: 'Despesas',
                data: [0, 0, 0, 0, 0, 0],
                borderColor: '#EF4444',
                backgroundColor: '#FEE2E2',
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'R$ ' + value.toFixed(2);
                        }
                    }
                }
            }
        }
    });
}); 