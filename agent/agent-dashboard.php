<?php /* Template Name: Agent-Dashboard */
get_header();
?>
<?php include('navigation.php'); ?>

<!-- tabs -->

<div class="admin_parrent">
<div class="toggle_btn">
        <div class="row ">
            <div class="catering_wrapper mt-5 mb-2 col-md-10 p-0">
                <div class="catering_menu buttons">
                    <a id="1" class="showSingle _active" target="1" data="">All Orders</a>
                    <a id="2" class="showSingle" target="2" data="Quotation">Quotation</a>
                    <a id="3" class="showSingle" target="2" data="Approval">Approval</a>
                    <a id="4" class="showSingle" target="2" data="Completed">Completed</a>
                </div>
            </div>
        </div>
    </div>
            <section id="div1" class="targetDiv activediv tablediv">
                <table id="all" class="table table-striped orders_table" style="width:100%">

                <?php global $current_user; wp_get_current_user();  $uid = $current_user->ID; ?>


<thead>
                        <tr>
                            <th>Sr #</th>
                            <th>Ticket ID</th>
                            <th>Date</th>
                            <th>Model</th>                                                                       
                            <th>Price</th>
                            <th>Status</th>
                            <th>Action</th>
                            <!-- <th>Action</th> -->
                        </tr>
                    </thead>
                    <tbody>

                    <?php 
                        $i = 0;

                        query_posts(array(
                            'post_type' => 'tickets',
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
                                                <td><?php echo get_post_meta( get_the_ID(), 'date', true ); ?></td>                                              
                                                <td><?php the_title();  get_noftication($pid);?>  </td>    
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
                                                <!-- <td> <a href="<?php the_permalink()?>">View Ticket </a>  <i class="fa-solid fa-down-to-line"></i></td> -->
                                                <td> <a href="<?php echo home_url('/agent-dashboard/edit-ticket?id='.$pid.''); ?>">Edit </a>  <i class="fa-solid fa-down-to-line"></i></td>
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


<?php get_footer(); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/reources/js/script.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function () {     

            var table = $('#all').DataTable();
            $('.catering_menu').on( 'click', 'a', function () {  
                $(".catering_menu a").removeClass("_active");
                $(this).addClass("_active");               
               
            table
                .columns( 6 )
                .search( $(this).attr('data') )
                .draw();
               
            });

        })
        $(document).ready(function () {
            var table = $('#allusers').DataTable();
            $('.catering_menu').on( 'click', 'a', function () {
                $(".catering_menu a").removeClass("_active");
                $(this).addClass("_active"); 
               
            table
                .columns( 1 )
                .search(  $(this).attr('data') )
                .draw();
            });
        })
       
        $(document).ready(function () {
            $('#cancle').DataTable();
        })

       


    </script>