<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link rel="stylesheet" href="/css/tabMonitor.css">
<div>
    <h2 class="font-size-5">Monitor de recursos</h2>
    <div class="contenedor-graficos">
        <div class="contenedor-grafico">
            <div class="grafico-header">
                <span class="grafico-titulo">CPU</span>
                <span class="grafico-valor" data-cpu>20<small>%</small></span>
            </div>
            <canvas id="cpuChart"></canvas>
        </div>
         <div class="contenedor-grafico">
            <div class="grafico-header">
                <span class="grafico-titulo">RAM</span>
                <span class="grafico-valor" data-ram>3.2<small>/ 8 GB</small></span>
            </div>
            <canvas id="ramChart"></canvas>
        </div>
    </div>
</div>

<script>
const ctxCpu = document.getElementById('cpuChart').getContext('2d');
const ctxRam = document.getElementById('ramChart').getContext('2d');

const cpuChart = new Chart(ctxCpu, {
    type: 'line',
    data: {
        labels: [],
        datasets: [{
            data: [],
            borderWidth: 2,
            tension: 0.2,       // suaviza la línea
            pointRadius: 2,     // sin puntos
            fill: true          // relleno abajo
        }]
    },
   options: {
        responsive: true,
        animation: false,
        spanGaps: true,
        plugins: {
            legend: { display: false },
        },
        scales: {
            x: {
                ticks: {
                    display: false
                }
            },
            y: {
                min: 0,
                max: 100,
                grid: {
                    color: 'rgba(255, 255, 255, 0.1)',
                    drawBorder: false
                },
                ticks: {
                    color: '#aaa',
                    stepSize: 25,
                }
            }
        }
    }
});


const ramChart = new Chart(ctxRam, {
    type: 'line',
    data: {
        labels: [],
        datasets: [{
            data: [],
            borderWidth: 2,
            tension: 0.4,       // suaviza la línea
            pointRadius: 2,     // sin puntos
            fill: true          // relleno abajo
        }]
    },
    options: {
        responsive: true,
        animation: false,
        spanGaps: true,
        plugins: {
            legend: { display: false },
        },
        scales: {
            x: {
                ticks: {
                    display: false
                }
            },
            y: {
                min: 0,
                max: 2,
                grid: {
                    color: 'rgba(255, 255, 255, 0.1)',
                    drawBorder: false
                },
                ticks: {
                    color: '#aaa',
                    stepSize: 0.5,
                }
            }
        }
    }
});
</script>