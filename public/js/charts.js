/**
 * charts.js
 * Géré par : CHAYMAE (Pallié par Assistant pour déblocage Jour 8)
 * Description : Fonctions utilitaires pour générer des graphiques avec Chart.js
 */

const DataCenterCharts = {
    /**
     * Crée un graphique en camembert (Pie Chart)
     * @param {string} canvasId - L'ID de l'élément canvas
     * @param {Array} labels - Les étiquettes
     * @param {Array} data - Les valeurs
     * @param {string} label - Le titre du jeu de données
     */
    createPieChart: function (canvasId, labels, data, label = 'Répartition') {
        const ctx = document.getElementById(canvasId).getContext('2d');
        return new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    label: label,
                    data: data,
                    backgroundColor: [
                        '#3498db', '#2ecc71', '#e74c3c', '#f1c40f', '#9b59b6', '#34495e', '#1abc9c'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                }
            }
        });
    },

    /**
     * Crée un graphique en barres (Bar Chart)
     */
    createBarChart: function (canvasId, labels, data, label = 'Valeurs') {
        const ctx = document.getElementById(canvasId).getContext('2d');
        return new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: label,
                    data: data,
                    backgroundColor: '#3498db',
                    borderRadius: 5
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    },

    /**
     * Crée un graphique linéaire (Line Chart)
     */
    createLineChart: function (canvasId, labels, data, label = 'Évolution') {
        const ctx = document.getElementById(canvasId).getContext('2d');
        return new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: label,
                    data: data,
                    borderColor: '#3498db',
                    tension: 0.3,
                    fill: true,
                    backgroundColor: 'rgba(52, 152, 219, 0.1)'
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }
};
