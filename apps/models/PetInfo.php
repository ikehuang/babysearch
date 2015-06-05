<?php

class PetInfo extends \Phalcon\Mvc\Model {

	public function initialize() {
		//setSource=table name
		$this->setSource("pet_info");
	}
}