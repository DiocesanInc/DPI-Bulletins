<?php if ( !defined( 'ABSPATH' ) ) exit; ?>

<div class="dpi_bulletin_wrapper bulletin_bookshelf">
	<?php if (!empty($bulletins)): ?>
		<?php foreach($bulletins as $bulletin) { ?>
			<?php 
				$label = $args['title'] ? $args['title'] : date("F j, Y", strtotime($bulletin['date'])); 
				if( get_locale() == 'es_ES' && !$args['title'] ) { 
					$label = $Controller->translateDate( $bulletin['date'] );
				}
			?>
			<a href="<?= $bulletin['links']['bulletin'] ?>" <?= $bulletin['new_tab'] ? " target='_blank'" : "" ?> rel="noopener">
				<div class='dpi_bulletin_shelf'>
					<img class='dpi_bulletin_cover' src="<?= $bulletin['links']['cover'] ?>" alt="Bulletin Cover" />
					<?= $label ?>
				</div>
			</a>
		<?php } ?>
	<?php else: ?>
		<p class="dpi_bulletin_empty">Sorry, there aren't any bulletins to show you right now.</p>
	<?php endif; ?>
</div>