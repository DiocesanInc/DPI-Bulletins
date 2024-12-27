<?php if ( !defined( 'ABSPATH' ) ) exit; ?>

<aside id="bulletins-widget" class="widget widget-text wp_widget_plugin_box">
	<?php if (!empty($instance['title'])): ?>
		<h3 class="widget-title"><?= apply_filters('widget_title', $instance['title']) ?></h4>
	<?php endif; ?>
	<?php if (!empty($instance['text'])): ?>
		<p class="wp_widget_plugin_text"><?= $instance['text'] ?></p>
	<?php endif; ?>
	<?php if (!empty($bulletins)): ?>
		<?php foreach($bulletins as $bulletin) { ?>
			<a href="<?= $bulletin['links']['bulletin'] ?>" class="dpi_bulletin_widget_link" <?= $bulletin['new_tab'] ? " target='_blank'" : "" ?> rel="noopener">
				<?= ( get_locale() == 'es_ES' ) ? $Controller->translateDate( $bulletin['date'] ) : date("F j, Y", strtotime($bulletin['date'])); ?>
			</a>
			<br>
		<?php } ?>
	<?php else: ?>
		<p class="dpi_bulletin_empty">Sorry, there aren't any bulletins to show you right now.</p>
	<?php endif; ?>
</aside>