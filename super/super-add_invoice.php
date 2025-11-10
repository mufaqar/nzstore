<?php
/* Template Name: Add Invoice */
get_header('admin');
include('navigation.php');

// Current user info
global $current_user;
wp_get_current_user();
$uid = $current_user->ID;
?>

<div class="custom_container catering_form mt-5 mb-3">
  <div class="_info mt-5 mb-5">
    <h2>Create Invoice</h2>
  </div>

  <div class="_form p-4 pt-5 pb-5">
    <form id="create_invoice" action="#" method="POST">

      <div class="row">
        <!-- Date / Name -->
        <div class="col-md-6 mb-3">
          <label>Date</label>
          <input type="date" id="invoice_date" class="form-control" required>
        </div>
        <div class="col-md-6 mb-3">
          <label>Name / Company Name</label>
          <input type="text" id="client_name" class="form-control" placeholder="Enter name" required>
        </div>

        <!-- Address / Device Type -->
        <div class="col-md-6 mb-3">
          <label>Address</label>
          <input type="text" id="address" class="form-control" placeholder="Enter address">
        </div>
        <div class="col-md-6 mb-3">
          <label>Device Type</label>
          <input type="text" id="device_type" class="form-control" placeholder="e.g. Laptop, Phone">
        </div>

        <!-- Repair / Cost -->
        <div class="col-md-6 mb-3">
          <label>Repair</label>
          <input type="text" id="repair" class="form-control" placeholder="Enter repair details" required>
        </div>
        <div class="col-md-6 mb-3">
          <label>Cost</label>
          <input type="number" id="cost" class="form-control" placeholder="Enter cost" required>
        </div>

        <!-- Totals -->
        <div class="col-md-6 mb-3">
          <label>Sub Total</label>
          <input type="number" id="subtotal" class="form-control" readonly>
        </div>

        <div class="col-md-6 mb-3">
          <label>15% GST</label>
          <input type="number" id="gst" class="form-control" readonly>
        </div>

        <div class="col-md-6 mb-3">
          <label>Total Including GST</label>
          <input type="number" id="total" class="form-control" readonly>
        </div>

        <!-- Save -->
        <div class="col-md-12 mt-4 text-end">
          <button type="submit" class="btn btn-primary px-4">💾 Save Invoice</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Overlay Modal -->
<section class="hideme zindex-modal overlay">
  <div class="popup">
    <div class="popup_wrapper text-center p-4">
      <h2 class="mb-3">Invoice Created Successfully!</h2>
      <button class="btn btn-secondary _cross">Close</button>
    </div>
  </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
jQuery(document).ready(function($){

  // Auto calculate GST & total
  $('#cost').on('input', function(){
    let cost = parseFloat($(this).val()) || 0;
    let gst = cost * 0.15;
    let total = cost + gst;
    $('#subtotal').val(cost.toFixed(2));
    $('#gst').val(gst.toFixed(2));
    $('#total').val(total.toFixed(2));
  });

  $('._cross').click(function(){
    $(".hideme").hide();
  });

  // Submit invoice form
  $("#create_invoice").submit(function(e){
    e.preventDefault();

    let data = {
      action: "admin_create_invoice",
      date: $('#invoice_date').val(),
      name: $('#client_name').val(),
      address: $('#address').val(),
      device_type: $('#device_type').val(),
      repair: $('#repair').val(),
      cost: $('#cost').val(),
      subtotal: $('#subtotal').val(),
      gst: $('#gst').val(),
      total: $('#total').val(),
      uid: "<?php echo $uid; ?>"
    };

    $.post("<?php echo admin_url('admin-ajax.php'); ?>", data, function(response){
      if(response.success){
        const invoiceId = response.data.invoice_id;

        // Generate PDF
        $.post("<?php echo admin_url('admin-ajax.php'); ?>", {
          action: "admin_generate_invoice_pdf",
          invoice_id: invoiceId
        }, function(pdfRes){
          if(pdfRes.success){
           // window.open(pdfRes.data.pdf_url, '_blank');
            $(".overlay").show();
          } else {
            alert("PDF Error: " + pdfRes.data);
          }
        });
      } else {
        alert("Error saving invoice: " + response.data);
      }
    });
  });

});
</script>

<?php get_footer(); ?>
