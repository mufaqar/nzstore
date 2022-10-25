<?php




function sendmail_signup($to,$password) {
	$to = $to;
	$admin = 'no_repley@kiwimobile.co.nz';
	$subject = 'Kiwi Mobile  | Username & Password';
	$body  = "<p><strong> Username :  </strong> $to </p> <p> <strong> Password : </strong> $password  </p>";
	$headers = array('Content-Type: text/html; charset=UTF-8');	
	$headers  = "From: " . $admin . "\r\n";
	$headers .= "Reply-To: " . $to . "\r\n";		
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
	mail( $to, $subject, $body, $headers );
}



// add_action('wp_ajax_agent_signup', 'agent_signup', 0);
// add_action('wp_ajax_nopriv_agent_signup', 'agent_signup');


// function usersignup() {	

   

   

// 	  global $wpdb;
//       $username = $_POST['agent_email'];
//       $agent_email = $_POST['agent_email'];
//       $agent_name = $_POST['agent_name'];
//       $business_address = $_POST['business_address'];	
//       $business_name = $_POST['business_name'];  
//       $business_phone = $_POST['business_phone'];  
//       $postal_code = $_POST['postal_code'];  
// 	  $password = generateRandomString(20);	
// 	  $user_data = array(
// 		'user_login' => $username,
// 		'user_email' => $agent_email,
// 		'user_pass' => $password,	
// 		'display_name' => $agent_name,
// 		'role' => 'agent'
// 		);
// 	    $user_id = wp_insert_user($user_data);
// 	  	if (!is_wp_error($user_id)) {	
//             update_user_meta( $user_id,'business_name', $business_name);	 
//             update_user_meta( $user_id,'business_phone', $business_phone);	  
//             update_user_meta( $user_id,'postal_code', $postal_code);	    
// 			//sendmail_signup($username,$password);
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

//           echo wp_send_json( array('code' => 200 , 'message'=>__('last Message')));
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








