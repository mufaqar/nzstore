<?php
/*
 * Template Name: Test
 */

get_header();
?>



<div id='pdf'>
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
      </div>
</div>


<button id='print-btn'>Start print process</button>





<?php

get_footer();?>



<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.2.61/jspdf.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/canvg/1.4.0/canvg.min.js"></script>





  <script type="text/javascript">
 $('#print-btn').click(()=>{
var pdf = new jsPDF('p','pt','a4');
htmlString = document.getElementById("main");
pdf.addHTML(document.body,function() {
    pdf.save('web.pdf');
});
})
  </script>

