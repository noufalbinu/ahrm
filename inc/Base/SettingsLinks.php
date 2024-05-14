<?php
/**
 * @package ZonPackages
 *
 */

namespace Inc\Base;

use \Inc\Base\BaseController;

class SettingsLinks extends BaseController
{
	public function register() 
	{
		add_filter( "plugin_action_links_$this->plugin", array( $this, 'settings_link' ) );
	}

	public function settings_link( $links ) 
	{
		$settings_link = '<a href="admin.php?page=ahrm_packages"> Settings</a>';
		array_push( $links, $settings_link );
		print_r($links);
		return $links;
	}
}