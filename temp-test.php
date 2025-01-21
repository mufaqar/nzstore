<?php /* Template Name: Test  */ 
        get_header();
     




    
        
                $to = 'mufaqar@gmail.com'; // Replace with your email
                $subject = 'Test Email from WordPress';
                $message = 'This is a test email sent from your WordPress site.';
                $headers = ['Content-Type: text/html; charset=UTF-8'];
        
                if (wp_mail($to, $subject, $message, $headers)) {
                    echo '<p style="color: green;">Test email sent successfully!</p>';
                } else {
                    echo '<p style="color: red;">Test email failed. Check your server configuration.</p>';
                }
          
 
        
