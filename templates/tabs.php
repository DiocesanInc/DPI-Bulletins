<?php

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit; ?>

<div id="bulletins-tabs" class="dpi_bulletin_wrapper">
    <?php if (!empty($bulletins)): 
		$nav = "<ul class='nav nav-tabs'>";
		$tabs = "<div class='tab-content'>";
		$count = 0;

		foreach($bulletins as $bulletin) { 
			$nav .= '<li' . ($count === 0 ? " class=\"active\"" : "") . '>
				<a href="#bulletin-' . date( "Y-m-d", strtotime($bulletin['date']) ) . '">
					<time class="dpi-bulletins-time" datetime="' . date( "Y-m-d", strtotime($bulletin['date']) ) . '">' . date( "F j, Y", strtotime($bulletin['date']) ) . '</time>
					<span class="dpi-bulletins-meta">' . ($count === 0 ? "Current" : "Archived") . ' Bulletin</span>
				</a>
			</li>';
			$tabs .= '<a href="#bulletin-' . date( "Y-m-d", strtotime($bulletin['date']) ) . '" class="tab_drawer_heading' . ($count === 0 ? " d_active" : "") . '">
					<time class="dpi-bulletins-time" datetime="' . date( "Y-m-d", strtotime($bulletin['date']) ) . '">' . date( "F j, Y", strtotime($bulletin['date']) ) . '</time>
					<span class="dpi-bulletins-meta">' . ($count === 0 ? "Current" : "Archived") . ' Bulletin</span>
				</a>
				<div id="bulletin-' . date( "Y-m-d", strtotime($bulletin['date']) ) . '" class="tab-pane fade in ' . ($count === 0 ? "active" : "") . '">
					<div class="dpi-bulletins-tab">
						<a class="dpi-bulletins-tab--link" href="' . $bulletin['links']['bulletin'] . '"' . ($bulletin['new_tab'] ? " target=\"_blank\"" : "") . '>
							<svg class="dpi-bulletins-svg-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M20 2H8c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-8.5 7.5c0 .83-.67 1.5-1.5 1.5H9v2H7.5V7H10c.83 0 1.5.67 1.5 1.5v1zm5 2c0 .83-.67 1.5-1.5 1.5h-2.5V7H15c.83 0 1.5.67 1.5 1.5v3zm4-3H19v1h1.5V11H19v2h-1.5V7h3v1.5zM9 9.5h1v-1H9v1zM4 6H2v14c0 1.1.9 2 2 2h14v-2H4V6zm10 5.5h1v-3h-1v3z"></path></svg>
							View Bulletin
						</a>
						<a class="dpi-bulletins-tab--link" href="https://discovermass.com" target="_blank">
							<svg class="dpi-bulletins-svg-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 271.22 271.22">&gt;<path d="M97.87 55.42l.18.36.45 1 37.1 78.82 36.92-78.43.19-.36c.15-.33.33-.66.48-1l.12-.33a40.6 40.6 0 1 0-78.38-15.31 42.91 42.91 0 0 0 3 15.26zm37.74-35.08a20.34 20.34 0 1 1-20.34 20.34 20.34 20.34 0 0 1 20.34-20.34zM231 94.92a42.92 42.92 0 0 0-15.26 3l-.36.18-1 .45-78.82 37.11L214 172.53l.36.18c.33.15.67.33 1 .48l.33.12A40.6 40.6 0 1 0 231 94.92zm-.52 61a20.34 20.34 0 1 1 20.34-20.34 20.34 20.34 0 0 1-20.29 20.37z"></path><path d="M173.35 215.79l-.18-.36-.45-1-37.11-78.82L98.69 214l-.18.37c-.15.33-.33.66-.48 1l-.12.33a40.6 40.6 0 1 0 78.38 15.3 43 43 0 0 0-3-15.26zm-37.74 35.09a20.34 20.34 0 1 1 20.34-20.34 20.34 20.34 0 0 1-20.34 20.34zM57.18 98.69l-.36-.19c-.33-.15-.66-.33-1-.49l-.33-.12a40.6 40.6 0 1 0-15.29 78.39 42.87 42.87 0 0 0 15.26-3l.36-.18 1-.45 78.82-37.11zm-16.5 57.26A20.34 20.34 0 1 1 61 135.61a20.34 20.34 0 0 1-20.32 20.34z"></path></svg>
							See More Bulletins on DiscoverMass
						</a>
					</div>
				<a class="dpi-bulletins-tab--link" href="' . $bulletin['links']['bulletin'] . '"' . ($bulletin['new_tab'] ? " target=\"_blank\"" : "") . '><img class="dpi-bulletins-tab--image" src="' . $bulletin['links']['cover'] . '" alt="Bulletin Cover"></a>

			</div>';
			 $count++;
		}
		
		echo $nav . '</ul>' . $tabs . '</div>';

	else: ?>
        <p class="dpi_bulletin_empty">Sorry, there aren't any bulletins to show you right now.</p>
    <?php endif; ?>
</div>