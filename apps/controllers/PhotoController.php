<?php

class PhotoController extends \Phalcon\Mvc\Controller {
	
	public function initialize() {
		$this->_request = new \Phalcon\Http\Request();
	}
	
	public function listAction() {
		$serial_number = $this->_request->get('serial_number');
		$device = Device::findFirst("serial_number = '{$serial_number}'");
		$this->view->device = $device;
		$this->view->photo_list = Photos::find("did = '{$device->did}'");
	}
	
	public function createAction(){
		$this->view->disable();
		$this->response->setContentType('application/json', 'UTF-8');
		
		$photo = new Photos();
		
		if($this->request->hasFiles() == true){
			$uploads = $this->request->getUploadedFiles();
			$isUploaded = false;
			foreach($uploads as $upload){
				$path = 'upload/'.md5(uniqid(rand(), true)).'-'.strtolower($upload->getname());
				$blacklog_files[] = $path;
				($upload->moveTo($path)) ? $isUploaded = true : $isUploaded = false;
			}
			
			if($isUploaded) {
				$photo->photo = $path;
			}
		}
		
		$photo->did = $this->_request->getPost('did');

		if ($photo->create() == false) {
			foreach ($photo->getMessages() as $message) {
				$response_data = array(
						"status" => 'fail'
				);
			}
		}
		else {
			$response_data = array(
					"status" => 'success'
			);
		}
			
		$this->response->setContent(json_encode($response_data));
		$this->response->send();
	}
	

	public function deleteAction(){
		$this->view->disable();
		$this->response->setContentType('application/json', 'UTF-8');

		$id = $this->_request->get('id');
		$photo = Photos::findFirst("id = {$id}");
		
		if ($photo->delete() == false) {
			foreach ($photo->getMessages() as $message) {
				$response_data = array(
						"status" => 'fail'
				);
			}
		}
		else {
			$response_data = array(
					"status" => 'success'
			);
		}
		
		$this->response->setContent(json_encode($response_data));
		$this->response->send();
	}
	
}