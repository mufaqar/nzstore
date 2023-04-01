<?php
/*
 * Template Name: Price Search
 */
get_header('landing');
?>  
<style>

#search-results {
  margin: 60px 0;
}
.result {
  margin: 30px 0;
  font-size: 30px;
}

#search-results ul li {
  
  background: #eaeceb;
    padding: 15px 22px;
    border: 1px dashed #5fb227;
    border-radius: 50px;
    margin-bottom: 20px;
  
  
}

#search-results ul li:odd {
  background: #d9d9d9;  
}

#search-results .btn_primary { margin-left:30px}

.headerbg { background:#979797dd;}



</style>




<section class="container login headerbg" >
    <div class="row">  
        <div class="col-md-6 p-3">  
            <img src="<?php bloginfo('template_directory'); ?>/reources/images/logo.png" alt="" style="max-width:350px" >  
        </div>
        <div class="col-md-6 p-3">  
              POWERED BY ICS NS LIMITED , www.icsservices.nz
              <img src="<?php bloginfo('template_directory'); ?>/reources/ics_logo.png" alt="" style="max-width:350px" >  
              
        </div>
    </div>  
    <div class="row align-items-center">  
        
        <div class="col-md-12 p-3">  
        <h2> HOW TO SEARCH? </h2>
        <h3>FOR EXAMPLE !PHONE 11 SCREEN BROKEN" OR YOU CAN SEARCH ANY MODELS, LAPTOPS, SMARTPHONES, XBOX, PLAY STATIONS. WE USUALLY REPLY IN TWO HOURS IN WORKING DAYS</h3>
              
        </div>
    </div>   

</section>














<section class="container login mt-5 mb-5" style="margin-bottom:5rem !important">
        <div class="row align-items-center">           
            <div class="col-sm-12 right col-md-12 p-3">
                    <img src="<?php bloginfo('template_directory'); ?>/reources/images/logo.png" alt="" style="max-width:350px" >                 
                    <div class="catering_form mt-5 mb-5">
                                <div class="_info mt-5 mb-3">
                                <h3>Repair Cost Search </h3>

                                </div>


                                <div class="_form p-4 pt-5 pb-5">
                                <form class="get_repair_price" id="get_repair_price" action="#" >

                                <div class="row">
                                <div class="col-md-12 mb-3">
                                <label for="">Enter Device Name </label>
                                 <div class="_select">
                                      <input type="text" id="search" name="search" placeholder="Search...">
                                  </div>
                                   <div id="search-results"></div>

                                                </div>
                                    
                                </form>
                            </div>
                        </div>
                    </div>
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

     <!-- Font Awsome -->
     <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" ></script> 
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script type="text/javascript">  


            jQuery(document).ready(function($) {
                var searchTimer;
                $('#search').on('input', function() {
                var query = $(this).val();
                if(query != '') {
                    $.ajax({
                        url:"<?php echo admin_url('admin-ajax.php'); ?>",
                        type: 'post',
                        data: { action: 'autocomplete_search', query: query },
                        success: function(data) {
                        $('#search-results').html(data);
                        }
                    });
                } else {
                    $('#search-results').html('');
                }
            });
            });

        
        

        jQuery(document).ready(function($) {	
            $('._cross').click(function(){           
            $(".hideme").css("display", "none");
        });

        $("#ticket_cat").change(function () {     
                var parent_id = this.value ;
                var cat_slug = this.getAttribute("id").value;
                var selected = $(this).find('option:selected');
                var category_slug = selected.data('id');
                $.ajax(
                        {
                            type:"POST",
                            url:"<?php echo admin_url('admin-ajax.php'); ?>",
                            data: {
                                action: "super_get_child_cat",
                                parent_id: parent_id
                            },   
                            success: function(response){      
                                $('#model_cat').html(response);
                            }                
                    });
                $.ajax(
                    {
                        type:"POST",
                        url:"<?php echo admin_url('admin-ajax.php'); ?>",
                        data: {
                            action: "super_get_fault_cat",
                            parent_id: category_slug
                        },   
                        success: function(response){  
                            $('#falt_cat').html(response);
                        }            
                    });       
        });

        $("#model_cat").change(function () {
                    var selected = $(this).find('option:selected');
                    var mod_slug = selected.data('id'); 
                    $.ajax(
                            {
                                type:"POST",
                                url:"<?php echo admin_url('admin-ajax.php'); ?>",
                                data: {
                                    action: "super_get_model_cat",
                                    parent_id: mod_slug
                                },                      
                                success: function(response){   
                                    $('#model_nocat').html(response);
                                }                    
                        });       
            });                 
            $("#get_repair_price").submit(function(e) {                          
                e.preventDefault(); 
                var ticket_cat = jQuery('#ticket_cat').val();
                var model_cat = jQuery('#model_cat').val();	 
                var falt_cat = jQuery('#falt_cat').val();	
                var model_nocat = jQuery('#model_nocat').val();	 
                var parts_availablity = jQuery('#parts_availablity').val();	  
                var repair_cost = jQuery('#repair_cost').val();	    
                var diagnostic_fee = jQuery('#diagnostic_fee').val();
                var uid = jQuery('#uid').val(); 
                form_data = new FormData();      
                form_data.append('action', 'get_repair_price');                
                form_data.append('ticket_cat', ticket_cat); 
                form_data.append('model_cat', model_cat);                
                form_data.append('falt_cat', falt_cat); 
                form_data.append('model_nocat', model_nocat);  
                form_data.append('parts_availablity', parts_availablity);    
                form_data.append('repair_cost', repair_cost);  
                form_data.append('diagnostic_fee', diagnostic_fee);   
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
                            $("#spinner-div").hide();  },   
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













