<?php /* Template Name: Add Ticket  */ 
get_header();

?> 
 <?php include('navigation.php'); ?>
 <?php global $current_user; wp_get_current_user();  $uid = $current_user->ID;?>

<div class="custom_container catering_form mt-5 mb-5">
    <div class="_info mt-5 mb-5">
        <h2>Create Ticket </h2>
        <p>Enter Your Ticket Details here</p>
    </div>
    <div class="_form mt-5 p-4 pt-5 pb-5">
    <form class="add_ticket" id="add_ticket" action="#" > 
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="">Title</label>
                    <div class="_select">
                        <input type="text" value="" placeholder="Please enter title" id="title" required>
                        <input type="hidden" value="<?php echo $uid ?>"  id="uid" >
                    </div>
                </div>
                <div class="col-md-6 mt-3 mt-md-0 mb-3">
                    <label for="">Date</label>
                    <div class="_select">
                        <input type="date" value="<?php echo date("Y-m-d"); ?>" placeholder="02-05-22" id="date" required>
                    </div>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="">Status </label>
                    <div class="_select">
                        <select id="ticket_status">                            
                            <?php   
                            $types_tax = get_terms( array('taxonomy' => 'ticket_status','hide_empty' => false ) ); 
                            foreach( $types_tax as $type )  {
                                        $type_slug = $type->term_id ;
                                        $type_name = $type->name ; ?>                            
                                        <option value="<?php echo $type_slug; ?>" > <?php echo $type_name; ?> </option>
                                            <?php
                                }                                                    
                            ?>
                        </select>
                        <img src="./reources/images/down-arrow.png" alt="">
                    </div>
                </div>
               
                <div class="col-md-6 mb-3">
                    <label for=""> Type</label>
                    <div class="_select">
                        <select id="ticket_type">
                        <?php   
                            $food_categories = get_terms( array('taxonomy' => 'ticket_type','hide_empty' => false ) ); 
                            foreach( $food_categories as $food_cat )  {
                                        $food_cat_slug = $food_cat->term_id ;
                                        $food_cat_name = $food_cat->name ; ?>                            
                                        <option value="<?php echo $food_cat_slug; ?>" > <?php echo $food_cat_name; ?> </option>
                                            <?php
                                }                                                    
                            ?>
                        </select>
                        <img src="<?php bloginfo('template_directory'); ?>/reources/images/down-arrow.png" alt="">
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="">Priority</label>
                    <div class="_select">
                        <select id="ticket_priority">
                    <?php   
                            $product_tax = get_terms( array('taxonomy' => 'ticket_priority','hide_empty' => false ) ); 
                            foreach( $product_tax as $product_cat )  {
                                        $product_cat_slug = $product_cat->term_id ;
                                        $product_cat_name = $product_cat->name ; ?>                            
                                        <option value="<?php echo $product_cat_slug; ?>" > <?php echo $product_cat_name; ?> </option>
                                            <?php
                                }                                                    
                            ?>
                         </select>
                        <img src="<?php bloginfo('template_directory'); ?>/reources/images/down-arrow.png" alt="">
                    </div>
                </div>            

                <div class="col-md-6 mt-3 mt-md-0 mb-3">
                    <label for="">Address</label>
                    <div class="_select">                    
                        <textarea id="address"><?php echo get_post_meta($pid, 'address', true ); ?></textarea>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                <label for="">Issue Details</label>
                    <div class="_select">                       
                        <textarea id="issues"><?php echo get_post_meta($pid, 'issues', true ); ?></textarea>
                    </div>
                </div>

              
                <div class="col-md-6 mb-3">
                <label for="">Shipping Details</label>
                    <div class="_select">                        
                        <textarea id="shipping"><?php echo get_post_meta($pid, 'shipping', true ); ?></textarea>
                    </div>
                </div>
                <div class="d-flex justify-content-end savebtn">
                    <input type="submit" class="btn_primary"  value="Add Ticket"/>
                </div>
            </div>
        </form>
    </div>
</div>
</div>
</div>
</div>
</main>


<section class="hideme zindex-modal overlay">
        <div class="popup">
            <div class="popup_wrapper">
                <div
                    class="order_confirm d-flex position-relative justify-content-center flex-column align-items-center p-4">
                    <img src="<?php bloginfo('template_directory'); ?>/reources/images/logo.png" class="logo" alt="logo">

                    <div
                        class="step_wrapper d-flex justify-content-center flex-column align-items-center text-center">
                        <div class="content mt-5">
                            <div class="right"><img src="<?php bloginfo('template_directory'); ?>/reources/images/img 3.png" alt=""></div>
                            <h1 class="finished">Finished!</h1>
                            <h2 class="mb-5 mt-5">Your order has beed submitted!</h2>
                        </div>
                    </div>
                    
                </div>
                <img src="<?php bloginfo('template_directory'); ?>/reources//images/red cross.png" alt="" class="_cross">
            </div>
        </div>
    </section>


    <?php get_footer();?>

     <!-- Font Awsome -->
 <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" ></script> 
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
 <script type="text/javascript">   
     jQuery(document).ready(function($) {	
        $('._cross').click(function(){
           
           $(".hideme").css("display", "none");
       });
                 
        $("#add_ticket").submit(function(e) {                     
            e.preventDefault();                     
            var title = jQuery('#title').val();	             
            var date = jQuery('#date').val();	       
            var address = jQuery('#address').val();	             
            var ticket_type = jQuery('#ticket_type').val();	 
            var ticket_priority = jQuery('#ticket_priority').val();	 
            var ticket_status = jQuery('#ticket_status').val();	          
            var shipping = jQuery('#shipping').val();           
            var issues = jQuery('#issues').val(); 
            var uid = jQuery('#uid').val();             
            $.ajax(
                {
                    type:"POST",
                    url:"<?php echo admin_url('admin-ajax.php'); ?>",
                    data: {
                        action: "add_ticket",
                        title : title,
                        date : date, 
                        address : address,
                        ticket_type : ticket_type,
                        ticket_priority : ticket_priority,
                        ticket_status : ticket_status ,
                        issues : issues,
                        shipping : shipping,
                        user_type : "Agent",
                        uid : uid
                    },   
                    success: function(data){                      
                     
                        if(data.code==0) {
                                    alert(data.message);
                        }  
                        else {
                           $(".overlay").css("display", "flex");
                      
                        }      
            }
            
             });
         }); 
            
        
     });
	</script>













