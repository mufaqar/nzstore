                <thead>
                        <tr>
                            <th>Sr #</th>
                            <th>Order ID</th>
                            <th>Ticket ID</th>
                         
                            <th>Agent</th>                         
                            <th>Order Date</th>                             
                            <th>Price</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php 
                        $i = 0;
                        query_posts(array(
                            'post_type' => 'orders',
                            'posts_per_page' => -1,
                            'order' => 'desc'
                        ));

                        if (have_posts()) :  while (have_posts()) : the_post();
                                $i++; ?>
                                <tr>
                                    <td><?php echo $i ?></td>
                                    <td><?php the_title() ?></td>
                                    <td><?php the_title() ?></td>
                                    <td><?php the_date('Y-m-d');?></td> 
                                    <td><?php the_date('Y-m-d');?></td>                          
                                    <td>$ <?php echo get_post_meta(get_the_ID(), 'order_price', true); ?></td>
                                    <td><span class="status <?php echo get_post_meta(get_the_ID(), 'order_status', true); ?>"><?php echo get_post_meta(get_the_ID(), 'order_status', true); ?> </span> </td>
                                </tr>
                            <?php endwhile;
                            wp_reset_query();
                        else : ?>
                            <h2><?php _e('Nothing Found', 'lbt_translate'); ?></h2>
                        <?php endif; ?>

                    </tbody>
