<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model_jwt extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // Ambil user berdasarkan username
    public function getUserByUsername($username)
    {
        $this->db->select('
            tb_user_app.*,
            user_pengguna.*
        ');
        $this->db->from('tb_user_app');
        $this->db->join('user_pengguna', 'user_pengguna.IDPENGGUNA = tb_user_app.IDUSERS', 'left');
        $this->db->where('tb_user_app.USERNAME', $username);
    
        $query = $this->db->get();
    
        // Jika query gagal, tampilkan error
        if (!$query) {
            $error = $this->db->error();
            log_message('error', 'DB Error: '. json_encode($error));
            return false;
        }
    
        return $query->row();
    }

    // Update token ke DB (disimpan di kolom BEARER)
    public function saveToken($userId, $token)
    {
        $this->db->where('IDUSERS', $userId);
        return $this->db->update('tb_user_app', ['BEARER' => $token]);
    }

    // Hapus token (logout)
    public function removeToken($token)
    {
        // Cek apakah token ada
        $this->db->where('BEARER', $token);
        $user = $this->db->get('tb_user_app')->row();

        if (!$user) {
            return false;
        }

        // Hapus token (set null)
        $this->db->where('IDUSERS', $user->IDUSERS);
        return $this->db->update('tb_user_app', ['BEARER' => null]);
    }

    // Ambil user berdasarkan token
    public function getUserByToken($token)
    {
        return $this->db->get_where('tb_user_app', ['BEARER' => $token])->row();
    }
    
    
    
    // untuk check ke semua halaman
    // public function isValidToken()
    // {
    //     $CI =& get_instance();
    //     $CI->load->library('JwtHandler');
    
    //     $headers = $CI->input->request_headers();
    
    //     // Pastikan Authorization Header ada
    //     if (!isset($headers['Authorization'])) {
    //         return false;
    //     }
    
    //     $token = str_replace('Bearer ', '', $headers['Authorization']);
    
    //     // Cek token di database (harus masih aktif)
    //     $user = $this->getUserByToken($token);
    //     if (!$user) {
    //         return false;
    //     }
    
    //     // Decode token berdasarkan key unik user
    //     $decoded = $CI->jwthandler->decodeToken($token, $user->IDUSERS);
    
    //     if (isset($decoded['error'])) {
    //         return false;
    //     }
    
    //     return $decoded; // return data user yang valid
    // }
}
