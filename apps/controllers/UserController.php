<?php

class UserController extends \Phalcon\Mvc\Controller {

	private $_imei;
	private $_token;
	private $_api_key;
	private $_email;
	private $_sso_id;
	
	//private $_test_imei;
	//private $_test_token;
	//private $_test_key;
	//private $_test_email;
	
	private $_apikey;
	
	public function initialize() {
		$this->_request = new \Phalcon\Http\Request();
		
		//$this->view->disable();
		//$this->response->setContentType('application/json', 'UTF-8');
		$this->_imei = $this->_request->getPost('imei');
		$this->_token = $this->_request->getPost('token');
		$this->_email = strtolower($this->_request->getPost('email'));
		$this->_api_key = $this->_request->getPost('api_key');
		$this->_sso_id = $this->_request->getPost('sso_id');
		
		//test code for getting data
		//$this->_test_api_key = $this->_request->get('api_key');
		//$this->_test_email = strtolower($this->_request->get('email'));
		//$this->_test_token = $this->_request->get('token');
		//$this->_test_imei = $this->_request->get('imei');
		
	}
	
	public function indexAction() {
		$device_list = array();
		
		//find user info and all devices belong to the user
		$user = User::findFirst("email = '{$_SESSION['USER']['INFO']['email']}'");
		
		$devices = Device::find("email = '{$_SESSION['USER']['INFO']['email']}'");
		
		foreach ($devices as $device) {
			$device_list[] = $device;
		}
		
		$this->view->setVar("user", $_SESSION['USER']['INFO']);
		$this->view->setVar("device_list", $device_list);
	}
	
	public function loginAction() {
		$this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_ACTION_VIEW);
		$config = new \Phalcon\Config\Adapter\Ini("../apps/config/config.ini");
		
		//$this->view->setVar("config", $config);
		$this->view->config = $config;
	}
	
	public function checkEmailExistsAction() {
		
		$this->view->disable();
		$this->response->setContentType('application/json', 'UTF-8');
		
		$result = User::find("email = '{$_POST["formKey"]}'");
		
		if($result->count() > 0) {
			$status = 'success';
		}
		else {
			$status = 'fail';
				
		}
		$response_data = array(
				'status' => $status
		);
		
		$this->response->setContent(json_encode($response_data));
		$this->response->send();
	}
	
	public function createAction(){
		
		$bulletin_message = "";
		
		$response_data = array(
				'status' => 'fail',
				'bulletin_message' => $bulletin_message
		);
				
		//sample data to create user
		//$this->_api_key = 'qwe123';
		//$this->_apikey = 'qwe123';
		//$this->_email = 'terry@ink.net.tw';
		
		//$test_fullname = 'David Beckham';
		//$test_phone = '91233456';
		//$test_address = '1 UK';
		//$test_nickname = 'DB7';
		
		//sample data to create mobile
		//$this->_imei = '123457392038576';
		//$this->_sso_id = '678957392038576';
		//$this->_token = '678942940015970|tcOoRAAQrWcDm_84h3O7NN7Z9DM';
		
		//if api_key match, continue...; otherwise, return fail
		if($this->_api_key == $this->_apikey) {
			
			//get the newest message from bulletin
			$bulletin = Bulletin::findFirst();
			$bulletin_message = $bulletin->message;
			
			//if email doesn't exist, then continue to create user...; otherwise, return fail
			if(User::count("email = '{$this->_email}'") == 0) {
				
				$user = new User();
				
				$user->email = $this->_email;
				
				//optional?
				//$user->fullname = $test_fullname;
				//$user->phone = $test_phone;
				//$user->address = $test_address;
				//$user->nickname = $test_nickname;
				
				if($user->create() == false) {
					$message = "Failed to create user. Please refer to return message for possible errors.\n";
				
					foreach($user->getMessages() as $msg) {
						$message = $msg . "\n";
					}
				}
				else {
					$message = "User created successfully.\n";
					
					$response_data = array(
							'status' => 'success',
							'bulletin_message' => $bulletin_message
					);
				}
			}
			//else {
			//	$message = "Failed to create user. Email existed\n";
			//}
			
			//create mobile
			
			//if sso_id doesn't exist, then continue to create mobile...; otherwise, return fail
			if(Mobile::count("sso_id = '{$this->_sso_id}'") == 0) {
			//if imei doesn't exist, then continue to create mobile...; otherwise, return fail
			//if(Mobile::count("imei = '{$this->_imei}'") == 0) {
			
				//sample data to create mobile
				$mobile = new Mobile();
				
				$mobile->imei = $this->_imei;
				$mobile->token = $this->_token;
				$mobile->email = $this->_email;
				$mobile->sso_id = $this->_sso_id;
				
				if($mobile->create() == false) {
					$message = "Failed to create mobile. Please refer to return message for possible errors.\n";
				
					foreach($mobile->getMessages() as $msg) {
						$message = $msg . "\n";
					}
				}
				else {
					$message = "Mobile created successfully\n";
					
					$response_data = array(
							'status' => 'success',
							'bulletin_message' => $bulletin_message
					);
				}
			}
			else {
				$message = "Failed to create mobile. SSO_ID existed\n";
			}
		}
		
		$this->response->setContent(json_encode($response_data));
		$this->response->send();
	}
	
	public function updateAction(){
		
		//still need to get user email from session/login
		//sample data
		$email = "watson@ink.net.tw";
			
		//find user with given email
		$user = User::findFirst("email = '{$email}'");
		
		$request = new \Phalcon\Http\Request();
		
		//determine if getting or posting data
		if ($request->isPost() == true) {
			
			$this->view->disable();
			$this->response->setContentType('application/json', 'UTF-8');
			
			$firstname = $this->_request->getPost('firstname');
			$lastname = $this->_request->getPost('lastname');
			$address = $this->_request->getPost('address');
			$phone = $this->_request->getPost('phone');
			$nickname = $this->_request->getPost('nickname');
			$birthday = $this->_request->getPost('birthday');
			$sex = $this->_request->getPost('sex');
			//$photo = $this->_request->getPost('photo');
			
			$user->fullname = $firstname .  '' . $lastname;
			$user->phone = $phone;
			$user->address = $address;
			$user->nickname = $nickname;
			$user->birthday = $birthday;
			$user->sex = $sex;
			//$user->photo = $photo;
			
			$user->update();
		}
		else {
					
			$this->view->setVar("user", $user);
		}
	}
	
	public function deleteAction(){
		
		$response_data = array(
				'status' => 'fail'
		);
		
		//sample data to delete user
		//$this->_api_key = 'qwe123';
		//$this->_apikey = 'qwe123';
		//$this->_email = 'brucelee@gmail.com';
		
		//if api_key match, continue...; otherwise, return fail
		if($this->_api_key == $this->_apikey) {

			//if email exists, delete user, delete mobile, delete device...; otherwise, return fail
			if(User::count("email = '{$this->_email}'") > 0) {
			
				$user = User::findFirst("email = '{$this->_email}'");
				
				if($user->delete() == false) {
					$message = "Failed to delete. Please refer to return message for possible errors.\n";
				
					foreach($user->getMessages() as $msg) {
						$message = $msg . "\n";
					}
				}
				else {
					$message = "User deleted successfully.\n";
					
					//delete mobiles
					if(Mobile::count("email = '{$this->_email}'") > 0) {
					
						foreach (Mobile::find("email = '{$this->_email}'") as $mobile) {
							if ($mobile->delete() == false) {
								$message = "Sorry, we can't delete the mobile right now: \n";
								foreach ($mobile->getMessages() as $msg) {
									$message = $msg . "\n";
								}
							}
							else {
								$message = "Mobile deleted successfully.\n";
							}
						}
					}
					
					//delete devices
					if(Device::count("email = '{$this->_email}'") > 0) {
							
						foreach (Device::find("email = '{$this->_email}'") as $device) {
							if ($device->delete() == false) {
								$message = "Sorry, we can't delete the device right now: \n";
								foreach ($device->getMessages() as $msg) {
									$message = $msg . "\n";
								}
							}
							else {
								$message = "Device deleted successfully.\n";
							}
						}
					}
					
					//delete contacts
					$lost_contacts = LostContacts::find("email = '{$this->_email}'");
					
					foreach (LostContacts::find("email = '{$this->_email}'") as $lost_contact) {
						$lost_contact->delete();
					}

					$response_data = array(
							'status' => 'success'
					);
				}
			}

			/*
			//check if mobile existed...
			if(Mobile::count(array("email = '{$this->_email}'", "token = '{$this->_token}'", "imei = '{$this->_imei}'")) > 0) {
		
				//sample data
				//$id = $this->_request->get('id');
				
				$user = User::findFirst("email = '{$this->_email}'");
				
				if($user->delete() == false) {
					$message = "Failed to delete. Please refer to return message for possible errors.\n";
				
					foreach($user->getMessages() as $msg) {
						$message = $msg . "\n";
					}
				}
				else {
					$message = "User deleted successfully.\n";
				}
				
				//need to connect $message to $response_data...
				
				$response_data = array(
						'status' => 'success'
				);
			}*/
		}
		
		$this->response->setContent(json_encode($response_data));
		$this->response->send();
	}

	public function createContactsAction() {
		$firstnames = $this->_request->getPost('firstname');
		$lastnames = $this->_request->getPost('lastname');
		$phones = $this->_request->getPost('phone');
		
		$response_data = array(
				'status' => 'fail'
		);
		
		//sample code
		//$this->_api_key = 'qwe123';
		//$this->_apikey = 'qwe123';
		//$firstnames[1] = "david";
		//$lastnames[1] = "beckham";
		//$phones[1] = "012948123";
		//$firstnames[2] = "john";
		//$lastnames[2] = "doe";
		//$phones[2] = "555948123";
		//$firstnames[3] = "alan";
		//$lastnames[3] = "tam";
		//$phones[3] = "999948123";
		//$this->_email = "brucelee@gmail.com";
		
		
		//if api_key match, continue...; otherwise, return fail
		if($this->_api_key == $this->_apikey) {
			
			//if email doesn't exist, then continue...; otherwise, return fail
			if(LostContacts::count("email = '{$this->_email}'") == 0) {
			
				//Assume firstname is required here...
				if(!empty($firstnames)) {
					
					foreach($firstnames as $k => $v) {

						if(!empty($firstnames[$k]) || !empty($lastnames[$k]) || !empty($phones[$k])) {
							
							$lost_contact = new LostContacts();
							$lost_contact->firstname = $firstnames[$k];
							$lost_contact->lastname = $lastnames[$k];
							$lost_contact->phone = $phones[$k];
							$lost_contact->email = $this->_email;
							$lost_contact->create();
						}
					}
				}
				
				$response_data = array(
						'status' => 'success'
				);
			}
		}
		
		$this->response->setContent(json_encode($response_data));
		$this->response->send();
		/**
		 *
		 * <input type='text' name='firstname[1]'/>
		 *  <input type='text' name='lastname[1]'/>
		 *   <input type='text' name='phone[1]'/>
		 *
		 * <input type='text' name='firstname[2]'/>
		 *  <input type='text' name='lastname[2]'/>
		 *   <input type='text' name='phone[2]'/>
		 *
		 *
		 * <input type='text' name='firstname[3]'/>
		 *  <input type='text' name='lastname[3]'/>
		 *   <input type='text' name='phone[3]'/>
		 */
	}
	
	public function updateContactAction() {
		if ($this->_request->isPost() == true) {
			$this->view->disable();
			$this->response->setContentType('application/json', 'UTF-8');
			$firstnames = $this->_request->getPost('firstname');
			$lastnames = $this->_request->getPost('lastname');
			$phones = $this->_request->getPost('phone');
		
			$response_data = array(
					'status' => 'fail'
			);
		
			foreach($firstnames as $r) {
		
				//Assume firstname is required here...
				if(!empty($firstnames)) {
				
					foreach($firstnames as $k => $v) {
		
						$lost_contact = LostContacts::findFirst("id = '{$k}'");
								
						$lost_contact->firstname = $firstnames[$k];
						$lost_contact->lastname = $lastnames[$k];
						$lost_contact->phone = $phones[$k];
						$lost_contact->update();
					}
				
					$response_data = array(
							'status' => 'success'
					);
				}
			}
		
			$this->response->setContent(json_encode($response_data));
			$this->response->send();
		}
		else {
			$this->view->contacts = LostContacts::find("email  = '{$_SESSION['USER']['INFO']['email']}'");
		}
	}
	
	/*
	public function loginAction(){
		
		$user_info = array("fullname" =>"Franky Li", "phone" => "90123456", "address" => "China", "email" => "franky@ink.net.tw", "nickname" => "franky");
		
		$response_data = array(
				'status' => 'fail',
				'user_info' => $user_info
		);
		
		//if api_key match, continue...; otherwise, return fail
		if($this->_api_key == $this->_apikey) {
			
			//check if mobile existed...		
			if(Mobile::count(array("conditions" => "email = '{$this->_email}' AND token = '{$this->_token}' AND imei = '{$this->_imei}'")) > 0) {
				
				//replace old token with new if needed as per request
				//
				$mobile = Mobile::findFirst(array("email = '{$this->_email}'", "imei = '{$this->_imei}'"));
				$mobile->token = $this->_token;
				if($mobile->save() == false) {
					$message = "Failed to save new token. Please refer to return message for possible errors.\n";
				
					foreach($mobile->getMessages() as $msg) {
						$message = $msg . "\n";
					}
				}
				else {
					$message = "New token saved successfully.\n";
				}
				//
				
				//fill user_info with given email
				$user = User::findFirst("email = '{$this->_email}'");
				
				$user_info = array("fullname" =>$user->fullname, "phone" => $user->phone, "address" => $user->address, "email" => $user->email, "nickname" => $user->nickname);
			
				$response_data = array(
					'status' => 'success',
					'user_info' => $user_info
				);
			}
		}
		
		//orig.

		//$user_info = array("fullname" =>"Franky", "address" => "China", "email" => "franky@ink.net.tw");

		$response_data = array(
			'status' => 'success',
			'user_info' => $user_info
		);

		$this->response->setContent(json_encode($response_data));
		$this->response->send();
	}
	*/
	
	/*
	 public function updateTokenAction(){
	
	$new_token = $this->_request->getPost('new_token');
	
	$response_data = array(
			'status' => 'fail'
	);
	
	//sample data
	//$new_token = '123442940015970|tcOoRAAQrWcDm_84h3O7NN7Z9DM';
	
	//if api_key match, continue...; otherwise, return fail
	if($this->_api_key == $this->_apikey) {
		
	//if email-imei pair exists in the system, then continue...; otherwise, fail.
	if(Mobile::count(array("conditions" => "email = '{$this->_email}' AND imei = '{$this->_imei}'")) > 0) {
	
	$device = Mobile::findFirst("email = '{$this->_email}' AND imei = '{$this->_imei}'");
	
	$device->token = $new_token;
	
	if($device->update() == false) {
	$message = "Failed to update. Please refer to return message for possible errors.\n";
	
	foreach($device->getMessages() as $msg) {
	$message = $msg . "\n";
	}
	}
	else {
	$message = "User updated successfully.\n";
		
	$response_data = array(
			'status' => 'success'
	);
	}
	}
	}
	
	$this->response->setContent(json_encode($response_data));
	$this->response->send();
	}
	*/
	
	public function logoutAction() {
		$this->view->disable();
		$this->session->destroy();
		unset($_SESSION['INFO']);
		header('Location: /');
	}
}