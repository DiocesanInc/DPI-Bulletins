<?php if ( !defined( 'ABSPATH' ) ) exit; ?>

<div class="dpi_bulletin_wrapper">
    <?php if (!empty($bulletins)): ?>
        <?php foreach($bulletins as $bulletin) { ?>
            <?php if ($args['cover_count'] > 0): ?>
                <div class='dpi_bulletin_cover_wrapper'>
                    <span class='dpi_bulletin_cover_date'><?= date("F jS, Y", strtotime($bulletin['date'])) ?></span>
                    <br>
                    <a href="<?= $bulletin['links']['bulletin'] ?>" target="_blank" rel="noopener">
                        <img class='dpi_bulletin_cover' src="<?= $bulletin['links']['cover'] ?>" alt="Bulletin Cover" />
                    </a>
                </div>
                <?php $args['cover_count']-- ?>
            <?php else: ?>
				<?php 
					$label = $args['title'] ? $args['title'] : date("F j, Y", strtotime($bulletin['date'])); 
					if( get_locale() == 'es_ES' && !$args['title'] ) { 
						$label = $Controller->translateDate( $bulletin['date'] );
					}
				?>
                <div class="dpi_bulletin">
                    <a href="<?= $bulletin['links']['bulletin'] ?>" <?= $bulletin['new_tab'] ? " target='_blank'" : "" ?> rel="noopener">
                        <?= $label ?>
                    </a>
                </div>
            <?php endif; ?>
        <?php } ?>
    <?php else: ?>
        <p class="dpi_bulletin_empty">Sorry, there aren't any bulletins to show you right now.</p>
    <?php endif; ?>
	
	<?php if( $args['show_signup'] ) {
			if (!empty($signup)): ?>
			<h2>Email Notification</h2>
			<p>Stay up to date with what is happening at <?php echo get_bloginfo(); ?>. Each week we will send you an email update with a link to the current week's bulletin.</p>
			<button id="bulletins-signup" class="signup-btn">Sign Up Today</a></button>
			<span class="dpi_signup_button">
				<div id="dialog-bulletin">
					<h4>Email Notification Signup</h4>					
					<iframe src="<?php echo $signup['signupUrl']; ?>" width="100%" height="420px" style="border: none; max-width: 400px;"></iframe>
				</div>
			</span>
		<?php else: ?>
			<p class="dpi_signup_empty">Sorry, signup isn't available for <?php echo get_bloginfo(); ?>.</p>
		<?php endif;
		}
		?>
</div>

