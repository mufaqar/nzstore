<?php get_header('landing'); ?>
           
<main class="launch_calandar">
        <div class="row d-flex">
           
        </div>    


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
                <?php 
                        query_posts(array(
                            'post_type' => 'repair',
                            'posts_per_page' => 1,
                            'order' => 'desc',  
                          
                        ) ); 

            
                if (have_posts()) :  while (have_posts()) : the_post();
                $date = get_field('date'); ?>
                        <div class="catering_card _pro_salat">
                            <h3>Modle  # <?php the_title() ?></h3>  

                            
                            

                            <div class="row">
                                <div class="col-md-4">
                                    <h6 class="mt-2">Fault Type:</h6>                                                                  
                                </div>
                                <div class="col-md-8">                               
                                    <?php ?>                               
                                </div>                        
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <h6 class="mt-2">Type:</h6>                                                                  
                                </div>
                                <div class="col-md-8">                               
                                <?php    echo "65" ;?>                                 
                                </div>                        
                            </div>


                            <div class="row">
                                <div class="col-md-4">
                                    <h6 class="mt-2">	Model:</h6>                                                                  
                                </div>
                                <div class="col-md-8">                               
                                <?php    echo "65" ;?>                                 
                                </div>                        
                            </div>


                            <div class="row">
                                <div class="col-md-4">
                                    <h6 class="mt-2">Price:</h6>                                                                  
                                </div>
                                <div class="col-md-8">                               
                                    <?php    echo "65" ;?>                               
                                </div>                        
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <h6 class="mt-2">Issues:</h6>                                                                  
                                </div>
                                <div class="col-md-8">                               
                                  <?php echo get_post_meta( $post->ID, 'issues', true ); ?>                               
                                </div>                        
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <h6 class="mt-2">Technician Remarks:</h6>                                                                  
                                </div>
                                <div class="col-md-8">                               
                                  <?php echo get_post_meta( $post->ID, 'eng_remarks', true ); ?>                               
                                </div>                        
                            </div>

                            











                        </div>
                    <?php endwhile;
                    wp_reset_query();
                else : ?>
                   
                    <div class="catering_card _pro_salat">
                            <h3> 404 Not Found</h3>
                                             
                        </div>


                <?php endif; ?>
            </div>
            </div>
           
    </section>                
  

    </div>

    </div>
    </div>
    </div>

    </main>

<?php get_footer(); ?>