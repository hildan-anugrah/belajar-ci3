<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('tgl_indo')) {
    function tgl_indo($datetime) {
        if (empty($datetime) || $datetime == '0000-00-00 00:00:00') {
            return '-';
        }

        $bulan = array (
            1 => 'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );

        $split_waktu = explode(' ', $datetime);
        $tgl         = $split_waktu[0];
        $jam         = isset($split_waktu[1]) ? $split_waktu[1] : '';
        $pecahkan    = explode('-', $tgl);

        return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0] . ($jam ? ' ' . $jam : '');
    }
}