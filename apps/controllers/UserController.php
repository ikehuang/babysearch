<?php

class UserController extends \Phalcon\Mvc\Controller {

	private $_imei;
	private $_token;
	private $_api_key;
	private $_email;
	private $_sso_id;
	private $_config;
	
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

		$config = new \Phalcon\Config\Adapter\Ini("../apps/config/config.ini");
		$this->_config = $config;
		//test code for getting data
		//$this->_test_api_key = $this->_request->get('api_key');
		//$this->_test_email = strtolower($this->_request->get('email'));
		//$this->_test_token = $this->_request->get('token');
		//$this->_test_imei = $this->_request->get('imei');
		
	}
	
	public function indexAction() {
		
		$device_list = array();
		
		//find user info and all devices belong to the user
		$user = User::findFirst("sso_id = '{$_SESSION['USER']['INFO']['sso_id']}'");
		//$user = User::findFirst("email = '{$_SESSION['USER']['INFO']['email']}'");
		
		$devices = Device::find("sso_id = '{$_SESSION['USER']['INFO']['sso_id']}'");
		//$devices = Device::find("email = '{$_SESSION['USER']['INFO']['email']}'");
		
		foreach ($devices as $device) {
			$result = Guestbook::find("did = {$device->did} and checked is null");
			$device->notification_count = $result->count();
			$device_list[] = $device;
		}
		
		//$this->view->setVar("user", $_SESSION['USER']['INFO']);
		$this->view->setVar("user", $user);
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
		
		$app = $this->_request->get('app');
		
		if(!empty($app))
			$this->view->setVar("app", $app);
		
		//still need to get user email from session/login
		//sample data
		//$email = "watson@ink.net.tw";
		
		$this->_sso_id = $_SESSION['USER']['INFO']['sso_id'];
		
		$user = User::findFirst("sso_id = '{$this->_sso_id}'");
		//find user with given email
		//$user = User::findFirst("email = '{$email}'");
		
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
			
			$city = $this->_request->getPost('city');
			$district = $this->_request->getPost('district');
			$postal = $this->_request->getPost('postal');
			$country = $this->_request->getPost('country');
			
			$user->fullname = $firstname .  '' . $lastname;
			$user->firstname = $firstname;
			$user->lastname = $lastname;
			$user->phone = $phone;
			$user->address = $address;
			$user->nickname = $nickname;
			$user->birthday = $birthday;
			$user->sex = $sex;
			//$user->photo = $photo;
			
			$user->city = $city;
			$user->district = $district;
			$user->postal = $postal;
			$user->country = $country;
			
			//for uploading user photo
			// Check if the user has uploaded files
			if($this->request->hasFiles() == true){
				$uploads = $this->request->getUploadedFiles();
				$isUploaded = false;
				foreach($uploads as $upload){
					$path = 'upload/'.md5(uniqid(rand(), true)).'-'.strtolower($upload->getname());
					($upload->moveTo($path)) ? $isUploaded = true : $isUploaded = false;
				}
					
				if($isUploaded) {
					$user->photo = "http://{$_SERVER['HTTP_HOST']}/" . $path;
				}
			}
			/*
			if($this->request->hasFiles() == true){
				$uploads = $this->request->getUploadedFiles();
				$isUploaded = false;
					
				foreach($uploads as $upload){
			
					//Move the file into the application
					$path = 'upload/'.md5(uniqid(rand(), true)).'-'.strtolower($upload->getname());
					($upload->moveTo($path)) ? $isUploaded = true : $isUploaded = false;
			
					if($isUploaded) {
						if(preg_match("/photo/",$upload->getKey())) {
							 
							//strip from input key(eg.photos.1) to get id
							$newkey = preg_replace("/^photos./","",$upload->getKey());
			
							$user->photo = "http://{$_SERVER['HTTP_HOST']}/".$path;
			
							$photo = $user->photo;
						}
					}
				}
			}*/
			
			$user->update();
			
			$response_data = array(
					'status' => 'success'
			);
			
			$this->response->setContent(json_encode($response_data));
			$this->response->send();
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
	}
	
	public function updateContactAction() {
		if ($this->_request->isPost() == true) {
			$this->view->disable();
			$this->response->setContentType('application/json', 'UTF-8');
			$firstnames = $this->_request->getPost('firstname');
			$lastnames = $this->_request->getPost('lastname');
			$names = $this->_request->getPost('name');
			$phones = $this->_request->getPost('phone');
		
			$response_data = array(
					'status' => 'fail'
			);
		/*
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
			*/
			foreach($names as $r) {
			
				//Assume firstname is required here...
				if(!empty($names)) {
			
					foreach($names as $k => $v) {
			
						$lost_contact = LostContacts::findFirst("id = '{$k}'");
			
						//$lost_contact->firstname = $firstnames[$k];
						//$lost_contact->lastname = $lastnames[$k];
						$lost_contact->name = $names[$k];
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
			//$this->view->contacts = LostContacts::find("email  = '{$_SESSION['USER']['INFO']['email']}'");
			$this->view->contacts = LostContacts::find("sso_id  = '{$_SESSION['USER']['INFO']['sso_id']}'");
		}
	}
	
	public function logoutAction() {
		$this->view->disable();
		$login_type = $_SESSION['USER']['INFO']['login_type'];
		$access_token = $_SESSION['USER']['INFO']['access_token'];
		$this->session->destroy();
		unset($_SESSION);
		
		if($login_type == 'facebook') {
			header("Location: https://www.facebook.com/logout.php?next=http://{$_SERVER['HTTP_HOST']}&access_token={$access_token}");
			die();
		}
		
		if($login_type == 'google') {
			
			$revokeURL = "https://accounts.google.com/o/oauth2/revoke?token=".$access_token;
			
			$ch = curl_init();
			$options = array(
					CURLOPT_URL => $revokeURL,
					CURLOPT_HEADER  =>  true,
					CURLOPT_RETURNTRANSFER  =>  true,
					CURLOPT_SSL_VERIFYPEER => true, //verify HTTPS
					CURLOPT_SSL_CIPHER_LIST => 'TLSv1'); //remove this line if curl SSL error
			
			curl_setopt_array($ch, $options); //setup
			
			$response = curl_exec($ch); //run
					
			header("Location: /");
			die();
		}
		
		header("Location: /");
		exit;
	}
	
	public function facebookAction() {
		$this->view->disable();
		$facebook_code = $_GET['code'];
		$access_token = $this->getFacebookAccessToken($facebook_code);
		$user_info = $this->getFacebookUserInfo($access_token);

		//if email doesn't exist, then continue to create user...; otherwise, return fail
		if(User::count("sso_id = '{$user_info->id}'") == 0) {
		
			$user = new User();
		
			$user->email = $user_info->email;
			$user->sso_id = $user_info->id;
			$user->nickname = $user_info->name;
		
			$user->create();
			
			//create contact
			for($i = 0 ;$i < 3;$i++ ) {
				$lost_contact = new LostContacts();
				$lost_contact->firstname = '';
				$lost_contact->lastname = '';
				$lost_contact->phone = '';
				$lost_contact->email = '';
				$lost_contact->sso_id = $user->sso_id;
				$lost_contact->create();
			}
			
		}
		else {
			$user = User::findFirst("sso_id = '{$user_info->id}'");

			$user->email = $user_info->email;
			$user->nickname = $user_info->name;
				
			$user->update();
		}
		
		$_SESSION['USER']['INFO']['login_type'] = 'facebook';
		$_SESSION['USER']['INFO']['email'] = $user->email;
		$_SESSION['USER']['INFO']['sso_id'] = $user->sso_id;
		$_SESSION['USER']['INFO']['nickname'] = $user->nickname;
		$_SESSION['USER']['INFO']['access_token'] = $access_token;
		
		if(Mobile::count("sso_id = '{$user_info->id}'") == 0) {
			$mobile = new Mobile();
		
			$mobile->email = $user_info->email;
			$mobile->sso_id = $user_info->id;
			$mobile->access_token = $access_token;
		
			$mobile->create();
		}
		else {
			$mobile = Mobile::findFirst("sso_id = '{$user_info->id}'");
			
			$mobile->access_token = $access_token;
			
			$mobile->update();
		}
		

		return $this->response->redirect("user/index");
	}
	

	public function googleAction() {
		$this->view->disable();
		$google_code = $_GET['code'];
		$access_token = $this->getGoogleAccessToken($google_code);
		$user_info = $this->getGoogleUserInfo($access_token);
		//$user_info->id = "10207116136561047";
		//$user_info->email = "terry.hk796@gmail.com";
	
		//if email doesn't exist, then continue to create user...; otherwise, return fail
		if(User::count("sso_id = '{$user_info->id}'") == 0) {
	
			$user = new User();
	
			$user->email = $user_info->email;
			$user->sso_id = $user_info->id;
			$user->nickname = $user_info->name;
	
			$user->create();
			
			//create contact
			for($i = 0 ;$i < 3;$i++ ) {
				$lost_contact = new LostContacts();
				$lost_contact->firstname = '';
				$lost_contact->lastname = '';
				$lost_contact->phone = '';
				$lost_contact->email = '';
				$lost_contact->sso_id = $user->sso_id;
				$lost_contact->create();
			}
		}
		else {
			$user = User::findFirst("sso_id = '{$user_info->id}'");
			
			$user->email = $user_info->email;
			$user->nickname = $user_info->name;
			
			$user->update();
		}

		$_SESSION['USER']['INFO']['login_type'] = 'google';
		$_SESSION['USER']['INFO']['email'] = $user->email;
		$_SESSION['USER']['INFO']['sso_id'] = $user->sso_id;
		$_SESSION['USER']['INFO']['nickname'] = $user->nickname;
		$_SESSION['USER']['INFO']['access_token'] = $access_token;
	
		if(Mobile::count("sso_id = '{$user_info->id}'") == 0) {
			$mobile = new Mobile();
	
			$mobile->email = $user_info->email;
			$mobile->sso_id = $user_info->id;
			$mobile->access_token = $access_token;
			
			$mobile->create();
		}
		else {
			$mobile = Mobile::findFirst("sso_id = '{$user_info->id}'");
				
			$mobile->access_token = $access_token;
				
			$mobile->update();
		}
	
		var_dump($_SESSION['USER']['INFO']['login_type']);
		var_dump($_SESSION['USER']['INFO']['email']);
		var_dump($_SESSION['USER']['INFO']['sso_id']);
		var_dump($_SESSION['USER']['INFO']['nickname']);
		var_dump($_SESSION['USER']['INFO']['access_token']);
		die();
		
		return $this->response->redirect("user/index");
	}
	
	public function facebookCurl($url) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}
	public function getFacebookAccessToken($facebook_code) {
		$token_url = "https://graph.facebook.com/oauth/access_token?"
				. "client_id=" .  $this->_config->facebook_sso->app_id
				. "&redirect_uri=" . urlencode($this->_config->facebook_sso->redirect_url)
				. "&client_secret=" . $this->_config->facebook_sso->app_secret
				. "&code=" . $facebook_code;
		$response = $this->facebookCurl($token_url);
		parse_str($response, $params);
		if ($params['access_token']) {
			return $params['access_token'];
		}
		return FALSE;
	}
	
	public function getFacebookUserInfo($access_token) {
		$graph_url = "https://graph.facebook.com/me?access_token=". $access_token;
		$user = json_decode($this->facebookCurl($graph_url));
		if($user != null && isset($user->id)) {
			return $user;
		}
		return FALSE;
	}
	
	
	function google_curl_post($url, $post) {
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_POST, TRUE);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
		curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$json_response = curl_exec($curl);
		curl_close($curl);
		return $json_response;
	}

	function getGoogleAccessToken($google_code) {
		$token_url = "https://accounts.google.com/o/oauth2/token?";
		$post = array(
				"code" => $google_code,
				"client_id" => $this->_config->google_sso->client_id,
				"client_secret" => $this->_config->google_sso->client_secret,
				"redirect_uri" => $this->_config->google_sso->redirect_url,
				"grant_type" => "authorization_code"
		);
		
		$response = $this->google_curl_post($token_url, $post);
		
		if ($response) {
			$authObj = json_decode($response);
		}
		if (isset($authObj->access_token)) {
			return $authObj->access_token;
		}else {
			return FALSE;
		}
	}
	
	function getGoogleUserInfo($access_token) {
		$user_info_url = "https://www.googleapis.com/oauth2/v1/userinfo?alt=json&access_token=" . $access_token;
		if ($user = json_decode(file_get_contents($user_info_url))) {
			return $user;
		};
		return FALSE;
	}
}