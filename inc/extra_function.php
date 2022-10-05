<?php
include_once('login.php');
include_once('register.php');
include_once('cpts.php');
include_once('class-wp-bootstrap-navwalker.php');
include_once('ajax_request.php');

//add_role( 'company', 'Company', array( 'read' => true, 'level_0' => true ) );
//add_role( 'personal', 'Personal', array( 'read' => true, 'level_0' => true ) );

add_action('after_setup_theme', 'remove_admin_bar');
function remove_admin_bar() {
  if (!current_user_can('administrator') && !is_admin()) {
    show_admin_bar(false);
  }
}



/* Roles & Capabilities */
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


























function  page_title() {

    ?> <div class='toggle mb-5'>
            <div class='tabs'>
                <div class='tab active'><?php the_title()?></div>           
            </div>
    </div><?php
}



function my_get_current_user_roles() {
 
    if( is_user_logged_in() ) {
         $user = wp_get_current_user();   
      $roles = ( array ) $user->roles;
      return array_values($roles);
   
    } else {
   
      return array();
   
    }
   
  }

    function profile_user_nav() {   
   
    $user_role_arr =  my_get_current_user_roles();
    $c_user_role = $user_role_arr[0];
        if($c_user_role == 'personal') { ?>
            <a href="<?php echo get_site_url(); ?>/profile" class="singleprofile myprofile active" onclick="myProfile()">My <br> Profile</a>
            <?php


        }
        else {

        ?>
        <a href="<?php echo get_site_url(); ?>/profile" class="myprofile active" onclick="myProfile()">My <br> Profile</a>
        <a href="<?php echo get_site_url(); ?>/company-profile" class="companyProfile active" onclick="companyProfile()">Company<br> Profile</a>



        <?php



    }



   

   
   
  }



  function getStartAndEndDate($week, $year) {
    $dateTime = new DateTime();
    $dateTime->setISODate($year, $week);
    $result['start_date'] = $dateTime->format('Y-m-d');
    $dateTime->modify('+4 days');
    $result['end_date'] = $dateTime->format('Y-m-d');
    return $result;
    }


    function reddirectProfile() {

        global $current_user;
        $logged_user = wp_get_current_user();
        $UIL =  $logged_user->user_login;
        $uid =  $logged_user->ID;
        $url = home_url('profile');
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
  