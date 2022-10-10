<?php


function sendmail($agent_email,$message,$postid) {
	$admin = 'budgetcomputer2013@gmail.com,mufaqar@gmail.com';
	$to = 'info@kiwimobiles.co.nz';
	$subject = "Budget Computer |  $message ";
	$body  = "<p><strong> $message  </strong> <br/> Ticket   :  ".get_permalink($postid)."  </p>";
	$headers = array('Content-Type: text/html; charset=UTF-8');	
	$headers  = "From: " . $to . "\r\n";
	$headers .= "Reply-To: " . $agent_email . "\r\n";
	$headers .= "Cc: $agent_email" . "\r\n";	
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
	mail( $admin, $subject, $body, $headers );
	//$get_notifcation = get_post_meta( $postid, 'notification', true); 
	//$count = $get_notifcation;
	//update_post_meta( $postid, 'notification', $count+1); 
	//echo "Email sent to : $to and $agent_email";
	}





add_action('wp_ajax_add_ticket', 'add_ticket', 0);
add_action('wp_ajax_nopriv_add_ticket', 'add_ticket');

function add_ticket()
{
	global $wpdb;
	$title = $_POST['title'];
	$date = $_POST['date'];
	$address = $_POST['address'];
	$ticket_type = $_POST['ticket_type'];
	$ticket_priority = $_POST['ticket_priority'];
	$ticket_status = $_POST['ticket_status'];
	$ticket_cat = $_POST['ticket_cat'];
	$issues = $_POST['issues'];
	$shipping = $_POST['shipping'];
	$user_type = $_POST['user_type'];
	$uid = $_POST['uid'];
	$file_name = $_FILES["file"]["name"];
	$file_url        = $_FILES["file"]["tmp_name"]; 
	$post = array(
		'post_title'    => $title,
		'post_status'   => 'publish',
		'post_content'   => $issues,
		'post_type'     => 'tickets',
		'meta_input'   => array(
			'title' => $title,
			'address' => $address,
			'shipping' => $shipping,
			'issues' => $issues,
			'date' => $date,
			'user_type' => $user_type,
			'order_uid' => $uid,
		),
		'tax_input'    => array(
			'ticket_type' => array($ticket_type),
			'ticket_priority' => array($ticket_priority),
			'ticket_status' => array($ticket_status),
			'ticket_cat' => array($ticket_cat)
		),

	);
		$inserted_post_id = wp_insert_post($post);
		$user = get_user_by( 'id', $uid );
		$agent_email = $user->user_email;
		sendmail($agent_email,"New Ticket Created by $agent_email ", $inserted_post_id);

	    $image_url        = $file_url; // Define the image URL here
		$image_name       = $file_name;
		$upload_dir       = wp_upload_dir(); // Set upload folder
		$image_data       = file_get_contents($image_url); // Get image data
		$unique_file_name = wp_unique_filename( $upload_dir['path'], $image_name ); // Generate unique name
		$filename         = basename( $unique_file_name ); // Create image file name
		if( wp_mkdir_p( $upload_dir['path'] ) ) {
			$file = $upload_dir['path'] . '/' . $filename;
		} else {
			$file = $upload_dir['basedir'] . '/' . $filename;
		}
		file_put_contents( $file, $image_data );
		$wp_filetype = wp_check_filetype( $filename, null );
		$attachment = array(
			'post_mime_type' => $wp_filetype['type'],
			'post_title'     => sanitize_file_name( $filename ),
			'post_content'   => '',
			'post_status'    => 'inherit'
		);



	if (!is_wp_error($inserted_post_id)) {	

		// Create the attachment
		$attach_id = wp_insert_attachment( $attachment, $file, $inserted_post_id );
		 require_once(ABSPATH . 'wp-admin/includes/image.php');
		 $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
		wp_update_attachment_metadata( $attach_id, $attach_data );
		set_post_thumbnail( $inserted_post_id, $attach_id );
		echo wp_send_json(array('code' => 200, 'message' => __('Ticket Created Sucessfully')));
		die();
	} else {
		echo wp_send_json(array('code' => 0, 'message' => __('Error Occured please fill up form carefully.')));
		die();
	}

	die;
}


add_action('wp_ajax_update_ticket', 'update_ticket', 0);
add_action('wp_ajax_nopriv_update_ticket', 'update_ticket');

function update_ticket()
{


	global $wpdb;
	$pid = $_POST['pid'];
	$title = $_POST['title'];
	$date = $_POST['date'];
	$address = $_POST['address'];
	$ticket_type = $_POST['ticket_type'];
	$ticket_priority = $_POST['ticket_priority'];
	$ticket_status = $_POST['ticket_status'];
	$ticket_cat = $_POST['ticket_cat'];
	$issues = $_POST['issues'];
	$shipping = $_POST['shipping'];
	$user_type = $_POST['user_type'];
	$uid = $_POST['uid'];
	$post = array(
		'ID' => $pid,
		'post_title'    => $title,
		'post_status'   => 'publish',
		'post_content'   => $issues,
		'post_type'     => 'tickets',
		'meta_input'   => array(
			'title' => $title,
			'address' => $address,
			'shipping' => $shipping,
			'issues' => $issues,
			'date' => $date,
			'user_type' => $user_type
		
		),
		'tax_input'    => array(
			'ticket_type' => array($ticket_type),
			'ticket_priority' => array($ticket_priority),
			'ticket_status' => array($ticket_status),
			'ticket_cat' => array($ticket_cat),
			
		),

	);
		$update_post = wp_update_post($post);
		$user = get_user_by( 'id', $uid );
		$agent_email = $user->user_email;
		

	if (!is_wp_error($update_post)) {
		sendmail($agent_email,"Ticket Updated by $agent_email ", $pid);
	
		echo wp_send_json(array('code' => 200, 'message' => __('Ticket Updated Sucessfully')));
		die();
	} else {
		echo wp_send_json(array('code' => 0, 'message' => __('Error Occured please fill up form carefully.')));
		die();
	}

	die;
}




add_action('wp_ajax_tech_update_ticket', 'tech_update_ticket', 0);
add_action('wp_ajax_nopriv_tech_update_ticket', 'tech_update_ticket');

function tech_update_ticket()
{


	global $wpdb;
	$pid = $_POST['pid'];	
	$title = $_POST['title'];
	$date = $_POST['date'];
	$address = $_POST['address'];
	$ticket_type = $_POST['ticket_type'];
	$ticket_priority = $_POST['ticket_priority'];
	$ticket_status = $_POST['ticket_status'];
	$ticket_cat = $_POST['ticket_cat'];
	$eng_remarks = $_POST['eng_remarks'];
	$internal_remarks = $_POST['internal_remarks'];
	$user_type = $_POST['user_type'];
	$pid = $_POST['pid'];
	$invoice = $_POST['invoice'];
	$price = $_POST['price'];
	$tech_uid = $_POST['uid'];	
	$file_name = $_FILES["file"]["name"];
	$file_url        = $_FILES["file"]["tmp_name"]; 

	$post = array(
		'ID' => $pid,
		'post_title'    => $title,
		'post_status'   => 'publish',
		'post_content'   => $issues,
		'post_type'     => 'tickets',
		'meta_input'   => array(
			'title' => $title,
			'address' => $address,
			'eng_remarks' => $eng_remarks,
			'internal_remarks' => $internal_remarks,
			'invoice' => $invoice,	
			'price' => $price,			
			'date' => $date	
		),
		'tax_input'    => array(
			'ticket_type' => array($ticket_type),
			'ticket_priority' => array($ticket_priority),
			'ticket_status' => array($ticket_status),
			'ticket_cat' => array($ticket_cat)
		),

	);
	wp_update_post($post);

		$update_post = wp_update_post($post);
		$user_tech = get_user_by( 'id', $tech_uid );
		$tech_email = $user_tech->user_email;
		$ticket_uid = get_post_meta( $pid, 'order_uid', true);
		$user_agent =  get_user_by( 'id', $ticket_uid);
		$agent_email = $user_agent->user_email;
		$agent_email = $agent_email .",".$tech_email;
		sendmail($agent_email,"Technician [ $tech_email ] Updated Ticket  $pid ", $pid);
		echo $agent_email;




	$ticket_id = $pid;

		$image_url        = $file_url;
		$image_name       = $file_name;
		$upload_dir       = wp_upload_dir(); 
		$image_data       = file_get_contents($image_url); 
		$unique_file_name = wp_unique_filename( $upload_dir['path'], $image_name ); 
		$filename         = basename( $unique_file_name ); 
		if( wp_mkdir_p( $upload_dir['path'] ) ) {
			$file = $upload_dir['path'] . '/' . $filename;
		} else {
			$file = $upload_dir['basedir'] . '/' . $filename;
		}
		file_put_contents( $file, $image_data );
		$wp_filetype = wp_check_filetype( $filename, null );
		$attachment = array(
			'post_mime_type' => $wp_filetype['type'],
			'post_title'     => sanitize_file_name( $filename ),
			'post_content'   => '',
			'post_status'    => 'inherit'
		);


		$attach_id = wp_insert_attachment( $attachment, $file, $ticket_id );
		require_once(ABSPATH . 'wp-admin/includes/image.php');
		$attach_data = wp_generate_attachment_metadata( $attach_id, $file );
		wp_update_attachment_metadata( $attach_id, $attach_data );
		//sendmail($username,$password);		
			$query_meta = array(
				'posts_per_page' => -1,
				'post_type' => 'orders',
				'meta_query' => array(
					array(
						'key'     => 'order_id',
						'value' =>   $ticket_id,
						'compare' => '=='
					)
				)
			);		

		   $postinweek = new WP_Query($query_meta);
		if ( $postinweek->have_posts() ): while ( $postinweek->have_posts() ): $postinweek->the_post();	
			
				// Updated order if exist
				if( has_term('complete', 'ticket_type' , $ticket_id) ){	
				$updated_post_id = get_the_ID();
				update_post_meta($updated_post_id, 'order_price', $price);
				update_post_meta($updated_post_id, 'order_status','Pending');			
				echo wp_send_json(array('code' => 200, 'message' => __('Ticket Update with Invoice')));
				}
				die;
		endwhile; wp_reset_query(); else : 	
			// Insert post as its not exisit 
			
			$order_uid =   get_post_meta( $ticket_id, 'order_uid', true );
			$order_arg = array(	
				'post_title'    => "OHYSX-" . $ticket_id,
				'post_status'   => 'publish',
				'post_type'     => 'orders',
				'meta_input'   => array(
					'date' => $date,
					'order_id' => $ticket_id,
					'order_price' => $price,
					'invoice_uid' => $order_uid
				)
			);
			if( has_term('complete', 'ticket_type' , $ticket_id) ){
				$inovice_id = wp_insert_post($order_arg);	
				echo wp_send_json(array('code' => 0, 'message' => __('Tecket updated and Invoice created.')));	
				echo "Yes Term Inovice";
			}
			
		
			die;

		endif; 



		

	

	die;
}



add_action('wp_ajax_super_update_ticket', 'super_update_ticket', 0);
add_action('wp_ajax_nopriv_super_update_ticket', 'super_update_ticket');

function super_update_ticket()
{


	global $wpdb;
	$pid = $_POST['pid'];	
	$title = $_POST['title'];
	$date = $_POST['date'];
	$address = $_POST['address'];
	$ticket_type = $_POST['ticket_type'];
	$ticket_priority = $_POST['ticket_priority'];
	$ticket_status = $_POST['ticket_status'];
	$ticket_cat = $_POST['ticket_cat'];
	$eng_remarks = $_POST['eng_remarks'];
	$internal_remarks = $_POST['internal_remarks'];
	$user_type = $_POST['user_type'];
	$pid = $_POST['pid'];
	$invoice = $_POST['invoice'];
	$price = $_POST['price'];
	$tech_uid = $_POST['uid'];	
	$file_name = $_FILES["file"]["name"];
	$file_url        = $_FILES["file"]["tmp_name"]; 

	$post = array(
		'ID' => $pid,
		'post_title'    => $title,
		'post_status'   => 'publish',
		'post_content'   => $issues,
		'post_type'     => 'tickets',
		'meta_input'   => array(
			'title' => $title,
			'address' => $address,
			'eng_remarks' => $eng_remarks,
			'internal_remarks' => $internal_remarks,
			'invoice' => $invoice,	
			'price' => $price,			
			'date' => $date	
		),
		'tax_input'    => array(
			'ticket_type' => array($ticket_type),
			'ticket_priority' => array($ticket_priority),
			'ticket_status' => array($ticket_status),
			'ticket_cat' => array($ticket_cat)
		),

	);
		wp_update_post($post);

		$update_post = wp_update_post($post);
		$user = get_user_by( 'id', $tech_uid );
		$agent_email = $user->user_email;
		sendmail($agent_email,"Administrator [ $agent_email ] Updated Ticket  $pid ", $pid);




	$ticket_id = $pid;

		$image_url        = $file_url;
		$image_name       = $file_name;
		$upload_dir       = wp_upload_dir(); 
		$image_data       = file_get_contents($image_url); 
		$unique_file_name = wp_unique_filename( $upload_dir['path'], $image_name ); 
		$filename         = basename( $unique_file_name ); 
		if( wp_mkdir_p( $upload_dir['path'] ) ) {
			$file = $upload_dir['path'] . '/' . $filename;
		} else {
			$file = $upload_dir['basedir'] . '/' . $filename;
		}
		file_put_contents( $file, $image_data );
		$wp_filetype = wp_check_filetype( $filename, null );
		$attachment = array(
			'post_mime_type' => $wp_filetype['type'],
			'post_title'     => sanitize_file_name( $filename ),
			'post_content'   => '',
			'post_status'    => 'inherit'
		);


		$attach_id = wp_insert_attachment( $attachment, $file, $ticket_id );
		require_once(ABSPATH . 'wp-admin/includes/image.php');
		$attach_data = wp_generate_attachment_metadata( $attach_id, $file );
		wp_update_attachment_metadata( $attach_id, $attach_data );
		//sendmail($username,$password);		
			$query_meta = array(
				'posts_per_page' => -1,
				'post_type' => 'orders',
				'meta_query' => array(
					array(
						'key'     => 'order_id',
						'value' =>   $ticket_id,
						'compare' => '=='
					)
				)
			);		

		   $postinweek = new WP_Query($query_meta);
		if ( $postinweek->have_posts() ): while ( $postinweek->have_posts() ): $postinweek->the_post();	
			
				// Updated order if exist
				if( has_term('complete', 'ticket_type' , $ticket_id) ){	
				$updated_post_id = get_the_ID();
				update_post_meta($updated_post_id, 'order_price', $price);
				update_post_meta($updated_post_id, 'order_status','Pending');			
				echo wp_send_json(array('code' => 200, 'message' => __('Ticket Update with Invoice')));
				}
				die;
		endwhile; wp_reset_query(); else : 	
			// Insert post as its not exisit 
			
			$order_uid =   get_post_meta( $ticket_id, 'order_uid', true );
			$order_arg = array(	
				'post_title'    => "OHYSX-" . $ticket_id,
				'post_status'   => 'publish',
				'post_type'     => 'orders',
				'meta_input'   => array(
					'date' => $date,
					'order_id' => $ticket_id,
					'order_price' => $price,
					'invoice_uid' => $order_uid
				)
			);
			if( has_term('complete', 'ticket_type' , $ticket_id) ){
				$inovice_id = wp_insert_post($order_arg);	
				echo wp_send_json(array('code' => 0, 'message' => __('Tecket updated and Invoice created.')));	
				echo "Yes Term Inovice";
			}
			
		
			die;

		endif; 



		

	

	die;
}



add_action('wp_ajax_add_agent', 'add_agent', 0);
add_action('wp_ajax_nopriv_add_agent', 'add_agent');

function add_agent() {	


	global $wpdb;


	  
	$username = $_POST['email'];
	$email = $_POST['email'];		
	$name = $_POST['name'];  
	$password = $_POST['password'];	
	$user_type = $_POST['user_type'];	
	$user_data = array(
	  'user_login' => $username,
	  'user_email' => $email,
	  'user_pass' => $password,	
	  'display_name' => $name,
	  'role' => $user_type
	  );
	  $user_id = wp_insert_user($user_data);
		if (!is_wp_error($user_id)) {		    
		  sendmail($username,$password);
		  echo wp_send_json( array('code' => 200 , 'message'=>__('We have Created an account for you.')));

		} else {
		  if (isset($user_id->errors['empty_user_login'])) {
			
			echo wp_send_json( array('code' => 0 , 'message'=>__('User Name and Email are mandatory')));
			} elseif (isset($user_id->errors['existing_user_login'])) {
		   // echo 'User name already exixts.';
			echo wp_send_json( array('code' => 0 , 'message'=>__('This email address is already registered.')));
			} else {	         
			echo wp_send_json( array('code' => 0 , 'message'=>__('Error Occured please fill up the sign up form carefully.')));
			}
		}
  die;   
	  
}





add_action('wp_ajax_admin_update_invoice', 'admin_update_invoice', 0);
add_action('wp_ajax_nopriv_admin_update_invoice', 'admin_update_invoice');

function admin_update_invoice()
{

	global $wpdb;
	$pid = $_POST['pid'];	
	$order_status = $_POST['order_status'];
	$order_price_paid = $_POST['order_price_paid'];
	$admin_remarks = $_POST['admin_remarks'];
	$price = $_POST['price'];
	update_post_meta($pid, 'order_price_paid', $order_price_paid);
	update_post_meta($pid, 'admin_remarks', $admin_remarks);
	wp_set_object_terms( $pid, $terms, $taxonomy, $append ); 
	wp_set_post_terms( $pid, array( $order_status ), 'order_status' ); 
	echo wp_send_json(array('code' => 0, 'message' => __('Invoice Sucessfully Updated.')));
	die;


}

