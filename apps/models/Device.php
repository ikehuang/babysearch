<?php

class Device extends \Phalcon\Mvc\Model {

	public function initialize(){
	
		$this->setSource("devices");
		
	}
}