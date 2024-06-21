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

		// filter option for job application from candidates
		add_filter('parse_query', array( $this, 'tsm_convert_id_to_term_in_query_cv') );
		add_action( 'init', array( $this,  'job_taxonomy_cv') );
	    add_action('restrict_manage_posts', array( $this,  'tsm_filter_post_type_by_taxonomy_cv') );
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
			'taxonomies'            => [ 'job-type','jobtype','category', 'fixedpackages' ],
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
			'job-type',  // The name of the taxonomy. Name should be in slug form (must not contain capital letters or spaces).
			'jobs',             // post type name
			array(
				'hierarchical' => true,
				'label' => 'Job Type', // display name
				'show_in_rest' => true, //add this
				'show_ui' => true,
				'show_admin_column' => true,
				'query_var' => true,
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


public function zon_featuress_boxx( $post ) {
	wp_nonce_field( 'zonpackk_testimonial', 'zonpackk_testimonial_nonce' );

		$data = get_post_meta( $post->ID, '_zonpackk_testimonial_key', true );

		$p1 = isset($data['p1']) ? $data['p1'] : '';
		$p2 = isset($data['p2']) ? $data['p2'] : '';
		$p3 = isset($data['p3']) ? $data['p3'] : '';
		$p4 = isset($data['p4']) ? $data['p4'] : '';
		$p5 = isset($data['p5']) ? $data['p5'] : '';
		$p6 = isset($data['p6']) ? $data['p6'] : '';
		$p7 = isset($data['p7']) ? $data['p7'] : '';
		$p8 = isset($data['p8']) ? $data['p8'] : '';
		$p9 = isset($data['p9']) ? $data['p9'] : ''; 

		$ticketcount = isset($data['ticketcount']) ? $data['ticketcount'] : '';
		$fixeddeparture = isset($data['fixeddeparture']) ? $data['fixeddeparture'] : '';
		$picture1 = isset($data['picture1']) ? $data['picture1'] : '';
		$picture2 = isset($data['picture2']) ? $data['picture2'] : '';
		$picture3  = isset($data['picture3']) ? $data['picture3'] : '';

		$packagecode = isset($data['packagecode']) ? $data['packagecode'] : '';


		//package Header
		$budget = isset($data['budget']) ? $data['budget'] : '';
		$economy = isset($data['economy']) ? $data['economy'] : '';
		$premium = isset($data['premium']) ? $data['premium'] : ''; 

		$pm1 = isset($data['pm1']) ? $data['pm1'] : '';
		$pm2 = isset($data['pm2']) ? $data['pm2'] : ''; 
		$pm3 = isset($data['pm3']) ? $data['pm3'] : ''; 
		$pm4 = isset($data['pm4']) ? $data['pm4'] : ''; 
		$pm5 = isset($data['pm5']) ? $data['pm5'] : '';
		$pm6 = isset($data['pm6']) ? $data['pm6'] : '';
		$pm7 = isset($data['pm7']) ? $data['pm7'] : '';
		$pm8 = isset($data['pm8']) ? $data['pm8'] : '';


		$packtitle = isset($data['packtitle']) ? $data['packtitle'] : '';
		$packdiscription = isset($data['packdiscription']) ? $data['packdiscription'] : '';
		$dataoption = isset($data['dataoption']) ? $data['dataoption'] : '';
		$zonoption = isset($data['zonoption']) ? $data['zonoption'] : '';


		?>	


<div class="pack-option-container">
	<div class="firstone">
		<div class="package-discription">
			<p>Package Subtitle</p>


			<input type="text" class="pack-title" name="pack-title" placeholder="<?php echo esc_attr($packtitle); ?>" value="<?php echo esc_attr($packtitle); ?>">
			<p>Package Description</p>
<textarea name="pack-discription" class="pack-discription" value="<?php echo esc_attr($packdiscription); ?>">
<?php echo esc_attr($packdiscription); ?>
</textarea>

</div>
		</div>

		<div class="package-main">
			<p>Package Included</p>
			<input type="text" class="pack-menu" name="packmain1" placeholder="<?php echo esc_attr($pm1); ?>" value="<?php echo esc_attr($pm1); ?>">
			<input type="text" class="pack-menu" name="packmain2" placeholder="<?php echo esc_attr($pm2); ?>" value="<?php echo esc_attr($pm2); ?>">
			<input type="text" class="pack-menu" name="packmain3" placeholder="<?php echo esc_attr($pm3); ?>" value="<?php echo esc_attr($pm3); ?>">
			<input type="text" class="pack-menu" name="packmain4" placeholder="<?php echo esc_attr($pm4); ?>" value="<?php echo esc_attr($pm4); ?>">
			<input type="text" class="pack-menu" name="packmain5" placeholder="<?php echo esc_attr($pm5); ?>" value="<?php echo esc_attr($pm5); ?>">
			<input type="text" class="pack-menu" name="packmain6" placeholder="<?php echo esc_attr($pm6); ?>" value="<?php echo esc_attr($pm6); ?>">
			<input type="text" class="pack-menu" name="packmain7" placeholder="<?php echo esc_attr($pm7); ?>" value="<?php echo esc_attr($pm7); ?>">	
			<input type="text" class="pack-menu" name="packmain8" placeholder="<?php echo esc_attr($pm8); ?>" value="<?php echo esc_attr($pm8); ?>">
		</div>
        	<div class="select-option">
<select name="dataoption" onchange="this.form.submit()">
     <option value="page1"<?php if ($dataoption == "page1") { echo " selected"; } ?>>Custom Departure</option>
     <option value="page2"<?php if ($dataoption  == "page2") { echo " selected"; } ?>>Fixed Departure</option>
</select>
 </div>
<?php

switch ($dataoption) {
    case 'page2': ?>
        
        <div class="package-fixed">

        	<div class="profile-picture-preview1" style="background-image: url(<?php echo esc_attr($picture1); ?>);">
        		<input type="button" class="upload-button" value="Upload Hotel Picture" data-group="1">
        		<input type="hidden" name="profile_picture1" class="profile-picture1" value="<?php echo esc_attr($picture1); ?>">
        	</div>
        	<div class="package-edit-input">
        		<table class="form-table">
        			<tr>
        				<th scope="row">Title</th>
        				<td><input type="text" class="fixed-departure" name="fixed-departure" placeholder="<?php echo esc_attr($fixeddeparture); ?>" value="<?php echo esc_attr($fixeddeparture); ?>"></td>
        			</tr>
        			<tr>
        				<th scope="row">Hotel Name</th>
        				<td><input type="text"  name="budget_title" placeholder="<?php echo esc_attr($budget); ?>" value="<?php echo esc_attr($budget); ?>"></td>
        			</tr>
        			<tr>
        				<th scope="row">Amount</th>
        				<td><input type="text"  name="pack1" placeholder="<?php echo esc_attr($p1); ?>" value="<?php echo esc_attr($p1); ?>"></td>
        			</tr>
        			<tr>
        				<th scope="row">Package Code</th>
        				<td><input type="text"  name="package" placeholder="<?php echo esc_attr($packagecode); ?>" value="<?php echo esc_attr($packagecode); ?>"></td>
        			</tr>
        			<tr>
        				<th scope="row">Balance tickets</th>
        				<td><input type="text" class="pack-menu" name="ticketcounter" placeholder="<?php echo esc_attr($ticketcount); ?>" value="<?php echo esc_attr($ticketcount); ?>"></td>
        			</tr>
        		</table>
        	</div>
        </div>

        <?php
        break;
        case 'page1':
        ?>
        <div class="packageoption">




<div class="package-edit">

	<div class="profile-picture-preview1" style="background-image: url(<?php echo esc_attr($picture1); ?>);"></div>
<input type="button" class="upload-button" value="Upload Profile Picture" data-group="1">
<input type="hidden" name="profile_picture1" class="profile-picture1" value="<?php echo esc_attr($picture1); ?>">
<input type="text" class="pack-title" name="budget_title" placeholder="<?php echo esc_attr($budget); ?>" value="<?php echo esc_attr($budget); ?>">

<input type="text" class="pack-price" name="pack1" placeholder="<?php echo esc_attr($p1); ?>" value="<?php echo esc_attr($p1); ?>">
<input type="text" class="pack-price" name="pack2" placeholder="<?php echo esc_attr($p2); ?>" value="<?php echo esc_attr($p2); ?>">
<input type="text" class="pack-price" name="pack3" placeholder="<?php echo esc_attr($p3); ?>" value="<?php echo esc_attr($p3); ?>">
</div>


<div class="package-edit">
	<div class="profile-picture-preview2" style="background-image: url(<?php echo esc_attr($picture2); ?>);"></div>
<input type="button" class="upload-button" value="Upload Profile Picture" data-group="2">
<input type="hidden" name="profile_picture2" class="profile-picture2" value="<?php echo esc_attr($picture2); ?>">
<input type="text" class="pack-title" name="economy_title" placeholder="<?php echo esc_attr($economy); ?>" value="<?php echo esc_attr($economy); ?>">

<input type="text" class="pack-price" name="pack4" placeholder="<?php echo esc_attr($p4); ?>" value="<?php echo esc_attr($p4); ?>">
<input type="text" class="pack-price" name="pack5" placeholder="<?php echo esc_attr($p5); ?>" value="<?php echo esc_attr($p5); ?>">
<input type="text" class="pack-price" name="pack6" placeholder="<?php echo esc_attr($p6); ?>" value="<?php echo esc_attr($p6); ?>">

</div>


<div class="package-edit">
	<div class="profile-picture-preview3" style="background-image: url(<?php echo esc_attr($picture3); ?>);"></div>
<input type="button" class="upload-button" value="Upload Profile Picture" data-group="3">
<input type="hidden" name="profile_picture3" class="profile-picture3" value="<?php echo esc_attr($picture3); ?>">
<input type="text" class="pack-title" name="premium_title" placeholder="<?php echo esc_attr($premium); ?>" value="<?php echo esc_attr($premium); ?>">

<input type="text" class="pack-price" name="pack7" placeholder="<?php echo esc_attr($p7); ?>" value="<?php echo esc_attr($p7); ?>">
<input type="text" class="pack-price" name="pack8" placeholder="<?php echo esc_attr($p8); ?>" value="<?php echo esc_attr($p8); ?>">
<input type="text" class="pack-price" name="pack9" placeholder="<?php echo esc_attr($p9); ?>" value="<?php echo esc_attr($p9); ?>">

</div>


</div>


        <?php
        break;
    }
    ?>

	</div>

</div>


<script>
jQuery(document).ready( function($){

var mediaUploader;

$('.upload-button').on('click',function(e) {
    e.preventDefault();
    var buttonID = $(this).data('group');

    if( mediaUploader ){
        mediaUploader.open();
        return;
    }

  mediaUploader = wp.media.frames.file_frame =wp.media({
    title: 'Choose a Hotel Picture',
    button: {
        text: 'Choose Picture'
    },
    multiple:false
  });

  mediaUploader.on('select', function(){
    attachment = mediaUploader.state().get('selection').first().toJSON();
    $('.profile-picture'+buttonID).val(attachment.url);
    $('.profile-picture-preview'+buttonID).css('background-image','url(' + attachment.url + ')');

  });
  mediaUploader.open();
}); });

</script>


<?php
	
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
			'p1' => $_POST['pack1'],
			'p2' => $_POST['pack2'],
			'p3' => $_POST['pack3'],
			'p4' => $_POST['pack4'],
			'p5' => $_POST['pack5'],
			'p6' => $_POST['pack6'],
			'p7' => $_POST['pack7'],
			'p8' => $_POST['pack8'],
			'p9' => $_POST['pack9'],

			'ticketcount' => $_POST['ticketcounter'],
			'fixeddeparture' => $_POST['fixed-departure'],


			'packdiscription' => $_POST['pack-discription'],
			'packtitle' => $_POST['pack-title'],
			'pm1' => $_POST['packmain1'],
			'pm2' => $_POST['packmain2'],
			'pm3' => $_POST['packmain3'],
			'pm4' => $_POST['packmain4'],
			'pm5' => $_POST['packmain5'],
			'pm6' => $_POST['packmain6'],
			'pm7' => $_POST['packmain7'],
			'pm8' => $_POST['packmain8'],

			'budget' => $_POST['budget_title'],

			'picture1' => $_POST['profile_picture1'],
			'picture2' => $_POST['profile_picture2'],
			'picture3' => $_POST['profile_picture3'],

			'packagecode' => $_POST['package'],

			'dataoption' => $_POST['dataoption'],
			'zonoption' => $_POST['zonoption'],



		);
		update_post_meta( $post_id, '_zonpackk_testimonial_key', $data );
		}
}


