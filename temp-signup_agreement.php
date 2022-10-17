<?php /* Template Name: AgentSignup  */ 
        get_header();
        //reddirectProfile();
                ?> 
 <main class="business_agreement">
        <div class="agreement_wrapper d-flex position-relative justify-content-center flex-column align-items-center p-4">
                <a href="<?php echo home_url(); ?>"> <img src="<?php bloginfo('template_directory'); ?>/reources/images/logo.png" class="logo" alt="logo"></a>
                
                <form class="add_agent" id="add_agent" action="#" > 
                    <div class="d-flex justify-content-center flex-column align-items-center text-center">
                    <a href="<?php echo home_url(); ?>"> <img src="<?php bloginfo('template_directory'); ?>/reources/images/left arrow.png" class="arrow position-absolute" alt="back arrow"> </a>
                    <h2 class="">Create Agent Profile</h2>   
                    <p>REGISTER FOR YOUR SMARTPHONES, LAPTOPS, IPAD, MACBOOKS & PERIPHERALS</p>
                        <div class="pl-4 pt-3 pr-4">
                            
                        <div class="form-group w-100  mb-2">
                                <label for="compnay_name">Your Name</label>
                                <input type="text" class="form-control" id="agent_name" placeholder="Agent Name" required >
                            </div>
                            <div class="form-group w-100  mb-2">
                                <label for="compnay_delivery_address">Email adress</label>
                                <input type="text" class="form-control" id="agent_email"  placeholder="Enter Your Email adress" />                      
                            </div>

                            <div class="form-group w-100  mb-2">
                                <label for="business_address">Business Address</label>
                                <input type="text" class="form-control" id="business_address" placeholder="Enter your business address" >
                            </div>
                            <div class="form-group w-100  mb-2">
                                <label for="business_phone">Business Phone Number</label>
                                <input type="text"  class="form-control" id="business_phone" placeholder="Enter Business Phone Number" />
                                    </div>
                            <div class="form-group w-100  mb-2">                            
                                    <label for="business_name">Business Name</label>
                            <input type="text" class="form-control" id="business_name"  placeholder="Enter Your Business Name" >
                            </div>
                            <div class="form-group w-100  mb-2">
                                    <label for="postal_code">Postal Code</label>
                            <input type="text" class="form-control" id="postal_code"  placeholder="Enter Your Postal Code" >
                            </div>
                            <div class="pinfo mb-5">
                                    
                                    <p class="text">Thanks for subscribing us and welcome to be the business partner for all of your <p>
                                    <p>Smartphones, laptops, iPad, and  MacBooks are repaired at competitive prices. After repair warranty
                                        Special discount for the business  having turn over more than $5000/month </p>
                                        <p class="text">  We at BUDGET COMPUTERS AND KIWI MOBILES, HAVING HIGHLY SKILLED TECHNICIANS, QUALIFIED FROM NEW ZEALAND POLYTECH IN IT. WE HAVE HI-TECH LAB WITH LATEST TOOLS TO DIAGNOSE THE FAULY AND REPAIR, WE ALSO SPECIALISED IN MOTHERBOARDS 
                                        DIAGNOSTIC AND PART REPLACEMENTS, i.e., IC, VGA card, data recovery, charging slot repair.</p>
                                        <p class="text"> One of our sales team will contact you at your preferred time to discuss more and answer your queries </p>
                            </div>
                            <button type="submit" class="btn_primary d-block next">Sign Up</button>                   
                        </div>
                    </div>      
                </form>
                <div id="last_step">
                    <div  class="finish_step step_wrapper d-flex justify-content-center flex-column align-items-center text-center">            
                        <div class="content mt-5">
                            <div class="right"><img src="<?php bloginfo('template_directory'); ?>/reources/images/img 3.png" alt=""></div>
                            <h1 class="finished">Finished!</h1>
                            <h2 class="looking">Your Request Sent</h2>
                            <p class="find_information">We have now sent you an Email for varification. Please check and activate your account</p>             
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
        $("#add_agent").submit(function(e) {                     
            e.preventDefault();   
            $("#spinner-div").show();                     
            var agent_name = jQuery('#agent_name').val();  
            var agent_email = jQuery('#agent_email').val();        
            var business_address = jQuery('#business_address').val();	
            var business_name = jQuery('#business_name').val();	
            var business_phone = jQuery('#business_phone').val();	 
            var postal_code = jQuery('#postal_code').val();	     
            form_data = new FormData();
            form_data.append('action', 'agent_create_signup');
            form_data.append('agent_name', agent_name);
            form_data.append('agent_email', agent_email);	
            form_data.append('business_address', business_address); 
            form_data.append('business_name', business_name); 
            form_data.append('business_phone', business_phone); 
            form_data.append('postal_code', postal_code);  
            
            $.ajax(
                {
                    url:"<?php echo admin_url('admin-ajax.php'); ?>",
                    type: 'POST',
                    contentType: false,
                    processData: false,
                    data: form_data,
                    beforeSend: function(){                    
                        $("#loader").show();
                    },
                    complete: function () {
                        $("#spinner-div").hide(); 
                    },   
                    success: function(data){ 
                        if(data.code==0) {
                           alert(data.message);
                        }  
                        else {
                           $(".sucess_message").css("display", "flex");                      
                        }      
                    }
            
             });
         }); 
            
        
     });
	</script>








