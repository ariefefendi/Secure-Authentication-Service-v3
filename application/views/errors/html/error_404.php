<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>404 Page Not Found</title>
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap');

* { box-sizing: border-box; margin:0; padding:0; }

body, html {
    height: 100%;
    font-family: 'Inter', sans-serif;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #2c3e50, #34495e);
}

.container-404 {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: center;
    max-width: 900px;
    width: 90%;
    background-color: #c8e3ffeb;
    border-radius: 16px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.2);
    overflow: hidden;
    animation: fadeIn 1s ease forwards;
}

.image-section {
    flex: 1 1 300px;
    background: url('https://template.kazuyamedia.com/frest_admin/app-assets/images/pages/404.png') center center no-repeat;
    background-size: contain;
    min-height: 300px;
    margin: 0em 1em;
}

.text-section {
    flex: 1 1 400px;
    padding: 0px 40px 40px;
    text-align: center;
}

.error-code {
    font-size: 80px;
    font-weight: 700;
    color: #e74c3c;
}

.error-heading {
    font-size: 28px;
    color: #2c3e50;
    margin: 15px 0 20px 0;
    font-weight: 600;
}

.error-message {
    font-size: 16px;
    color: #555;
    margin-bottom: 30px;
}

.btn-home {
    display: inline-block;
    padding: 12px 28px;
    background-color: #1abc9c;
    color: #fff;
    font-weight: 600;
    border-radius: 8px;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-home:hover {
    background-color: #16a085;
    transform: translateY(-2px);
    box-shadow: 0 6px 12px rgba(0,0,0,0.15);
}

.footer {
    margin-top: 30px;
    font-size: 12px;
    color: #7f8c8d;
    font-style: italic;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
}

@media (max-width: 768px) {
    .container-404 { flex-direction: column; }
    .image-section { min-height: 200px; }
    .error-code { font-size: 60px; }
    .error-heading { font-size: 22px; }
}
</style>
</head>
<body>
    <div class="container-404">
        <div class="image-section"></div>
        <div class="text-section">
            <div class="error-code">404</div>
            <div class="error-heading"><?php echo $heading; ?></div>
            <div class="error-message"><?php echo $message; ?></div>
            <a href="/" class="btn-home">Kembali ke Beranda</a>
            <div class="footer">
                Powered by <strong>Kazuya Media Indonesia</strong> – 
                <a href="https://www.kazuyamedia.com" target="_blank">www.kazuyamedia.com</a>
            </div>
        </div>
    </div>
</body>
</html>
