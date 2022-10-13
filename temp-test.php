<?php
/*
 * Template Name: Test
 */

get_header();
?>


<body>
<div id='print_id'>
<div class="popup_wrapper">
        <h3 class="ad_productss">Invoice</h3>

        <div class="invoice_table">
          <table class="_table">
            <thead>
              <tr>
                <th scope="col">Invoice Date</th>
                <th scope="col">Total</th>
                <th scope="col">Total</th>
                <th scope="col">Status</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td scope="row">Sunday, May 29, 2022</td>
                <td>80</td>
                <td>459.2</td>
                <td>Complete <i class="fa-solid fa-down-to-line"></i></td>
              </tr>
              <tr>
                <td scope="row">Sunday, June 5, 2022</td>
                <td>80</td>
                <td>459.2</td>
                <td>Pending <i class="fa-solid fa-down-to-line"></i></td>
              </tr>
              <tr>
                <td scope="row">Sunday, June 6, 2022</td>
                <td>80</td>
                <td>459.2</td>
                <td>Pending <i class="fa-solid fa-down-to-line"></i></td>
              </tr>
            </tbody>
          </table>
        </div>

        <img src="../reources//images/red cross.png" alt="" class="_cross">
      </div>
</div>
<a id="basic" href="#nada" class="button button-primary">Print container</a>

<a id="advanced" href="#nada" class="button button-primary">Print kittens</a>
</body>

<?php

get_footer();?>

<script type="text/javascript" src="https://jasonday.github.io/printThis/printThis.js"></script>



 <script>
    $('#basic').on("click", function () {
      $('#print_id').printThis({
        header: "<h1>Look at all of my kitties!</h1>",       
    importCSS: true,      
    importStyle: true,   
    loadCSS: "http://localhost/clients/demo/wp-content/themes/nzstore-ticket/style.css",  
  
      });
    });


    
  </script>

