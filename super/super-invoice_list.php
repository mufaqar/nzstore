<?php 
/* Template Name: Invoice List  */
get_header('admin'); 
?>

<style>
#div1 {
    width: 90% !important;
    margin: 0 auto;
}

.action-btns button {
    margin-right: 5px;
    font-size: 13px;
}
</style>

<?php include('navigation.php'); ?>

<div class="admin_parrent">
    <section id="div1" class="targetDiv activediv tablediv">
        <table id="invoice_orders" class="table table-striped orders_table export_table" style="width:100%">
            <thead>
                <tr>
                    <th>Sr #</th>
                    <th>Name/Company</th>
                    <th>Date</th>
                    <th>Device</th>
                    <th>Total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $i = 0;
                $invoices = new WP_Query([
                    'post_type' => 'invoice',
                    'posts_per_page' => -1,
                    'order' => 'DESC'
                ]);

                if ($invoices->have_posts()) :  
                    while ($invoices->have_posts()) : $invoices->the_post(); 
                        $pid = get_the_ID();
                        $i++;
                        $client_name = get_post_meta($pid, 'client_name', true);  
                        $device_type =  get_post_meta($pid, 'device_type', true); 
                        $invoice_date =  get_post_meta($pid, 'invoice_date', true); 
              
                        $repair = get_post_meta($pid, 'repair', true);  
                        $gst = get_post_meta($pid, 'gst', true);  
                        $total = get_post_meta($pid, 'total', true);  
                          ?>

                <tr>
                    <td><?php echo $i ?></td>
                    <td><?php echo $client_name ?></td>
                    <td><?php echo $invoice_date ?></td>
                    <td><?php echo $device_type ?></td>

                    <td><?php echo $total?></td>
                    <td class="action-btns">
                        <button class="btn btn-sm btn-success whatsapp-btn" data-id="<?php echo $pid; ?>"
                            data-name="<?php echo esc_attr($client_name); ?>">📱 WhatsApp</button>

                        <button class="btn btn-sm btn-info view-pdf-btn" data-id="<?php echo $pid; ?>">📄 View
                            PDF</button>

                        <button class="btn btn-sm btn-primary email-btn" data-id="<?php echo $pid; ?>">✉️ Email</button>
                    </td>
                </tr>
                <?php 
                    endwhile; 
                    wp_reset_postdata();
                else: ?>
                <tr>
                    <td colspan="7" class="text-center">No invoices found</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </section>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script>
// ===============================
// ✅ View PDF in Modal
// ===============================
$(document).on('click', '.view-pdf-btn', function() {
    const invoice_id = $(this).data('id');
    $('#pdfFrame').attr('src', '');
    $('#pdfModal').fadeIn();

    $.ajax({
        type: 'POST',
        url: '<?php echo admin_url("admin-ajax.php"); ?>',
        data: {
            action: 'admin_generate_invoice_pdf',
            invoice_id: invoice_id
        },
        beforeSend: function() {
            $('#pdfFrame').attr('src', 'about:blank');
        },
        success: function(res) {
            if (res.success) {
                const pdf_url = res.data.pdf_url;
                $('#pdfFrame').attr('src', pdf_url);
            } else {
                alert('❌ Error generating PDF: ' + res.data);
                $('#pdfModal').fadeOut();
            }
        },
        error: function() {
            alert('❌ AJAX error while generating PDF');
            $('#pdfModal').fadeOut();
        }
    });
});

// Close modal
$(document).on('click', '#closePdfModal', function() {
    $('#pdfModal').fadeOut();
    $('#pdfFrame').attr('src', '');
});

// ===============================
// ✅ WhatsApp Share Button
// ===============================
$(document).on('click', '.whatsapp-btn', function() {
    const invoice_id = $(this).data('id');
    const client_name = $(this).data('name') || 'Client';

    // Generate PDF first, then share
    $.ajax({
        type: 'POST',
        url: '<?php echo admin_url("admin-ajax.php"); ?>',
        data: {
            action: 'admin_generate_invoice_pdf',
            invoice_id: invoice_id
        },
        success: function(res) {
            if (res.success) {
                const pdf_url = res.data.pdf_url;
                const message = `Hello ${client_name}, here is your repair invoice:\n${pdf_url}`;
                const whatsapp_url = `https://wa.me/?text=${encodeURIComponent(message)}`;
                window.open(whatsapp_url, '_blank');
            } else {
                alert('❌ Failed to generate invoice PDF: ' + res.data);
            }
        },
        error: function() {
            alert('❌ Error contacting server.');
        }
    });
});
</script>

<!-- ✅ PDF Modal -->
<div id="pdfModal"
    style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.8); z-index:9999;">
    <div
        style="position:relative; width:80%; height:90%; margin:5% auto; background:#fff; padding:10px; border-radius:8px;">
        <button id="closePdfModal"
            style="position:absolute; top:5px; right:10px; font-size:20px; background:none; border:none; cursor:pointer;">❌</button>
        <iframe id="pdfFrame" src="" style="width:100%; height:100%; border:none;"></iframe>
    </div>
</div>

<?php get_footer('admin'); ?>