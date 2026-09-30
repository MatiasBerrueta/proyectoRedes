<?php
class Formatear {
  public static function formatBytes(int $bytes, $precision = 2) { 
    $units = ['B', 'KB', 'MB', 'GB', 'TB']; 

    $bytes = max($bytes, 0); 
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
    $pow = min($pow, count($units) - 1); 

    $bytes /= pow(1024, $pow);

    return round($bytes, $precision) . $units[$pow]; 
  }

  public static function obtenerTiempoTranscurrido(string $fechaIso): string {
    $ultimaFecha = new DateTime($fechaIso);
    $ahora = new DateTime();
    
    $diferencia = $ahora->diff($ultimaFecha);
    
    // Si la fecha es futura por algun desfase de reloj
    if ($ultimaFecha > $ahora) {
        return "hace unos momentos";
    }

    // Si pasaron 30 dias o mas
    if ($diferencia->days >= 30) {
        // Retorna la fecha formateada (ej: 01/05/2026)
        return $ultimaFecha->format('d/m/Y'); 
    }

    // Logica para tiempo relativo (menos de 30 días)
    if ($diferencia->days >= 7) {
        $semanas = floor($diferencia->days / 7);
        return "hace " . $semanas . ($semanas == 1 ? " semana" : " semanas");
    }
    
    if ($diferencia->days >= 1) {
        return "hace " . $diferencia->days . ($diferencia->days == 1 ? " día" : " días");
    }
    
    if ($diferencia->h >= 1) {
        return "hace " . $diferencia->h . ($diferencia->h == 1 ? " hora" : " horas");
    }
    
    if ($diferencia->i >= 1) {
        return "hace " . $diferencia->i . ($diferencia->i == 1 ? " minuto" : " minutos");
    }

    return "hace unos segundos";
}
}