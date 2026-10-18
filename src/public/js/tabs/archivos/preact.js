import { h, render } from "https://esm.sh/preact@10.24.3";
import { useState, useMemo, useRef, useEffect } from "https://esm.sh/preact@10.24.3/hooks";
import htm from "https://esm.sh/htm@3.1.1";

// Punto unico de importacion de Preact para el tab de archivos.
// Centralizar `h` garantiza que todas las plantillas `html` compartan la
// misma instancia de Preact y que `htm.bind(h)` sea consistente.
export { h, render, useState, useMemo, useRef, useEffect };

export const html = htm.bind(h);
