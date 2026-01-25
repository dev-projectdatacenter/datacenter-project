/* 
 * public/js/statistics.js
 * Auteur : OUARDA
 * Description : Initialisation des graphiques du Data Center
 */

document.addEventListener('DOMContentLoaded', function () {
    // 1. Initialisation des graphiques de la page INDEX (Général)
    const categoryCanvas = document.getElementById('categoryChart');
    const topResourcesCanvas = document.getElementById('topResourcesChart');

    if (categoryCanvas && topResourcesCanvas && typeof DataCenterCharts !== 'undefined') {
        try {
            // Récupération des données injectées dans le DOM via data attributes
            const catCtx = categoryCanvas.closest('.chart-card');
            const catLabels = JSON.parse(categoryCanvas.dataset.labels || '[]');
            const catData = JSON.parse(categoryCanvas.dataset.values || '[]');

            const resLabels = JSON.parse(topResourcesCanvas.dataset.labels || '[]');
            const resData = JSON.parse(topResourcesCanvas.dataset.values || '[]');

            DataCenterCharts.createPieChart('categoryChart', catLabels, catData, 'Équipements');
            DataCenterCharts.createBarChart('topResourcesChart', resLabels, resData, 'Réservations');
        } catch (e) {
            console.error("Erreur lors de l'initialisation des graphiques globaux:", e);
        }
    }

    // 2. Initialisation du graphique de la page MY-RESOURCES (Personnel)
    const activityCanvas = document.getElementById('activityChart');
    if (activityCanvas && typeof DataCenterCharts !== 'undefined') {
        try {
            // Récupération des données injectées dans le DOM
            const actLabels = JSON.parse(activityCanvas.dataset.labels || '[]');
            const actData = JSON.parse(activityCanvas.dataset.values || '[]');

            // Conversion des numéros de mois en noms
            const monthNames = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'];
            const labels = actLabels.map(month => monthNames[month - 1] || 'Mois ' + month);

            DataCenterCharts.createLineChart('activityChart', labels, actData, 'Réservations mensuelles');
        } catch (e) {
            console.error("Erreur lors de l'initialisation du graphique d'activité:", e);
        }
    }
});
