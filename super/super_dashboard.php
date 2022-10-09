<?php /* Template Name: Super-Dashboard  */  get_header('admin');
?>
<?php include('navigation.php'); ?>
<div class="admin_parrent">
    <div class="toggle_btn">
        <div class="row ">
            <div class="catering_wrapper mt-5 mb-2 col-md-10 p-0">
                <div class="catering_menu all-tickets buttons">
                    <a id="1" class="showSingle _active" target="1" data="">All Tickets</a>
                    <a id="2" class="showSingle" target="2" data="Quotation">Quotation</a>
                    <a id="3" class="showSingle" target="2" data="Approval">Approval</a>
                    <a id="4" class="showSingle" target="2" data="Completed">Completed</a>
                </div>
            </div>
        </div>
    </div>
    <section id="div1" class="targetDiv activediv tablediv">
        <table id="alltickets" class="table table-striped orders_table" style="width:100%">

        <?php
global $current_user; wp_get_current_user();  $uid = $current_user->ID;

?>


<thead>
                        <tr>
                            <th>Sr #</th>
                            <th>Ticket ID</th>
                            <th>Date</th>
                            <th>Title</th>
                             <th>Agent</th>                             
                            <th>Price</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php 
                        $i = 0;
                        query_posts(array(
                            'post_type' => 'tickets',
                            'posts_per_page' => -1,
                            'order' => 'desc',                            
                        ));

                        if (have_posts()) :  while (have_posts()) : the_post(); $pid = get_the_ID(); $i++;
                        $user_id = get_post_meta( get_the_ID(), 'order_uid', true );

                        $user_info = get_userdata($user_id);
                      
                                            
                        
                        ?>
                                 <tr>
                                                <td><?php echo $i;?></td>
                                                <td><?php echo $pid?></td>                                                
                                                <td><?php echo get_post_meta( get_the_ID(), 'date', true ); ?> </td>
                                                <td><?php the_title(); ?></td>
                                                <td><?php echo $user_info->user_login ?></td>                                              
                                                <td><?php echo get_post_meta( get_the_ID(), 'price', true ); ?></td>
                                               
                                                <td><?php   
                                                        $term_list = get_the_terms($post->ID, 'ticket_type');
                                                        $types ='';
                                                        foreach($term_list as $term_single) {
                                                            $types .= ucfirst($term_single->slug).', ';
                                                        }
                                                        $typesz = rtrim($types, ', ');
                                                        echo $typesz;                                                    
                                                     ?>
                                                </td>
                                                <td><?php   
                                                        $term_ticket_status = get_the_terms($post->ID, 'ticket_status');
                                                     
                                                        foreach($term_ticket_status as $term_status) {
                                                            echo $term_status->name;
                                                        }
                                                                                                      
                                                     ?>
                                                </td>
                                                <td> <a href="<?php echo home_url('/admin-dashboard/edit-ticket?id='.$pid.''); ?>">Edit </a>  <i class="fa-solid fa-down-to-line"></i></td>
                                                </tr>
                            <?php endwhile;
                            wp_reset_query();
                        else : ?>
                            <h2><?php _e('Nothing Found', 'lbt_translate'); ?></h2>
                        <?php endif; ?>

                    </tbody>

           
        </table>

    </section>
    
</div>





<?php get_footer('admin') ?>