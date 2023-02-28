<?php

// Función para dar formato a las fechas y mostrar el tiempo
// transcurrido desde la fecha 1 hasta la fecha 2
function format_interval_dates_short($dateFrom, $dateTo)
{
    $interval = $dateFrom->diff($dateTo);

    if ($interval->y) {
        return $interval->format("%yY");
    }
    if ($interval->m) {
        return $interval->format("%mM");
    }
    if ($interval->d) {
        return $interval->format("%dD");
    }
    if ($interval->h) {
        return $interval->format("%hH");
    }
    if ($interval->i) {
        return $interval->format("%im");
    }
    if ($interval->s) {
        return $interval->format("%ss");
    }
}