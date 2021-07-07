<?php  
/* 
Template Name: Registration Form
*/
 
get_header();
?> 
<?php
	$error= '';
	$success = '';
 
	global $wpdb, $PasswordHash, $current_user, $user_ID;
 
	if(isset($_POST['submit']) && $_POST['submit'] == 'register' ) { 
        $first_name = $wpdb->escape(trim($_POST['first_name']));
		$last_name = $wpdb->escape(trim($_POST['last_name']));
		$email = $wpdb->escape(trim($_POST['email']));		
		$password1 = $wpdb->escape(trim($_POST['password1']));
		$password2 = $wpdb->escape(trim($_POST['password2']));		
		$username = $wpdb->escape(trim($_POST['username']));		
		if( $email == "" || $password1 == "" || $password2 == "" || $username == "" || $first_name == "" || $last_name == "") {
			$error= 'Please don\'t leave the required fields.';
		} else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$error= 'Invalid email address.';
		} else if(email_exists($email) ) {
			$error= 'Email already exist.';
		} else if($password1 != $password2 ){
			$error= 'Password do not match.';		
		} else { 
			$user_id = wp_insert_user( 
				array ('first_name' => apply_filters('pre_user_first_name', $first_name), 
					   'last_name' => apply_filters('pre_user_last_name', $last_name), 
					   'user_pass' => apply_filters('pre_user_user_pass', $password1), 
					   'user_login' => apply_filters('pre_user_user_login', $username), 
					   'user_email' => apply_filters('pre_user_user_email', $email), 
					   'role' => 'subscriber'
					  ) 
			);
			if( is_wp_error($user_id) ) {
				$error= 'Error on user creation.';
			} else {
				do_action('user_register', $user_id);				
				$success = 'You\'re successfully register';
// 				$to = 'nehatomar2590@gmail.com';
// 				$subject = 'Registration Successfully';
// 				$body = 'The email body content';
// 				$headers = array('Content-Type: text/html; charset=UTF-8');

// 				wp_mail( $to, $subject, $body, $headers );
			}
			
		}
		
	}
	?>
 
     
    <div class="sp-100 bg-w">
	<div class="container">
		<div class="row">
			<div class="registration_form col-lg-12"> 
				<!--display error or success message-->
				<div id="message">
					<?php 
						if(! empty($error) ) :
							echo '<p class="error">'.$error.'';
						endif;
					?>

					<?php 
						if(! empty($success) ) :
							echo '<p class="error">'.$success.'';
						endif;
					?>
				</div>
                <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                <h3>Register Now</h3>
				<div class="row">
				<div class="col-md-4">
					<p><label>First Name</label></p>
					<p><input type="text" value="<?php echo $_POST['first_name']; ?>" name="first_name" id="first_name" /></p>
				</div>				
				<div class="col-md-4">
					<p><label>Last Name</label></p>
					<p><input type="text" value="<?php echo $_POST['last_name']; ?>" name="last_name" id="last_name" /></p>  
				</div> 
				<div class="col-md-4">             
					<p><label>Email</label></p>
					<p><input type="text" value="<?php echo $_POST['email'] ?>" name="email" id="email" /></p>
				</div>
				<div class="col-md-4">
					<p><label>Username</label></p>
					<p><input type="text" value="<?php echo $_POST['username'] ?>" name="username" id="username" /></p>
				</div>
				<div class="col-md-4">
					<p><label>Password</label></p>
					<p><input type="password" value="" name="password1" id="password1" /></p>
				</div>
				<div class="col-md-4">
					<p><label>Confirm Password</label></p>
					<p><input type="password" value="" name="password2" id="password2" /></p> 
				</div>  
				<div class="col-md-12">             
					<button type="submit" name="btnregister" class="button" >Submit</button>
					<input type="hidden" name="submit" value="register" />
				</div>
				</div>
                </form>
 
            </div>
        </div>
    </div>
<?php get_footer() ?>