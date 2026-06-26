<?php

	// Encription & Decription value
    function aes_encrypt($value) {
        $key  = getenv('ENCRYPTION_KEY');
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        $encrypted = openssl_encrypt($value, 'aes-256-cbc', $key, 0, $iv);
        return base64_encode($encrypted . '::' . $iv); // Combine encrypted data and IV
    }
    function aes_decrypt($encoded_value) {
        $key  = getenv('ENCRYPTION_KEY');
        list($encrypted_data, $iv) = explode('::', base64_decode($encoded_value), 2);
        return openssl_decrypt($encrypted_data, 'aes-256-cbc', $key, 0, $iv);
    }
    // NOTE 
    // AES encryption. 
    // AES requires a secret key and an initialization vector (IV) for encoding and decoding.
    // AES Encryption: Use when data security is critical (e.g., Email, NIM, Sandi, Username, ).
    // --------
    // Contoh penggunaan
    // $key = 'your-secret-key'; // Panjang disarankan 32 karakter
    // $original_filename = 'example.pdf'; // Nama file asli
    
    // // Enkripsi
    // $encrypted_filename = aes_encrypt($original_filename, $key);
    // echo "Nama file terenkripsi: " . $encrypted_filename . "\n";
    
    // // Dekripsi
    // $decrypted_filename = aes_decrypt($encrypted_filename, $key);
    // echo "Nama file asli: " . $decrypted_filename . "\n";


function isValidToken() {
    $CI =& get_instance();
    $CI->load->library('JwtHandler');
    $CI->load->model('Auth_model_jwt', 'auth');

    $authHeader = $CI->input->get_request_header('Authorization', TRUE);
    $token = str_replace('Bearer ', '', $authHeader);

    if (!$token) {
        echo json_encode(['status'=>false,'message'=>'Missing token']);
        return false;
    }

    // Cari user berdasarkan token
    $user = $CI->auth->getUserByToken($token);
    if (!$user) {
        echo json_encode(['status'=>false,'message'=>'Token tidak terdaftar']);
        return false;
    }

    // Decode token (WAJIB kirim userId)
    $decoded = $CI->jwthandler->decodeToken($token, $user->IDUSERS);

    if (isset($decoded['error'])) {
        echo json_encode(['status'=>false,'message'=>$decoded['error']]);
        return false;
    }

    // Simpan user ke CI super object (opsional tapi recommended)
    $CI->auth_user = $decoded;

    return true;
}


/* untuk mengambil lokasi login berdasarkan IP */
function get_user_location()
{
    // Ambil IP User
    $ip = $_SERVER['REMOTE_ADDR'] ? $_SERVER['REMOTE_ADDR'] : '0.0.0.0';

    // Tambahkan fields lat, lon
    $url = "http://ip-api.com/json/{$ip}?fields=status,country,regionName,city,lat,lon,query";
    $response = @file_get_contents($url);

    if (!$response) {
        return "Unknown";
    }

    $geo = json_decode($response, true);

    // Jika status gagal
    if (!isset($geo['status']) || $geo['status'] !== 'success') {
        return "Unknown";
    }

    // Format Lokasi + Koordinat
    $lokasi = "{$geo['city']}, {$geo['regionName']}, {$geo['country']}";
    $koordinat = "{$geo['lat']}, {$geo['lon']}";

    return [
        'ip'        => $geo['query'],
        'lokasi'    => $lokasi,
        'koordinat' => $koordinat
    ];
}

?>
