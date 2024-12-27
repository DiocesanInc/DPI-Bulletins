<?php

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit; ?>

<div class="dpi_bulletin_wrapper">
    <?php if (!empty($bulletins)): 
		$count = 0;
		$accordion = '<ul id="dpi-bulletins-accordion">';
             
		foreach( $bulletins as $bulletin ) {
		  $accordion .= '
			<li ' . ($count == 0 ? "class=\"open\"" : "") . '>
			  <span>' . date( "F jS, Y", strtotime($bulletin['date']) ) . '</span>
			  <div>
				  <a
					class="text-link"
					href="' . $bulletin['links']['bulletin'] . '" ' . ($bulletin['new_tab'] ? "target=\"_blank\"" : "") . '>
					  View Bulletin
				  <a/>
				  <a
					href="' . $bulletin['links']['bulletin'] . '" ' . ($bulletin['new_tab'] ? "target=\"_blank\"" : "") . '>
					  <img src="' . $bulletin['links']['cover'] . '" alt="bulletin cover" />
				  </a>
			  </div>
			</li>
		  ';
		  $count++;
		}

		$accordion .= '</ul>';

        echo $accordion;
		
	else: ?>
        <p class="dpi_bulletin_empty">Sorry, there aren't any bulletins to show you right now.</p>
    <?php endif; ?>
</div>