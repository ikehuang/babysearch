<?php

class DeviceController extends \Phalcon\Mvc\Controller {
	
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
		
		//$this->view->disable();
		//$this->response->setContentType('application/json', 'UTF-8');
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
		
		if($config->site->env == 'development') {
				
			$user_info = array(
					'email' => 'franky@ink.net.tw',
					'nickname' => 'franky'
			);
				
			$_SESSION['USER']['INFO'] = $user_info;
		}
	}
	
	public function indexAction() {
		$serial_number = $_GET["sn"];
		
		//still need to implement guestbook...
		//sample code
		//$serial_number = "BD1B46XFKMX";
		
		$device = Device::findFirst("serial_number = '{$serial_number}'");
		//$device = Device::findFirst(array("serial_number = '{$serial_number}'", "columns" => "status, type, name, photo, message"));
		
		switch($device->type) {
			case "Pets":
				$info = PetInfo::findFirst("did = '{$device->did}'");
				break;
			case "Human":
				$info = HumanInfo::findFirst("did = '{$device->did}'");
				break;
			case "Valuables":
				$info = ValuableInfo::findFirst("did = '{$device->did}'");
				break;
			default:
				break;
		}
		
		//find all photos under given serial number
		//$device = Device::findFirst("serial_number = '{$serial_number}'");
		
		$photos = Photos::find("did = '{$device->did}'");
		
		foreach ($photos as $photo) {
			$photo_list[] = $photo->photo;
		}
		
		$this->view->setVar("device", $device);
		$this->view->setVar("info", $info);
		$this->view->setVar("photo_list", $photo_list);
	}
	
	public function createPetAction(){
		
		//device info
		$serial_number = strtoupper($this->_request->getPost('serial_number1'));
		$status = '';
		$name = $this->_request->getPost('name');
		$photo = $this->_request->getPost('photo');
		$message = $this->_request->getPost('message');
		$expiry_date = '';
		
		$open = $this->_request->getPost('open');
		
		//pet info
		$pet_name = $this->_request->getPost('pet_name');
		$pet_sex = $this->_request->getPost('pet_sex');
		$pet_birthday = $this->_request->getPost('pet_birthday');
		$pet_height = $this->_request->getPost('pet_height');
		$pet_weight = $this->_request->getPost('pet_weight');
		$pet_temperament = $this->_request->getPost('pet_temperament');
		$pet_talents = $this->_request->getPost('pet_talents');
		$pet_description = $this->_request->getPost('pet_description');
		
		//pet health status
		$pet_chip_number = $this->_request->getPost('pet_chip_number');
		$pet_desex = $this->_request->getPost('pet_desex');
		$pet_vaccine_type = $this->_request->getPost('pet_vaccine_type');
		$pet_bloodtype = $this->_request->getPost('pet_bloodtype');
		$pet_bloodbank = $this->_request->getPost('pet_bloodbank');
		$pet_disability = $this->_request->getPost('pet_disability');
		$pet_insurance = $this->_request->getPost('pet_insurance');
		$pet_hospital_name = $this->_request->getPost('pet_hospital_name');
		$pet_hospital_phone = $this->_request->getPost('pet_hospital_phone');
		$pet_hospital_address = $this->_request->getPost('pet_hospital_address');
		
		//if serial number exists and 'status'='new', then continue to create device...; otherwise, return fail
		if(Device::count(array("conditions" => "status = 'new' AND serial_number = '{$serial_number}'")) > 0) {
		
			//create Device
			//$device = new Device();
			$device = Device::findFirst("serial_number = '{$serial_number}'");
			
			$type = "Pets";
	
			//register device status as Normal
			$status = 'normal';
				
			//register expiry date for 1-year for now
			$expiry_date = '2016-05-31';
				
			$device->serial_number = $serial_number;
			$device->status = $status;
			$device->type = $type;
			//$device->name = $name;
			$device->name = $pet_name;
			$device->message = $message;
			$device->expiry_date = $expiry_date;
			//$device->open = 'N';
			$device->open = $open;
			$device->created = date('Y-m-d H:i:s');
			//$device->email = $this->_email;
			$device->email = $_SESSION['USER']['INFO']['email'];
			
			//for uploading device photo
			// Check if the user has uploaded files
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
			
							$device->photo = "http://{$_SERVER['HTTP_HOST']}/".$path;
			
							$photo = $device->photo;
						}
					}
				}
			}
			
			$device->update();
			
			//create PetInfo
			$pet_info = new PetInfo();
			$pet_info->did = $device->did;
			
			$pet_info->name = $pet_name;
			$pet_info->sex = $pet_sex;
			$pet_info->birthday = $pet_birthday;
			$pet_info->height = $pet_height;
			$pet_info->weight = $pet_weight;
			$temperaments = implode (",", $pet_temperament);
			$pet_info->temperament = $temperaments;
			//$pet_info->temperament = $pet_temperament;
			$talents = implode (",", $pet_talents);
			$pet_info->talents = $talents;
			//$pet_info->talents = $pet_talents;
			$pet_info->description = $pet_description;
			$pet_info->chip_number = $pet_chip_number;
			$pet_info->desex = $pet_desex;
			$pet_info->vaccine_type = $pet_vaccine_type;
			$pet_info->bloodtype = $pet_bloodtype;
			$pet_info->bloodbank = $pet_bloodbank;
			$disabilities = implode (",", $pet_disability);
			$pet_info->disability = $disabilities;
			//$pet_info->disability = $pet_disability;
			$pet_info->insurance = $pet_insurance;
			$pet_info->hospital_name = $pet_hospital_name;
			$pet_info->hospital_phone = $pet_hospital_phone;
			$pet_info->hospital_address = $pet_hospital_address;
			
			$pet_info->create();
		}
	}
	
	public function createHumanAction(){
		
		//device info
		$serial_number = strtoupper($this->_request->getPost('serial_number2'));
		$status = '';
		$name = $this->_request->getPost('name');
		$photo = $this->_request->getPost('photo');
		$message = $this->_request->getPost('message');
		$expiry_date = '';
		
		$open = $this->_request->getPost('open');
		
		//human info
		$human_firstname = $this->_request->getPost('human_firstname');
		$human_lastname = $this->_request->getPost('human_lastname');
		$human_nickname = $this->_request->getPost('human_nickname');
		$human_sex = $this->_request->getPost('human_sex');
		$human_birthday = $this->_request->getPost('human_birthday');
		$human_height = $this->_request->getPost('human_height');
		$human_weight = $this->_request->getPost('human_weight');
		$human_bloodtype = $this->_request->getPost('human_bloodtype');
		$human_disease = $this->_request->getPost('human_disease');
		$human_disability = $this->_request->getPost('human_disability');
		$human_medications = $this->_request->getPost('human_medications');
		$human_hospital_name = $this->_request->getPost('human_hospital_name');
		$human_hospital_phone = $this->_request->getPost('human_hospital_phone');
		$human_hospital_address = $this->_request->getPost('human_hospital_address');
		
		//if serial number exists and 'status'='new', then continue to create device...; otherwise, return fail
		if(Device::count(array("conditions" => "status = 'new' AND serial_number = '{$serial_number}'")) > 0) {
		
			//create Device
			//$device = new Device();
			$device = Device::findFirst("serial_number = '{$serial_number}'");
			
			$type = "Human";
			
			//register device status as Normal
			$status = 'normal';
				
			//register expiry date for 1-year for now
			$expiry_date = '2016-05-31';
				
			$device->serial_number = $serial_number;
			$device->status = $status;
			$device->type = $type;
			//$device->name = $name;
			$device->name = $human_nickname;
			$device->message = $message;
			$device->expiry_date = $expiry_date;
			//$device->open = 'N';
			$device->open = $open;
			$device->created = date('Y-m-d H:i:s');
			//$device->email = $this->_email;
			$device->email = $_SESSION['USER']['INFO']['email'];
			
			//for uploading device photo
			// Check if the user has uploaded files
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
			
							$device->photo = "http://{$_SERVER['HTTP_HOST']}/".$path;
			
							$photo = $device->photo;
						}
					}
				}
			}
			
			$device->update();
			
			//create HumanInfo
			$human_info = new HumanInfo();
			$human_info->did = $device->did;
			
			$human_info->firstname = $human_firstname;
			$human_info->lasname = $human_lastname;
			$human_info->nickname = $human_nickname;
			$human_info->sex = $human_sex;
			$human_info->birthday = $human_birthday;
			$human_info->height = $human_height;
			$human_info->weight = $human_weight;
			$human_info->bloodtype = $human_bloodtype;
			$human_info->disease = $human_disease;
			$human_info->disability = $human_disability;
			$human_info->medications = $human_medications;
			$human_info->hospital_name = $human_hospital_name;
			$human_info->hospital_phone = $human_hospital_phone;
			$human_info->hospital_address = $human_hospital_address;
			
			$human_info->create();
		}
	}
	
	public function createValuableAction(){
	
		//device info
		$serial_number = strtoupper($this->_request->getPost('serial_number3'));
		$status = '';
		$name = $this->_request->getPost('name');
		$photo = $this->_request->getPost('photo');
		$message = $this->_request->getPost('message');
		$expiry_date = '';
		
		$open = $this->_request->getPost('open');
		
		//valuable info
		$valuable_name = $this->_request->getPost('valuable_name');
		$valuable_description = $this->_request->getPost('valuable_description');
		
		//if serial number exists and 'status'='new', then continue to create device...; otherwise, return fail
		if(Device::count(array("conditions" => "status = 'new' AND serial_number = '{$serial_number}'")) > 0) {
		
			//create Device
			//$device = new Device();
			$device = Device::findFirst("serial_number = '{$serial_number}'");
			
			$type = "Valuables";
			
			//register device status as Normal
			$status = 'normal';
				
			//register expiry date for 1-year for now
			$expiry_date = '2016-05-31';
				
			$device->serial_number = $serial_number;
			$device->status = $status;
			$device->type = $type;
			//$device->name = $name;
			$device->name = $valuable_name;
			$device->message = $message;
			$device->expiry_date = $expiry_date;
			//$device->open = 'N';
			$device->open = $open;
			$device->created = date('Y-m-d H:i:s');
			//$device->email = $this->_email;
			$device->email = $_SESSION['USER']['INFO']['email'];
			
			//for uploading device photo
			// Check if the user has uploaded files
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
			
							$device->photo = "http://{$_SERVER['HTTP_HOST']}/".$path;
			
							$photo = $device->photo;
						}
					}
				}
			}
			
			$device->update();
			
			$valuable_info = new ValuableInfo();
			$valuable_info->did = $device->did;
			
			$valuable_info->name = $valuable_name;
			$valuable_info->description = $valuable_description;
			
			$valuable_info->create();
		}
	}
	
	public function updateGuestbookAction(){
		$serial_number = $_GET["sn"];
		
		//sample data
		$this->_email = $_SESSION['USER']['INFO']['email'];
		
		//if email-serial_number pair exists in the system, then continue...; otherwise, fail.
		if(Device::count(array("conditions" => "email = '{$this->_email}' AND serial_number = '{$serial_number}'")) > 0) {
			
			$device = Device::findFirst("serial_number = '{$serial_number}'");
			
			$this->view->setVar("device", $device);		
		}
	}
	
	public function updateInfoAction(){
		$serial_number = $_GET["sn"];
		
		//sample data
		$this->_email = $_SESSION['USER']['INFO']['email'];
		
		//if email-serial_number pair exists in the system, then continue...; otherwise, fail.
		if(Device::count(array("conditions" => "email = '{$this->_email}' AND serial_number = '{$serial_number}'")) > 0) {
			
			$device = Device::findFirst("serial_number = '{$serial_number}'");
			
			$this->view->setVar("device", $device);		
		}
	}
	
	public function updatePetAction(){
		//for updating device info
		//$category = $this->_request->getPost('category');
		$status = strtolower($this->_request->getPost('status'));
		//$type = $this->_request->getPost('type');
		$name = $this->_request->getPost('name');
		//$photo = $this->_request->getPost('photo');
		$photo = "";
		$message = $this->_request->getPost('message');
		$serial_number = strtoupper($this->_request->getPost('serial_number1'));
		//$expiry_date = "2015-12-30";
		
		//for updating pet...
		$pet_name = $this->_request->getPost('pet_name');
		$pet_sex = $this->_request->getPost('pet_sex');
		$pet_birthday = $this->_request->getPost('pet_birthday');
		$pet_height = $this->_request->getPost('pet_height');
		$pet_weight = $this->_request->getPost('pet_weight');
		$pet_temperament = $this->_request->getPost('pet_temperament');
		$pet_talents = $this->_request->getPost('pet_talents');
		$pet_description = $this->_request->getPost('pet_description');
		$pet_chip_number = $this->_request->getPost('pet_chip_number');
		$pet_desex = $this->_request->getPost('pet_desex');
		$pet_vaccine_type = $this->_request->getPost('pet_vaccine_type');
		$pet_bloodtype = $this->_request->getPost('pet_bloodtype');
		$pet_bloodbank = $this->_request->getPost('pet_bloodbank');
		$pet_disability = $this->_request->getPost('pet_disability');
		$pet_insurance = $this->_request->getPost('pet_insurance');
		$pet_hospital_name = $this->_request->getPost('pet_hospital_name');
		$pet_hospital_phone = $this->_request->getPost('pet_hospital_phone');
		$pet_hospital_address = $this->_request->getPost('pet_hospital_address');
		
		//set 'email' to session's email
		$this->_email = $_SESSION['USER']['INFO']['email'];
		
		//find 'type'-P,M,T,A from first letter of serial number
		$type = null;
		
		if(!empty($serial_number))
			$type = $serial_number[0];
		
		switch($type) {
			case "P":
				$type = "Pets";
				break;
			case "M":
				$type = "Human";
				break;
			case "T":
				$type = "Valuables";
				break;
			case "A":
				$type = "All";
				break;
			default:
				break;
		}
		
		//if email-serial_number pair exists in the system, then continue...; otherwise, fail.
		if(Device::count(array("conditions" => "email = '{$this->_email}' AND serial_number = '{$serial_number}'")) > 0) {
				
			$device = Device::findFirst("email = '{$this->_email}' AND serial_number = '{$serial_number}'");
		
			//filter status
			switch($status) {
				case "lost":
					$device->status = $status;
					break;
				case "normal":
					$device->status = $status;
					break;
				default:
					$device->status = null;
			}
		
			//if device is lost, then switch ON the "open" flag to signal
			if($device->status == 'lost')
				$device->open = 'Y';
			else
				$device->open = 'N';
		
			$device->type = $type;
			//$device->name = $name;
			$device->name = $pet_name;
			//$device->photo = $photo;
			$device->message = $message;
		
			//for uploading device photo
			// Check if the user has uploaded files
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
		
							$device->photo = "http://{$_SERVER['HTTP_HOST']}/".$path;
		
							$photo = $device->photo;
						}
					}
				}
			}
		
			$device->update();
				
			//update device info under type
			if($type == "Pets") {
		
				//PetInfo: update
				$pet_info = PetInfo::findFirst("did = '{$device->did}'");
		
				$pet_info->name = $pet_name;
				$pet_info->sex = $pet_sex;
				$pet_info->birthday = $pet_birthday;
				$pet_info->height = $pet_height;
				$pet_info->weight = $pet_weight;
				//$pet_info->temperament = $pet_temperament;
				//$pet_info->talents = $pet_talents;
				$pet_info->description = $pet_description;
				$pet_info->chip_number = $pet_chip_number;
				$pet_info->desex = $pet_desex;
				$pet_info->vaccine_type = $pet_vaccine_type;
				$pet_info->bloodtype = $pet_bloodtype;
				$pet_info->bloodbank = $pet_bloodbank;
				//$pet_info->disability = $pet_disability;
				$pet_info->insurance = $pet_insurance;
				$pet_info->hospital_name = $pet_hospital_name;
				$pet_info->hospital_phone = $pet_hospital_phone;
				$pet_info->hospital_address = $pet_hospital_address;
		
				$pet_info->update();
			}
		}
	}
	
	public function updateHumanAction(){
		
		//for updating device info
		//$category = $this->_request->getPost('category');
		$status = strtolower($this->_request->getPost('status'));
		//$type = $this->_request->getPost('type');
		$name = $this->_request->getPost('name');
		//$photo = $this->_request->getPost('photo');
		$photo = "";
		$message = $this->_request->getPost('message');
		$serial_number = strtoupper($this->_request->getPost('serial_number2'));
		//$expiry_date = "2015-12-30";
		
		//for updating human...
		$human_firstname = $this->_request->getPost('human_firstname');
		$human_lastname = $this->_request->getPost('human_lastname');
		$human_nickname = $this->_request->getPost('human_nickname');
		$human_sex = $this->_request->getPost('human_sex');
		$human_birthday = $this->_request->getPost('human_birthday');
		$human_height = $this->_request->getPost('human_height');
		$human_weight = $this->_request->getPost('human_weight');
		$human_bloodtype = $this->_request->getPost('human_bloodtype');
		$human_disease = $this->_request->getPost('human_disease');
		$human_disability = $this->_request->getPost('human_disability');
		$human_medications = $this->_request->getPost('human_medications');
		$human_hospital_name = $this->_request->getPost('human_hospital_name');
		$human_hospital_phone = $this->_request->getPost('human_hospital_phone');
		$human_hospital_address = $this->_request->getPost('human_hospital_address');
		
		//set 'email' to session's email
		$this->_email = $_SESSION['USER']['INFO']['email'];
		
		//find 'type'-P,M,T,A from first letter of serial number
		$type = null;
		
		if(!empty($serial_number))
			$type = $serial_number[0];
		
		switch($type) {
			case "P":
				$type = "Pets";
				break;
			case "M":
				$type = "Human";
				break;
			case "T":
				$type = "Valuables";
				break;
			case "A":
				$type = "All";
				break;
			default:
				break;
		}
		
		//if email-serial_number pair exists in the system, then continue...; otherwise, fail.
		if(Device::count(array("conditions" => "email = '{$this->_email}' AND serial_number = '{$serial_number}'")) > 0) {
			
			$device = Device::findFirst("email = '{$this->_email}' AND serial_number = '{$serial_number}'");
		
			//filter status
			switch($status) {
				case "lost":
					$device->status = $status;
					break;
				case "normal":
					$device->status = $status;
					break;
				default:
					$device->status = null;
			}
		
			//if device is lost, then switch ON the "open" flag to signal
			if($device->status == 'lost')
				$device->open = 'Y';
			else
				$device->open = 'N';
		
			$device->type = $type;
			//$device->name = $name;
			$device->name = $human_nickname;
			//$device->photo = $photo;
			$device->message = $message;
		
			//for uploading device photo
			// Check if the user has uploaded files
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
		
							$device->photo = "http://{$_SERVER['HTTP_HOST']}/".$path;
		
							$photo = $device->photo;
						}
					}
				}
			}
		
			$device->update();
			
			//update device info under type
			if($type == "Human") {
		
				//HumanInfo: update
				$human_info = HumanInfo::findFirst("did = '{$device->did}'");
		
				$human_info->firstname = $human_firstname;
				$human_info->lasname = $human_lastname;
				$human_info->nickname = $human_nickname;
				$human_info->sex = $human_sex;
				$human_info->birthday = $human_birthday;
				$human_info->height = $human_height;
				$human_info->weight = $human_weight;
				$human_info->bloodtype = $human_bloodtype;
				$human_info->disease = $human_disease;
				$human_info->disability = $human_disability;
				$human_info->medications = $human_medications;
				$human_info->hospital_name = $human_hospital_name;
				$human_info->hospital_phone = $human_hospital_phone;
				$human_info->hospital_address = $human_hospital_address;
		
				$human_info->update();
			}
		}
	}
	
	public function updateValuableAction(){
		//for updating device info
		//$category = $this->_request->getPost('category');
		$status = strtolower($this->_request->getPost('status'));
		//$type = $this->_request->getPost('type');
		$name = $this->_request->getPost('name');
		//$photo = $this->_request->getPost('photo');
		$photo = "";
		$message = $this->_request->getPost('message');
		$serial_number = strtoupper($this->_request->getPost('serial_number3'));
		//$expiry_date = "2015-12-30";
		
		//for updating valuable...
		$valuable_name = $this->_request->getPost('valuable_name');
		$valuable_description = $this->_request->getPost('valuable_description');
		
		//set 'email' to session's email
		$this->_email = $_SESSION['USER']['INFO']['email'];
		
		//find 'type'-P,M,T,A from first letter of serial number
		$type = null;
		
		if(!empty($serial_number))
			$type = $serial_number[0];
		
		switch($type) {
			case "P":
				$type = "Pets";
				break;
			case "M":
				$type = "Human";
				break;
			case "T":
				$type = "Valuables";
				break;
			case "A":
				$type = "All";
				break;
			default:
				break;
		}
		
		//if email-serial_number pair exists in the system, then continue...; otherwise, fail.
		if(Device::count(array("conditions" => "email = '{$this->_email}' AND serial_number = '{$serial_number}'")) > 0) {
				
			$device = Device::findFirst("email = '{$this->_email}' AND serial_number = '{$serial_number}'");
		
			//filter status
			switch($status) {
				case "lost":
					$device->status = $status;
					break;
				case "normal":
					$device->status = $status;
					break;
				default:
					$device->status = null;
			}
		
			//if device is lost, then switch ON the "open" flag to signal
			if($device->status == 'lost')
				$device->open = 'Y';
			else
				$device->open = 'N';
		
			$device->type = $type;
			//$device->name = $name;
			$device->name = $valuable_name;
			//$device->photo = $photo;
			$device->message = $message;
		
			//for uploading device photo
			// Check if the user has uploaded files
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
		
							$device->photo = "http://{$_SERVER['HTTP_HOST']}/".$path;
		
							$photo = $device->photo;
						}
					}
				}
			}
		
			$device->update();
				
			//update device info under type
			if($type == "Valuables") {
		
				//ValuableInfo: update
				$valuable_info = ValuableInfo::findFirst("did = '{$device->did}'");
		
				$valuable_info->name = $valuable_name;
				$valuable_info->description = $valuable_description;
		
				$valuable_info->update();
			}			
		}
	}
	
	public function updatePhotosAction() {
		//$serial_number = strtoupper($this->_request->getPost('serial_number'));
		$serial_number = $_GET["sn"];
		
		//for photos...
		$photo_list = array();
	
		//sample data
		$this->_email = $_SESSION['USER']['INFO']['email'];
		//$this->_api_key = 'qwe123';
		//$this->_apikey = 'qwe123';
		//$this->_email = 'brucelee@gmail.com';
		//$serial_number = 'INK46XFKMX';
		//$type = 'valuable';
	
		//if api_key match, continue...; otherwise, return fail
		//if($this->_api_key == $this->_apikey) {
	
			//if email-serial_number pair exists in the system, then continue...; otherwise, fail.
			if(Device::count(array("conditions" => "email = '{$this->_email}' AND serial_number = '{$serial_number}'")) > 0) {
				//if serial number exists, then continue...; otherwise, return fail
				//if(Device::count("serial_number = '{$serial_number}'") > 0) {
	
				//Photos:
				//find did
				$device = Device::findFirst("serial_number = '{$serial_number}'");
	
				$photos = Photos::find("did = '{$device->did}'");
	
				//set counter
				$counter = count($photos);
	
				// Check if the user has uploaded files
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
	
								//if device has >= 10 photos, delete from first add to lasts
								if($counter >= 10) {
									$photo = Photos::findFirst("did = '{$device->did}'");
									$photo->delete();
								}
	
								$photo = new Photos();
								$photo->did = $device->did;
								$photo->photo = "http://{$_SERVER['HTTP_HOST']}/".$path;
								$photo->create();
									
								$counter++;
	
								//for listing updated photos
								$photo_list[] = $photo->photo;
	
							}
						}
					}

					//send '$photo_list' to view here
				}
				$this->view->setVar("device", $device);
			}
		//}
	}
	
	public function updateStatusAction(){
		$serial_number = $_GET["sn"];
		
		//sample data
		$this->_email = $_SESSION['USER']['INFO']['email'];
		
		//if email-serial_number pair exists in the system, then continue...; otherwise, fail.
		if(Device::count(array("conditions" => "email = '{$this->_email}' AND serial_number = '{$serial_number}'")) > 0) {
			
			$device = Device::findFirst("serial_number = '{$serial_number}'");
			
			$this->view->setVar("device", $device);		
		}
	}
	
	public function createAction(){
		$serial_number = $_GET["sn"];
		
		//$device = Device::findFirst(array("conditions" => "status = 'new' AND serial_number = '{$serial_number}'"));
		
		//old code...
		//check serial number exist or not 
		//$category = $this->_request->getPost('category');
		$serial_number = strtoupper($this->_request->getPost('serial_number'));
		//$status = strtolower($this->_request->getPost('status'));
		$status = '';
		//$type = $this->_request->getPost('type');
		$name = $this->_request->getPost('name');
		$photo = $this->_request->getPost('photo');
		$message = $this->_request->getPost('message');
		$expiry_date = '';
		
		//sample data
		//$this->_api_key = 'qwe123';
		//$this->_apikey = 'qwe123';
		//$this->_email = 'ike@ink.net.tw';
		//$serial_number = 'INK46XFKMX';
		//$type = 'pet';
		//$category = 'cats';
		
		//$imei = '152328054557408';
		//$token = '166942940015970|tcOoRAAQrWcDm_84h3O7NN7Z9DM';
		
		//find 'type'-P,M,T,A from first letter of serial number
		$type = null;
		
		if(!empty($serial_number))
			$type = $serial_number[0];
		
		switch($type) {
			case "P":
				$type = "Pets";
				break;
			case "M":
				$type = "Human";
				break;
			case "T":
				$type = "Valuables";
				break;
			case "A":
				$type = "All";
				break;
			default:
				break;
		}
		
		//if api_key match, continue...; otherwise, return fail
		if($this->_api_key == $this->_apikey) {
			
			//make sure all inputs are not empty
			if(!empty($serial_number) && !empty($this->_email)) {
			
				//if user exists, then continue to create device...; otherwise, return fail
				if(User::count("email = '{$this->_email}'") > 0) {
				
					//if serial number doesn't exist, then continue to create device...; otherwise, return fail
					if(Device::count("serial_number = '{$serial_number}'") == 0) {
						
						$device = new Device();
						
						//register device status as Normal
						$status = 'normal';
						
						//register expiry date for 1-year for now
						$expiry_date = '2016-05-31';
						
						$device->serial_number = $serial_number;
						$device->status = $status;
						$device->type = $type;
						$device->name = $name;
						$device->photo = $photo;
						$device->message = $message;
						$device->expiry_date = $expiry_date;
						//$device->category = $category;
						$device->open = 'N';
						$device->email = $this->_email;
						
						$device->create();
						
						//create Photos
						$photos = new Photos();
						$photos->did = $device->did;
						$photos->create();
						
					}
				}
			}
		}
	}
	
	public function updateCoordinatesAction() {
		
		$serial_number = strtoupper($this->_request->getPost('serial_number'));
		
		$latitude = $this->_request->getPost('latitude');
		$longitude = $this->_request->getPost('longitude');
		$battery_status = $this->_request->getPost('battery_status');
		
		$device_message = array("latitude" => $latitude, 'longitude' => $longitude, 'battery_status' => $battery_status);
		
		$response_data = array(
				'status' => 'fail',
				'device_message' => $device_message
		);
		
		//if api_key match, continue...; otherwise, return fail
		if($this->_api_key == $this->_apikey) {
			
			//sample data
			//$serial_number = 'BD1B46XFKMX';
			//$latitude= "111.213";
			//$longitude = "222.123";
			//$battery_status = "low";
				
			//if email-serial_number pair exists in the system, then continue...; otherwise, fail.
			if(Device::count(array("conditions" => "email = '{$this->_email}' AND serial_number = '{$serial_number}'")) > 0) {
				
				$device = Device::findFirst("serial_number = '{$serial_number}'");
				
				$device->latitude = $latitude;
				$device->longitude = $longitude;
				$device->battery_status = $battery_status;
				
				if($device->update() == false) {
					$message = "Failed to update. Please refer to return message for possible errors.\n";
						
					foreach($device->getmessages() as $msg) {
						$message = $msg . "\n";
					}
				}
				else {
					$message = "Device updated successfully.\n";
				
					$device_message = array("latitude" => $latitude, 'longitude' => $longitude, 'battery_status' => $battery_status);
				
					$response_data = array(
							'status' => 'success',
							'device_message' => $device_message
					);
				}
			}
		}
			
		$this->response->setContent(json_encode($response_data));
		$this->response->send();
	}

	public function updateAction(){
		//$category = $this->_request->getPost('category');
		$status = strtolower($this->_request->getPost('status'));
		//$type = $this->_request->getPost('type');
		$name = $this->_request->getPost('name');
		//$photo = $this->_request->getPost('photo');
		$photo = "";
		$message = $this->_request->getPost('message');
		$serial_number = strtoupper($this->_request->getPost('serial_number'));
		//$expiry_date = "2015-12-30";
		
		//for updating pet...
		$pet_name = $this->_request->getPost('pet_name');
		$pet_sex = $this->_request->getPost('pet_sex');
		$pet_birthday = $this->_request->getPost('pet_birthday');
		$pet_height = $this->_request->getPost('pet_height');
		$pet_weight = $this->_request->getPost('pet_weight');
		$pet_temperament = $this->_request->getPost('pet_temperament');
		$pet_talents = $this->_request->getPost('pet_talents');
		$pet_description = $this->_request->getPost('pet_description');
		$pet_chip_number = $this->_request->getPost('pet_chip_number');
		$pet_desex = $this->_request->getPost('pet_desex');
		$pet_vaccine_type = $this->_request->getPost('pet_vaccine_type');
		$pet_bloodtype = $this->_request->getPost('pet_bloodtype');
		$pet_bloodbank = $this->_request->getPost('pet_bloodbank');
		$pet_disability = $this->_request->getPost('pet_disability');
		$pet_insurance = $this->_request->getPost('pet_insurance');
		$pet_hospital_name = $this->_request->getPost('pet_hospital_name');
		$pet_hospital_phone = $this->_request->getPost('pet_hospital_phone');
		$pet_hospital_address = $this->_request->getPost('pet_hospital_address');
		
		//for updating human...
		$human_firstname = $this->_request->getPost('human_firstname');
		$human_lastname = $this->_request->getPost('human_lastname');
		$human_nickname = $this->_request->getPost('human_nickname');
		$human_sex = $this->_request->getPost('human_sex');
		$human_birthday = $this->_request->getPost('human_birthday');
		$human_height = $this->_request->getPost('human_height');
		$human_weight = $this->_request->getPost('human_weight');
		$human_bloodtype = $this->_request->getPost('human_bloodtype');
		$human_disease = $this->_request->getPost('human_disease');
		$human_disability = $this->_request->getPost('human_disability');
		$human_medications = $this->_request->getPost('human_medications');
		$human_hospital_name = $this->_request->getPost('human_hospital_name');
		$human_hospital_phone = $this->_request->getPost('human_hospital_phone');
		$human_hospital_address = $this->_request->getPost('human_hospital_address');
		
		//for updating valuable...
		$valuable_name = $this->_request->getPost('valuable_name');
		$valuable_description = $this->_request->getPost('valuable_description');
		
		//find 'type'-P,M,T,A from first letter of serial number
		$type = null;
		
		if(!empty($serial_number))
			$type = $serial_number[0];
		
		switch($type) {
			case "P":
				$type = "Pets";
				break;
			case "M":
				$type = "Human";
				break;
			case "T":
				$type = "Valuables";
				break;
			case "A":
				$type = "All";
				break;
			default:
				break;
		}
		
		$device_message = array("serial_number" => $serial_number, "status" => $status, "type" => $type, "name" => $name, "photo" => $photo, "message" => $message);
			
		$response_data = array(
				'status' => 'fail',
				'device_message' => $device_message
		);
		
		//sample code
		//$this->_api_key = 'qwe123';
		//$this->_apikey = 'qwe123';
		//$this->_email = 'franky@ink.net.tw';
		//$serial_number = 'AB4B46XFKMX';
		//$status = 'lost';
		//$type = 'human';
		//$name = 'little george';
		//$message = 'please contact me if you happen to pick this up at 999132094. Thanks!';
		
		//pet:
		//$pet_name = 'birdie';
		//$pet_sex = 'male';
		//$pet_birthday = '2014-02-14';
		//$pet_height = '80';
		//$pet_weight = '25';
		//$pet_temperament = 'friendly';
		//$pet_talents = 'handshake';
		//$pet_description = 'gold color fur with white collar around his neck';
		//$pet_chip_number = '2134567';
		//$pet_desex = 'yes';
		//$pet_vaccine_type = 'canine vaccine';
		//$pet_bloodtype = 'A';
		//$pet_bloodbank = 'taipei';
		//$pet_disability = '';
		//$pet_insurance = '';
		//$pet_hospital_name = 'taipei vet clinic';
		//$pet_hospital_phone = '01298347';
		//$pet_hospital_address = 'big on road, taipei';
		
		//human:
		//$human_firstname = 'george';
		//$human_lastname = 'washington';
		//$human_nickname = 'gwbaby';
		//$human_sex = 'male';
		//$human_birthday = '2001-10-10';
		//$human_height = '20';
		//$human_weight = '35';
		//$human_bloodtype = 'O';
		//$human_disease = '';
		//$human_disability = '';
		//$human_medications = '';
		//$human_hospital_name = 'US general hospital';
		//$human_hospital_phone = '72017777';
		//$human_hospital_address = 'statue of freedom, america.';
		
		//valuable:
		//$valuable_name = 'iphone 6';
		//$valuable_description = 'moms birthday present';
		
		//if api_key match, continue...; otherwise, return fail
		if($this->_api_key == $this->_apikey) {
		
			//sample data
			//$serial_number = 'KB2A56XFKMX';
			//$status = "lost";
			//$type = 'nfc';
			//$name = 'apples tag';
			//$photo = 'apple123374.png';
			//$message = 'my name is apple.vPlease contact my owner at 94887766';
			//$category = 'pets';
			
			//if email-serial_number pair exists in the system, then continue...; otherwise, fail.
			if(Device::count(array("conditions" => "email = '{$this->_email}' AND serial_number = '{$serial_number}'")) > 0) {
			
				$device = Device::findFirst("email = '{$this->_email}' AND serial_number = '{$serial_number}'");
				
				//category missing in device message?
				
				//filter status
				switch($status) {
					case "lost":
						$device->status = $status;
						break;
					case "normal":
						$device->status = $status;
						break;
					default:
						$device->status = null;
				}
				
				//if device is lost, then switch ON the "open" flag to signal
				if($device->status == 'lost')
					$device->open = 'Y';
				else
					$device->open = 'N';
				
				$device->type = $type;
				$device->name = $name;
				//$device->photo = $photo;
				$device->message = $message;
				
				//filter input category with system
				//if(Category::count("name = '{strtolower($category)}'" == 0)) {
					//$category = '';
				//}
				//$device->category = $category;
				
				//for uploading device photo
				// Check if the user has uploaded files
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
						
								$device->photo = "http://{$_SERVER['HTTP_HOST']}/".$path;
								
								$photo = $device->photo;
							}
						}
					}
				}
				
				$device->update();
				
				//$_POST['photo']
					
				//update device info under type
				if($type == "Pets") {
						
					//PetInfo: update
					$pet_info = PetInfo::findFirst("did = '{$device->did}'");
						
					$pet_info->name = $pet_name;
					$pet_info->sex = $pet_sex;
					$pet_info->birthday = $pet_birthday;
					$pet_info->height = $pet_height;
					$pet_info->weight = $pet_weight;
					$pet_info->temperament = $pet_temperament;
					$pet_info->talents = $pet_talents;
					$pet_info->description = $pet_description;
					$pet_info->chip_number = $pet_chip_number;
					$pet_info->desex = $pet_desex;
					$pet_info->vaccine_type = $pet_vaccine_type;
					$pet_info->bloodtype = $pet_bloodtype;
					$pet_info->bloodbank = $pet_bloodbank;
					$pet_info->disability = $pet_disability;
					$pet_info->insurance = $pet_insurance;
					$pet_info->hospital_name = $pet_hospital_name;
					$pet_info->hospital_phone = $pet_hospital_phone;
					$pet_info->hospital_address = $pet_hospital_address;

					$pet_info->update();						
				}
				else if($type == "Human") {
						
					//HumanInfo: update
					$human_info = HumanInfo::findFirst("did = '{$device->did}'");
						
					$human_info->firstname = $human_firstname;
					$human_info->lasname = $human_lastname;
					$human_info->nickname = $human_nickname;
					$human_info->sex = $human_sex;
					$human_info->birthday = $human_birthday;
					$human_info->height = $human_height;
					$human_info->weight = $human_weight;
					$human_info->bloodtype = $human_bloodtype;
					$human_info->disease = $human_disease;
					$human_info->disability = $human_disability;
					$human_info->medications = $human_medications;
					$human_info->hospital_name = $human_hospital_name;
					$human_info->hospital_phone = $human_hospital_phone;
					$human_info->hospital_address = $human_hospital_address;

					$human_info->update();
				}
				else if($type == "Valuables") {
				
					//ValuableInfo: update
					$valuable_info = ValuableInfo::findFirst("did = '{$device->did}'");
				
					$valuable_info->name = $valuable_name;
					$valuable_info->description = $valuable_description;
						
					$valuable_info->update();
				}
				else {
					//echo "No category found.";
				}
				
				$device_message = array("serial_number" => $serial_number, "status" => $status, "type" => $type, "name" => $name, "photo" => $photo, "message" => $message);
				
				$response_data = array(
						'status' => 'success',
						'device_message' => $device_message
				);
			}
		}
		
		$this->response->setContent(json_encode($response_data));
		$this->response->send();

	}

	public function deleteAction(){
		
		$serial_number = strtoupper($this->_request->getPost('serial_number'));
		
		//sample data
		//$this->_api_key = 'qwe123';
		//$this->_apikey = 'qwe123';
		//$serial_number = 'ilHK46XFKMX';
		//$this->_email = 'watson@ink.net.tw';
		
		$response_data = array(
				'status' => 'fail'
		);
		
		//if api_key match, continue...; otherwise, return fail
		if($this->_api_key == $this->_apikey) {

			//if email-serial_number pair exists in the system, then continue...; otherwise, fail.
			if(Device::count(array("conditions" => "email = '{$this->_email}' AND serial_number = '{$serial_number}'")) > 0) {
			
				$device = Device::findFirst("email = '{$this->_email}' AND serial_number = '{$serial_number}'");
				
				$gid = $device->gid;
				
				//make a copy of did and type for the "will-be" deleted device
				$did = $device->did;
				$type = $device->type;
				
				if($device->delete() == false) {
					$message = "Failed to delete. Please refer to return message for possible errors.\n";
				
					foreach($device->getmessages() as $msg) {
						$message = $msg . "\n";
					}
				}
				else {
					$message = "Device deleted successfully.\n";
					
					//delete guestbook
					if(Guestbook::count("gid = '{$gid}'") > 0) {
						
						$guestbook = Guestbook::find("gid = '{$gid}'");
						$guestbook->delete();
						
					}
					
					//delete info
					if($type == 'Pets') {
						
						//PetInfo:
						$pet_info = PetInfo::findFirst("did = '{$did}'");
						$pet_info->delete();
					
					}
					else if($type == 'Human') {
						
						//HumanInfo:
						$human_info = HumanInfo::findFirst("did = '{$did}'");
						$human_info->delete();
						
					}
					else if($type == 'Valuables') {
					
						//ValuableInfo:
						$valuable_info = ValuableInfo::findFirst("did = '{$did}'");
						$valuable_info->delete();

					}
					else {
						//echo "No category found.";
					} 
					
					//delete photos:(if any)
					if(Photos::findFirst("did = '{$did}'") > 0) {
						
						$photos = Photos::findFirst("did = '{$did}'");
						$photos->delete();
					}
					
					$response_data = array(
							'status' => 'success'
					);
				}				
			}
		}
		
		$this->response->setContent(json_encode($response_data));
		$this->response->send();
	}
	
	public function listAction(){
		
		$tag_status = strtolower($this->_request->getPost('tag_status'));
		
		$device_list = array();
		
		$response_data = array(
				'status' => 'fail',
				'device_list' => $device_list
		);
		
		//test code for listing all devices under given email account
		
		//sample data
		//$this->_api_key = 'qwe123';
		//$this->_apikey = 'qwe123';
		//$this->_email='franky@ink.net.tw';
		//$tag_status = '';
		
		//if api_key match, continue...; otherwise, return fail
		if($this->_api_key == $this->_apikey) {
			
			//check email and sso_id
			//if(Mobile::count(array("conditions" => "email = '{$this->_email}' AND sso_id = '{$this->_sso_id}'")) > 0) {

				//if the given email has devices, then continue...; otherwise, return fail
				if(Device::count("email = '{$this->_email}'") > 0) {
					
					//may add more status later...
					switch ($tag_status) {
						case "lost":
							$conditions = "email = '{$this->_email}' AND status = 'lost'";
							break;
						case "normal":
							$conditions = "email = '{$this->_email}' AND status = 'normal'";
							break;
						default:
							$conditions = "email = '{$this->_email}'";
							break;
					}
					
					//$devices = Device::find("email = '{$this->_email}'");
					$devices = Device::find(array($conditions, "columns" => "serial_number, status, type, name, photo, message, latitude, longitude, battery_status, expiry_date"));
					
					foreach ($devices as $device) {
						$device_list[] = $device;
					}
					/*
					 for($i=0; $i<count($devices); $i++) {
					var_dump($device_list[$i]->serial_number);
					}
						
					$device_list = array(
							array("serial_number" => $serial_number, "status" => $status, "type" => $type, "name" => $name, "photo" => $photo, "message" => $message, "latitude" => $latitude, 'longitude' => $longitude, 'battery_status' => $battery_status, 'expiry_date' => $expiry_date),
							array("serial_number" => $serial_number, "status" => $status, "type" => $type, "name" => $name, "photo" => $photo, "message" => $message, "latitude" => $latitude, 'longitude' => $longitude, 'battery_status' => $battery_status, 'expiry_date' => $expiry_date),
							array("serial_number" => $serial_number, "status" => $status, "type" => $type, "name" => $name, "photo" => $photo, "message" => $message, "latitude" => $latitude, 'longitude' => $longitude, 'battery_status' => $battery_status, 'expiry_date' => $expiry_date),
					);
					*/
					
					$response_data = array(
							'status' => 'success',
							'device_list' => $device_list
					);
				}
			//}
		}
		
		$this->response->setContent(json_encode($response_data));
		$this->response->send();
	}
	
	public function transferExpiryDateAction() {
		$from_serial_number = $this->_request->getPost('from_serial_number');
		$to_serial_number = $this->_request->getPost('to_serial_number');
		
		//$category = 'null';
		$type = 'null';
		$name = 'null';
		$photo='null';
		$message='null';
		$latitude = 'null';
		$longitude = 'null';
		$battery_status = 'null';
		$expiry_date = 'null';
		$serial_number = 'null';
		$status = 'null';

		//sample data
		//$from_serial_number = 'KB2A56XFKMX';
		//$to_serial_number = 'CR2A56XFKMX';
		
		$device_message = array("serial_number" => $serial_number, "status" => $status, "type" => $type, "name" => $name, "photo" => $photo, "message" => $message, "latitude" => $latitude, 'longitude' => $longitude, 'battery_status' => $battery_status, 'expiry_date' => $expiry_date);
		
		$response_data = array(
				'status' => 'fail',
				'device_message' => $device_message
		);
		
		//if api_key match, continue...; otherwise, return fail
		if($this->_api_key == $this->_apikey) {
			
			//check if both 'from' and 'to' serial numbers are existed and belonged to the same email account
			if((Device::count("email = '{$this->_email}' AND serial_number = '{$from_serial_number}'") > 0)
				&& (Device::count("email = '{$this->_email}' AND serial_number = '{$to_serial_number}'") > 0)) {
				
				$fromDevice = Device::findFirst("email = '{$this->_email}' AND serial_number = '{$from_serial_number}'");
				$toDevice = Device::findFirst("email = '{$this->_email}' AND serial_number = '{$to_serial_number}'");
				
				//transfer date calculations...
				$today = strtotime(date('Y-m-d'));
				$fromDate = strtotime($fromDevice->expiry_date);
				$toDate = strtotime($toDevice->expiry_date);
				
				//check to make sure 'fromDevice' has longer expiry date
				//compare between today and from device expire date ,add remain date to to device
				if(strtotime($toDevice->expiry_date) < strtotime($fromDevice->expiry_date)) {
					
					//$toDevice->expiry_date = $fromDevice->expiry_date;
					
					$toDevice->expiry_date = date('Y-m-d', ($toDate + $fromDate - $today));
					
					$toDevice->update();
					$fromDevice->delete();
					
					$device_message = array("serial_number" => $serial_number, "status" => $status, "type" => $type, "name" => $name, "photo" => $photo, "message" => $message, "latitude" => $latitude, 'longitude' => $longitude, 'battery_status' => $battery_status, 'expiry_date' => $expiry_date);
					
					$response_data = array(
							'status' => 'success',
							'device_message' => $device_message
					);
				}
			}
		}
		
		$this->response->setContent(json_encode($response_data));
		$this->response->send();
		
	}
	
	public function getInfoAction() {
		$serial_number = strtoupper($this->_request->getPost('serial_number'));
		
		//sample data
		//$this->_api_key = 'qwe123';
		//$this->_apikey = 'qwe123';
		//$this->_email = 'ike@ink.net.tw';
		//$serial_number = 'INK46XFKMX';
		
		//find 'type'-P,M,T,A from first letter of serial number
		$type = null;
		
		if(!empty($serial_number))
			$type = $serial_number[0];
		
		switch($type) {
			case "P":
				$type = "Pets";
				break;
			case "M":
				$type = "Human";
				break;
			case "T":
				$type = "Valuables";
				break;
			case "A":
				$type = "All";
				break;
			default:
				break;
		}
		
		$device_info = array();
		
		$response_data = array(
				'status' => 'fail',
				'device_info' => $device_info
		);
		
		//if api_key match, continue...; otherwise, return fail
		if($this->_api_key == $this->_apikey) {
			
			//if email-serial_number pair exists in the system, then continue...; otherwise, fail.
			if(Device::count(array("conditions" => "email = '{$this->_email}' AND serial_number = '{$serial_number}'")) > 0) {
			//if serial number exists, then continue...; otherwise, return fail
			//if(Device::count("serial_number = '{$serial_number}'") > 0) {
		
				//get info under given serial number
				$device = Device::findFirst("serial_number = '{$serial_number}'");
				
				/**
				 from terry 
					
				switch(strtolower($category)) {
					case "dogs":
						$category = "pet";
						$sql = <<<EOT
select devices.did,devices.serial_number,devices.status,
pet_info.name as pet_name,pet_info.sex 
from devices 
left outer join pet_info on pet_info.did = devices.did 
where devices.email = '{$_POST['email']}' 
EOTl
		
					    $query = $this->db->query($sql);
		   				$result = $query->fetch();
		   				
		   				if(!empty($result)) {
		   				//$result = array ("id" => id,serial_number => serial_number....);
		   				
	   						$this->db->query("select photo from photos where did={$result['id']}");
		    				$result['photos'] = $query->fetchAll();
		   				//$result = array ("id" => id,serial_number => serial_number....,"photos" => array());
		   				}
						break;
					case "cats":
						$type = "pet";
						break;
					default:s
						break;
				}
				
				**/
		
				if($type == 'Pets') {
					$pet_info = PetInfo::findFirst(array("did = '{$device->did}'", "columns" => "name, sex, birthday, height,
													weight, temperament, talents, description, chip_number, desex, vaccine_type,
													bloodtype, bloodbank, disability, insurance, hospital_name, hospital_phone,
													hospital_address"));
					
					$device_info[] = $pet_info;
				}
				else if($type == 'Human') {
					$human_info = HumanInfo::findFirst(array("did = '{$device->did}'", "columns" => "firstname, lastname, nickname,
														sex, birthday, height, weight, bloodtype, disease, disability, medications,
														hospital_name, hospital_phone, hospital_address"));
					
					$device_info[] = $human_info;
				}
				else if($type == 'Valuables') {
					$valuable_info = ValuableInfo::findFirst(array("did = '{$device->did}'",  "columns" => "name, description"));
					
					$device_info[] = $valuable_info;
				}
				else {
					//echo "No category found.";
				}
				
				$response_data = array(
						'status' => 'success',
						'device_info' => $device_info
				);
			}
		}
		
		$this->response->setContent(json_encode($response_data));
		$this->response->send();
	}

	public function getPhotosAction() {
		$serial_number = strtoupper($this->_request->getPost('serial_number'));
		
		$photos = array();
		
		$response_data = array(
				'status' => 'fail',
				'photos' => $photos
		);
		
		//sample data
		//$this->_api_key = 'qwe123';
		//$this->_apikey = 'qwe123';
		//$this->_email = 'brucelee@gmail.com';
		//$serial_number = 'INK46XFKMX';
		//$type = 'valuable';
		
		//if api_key match, continue...; otherwise, return fail
		if($this->_api_key == $this->_apikey) {

			//if email-serial_number pair exists in the system, then continue...; otherwise, fail.
			if(Device::count(array("conditions" => "email = '{$this->_email}' AND serial_number = '{$serial_number}'")) > 0) {
			//if serial number exists, then continue...; otherwise, return fail
			//if(Device::count("serial_number = '{$serial_number}'") > 0) {
				
				//find all photos under given serial number
				$device = Device::findFirst("serial_number = '{$serial_number}'");
				
				$photos = Photos::find("did = '{$device->did}'");
				
				foreach ($photos as $photo) {
					$photo_list[] = $photo->photo;
				}
					
				$response_data = array(
						'status' => 'success',
						'photos' => $photo_list
				);

			}
		}
		
		$this->response->setContent(json_encode($response_data));
		$this->response->send();
	}
	
	/**
	 * name = photo[photo_id] when update
	 */
	
	public function deleteAllPhotosAction() {
		$serial_number = strtoupper($this->_request->getPost('serial_number'));
		
		$response_data = array(
				'status' => 'fail'
		);
		
		//sample data
		//$this->_api_key = 'qwe123';
		//$this->_apikey = 'qwe123';
		//$this->_email = 'brucelee@gmail.com';
		//$serial_number = 'INK46XFKMX';
		
		//if api_key match, continue...; otherwise, return fail
		if($this->_api_key == $this->_apikey) {
			
			//if email-serial_number pair exists in the system, then continue...; otherwise, fail.
			if(Device::count(array("conditions" => "email = '{$this->_email}' AND serial_number = '{$serial_number}'")) > 0) {
			//if serial number exists, then continue...; otherwise, return fail
			//if(Device::count("serial_number = '{$serial_number}'") > 0) {
		
				//Photos:
				//find did
				$device = Device::findFirst("serial_number = '{$serial_number}'");
		
				$photos = Photos::find("did = '{$device->did}'");
				
				foreach ($photos as $photo) {
					//$path = preg_replace("http://{$_SERVER['HTTP_HOST']}/","",$photo->photo);
					//var_dump($path);
					//unlink($path);
					//need testing
					$name = $photo->name;
					$newname = preg_replace("/http://{$_SERVER['HTTP_HOST']}/upload//", "", $name);
					$path = getcwd();
					unlink($path . "\\upload\\" . $newname);
					$photo->delete();
				}
				
				$response_data = array(
						'status' => 'success'
				);
			}
		}
		
		$this->response->setContent(json_encode($response_data));
		$this->response->send();
	}
	
	public function getStatusAction() {
		$serial_number = strtoupper($this->_request->getPost('serial_number'));
		
		$tag_status = null;
		
		//sample data
		//$this->_api_key = 'qwe123';
		//$this->_apikey = 'qwe123';
		//$serial_number = 'AB4B46XFKMX';
		
		$response_data = array(
				'status' => 'fail',
				'tag_status' => $tag_status
		);
		
		//if api_key match, continue...; otherwise, return fail
		if($this->_api_key == $this->_apikey) {
			
			//if serial number exists, then continue...; otherwise, return fail
			if(Device::count("serial_number = '{$serial_number}'") > 0) {
				
				//find status
				$device = Device::findFirst("serial_number = '{$serial_number}'");
				
				$tag_status = $device->status;
			}
			else {
				$tag_status = 'invalid';
			}
			
			$response_data = array(
					'status' => 'success',
					'tag_status' => $tag_status
			);
		}
		
		$this->response->setContent(json_encode($response_data));
		$this->response->send();
	}
	
	public function importAction() {

		$this->view->disable();
		$file = getcwd()."/data/test_serial.csv";
		
		if (($handle = fopen($file, "r")) !== FALSE) {
			while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
				
				$device = new Device();
				$device->serial_number = $data[1];
				$device->status = 'new';
				$device->create();
			}
			
			fclose($handle);
		}
	}
}