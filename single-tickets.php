<?php get_header(); ?>
<?php include('agent/navigation.php'); ?> 

<div class='blogs_wrapper mt-4'>
            <div class='blogs'>

          
                <h3 class="ad_productss">Ticket Details</h3>
                
                <div class="invoice_table">
                  <table class="invoice_slip_table">
                    <thead>
                      <tr>
                        <th scope="col">Info</th>
                        <th scope="col">Details</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td><strong>Ticket ID: </strong></td>
                        <td"><strong>Ticket ID: </strong></td>
                      </tr>
                      
                    </tbody>
                  </table>

                  <!-- <h5 class="mt-4">Summary</h5>
                  <table class="invoice_slip_table">
                    <thead>
                      <tr>
                        <th scope="col">Description</th>
                        <th scope="col">Number</th>
                      </tr>
                    </thead>
                    <tbody>
                      
                      <tr>
                        <td scope="row"><strong>Salad</td>
                        <td scope="row">2 <sub>stk</sub></td>
                      </tr>
                      <tr>
                        <td scope="row"><strong>Vegan</td>
                        <td scope="row">2 <sub>stk</sub></td>
                      </tr>
                    

                    </tbody>
                  </table> -->


                </div>

              
            
                <div class="row">
<?php if (have_posts()) : while (have_posts()) : the_post(); 



the_title();







?>

<?php endwhile; endif; ?>

</div>
            </div>
        </div>
        
    </main>


<?php //get_sidebar('blog'); ?>
<?php get_footer(); ?>