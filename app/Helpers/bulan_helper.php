<?php
if (!function_exists('bulanIndo')) {
    function bulanIndo($bulanInggris) {
        $map = [
            'January' => 'Januari',
            'February' => 'Februari',
            'March' => 'Maret',
            'April' => 'April',
            'May' => 'Mei',
            'June' => 'Juni',
            'July' => 'Juli',
            'August' => 'Agustus',
            'September' => 'September',
            'October' => 'Oktober',
            'November' => 'November',
            'December' => 'Desember',
        ];
        return $map[$bulanInggris] ?? $bulanInggris;
    }
}
