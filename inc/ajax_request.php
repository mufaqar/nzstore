<?php


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


	    $image_url        = $file_url; // Define the image URL here
		$image_name       = $file_name;
		$upload_dir       = wp_upload_dir(); // Set upload folder
		$image_data       = file_get_contents($image_url); // Get image data
		$unique_file_name = wp_unique_filename( $upload_dir['path'], $image_name ); // Generate unique name
		$filename         = basename( $unique_file_name ); // Create image file name
		
		// Check folder permission and define file location
		if( wp_mkdir_p( $upload_dir['path'] ) ) {
			$file = $upload_dir['path'] . '/' . $filename;
		} else {
			$file = $upload_dir['basedir'] . '/' . $filename;
		}
		// Create the image  file on the server
		file_put_contents( $file, $image_data );
			// Check image file type
		$wp_filetype = wp_check_filetype( $filename, null );
		
		// Set attachment data
		$attachment = array(
			'post_mime_type' => $wp_filetype['type'],
			'post_title'     => sanitize_file_name( $filename ),
			'post_content'   => '',
			'post_status'    => 'inherit'
		);



	if (!is_wp_error($inserted_post_id)) {

		// Create the attachment
		$attach_id = wp_insert_attachment( $attachment, $file, $inserted_post_id );
		 // Include image.php
		 require_once(ABSPATH . 'wp-admin/includes/image.php');
		   // Define attachment metadata
		   $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
		    // Assign metadata to attachment
		  wp_update_attachment_metadata( $attach_id, $attach_data );

		   // And finally assign featured image to post
		   set_post_thumbnail( $inserted_post_id, $attach_id );
		//sendmail($username,$password);
		echo wp_send_json(array('code' => 200, 'message' => __('Ticket Created Sucessfully')));
	} else {
		echo wp_send_json(array('code' => 0, 'message' => __('Error Occured please fill up form carefully.')));
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
	$user_id = wp_update_post($post);
	if (!is_wp_error($user_id)) {
		//sendmail($username,$password);
		echo wp_send_json(array('code' => 200, 'message' => __('Ticket Updated Sucessfully')));
	} else {
		echo wp_send_json(array('code' => 0, 'message' => __('Error Occured please fill up form carefully.')));
	}

	die;
}




add_action('wp_ajax_admin_update_ticket', 'admin_update_ticket', 0);
add_action('wp_ajax_nopriv_admin_update_ticket', 'admin_update_ticket');

function admin_update_ticket()
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
			'date' => $date,
			'user_type' => $user_type		
		),
		'tax_input'    => array(
			'ticket_type' => array($ticket_type),
			'ticket_priority' => array($ticket_priority),
			'ticket_status' => array($ticket_status),
			'ticket_cat' => array($ticket_cat)
		),

	);
	$ticket_id = wp_update_post($post);
	if (!is_wp_error($ticket_id)) {
		//sendmail($username,$password);		
			$query_meta = array(
				'posts_per_page' => -1,
				'post_type' => 'orders',
				'meta_query' => array(
					array(
						'key'     => 'order_id',
						'value' => $ticket_id,
						'compare' => '=='
					)
				)
			);		

		   $postinweek = new WP_Query($query_meta);
		if ( $postinweek->have_posts() ): while ( $postinweek->have_posts() ): $postinweek->the_post();	
				// Updated order if exist
				if( has_term('Completed', 'ticket_type' , $ticket_id) ){	
				$updated_post_id = get_the_ID();
				update_post_meta($updated_post_id, 'order_price', $price);
				update_post_meta($updated_post_id, 'order_status','Pending');			
				echo wp_send_json(array('code' => 200, 'message' => __('Order Sucessfully Updated')));
				}
				die;
		endwhile; wp_reset_query(); else : 	
			// Insert post as its not exisit 
			$order_arg = array(	
				'post_title'    => "OHYSX-" . rand(10, 100),
				'post_status'   => 'publish',
				'post_type'     => 'orders',
				'meta_input'   => array(
					'date' => $date,
					'order_id' => $ticket_id,
					'order_price' => $price,
					'order_status' => 'Pending',
				)
			);
			if( has_term('Completed', 'ticket_type' , $ticket_id) ){
				$inovice_id = wp_insert_post($order_arg);	
				echo wp_send_json(array('code' => 0, 'message' => __('Invoice Created ')));			
			}
			
			echo wp_send_json(array('code' => 0, 'message' => __('Order Sucessfully Updated.')));
			die;

		endif; 



		

	}

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
	


	echo wp_send_json(array('code' => 0, 'message' => __('Invoice Sucessfully Updated.')));
	die;


}

