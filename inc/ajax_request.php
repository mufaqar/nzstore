<?php


function sendmail($agent_email,$message,$postid) {
	$admin = 'choudgry.asif@gmail.com,uziasif06@gmail.com,mufaqar@gmail.com';
	$tech =  'bydgetcomputer2013@gmail.com';
	//$admin = 'mufaqar@gmail.com';
	$to = 'info@kiwimobiles.co.nz';
	$subject = "Budget Computer |  $message ";
	$body  = "<p><strong> $message  </strong> <br/> Ticket   :  ".get_permalink($postid)."  </p>";
	$headers = array('Content-Type: text/html; charset=UTF-8');	
	$headers  = "From: " . $to . "\r\n";
	$headers .= "Reply-To: " . $agent_email . "\r\n";
	$headers .= "CC: ".$agent_email."\r\n";
	$headers .= "CC: ".$tech."\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
	mail( $admin, $subject, $body, $headers );
	$get_notifcation = get_post_meta( $postid, 'notification', true); 
	$count = $get_notifcation;
	update_post_meta( $postid, 'notification', $count+1); 
	echo "Email sent to : $admin and $agent_email";	
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
		sendmail($agent_email,"Ticket Updated by $agent_email ", $pid);
		

	if (!is_wp_error($update_post)) {
	
	
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

		sendmail($agent_email,"Technician [ $tech_email ] Updated Ticket  $pid ", $pid);
	



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
		$admin_email = $user->user_email;
		$ticket_uid = get_post_meta( $pid, 'order_uid', true);
		$user_agent =  get_user_by( 'id', $ticket_uid);
		$agent_email = $user_agent->user_email;
		sendmail($agent_email,"Administrator [ $admin_email ] Updated Ticket  $pid ", $pid);




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



add_action('wp_ajax_get_invoice_detail', 'get_invoice_detail', 0);
add_action('wp_ajax_nopriv_get_invoice_detail', 'get_invoice_detail');

	function get_invoice_detail()
	{
							global $wpdb;	
							$orderid = $_POST['orderid'];				
						
						
							$args = array('p' => $orderid, 'post_type' => 'orders');

							
							$uid =  get_post_meta( $orderid, 'invoice_uid', true );
							$user_info = get_userdata( $uid);

							

						 
						   $order_price =  get_post_meta( $orderid, 'order_price', true );
						   $order_price_gst =  $order_price * 15 / 100; 						   
						   $order_total  =   $order_price+$order_price_gst;		
						   $ticket_id =  get_post_meta( $orderid, 'order_id', true );	   

						  

							
							?>

				
						            
						   <div class="invoice_table">
								<table class="invoice_slip_table">
									<thead>
									<tr>
										<th scope="col">Name</th>
										<th scope="col">Details</th>
									</tr>
									</thead>							
									<tbody>
									<tr>
										<td scope="row"><strong>Invoice Id: </strong></td>
										<td scope="row"><?php echo get_the_title($orderid);?></td>
										
									</tr>
									<tr>
										<td scope="row"><strong>Email: </strong></td>
										<td scope="row"><?php echo $user_info->user_login ?></td>
									</tr>
									<tr>
										<td scope="row"><strong>Price: </strong></td>
										<td scope="row"><strong>$ </strong><?php echo $order_price?></td>
									</tr>
									<tr>
										<td scope="row"><strong>GST </strong> ( 15% = <?php echo $order_price_gst?>)</td>
										<td scope="row"><strong>$ </strong> <?php echo $order_total?> </td>
									</tr>
									<tr>
										<td scope="row"><strong>GST </strong> ( 15% = <?php echo $order_price_gst?>)</td>
										<td scope="row"><strong>$ </strong> <?php echo $order_total?> </td>
									</tr>
									
									</tbody>
								</table>
							
								<h5 class="mt-4">Ticket Summary</h5>
								<table class="invoice_slip_table">
									<thead>
									<th scope="col">Name</th>
									<th scope="col">Details</th>
								
									</thead>
									<tbody>

									<tr>
										<td scope="row"><strong>Ticket Id </strong></td>
										<td scope="row"><?php echo get_the_title($ticket_id); ?></td>
										
									</tr>
											
									<tr>
										<td scope="row"><strong>Date</strong></td>
										<td scope="row"><?php echo get_post_meta( $ticket_id, 'date', true ); ?></td>
										
									</tr>
									<tr>
										<td scope="row"><strong>Technician Remarks </strong></td>
										<td scope="row"><?php echo get_post_meta( $ticket_id, 'eng_remarks', true ); ?></td>
										
									</tr>
									<tr>
										<td scope="row"><strong>Agent Remarks: </strong></td>
										<td scope="row"><?php echo get_post_meta( $ticket_id, 'issues', true ); ?></td>
										
									</tr>
									<tr>
										<td scope="row"><strong>Address </strong></td>
										<td scope="row"><?php echo get_post_meta( $ticket_id, 'address', true ); ?></td>
										
									</tr>
									<tr>
										<td scope="row"><strong>Shipping Details </strong></td>
										<td scope="row"><?php echo get_post_meta( $ticket_id, 'shipping', true ); ?></td>
										
									</tr>

									<tr>
								
										<td colspan="2" scope="row">
										<strong>Terms and Conditions </strong>
										
										<ul>
											<li>1: Diagnosed fees will apply for all repairs even if the gadget is not repairable or job cancelled by customer.</li>
											<li></li>
											<li>2: Part order on customer behalf and deposit is 50% is taken the deposit is nonrefundable as we order part on customer behalf.</li>
											<li></li>
											<li>3: All the parts fitted come with 3 month warranty unless specified. We will fix the fault & check with which gadget is booked. No other functionality checked unless a thorough assessment is requested & assessment fee is paid and also provide the password or login id.</li>
											<li></li>
											<li>4: All repair come with 3 month warranty unless specified. LCD are fragile any external pressure while in pocket or any other place or harsh use will break without damaging the top glass as top glass is harder/ stronger then underneath LCD in such case warranty will be voided.</li>
											<li></li>
											<li>5: Any physical damage which includes liquid damage, dropped, and any pressure on the LCD which break the display will not be covered in warranty. Any gadget returned under warranty and it is find out to be physical damage diagnostic will apply. In any dispute customer is required to get third party opinion on their own cost from a reputable repair shop and provide a copy of the report.</li>
											<li></li>
											<li>6: Warranty is provided only on the part we have replaced not any other part of gadget.</li>
											<li></li>
											<li>7: No responsibility taken of any data loss while working on any gadget. Backup all your data before it is booked for a repair.</li>
											<li></li>
											<li>8: Customer ‘s responsibility to pick their gadget within 2 months’ time after it fixed and pay repairing fee in full. No gadget will be delivered if not aid In full or sell my gadget is not picked within 2 month time it will be disposed off or sold to recover the cost. I authorize budget computer to dispose off or sell my gadget to recover cost if not picked and paid within 2 month time.</li>
											<li></li>
											<li>9: Warranty repair cannot be checked straight away. We need reasonable time to check and fix.</li>
											<li></li>
											<li>10: Software/ operating system installation if virus infected or corrupted by customer negligence or misuse or any third party software not working no responsibility taken.</li>
											<li></li>
											<li>11: Customer advised to take their SD card/sim cards out from phone before they give for as budget computer takes no responsibility for any loss SD sim card/SD card etc.</li>
											<li></li>
											<li>If you damage or lose or do not return the loan equipment you will be charged for its repair or replacement. For more details of your terms & conditions please visit our website at www.smartphonesrepair.co.nz</li>
										</ul>

										</td>
										
									</tr>

											
											
									

											

										
									<tbody>
								</table>
							</div>
							
                      
                     

				 
						   
	

					<?php	die;
	}



