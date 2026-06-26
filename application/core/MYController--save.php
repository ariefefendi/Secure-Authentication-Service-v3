<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '/libraries/REST_Controller.php';

class MYController extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->userdata = $this->session->userdata('userdata');
    $this->session->set_flashdata('segment', explode('/', $this->uri->uri_string()));
  }


  public function check_login()
  {
    // pengecekan jika tidak ada email dari session maka diarahkan untuk login
    if (!$this->session->userdata('is_login')) {
      redirect('auth/login');
    }
  }

  public function updateProfil()
  {
    if ($this->userdata != '') {
      $data = $this->Auth_model->select($this->userdata->id);
      $this->session->set_userdata('userdata', $data);
      $this->userdata = $this->session->userdata('userdata');
    }
  }

  protected function keycron(){
    $this->config->load('confcompany', TRUE);
    $keyCron = $this->config->item('key_cronjob', 'confcompany');
    return $keyCron;
  }
  protected function checkKey($keyValue=''){
    $key = $this->keycron();
    $hash = password_hash($keyValue, PASSWORD_DEFAULT);
    if(password_verify($key, $hash)) {
      return true;
    } else { return false; }
  }
  protected function res($code = '', $data = '') {
    if($code === REST_Controller::HTTP_OK ) {//200
      $response = array('code' => REST_Controller::HTTP_OK, 'status' => 'true', 'info' => 'success', 'data' => $data);
      $res = array('res' => $response);
      echo $res = json_encode($res);
    }
    if($code === REST_Controller::HTTP_NOT_FOUND ) {//404
      $response = array('code' => REST_Controller::HTTP_NOT_FOUND, 'status' => 'false', 'info' => 'not allowed', 'data' => $data);
      $res = array('res' => $response);
      echo $res = json_encode($res);
    }
    if($code === REST_Controller::HTTP_NO_CONTENT ) {//204
      $response = array('code' => REST_Controller::HTTP_NO_CONTENT, 'status' => 'false', 'info' => 'no content', 'data' => $data);
      $res = array('res' => $response);
      echo $res = json_encode($res);
    }
  }
  protected function insert($table, $data){
    return $this->db->insert($table, $data);
  }
  protected function delete($table, $data, $param){
    $field = $param; $value = $data[$param];
    $this->db->where($field, $value);
    return $this->db->delete($table);
  }
  protected function multidelete($table1, $table2, $data, $param){
    $tables = array($table1, $table2);
    $field = $param; $value = $data[$param];
    $this->db->where($field, $value);
    return $this->db->delete($tables);
  }
  protected function update($table, $data, $param){
    $field = $param; $value = $data[$param];
    $this->db->where($field, $value);
    $query = $this->db->update($table, $data);
    return $query;
  }
  protected function query($select, $table, $where = ''){
    if($where == ""){ $where = ''; } else { $where = "WHERE ".$where; }
    return $sql = $this->db->query("SELECT ".$select." FROM ".$table.' '.$where);
  }
  protected function resDataAll($sql, $queryAll) {
    $data = $sql->result();
    $total = $queryAll->num_rows();
    $dataRecord = array(
      "RecordsTotal" => $total,
      "RecordsFiltered" => $total,
      "Data" => $data,
    );
    return $res = json_encode( $dataRecord );
  }
  protected function resultSelect($sql){
    $res = $sql->result(); return json_encode($res = array('res'=>$res));
  }



}
