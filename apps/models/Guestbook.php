<?php

class Guestbook extends \Phalcon\Mvc\Model {

	public function initialize() {
		//setSource=table name
		$this->setSource("guestbook");
	}
}