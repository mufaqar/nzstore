<?php


// function generateRandomString($length = 10) {
// 	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
// 	$charactersLength = strlen($characters);
// 	$randomString = '';
// 	for ($i = 0; $i < $length; $i++) {
// 		$randomString .= $characters[rand(0, $charactersLength - 1)];
// 	}
// 	return $randomString;
// }

// function sendmail($to,$password) {
// 	$to = $to;
// 	$admin = 'hei@doubledowndish.no';
// 	$subject = 'Double Down Dish | Username & Password';
// 	$body  = "<p><strong> Username :  </strong> $to </p> <p> <strong> Password : </strong> $password  </p>";
// 	$headers = array('Content-Type: text/html; charset=UTF-8');	
// 	$headers  = "From: " . $admin . "\r\n";
// 	$headers .= "Reply-To: " . $to . "\r\n";		
// 	$headers .= "MIME-Version: 1.0\r\n";
// 	$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
// 	mail( $to, $subject, $body, $headers );
// 	}



// add_action('wp_ajax_usersignup', 'usersignup', 0);
// add_action('wp_ajax_nopriv_usersignup', 'usersignup');


// function usersignup() {	

// 	  //require_once('../../../wp-config.php');
// 	  global $wpdb;


		
// 	  $username = ($_POST['username']);
//       $email = ($_POST['username']);
//       $phone = stripcslashes($_POST['phone']);
//       $referral = stripcslashes($_POST['referral']);	
//       $name = stripcslashes($_POST['name']);  
// 	  $password = generateRandomString();	
// 	  $user_data = array(
// 		'user_login' => $username,
// 		'user_email' => $email,
// 		'user_pass' => $password,	
// 		'display_name' => $name,
// 		'role' => 'company'
// 		);
// 	    $user_id = wp_insert_user($user_data);
// 	  	if (!is_wp_error($user_id)) {		    
// 			sendmail($username,$password);
// 			echo wp_send_json( array('code' => 200 , 'message'=>__('We have Created an account for you.')));

// 	  	} else {
// 	    	if (isset($user_id->errors['empty_user_login'])) {
	          
// 			  echo wp_send_json( array('code' => 0 , 'message'=>__('User Name and Email are mandatory')));
// 	      	} elseif (isset($user_id->errors['existing_user_login'])) {
// 	         // echo 'User name already exixts.';
// 			  echo wp_send_json( array('code' => 0 , 'message'=>__('This email address is already registered.')));
// 	      	} else {	         
// 			  echo wp_send_json( array('code' => 0 , 'message'=>__('Error Occured please fill up the sign up form carefully.')));
// 	      	}
// 	  	}
// 	die;   
		
// }




add_action('wp_ajax_resetpassword', 'resetpassword', 0);
add_action('wp_ajax_nopriv_resetpassword', 'resetpassword');
function resetpassword() {	
	  $username = stripcslashes($_POST['username']);	
	  $password = generateRandomString();		
	  global $wpdb;  
    //We shall SQL escape all inputs  
      $username = $_POST['username'];
      $email = $_POST['username'];    
	  $password = generateRandomString();	
	  $user_data = array(
		'user_login' => $username,
		'user_email' => $username,
		'user_pass' => $password,	
		
		);

		$user = get_user_by( 'email', $email );
		$user_id = $user->ID;
	    $user_id = wp_update_user( array ( 'ID' => $user_id, 'user_pass' => $password ) );	
	  	if (!is_wp_error($user_id)) {		    
			sendmail($username,$password);
			echo wp_send_json( array('code' => 200 , 'message'=>__('Password Updated , Please check your email')));
	  	} else {	    		         
			  echo wp_send_json( array('code' => 0 , 'message'=>__('Error Occured please check your email address')));
	      	}
	  	
	die;   	
		
}





add_action('wp_ajax_add_employes', 'add_employes', 0);
add_action('wp_ajax_nopriv_add_employes', 'add_employes');
function add_employes() {	
	
		global $wpdb;		
		$uid = $_POST['uid'];
		$invite_user1 = $_POST['email'];
		$password = generateRandomString();	


		
		$user_data = array(
			'user_login' => $invite_user1,
			'user_email' => $invite_user1,
			'user_pass' => $password,	
			'role' => 'personal'
			);
	    $user_id = wp_insert_user($user_data);
		
	  	if (!is_wp_error($user_id)) {

			update_user_meta( $user_id, 'employee', $uid);
			update_user_meta( $user_id, 'status', 'active');
			sendmail($invite_user1,$password);
			//update_user_meta( $uid, 'employer', $user_id);
			echo wp_send_json( array('code' => 0 , 'message'=>__('New user Created for this Compnay')));
			
			//echo wp_send_json( array('code' => 200 , 'message'=>__('we have Created an account for you.')));

	  	} else {
	    		         
			  echo wp_send_json( array('code' => 0 , 'message'=>__('Error Occured please fill up the sign up form carefully.')));
	      	
	  	}
	die;
		
}





add_action('wp_ajax_de_activate_employees', 'de_activate_employees', 0);
add_action('wp_ajax_nopriv_de_activate_employees', 'de_activate_employees');
function de_activate_employees() {	
	
		global $wpdb;		
		$uid = $_POST['uid'];
		$active_emp = $_POST['active_emp'];
		foreach($active_emp as $active_emp)
		{
			update_user_meta( $active_emp, 'status', 'inactive');
		}

		echo wp_send_json( array('code' => 0 , 'message'=>__('Selected employees updated with deactive status')));
	  
		die;
		
}



add_action('wp_ajax_activate_employees', 'activate_employees', 0);
add_action('wp_ajax_nopriv_activate_employees', 'activate_employees');
function activate_employees() {	
	
		global $wpdb;		
		$uid = $_POST['uid'];
		$active_emp = $_POST['active_emp'];
		foreach($active_emp as $active_emp)
		{
			update_user_meta( $active_emp, 'status', 'active');
		}

		echo wp_send_json( array('code' => 0 , 'message'=>__('Selected employees updated with active status')));
	  
		die;
		
}












