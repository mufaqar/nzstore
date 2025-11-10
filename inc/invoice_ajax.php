<?php
// ==========================
// SAVE INVOICE
// ==========================
add_action('wp_ajax_admin_create_invoice', 'admin_create_invoice');
function admin_create_invoice() {
    $title = sanitize_text_field($_POST['name'] . ' - ' . $_POST['date']);
    $invoice_id = wp_insert_post([
        'post_title' => $title,
        'post_type' => 'invoice',
        'post_status' => 'publish',
    ]);

    update_post_meta($invoice_id, 'invoice_date', sanitize_text_field($_POST['date']));
    update_post_meta($invoice_id, 'client_name', sanitize_text_field($_POST['name']));
    update_post_meta($invoice_id, 'address', sanitize_text_field($_POST['address']));
    update_post_meta($invoice_id, 'device_type', sanitize_text_field($_POST['device_type']));
    update_post_meta($invoice_id, 'repair', sanitize_text_field($_POST['repair']));
    update_post_meta($invoice_id, 'cost', sanitize_text_field($_POST['cost']));
    update_post_meta($invoice_id, 'subtotal', sanitize_text_field($_POST['subtotal']));
    update_post_meta($invoice_id, 'gst', sanitize_text_field($_POST['gst']));
    update_post_meta($invoice_id, 'total', sanitize_text_field($_POST['total']));
    update_post_meta($invoice_id, 'invoice_uid', get_current_user_id());

    wp_send_json_success(['invoice_id' => $invoice_id]);
}


// ==========================
// GENERATE PDF 
// ==========================
add_action('wp_ajax_admin_generate_invoice_pdf', 'admin_generate_invoice_pdf');
function admin_generate_invoice_pdf() {
    require_once get_template_directory() . '/tcpdf/tcpdf.php';

    $invoice_id   = intval($_POST['invoice_id']);
    $client_name  = get_post_meta($invoice_id, 'client_name', true);
    $invoice_date = get_post_meta($invoice_id, 'invoice_date', true);
    $address      = get_post_meta($invoice_id, 'address', true);
    $device_type  = get_post_meta($invoice_id, 'device_type', true);
    $repair       = get_post_meta($invoice_id, 'repair', true);
    $cost         = get_post_meta($invoice_id, 'cost', true);
    $subtotal     = get_post_meta($invoice_id, 'subtotal', true);
    $gst          = get_post_meta($invoice_id, 'gst', true);
    $total        = get_post_meta($invoice_id, 'total', true);

    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
    $pdf->SetCreator('Invoice System');
    $pdf->SetAuthor('Your Company');
    $pdf->SetTitle('Invoice #' . $invoice_id);
    $pdf->SetMargins(15, 20, 15);
    $pdf->AddPage();

    $logo_path = get_template_directory() . '/images/logo.png';
    if (file_exists($logo_path)) {
        $pdf->Image($logo_path, 160, 10, 30);
    }

    $html = '
    <h2 style="text-align:center;">TAX INVOICE</h2>
    <table border="0" cellpadding="5" width="100%">
      <tr>
        <td width="60%">
          <strong>' . esc_html($client_name) . '</strong><br>
          ' . esc_html($address) . '
        </td>
        <td width="40%" align="right">
          <strong>Invoice Date:</strong> ' . esc_html($invoice_date) . '<br>
          <strong>Invoice No:</strong> ' . esc_html($invoice_id) . '<br>
          <strong>GST 15%</strong>
        </td>
      </tr>
    </table>
    <br><br>

    <table border="1" cellpadding="6" cellspacing="0" width="100%">
      <tr bgcolor="#f5f5f5">
        <th width="55%">Description</th>
        <th width="15%">Qty</th>
        <th width="15%">Unit Price</th>
        <th width="15%">Amount</th>
      </tr>
      <tr>
        <td>' . esc_html($repair) . ' (' . esc_html($device_type) . ')</td>
        <td align="center">1</td>
        <td align="right">' . number_format($cost, 2) . '</td>
        <td align="right">' . number_format($cost, 2) . '</td>
      </tr>
    </table>
    <br><br>

    <table border="0" cellpadding="4" width="100%">
      <tr><td align="right"><strong>Subtotal:</strong> ' . number_format($subtotal, 2) . '</td></tr>
      <tr><td align="right"><strong>GST (15%):</strong> ' . number_format($gst, 2) . '</td></tr>
      <tr><td align="right"><strong>Total (NZD):</strong> ' . number_format($total, 2) . '</td></tr>
    </table>

    <br><hr><br>
    <p><strong>Payment Advice</strong><br>
    Bank Name: ABC Traders<br>
    Account: 12-3456-7890-00<br>
    Reference: Invoice ' . $invoice_id . '<br>
    Please make payment within 7 days of invoice date.
    </p>

    <br><br>
    <p style="text-align:center; font-size:10px; color:#777;">
    Thank you for your business!<br>
    This is a computer-generated invoice. No signature required.<br>
    <strong>Footer Note:</strong> All payments are subject to our standard terms.
    </p>';

    $pdf->writeHTML($html, true, false, true, false, '');

    $upload_dir = wp_upload_dir();
    $file_path = $upload_dir['basedir'] . "/invoice-$invoice_id.pdf";
    $pdf->Output($file_path, 'F');

    $file_url = $upload_dir['baseurl'] . "/invoice-$invoice_id.pdf";
    wp_send_json_success(['pdf_url' => $file_url]);
}
