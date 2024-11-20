<?php /* Template Name: Super-AddFault  */ 
get_header();

?> 
 <?php include('navigation.php'); ?>
 <?php global $current_user; wp_get_current_user();  $uid = $current_user->ID;?>

<div class="custom_container catering_form mt-5 mb-5">
    <div class="_info mt-5 mb-3">
        <h2>Create New Fault  </h2>
    </div>
    <div class="_form p-4 pt-5 pb-5">
    <form class="add_model" id="add_model" action="#" enctype="multipart/form-data">
            <div class="row">

            <div class="col-md-6 mb-3">
                    <label for="">Select Type</label>
                    <div class="_select">
                        <select id="ticket_cat"> 
                        <option value="">Select Type</option>                           
                            <?php   
                            $cat_tax = get_terms( array('taxonomy' => 'cat_fault_type','hide_empty' => false ,  'parent' => 0) ); 
                            foreach( $cat_tax as $cat )  {
                                        $cat_id = $cat->term_id ;
                                        $cat_slug = $cat->slug ;
                                        $cat_name = $cat->name ; ?>                            
                                        <option value="<?php echo $cat_id; ?>" data-id="<?php echo $cat_slug; ?>" > <?php echo $cat_name; ?> </option>
                                   <?php
                                }                                                    
                            ?>
                        </select>
                        <img src="<?php bloginfo('template_directory'); ?>/reources/images/down-arrow.png" alt="">
                    </div>
                </div>

                 
                <div class="col-md-6 mb-3">
                    <label for="">Fault Name</label>
                    <div class="_select">
                        <input type="text" value="" placeholder="" id="model_name" required>
                    </div>
                </div>
            

                <div class="d-flex justify-content-end savebtn">
                    <input type="submit" class="btn_primary"  value="Add Fault"/>
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
                            <h2 class="mb-5 mt-5">Your Fault  has beed created!</h2>
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
                 
        $("#add_model").submit(function(e) {                     
            e.preventDefault();   

          

            $("#spinner-div").show();                     
            var ticket_cat = jQuery('#ticket_cat').val();	             
            var model_name = jQuery('#model_name').val();
           
            form_data = new FormData();   
            form_data.append('action', 'super_add_fault');
            form_data.append('ticket_cat', ticket_cat);
            form_data.append('model_name', model_name);	
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
                           $(".overlay").css("display", "flex");
                      
                        }      
            }
            
             });
         }); 
            
        
     });
	</script>













