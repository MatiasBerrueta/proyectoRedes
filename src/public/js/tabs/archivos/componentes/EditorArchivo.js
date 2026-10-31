import { html, useState, useEffect } from "../preact.js";
import {
  IconoVolver,
  IconoDescargar,
  IconoDescartar,
  IconoGuardar,
} from "../iconos.js";

export function EditorArchivo({ path, contenido, onGuardar, onDescargar }) {
  const [valor, setValor] = useState(contenido ?? "");
  const [contenidoGuardado, setContenidoGuardado] = useState(contenido ?? "");
  const [estado, setEstado] = useState("sin-cambios");
  const [guardando, setGuardando] = useState(false);

  useEffect(() => {
    const inicial = contenido ?? "";
    setValor(inicial);
    setContenidoGuardado(inicial);
    setEstado("sin-cambios");
    setGuardando(false);
  }, [path]);

  const hayCambios = valor !== contenidoGuardado;
  const nombreArchivo =
    String(path ?? "")
      .split("/")
      .pop() || "archivo";

  const textoEstado =
    estado === "error"
      ? "Error al guardar"
      : hayCambios
        ? "Cambios sin guardar"
        : estado === "guardado"
          ? "Guardado"
          : "Sin cambios";

  const claseEstado =
    estado === "error"
      ? "error"
      : hayCambios
        ? "pendiente"
        : estado === "guardado"
          ? "guardado"
          : "sin-cambios";

  const descartar = () => {
    setValor(contenidoGuardado);
    setEstado("sin-cambios");
  };

  const descargar = () => {
    if (onDescargar) {
      onDescargar({ path, contenido: valor });
      return;
    }

    const blob = new Blob([valor], { type: "text/plain;charset=utf-8" });
    const url = URL.createObjectURL(blob);
    const enlace = document.createElement("a");

    enlace.href = url;
    enlace.download = nombreArchivo;
    enlace.click();
    URL.revokeObjectURL(url);
  };

  const guardar = async (e) => {
    e.preventDefault();
    if (!hayCambios || guardando) return;

    setGuardando(true);
    try {
      if (onGuardar) await onGuardar({ path, contenido: valor });
      setContenidoGuardado(valor);
      setEstado("guardado");
    } catch (error) {
      setEstado("error");
    } finally {
      setGuardando(false);
    }
  };

  return html`
    <form class="editor-contenedor" onSubmit=${guardar}>
      <div class="editor-header">
        <div class="editor-header-info">
          <span class=${"editor-estado editor-estado--" + claseEstado}>
            ${textoEstado}
          </span>
        </div>
        <div class="acciones">
          <button
            type="button"
            class="boton boton--s"
            disabled=${!hayCambios || guardando}
            onClick=${descartar}
          >
            <${IconoDescartar} /> Descartar
          </button>
          <button type="button" class="boton boton--s" onClick=${descargar}>
            <${IconoDescargar} /> Descargar
          </button>
          <button
            type="submit"
            class="boton boton--s boton--primario"
            disabled=${!hayCambios || guardando}
          >
            <${IconoGuardar} />
            ${guardando ? "Guardando..." : "Guardar cambios"}
          </button>
        </div>
      </div>

      <input type="hidden" name="path" value=${path} />
      <textarea
        id="editor"
        name="contenido"
        class="editor-textarea"
        spellcheck="false"
        placeholder="Archivo vacío..."
        value=${valor}
        onInput=${(e) => {
          setValor(e.target.value);
          setEstado("sin-cambios");
        }}
      ></textarea>
    </form>
  `;
}
