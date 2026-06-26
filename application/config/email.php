<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['config'] = [
    'protocol'    => 'smtp',
    'smtp_host'   => 'sandbox.smtp.mailtrap.io', // Pastikan ini adalah host yang benar
    'smtp_user'   => '0cf1a5fa6196c4',          // Ganti dengan username Mailtrap Anda
    'smtp_pass'   => '8db3cc912e40af',          // Ganti dengan password Mailtrap Anda
    'smtp_port'   => 2525,                      // Port default untuk Mailtrap (2525 atau 587)
    'smtp_crypto' => '',                        // Tidak diperlukan untuk Mailtrap, tapi gunakan 'tls' jika diharuskan
    'mailtype'    => 'html',                    // Tipe email: HTML
    'charset'     => 'utf-8',                   // Karakter yang digunakan
    'wordwrap'    => TRUE,                      // Word wrapping
    'newline'     => "\r\n",                    // Untuk memastikan kompatibilitas dengan standar protokol SMTP
    'validate'    => TRUE                       // Validasi email
];