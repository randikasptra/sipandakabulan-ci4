<?php
if (!function_exists('getKlasterSlug')) {
    function getKlasterSlug($klaster)
    {
        // Contoh fungsi sederhana, sesuaikan dengan fungsi asli kamu
        return strtolower(str_replace(' ', '-', $klaster));
    }
}
