function initSeparator(canvas, options = {}) {
  const CONFIG = {
    height: 80,
    px: 8,
    color: 'hsl(243, 35%, 18%)',
    mainBarY: 40,
    mainBarH: 40,
    floatChance: 0.15,
    barVariation: 4,
    seed: 0,
    maxStep: 1,
    ...options,
  };

  function rand(seed) {
    const x = Math.sin(seed * 9301 + 49297) * 233280;
    return x - Math.floor(x);
  }

  function snap(val, unit) {
    return Math.round(val / unit) * unit;
  }

  function draw() {
    const W = window.innerWidth;
    const H = CONFIG.height;

    const dpr = window.devicePixelRatio || 1;
    canvas.width  = W * dpr;
    canvas.height = H * dpr;
    canvas.style.height = H + 'px';
    const ctx = canvas.getContext('2d');
    ctx.scale(dpr, dpr);

    ctx.fillStyle = CONFIG.color;

    const maxStep = CONFIG.maxStep * CONFIG.px;
    let prevTopOffset = 0;
    let prevBotOffset = 0;
    let col = 0;

    for (let x = 0; x < W; x += CONFIG.px, col++) {
      const r0 = rand(col + CONFIG.seed);
      const r1 = rand(col + CONFIG.seed + 1000);
      const r2 = rand(col + CONFIG.seed + 2000);
      const r3 = rand(col + CONFIG.seed + 3000);

      const targetTop = snap((r0 - 0.5) * CONFIG.barVariation * CONFIG.px, CONFIG.px);
      const targetBot = snap((r1 - 0.5) * CONFIG.barVariation * CONFIG.px, CONFIG.px);

      const deltaTop = Math.max(-maxStep, Math.min(maxStep, targetTop - prevTopOffset));
      const deltaBot = Math.max(-maxStep, Math.min(maxStep, targetBot - prevBotOffset));

      prevTopOffset += deltaTop;
      prevBotOffset += deltaBot;

      const topOffset = CONFIG.direction === 'down' ? 0 : prevTopOffset;
      const botOffset = CONFIG.direction === 'up'   ? 0 : prevBotOffset;

      const barTop = CONFIG.mainBarY * `${CONFIG.direction === 'up' ? 1 : 0}` + topOffset;
      const barBot = CONFIG.mainBarY * `${CONFIG.direction === 'up' ? 1 : 0}` + CONFIG.mainBarH + botOffset;
      const barH   = barBot - barTop;

      if (barH > 0) {
        ctx.fillRect(x, barTop, CONFIG.px, barH);
      }

      if (CONFIG.direction === 'up' && r2 < CONFIG.floatChance) {
        const floatY = barTop - CONFIG.px - CONFIG.px;
        if (floatY >= 0) {
          ctx.fillRect(x, floatY, CONFIG.px, CONFIG.px);
        }
      }

      if (CONFIG.direction === 'down' && r3 < CONFIG.floatChance) {
        const floatY = barBot + CONFIG.px;
        if (floatY + CONFIG.px <= H) {
          ctx.fillRect(x, floatY, CONFIG.px, CONFIG.px);
        }
      }
    }
  }

  draw();
  window.addEventListener('resize', draw);
}

document.querySelectorAll('.pixel-separator').forEach(el => {
    const color = el.dataset.color || 
    getComputedStyle(document.documentElement)
      .getPropertyValue('--azul-logo').trim();


    const canvas = document.createElement('canvas');
    canvas.style.display = 'block';
    canvas.style.width = '100%';
    canvas.style.imageRendering = 'pixelated';
    canvas.style[el.dataset.direction === 'up' ? 'marginTop' : 'marginBottom'] = '5rem';

    el.appendChild(canvas);

    initSeparator(canvas, {
        seed: Number(el.dataset.seed ?? 0),
        color: color,
        height: Number(el.dataset.height ?? 80),
        direction: el.dataset.direction ?? 'down',
    });
});