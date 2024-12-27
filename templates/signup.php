<?php if ( !defined( 'ABSPATH' ) ) exit; ?>

<div class="dpi_bulletin_signup_wrapper">
	<?php if (!empty($signup)): ?>
		<button id="bulletins-signup" class="signup-btn">Sign Up Today</a></button>
		<span class="dpi_signup_button">
			<div id="dialog-bulletin">
				<h4>Email Notification Signup</h4>					
				<iframe src="<?php echo $signup['signupUrl']; ?>" width="100%" height="420px" style="border: none; max-width: 400px;"></iframe>
			</div>
		</span>
	<?php else: ?>
		<p class="dpi_signup_empty">Sorry, signup isn't available for this church.</p>
	<?php endif; ?>
</div>