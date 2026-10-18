import { html, useState } from "../preact.js";

export function EditorArchivo({ path, contenido }) {
  const [valor, setValor] = useState(contenido ?? "");

  return html`
    <form class="editor-contenedor" action="guardar.php" method="POST">
      <input type="hidden" name="path" value=${path} />
      <textarea
        id="editor"
        name="contenido"
        class="editor-textarea"
        spellcheck="false"
        placeholder="Archivo vacío..."
        value=${valor}
        onInput=${(e) => setValor(e.target.value)}
      ></textarea>
      <div class="editor-footer">
        <button type="submit" class="boton boton--primario">Guardar Cambios</button>
      </div>
    </form>
  `;
}
