<?php
/**
 * @package ZonPackages
 *
 */


namespace Inc\Base;
class Activate
{
	public static function activate() {
		flush_rewrite_rules();
		$default = array();
		if ( ! get_option( 'zon_packages' ) ) {
			update_option( 'zon_packages', $default );
		}
		if ( ! get_option( 'zon_packages_cpt' ) ) {
			update_option( 'zon_packages_cpt', $default );
		}
		if ( ! get_option( 'zon_packages_tax' ) ) {
			update_option( 'zon_packages_tax', $default );
		}
	}
}