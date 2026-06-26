<?php defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require_once APPPATH . '/libraries/REST_Controller.php';
require_once APPPATH . '/libraries/JWT.php';
require_once APPPATH . '/libraries/BeforeValidException.php';
require_once APPPATH . '/libraries/ExpiredException.php';
require_once APPPATH . '/libraries/SignatureInvalidException.php';
use \Firebase\JWT\JWT;

class BD_Controller extends REST_Controller
{
	private $user_credential;
    public function auth()
    {
        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key
        //JWT Auth middleware
        $headers = $this->input->get_request_header('Authorization');
        $kunci = $this->config->item('thekey'); //secret key for encode and decode
        $token= "token";
       	if (!empty($headers)) {
        	if (preg_match('/Bearer\s(\S+)/', $headers , $matches)) {
            $token = $matches[1];
        	}
    	}
        try {
           $decoded = JWT::decode($token, $kunci, array('HS256'));
           $this->user_data = $decoded;
        } catch (Exception $e) {
            $invalid = ['status' => $e->getMessage()]; //Respon if credential invalid
            $this->response($invalid, 401);//401
        }
    }


    public function res($query)
    {
        if ($query !== null) 
        {
            return $status = REST_Controller::HTTP_OK; // OK (200) being the HTTP response code
        } 
        else 
        {
            return $status = REST_Controller::HTTP_NOT_FOUND; // not found
        }

    }


    // ( get id   OR   get all data ) checking data and generate data to json format
    public function printdata($id, $query)
    {
         
           // If the id parameter doesn't exist return all the query

        if ($id === NULL)
        {
            // Check if the query data store contains query (in case the database result returns NULL)
            if ($query)
            {
                // Set the response and exit
                $this->response($query, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else
            {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'No query were found'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }

        // Find and return a single record for a particular user.

        // $id = (int) $id; [ terjadi error ]

        // Validate the id.
        if ($id <= 0)
        {
            // Invalid id, set the response and exit.
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        // Get the res from the array, using the id as key for retrieval.
        // Usually a model is to be used for this.

        $res = NULL;

        if (!empty($query))
        {
            foreach ($query as $key => $value)
            {
                if (isset($value['id']) && $value['id'] === $id)
                {
                    $res = $value;
                }
            }
        }

        if (!empty($res))
        {
            $this->set_response($res, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }
        else
        {
            $this->set_response([
                'status' => FALSE,
                'message' => 'Data could not be found'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
        
    }



    // CUSTOM FUNCTION
   protected function checkKey($keyValue=''){
        $key = $this->key;
        $res = password_verify($key, $keyValue);
        if($key === $keyValue){
            return true;
        } else { return false; }
   }
  
  protected function _res( $code = '' ) {
    if( $code === REST_Controller::HTTP_OK ) { // if res_code = 200
        $response = array('code' => REST_Controller::HTTP_OK, 'status' => 'true', 'info' => 'success');
        // $res = array('res' => $response);
        // return json_encode($res);

        $this->set_response([
                'message' => 'Data could not be found',
                'res'    => $response,
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code

    }
    if( $code === REST_Controller::HTTP_NOT_FOUND ) { // if res_code = 404
        $response = array('code' => REST_Controller::HTTP_NOT_FOUND, 'status' => 'false', 'info' => 'not allowed');
        // $res = array('res' => $response);
        // return json_encode($res);

        $this->set_response([
                'message' => 'Data could not be found',
                'res'    => $response,
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
    }
  }
  
  
  protected function insert($table, $data){
        return $this->db->insert($table, $data);
  }
 // function update($set, $data){
 //     $f = 'id'; $v = '4'; $t = $table;
  //    $this->db->where($f, $v);
  //    $query = $this->db->update($t, $data);
  //    return $query;
//  }
  
  protected function query($select, $table, $where){
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
  

  
  
  
  
/*

CREATE TABLE `cron` (
  `id` int(5) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `command` varchar(255) NOT NULL,
  `interval_sec` int(10) NOT NULL,
  `last_run_at` timestamp NULL DEFAULT current_timestamp(),
  `next_run_at` datetime DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `cron`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `cron`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;
COMMIT;

*/




}