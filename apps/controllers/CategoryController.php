<?php

class CategoryController extends \Phalcon\Mvc\Controller {

	private $_imei;
	private $_token;
	private $_api_key;
	private $_email;
	
	//private $_test_imei;
	//private $_test_token;
	//private $_test_key;
	//private $_test_email;
	
	private $_apikey;
	
	public function initialize() {
		$this->_request = new \Phalcon\Http\Request();
		
		$this->view->disable();
		$this->response->setContentType('application/json', 'UTF-8');
		$this->_imei = $this->_request->getPost('imei');
		$this->_token = $this->_request->getPost('token');
		$this->_email = strtolower($this->_request->getPost('email'));
		$this->_api_key = $this->_request->getPost('api_key');
		
		//test code for getting data
		//$this->_test_api_key = $this->_request->get('api_key');
		//$this->_test_email = strtolower($this->_request->get('email'));
		//$this->_test_token = $this->_request->get('token');
		//$this->_test_imei = $this->_request->get('imei');
		
		//to check api-key with config
		$config = new \Phalcon\Config\Adapter\Ini("../apps/config/config.ini");
		$this->_apikey = $config->api->apikey;
	}
	
	public function listAction() {
		$name = $this->_request->getPost('category');
		
		$category_list = array();
		
		$response_data = array(
				'status' => 'fail',
				'$category_list' => $category_list
		);
		
		//sample data
		//$name = 'valuable';
		
		//if api_key match, continue...; otherwise, return fail
		if($this->_api_key == $this->_apikey) {
			
			//if category name exists, continue...; otherwise, return fail
			if(Category::count("name = '{$name}'") > 0) {
				
				//list sub-category under given category name
				$category = Category::findFirst("name = '{$name}'");
				
				$categories = Category::find(array("parent_id = '{$category->cid}'", "columns" => "name"));
				
				foreach ($categories as $c) {
					$category_list[] = $c;
				}
				
				$response_data = array(
						'status' => 'success',
						'$category_list' => $category_list
				);
			}
		}
		
		$this->response->setContent(json_encode($response_data));
		$this->response->send();
	}
	/**
	public function createAction(){
		
		$response_data = array(
				'status' => 'fail'
		);
		
		$name = $this->_request->getPost('name');
		
		//sample data
		$name = 'valuables';
	
		//if api_key match, continue...; otherwise, return fail
		if($this->_api_key == $this->_apikey) {
		
			//if name doesn't exist, then continue to create category...; otherwise, return fail
			if(Category::count("name = '{$name}'") == 0) {
			
				//sample data
				$category = new Category();
				
				$category->name = $name;
				
				if($category->create() == false) {
					$message = "Failed to create. Please refer to return message for possible errors.\n";
				
					foreach($category->getMessages() as $msg) {
						$message = $msg . "\n";
					}
				}
				else {
					$message = "Category created successfully.\n";
					
					//need to connect $message to $response_data...
					
					$category_info = array("name");
					
					$response_data = array(
							'status' => 'success'
					);
				}
			}
			else {
				$message = "Failed to create category. Category name existed\n";
			}
		}
		
		$this->response->setContent(json_encode($response_data));
		$this->response->send();
	}
	
	public function updateAction(){
		
		$category_info = array("name");
		
		$response_data = array(
				'status' => 'fail',
				'category_info' => $category_info
		);
		
		$name = $this->_request->getPost('name');
		
		$name = 'pets';
		
		//if api_key match, continue...; otherwise, return fail
		if($this->_api_key == $this->_apikey) {
			
			//if name doesn't exist, then continue to create category...; otherwise, return fail
			if(Category::count("name = '{$name}'") == 0) {
				
				//sample data...update category name or id?				
				$category = Category::findFirst("name = '{$name}'");
				
				//var_dump($category);
				
				$category->name = $name;
				
				if($category->update() == false) {
					$message = "Failed to update. Please refer to return message for possible errors.\n";
				
					foreach($category->getMessages() as $msg) {
						$message = $msg . "\n";
					}
				}
				else {
					$message = "Category updated successfully.\n";
					
					//need to connect $message to $response_data...
					
					$category_info = array("name");
					
					$response_data = array(
							'status' => 'success',
							'category_info' => $category_info
					);
				}
			}
		}
		
		$this->response->setContent(json_encode($response_data));
		$this->response->send();
	}
	
	public function deleteAction(){
		
		$response_data = array(
				'status' => 'fail'
		);
		
		//if api_key match, continue...; otherwise, return fail
		if($this->_api_key == $this->_apikey) {
		
			//sample data
			$id = $this->_request->get('id');
			
			$category = Category::findFirst("cid = '{$id}'");
			
			if($category->delete() == false) {
				$message = "Failed to delete. Please refer to return message for possible errors.\n";
			
				foreach($category->getMessages() as $msg) {
					$message = $msg . "\n";
				}
			}
			else {
				$message = "Category deleted successfully.\n";
				
				//need to connect $message to $response_data...
					
				$response_data = array(
						'status' => 'success'
				);
			}
		}
		
		$this->response->setContent(json_encode($response_data));
		$this->response->send();
	}
	**/
	
}