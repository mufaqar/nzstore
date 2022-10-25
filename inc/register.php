<?php


function send_mail_password($to,$password) {
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
			send_mail_password($username,$password);
			echo wp_send_json( array('code' => 200 , 'message'=>__('Password Updated , Please check your email')));
	  	} else {	    		         
			  echo wp_send_json( array('code' => 0 , 'message'=>__('Error Occured please check your email address')));
	      	}
	  	
	die;   	
		
}








