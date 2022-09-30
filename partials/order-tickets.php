
    <div class="custom_container catering_wrapper mt-5 mb-5">
                 <div class="calender_wrapper d-flex justify-content-between align-items-center mt-5">
                        <div class="catering_heading d-flex align-items-center">
                            <h2>Tickets</h2>
                          
                        </div>
                       
                        </div>
                        <div class="catering_card_wrapper">
                            <div class="invoice_table">
                                <table class="_table">
                                    <thead>
                                    <tr>
                                        <th scope="col"> ID</th>
                                      
                                        <th scope="col">Title</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Shipping Details</th>
                                        <th scope="col">Issues</th>                                      
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                
                                        <?php 
                                            global $current_user;
                                            wp_get_current_user();
                                            query_posts(array(
                                                    'post_type' => 'tickets',
                                                    'posts_per_page' => -1,
                                                    'order' => 'desc',                                                 
                                                    'meta_query' => array(   
                                                       
                                                            array(
                                                                'key'     => 'order_uid',
                                                                'value'   => $current_user->ID,
                                                                'compare' => '='
                                                            )
                                                    )
                                                    
                                                ));              
                                        
                                                if (have_posts()) :  while (have_posts()) : the_post(); $pid =  get_the_ID();?>
                                                                <tr>
                                                                <td scope="row"><?php echo get_the_ID()?></td>
                                                                        <td scope="row"><?php the_title()?></td>
                                                                      
                                                                        <td><?php echo get_post_meta( get_the_ID(), 'date', true ); ?>                                                                   
                                                                    
                                                                    
                                                                    
                                                                    </td>
                                                                        <td><?php echo get_post_meta( get_the_ID(), 'shipping', true ); ?></td>
                                                                        <td><?php the_content(); ?></td>
                                                                       
                                                                        <td><?php foreach ( get_the_terms( get_the_ID(), 'ticket_type' ) as $tax ) {
                                                                                    echo $tax->name ;
                                                                                } ?></td>
                                                                        <td> <a href="<?php echo home_url('edit-tickets?id='.$pid.''); ?>">Edit </a>  <i class="fa-solid fa-down-to-line"></i></td>
                                                                        </tr>
                                            <?php endwhile; wp_reset_query(); else : ?>
                                                    <h2><?php _e('Nothing Found','lbt_translate'); ?></h2>
                                                <?php endif; ?>  
                                        
                                        
                                    </tbody>
                                </table>
                            </div>                

                        </div>
                
     </div>
              
                        

