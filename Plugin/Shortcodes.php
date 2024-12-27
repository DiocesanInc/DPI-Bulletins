<?php namespace Bulletins\Plugin;

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

class Shortcodes {

	private $bulletinsShortcode = 'bulletins';
	private $coverShortcode = 'bulletin_cover';
	private $signupShortcode = 'bulletin_signup';

	/**
	* Init, run wp hooks
	*/
	public function __construct() {
		add_shortcode($this->bulletinsShortcode, [$this, 'shortcodeHandler']);
		add_shortcode($this->coverShortcode, [$this, 'shortcodeHandler']);
		add_shortcode($this->signupShortcode, [$this, 'shortcodeHandler']);
	}

	/**
	* Sanitize shortcode parameters
	*/
	private function sanitizeParams(array $params) {
		return array_map(function($dirty) {
			switch(gettype($dirty)) {
				case 'boolean':
					return filter_var($dirty, FILTER_VALIDATE_BOOLEAN);
				case 'integer':
					return round(filter_var($dirty, FILTER_SANITIZE_NUMBER_FLOAT));
				default:
					return sanitize_text_field($dirty);
			}
		}, $params);
	}

	/**
	* Shortcode callback handler
	*/
	public function shortcodeHandler($params, $content, $shortcode) {
		$Controller = Controller::getInstance();

		$args = ($this->sanitizeParams(shortcode_atts([
			'id' => $Controller->getBulletinID(),
			'quantity' => $Controller->getBulletinQuantity(),
			'title' => false,
			'format' => false,
			'cover_count' => 0,
			'open_in_new_tab' => $Controller->getBulletinNewTab(),
			'show_signup' => $Controller->getBulletinShowSignup(),
			'offset' => 0
		], $params)));

		if (!$args['id']) {
			return false;
		}

		switch($shortcode) {
			case $this->bulletinsShortcode:
				$bulletins = $Controller->Transport->getBulletins( $args['id'], $args['quantity'], $args['open_in_new_tab'], $args['offset'] );
				if($args['format'] == "Accordion") {
					wp_enqueue_style( 'dpi-bulletins-accordion-css', plugins_url( '../css/accordion.css', __FILE__ ), null, '1.0.0', 'all' );
					wp_enqueue_script( 'dpi-bulletins-accordion-js', plugins_url( '../js/accordion.js', __FILE__ ), null, '1.0.0', true );
					ob_start();
					if( get_locale() == 'es_ES' ) { 
						include DPI_BULLETINS_DIR . '/templates/accordion-es.php';
					} else {
						include DPI_BULLETINS_DIR . '/templates/accordion.php';
					}
					return ob_get_clean();
				} if($args['format'] == "Tabs") {
					wp_enqueue_style( 'boostrap-css', plugins_url( '../css/bootstrap.css', __FILE__ ), null, '1.0.0', 'all' );
					wp_enqueue_style( 'dpi-bulletins-tabs-css', plugins_url( '../css/tabs.css', __FILE__ ), null, '1.0.0', 'all' );
					wp_enqueue_script( 'bootstrap-js', plugins_url( '../js/bootstrap.js', __FILE__ ), null, '1.0.0', 'all' );
					wp_enqueue_script( 'dpi-bulletins-tabs-js', plugins_url( '../js/tabs.js', __FILE__ ), 'jquery', '1.0.0', true );
					ob_start();
					if( get_locale() == 'es_ES' ) { 
						include DPI_BULLETINS_DIR . '/templates/tabs-es.php';
					} else {
						include DPI_BULLETINS_DIR . '/templates/tabs.php';
					}
					return ob_get_clean();
				} if($args['format'] != "" && $args['format'] != "Tabs" && $args['format'] != "Accordion") {
					$custom = strtolower( $args['format'] );
					$custom_styles = get_stylesheet_directory_uri() . '/dpi-bulletins/' . $custom . '.css';
					$custom_script = get_stylesheet_directory_uri() . '/dpi-bulletins/' . $custom . '.js';
					if( file_exists( get_stylesheet_directory() . '/dpi-bulletins/' . $custom . '.css' ) ) {
						wp_enqueue_style( $custom . '-bulletins', $custom_styles, null, '1.0.0', 'all' );
					}
					if( file_exists( get_stylesheet_directory() . '/dpi-bulletins/' . $custom . '.js' ) ) {
						wp_enqueue_script( $custom . '-bulletins', $custom_script, null, '1.0.0', 'all' );
					}
					ob_start();
					if( get_locale() == 'es_ES' ) { 
						if( file_exists( get_stylesheet_directory() . '/dpi-bulletins/' . $custom . '-es.php' ) ) {
							include get_stylesheet_directory() . '/dpi-bulletins/' . $custom . '-es.php';
						} else {
							echo "<p class='dpi_bulletin_error'>Error: Missing '" . $custom . "-es.php' file in your theme folder/dpi-bulletins/</p>";
						}
					} else {
						if( file_exists( get_stylesheet_directory() . '/dpi-bulletins/' . $custom . '.php' ) ) {
							include get_stylesheet_directory() . '/dpi-bulletins/' . $custom . '.php';
						} else {
							echo "<p class='dpi_bulletin_error'>Error: Missing '" . $custom . ".php' file in your theme folder/dpi-bulletins/</p>";
						}
					}
					return ob_get_clean();
				} else {
					if( $args['show_signup'] ) {
						wp_enqueue_style( 'jquery-ui-css', 'https://code.jquery.com/ui/1.14.0/themes/base/jquery-ui.css', null, '1.14.0', 'all' );
						wp_enqueue_script( 'jquery-ui','https://code.jquery.com/ui/1.14.0/jquery-ui.js', 'jquery', '1.14.0', true );
						wp_enqueue_style( 'dialog-css', plugins_url( '../css/dialog.css', __FILE__ ), null, '1.0.0', 'all' );
						wp_enqueue_script( 'dpi-bulletins-dialog-js', plugins_url( '../js/dialog.js', __FILE__ ), 'jquery', '1.0.0', true );
						$signup = $Controller->Transport->getSignup($args['id']);
					}
					ob_start();
					include DPI_BULLETINS_DIR . '/templates/default.php';
					return ob_get_clean();
				}
				
			case $this->coverShortcode:
				$cover_count = isset( $args['quantity'] ) ? $args['quantity'] : 1;
				$bulletins = $Controller->Transport->getBulletins($args['id'], $cover_count, $args['open_in_new_tab'], $args['offset']);
				$bulletin = is_array($bulletins) ? array_shift($bulletins) : '';
				ob_start();
				include DPI_BULLETINS_DIR . '/templates/covers.php';
				return ob_get_clean();
				
			case $this->signupShortcode:
				wp_enqueue_style( 'jquery-ui-css', 'https://code.jquery.com/ui/1.14.0/themes/base/jquery-ui.css', null, '1.14.0', 'all' );
				wp_enqueue_script( 'jquery-ui','https://code.jquery.com/ui/1.14.0/jquery-ui.js', 'jquery', '1.14.0', true );
				wp_enqueue_style( 'dialog-css', plugins_url( '../css/dialog.css', __FILE__ ), null, '1.0.0', 'all' );
				wp_enqueue_script( 'dpi-bulletins-dialog-js', plugins_url( '../js/dialog.js', __FILE__ ), 'jquery', '1.0.0', true );
				$args = ($this->sanitizeParams(shortcode_atts([
					'id' => $Controller->getBulletinID(),
				], $params)));
				$signup = $Controller->Transport->getSignup($args['id']);
				ob_start();
				include DPI_BULLETINS_DIR . '/templates/signup.php';
				return ob_get_clean();
		}
	}
}