<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AuthController extends CI_Controller {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->library('JwtHandler');
        $this->load->model('Auth_model_jwt', 'auth');
        header("Content-Type: application/json");
    }
    
    public function index()
    {
        echo json_encode([
            'status' => true,
            'service' => 'jwt-authentication-service',
            'version' => 'v3'
        ]);
    }

    // ===============================
    // LOGIN
    // ===============================
    public function login()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        // Ambil data user
        $user = $this->auth->getUserByUsername($username);
        
    
        if (!$user) {
            echo json_encode([
                'status' => false,
                'message' => 'User not found'
            ]);
            return;
        }
       

        $md5  = md5($password);
        $sha1 = sha1($password);
        if (
            $user->PASSWORD !== $md5 &&
            $user->PASSWORD !== $sha1
        ) {
            echo json_encode([
                'status'  => false,
                'message' => 'Password wrong'
            ]);
            return;
        }

        // ===============================
        //  GENERATE TOKEN CUSTOM
        // ===============================
        $dataPayload = [
            'IDPENGGUNA' => $user->IDUSERS,
            'NAMADEPAN'  => $user->USERNAME, // disesuaikan dengan struktur token custom
            'IDJABATAN'  => $user->IDJABATAN ? $user->IDJABATAN : 0,
            'STATUS'     => $user->STATUS ? $user->STATUS : 'AKTIF'
        ];
    
        // Generate token memakai JwtHandler custom
        $token = $this->jwthandler->encodeToken($dataPayload);
    
        // Simpan token ke database (tb_user_app)
        $this->auth->saveToken($user->IDUSERS, $token);
            
            // create log activity login
            $iddata = $user->IDJABATAN;
    		$iduser = $user->IDUSERS;
    		$lokasi = get_user_location();
    		$dataLocation = "User login from location: {$lokasi['lokasi']}, IP: {$lokasi['ip']}, Coordinate: {$lokasi['koordinat']}";
            write_log("Login activity recorded for User ID {$iduser} (Role/Jabatan: {$iddata}). {$dataLocation}", 'login-activity', $iduser);
            
        // Response
        echo json_encode([
            'status'  => true,
            'message' => 'Login success',
            'token'   => $token
        ]);
    }


    // ===============================
    // LOGOUT
    // ===============================
    public function logout()
    {
        $headers = $this->input->request_headers();

        if (!isset($headers['Authorization'])) {
            echo json_encode(['status' => false, 'message' => 'Authorization header missing']);
            return;
        }

        $token = str_replace('Bearer ', '', $headers['Authorization']);

        $deleted = $this->auth->removeToken($token);

        if ($deleted) {
            echo json_encode(['status' => true, 'message' => 'Logout success']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Token is invalid or has expired.']);
        }
    }

    // ===============================
    // CHECK TOKEN
    // ===============================
    public function check_token()
    {
        $headers = $this->input->request_headers();
    
        // Pastikan Authorization header ada
        if (!isset($headers['Authorization'])) {
            echo json_encode(['status' => false, 'message' => 'Authorization header missing']);
            return;
        }
    
        $token = str_replace('Bearer ', '', $headers['Authorization']);
    
        // Cari user berdasarkan token (karena token AES unik per user)
        $user = $this->auth->getUserByToken($token);
    
        if (!$user) {
            echo json_encode(['status' => false, 'message' => 'Token not registered']);
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
