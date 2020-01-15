<?php
class Myclass {
	
	
	public $mysqli;
	
	public function __construct () {
		$this -> mysqli = new mysqli("localhost", "root", "", "bobbleshop");
	
	if ($this -> mysqli -> connect_error){
		die ("connection failed:" .$this -> mysqli -> connect_error);
									}
	
	}
}
?>