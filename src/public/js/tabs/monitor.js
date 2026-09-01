import { Chart } from "https://cdn.jsdelivr.net/npm/chart.js/auto/+esm";
import { suscribir } from "/js/servidor/servidorWebsocket.js";

let cpuChart = null;
let ramChart = null;
let limpiadores = [];

function actualizarChart(chart, value) {
  const maxPoints = 10;

  chart.data.labels.push("");
  chart.data.datasets[0].data.push(value);

  if (chart.data.labels.length > maxPoints) {
    chart.data.labels.shift();
    chart.data.datasets[0].data.shift();
  }

  chart.update();
}

export function init() {
  const ctxCpu = document.getElementById("cpuChart");
  const ctxRam = document.getElementById("ramChart");
  if (!ctxCpu || !ctxRam) return;

  cpuChart = new Chart(ctxCpu.getContext("2d"), {
    type: "line",
    data: {
      labels: [],
      datasets: [
        {
          data: [],
          borderWidth: 2,
          tension: 0.2,
          pointRadius: 2,
          fill: true,
        },
      ],
    },
    options: {
      responsive: true,
      animation: false,
      spanGaps: true,
      plugins: { legend: { display: false } },
      scales: {
        x: { ticks: { display: false } },
        y: {
          min: 0,
          max: 100,
          grid: { color: "rgba(255, 255, 255, 0.1)", drawBorder: false },
          ticks: { color: "#aaa", stepSize: 25 },
        },
      },
    },
  });

  ramChart = new Chart(ctxRam.getContext("2d"), {
    type: "line",
    data: {
      labels: [],
      datasets: [
        {
          data: [],
          borderWidth: 2,
          tension: 0.4,
          pointRadius: 2,
          fill: true,
        },
      ],
    },
    options: {
      responsive: true,
      animation: false,
      spanGaps: true,
      plugins: { legend: { display: false } },
      scales: {
        x: { ticks: { display: false } },
        y: {
          min: 0,
          max: 2,
          grid: { color: "rgba(255, 255, 255, 0.1)", drawBorder: false },
          ticks: { color: "#aaa", stepSize: 0.5 },
        },
      },
    },
  });

  limpiadores.push(
    suscribir("stats", (raw) => {
      const stats = JSON.parse(raw);
      const ram = stats.memory_bytes / 1024 ** 3;

      actualizarChart(cpuChart, stats.cpu_absolute);
      actualizarChart(ramChart, ram.toFixed(2));
    }),
  );
}

export function destroy() {
  limpiadores.forEach((limpiar) => limpiar());
  limpiadores = [];

  if (cpuChart) {
    cpuChart.destroy();
    cpuChart = null;
  }
  if (ramChart) {
    ramChart.destroy();
    ramChart = null;
  }
}