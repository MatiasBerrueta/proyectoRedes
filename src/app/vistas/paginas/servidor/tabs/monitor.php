<link rel="stylesheet" href="/css/paginas/servidor/tabs/monitor.css">
<div>
    <h2 class="texto-g">Monitor de recursos</h2>
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