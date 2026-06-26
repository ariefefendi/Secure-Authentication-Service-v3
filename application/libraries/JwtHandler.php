<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class JwtHandler {
    protected $secret_key;

    public function __construct() {
        // Gunakan secret key dari environment CI
        $this->secret_key = getenv('ENCRYPTION_KEY');
    }

    // ============================================================
    // ENCODE TOKEN (GENERATE TOKEN)
    // ============================================================
    public function encodeToken($data) 
    {
        $issuedAt = time();
        $expire   = $issuedAt + 3600; // 1 jam

        $payload = [
            'id'        => $data['IDPENGGUNA'],
            'name'      => $data['NAMADEPAN'],
            'idjabatan' => $data['IDJABATAN'],
            'status'    => $data['STATUS'],
            'iat'       => $issuedAt,
            'exp'       => $expire
        ];

        // Generate signature
        $signatureInput = "{$payload['id']}:{$payload['name']}:{$payload['idjabatan']}:{$payload['status']}:{$issuedAt}:{$expire}";
        $payload['signature'] = hash_hmac('sha256', $signatureInput, $this->secret_key);

        // JWT custom berbasis AES
        return aes_encrypt(json_encode($payload), $this->secret_key);
    }

    // ============================================================
    // GET TOKEN DARI TABEL (TOKEN YANG SAH)
    // ============================================================
    protected function getValidToken($userId = null) 
    {
        $CI =& get_instance();
        $CI->db->where('IDUSERS', $userId);
        $row = $CI->db->get('tb_user_app')->row_array();

        if (!$row || empty($row['BEARER'])) {
            return null;
        }

        return $row['BEARER'];
    }

    // ============================================================
    // DECODE TOKEN (VALIDASI TOKEN)
    // ============================================================
    public function decodeToken($token, $userId = null) 
    {
        // Ambil token dari DB untuk dibandingkan
        $dbToken = $this->getValidToken($userId);

        if (!$dbToken) {
            return ['error' => 'Token tidak ditemukan di database.'];
        }

        if ($token !== $dbToken) {
            return ['error' => 'Token tidak valid atau sudah logout.'];
        }

        // Dekripsi token
        $decoded = aes_decrypt($token, $this->secret_key);

        if (!$decoded) {
            return ['error' => 'Gagal mendekripsi token.'];
        }

        // Decode JSON
        $data = json_decode($decoded, true);

        if (!is_array($data)) {
            return ['error' => 'Format token tidak valid.'];
        }

        // Validasi signature
        $signatureInput = "{$data['id']}:{$data['name']}:{$data['idjabatan']}:{$data['status']}:{$data['iat']}:{$data['exp']}";
        $expectedSignature = hash_hmac('sha256', $signatureInput, $this->secret_key);

        if ($data['signature'] !== $expectedSignature) {
            return ['error' => 'Signature token tidak valid.'];
        }

        // Validasi waktu exp
        $current = time();
        $tolerance = 0; // tidak ada toleransi tambahan

        if ($current > ($data['exp'] + $tolerance)) {
            return ['error' => 'Token sudah kedaluwarsa.'];
        }

        // Token valid – return payload minimal
        return [
            'id'        => $data['id'],
            'name'      => $data['name'],
            'idjabatan' => $data['idjabatan'],
            'status'    => $data['status']
        ];
    }
    
    
    
    
    // ===============================
    // CHECK TOKEN : untuk setiap halaman.
    // ===============================
    public function isValidToken()
    {
        $headers = $this->input->request_headers();
    
        // Pastikan Authorization header ada
        if (!isset($headers['Authorization'])) {
            echo json_encode(['status' => false, 'message' => 'Authorization header missing']);
            return;
        }
    
        $token = str_replace('Bearer ', '', $headers['Authorization']);
    
        // Cari user berdasarkan token (karena token AES unik per user)
        $this->load->model('Auth_model_jwt', 'auth');
        $user = $this->auth->getUserByToken($token);
    
        if (!$user) {
            echo json_encode(['status' => false, 'message' => 'Token tidak terdaftar di DB (sudah logout / invalid)']);
            return;
        }
    
        // Decode token menggunakan JwtHandler custom Anda
        $decoded = $this->jwthandler->decodeToken($token, $user->IDUSERS);
    
        if (!$decoded || isset($decoded['error'])) {
            echo json_encode([
                'status' => false,
                'message' => isset($decoded['error']) 
                    ? $decoded['error'] 
                    : 'Token decode failed'
            ]);
            return;
        }
    
        echo json_encode([
            'status'  => true,
            'message' => 'Token valid',
            'user'    => $decoded
        ]);
    }

     


}
