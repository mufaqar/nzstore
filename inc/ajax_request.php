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
	$user_id = wp_insert_post($post);
	if (!is_wp_error($user_id)) {
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
	$user_id = wp_update_post($post);
	if (!is_wp_error($user_id)) {
		//sendmail($username,$password);

		
			$query_meta = array(
				'posts_per_page' => -1,
				'post_type' => 'orders',
				'meta_query' => array(
					array(
						'key'     => 'order_id',
						'value' => $user_id,
						'compare' => '=='
					)
				)
			);		

		   $postinweek = new WP_Query($query_meta);
		if ( $postinweek->have_posts() ): while ( $postinweek->have_posts() ): $postinweek->the_post();	
				// Updated order if exist	
				$updated_post_id = get_the_ID();
				update_post_meta($updated_post_id, 'order_price', $price);
				update_post_meta($updated_post_id, 'order_status','Pending');			
				echo wp_send_json(array('code' => 200, 'message' => __('Order Sucessfully Updated')));
				die;
		endwhile; wp_reset_query(); else : 	
			// Insert post as its not exisit 
			$order_arg = array(	
				'post_title'    => "OHYSX-" . rand(10, 100),
				'post_status'   => 'publish',
				'post_type'     => 'orders',
				'meta_input'   => array(
					'date' => $date,
					'order_id' => $user_id,
					'order_price' => $price,
					'order_status' => 'Pending',
				)
			);	
			$inovice_id = wp_insert_post($order_arg);
			echo wp_send_json(array('code' => 0, 'message' => __('Order Sucessfully Updated.')));
			die;

		endif; 



		

	}

	die;
}

