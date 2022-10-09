    <?php /* Template Name: Agent-Order  */
        get_header('admin');


    ?>
        <?php include('navigation.php'); ?>
        <div class="admin_parrent">
            <div class="toggle_btn">
                <div class="row ">
                    <div class="catering_wrapper mt-5 mb-2  p-0 w-100">
                        <div class="catering_menu buttons">
                        <a id="1" class="showSingle _active" target="1" data="">All</a>
                        <a id="2" class="showSingle" target="2" data="Complete">Complete</a>
                        <a id="3" class="showSingle" target="3" data="Pending">Pending</a>
                        <a id="4" class="showSingle" target="4" data="Cancel">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
            <section id="div1" class="targetDiv activediv tablediv">
            <table id="allusers" class="table table-striped orders_table" style="width:100%">
            <?php global $current_user; wp_get_current_user();  $uid = $current_user->ID;  ?>
                <thead>
                        <tr>
                            <th>Sr #</th>
                            <th>Ticket ID</th>
                            <th>Date</th>
                            <th>Model</th>                                                                       
                            <th>Price</th>
                            <th>Status</th>
                            <th>Action</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                        $i = 0;

                        query_posts(array(
                            'post_type' => 'orders',
                            'posts_per_page' => -1,
                            'order' => 'desc',
                            'meta_query' => array(
                                array(
                                    'key' => 'order_uid',
                                    'value' => $uid,
                                    'compare' => '=='
                                ),
                            )
                        ));
                        if (have_posts()) :  while (have_posts()) : the_post(); $pid = get_the_ID(); $i++; ?>
                                 <tr>
                                                <td><?php echo $i;?></td>
                                                <td><?php echo $pid?></td>                                                
                                                <td><?php echo get_post_meta( get_the_ID(), 'date', true ); ?> </td>
                                                <td><?php the_title(); ?></td>
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
                                               
                                                <td> <a href="<?php echo home_url('edit-ticket?id='.$pid.''); ?>">Edit </a>  <i class="fa-solid fa-down-to-line"></i></td>
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