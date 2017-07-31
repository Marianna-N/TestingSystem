<?php
//declare(strict_types=1);

class DataBase
{	
	private $connection = null;
	
	// Use MySQL::getInstance() to get an object.
	public static function getInstance() : DataBase
    {
        static $instance = null;
        if (is_null($instance)) {
            $instance = new DataBase();
			$instance->establishConnection();
        }
        return $instance;
    }

	// This method is called from getInstance() to establish MySQL connection.
	public function establishConnection() : void
	{
		$this->connection = new PDO('mysql:dbname='.CONFIG_DB_NAME.';host='.CONFIG_DB_HOST.';charset='.CONFIG_DB_CHAR, CONFIG_DB_USER, CONFIG_DB_PASS);
	}
	
	public function query($sql){
		return $this->connection->query($sql);
	}
	
	public function prepare($sql){
		return $this->connection->prepare($sql);
	}
	
	public function completeQuery($sql){
		$request = $this->connection->prepare($sql);
		$request->execute();
		$result = $request->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}
	
	

}
