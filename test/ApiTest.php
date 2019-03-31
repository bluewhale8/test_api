<?php

use PHPUnit\Framework\TestCase;
require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'model'.DIRECTORY_SEPARATOR.'Api.php';

class ApiTest extends TestCase
{
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        
        $this->api = new Api();
    }
    
    public function testGetKey()
    {
        $this->api->post('test_key', 'test_value');
        
        $this->assertArraySubset(['value' => "test_value"], json_decode($this->api->get('test_key'), true));
        
        $this->api->delete('test_key');
    }
    
    public function testGetNonExistentKey()
    {
        $this->api->delete('test_key');
        
        $this->assertArraySubset(['error' => "not found"], json_decode($this->api->get('test_key'), true));
    }
    
    public function testPostKey()
    {
        $this->assertArraySubset(
            ['result' => "success"],
            json_decode($this->api->post('test_key', 'test_value'), true)
        );
        
        $this->api->delete('test_key');
    }
    
    public function testPostLongKey()
    {
        $this->assertArraySubset(
            ['error' => "key too long"],
            json_decode($this->api->post('my_very_long_key_100000000', 'my_value_for_long_key'), true)
        );
    }
    
    public function testDeleteKey()
    {
        $this->api->post('test_key', 'test_value');
        
        $this->assertArraySubset(
            ['result' => "success"],
            json_decode($this->api->delete('test_key'), true)
        );
    }
    
    public function testDeleteNonExistentKey()
    {
        $this->api->delete('test_key');
        
        $this->assertArraySubset(['error' => "not found"], json_decode($this->api->delete('test_key'), true));
    }
}