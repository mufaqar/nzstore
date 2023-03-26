<?php get_header('landing'); ?>


<section class="container login mt-5 mb-5" style="margin-bottom:5rem !important">
        <div class="row align-items-center">           
            <div class="col-sm-12 right col-md-12 p-3">
                    <img src="<?php bloginfo('template_directory'); ?>/reources/images/logo.png" alt="" style="max-width:350px" >                 
                    
           
<main class="launch_calandar">
        


        <div class="content">
                <div class="container_wrapper">
                    

     <div class="tab_wrapper">
        <?php page_title() ?>
    </div>

    


    <div class="custom_container catering_wrapper ">                       
                       
    
    <section id="div1" class="targetDiv activediv">

   

<div class="catering_card_wrapper">
            <div class="ajaxload"></div>
            <div class="foodlist">       
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                        <div class="catering_card _pro_salat">
                            <h3><?php the_title() ?></h3>  

                            
                            

                            <div class="row">
                                <div class="col-md-4">
                                    <h6 class="mt-2">Diagnostic Fee</h6>                                                                  
                                </div>
                                <div class="col-md-8">                               
                                    <?php   echo get_post_meta( get_the_ID(), 'diagnostic_fee', true );?>                               
                                </div>                        
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <h6 class="mt-2">Parts Availablity:</h6>                                                                  
                                </div>
                                <div class="col-md-8">                               
                                <?php  echo get_post_meta( get_the_ID(), 'parts_availablity', true );?>                           
                                </div>                        
                            </div>


                            <div class="row">
                                <div class="col-md-4">
                                    <h6 class="mt-2">	Repair Cost</h6>                                                                  
                                </div>
                                <div class="col-md-8">                               
                                <?php  echo get_post_meta( get_the_ID(), 'repair_cost', true );?>                                
                                </div>                        
                            </div>

                            











                        </div>
                        <?php endwhile; endif; ?>
            </div>
            </div>

            <br/><br/>

            <a class="btn_primary"  href="https://kiwimobiles.co.nz/jobform/search-price/">Check Another Device Price </a>
           
    </section>                
  

    </div>

    </div>
    </div>
    </div>

    </main>

<?php get_footer(); ?>