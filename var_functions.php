<?php
  class var_functions{
    /**
	  Author: Justin Xyrel
	  Function: is_logged_in
	  Desc: checks if the user is logged in
	  Params: none
	*/
	public function is_logged_in(){
	    if(!isset($_SESSION)){
			session_start();
		}
		$result = (!empty($_SESSION['auth'])) ? true : false;
		return $result;
	}

	/**
	  Author: Justin Xyrel 
	  Function: parse_access 
	  Desc: parse the config ini file specifically the access module array
	  Params: none
	*/
	public function parse_access(){
	  $conf = parse_ini_file("config.ini",true);

      foreach($conf['access_module'] as $key => $val){
         $key_exp = explode('.',$key);
		 /*grouped the user type by creating a new array -JX*/
		 $user_access[$key_exp[0]][$key_exp[1]] = $val;
	  }
	  return $user_access;
	}	
	
	/**
	  Author: Justin Xyrel 
	  Function: check_user_access 
	  Desc: checks if user is allowed to view a specific module 
	  Params: {$mod_name : module name the user wants to view}	
   */
	 
	public function check_user_access($module = NULL){
		if(!isset($_SESSION)){
			session_start();
		}
	  $auth = $_SESSION['auth'][0];
	  $access_module = $this->parse_access();
	  return $access_module[$auth['user_type']][$module];
     }

    public function generate_password($length = 8) {
		$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		$count = mb_strlen($chars);

		for ($i = 0, $result = ''; $i < $length; $i++) {
			$index = rand(0, $count - 1);
			$result .= mb_substr($chars, $index, 1);
		}

		return $result;
	}	 
	
	
	public function get_error_msg($err_code){
	  $error = array(
			'1'=> 'The email address is already taken',
	  
	  );

      return $error[$err_code];	  
	
	}
	 


  }

?>