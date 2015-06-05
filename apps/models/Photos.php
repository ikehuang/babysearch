<?php

class Photos extends \Phalcon\Mvc\Model {

	public function initialize() {
		//setSource=table name
		$this->setSource("photos");
	}
}

/**
<form>
 <?php
 foreach($photos as $p) {
	echo " <input type='file' name='file[{$p->id}]'/>";
	echo " <input type='file' name='file[{$p->id}]'/>";
	echo " <input type='file' name='file[{$p->id}]'/>";
	echo " <input type='file' name='file[{$p->id}]'/>";
	echo " <input type='file' name='file[{$p->id}]'/>";
	echo " <input type='file' name='file[{$p->id}]'/>";
	echo " <input type='file' name='file[{$p->id}]'/>";
	echo " <input type='file' name='file[{$p->id}]'/>";
	
}
 ?>

</form>

file[1]
file[2]
file[3]
file[4]
**/