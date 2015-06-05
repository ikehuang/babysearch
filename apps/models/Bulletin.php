<?php

class Bulletin extends \Phalcon\Mvc\Model {

	public function initialize() {
		//setSource=table name
		$this->setSource("bulletin");
	}
}