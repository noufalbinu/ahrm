<?php 
/**
 * @package  ZonPackages
 */
namespace Inc\Base;


use Inc\Base\BaseController;


/**
* 
*/

class AuthController extends BaseController 
{

	public function register()
	{
		if(! $this->activated('login_manager') ) return;
		add_action('wp_enqueue_scripts', array( $this, 'enqueue') );
		add_action('wp_head', array( $this, 'add_auth_template') );
		add_action('wp_ajax_nopriv_zon_login', array( $this, 'login') );
	
	}

	public function enqueue()
	{
		if( is_user_logged_in() ) return;

		wp_enqueue_style('authStyle', $this->plugin_url . './assets/auth.css' );
		wp_enqueue_style('authScript', $this->plugin_url . './assets/auth.js' );
	}

	public function add_auth_template() 
	
	{
		if( is_user_logged_in() ) return;

		$file = $this->plugin_path . 'templates/auth.php';

		if ( file_exists($file) ) {
			load_template($file, true);
		}
	}
	public function login()
	{
		check_ajax_referer( 'ajax-login-nonce', 'zon_auth' );

		$info = array();
		$info['user_login'] = $_POST['username'];
		$info['user_password'] = $_POST['password'];
		$info['remember'] = true;	
		$user_signon = wp_signon( $info, true);


		if(is_wp_error($user_signon)) 	
		{
			echo json_encode( 
				array(
					'status' => false,
					'message' => 'Wrong Username or password.'
					)
				);
				die();
		}

		echo json_encode( 
			array(
				'status' => true,
				'message' => 'Wrong Username or password.'
				)
			);
			die();
	}
}
