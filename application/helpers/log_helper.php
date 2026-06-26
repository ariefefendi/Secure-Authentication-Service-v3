<?php

if (!function_exists('write_log')) {
    function write_log($aksi, $modul, $iduser = null)
    {
        $CI =& get_instance();
        $CI->load->model('LogActivity');

        // Jika iduser tidak dikirim, default ke 'Guest'
        if (!$iduser) {
            $iduser = 'Guest';
        }

        // Simpan log
        $CI->LogActivity->saveLog($iduser, $aksi, $modul);
    }
}