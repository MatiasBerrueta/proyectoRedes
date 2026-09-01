<link rel="stylesheet" href="/css/paginas/servidor/tabs/mods.css">

<div class="mods-tab">
	<nav>
		<ul>
			<li><a class="seleccionado" href="">Mods instalados</a></li>
			<li><a href="">Descubrir</a></li>
		</ul>
	</nav>
	<div class="mods-instalados">
		
	</div>
	<div class="barra-busqueda">
		<input type="text" id="query" placeholder="Buscar mods...">
		<select id="loader">
			<option value="fabric">Fabric</option>
			<option value="forge">Forge</option>
			<option value="quilt">Quilt</option>
			<option value="neoforge">NeoForge</option>
		</select>
		<button onclick="window.__buscarMod()">Buscar</button>
	</div>
	<div class="lista-mods" id="grid"></div>
</div>
