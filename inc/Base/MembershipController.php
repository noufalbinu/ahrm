<?php 
/**
 * @package  ZonPackages
 */
namespace Inc\Base;

use Inc\Api\SettingsApi;
use Inc\Base\BaseController;
use Inc\Api\Callbacks\AdminCallbacks;

/**
* 
*/
class MembershipController extends BaseController
{
	public $callbacks;

	public $subpages = array();

	public function register()
	{
		if ( ! $this->activated( 'membership_manager' ) ) return;

		// add the employer_role
		add_action( 'init', array( $this, 'ahrm_manager_role' ) );
		add_action( 'admin_init', array( $this, 'ahrm_manager_role_caps'), 999 );
	}

	public function setSubpages()
	{
		$this->subpages = array(
			array(
				'parent_slug' => 'zon_packages', 
				'page_title' => 'Membership Manager', 
				'menu_title' => 'Membership Manager', 
				'capability' => 'manage_options', 
				'menu_slug' => 'zon_membership', 
				'callback' => array( $this->callbacks, 'adminMembership' )
			)
		);
	}


	public function ahrm_manager_role()
    {
        add_role('ahrm_manager_role','AHRM Manager',
            [
                // list of capabilities for this role
				'read' => true,
                'edit_posts' => false,
                'delete_posts' => true,
                'publish_posts' => true,
                'upload_files' => true,
            ]
        );
    }

	public function ahrm_manager_role_caps()
    {

		/* Get the roles you want to add capabilities for, e.g. */
		$roles = array( get_role('ahrm_manager_role'), get_role('administrator') );
		// Add the roles you'd like to administer the custom post types

		// Loop through each role and assign capabilities
		foreach($roles as $role) { 
			//remove_role('ahrm_manager_role');
			if($role) {
                $role->add_cap( 'read' );
		        $role->add_cap( 'read_jobs' );
		        $role->add_cap( 'read_private_jobs' );
                $role->add_cap( 'edit_jobs' );
			    $role->add_cap( 'publish_jobs', true );
			    $role->add_cap( 'delete_jobs', true );
		        $role->add_cap( 'edit_jobs' );
		        $role->add_cap( 'edit_others_jobs' );
		        $role->add_cap( 'edit_published_jobs' );
		        $role->add_cap( 'publish_jobs' );
		        $role->add_cap( 'delete_others_jobs' );
		        $role->add_cap( 'delete_private_jobs' );
		        $role->add_cap( 'delete_published_jobs' );
			}
		}
    }

}
