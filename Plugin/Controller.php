<?php namespace Bulletins\Plugin;

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

// singleton!
class Controller {

    // singleton instance
    private static $instance = false;

    // global plugin objects
    public $Transport;

    // options config, make these global so other objects can refer to them  
    protected $idOptionName = 'dpi_bulletin_id';
    protected $quantityOptionName = 'dpi_bulletin_quantity';
	protected $newTabOptionName = 'dpi_bulletin_new_tab';
	protected $showSignupOptionName = 'dpi_bulletin_show_signup';

    /**
    * Get or create controller instance
    */
    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Controller();
        }

        return self::$instance;
    }

    /**
    * Check for updates, alert wp if there are any
    */
    public function checkForUpdates() {
        //return false;
		require DPI_BULLETINS_DIR . '/plugin-updates/plugin-update-checker.php';
		$myUpdateChecker = \Puc_v4_Factory::buildUpdateChecker(
			'http://help.diocesanweb.com/plugins/bulletins.json',
			DPI_BULLETINS_DIR . '/dpi-bulletins.php',
			'dpi-bulletins'
		);
    }

    /**
    * Load up necessary plugin objects based on the current view
    */
    public function init() {
        // widget needs to be loaded on both admin and frontend
        add_action('widgets_init', function() {
            return register_widget(__NAMESPACE__ . '\\Widget');
        });

        if (is_admin()) {
            new PluginPage([
                'pageTitle' => 'Diocesan Bulletins - Options',
                'menuTitle' => 'Diocesan Bulletins',
                'capability' => 'manage_options'
            ]);
        } else {
            $this->Transport = new Transport();
            new Shortcodes();
        }
    }

    /**
    * Attempt to retrieve user input bulletin id from options table, otherwise return false
    */
    public function getBulletinID() {
        $id = get_option($this->idOptionName, false);

        if (!$id) {
            return false;
        }

        return $id;
    }

	/**
	* Attempt to retrieve user input quantity from options table, otherwise return 4
	*/
	public function getBulletinQuantity() {
		$quantity = get_option($this->quantityOptionName, false);

		if (!$quantity) {
			return 4;
		}

		return $quantity;
	}

	/**
	* Attempt to retrieve user defined new tab setting from options table, otherwise return false
	*/
	public function getBulletinNewTab() {
		$newtab = checked(1, get_option($this->newTabOptionName, false), false );

		if (!$newtab) {
			return false;
		}

		return true;
	}
	
	/**
	* Attempt to retrieve user defined show signup setting from options table, otherwise return false
	*/
	public function getBulletinShowSignup() {
		$showSignup = checked(1, get_option($this->showSignupOptionName, false), false );

		if (!$showSignup) {
			return false;
		}

		return true;
	}
	
	/**
	* Retrieve bulletin dates and links, format into an array
	*/
	public function translateDate( $date ) {
		if (!$date) {
			return trigger_error('A valid date must be passed to ' . __METHOD__ . ' in ' . __CLASS__ . '!', E_USER_ERROR);
		}
		
		setlocale(LC_ALL,"es_ES");

		return strftime("%e de %B del %Y", strtotime($date));;
	}
	
}