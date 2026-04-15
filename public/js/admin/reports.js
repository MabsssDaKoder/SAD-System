// ==========================================
// TAB SWITCHING
// ==========================================
function showTab(tab, btn) {
    document.querySelectorAll('.tab-content').forEach(t => t.classList.add('hidden'));
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    document.getElementById('tab-' + tab).classList.remove('hidden');
    btn.classList.add('active');

    // Draw chart for selected tab
    drawChart(tab);
}

// ==========================================
// PIE CHART DATA
// Change these values to update the charts
// ==========================================

// DAILY color stats
const daily_color_stats = [50, 35, 5, 10]; // white, black, colored, others

// WEEKLY color stats
const weekly_color_stats = [50, 25, 15, 10];

// MONTHLY color stats
const monthly_color_stats = [45, 30, 15, 10];

// ANNUALLY color stats
const annually_color_stats = [48, 28, 14, 10];

// Chart colors
const chartColors = ['#e0e0e0', '#1a1a1a', '#8B4513', '#607d8b'];

// Store chart instances
const chartInstances = {};

function drawChart(tab) {
    const dataMap = {
        daily:    daily_color_stats,
        weekly:   weekly_color_stats,
        monthly:  monthly_color_stats,
        annually: annually_color_stats,
    };

    const canvasId = `${tab}-color-chart`;
    const canvas   = document.getElementById(canvasId);
    if (!canvas) return;

    // Destroy existing chart if any
    if (chartInstances[tab]) {
        chartInstances[tab].destroy();
    }

    chartInstances[tab] = new Chart(canvas, {
        type: 'pie',
        data: {
            labels: ['White', 'Black', 'Colored', 'Others'],
            datasets: [{
                data: dataMap[tab],
                backgroundColor: chartColors,
                borderWidth: 1
            }]
        },
        options: {
            plugins: { legend: { display: false } },
            responsive: false
        }
    });
}

// Draw initial chart on page load
drawChart('daily');