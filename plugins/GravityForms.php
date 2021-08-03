<?php
/**
 * Gravity Forms Plugin.
 *
 * @package Junaidbhura\Composer\WPProPlugins\Plugins
 */

namespace Junaidbhura\Composer\WPProPlugins\Plugins;

use Junaidbhura\Composer\WPProPlugins\Http;

/**
 * GravityForms class.
 */
class GravityForms {

	/**
	 * The version number of the plugin to download.
	 *
	 * @var string Version number.
	 */
	protected $version = '';

	/**
	 * The slug of which Gravity Forms plugin to download.
	 *
	 * @var string Plugin slug.
	 */
	protected $slug = '';

	/**
	 * GravityForms constructor.
	 *
	 * @param string $version
	 * @param string $slug
	 */
	public function __construct( $version = '', $slug = 'gravityforms' ) {
		$this->version = $version;
		$this->slug    = $slug;
	}

	/**
	 * Get the download URL for this plugin.
	 *
	 * @return string
	 */
	public function getDownloadUrl() {
		$http   = new Http();
		$url    = 'https://www.gravityhelp.com/wp-content/plugins/gravitymanager/api.php?op=get_plugin&slug=' . $this->slug . '&key=' . getenv( 'GRAVITY_FORMS_KEY' );
		$result = $http->post( $url );

		if (false === $result) {
			throw new Exception('Can\'t get correct download URL for ' . $url);
		}

		$body         = trim($result);
		$response     = unserialize( $body );
		$download_url = isset($response['download_url_latest']) ? $response['download_url_latest'] : '';

		if (empty($download_url)) {
				throw new Exception('Unable to find download URL. Check your Gravity Forms API key.');
		}
		return (string) $download_url;
	}

}
