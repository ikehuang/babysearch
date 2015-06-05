<?php

class Category extends \Phalcon\Mvc\Model {

	public function initialize(){
		
		$this->setSource("categories");
		
	}
}