<?php 
class LogActivity extends CI_Model {
    
    public function saveLog($userId, $aksi, $modul) {
        $timezone = $this->session->userdata('user_timezone');
        
        $id_log = substr(md5(uniqid(mt_rand(), true)), 0, 12);
        
        $data = [
            'ID'         => $id_log,
            'USER_ID'    => $userId,
            'AKSI'       => $aksi,
            'MODUL'      => $modul,
            'IP_ADDRESS' => $this->input->ip_address(),
            'USER_AGENT' => $this->input->user_agent(),
            'TIMEZONE'    => $timezone ? $timezone : 'Unknown', 
            'WAKTU'      => date('Y-m-d H:i:s')
        ];
        return $this->db->insert('log_activity', $data);
    }

}
