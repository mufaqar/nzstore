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
			'ticket_status' => array($ticket_status)
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
			'user_type' => $user_type,
			'order_uid' => $uid,
		),
		'tax_input'    => array(
			'ticket_type' => array($ticket_type),
			'ticket_priority' => array($ticket_priority),
			'ticket_status' => array($ticket_status)
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


add_action('wp_ajax_weeklyfood', 'weeklyfood', 0);
add_action('wp_ajax_nopriv_weeklyfood', 'weeklyfood');

function weeklyfood()
{

	
	global $wpdb;

	$weekdays = $_POST['weekdays'];
	$usertype = $_POST['usertype'];
	$menu_items = $_POST['menu_items'];
	$uid = $_POST['uid'];
	$weekid = $_POST['weekid'];
	$total_days = count($weekdays);
	update_user_meta( $uid, $usertype.'_days', $total_days);

		$food_items = [];
				foreach ($menu_items as $menu_item) {
					$product_id = $menu_item[0];
					$menu_item = $menu_item[1];
					$food_items[$product_id] = $menu_item;
				
				}
		$days = [];	
		foreach ($weekdays as  $weekday) {
			$day = $weekday;		
			$days[$day]= $food_items;			
		}
	//	print_r($days);
		

			// check if order already placed by week
		$query_meta = array(
				'posts_per_page' => -1,
				'post_type' => 'orders',
				'meta_query' => array(
					'relation' => 'AND',
					array(
						'key' => 'order_week',
						'value' => $weekid,
						'compare' => '='
					),
					array(
						'key' => 'order_type',
						'value' => 'Weekly',
						'compare' => '='
					),
					array(
						'key'     => 'user_type',
						'value' => $usertype,
						'compare' => '='
					),
					array(
						'key'     => 'order_uid',
						'value' => $uid,
						'compare' => '='
					)
				)
			);


	

		$postinweek = new WP_Query($query_meta);
		if ( $postinweek->have_posts() ): while ( $postinweek->have_posts() ): $postinweek->the_post();		
			$updated_post_id = get_the_ID();	
			

			// If Menus are empty and days selected 
			if($menu_items == '')
			{

			
				$orders_price = get_post_meta($updated_post_id, 'food_order' , true);			
				$a1=$orders_price;
			//	unset($orders_price['Wednesday']);				
				$a2=$days;

				$result=array_diff_assoc($a1,$a2);

				//print_r($result);
				foreach ($result as $key => $value) {
					//echo $key;
					unset($orders_price[$key]);	
				}

				update_post_meta($updated_post_id, 'food_order', $orders_price);
				echo wp_send_json(array('code' => 200, 'message' => __('Order Sucessfully Updated {Day not seletc with 0 menu}')));
				die;
		

			}
			else{
				
				update_post_meta($updated_post_id, 'food_order', $days);
				$orders_price = get_post_meta($updated_post_id, 'food_order' , true);
				$price_arr = [];
				foreach($orders_price as $index => $order_price)
				{
					foreach($order_price as $key => $price )
					{   
						$get_price =  get_post_meta($key, 'menu_item_price', true);
						$price_arr[] = $get_price*$price;					
					}    			
				}
				$order_total = array_sum($price_arr);
				update_post_meta($updated_post_id, 'food_order', $days);
				update_post_meta($updated_post_id, 'order_total', $order_total);
				update_post_meta($updated_post_id, 'order_uid', $uid);
				update_post_meta($updated_post_id, 'user_type', $usertype);
				echo wp_send_json(array('code' => 200, 'message' => __('Order Sucessfully Updated')));
				die;
			


			}
			



		
			

		endwhile; wp_reset_query(); else : 		

			// Insert post as its not exisit 
					$postdata = array(
						'post_title'    => "OHYSX-" . rand(10, 100),
						'post_status'   => 'publish',
						'post_type'     => 'orders'
					);
					$user_id = wp_insert_post($postdata);
					add_post_meta($user_id, 'food_order', $days, true);				
					add_post_meta($user_id, 'order_week', $weekid, true);
					add_post_meta($user_id, 'order_status', 'Pending', true);
					add_post_meta($user_id, 'order_type', 'Weekly', true);
					add_post_meta($user_id, 'user_type', $usertype, true);
					add_post_meta($user_id, 'order_uid', $uid);

					$orders_price = get_post_meta($user_id, 'food_order' , true);
					$price_arr = [];
					foreach($orders_price as $index => $order_price)
					{
						foreach($order_price as $key => $price )
						{   
							$get_price =  get_post_meta($key, 'menu_item_price', true);
							$price_arr[] = $get_price*$price;							
						}    
					
					}
					$order_total = array_sum($price_arr);
					add_post_meta($user_id, 'order_total', $order_total,true);
					echo wp_send_json(array('code' => 200, 'message' => __('Order Sucessfully Created')));
					die;

		endif;
	
}



add_action('wp_ajax_weeklyfood_byday', 'weeklyfood_byday', 0);
add_action('wp_ajax_nopriv_weeklyfood_byday', 'weeklyfood_byday');

function weeklyfood_byday()
{
	global $wpdb;

	$sel_day = $_POST['sel_day'];
	$usertype = $_POST['usertype'];
	$menu_items = $_POST['menu_items'];
	$uid = $_POST['uid'];
	$weekid = $_POST['weekid'];
	$tdate = $_POST['tdate'];


	$daily_food = [];
	$product_items = array();
	foreach ($menu_items as $menu_item) {
		$product_id = $menu_item[0];
		$menu_item = $menu_item[1];		
		$product_items[$product_id] = $menu_item;
		$daily_food[$sel_day] = $product_items;
	}


	// check if order already placed by week
	$query_meta = array(
        'posts_per_page' => -1,
        'post_type' => 'orders',
		'meta_query' => array(
			'relation' => 'AND',
            array(
                'key' => 'order_week',
                'value' => $weekid,
                'compare' => '='
            ),
			array(
                'key' => 'order_type',
                'value' => 'Weekly',
                'compare' => '='
            ),
			array(
				'key'     => 'user_type',
				'value' => $usertype,
				'compare' => '='
			),
			array(
				'key'     => 'order_uid',
				'value' => $uid,
				'compare' => '='
			)
        )
    );

    $postinweek = new WP_Query($query_meta);
	if ( $postinweek->have_posts() ): while ( $postinweek->have_posts() ): $postinweek->the_post();			
		
		// updated Existing Food order Weekly 
		$updated_post_id = get_the_ID();			
		$food_orderd_data = array();
		$food_orderd_data = get_post_meta( $updated_post_id, 'food_order' , true);		
		//print_r($food_orderd_data);
		if (array_key_exists($sel_day,$food_orderd_data))
		{

			// Order Exisit and Days Exist
		
			unset($food_orderd_data[$sel_day]);
			$food_orderd_data[$sel_day] = array_shift($daily_food);	

			update_post_meta($updated_post_id, 'food_order', $food_orderd_data);
			$total_days = count($food_orderd_data);
			update_user_meta( $uid, $usertype.'_days', $total_days);
			$orders_price = get_post_meta($updated_post_id, 'food_order' , true);
			$price_arr = [];
			foreach($orders_price as $index => $order_price)
			{
				foreach($order_price as $pro_id => $pro_qty)
					{					
						$price =  get_post_meta($pro_id, 'menu_item_price', true);
						$price_arr[] = $price*$pro_qty;		
						
					}
			
			}
			$order_total = array_sum($price_arr);
			update_post_meta($updated_post_id, 'order_total', $order_total);
			echo wp_send_json(array('code' => 200, 'message' => __('Order Updated Sucessfully {Days Updated}')));
			die();		
		
		
		}
		else {	

				// Order Exisit and Days Not Found
			

			$food_orderd_data[$sel_day] = array_shift($daily_food);
			update_post_meta($updated_post_id, 'food_order', $food_orderd_data);
			$total_days = count($food_orderd_data);
			update_user_meta( $uid, $usertype.'_days', $total_days);			
			$orders_price = get_post_meta($updated_post_id, 'food_order' , true);
			$price_arr = [];
			foreach($orders_price as $index => $order_price)
			{
				foreach($order_price as $pro_id => $pro_qty)
					{					
						$price =  get_post_meta($pro_id, 'menu_item_price', true);
						$price_arr[] = $price*$pro_qty;		
						
					}
			
			}
			$order_total = array_sum($price_arr);
			update_post_meta($updated_post_id, 'order_total', $order_total);
			echo wp_send_json(array('code' => 200, 'message' => __('Order Updated Sucessfully { Days Added }')));			
			die();
			
			

			}

	endwhile; wp_reset_query(); else : 	

		
		$postdata = array(
			'post_title'    => "OHYSX-" . rand(10, 100),
			'post_status'   => 'publish',
			'post_type'     => 'orders'
		);
		$user_id = wp_insert_post($postdata);
		add_post_meta($user_id, 'food_order', $daily_food, true);
		add_post_meta($user_id, 'order_uid', $uid, true);
		add_post_meta($user_id, 'order_week', $weekid, true);
		add_post_meta($user_id, 'order_status', 'Pending', true);
		add_post_meta($user_id, 'order_type', 'Weekly', true);
		add_post_meta($user_id, 'user_type', $usertype, true);	

		
		if (!is_wp_error($user_id)) {

			$orders_price = get_post_meta($user_id, 'food_order' , true);
			$price_arr = [];
			foreach($orders_price as $index => $order_price)
			{
				foreach($order_price as $pro_id => $pro_qty)
					{					
						$price =  get_post_meta($pro_id, 'menu_item_price', true);
						$price_arr[] = $price*$pro_qty;			
						
					}
			
			}
			$order_total = array_sum($price_arr);
			update_post_meta($user_id, 'order_total', $order_total);
			//sendmail($username,$password);
			echo wp_send_json(array('code' => 200, 'message' => __('Order Sucessfully Create')));
		} else {
			echo wp_send_json(array('code' => 0, 'message' => __('Error Occured please fill up form carefully.')));
		}
		

		endif;

	die;
}



add_action('wp_ajax_dailyfood', 'dailyfood', 0);
add_action('wp_ajax_nopriv_dailyfood', 'dailyfood');

function dailyfood()
{
	global $wpdb;
	$day = $_POST['date'];
	$menu_items = $_POST['menu_items'];
	$uid = $_POST['uid'];
	$weekid = $_POST['weekid'];
	$usertype = $_POST['usertype'];	
	$author_obj = get_user_by('id', $uid);
	$author =  $author_obj->display_name;	
	$tdate = new DateTime($day);
	$week = $tdate->format("W");
	$food_items = [];
	foreach ($menu_items as $menu_item) {
		$product_id = $menu_item[0];
		$menu_item = $menu_item[1];			
		$food_items[$product_id] = $menu_item;
	
	}



	$days = [];
	$days[$day] = $food_items;
	// check if order already placed by week
	$query_meta = array(
        'posts_per_page' => -1,
        'post_type' => 'orders',
        'meta_query' => array(
			'relation' => 'AND',
            array(
                'key' => 'order_day',
                'value' => $day,
                'compare' => '='
            ),
			array(
				'key'     => 'user_type',
				'value' => $usertype,
				'compare' => '='
			),
        )
    );	

    $postinweek = new WP_Query($query_meta);
	if ( $postinweek->have_posts() ): while ( $postinweek->have_posts() ): $postinweek->the_post();



	    // updated Existing Food order Weekly 
		$updated_post_id = get_the_ID();	
		update_post_meta($updated_post_id, 'food_order', $days);
		update_post_meta($updated_post_id, 'order_uid', $uid);	
		$orders_price_data = get_post_meta($updated_post_id, 'food_order' , true);
		
		$price_arr = [];
		foreach($orders_price_data[$day] as $key=> $order_price)
		{	
			$product_id =  $key;
			$product_qty =  $order_price;
			$price_item =  get_post_meta($product_id, 'menu_item_price', true);			
			$price_arr[] = $price_item*$product_qty;				
				
		}
		$order_total = array_sum($price_arr);
		update_post_meta($updated_post_id, 'order_total', $order_total);
		echo wp_send_json(array('code' => 200, 'message' => __('Order Updated Sucessfully')));
		die();
		


	

endwhile; wp_reset_query(); else : 

	// Insert post as its not exisit 

	
		$post = array(
			'post_title'    => "OHYSX-" . rand(10, 100),
			'post_status'   => 'publish',
			'post_type'     => 'orders',
			'post_author' => $uid
		);
		$user_id = wp_insert_post($post);
		add_post_meta($user_id, 'order_day', $day, true);
		add_post_meta($user_id, 'order_status', 'Pending', true);
		add_post_meta($user_id, 'order_type', 'Day', true);
		add_post_meta($user_id, 'user_type', $usertype, true);
		add_post_meta($user_id, 'order_week', $week, true);
		add_post_meta($user_id, 'food_order', $days);
		add_post_meta($user_id, 'order_uid', $uid);

	    $orders_price = get_post_meta($user_id, 'food_order' , true);
		$price_arr = [];

		foreach($orders_price[$day] as $index => $order_price)
		{		
		$price =  get_post_meta($index, 'menu_item_price', true);
		$price_arr[] = $price*$order_price;
		
		}
		$order_total = array_sum($price_arr);
		add_post_meta($user_id, 'order_total', $order_total);	
		echo wp_send_json(array('code' => 200, 'message' => __('Order Sucessfully Create')));
		die();

endif;
die;
}






add_action('wp_ajax_fixdelivery', 'fixdelivery', 0);
add_action('wp_ajax_nopriv_fixdelivery', 'fixdelivery');

function fixdelivery()
{
	global $wpdb;

	$mon =  json_decode(stripslashes($_POST['mon']));
	$tue =  json_decode(stripslashes($_POST['tue']));
	$wed =  json_decode(stripslashes($_POST['wed']));
	$thu =  json_decode(stripslashes($_POST['thu']));
	$fri =  json_decode(stripslashes($_POST['fri']));

	$days_data = array();
	$days_data[0] = $mon;
	$days_data[1] = $tue;
	$days_data[3] = $wed;
	$days_data[4] = $thu;
	$days_data[5] = $fri;
	


	$uid = $_POST['uid'];
	$author_obj = get_user_by('id', $uid);
	$author =  $author_obj->display_name;
	

	$post = array(
		'post_title'    => "OHYSX-" . rand(10, 100),
		'post_status'   => 'publish',
		'post_type'     => 'orders',
		'post_author' => $uid
	);
	$user_id = wp_insert_post($post);


	add_post_meta($user_id, 'order_day', 'Fixed Delivery', true);	
	add_post_meta($user_id, 'order_status', 'Pending', true);
	add_post_meta($user_id, 'order_type', 'Weekly', true);
	add_post_meta($user_id, 'user_type', 'Personal', true);



	$total_day_price = [];

	foreach ($days_data as $myday){

		//print_r($myday);

		$dayitems = [];
		

		$day = $myday->day;
		$type  = $myday->type;

		$items = $myday->items;
		foreach($items as $item)
		{
		
			$price =  get_post_meta($item, 'menu_item_price', true);			
		    $dayitems[] = $price;

		}
		 $day_price=  array_sum($dayitems);
		 $total_day_price[] =  $day_price;
		 add_post_meta($user_id, $day.'_ids', $day_price , true);	
		



		
	}

	$total_price =  array_sum($total_day_price);
	add_post_meta($user_id, 'total_price', $total_price ,true);	
	


	if (!is_wp_error($user_id)) {
		echo wp_send_json(array('code' => 200, 'message' => __('Order Sucessfully Create')));
	} else {
		echo wp_send_json(array('code' => 0, 'message' => __('Error Occured please fill up form carefully.')));
	}

	die;
}



// Meeting Ajax


add_action('wp_ajax_addmeeting', 'addmeeting', 0);
add_action('wp_ajax_nopriv_addmeeting', 'addmeeting');

function addmeeting()
{
	global $wpdb;
	$date = $_POST['date'];
	$time = $_POST['time'];
	$menu_items = $_POST['menu_items'];
	$uid = $_POST['uid'];
	$order = $_POST['order'];
	$post = array(
		'post_title'    => "OHYSX-" . rand(10, 100),
		'post_status'   => 'publish',
		'post_type'     => 'orders',
		'post_author' => $uid
	);
	$user_id = wp_insert_post($post);
	$price =  get_post_meta($product_id, 'menu_item_price', true);
	add_post_meta($user_id, 'date', $date, true);	
	add_post_meta($user_id, 'order_uid', $uid, true);	
	add_post_meta($user_id, 'order_time', $time, true);	
	$food_items = [];
	foreach ($menu_items as $menu_item) {
		$product_id = $menu_item[0];
		$menu_item = $menu_item[1];		
		$food_items[$product_id] = $menu_item;
	}
	add_post_meta($user_id, 'food_order', $food_items, true);	
	add_post_meta($user_id, 'order_status', 'Pending', true);
	add_post_meta($user_id, 'order_type', 'Meeting', true);
	add_post_meta($user_id, 'user_type', $order, true);

	$orders_price = get_post_meta($user_id, 'food_order' , true);
	$price_arr = [];
	foreach($orders_price as $index => $order_price)
	{
			$price =  get_post_meta($index, 'menu_item_price', true);		
			$price_arr[] = $price * $order_price;
	}

	
	$order_total = array_sum($price_arr);
	add_post_meta($user_id, 'order_total', $order_total,true);	





	if (!is_wp_error($user_id)) {
		//sendmail($username,$password);
		echo wp_send_json(array('code' => 200, 'message' => __('Order Sucessfully Create')));
	} else {
		echo wp_send_json(array('code' => 0, 'message' => __('Error Occured please fill up form carefully.')));
	}

	die;
}



// company_deliver_address Ajax


add_action('wp_ajax_company_deliver_address', 'company_deliver_address', 0);
add_action('wp_ajax_nopriv_company_deliver_address', 'company_deliver_address');

function company_deliver_address()
{
	global $wpdb;
	$uid = stripcslashes($_POST['uid']);
	$address = $_POST['address'];
	$user_id = update_user_meta($uid, 'compnay_delivery_address', $address);
	if (!is_wp_error($user_id)) {
		//sendmail($username,$password);
		echo wp_send_json(array('code' => 200, 'message' => __('Compnay address updated')));
	} else {
		echo wp_send_json(array('code' => 0, 'message' => __('Error Occured please check address')));
	}

	die;
}



add_action('wp_ajax_update_agreement', 'update_agreement', 0);
add_action('wp_ajax_nopriv_update_agreement', 'update_agreement');

function update_agreement()
{
	global $wpdb;
	$uid = stripcslashes($_POST['uid']);
	$compnay_agreement = $_POST['compnay_agreement'];
	$lunch_benefit = $_POST['lunch_benefit'];
	$benefit_type = $_POST['benefit_type'];
	$user_id = update_user_meta($uid, 'lunch_benefit', $lunch_benefit);

	if (!is_wp_error($user_id)) {
		update_user_meta($uid, 'lunch_benefit', $lunch_benefit);
		update_user_meta($uid, 'lunch_benfit_type', $benefit_type);
		update_user_meta($uid, 'compnay_name', $compnay_agreement);
		//sendmail($username,$password);
		echo wp_send_json(array('code' => 200, 'message' => __('Agreement detail updated')));
	} else {
		echo wp_send_json(array('code' => 0, 'message' => __('Error Occured please form Data')));
	}

	die;
}




// Profile Devivery Address


add_action('wp_ajax_profile_deliver_address', 'profile_deliver_address', 0);
add_action('wp_ajax_nopriv_profile_deliver_address', 'profile_deliver_address');

function profile_deliver_address()
{
	global $wpdb;
	$uid = stripcslashes($_POST['uid']);
	$profile_delivery_address = $_POST['profile_delivery_address'];
	update_user_meta($uid, 'profile_delivery_address', $profile_delivery_address);
	echo wp_send_json(array('code' => 200, 'message' => __('Profile address updated')));
	die;
}


// Profile Devivery Address


add_action('wp_ajax_profile_details', 'profile_details', 0);
add_action('wp_ajax_nopriv_profile_details', 'profile_details');

function profile_details()
{
	global $wpdb;
	$uid = stripcslashes($_POST['uid']);
	$profile_delivery_phone = $_POST['profile_delivery_phone'];
	update_user_meta($uid, 'profile_delivery_phone', $profile_delivery_phone);
	echo wp_send_json(array('code' => 200, 'message' => __('Profile details updated')));
	die;
}


// Profile Devivery Address


add_action('wp_ajax_profile_deliver_fast', 'profile_deliver_fast', 0);
add_action('wp_ajax_nopriv_profile_deliver_fast', 'profile_deliver_fast');

function profile_deliver_fast()
{
	global $wpdb;
	$uid = stripcslashes($_POST['uid']);
	$profile_delivery_days = $_POST['profile_delivery_days'];

	$user_id = update_user_meta($uid, 'profile_delivery_days', $profile_delivery_days);
	if (!is_wp_error($user_id)) {

		echo wp_send_json(array('code' => 200, 'message' => __('Profile Delivery Days Updated')));
	} else {
		echo wp_send_json(array('code' => 0, 'message' => __('Error Occured please check address')));
	}
	die;
}

// Profile Payment Card Number Address


add_action('wp_ajax_profile_contact', 'profile_contact', 0);
add_action('wp_ajax_nopriv_profile_contact', 'profile_contact');

function profile_contact()
{
	global $wpdb;
	$uid = stripcslashes($_POST['uid']);
	$profile_contact = $_POST['profile_contact'];
	
	$user_id = update_user_meta($uid, 'profile_contact', $profile_contact);
	if (!is_wp_error($user_id)) {

		echo wp_send_json(array('code' => 200, 'message' => __('Profile contact details updated')));
	} else {
		echo wp_send_json(array('code' => 0, 'message' => __('Error Occured please check address')));
	}
	die;
}


add_action('wp_ajax_profile_allergies_other', 'profile_allergies_other', 0);
add_action('wp_ajax_nopriv_profile_allergies_other', 'profile_allergies_other');

function profile_allergies_other()
{
	global $wpdb;
	$uid = stripcslashes($_POST['uid']);
	$choices_alergies = $_POST['choices_alergies'];
	

	$user_id = update_user_meta($uid, 'profile_alergies', $choices_alergies);
	if (!is_wp_error($user_id)) {

		echo wp_send_json(array('code' => 200, 'message' => __('Profile allergies updated')));
		die;
	} else {
		echo wp_send_json(array('code' => 0, 'message' => __('Error Occured please check address')));
		die;
	}
	die;
}







add_action('wp_ajax_get_type_products', 'get_type_products', 0);
add_action('wp_ajax_nopriv_get_type_products', 'get_type_products');

	function get_type_products()
	{
							global $wpdb;	
							$query_week = $_POST['weekid'];
							$catname = $_POST['catname'];							
							$week_arr = explode("-", $query_week, 2);
							$week = $week_arr[1];
							$year = $week_arr[0];	
							$dates = getStartAndEndDate($week,$year);
							$FirstDay = $dates['start_date'] ;
							$LastDay =  $dates['end_date'];  
							query_posts(array(
								'post_type' => 'menu_items',
								'posts_per_page' => -1,
								'order' => 'desc',   
								'menus_type' => $catname,                                                                                                       
								'meta_query' => array(
									array(
										'key' => 'date',
										'value' => array($FirstDay, $LastDay ),           
										'compare' => 'BETWEEN',
										'type' => 'DATE'
									),
								)
							) ); 
							//echo "Ajax Load Data -" . $catname;
                                if (have_posts()) :  while (have_posts()) : the_post();
								$date = get_field('date'); ?>
								<div class="catering_card _pro_salat">
									<h3><?php the_title() ?> ( <?php $timestamp = strtotime($date); echo  date('D', $timestamp);  ?> | <span><?php echo $date ?> ) </h3>
									<p class="mt-3"><?php the_content() ?></p>
									<div class="row">
										<div class="col-md-12">
										<h6 class="mt-2">Allergenes:</h6>
                                    <?php $allergense =  get_the_terms( $post->ID, 'menu_sub_types' ); 
                                    
                                    foreach($allergense as $allergy) {
                                        echo "<p>".$allergy->name ."</p> " ;

                                    } ?>
											
										</div>                        
									</div>
								</div>
								<?php endwhile;
                                    wp_reset_query(); else : ?>
                                   <div class="catering_card _pro_salat">
										<h3> Sorry, no <span><?php echo $catname ?></span> menu added for this (<?php echo $week?>)week</h3>
										<p class="mt-3"> We are workign on it, we will add it soon</p>                            
									</div>
                                <?php endif; 

	

		die;
	}







	
add_action('wp_ajax_get_invoice_detail', 'get_invoice_detail', 0);
add_action('wp_ajax_nopriv_get_invoice_detail', 'get_invoice_detail');

	function get_invoice_detail()
	{
							global $wpdb;	
							$orderid = $_POST['orderid'];
							//$orderid = 668;
							$uid = $_POST['uid'];	
							$user_info = get_userdata( $uid);
							$args = array('p' => $orderid, 'post_type' => 'orders'); ?>

				
						            
						   <div class="invoice_table">
								<table class="invoice_slip_table">
									<thead>
									<tr>
										<th scope="col">Cloud</th>
										<th scope="col">Distribution</th>
									</tr>
									</thead>							
									<tbody>
									<tr>
										<td scope="row"><strong>Name: </strong><?php echo $user_info->display_name; ?></td>
										<td scope="row"><strong>Lunch: </strong>NOK <?php echo get_post_meta( $orderid, 'order_total', true ); ?></td>
										
									</tr>
									<tr>
										<td scope="row"><strong>Email: </strong><?php echo $user_info->user_login ?></td>
										<td scope="row"><strong>Shipping: </strong>NOK 0</td>
									</tr>
									</tbody>
								</table>
								<?php $loop = new WP_Query($args); while ( $loop->have_posts() ) : $loop->the_post();  global $post; ?>
								<h5 class="mt-4">Summary</h5>
								<table class="invoice_slip_table">
									<thead>
									<th scope="col">Description</th>
									<th scope="col">Number</th>
									<th scope="col">Price</th>
									</thead>
									<tbody>
										<?php   $food_items =  get_post_meta( get_the_ID(), 'food_order', true );						
												foreach($food_items as $index => $food) {  ?>
														<tr>
																<td scope="row"><strong><?php echo $index ?></td>
																<td>
																<?php   foreach($food as $key => $ky_item) { 	?>
																		<p>  <?php echo  get_the_title($key) . " [". $ky_item . "] " ; ?> </p>
																
																	<?php 	}  ?>
																	</td>
																	<td>
																<?php   foreach($food as $key => $ky_item) { 	?>
																		<p> NOK <?php echo get_post_meta( $key, 'menu_item_price', true ); ?> </p>
																
																	<?php 	}  ?>
																	</td>
																
														</tr>

												<?php }  endwhile; ?>

										
									<tbody>
								</table>
							</div>
							
                      
                     

				 
						   
	

					<?php	die;
	}



		
add_action('wp_ajax_get_invoice_detail_company', 'get_invoice_detail_company', 0);
add_action('wp_ajax_nopriv_get_invoice_detail_company', 'get_invoice_detail_company');

	function get_invoice_detail_company()
	{
							global $wpdb;	
							$orderid = $_POST['orderid'];				
							$uid = $_POST['uid'];	
							$user_info = get_userdata( $uid);
							$args = array('p' => $orderid, 'post_type' => 'orders');

							$available_active_employee = get_users(
								array(
									'role' => 'personal',
									'meta_query' => array(
										array(
											'key' => 'employee',
											'value' => $uid,
											'compare' => '=='
										),
										array(
											'key' => 'status',
											'value' => 'active',
											'compare' => '=='
										)
									)
								)
							);

						   // print_r($available_active_employee);
						   $total_emp =   count($available_active_employee);
						   $order_total =  get_post_meta( $orderid, 'order_total', true );
						   $company_days =  get_user_meta($uid ,'Company_days',true);                                            

						   $lunch_benefit =  get_user_meta($uid ,'lunch_benefit',true);
						   $lunch_benfit_type =  get_user_meta($uid ,'lunch_benfit_type',true);                                               
						   $fixed_total = $order_total-$lunch_benefit;
						   $order_total_price =  $order_total * $company_days  * $total_emp ;
							$fix_remaing =  $fixed_total * $company_days  * $total_emp ;
							if($lunch_benfit_type == '%')
							{
								$company_pay = $lunch_benefit /100 * $order_total_price;
							}
							else{
								$company_pay = $order_total_price - $fix_remaing;
							}


							
							?>

				
						            
						   <div class="invoice_table">
								<table class="invoice_slip_table">
									<thead>
									<tr>
										<th scope="col">Cloud</th>
										<th scope="col">Distribution</th>
									</tr>
									</thead>							
									<tbody>
									<tr>
										<td scope="row"><strong>Name: </strong><?php echo $user_info->display_name; ?></td>
										<td scope="row"><strong>Lunch Item: </strong>NOK <?php echo get_post_meta( $orderid, 'order_total', true ); ?></td>
										
									</tr>
									<tr>
										<td scope="row"><strong>Email: </strong><?php echo $user_info->user_login ?></td>
										<td scope="row"><strong>Employees: </strong><?php echo $total_emp; ?></td>
									</tr>
									<tr>
										<td scope="row"><strong>Week Days: </strong><?php echo $company_days?></td>
										<td scope="row"><strong>Benifit: </strong> <?php echo $lunch_benefit. "" . $lunch_benfit_type; ?></td>
									</tr>
									<tr>
										<td scope="row"><strong>Compnay Pay: </strong>NOK <?php echo $company_pay; ?></td>
										<td scope="row"><strong>Total : </strong>NOK <?php echo $order_total_price ?> </td>
									</tr>
									</tbody>
								</table>
								<?php $loop = new WP_Query($args); while ( $loop->have_posts() ) : $loop->the_post();  global $post; ?>
								<h5 class="mt-4">Summary</h5>
								<table class="invoice_slip_table">
									<thead>
									<th scope="col">Description</th>
									<th scope="col">Number</th>
									<th scope="col">Price</th>
									</thead>
									<tbody>
										<?php   $food_items =  get_post_meta( get_the_ID(), 'food_order', true );						
												foreach($food_items as $index => $food) {  ?>
														<tr>
																<td scope="row"><strong><?php echo $index ?></td>
																<td>
																<?php   foreach($food as $key => $ky_item) { 	?>
																		<p>  <?php echo  get_the_title($key) . " [". $ky_item . "] " ; ?> </p>
																
																	<?php 	}  ?>
																	</td>
																	<td>
																<?php   foreach($food as $key => $ky_item) { 	?>
																		<p> NOK <?php echo get_post_meta( $key, 'menu_item_price', true ); ?> </p>
																
																	<?php 	}  ?>
																	</td>
																
														</tr>

												<?php }  endwhile; ?>

										
									<tbody>
								</table>
							</div>
							
                      
                     

				 
						   
	

					<?php	die;
	}



	







