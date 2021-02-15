<?php

class forms{
	
	private $cmd_log = '';
	
	private $key_array = array();
	private $data_array = array();

	private $form_posted_array = array();
	
	public $returned_posted_array = array();
	
	public function __construct() {
		$this->cmd_log = 'form started';
  	}
	
	public function __destruct(){
		//
	}
			
	//Forms Post functions
	public function post($posted_array){
		$this->form_posted_array = $posted_array;
		$forms = new stdClass();		
		if(is_array($posted_array)){
			foreach($posted_array as $key =>$val){
				if(is_array($val)){
					$this->returned_posted_array[$key] = $val ;
					$forms->$key = $val ;
				}else{
					$this->returned_posted_array[$key] = $this->mysql_prepare_value( $val );
					$forms->$key = $this->mysql_prepare_value( $val );
				}
			}
			return $forms;
		} else {
      		exit('Error: Form not good');
    	}
  	}



	public function mysql_prepare_value($value) {
		//check if get_magic_quotes_gpc is turned on.
		$magic_quotes_active = get_magic_quotes_gpc();
		$new_version_php = function_exists("mysql_real_escape_string");
		
		if($new_version_php){
			//undo any magic quote effects so mysql_real_escape_string can do the work
			if($magic_quotes_active) { $value = stripslashes($value); }
			$value = mysql_real_escape_string($value);
		} else {
				//if magic quotes aren't already on then add slashes manually
				if( !$magic_quotes_active ) { $values = addslashes( $value ); }
				//if magic quotes are active, then the slashes already exist
			}
		return $value;
	}



}


?>