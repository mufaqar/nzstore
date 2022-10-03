<thead>
                        <tr>
                            <th>Sr #</th>
                            <th>Order ID</th>
                            <th>Date</th>
                            <th>Title</th>
                             <th>Issue</th>                             
                            <th>Price</th>
                            <th>Status</th>
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
                                        <td scope="row"><?php echo $i;?></td>
                                                <td scope="row"><?php echo $pid?></td>                                                
                                                <td><?php echo get_post_meta( get_the_ID(), 'date', true ); ?> </td>
                                                <td><?php echo get_post_meta( get_the_ID(), 'shipping', true ); ?></td>
                                                <td><?php the_content(); ?></td>                                                
                                                <td><?php echo get_post_meta( get_the_ID(), 'price', true ); ?></td>
                                                <td> <a href="<?php echo home_url('edit-ticket?id='.$pid.''); ?>">Edit </a>  <i class="fa-solid fa-down-to-line"></i></td>
                                                </tr>
                            <?php endwhile;
                            wp_reset_query();
                        else : ?>
                            <h2><?php _e('Nothing Found', 'lbt_translate'); ?></h2>
                        <?php endif; ?>

                    </tbody>
