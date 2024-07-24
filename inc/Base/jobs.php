<?php 
/**
 * @package  ZonPackages
 */
namespace Inc\Base;
use Inc\Api\SettingsApi;
use Inc\Base\BaseController;

/**
* 
*/
class Jobs extends BaseController {

	public function register()
	{
		if ( ! $this->activated( 'Jobs' ) ) return;
		add_action( 'init', array( $this, 'custom_post_job' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'zon_styles' ) );
		add_filter( 'single_template', array( $this, 'load_pack_template' ) );
		add_action( 'add_meta_boxes', array( $this, 'zon_fixed_boxess' ) );
		add_action( 'save_post', array( $this,'zon_save_meta_boxx' ) );
        
		add_action( 'init', array( $this,'add_something' ) );

		// filter option for job application from candidates
		add_filter('parse_query', array( $this, 'tsm_convert_id_to_term_in_query_cv') );
		add_action( 'init', array( $this,  'job_taxonomy_cv') );
	    add_action('restrict_manage_posts', array( $this,  'tsm_filter_post_type_by_taxonomy_cv') );
	}
	public function add_something() {
	    global $wpdb;  
        $table = $wpdb->prefix.'vaniom_hr_candidates';
		$data = array(
            'name' => 'noufal',
            'email' => 'noufal@wpadroit.com',
        );
        $wpdb->insert($table, $data);
    }

	public function zon_styles( $page ) {
		echo "<link rel=\"stylesheet\" href=\"$this->plugin_url/assets/packageoptionn.css\" type=\"text/css\" media=\"all\" />";
	}

    public function load_pack_template($template) {
    global $post;
    	if ($post->post_type == "fixedpackages" && $template !== locate_template(array("fixedpackges.php"))){
    		return ("$this->plugin_path/templates/accommodation.php");
    	} 

    return $template;
    }

	
	public function custom_post_job() 
	{
		$labels = array(
			'name' => ( 'Add/Edit Jobs' ),
			'singular_name'         => _x( 'Add/Edit Jobs', 'Post Type Singular Name', 'text_domain' ),
			'menu_name'             => __( 'Add/Edit Jobs', 'text_domain' ),
			'name_admin_bar'        => __( 'Post Type', 'text_domain' ),
			'archives'              => __( 'Item Archives', 'text_domain' ),
			'attributes'            => __( 'Item Attributes', 'text_domain' ),
			'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
			'all_items'             => __( 'All Items', 'text_domain' ),
			'add_new_item'          => __( 'Add New Item', 'text_domain' ),
			'add_new'               => __( 'Add New', 'text_domain' ),
			'new_item'              => __( 'New Item', 'text_domain' ),
			'edit_item'             => __( 'Edit Item', 'text_domain' ),
			'update_item'           => __( 'Update Item', 'text_domain' ),
			'view_item'             => __( 'View Item', 'text_domain' ),
			'view_items'            => __( 'View Items', 'text_domain' ),
			'search_items'          => __( 'Search Item', 'text_domain' ),
			'not_found'             => __( 'Not found', 'text_domain' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
			'featured_image'        => __( 'Featured Image', 'text_domain' ),
			'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
			'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
			'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
			'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
			'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
			'items_list'            => __( 'Items list', 'text_domain' ),
			'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
			'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
		);
		$args = array(
			'label'                 => __( 'Post Type', 'text_domain' ),
			'description'           => __( 'Post Type Description', 'text_domain' ),
			'labels'                => $labels,
			'supports'              => array('title','editor', 'author', 'thumbnail'),
			'taxonomies'            => [ 'job-category','job-type','job-location' ],
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 0,
			'menu_icon'             => 'dashicons-id-alt',
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => 'jobs',
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'capability_type'     => array('job','jobs', 'page'),
			'map_meta_cap'        => true,
			'show_in_rest'          => true,
		);
		register_post_type( 'jobs', $args );
	}
	

	
	// https://stackoverflow.com/questions/72428718/wordpress-upload-post-and-attach-file-wp-insert-post-and-wp-insert-attachment
	// filter option for job application from candidates
	public function tsm_filter_post_type_by_taxonomy_cv() {
		global $typenow;
		$post_type = 'jobs' ; // change to your post type
		$taxonomy  = 'job-type'; // change to your taxonomy
		if ($typenow == $post_type) {
			$selected      = isset($_GET[$taxonomy]) ? $_GET[$taxonomy] : '';
			$info_taxonomy = get_taxonomy($taxonomy);
			wp_dropdown_categories(array(
				'show_option_all' => sprintf( __( 'Show all %s', 'textdomain' ), $info_taxonomy->label ),
				'taxonomy'        => $taxonomy,
				'name'            => $taxonomy,
				'orderby'         => 'name',
				'selected'        => $selected,
				'show_count'      => true,
				'hide_empty'      => true,
			));
		};
	}
	public function tsm_convert_id_to_term_in_query_cv($query) {
		global $pagenow;
		$post_type = 'jobs'; // change to your post type
		$taxonomy  = 'job-type'; // change to your taxonomy
		$q_vars    = &$query->query_vars;
		if ( $pagenow == 'edit.php' && isset($q_vars['post_type']) && $q_vars['post_type'] == $post_type && isset($q_vars[$taxonomy]) && is_numeric($q_vars[$taxonomy]) && $q_vars[$taxonomy] != 0 ) {
			$term = get_term_by('id', $q_vars[$taxonomy], $taxonomy);
			$q_vars[$taxonomy] = $term->slug;
		}
	}
	public function job_taxonomy_cv() {
		register_taxonomy(
			'job-category',  // The name of the taxonomy. Name should be in slug form (must not contain capital letters or spaces).
			'jobs',             // post type name
			array(
				'hierarchical' => true,
				'label' => 'Job Category', // display name
				'show_in_rest' => true, //add this
				'show_ui' => true,
				'show_admin_column' => true,
				'query_var' => true,
				'capabilities' => array(
                    'manage_terms' => 'manage_job-category',
                    'edit_terms'   => 'edit_job-category',
                    'delete_terms' => 'delete_job-category',
                    'assign_terms' => 'assign_job-category',
                ),
				'rewrite' => array(
					'slug' => 'job-category',    // This controls the base slug that will display before each term
					'with_front' => false  // Don't display the category base before
				)
			)
		);
		register_taxonomy(
			'job-type',  // The name of the taxonomy. Name should be in slug form (must not contain capital letters or spaces).
			'jobs',             // post type name
			array(
				'hierarchical' => true,
				'label' => 'Job Type', // display name
				'show_in_rest' => true, //add this
				'show_ui' => true,
				'show_admin_column' => true,
				'query_var' => true,
				'capabilities' => array(
                    'manage_terms' => 'manage_job-location',
                    'edit_terms'   => 'edit_job-location',
                    'delete_terms' => 'delete_job-location',
                    'assign_terms' => 'assign_job-location',
                ),
				'rewrite' => array(
					'slug' => 'job-type',    // This controls the base slug that will display before each term
					'with_front' => false  // Don't display the category base before
				)
			)
		);
		register_taxonomy(
			'job-location',  // The name of the taxonomy. Name should be in slug form (must not contain capital letters or spaces).
			'jobs',             // post type name
			array(
				'hierarchical' => true,
				'label' => 'Job Location', // display name
				'show_in_rest' => true, //add this
				'show_ui' => true,
				'show_admin_column' => true,
				'query_var' => true,
				'capabilities' => array(
                    'manage_terms' => 'manage_job-location',
                    'edit_terms'   => 'edit_job-location',
                    'delete_terms' => 'delete_job-location',
                    'assign_terms' => 'assign_job-location',
                ),
				'rewrite' => array(
					'slug' => 'job-location',    // This controls the base slug that will display before each term
					'with_front' => false  // Don't display the category base before
				)
			)
		);
		
		
	}
	// filter option for job application from candidates
public function zon_fixed_boxess() {
	global $post;
    if ( 'page' == $post->post_type && 0 != count( get_page_templates( $post ) ) && get_option( 'page_for_posts' ) != $post->ID ) {
         if( $my_conditions )
             $post->page_template = "page-mytemplate.php";
    }
	add_meta_box(
		'fixed_box',                       // Unique ID
		'Job Details',                             // Box title
		 array( $this, 'zon_featuress_boxx' ),      // Content callback, must be of type callable
		'jobs',                              // 
		'normal',
		'high'
	);

}






public function zon_save_meta_boxx( $post_id ) {

	
	if (! isset($_POST['zonpackk_testimonial_nonce'])) {
			return $post_id;
		}

		$nonce = $_POST['zonpackk_testimonial_nonce'];
		if (! wp_verify_nonce( $nonce, 'zonpackk_testimonial' )) {
			return $post_id;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}

		if (! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}

		if (isset($_POST['dataoption'])) {
			$zonoption = $_POST['dataoption'];
			$_SESSION['dataoption'] = $zonoption ;
		} else {
			$zonoption  = $_SESSION['dataoption'];
		}




		$data = array(
			'p1' => $_POST['pack1']
		);
		update_post_meta( $post_id, '_zonpackk_testimonial_key', $data );
		}

}


