<?php namespace Bulletins\Plugin;

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

class Transport {

	private $domain = 'https://bulletins.discovermass.com';

	/**
	* Get bulletin & cover links from DiscoverMass, format into an array
	*/
	private function buildLinks($id, $date) {
		$timestamp = time();
		$ssl_key = pack( "H*", "77b9a997085e0a9692f16b94107ea0a9adc2d22203737a335051b806d1bd4166" );
		$ssl_cipher = "AES-128-CBC";
		$ssl_iv_size = openssl_cipher_iv_length( $ssl_cipher );
		$ssl_iv = openssl_random_pseudo_bytes( $ssl_iv_size );
		$ssl_plaintext = "{$id}|{$date}|{$timestamp}|{$id}";
		$ssl_ciphertext_raw = openssl_encrypt( $ssl_plaintext, $ssl_cipher, $ssl_key, OPENSSL_RAW_DATA, $ssl_iv );
		$ssl_hmac = hash_hmac( "sha256", $ssl_ciphertext_raw, $ssl_key, true );
		$ssl_ciphertext = rawurlencode( base64_encode( $ssl_iv . $ssl_hmac . $ssl_ciphertext_raw ) );

		return [
			'bulletin' => $this->domain . '/download.php?bulletin=' . $ssl_ciphertext,
			'cover' => $this->domain . '/image.php?bulletin=' . $ssl_ciphertext
		];
	}

	/**
	* Retrieve bulletin dates and links, format into an array
	*/
	public function getBulletins( $id, $quantity = 4, $newtab = false, $offset = 0 ) {
		if (!$id) {
			return trigger_error('A valid ID must be passed to ' . __METHOD__ . ' in ' . __CLASS__ . '!', E_USER_ERROR);
		}
		
		$quantity = $quantity > 12 ? 12 : $quantity;
		$quantity = $quantity + $offset;
		
		$offset = ((is_int($offset) || ctype_digit($offset)) && (int)$offset > 0 ) ? $offset : 0;
		
		$res = wp_remote_get($this->domain . '/list.php?folder=' . $id . '&quantity=' . $quantity);

		if (!is_wp_error($res)) {
			$dates = array_flip(json_decode($res['body'], true));

			$bulletins = array_map(function($date) use($id, $newtab) {

				return [
					'date' => $date,
					'links' => $this->buildLinks($id, $date),
					'new_tab' => $newtab
				];

			}, $dates);
			
			for( $i = 0; $i < $offset; $i++ ) {
				array_shift( $bulletins );
			}
			
			return $bulletins;
		}

		return false;
	}
	
	/**
	* Retrieve signup URL based on Bulletin ID
	*/
	public function getSignup( $id ) {
		if (!$id) {
			return trigger_error('A valid ID must be passed to ' . __METHOD__ . ' in ' . __CLASS__ . '!', E_USER_ERROR);
		}
		
		$res = wp_remote_get($this->domain . '/signup.php?folder=' . $id);

		if (!is_wp_error($res)) {
			return json_decode($res['body'], true);
		}

		return false;
	}
}