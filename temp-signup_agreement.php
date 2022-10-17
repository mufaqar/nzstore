<?php /* Template Name: Signup-Agreement  */ 

get_header();

reddirectProfile();

$date  = date('Y-m-d', strtotime(' +1 day'));



?>  <main class="business_agreement">
        <div class="agreement_wrapper d-flex position-relative justify-content-center flex-column align-items-center p-4">
        <a href="<?php echo home_url(); ?>"> <img src="<?php bloginfo('template_directory'); ?>/reources/images/logo.png" class="logo" alt="logo"></a>
            <div class="agreement_steps d-flex justify-content-center align-items-center mt-4 mt-lg-5 mb-lg-5">
                <div class="step step_one"></div>
                <div class="step step_two"></div>
                <div class="step step_three"></div>
            </div>
        <form class="addprofile" id="profileform" action="#" > 
            <div class="first_step step_wrapper d-flex justify-content-center flex-column align-items-center text-center">
            <a href="<?php echo home_url(); ?>"> <img src="<?php bloginfo('template_directory'); ?>/reources/images/left arrow.png" class="arrow position-absolute" alt="back arrow"> </a>
                <p>REGISTER FOR YOUR SMARTPHONES, LAPTOPS, IPAD, MACBOOKS & PERIPHERALS 							
</p>
                <div class="pl-4 pr-4">
                    <h2 class="">Create Agent Profile</h2>
                    <div class="form-group w-100">
                        <label for="compnay_name">Your Name</label>
                        <input type="text" class="form-control" id="compnay_name" placeholder="Company Name" required >
                    </div>

                    <div class="form-group w-100 mt-3 mb-5">
                        <label for="compnay_delivery_address">Email adress</label>
                        <input type="text" class="form-control" id="compnay_delivery_address" rows="3"
                            placeholder="Enter Delivery adress" />
                        <!-- <input type="text" class="form-control" id="compnay_agreement" 
                            placeholder="Agreement Title" > -->
                    </div>

                    <a type="next" class="btn_primary d-block next" onclick="stepOne()">Continue</a>
                </div>
            </div>

            <!-- step 2  -->
            <div class="secound_step step_wrapper d-flex justify-content-center flex-column align-items-center text-center">
                <img src="<?php bloginfo('template_directory'); ?>/reources/images/left arrow.png" class="arrow position-absolute" alt="back arrow"
                    onclick="backToStepOne()">

                <div class="pl-4 inner-content pr-4">
                    <h2 class=""> Busniess Details</h2>
              
                    
                   

                    <div class="form-group w-100  mb-2">
                        <label for="compnay_delivery_address">Business Address</label>
                        <input type="text" class="form-control" id="starting_date" value="<?php echo $date ?>" aria-describedby="emailHelp"
                                placeholder="Enter your business address" >
                    </div>
                    <div class="form-group w-100  mb-2">
                        <label for="compnay_delivery_address">Business Phone Number</label>
                        <input type="text"  class="form-control" id="compnay_delivery_address" rows="3"
                            placeholder="Enter Delivery phone number" />
                            </div>
                    <div class="form-group w-100  mb-2">
                            
                            <label for="compnay_delivery_address">Business Name</label>
                    <input type="text" class="form-control" id="starting_date" value=""   placeholder="Enter Your Business Name" >
                    </div>
                    <div class="form-group w-100  mb-2">
                            <label for="compnay_delivery_address">Postal Code</label>
                    <input type="text" class="form-control" id="starting_date" value=""
                            placeholder="Enter Your Postal Code" >
                    </div>

                 

                    <a type="next" class="btn_primary d-block next" onclick="stepTwo()">Continue</a>
                </div>
            </div>

            <!-- step 3  -->
            <div
                class="third_step step_wrapper d-flex justify-content-center flex-column align-items-center text-center">
                <img src="<?php bloginfo('template_directory'); ?>/reources/images/left arrow.png" class="arrow position-absolute" alt="back arrow"
                    onclick="backToStepTwo()">

                <div class="pl-4 third pr-4">

                 

                    <div class="pinfo mb-5">
                        <h2 class="">Term of use, privacy andcrelevant information</h2>
                        <p class="text">Thanks for subscribing us and welcome to be the business partner for all of your

                                Smartphones, laptops, iPad, and  MacBooks are repaired at competitive prices. After repair warranty
                                Special discount for the business  having turn over more than $5000/month </p>
                                <p class="text">  We at BUDGET COMPUTERS AND KIWI MOBILES, HAVING HIGHLY SKILLED TECHNICIANS, QUALIFIED FROM NEW ZEALAND POLYTECH IN IT. WE HAVE HI-TECH LAB WITH LATEST TOOLS TO DIAGNOSE THE FAULY AND REPAIR, WE ALSO SPECIALISED IN MOTHERBOARDS 
                                DIAGNOSTIC AND PART REPLACEMENTS, i.e., IC, VGA card, data recovery, charging slot repair.</p>

                                <p class="text"> One of our sales team will contact you at your preferred time to discuss more and answer your queries 					
									
									
                        </p>
                    </div>

                    <div class="d-flex align-items-center mb-2">
                        <p class="">
                            <input type="radio" id="test1" name="radio-group" checked>
                            <label for="test1">Yes, Please</label>
                        </p>
                        <p style="margin-left: 2rem;">
                            <input type="radio" id="test2" name="radio-group">
                            <label for="test2">No Thanks</label>
                        </p>
                    </div>

                    <button type="next" class="btn_primary d-block next">Complete</button>
                </div>
            </div>

      
        </form>
        <div id="last_step">
            <div  class="finish_step step_wrapper d-flex justify-content-center flex-column align-items-center text-center">            
                <div class="content mt-5">
                    <div class="right"><img src="<?php bloginfo('template_directory'); ?>/reources/images/img 3.png" alt=""></div>
                    <h1 class="finished">Finished!</h1>
                    <h2 class="looking">We Looking forward to make lunch with you</h2>
                    <p class="find_information">We have now sent you an Email where you will find information on how to login
                        and manage your company and your orders.Companies receive an invoice at the end of each month.
                    </p>
                    <h3 class="employees_receive">Employees receive it at the end of each week</h3>
                    <a href="<?php echo home_url(); ?>" class="btn_primary mb-5">Go to the front</a>
                </div>                    
            </div>

        </div>


    
</div>

</main>






    <?php get_footer();?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <script type="text/javascript">   
     jQuery(document).ready(function($) {				
        $("#profileform").submit(function(e) {               
            e.preventDefault();
            var username = jQuery('#username').val();
            var name = jQuery('#name').val();          
            var phone = jQuery('#phone').val();	             
            var compnay_name = jQuery('#compnay_name').val();	 
            var compnay_delivery_address = jQuery('#compnay_delivery_address').val();	 
            //var compnay_agreement = jQuery('#compnay_agreement').val();	            
            var start_date = jQuery('#start_date').val();      
            var lunch_benefit = jQuery('#lunch_benefit').val();	 
            var lunch_benfit_type = jQuery('#lunch_benfit_type').val();	 
            var invite_user1 = jQuery('#invite_user1').val();	 
            var invite_user2 = jQuery('#invite_user2').val();	
            var invite_user3 = jQuery('#invite_user3').val();	 

            $.ajax(
                {
                    type:"POST",
                    url:"<?php echo admin_url('admin-ajax.php'); ?>",
                    data: {
                        action: "companysignup",
                        username : username,
                        name : name,
                        phone : phone,
                        compnay_name : compnay_name,                  
                        compnay_delivery_address : compnay_delivery_address,
                        lunch_benfit_type : lunch_benfit_type,
                        lunch_benefit : lunch_benefit,
                        invite_user1 : invite_user1,
                        invite_user2 : invite_user2,
                        invite_user3 : invite_user3,
                        start_date : start_date                     

                    },   
                    success: function(data){ 
                     
                        if(data.code==0) {
                                    alert(data.message);
                        }  
                        else {
                            $(".addprofile").css("display", "none");
                            $("#last_step").css("display", "block");
                        }      
            }
            
             });
         }); 
            
        
     });
	</script>







