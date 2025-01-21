<?php
include_once('login.php');
include_once('register.php');
include_once('cpts.php');
include_once('class-wp-bootstrap-navwalker.php');
include_once('ajax_request.php');


add_action('after_setup_theme', 'remove_admin_bar');
function remove_admin_bar() {
  if (!current_user_can('administrator') && !is_admin()) {
    show_admin_bar(false);
  }
}

add_role('agent', 'Agent', array(
    'read' => true, // True allows that capability, False specifically removes it.
    'edit_posts' => true,
    'delete_posts' => true,
    'edit_published_posts' => true,
    'publish_posts' => true,
    'edit_files' => true,
    'upload_files' => true //last in array needs no comma!
));

add_role( 'technician', 'Technician', get_role( 'agent' )->capabilities );


add_filter( 'manage_tickets_posts_columns', 'set_custom_edit_tickets_columns' );    
add_action( 'manage_tickets_posts_custom_column' , 'custom_tickets_column', 10, 2 );
function set_custom_edit_tickets_columns($columns) {    
    unset( $columns['author'] );   
 
    $columns['user_type'] = 'User Type';
    $columns['order_uid'] = 'Order By';
    $columns['order_price'] = 'Price';

    return $columns;    
}

function custom_tickets_column( $column, $post_id ) {   
    global $post;
    switch ( $column ) {
        case 'order_status' :
            if(get_field( "order_status", $post_id )) {
                echo get_field( "order_status", $post_id );
            } else {
                echo 0;
            }
        break;

        case 'order_type' :
            if(get_field( "order_type", $post_id )) {
                echo get_field( "order_type", $post_id );
            } else {
                echo 0;
            }
        break;  
        case 'user_type' :
          if(get_field( "user_type", $post_id )) {
              echo get_field( "user_type", $post_id );
          } else {
              echo 0;
          }
      break; 
      break;  
        case 'order_price' :
          if(get_field( "price", $post_id )) {
              echo get_field( "price", $post_id );
          } else {
              echo 0;
          }
      break; 
      break;  
        case 'order_uid' :
          if(get_field( "order_uid", $post_id )) {
              echo get_field( "order_uid", $post_id );
          } else {
              echo 0;
          }
      break;    
    }   
}

function tickets_column_register_sortable( $columns ) {
     $columns['order_status'] = 'order_status';
    $columns['order_type'] = 'order_type';
    return $columns;
}

add_filter("manage_edit-tickets_sortable_columns", "tickets_column_register_sortable" );









add_filter( 'manage_orders_posts_columns', 'set_custom_edit_orders_columns' );    
add_action( 'manage_orders_posts_custom_column' , 'custom_orders_column', 10, 2 );
function set_custom_edit_orders_columns($columns) {    
    unset( $columns['author'] );   
 
    $columns['invoice_uid'] = 'Agent ID';
    $columns['order_id'] = 'Ticket ID';
    $columns['order_price'] = 'Price';

    return $columns;    
}

function custom_orders_column( $column, $post_id ) {   
    global $post;
    switch ( $column ) {
        case 'invoice_uid' :
            if(get_field( "invoice_uid", $post_id )) {
                echo get_field( "invoice_uid", $post_id );
            } else {
                echo 0;
            }
        break;

        case 'order_id' :
            if(get_field( "order_id", $post_id )) {
                echo get_field( "order_id", $post_id );
            } else {
                echo 0;
            }
        break;  
        
      break;  
        case 'order_price' :
          if(get_field( "order_price", $post_id )) {
              echo get_field( "order_price", $post_id );
          } else {
              echo 0;
          }
      break; 
      break;  
        case 'order_uid' :
          if(get_field( "order_uid", $post_id )) {
              echo get_field( "order_uid", $post_id );
          } else {
              echo 0;
          }
      break;    
    }   
}

function orders_column_register_sortable( $columns ) {
     $columns['order_status'] = 'order_status';
    $columns['order_type'] = 'order_type';
    return $columns;
}

add_filter("manage_edit-orders_sortable_columns", "orders_column_register_sortable" );









function  page_title() {

    ?> <div class='toggle mb-5'>
            <div class='tabs'>
                <div class='tab active'><?php the_title()?></div>           
            </div>
    </div><?php
}







    function reddirectProfile() {

        global $current_user;
        $logged_user = wp_get_current_user();
        $UIL =  $logged_user->user_login;
        $uid =  $logged_user->ID;
        $url = home_url();
        if ( is_user_logged_in() ) {
            wp_redirect($url);
            exit();
        
        } else {
        
        //echo "Not Login" ;
        
        
        }


    }


  
    function weekdaySort($a, $b){
        $weekdays = array("Monday","Tuesday","Wednesday","Thursday","Friday");
        return array_search($a, $weekdays) - array_search($b, $weekdays);
    } 
  


    function get_noftication($pid) {

          if((get_post_meta($pid, "notification", true))) { ?>
                <span class="noti_bag"><?php echo get_post_meta( $pid, 'notification', true ); ?></span>
            <?php } 



    }

    
    function toggleTabss(){
        ?>

<div class="toggle_btn">
        <div class="row ">
            <div class="catering_wrapper mt-5 mb-2 col-md-12 p-0">
                <div class="catering_menu all-tickets buttons">
                    <a id="1" class="showSingle _active" target="1" data="">All Tickets</a>
                    <a id="2" class="showSingle" target="2" data="Quotation">Quotation</a>
                    <a id="5" class="showSingle" target="5" data="Quotation-sent">Quotation Sent</a>
                    <a id="3" class="showSingle" target="2" data="Approval">Approval</a>
                    <a id="4" class="showSingle" target="2" data="Complete">Complete</a>
                </div>
            </div>
        </div>
    </div>

        <?php
    }     
  

    
	

    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
        }
    
	


    add_action( 'template_redirect', 'wpse8170_activate_user' );
    function wpse8170_activate_user() {
        if ( is_page() && get_the_ID() == 125 ) {
            $user_id = filter_input( INPUT_GET, 'user', FILTER_VALIDATE_INT, array( 'options' => array( 'min_range' => 1 ) ) );
            if ( $user_id ) {        
                $code = get_user_meta( $user_id, 'has_to_be_activated', true );
                if ( $code == filter_input( INPUT_GET, 'key' ) ) {
                    delete_user_meta( $user_id, 'has_to_be_activated' );
                    add_user_meta( $user_id, 'user_activated', "yes" );
                    $user_info = get_userdata($user_id);
                    $user_email =  $user_info->user_login;
                    $password = generateRandomString();
                    wp_set_password($password,$user_id );
                    sendmail_agent($user_email,$password);
                    sendmail_admin($user_email);
                 
                  
                }
            }
        }
    }


    
    function check_user_role_and_redirect($required_role) {
        // Get the current user object
        $current_user = wp_get_current_user();
    
        // Check if the user is logged in
        if ( is_user_logged_in() ) {
            // Display a greeting message
            echo 'Hey, ' . esc_html( $current_user->display_name ) . "<br/>";
    
            // Get the user's roles
            $roles = $current_user->roles;
    
            // Check if the user has the required role
            if ( ! in_array( $required_role, $roles ) ) {
                // If not, terminate with a message
                wp_die( __( 'Not Allowed', 'your-text-domain' ) );
            } else {
                // Optional: Add further logic for users with the required role
                return true;
            }
        } else {
            // Redirect to the login page if the user is not logged in
            wp_redirect( home_url( '/login' ) );
            exit;
        }
    }
    
   
// Agent  Ticket Update  Email 
function sendmail($agent_email, $message, $postid) {		
    $subject = "Budget Computer & Kiwi Mobiles | $message";
    $headers = array(
        'From: Budget Computer <info@budgetrepaircenter.nz>',
        'Bcc: choudhry.asif@gmail.com',
        'Bcc: budgetcomputer2013@gmail.com',
        'Bcc: uziasif06@gmail.com',
        'Bcc: mufaqar@gmail.com',
        'Content-Type: text/html; charset=UTF-8'
    );

    $body  = "<p><img src='https://budgetrepaircenter.nz/jobform/wp-content/themes/nzstore/resources/images/logo.png' width='320px' alt='Logo'></p><hr/>";
    $body .= "<p><strong>$message</strong><br/> Ticket: <a href='" . get_permalink($postid) . "'>" . get_permalink($postid) . "</a></p>";

    // Send the email
    wp_mail($agent_email, $subject, $body, $headers);

    // Update the notification count
    $get_notification = get_post_meta($postid, 'notification', true); 
    $count = !empty($get_notification) ? intval($get_notification) : 0;
    update_post_meta($postid, 'notification', $count + 1); 
}


// Agent Activation Email 

function activation_mail($to,$activation_link) {
    $subject = 'Budget Computer & Kiwi Mobiles | User Account Activation';	
    $headers[] = 'From: info@budgetrepaircenter.nz" . "\r\n';
    $headers[] = "Content-Type: text/html; charset=UTF-8\r\n";
    $body   = "<p><img src='https://budgetrepaircenter.nz/jobform/wp-content/themes/nzstore/reources/images/logo.png' width='320px'></img></p><hr/> ";
    $body  .= "<p><strong> Account Activation Link: </strong><a href='$activation_link' >Activate your Account</a> </p> ";
    $body  .= "<p><strong> DID:   </strong> 09 9508717 </p> ";
    $body  .= "<p><strong> Email:   </strong>info@budgetrepaircenter.nz</p> ";
    wp_mail( $to, $subject, $body, $headers );
    
}

    // Reset Password Email 

function Send_Password($username,$password) {   
    $subject = 'Budget Computer & Kiwi Mobiles | Reset Password';	 
    $headers = array(
        'From: Budget Computer <info@budgetrepaircenter.nz>',
        'Content-Type: text/html; charset=UTF-8'
    );
    $body   = "<p><img src='https://budgetrepaircenter.nz/jobform/wp-content/themes/nzstore/reources/images/logo.png' width='320px'></img></p><hr/> ";
    $body  .= "<p><strong> Username : </strong>$username </p> ";
    $body  .= "<p><strong> Password : </strong>$password </p> ";
    wp_mail( $username, $subject, $body, $headers );
    
}


// Send mail to Agent Email 
function sendmail_agent($to,$password) {
    $subject = 'Budget Computer & Kiwi Mobiles | User Login Details';
    $body  = "<h1>Budget Computer & Kiwi Mobiles </h1> ";
    $body  .= "<p><img src='https://budgetrepaircenter.nz/jobform/wp-content/themes/nzstore/reources/images/logo.png' width='320px'></img></p><hr/> ";
    $body  .= "<p><strong> Username: </strong> $to </p> ";
    $body  .= "<p><strong> Password:   </strong> $password </p> ";
    $body  .= "<h1 style='color:#5fb227;margin:20px 0;'> YOUR ONLINE REPAIR PARTNER </h1>";
    $body  .= "<p>Thanks for subscribing to your online repair centre portal; now you can create your first query for any of your repair issues, the Galaxies series, iPhones, iPods, MacBooks, Laptops, X-BOX, and Gaming Machines. </p>";
    $body  .= "<p>We often stock all parts of the products mentioned above to repair fast. Online portal updates of your queries are generated until we receive your product repair and send them back with online tracking details in your dedicated login portal with us.  </p>";
    $body  .= "<p><strong> Email: </strong>  info@budgetrepaircenter.nz </p> ";
    $body  .= "<p><strong> DID: </strong>  073477044 -  099508717 </p> ";
    $body  .= "<p> <a href='http://icsservices.nz' target='_blank'>www.icsservices.nz </a>   &nbsp;&nbsp;&nbsp;  <a href='http://smartphonesrepair.co.nz' target='_blank'> www.smartphonesrepair.co.nz</a> </p> ";
    $body  .= "<p>Follow Us</p>";
    $body  .= "<p> <a href='https://www.facebook.com/smartphonesrepair.co.nz' target='_blank'>Facebook</a> &nbsp;&nbsp;&nbsp; <a href='https://www.youtube.com/channel/UC9DOgY5L5oAudmVE8V5D66g' target='_blank'>Youtube</a><p> ";
    $headers[] = 'From: info@budgetrepaircenter.nz" . "\r\n';
    $headers[] = "Content-Type: text/html; charset=UTF-8\r\n";
    wp_mail( $to, $subject, $body, $headers );
}

// Send Admint Notification 


function sendmail_admin($user_email) {
    $admin = 'choudhry.asif@gmail.com';
    $subject = 'Budget Computer & Kiwi Mobiles | New User Registerd  ';
    $body  = "<h1>Budget Computer & Kiwi Mobiles </h1> ";
    $body  .= "<p><img src='https://budgetrepaircenter.nz/jobform/wp-content/themes/nzstore/reources//images/logo.png' width='320px'></img></p><hr/> ";
    $body  .= "<p><strong> Email Address: </strong> $user_email </p> ";
    $headers[] = 'From: info@budgetrepaircenter.nz" . "\r\n';
    $headers[] = 'Cc: choudhry.asif@gmail.com';
    $headers[] = 'Cc: budgetcomputer2013@gmail.com';
    $headers[] = 'Cc: uziasif06@gmail.com,mufaqar@gmail.com';
    $headers[] = "Content-Type: text/html; charset=UTF-8\r\n";
    wp_mail( $admin, $subject, $body, $headers );
}
