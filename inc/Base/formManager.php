<?php 
/**
 * @package  ZonPackages
 */
namespace Inc\Base;
use Inc\Api\SettingsApi;
use Inc\Base\BaseController;
use Inc\Api\Callbacks\TestimonialCallbacks;
/**
* 
*/
class formManager extends BaseController
{
	public $settings;
	public $callbacks;

	public function register()
	{
		if ( ! $this->activated( 'form_manager' ) ) return;
		$this->settings = new SettingsApi();
		$this->callbacks = new TestimonialCallbacks();

		
		//form shortcodes
		//add_shortcode( 'application-form', array( $this, 'application_form' ) );
		//add_shortcode( 'contact-form', array( $this, 'contact_form' ) );

		//add_action( 'wp_ajax_submit_testimonial', array( $this, 'submit_form' ) );
		//add_action( 'wp_ajax_nopriv_submit_testimonial', array( $this, 'submit_testimonial' ) );

		//add_action( 'wp_ajax_update_testimonial', array( $this, 'update_testimonial' ) );
		//add_action( 'wp_ajax_nopriv_update_testimonial', array( $this, 'update_testimonial' ) );

	}
	


}

