/* 
 * public/js/charts.js
 * Auteur : OUARDA
 * Librairie utilitaire pour Chart.js - Couleurs standards
 */

const DataCenterCharts = {
    // Palette "Smartech" - Pastel (Blue, Green, Yellow, Orange)
    colors: [
        '#b3d1ff', // Blue
        '#b8e2d2', // Mint
        '#f9e8ad', // Yellow
        '#ffcc99', // Orange
        '#e2e8f0'  // Gray
    ],

    // 1. Graphique en Camembert (Pie) - Style épuré
    createPieChart(canvasId, labels, data, label) {
        const ctx = document.getElementById(canvasId).getContext('2d');
        return new Chart(ctx, {
            type: 'doughnut', // Doughnut est plus moderne que Pie
            data: {
                labels: labels,
                datasets: [{
                    label: label,
                    data: data,
                    backgroundColor: this.colors,
                    borderColor: '#ffffff',
                    borderWidth: 5,
                    hoverOffset: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '75%', // Très aéré
                borderRadius: 20,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true,
                            font: { family: 'inherit', size: 11, weight: '600' },
                            color: '#64748b'
                        }
                    }
                }
            }
        });
    },

    // 2. Graphique en Barres (Horizontal pour la lisibilité des noms)
    createBarChart(canvasId, labels, data, label) {
        const ctx = document.getElementById(canvasId).getContext('2d');
        return new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: label,
                    data: data,
                    backgroundColor: '#b3d1ff',
                    borderRadius: 8,
                    borderSkipped: false,
                    barThickness: 40
                }]
            },
            options: {
                indexAxis: 'y', // Mode horizontal
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { font: { family: 'inherit', weight: '600' }, color: '#64748b' }
                    },
                    y: {
                        grid: { display: false },
                        ticks: {
                            font: { family: 'inherit', weight: '600', size: 11 },
                            color: '#2c3e50',
                            // On assure que les labels ne se chevauchent pas
                        }
                    }
                },
                plugins: {
                    legend: { display: false }
                }
            }
        });
    },

    // 3. Graphique en Ligne (Line) - Courbe lissée et dégradé
    createLineChart(canvasId, labels, data, label) {
        const ctx = document.getElementById(canvasId).getContext('2d');

        // Création d'un dégradé sous la courbe
        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(179, 209, 255, 0.4)');
        gradient.addColorStop(1, 'rgba(179, 209, 255, 0)');

        return new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: label,
                    data: data,
                    fill: true,
                    backgroundColor: gradient,
                    borderColor: '#3498db',
                    borderWidth: 4,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#3498db',
                    pointBorderWidth: 3,
                    pointRadius: 6,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { display: false },
                    x: {
                        grid: { display: false },
                        ticks: { font: { family: 'inherit', weight: '600' }, color: '#8e8288' }
                    }
                },
                plugins: {
                    legend: { display: false }
                }
            }
        });
    }
};
