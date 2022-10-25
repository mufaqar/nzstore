<?php





// Agent Activation Email 

function activation_mail($to,$activation_link) {
	$subject = 'Kiwi Mobile | User Account Activation';	
	$headers = "From: no_reply@kiwimobiles.co.nz" . "\r\n" ;
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
	$body   = "<p><img src='https://kiwimobiles.co.nz/jobform/wp-content/themes/nzstore/reources//images/logo.png' width='320px'></img></p><hr/> ";
	$body  .= "<p><strong> Account Activation Link: </strong><a href='$activation_link' >Activate your Account</a> </p> ";
	$body  .= "<p><strong> DID:   </strong> 09 9508717 </p> ";
	$body  .= "<p><strong> Email:   </strong>repair@kiwimobiles.co.nz  </p> ";
	mail( $to, $subject, $body, $headers );
}


function send_reset_password($username,$password) {
	$subject = 'Kiwi Mobile | User Account Activation';	
	$headers = "From: no_reply@kiwimobiles.co.nz" . "\r\n" ;
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
	$body   = "<p><img src='https://kiwimobiles.co.nz/jobform/wp-content/themes/nzstore/reources//images/logo.png' width='320px'></img></p><hr/> ";
	$body  .= "<p><strong> Username : </strong>$username </p> ";
	$body  .= "<p><strong> Password : </strong>$password </p> ";
	mail( $to, $subject, $body, $headers );
}



function sendmail_agent($to,$password) {
	$to = $to;	
	$home_url =  home_url();
	$subject = 'Kiwi Mobile | Agent Login Details';
	$body  = "<p><img src='https://kiwimobiles.co.nz/jobform/wp-content/themes/nzstore/reources//images/logo.png' width='320px'></img></p><hr/> ";
	$body  .= "<p>Dear User</p><p><strong> Username :  </strong> $to </p> <p> <strong> Password : </strong> $password  </p>";
	$body  .= "<h3> WHO ARE WE, AND WHY ARE WE?</h3>
					<p>Thanks for subscribing to your online repair centre portal; now you can create your first query for any of your repair issues, the Galaxies series, iPhones, iPods, MacBooks, Laptops, X-BOX, and Gaming Machines.</p>
					<p>We often stock all parts of the products mentioned above to repair fast. Online portal updates of your queries are generated until we receive your product repair and send them back with online tracking details in your dedicated login portal with us. 
					</p><p>DID: 09 9508717</p> <p> DID: 07 3477044   Email: repair@kiwimobiles.co.nz </p>  <p>  Email: repair@kiwimobiles.co.nz</p>                        
				</p>www.icsservices.nz  www.smartphonesrepair.co.nz </p> ";
	$body  .= "<p> <a href='$home_url'>Now you can login </a> </p>";
	$headers = "From: no_reply@kiwimobiles.co.nz" . "\r\n" ;
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
	mail( $to, $subject, $body, $headers );
}


function sendmail_admin($user_email) {
	$admin = 'mufaqar@gmail.com';
	$subject = 'Kiwi Mobile | New Agent Registerd  ';
	$body  = "<p><strong> Email Address :  </strong> $user_email </p> ";
	$body  .= "<p><img src='https://kiwimobiles.co.nz/jobform/wp-content/themes/nzstore/reources//images/logo.png' width='320px'></img></p><hr/> ";
	$body  .= "<p><strong> Email Address: </strong> $user_email </p> ";
	$body  .= "<p><strong> DID:   </strong> 09 9508717 </p> ";
	$body  .= "<p><strong> Email:   </strong>repair@kiwimobiles.co.nz  </p> ";
	$headers = "From: no_reply@kiwimobiles.co.nz" . "\r\n" ;
	//$headers .= 'Bcc: choudhry.asif@gmail.com,budgetcomputer2013@gmail.co,uziasif06@gmail.com';
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
	mail( $admin, $subject, $body, $headers );
}







