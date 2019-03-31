<?php

class Db
{
    public function __construct()
    {
        $settings = $this->getPDOSettings();
        
        try {
            $this->dbh = new PDO($settings['dsn'], $settings['user'], $settings['pass']);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
    
    private function getPDOSettings()
    {
        
        $config = require dirname(
                __FILE__
            ).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'DB.php';
        
        $result['dsn'] = "{$config['type']}:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}";
        $result['user'] = $config['user'];
        $result['pass'] = $config['pass'];
        
        return $result;
    }
    
    public function get($key)
    {
        $sth = $this->dbh->prepare("SELECT `value` FROM storage WHERE `key` = ?");
        $sth->execute([$key]);
        $row = $sth->fetch(PDO::FETCH_ASSOC);
        
        return $row;
    }
    
    public function set($key, $value)
    {
        $sth = $this->dbh->prepare(
            "INSERT INTO storage (`key`, `value`) VALUES (?, ?) ON DUPLICATE KEY UPDATE `value`=?"
        );
        $sth->execute([$key, $value, $value]);
    }
    
    public function delete($key)
    {
        $sth = $this->dbh->prepare("DELETE FROM storage WHERE `key` = ?");
        $sth->execute([$key]);
        
        return $sth->rowCount();
    }
    
}

