<?php

if (!function_exists('angkaKeTerbilang')) {
    function angkaKeTerbilang($angka) {
        $fmt = new NumberFormatter('id_ID', NumberFormatter::SPELLOUT);
        return ucwords($fmt->format($angka));
    }
}
