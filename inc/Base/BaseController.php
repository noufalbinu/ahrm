<?php 
/**
 * @package  ZonPackages
 */
namespace Inc\Base;
class BaseController
{
	public $plugin_path;
	public $plugin_url;
	public $plugin;
	public $managers = array();
	public function __construct() {
		$this->plugin_path = plugin_dir_path( dirname( __FILE__, 2 ) );
		$this->plugin_url = plugin_dir_url( dirname( __FILE__, 2 ) );
		$this->plugin = plugin_basename( dirname( __FILE__, 3 ) ) . '/zon_packages.php';
		$this->managers = array(
			'testimonial_manager' => 'Activate Zon Package Manager',
			'form_manager' => 'Activate form Manager',
			'Jobs' => 'Activate Jobs Manager',			
			'fixed_packages' => 'Activate Fixed Package Departure',
			'taxonomy_manager' => 'Activate Taxonomy Manager',
			'media_widget' => 'Activate Media Widget',
			'gallery_manager' => 'Activate Gallery Manager',			
			'templates_manager' => 'Activate Templates Manager',
			'login_manager' => 'Activate Ajax Login/Signup',
			'membership_manager' => 'Activate Membership Manager',
			'payment_manager' => 'Activate Payment Manager',
			'chat_manager' => 'Activate Chat Manager',
			'cpt_manager' => 'Activate CPT Manager',
		);
	}
	public function activated( string $key )
	{
		$option = get_option( 'zon_packages' );
		return isset( $option[ $key ] ) ? $option[ $key ] : false;
	}
}