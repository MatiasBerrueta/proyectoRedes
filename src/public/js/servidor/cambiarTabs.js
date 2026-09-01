async function cargarJs(tabNombre) {
  try {
    moduloTabActivo = await import(`/js/tabs/${tabNombre}.js?v=${Date.now()}`);
    if (typeof moduloTabActivo.init === "function") {
      moduloTabActivo.init(servidor);
    }
  } catch (err) {
    console.log(err);
    moduloTabActivo = null;
  }
}

export async function cargarTab(tabNombre, extraParams = {}) {
  if (moduloTabActivo && typeof moduloTabActivo.destroy === "function") {
    moduloTabActivo.destroy();
  }

  const queryParams = new URLSearchParams(extraParams).toString();
  const url = `/api/servidores/${servidor.identifier}/tabs/${tabNombre}${queryParams ? "?" + queryParams : ""}`;

  const respuesta = await fetch(url, { method: "GET" });

  if (!respuesta.ok) {
    console.error(`Error al cargar el tab ${tabNombre}`);
    return;
  }

  document.getElementById("tab-contenido").innerHTML = await respuesta.text();

  cargarJs(tabNombre);
}

async function cambiarTab(servidorId, tab) {
  const nuevaUrl = `/servidores/${servidorId}/${tab}`;
  window.history.pushState({ servidorId, tab }, "", nuevaUrl);

  await cargarTab(tab);
}

const tabs = document.querySelectorAll("[data-tab]");

tabs.forEach((tab) => {
  tab.addEventListener("click", async (e) => {
    const tabActual = e.currentTarget;
    const nuevoTabNombre = tabActual.dataset.tab;

    if (tabActual.classList.contains("activo")) return;

    try {
      console.log(servidor.identifier, nuevoTabNombre);
      await cambiarTab(servidor.identifier, nuevoTabNombre);

      const tabActivoAnterior = document.querySelector("[data-tab].activo");
      if (tabActivoAnterior) {
        tabActivoAnterior.classList.remove("activo");
      }

      tabActual.classList.add("activo");
    } catch (error) {
      console.error("Error al cambiar de tab:", error);
    }
  });
});

window.addEventListener("popstate", (event) => {
  if (event.state) {
    cambiarTab(event.state.servidor.identifier, event.state.tab);
  }
});

cargarJs(tabActual);
