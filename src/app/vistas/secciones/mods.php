<div class="mods-tab">
	<div class="barra-busqueda">
		<input type="text" id="query" placeholder="Buscar mods...">
		<select id="loader">
			<option value="fabric">Fabric</option>
			<option value="forge">Forge</option>
			<option value="quilt">Quilt</option>
			<option value="neoforge">NeoForge</option>
		</select>
		<button onclick="buscar()">Buscar</button>
	</div>
	<div class="lista-mods" id="grid"></div>
</div>

<script>
	function formatNum(n) {
		if (n >= 1000000) return (n / 1000000).toFixed(1) + 'M';
		if (n >= 1000) return Math.round(n / 1000) + 'K';
		return n;
	}

	async function buscar() {
		const query = document.getElementById('query').value;
		const loader = document.getElementById('loader').value;
		const grid = document.getElementById('grid');
		grid.innerHTML = '<div class="loading">Buscando mods...</div>';

		try {
			const facets = JSON.stringify([
				["project_type:mod"],
				[`categories:${loader}`]
				// ["server_side:required", "server_side:optional"]
			]);
			const url = `https://api.modrinth.com/v2/search?query=${encodeURIComponent(query)}&limit=12&facets=${encodeURIComponent(facets)}`;
			const res = await fetch(url);
			const data = await res.json();
			console.log(data);

			if (!data.hits || data.hits.length === 0) {
				grid.innerHTML = '<div class="loading">No se encontraron mods.</div>';
				return;
			}

			grid.innerHTML = data.hits.map(mod => `
			<div class="card">
				<div class="card-header">
				${mod.icon_url
					? `<img class="mod-icon" src="${mod.icon_url}" alt="" onerror="this.style.display='none'">`
					: `<div class="mod-icon-placeholder">🧩</div>`}
				<div class="mod-info">
					<div class="mod-name" title="${mod.title}">${mod.title}<span class="mod-author"> por ${mod.author}</span></div>
					<div class="mod-desc">${mod.description}</div>
				</div>
				</div>
				<div class="categories">
				${mod.categories.slice(0,3).map(categoria => `<span class="badge ${categoria}">${categoria}</span>`).join('')}
				</div>
				<div class="card-footer">
				<div class="stats">
					<span class="stat">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-download"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" /><path d="M7 11l5 5l5 -5" /><path d="M12 4l0 12" /></svg>
						${formatNum(mod.downloads)}
					</span>
					<span class="stat">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-heart"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M19.5 12.572l-7.5 7.428l-7.5 -7.428a5 5 0 1 1 7.5 -6.566a5 5 0 1 1 7.5 6.572" /></svg>
					 	${formatNum(mod.follows)}
					 </span>
				</div>
				<button class="install-btn" onclick="instalar('${mod.slug}', '${mod.title.replace(/'/g, "\\'")}')">Instalar</button>
				</div>
			</div>
			`).join('');
		} catch (e) {
			grid.innerHTML = '<div class="error">Error al conectar con Modrinth.</div>';
		}
	}

	function instalar(slug, nombre) {
		alert(`por hacer`);
	}

	buscar();

	document.getElementById('query').addEventListener('keydown', e => {
		if (e.key === 'Enter') buscar();
	});
</script>