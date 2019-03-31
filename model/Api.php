<?php

require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'Db.php';

class Api
{
    public function __construct()
    {
        $this->db = new Db();
    }
    
    public function get($key)
    {
        $data = $this->db->get($key);
        
        if (empty($data)) {
            http_response_code(404);
            $result = ['error' => "not found"];
        } else {
            $result = $data;
        }
        
        return json_encode($result);
    }
    
    public function post($key, $value)
    {
        if (strlen($key) > 16) {
            http_response_code(400);
            $result = ['error' => "key too long"];
        } else {
            $this->db->set($key, $value);
            $result = ['result' => "success"];
        }
        
        return json_encode($result);
    }
    
    public function delete($key)
    {
        $count = $this->db->delete($key);
        
        if ($count == 0) {
            http_response_code(404);
            $result = ['error' => "not found"];
        } else {
            $result = ['result' => "success"];
        }
        
        return json_encode($result);
    }
}