<?php /* Template Name: Admin-Dashboard  */
get_header('admin');
?>
<?php include('navigation.php'); ?>
<div class="admin_parrent">
    <div class="toggle_btn">
        <div class="row ">
            <div class="catering_wrapper mt-5 mb-2 col-md-8 p-0">
                <div class="catering_menu buttons">
                <a id="1" class="showSingle _active" target="1" data="">All Orders</a>
                    <a id="2" class="showSingle" target="2" data="qoutation">Qoutation</a>
                    <a id="3" class="showSingle" target="2" data="order-start">Approval</a>
                    <a id="4" class="showSingle" target="2" data="completed">Completed</a>
                </div>
            </div>
        </div>
    </div>
    <section id="div1" class="targetDiv activediv tablediv">
        <table id="allusers" class="table table-striped orders_table" style="width:100%">

        <?php
global $current_user; wp_get_current_user();  $uid = $current_user->ID;

?>


<thead>
                        <tr>
                            <th>Sr #</th>
                            <th>Order ID</th>
                            <th>Date</th>
                            <th>Title</th>
                             <th>Issue</th>                             
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

                        if (have_posts()) :  while (have_posts()) : the_post(); $pid = get_the_ID(); $i++; ?>
                                 <tr>
                                                <td><?php echo $i;?></td>
                                                <td><?php echo $pid?></td>                                                
                                                <td><?php echo get_post_meta( get_the_ID(), 'date', true ); ?> </td>
                                                <td><?php the_title(); ?></td>
                                                <td><?php the_content(); ?></td>                                                
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
                                                <td> <a href="<?php echo home_url('admin-edit-ticket?id='.$pid.''); ?>">Edit </a>  <i class="fa-solid fa-down-to-line"></i></td>
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