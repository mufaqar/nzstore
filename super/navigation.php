<?php 
 if(!current_user_can('administrator') ) {
    wp_redirect( home_url('login'));                                     
    exit;
   };
?>
            
            <main class="launch_calandar">
        <div class="row d-flex">
            <div class="" style="width: 230px;">           
                <div class="sidebar p-0 align-items-start pt-5">
                    <div class="d-flex justify-content-center">
                       <a href="<?php bloginfo('url'); ?>"> <img src="<?php bloginfo('template_directory'); ?>/reources//images/logo.png" class="logo" alt=""></a>
                    </div>                   
                    <div class="mt-5">                        
                        <?php 	
								  wp_nav_menu ( array(
                                    'container'       => false,	
									'theme_location'  => 'admin',	
                                    'menu_class'      => 'myProfileNav activeNav'
									
								) );
								?>       
                            
                        

                    </div>
                    <div class="logout">                       	
                    <a href="<?php echo wp_logout_url( home_url() ); ?>"> <img src="<?php bloginfo('template_directory'); ?>/reources/images/logout.png" alt=""><span>Log Out</span></a>
                    </div>
                    <img src="<?php bloginfo('template_directory'); ?>/reources/images/cancel.png" class="hide_nav" alt="" onclick="HideNav()">
            </div>
        </div>    

        <div class="content">
                <div class="container_wrapper">
                    <div class="d-flex align-items-center justify-content-between mt-4">
                        <div class="hamburger">
                            <img src="<?php bloginfo('template_directory'); ?>/reources/images/hamburger.png" alt="" id="hamburgerbtn" onclick="hamburger()">
                        </div>
                        <div class="proofile_info d-flex align-items-center">
                            <div class="user">
                                <h6><?php global $current_user; wp_get_current_user();
                                 if ( is_user_logged_in() ) { 
                                    echo 'Hey, ' .  $current_user->display_name ; } 
                                    else {
                                        wp_redirect( home_url('login'));                                     
                                        exit;
                                    }
                                    ?></h6>  
                            </div>
                            <img src="<?php bloginfo('template_directory'); ?>/reources//images/profile.webp" alt="">
                        </div>                        
                    </div>