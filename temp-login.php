<?php
/*
 * Template Name: Login
 */

get_header('landing');
global $current_user;
$logged_user = wp_get_current_user();
$UIL =  $logged_user->user_login;
$uid =  $logged_user->ID;
$url = home_url('dashboard');
if ( is_user_logged_in() ) {
   wp_redirect($url);
   exit();

} else {

//echo "Not Login" ;


}



?>



    <!-- login section  -->

    <section class="container login mt-5 mb-5" style="margin-bottom:5rem !important">
        <div class="row align-items-center">
            <div class="col-sm-12 col-md-6 left">
                <div class="login_image_wrapper">
                    <div class="image_card">
                        <img src="<?php bloginfo('template_directory'); ?>/reources/images/mobile.jpg" alt="">
                        <div class="overlay"></div>
                    </div>                    
                </div>               
            </div>
            <div class="col-sm-12 right col-md-6 p-3">
                <h3>Welcome NZ Mobiles</h3>
                <p>Please Login</p>
                <form class="login_form" id="loginform">
                    <div class="form-group">
                        <label for="username">Email</label>
                        <input type="email" class="form-control border-0 border-bottom rounded-0"
                            id="username" aria-describedby="emailHelp" placeholder="abc@example.com" value="" required>                  
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control border-0 border-bottom rounded-0"
                            id="password" placeholder="Input your password" required>
                    </div>
                    <div class="d-flex justify-content-between align-items-center " style="margin-top: 3rem !important;">
                        <span>Don't remember your <a href="<?php echo home_url('forget-password'); ?>">Password?</a></span>
                        <button type="submit" class="green_btn">Login</button>
                    </div>
                    
                </form>
            </div>
        </div>

    </section>

    <!--x login section x -->

  

<?php get_footer('landing'); ?>
<script type="text/javascript">   
   jQuery(document).ready(function($) {    
        $("#loginform").submit(function(e) {          
            e.preventDefault();
            var username = jQuery('#username').val();
            var password = jQuery('#password').val();       
            jQuery.ajax({
            type:"POST",
            url:"<?php echo admin_url('admin-ajax.php'); ?>",
            data: {
                action: "userlogin",
                username : username,
                password : password
            },
            success: function(response){
               // alert(response.message);
               //window.location.href = "<?php echo home_url('profile'); ?>";
            },
            error: function(response) {
                alert(response.message);
            }
            });
        });
	
	});
	</script>


