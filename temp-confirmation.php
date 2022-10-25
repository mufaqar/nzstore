<?php
/*
 * Template Name: Confirmation
 */

get_header('landing');

// $user = $_REQUEST['user'];


// $user_info = get_userdata($user);


// echo 'Username: ' . $user_info->user_login . "\n";


?>



    <!-- login section  -->

    <section class="container login mt-5 mb-5" style="margin-bottom:5rem !important">
        <div class="row align-items-center">
            <div class="col-sm-12 col-md-6 left">
                <div class="login_image_wrapper">
                    <div class="image_card">
                        <img src="<?php bloginfo('template_directory'); ?>/reources/images/mobile.jpg" alt="" style="width:100%; border-radius:20px">
                        <div class="overlay"></div>
                    </div>                    
                </div>               
            </div>
            <div class="col-sm-12 right col-md-6 p-3">
                 <img src="<?php bloginfo('template_directory'); ?>/reources/images/logo.png" alt="" style="max-width:350px" > <br/><br/>
                   <h3>Thank you for joining us</h3> 

                   <p>Please check your email for username and password</p> 

                   <?php

                // $body  = "<h1>Kiwi Mobile </h1> ";
                // $body  .= "<p><img src='https://kiwimobiles.co.nz/jobform/wp-content/themes/nzstore/reources//images/logo.png' width='320px'></img></p><hr/> ";
                // $body  .= "<p><strong> Username: </strong> $user_info->user_login </p> ";
                // $body  .= "<p><strong> Password:   </strong> $password </p> ";
                // $body  .= "<h3> WHO ARE WE, AND WHY ARE WE?</h3>
                //             <p>Thanks for subscribing to your online repair centre portal; now you can create your first query for any of your repair issues, the Galaxies series, iPhones, iPods, MacBooks, Laptops, X-BOX, and Gaming Machines.</p>
                //             <p>We often stock all parts of the products mentioned above to repair fast. Online portal updates of your queries are generated until we receive your product repair and send them back with online tracking details in your dedicated login portal with us. 
                //             </p><p>DID: 09 9508717</p> <p> DID: 07 3477044   Email: repair@kiwimobiles.co.nz </p>  <p>  Email: repair@kiwimobiles.co.nz</p>                        
                //             </p>www.icsservices.nz  www.smartphonesrepair.co.nz </p>";



                //         echo $body;
                  ?>




                   <h6 class="mt-5 mb-5" ><a href="<?php echo home_url(); ?>" class="btn_primary  next">Login for creating Tickets</a> </h6>                 
                                 
              
            </div>

            
        </div>

    </section>




    <?php wp_footer(); ?>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
            <script src="<?php bloginfo('template_directory'); ?>/reources//js/slick-slider-script.js" type="text/javascript"></script>


        </body>
    </html>