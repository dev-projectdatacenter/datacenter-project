/* 
 * public/js/charts.js
 * Auteur : OUARDA
 * Librairie utilitaire pour Chart.js - Couleurs standards
 */

const DataCenterCharts = {
    colors: [
        '#3498db', '#1abc9c', '#e67e22', '#e74c3c', '#9b59b6',
        '#34495e', '#2ecc71', '#f1c40f', '#8e44ad', '#2c3e50'
    ],

    // 1. Graphique en Camembert (Pie)
    createPieChart(canvasId, labels, data, label) {
        const ctx = document.getElementById(canvasId).getContext('2d');
        return new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    label: label,
                    data: data,
                    backgroundColor: this.colors,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });
    },

    // 2. Graphique en Barres (Bar)
    createBarChart(canvasId, labels, data, label) {
        const ctx = document.getElementById(canvasId).getContext('2d');
        return new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: label,
                    data: data,
                    backgroundColor: '#3498db',
                    borderColor: '#2980b9',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { beginAtZero: true }
                },
                plugins: {
                    legend: { display: false }
                }
            }
        });
    },

    // 3. Graphique en Ligne (Line)
    createLineChart(canvasId, labels, data, label) {
        const ctx = document.getElementById(canvasId).getContext('2d');
        return new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: label,
                    data: data,
                    fill: false,
                    borderColor: '#3498db',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    }
};
