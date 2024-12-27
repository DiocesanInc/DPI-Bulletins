<?php if ( !defined( 'ABSPATH' ) ) exit; ?>

<div class="dpi_bulletin_cover_wrapper">
	<?php if (!empty($bulletin)): 
		$label = $args['title'] ? $args['title'] : date("F jS, Y", strtotime($bulletin['date'])); 
		if( get_locale() == 'es_ES' && !$args['title'] ) { 
			// Spanish
			setlocale(LC_ALL,"es_ES");
			$label = $Controller->translateDate( $bulletin['date'] );
		}?>
		<span class="dpi_bulletin_cover_date">
			<a href="<?= $bulletin['links']['bulletin'] ?>" target="_blank" rel="noopener">
				<?= $label ?>
			</a>
		</span>
		<br>
		<a href="<?= $bulletin['links']['bulletin'] ?>" target="_blank" rel="noopener">
			<img class='dpi_bulletin_cover' style="width: 100%; max-width: 447px; height: auto;" src="<?= $bulletin['links']['cover'] ?>" alt="Bulletin Cover" />
		</a>
	<?php else: ?>
		<p class="dpi_bulletin_empty">Sorry, there aren't any bulletins to show you right now.</p>
	<?php endif; ?>
</div>