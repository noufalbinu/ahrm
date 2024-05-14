
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
class CheckoutController extends BaseController
{
	public $settings;

	public $callbacks;

	public function register()
	{
		if ( ! $this->activated( 'testimonial_manager' ) ) return;

		$this->settings = new SettingsApi();

		$this->callbacks = new TestimonialCallbacks();




		add_shortcode('test',  array( $this, 'wp_first_shortcode') );
	}

	public function wp_first_shortcode(){
		echo "Hello, This is your another shortcode!";
	}


}