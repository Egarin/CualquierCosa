<?php

if (!function_exists('formato_moneda')) {
    /**
     * Formatea un monto a moneda Guaraní (Gs.)
     * Ejemplo: 100000 -> Gs. 100.000
     * 
     * @param float|int $monto
     * @return string
     */
    function formato_moneda($monto)
    {
        return 'Gs. ' . number_format($monto, 0, ',', '.');
    }
}
