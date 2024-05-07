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
class TestimonialController extends BaseController
{
	public $settings;



	public $callbacks;

	public function register()
	{
		if ( ! $this->activated( 'testimonial_manager' ) ) return;

		$this->settings = new SettingsApi();

		$this->callbacks = new TestimonialCallbacks();

		add_action( 'init', array( $this, 'testimonial_cpt' ) );
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
		add_action( 'save_post', array( $this, 'save_meta_box' ) );

		add_action( 'manage_testimonial_posts_columns', array( $this, 'set_custom_columns' ) );
		add_action( 'manage_testimonial_posts_custom_column', array( $this, 'set_custom_columns_data' ), 10, 2 );
		add_filter( 'manage_edit-testimonial_sortable_columns', array( $this, 'set_custom_columns_sortable' ) );

		add_shortcode( 'testimonial-form', array( $this, 'testimonial_form' ) );
		add_shortcode( 'user-booking', array( $this, 'user_booking' ) );

		add_action( 'wp_ajax_submit_testimonial', array( $this, 'submit_testimonial' ) );
		add_action( 'wp_ajax_nopriv_submit_testimonial', array( $this, 'submit_testimonial' ) );

		add_action( 'wp_ajax_update_testimonial', array( $this, 'update_testimonial' ) );
		add_action( 'wp_ajax_nopriv_update_testimonial', array( $this, 'update_testimonial' ) );

		// filter option for job application from candidates
		add_filter('parse_query', array( $this, 'tsm_convert_id_to_term_in_query') );
		add_action( 'init', array( $this,  'themes_taxonomy') );
		add_action('restrict_manage_posts', array( $this,  'tsm_filter_post_type_by_taxonomy') );
	}

		public function wp_first_shortcode() {

	}

	//https://stackoverflow.com/questions/72428718/wordpress-upload-post-and-attach-file-wp-insert-post-and-wp-insert-attachment
	// filter option for job application from candidates
        
		public function tsm_filter_post_type_by_taxonomy() {
        	global $typenow;
        	$post_type = 'testimonial'; // change to your post type
        	$taxonomy  = 'themes_categories'; // change to your taxonomy
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
        
        public function tsm_convert_id_to_term_in_query($query) {
        	global $pagenow;
        	$post_type = 'testimonial'; // change to your post type
        	$taxonomy  = 'themes_categories'; // change to your taxonomy
        	$q_vars    = &$query->query_vars;
        	if ( $pagenow == 'edit.php' && isset($q_vars['post_type']) && $q_vars['post_type'] == $post_type && isset($q_vars[$taxonomy]) && is_numeric($q_vars[$taxonomy]) && $q_vars[$taxonomy] != 0 ) {
        		$term = get_term_by('id', $q_vars[$taxonomy], $taxonomy);
        		$q_vars[$taxonomy] = $term->slug;
        	}
        }
        public function themes_taxonomy() {
            register_taxonomy(
                'themes_categories',  // The name of the taxonomy. Name should be in slug form (must not contain capital letters or spaces).
                'testimonial',             // post type name
                array(
                    'hierarchical' => true,
                    'label' => 'Themes store', // display name
                    'query_var' => true,
                    'rewrite' => array(
                        'slug' => 'themes',    // This controls the base slug that will display before each term
                        'with_front' => false  // Don't display the category base before
                    )
                )
            );
        }
        // filter option for job application from candidates

	public function submit_testimonial()
	{
	    
		if (! DOING_AJAX || ! check_ajax_referer('testimonial-nonce', 'nonce') ) {
			return $this->return_json('error');
		}

		$name = sanitize_text_field($_POST['name']);
		$package = sanitize_text_field($_POST['package']);
		$phone = sanitize_text_field($_POST['phone']);
		$date = sanitize_text_field($_POST['date']);
		$email = sanitize_email($_POST['email']);
		$message = sanitize_textarea_field($_POST['message']);

		$data = array(
			'name' => $name,
			'package' => $package,
			'phone' => $phone,
			'email' => $email,
			'date' => $date,
			'date' => $message,
			'approved' => 0,
			'featured' => 0,
		);
		$args = array(
			'post_title' => $name,
			'post_content' => $message,
			'post_author' =>  get_current_user_id(),
			'post_status' => 'publish',
			'post_type' => 'testimonial',
			'meta_input' => array(
				'_zon_testimonial_key' => $data
			)
		);

		$postID = wp_insert_post( $args );

		if ($postID) {
            $headers = "MIME-Version: 1.0\r\n" .
            "From: " . $current_user->user_email . "\r\n" .
            "Content-Type: text/plain; charset=\"" . get_option('blog_charset') . "\"\r\n";
            $to = $email;
            $body = "Hello " .  $name . " Your ZonPackage " . $package . " Booking Confirmed ." ;
            $subject ="Zon Package Booking";
            wp_mail( $to, $subject, $body, $headers );
        }
		
		if ($postID) {
		    return $this->return_json('success');
		    
		}
	    
	}
	
	public function return_json( $status ) {
	    $return = array(
	        'status' => $status
	        );
	        wp_send_json($return);
	    
	}

	public function update_testimonial() {
		if( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) &&  $_POST['action'] == "f_edit_post" && isset($_POST['pid'])) {
			//get the old post:
			$post_to_edit = get_post((int)$_POST['pid']); 
		
			//do you validation
			//...
			//...
		
		
			
		
			//save the edited post and return its ID
			$pid = wp_update_post($post_to_edit); 
		
		
			//set new category
			wp_set_post_terms($pid,(array)($_POST['cat']),'category',true);
		
		}
	}
	

	    
	    

	


	public function testimonial_form()
	{
		ob_start();
		echo "<link rel=\"stylesheet\" href=\"$this->plugin_url/assets/form.css\" type=\"text/css\" media=\"all\" />";

		require_once( "$this->plugin_path/templates/single-products.php" );

		echo "<script src=\"$this->plugin_url/assets/form.js\"></script>";

		return ob_get_clean();
	}

	public function user_booking()
	{
		ob_start();
		echo "<link rel=\"stylesheet\" href=\"$this->plugin_url/assets/user-booking.css\" type=\"text/css\" media=\"all\" />";

		require_once( "$this->plugin_path/templates/user-booking.php" );

		echo "<script src=\"$this->plugin_url/assets/user-booking.js\"></script>";

		return ob_get_clean();
	}
	

	public function testimonial_cpt ()
	{
		$labels = array(
			'name' => 'Candidates Applications',
			'singular_name' => 'Testimonial'
		);

		$supports = array('');
		$args = array(
			'labels' => $labels,
			'public' => true,
			'has_archive' => false,
			'menu_icon' => 'dashicons-calendar-alt',
			'menu_position'         => 1,
			'exclude_from_search' => true,
			'publicly_queryable' => false,
			'supports' => $supports
		);

		register_post_type ( 'testimonial', $args );
	}


    
	public function add_meta_boxes()
	{
		add_meta_box(
			'testimonial_author',
			'Zon Bookings',
			array( $this, 'render_features_box' ),
			'testimonial',
			'normal',
			'high'
		);

	}

	public function render_features_box($post)
	{
		wp_nonce_field( 'zon_testimonial', 'zon_testimonial_nonce' );

		$data = get_post_meta( $post->ID, '_zon_testimonial_key', true );

		$package = isset($data['package']) ? $data['package'] : '';
		$phone = isset($data['phone']) ? $data['phone'] : '';
		$name = isset($data['name']) ? $data['name'] : '';
		$date = isset($data['date']) ? $data['date'] : '';
		$email = isset($data['email']) ? $data['email'] : '';
		$approved = isset($data['approved']) ? $data['approved'] : false;
		$featured = isset($data['featured']) ? $data['featured'] : false;
		?>
		<p>
			<label class="meta-label" for="zon_name">name</label>
			<input type="text" id="zon_name" name="zon_name" class="widefat" value="<?php echo esc_attr( $name ); ?>">
		</p>
		<p>
			<label class="meta-label" for="zon_testimonial_author">Adult</label>
			<input type="text" id="zon_testimonial_author" name="zon_testimonial_author" class="widefat" value="<?php echo esc_attr( $name ); ?>">
		</p>
		<p>
			<label class="meta-label" for="zon_testimonial_date">Date</label>
			<input type="text" id="zon_testimonial_date" name="zon_testimonial_date" class="widefat" value="<?php echo esc_attr( $date ); ?>">
		</p>

		<p>
			<label class="meta-label" for="zon_package">package</label>
			<input type="text" id="zon_package" name="zon_package" class="widefat" value="<?php echo esc_attr( $package ); ?>">
		</p>

		<p>
			<label class="meta-label" for="zon_phone">phone</label>
			<input type="text" id="zon_phone" name="zon_phone" class="widefat" value="<?php echo esc_attr( $phone ); ?>">
		</p>

	
		<p>
			<label class="meta-label" for="zon_testimonial_email">Email</label>
			<input type="email" id="zon_testimonial_email" name="zon_testimonial_email" class="widefat" value="<?php echo esc_attr( $email ); ?>">
		</p>
		<div class="meta-container">
			<label class="meta-label w-50 text-left" for="zon_testimonial_approved">Candidates Shortlisted</label>
			<div class="text-right w-50 inline">
				<div class="ui-toggle inline"><input type="checkbox" id="zon_testimonial_approved" name="zon_testimonial_approved" value="1" <?php echo $approved ? 'checked' : ''; ?>>
					<label for="zon_testimonial_approved"><div></div></label>
				</div>
			</div>
		</div>
		<div class="meta-container">
			<label class="meta-label w-50 text-left" for="zon_testimonial_featured">Featured</label>
			<div class="text-right w-50 inline">
				<div class="ui-toggle inline"><input type="checkbox" id="zon_testimonial_featured" name="zon_testimonial_featured" value="1" <?php echo $featured ? 'checked' : ''; ?>>
					<label for="zon_testimonial_featured"><div></div></label>
				</div>
			</div>
		</div>
		<?php
	}

	public function save_meta_box($post_id)
	{
		if (! isset($_POST['zon_testimonial_nonce'])) {
			return $post_id;
		}

		$nonce = $_POST['zon_testimonial_nonce'];
		if (! wp_verify_nonce( $nonce, 'zon_testimonial' )) {
			return $post_id;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}

		if (! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}

		$data = array(
			'package' => sanitize_text_field( $_POST['zon_package'] ),
			'phone' => sanitize_text_field( $_POST['zon_phone'] ),
			'name' => sanitize_text_field( $_POST['zon_testimonial_author'] ),
			'date' => sanitize_text_field( $_POST['zon_testimonial_date'] ),
			'email' => sanitize_email( $_POST['zon_testimonial_email'] ),
			'approved' => isset($_POST['zon_testimonial_approved']) ? 1 : 0,
			'featured' => isset($_POST['zon_testimonial_featured']) ? 1 : 0,
		);
		update_post_meta( $post_id, '_zon_testimonial_key', $data );
	}

	public function set_custom_columns($columns)
	{
		$title = $columns['title'];
		$date = $columns['date'];
		unset( $columns['title'], $columns['date'] );
		$columns['name'] = 'Author Name';
		$columns['title'] = $title;
		$columns['approved'] = 'Approved';
		$columns['featured'] = 'Short listed';
		$columns['date'] = $date;
    
	    return $columns;
	}

	
	public function set_custom_columns_data($column, $post_id)
	{
		$data = get_post_meta( $post_id, '_zon_testimonial_key', true );
		$name = isset($data['name']) ? $data['name'] : '';
		$date = isset($data['date']) ? $data['date'] : '';
		$package = isset($data['package']) ? $data['package'] : '';
		$phone = isset($data['phone']) ? $data['phone'] : '';
		$email = isset($data['email']) ? $data['email'] : '';
		$approved = isset($data['approved']) && $data['approved'] === 1 ? '<strong>YES</strong>' : 'NO';
		$featured = isset($data['featured']) && $data['featured'] === 1 ? '<strong>YES</strong>' : 'NO';

		switch($column) {
			case 'name':
				echo '<strong>' . $name . '</strong><br/><a href="mailto:' . $email . '">' . $email . '</a>';
				break;

			case 'approved':
				echo $approved;
				break;

			case 'featured':
				echo $featured;
				break;
		}
	}

	public function set_custom_columns_sortable($columns)
	{

		$columns['name'] = 'name';
		$columns['package'] = 'package';
		$columns['phone'] = 'phone';
		$columns['date'] = 'date';
		$columns['approved'] = 'approved';
		$columns['featured'] = 'featured';

		return $columns;
	}
}

