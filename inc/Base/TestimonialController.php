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
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ), 25, 3 );
		add_action( 'add_meta_boxes', array( $this, 'add_status_box'), 25, 3 );
		add_action( 'save_post', array( $this, 'save_meta_box' ) );

		add_action( 'manage_applications_posts_columns', array( $this, 'set_custom_columns' ) );
		add_action( 'manage_applications_posts_custom_column', array( $this, 'set_custom_columns_data' ), 10, 2 );
		add_filter( 'manage_edit-applications_sortable_columns', array( $this, 'set_custom_columns_sortable' ) );

		add_shortcode( 'application-form', array( $this, 'application_form' ) );

		add_action( 'wp_ajax_submit_testimonial', array( $this, 'submit_testimonial' ) );
		add_action( 'wp_ajax_nopriv_submit_testimonial', array( $this, 'submit_testimonial' ) );

		add_action( 'wp_ajax_update_testimonial', array( $this, 'update_testimonial' ) );
		add_action( 'wp_ajax_nopriv_update_testimonial', array( $this, 'update_testimonial' ) );

		// filter option for job application from candidates
		add_filter('parse_query', array( $this, 'tsm_convert_id_to_term_in_query') );
	
		add_action('restrict_manage_posts', array( $this,  'tsm_filter_post_type_by_taxonomy') );
	}
		
	    // https://stackoverflow.com/questions/72428718/wordpress-upload-post-and-attach-file-wp-insert-post-and-wp-insert-attachment
	    // filter option for job application from candidates
		public function tsm_filter_post_type_by_taxonomy() {
        	global $typenow;
        	$post_type = 'applications' ; // change to your post type
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
        public function tsm_convert_id_to_term_in_query($query) {
        	global $pagenow;
        	$post_type = 'applications'; // change to your post type
        	$taxonomy  = 'job-type'; // change to your taxonomy
        	$q_vars    = &$query->query_vars;
        	if ( $pagenow == 'edit.php' && isset($q_vars['post_type']) && $q_vars['post_type'] == $post_type && isset($q_vars[$taxonomy]) && is_numeric($q_vars[$taxonomy]) && $q_vars[$taxonomy] != 0 ) {
        		$term = get_term_by('id', $q_vars[$taxonomy], $taxonomy);
        		$q_vars[$taxonomy] = $term->slug;
        	}
        }
        

	public function submit_testimonial()
	{
	    
		if (! DOING_AJAX || ! check_ajax_referer('testimonial-nonce', 'nonce') ) {
			return $this->return_json('error');
		}

		$name = sanitize_text_field($_POST['name']);
		$jobtitle = sanitize_text_field($_POST['jobtitle']);
		$cv = sanitize_text_field($_POST['cv']);
		$email = sanitize_email($_POST['email']);
		$message = sanitize_textarea_field($_POST['message']);
		$phone = sanitize_text_field($_POST['phone']);
		
		$date = sanitize_text_field($_POST['date']);
		
		

		$data = array(
			'name' => $name,
			'jobtitle' => $jobtitle,
			'cv' => $cv,
			'phone' => $phone,
			'email' => $email,
			
			'date' => $date,
			'message' => $message,
			'approved' => 0,
			'featured' => 0,
		);
		$args = array(
			'post_title' => $name,
			'post_content' => $message,
			'post_author' =>  get_current_user_id(),
			'post_status' => 'publish',
			'post_type' => 'applications',
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
            $body = "Hello " .  $name . " Your CV succefully Submitted " . $package . " We will inform you selection updates ." ;
            $subject ="Vistas Careers: Job Application Confirmation";
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

	public function application_form()
	{
		ob_start();
		echo "<link rel=\"stylesheet\" href=\"$this->plugin_url/assets/form.css\" type=\"text/css\" media=\"all\" />";
		require_once( "$this->plugin_path/templates/application-form.php" );
		echo "<script src=\"$this->plugin_url/assets/form.js\"></script>";
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

		register_post_type ( 'applications', $args );
	}
	public function add_status_box()
	{
		add_meta_box(
			'application_satuts',
			'Application status',
			array( $this, 'render_status_box' ),
			'applications',
			'side',
			'high'
		);
	}
	public function render_status_box($post)
	{
		$termID = [];
        $terms = get_the_terms( 553, 'job-type');
        foreach ($terms as $term) {
            $termID = $term->name;
              
            echo '<p>'.$termID.'</p>';
        }
	}
	public function add_meta_boxes()
	{
		add_meta_box(
			'testimonial_author',
			'Candidate Application Details',
			array( $this, 'render_features_box' ),
			'applications',
			'side',
			'high'
		);
	}
	public function render_features_box($post)
	{
		wp_nonce_field( 'zon_testimonial', 'zon_testimonial_nonce' );
		$data = get_post_meta( $post->ID, '_zon_testimonial_key', true );
        $cv = isset($data['cv']) ? $data['cv'] : '';
		$phone = isset($data['phone']) ? $data['phone'] : '';
		$name = isset($data['name']) ? $data['name'] : '';
		$jobtitle = isset($data['jobtitle']) ? $data['jobtitle'] : '';
		$message = isset($data['message']) ? $data['message'] : '';
		$email = isset($data['email']) ? $data['email'] : '';
		$approved = isset($data['approved']) ? $data['approved'] : false;
		$featured = isset($data['featured']) ? $data['featured'] : false;
		?>
		<p>
			<label class="meta-label" for="zon_name">Attached File(CV)</label>
			<div class="input-group">
			   <input type="text" id="zon_cv" name="zon_cv" class="widefat" value="<?php echo esc_attr( $cv ); ?>" disabled>
			   <button id="cv-download"><a href="<?php echo esc_attr( $cv ); ?>" download>Download CV</a></button>
			   <button id="cv-view"><a href="<?php echo esc_attr( $cv ); ?>" target="blank" rel="noopener noreferrer">View CV</a></button>
			</div>
		</p>
		<p>
			<label class="meta-label" for="zon_name">name</label>
			<input type="text" id="zon_name" name="zon_name" class="widefat" value="<?php echo esc_attr( $name ); ?>">
		</p>
		<p>
			<label class="meta-label" for="zon_package">Applyed for</label>
			<input type="text" id="zon_package" name="zon_package" class="widefat" value="<?php echo esc_attr( $jobtitle ); ?>">
		</p>
		<p>
			<label class="meta-label" for="zon_phone">phone</label>
			<input type="text" id="zon_phone" name="zon_phone" class="widefat" value="<?php echo esc_attr( $phone ); ?>">
		</p>
		<p>
			<label class="meta-label" for="zon_testimonial_email">Email</label>
			<input type="email" id="zon_testimonial_email" name="zon_testimonial_email" class="widefat" value="<?php echo esc_attr( $email ); ?>">
		</p>
		<p>
			<label class="meta-label" for="zon_testimonial_email">Cover Letter</label>
			<textarea  id="cover_message" name="cover_message" class="widefat" value="<?php echo esc_attr( $message ); ?>"></textarea>
		</p>
		<div class="meta-container">
			<label class="meta-label w-50 text-left" for="zon_testimonial_approved">Candidate Shortlisted</label>
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
			'phone' => sanitize_text_field( $_POST['zon_phone'] ),
			'cv' => sanitize_text_field( $_POST['zon_cv'] ),
			'jobtitle' => sanitize_text_field( $_POST['jobtitle'] ),
			'name' => sanitize_text_field( $_POST['zon_testimonial_author'] ),
			'message' => sanitize_text_field( $_POST['message'] ),
			'email' => sanitize_email( $_POST['zon_testimonial_email'] ),
			'approved' => isset($_POST['zon_testimonial_approved']) ? 1 : 0,
			'featured' => isset($_POST['zon_testimonial_featured']) ? 1 : 0,
		);
		update_post_meta( $post_id, '_zon_testimonial_key', $data );
	}

	public function set_custom_columns($columns)
	{


        //Uset defualt wordpress column titles
		unset( 
			$columns['title'], 
		    $columns['date'] 
		);
        //Assign new header titles
		$columns['name'] = 'Author Name';
		$columns['jobtitle'] = 'Job applied for';
		$columns['approved'] = 'Approved';
		$columns['featured'] = 'Short listed';
		$columns['date'] = 'Date';
		
    
	    return $columns;
	}

	
	public function set_custom_columns_data($column, $post_id)
	{
		
		$data = get_post_meta( $post_id, '_zon_testimonial_key', true );
		
		$name = isset($data['name']) ? $data['name'] : '';
		$jobtitle = isset($data['jobtitle']) ? $data['jobtitle'] : '';
		
		$date = isset($data['date']) ? $data['date'] : '';
		
		
		$phone = isset($data['phone']) ? $data['phone'] : '';
		$email = isset($data['email']) ? $data['email'] : '';
		$approved = isset($data['approved']) && $data['approved'] === 1 ? '<strong>YES</strong>' : 'NO';
		$featured = isset($data['featured']) && $data['featured'] === 1 ? '<strong>YES</strong>' : 'NO';


		
		switch($column) {
			case 'name':
				echo '<strong>' . $name . '</strong><br/><a href="mailto:' . $email . '">' . $email . '</a>';
				break;

			case 'jobtitle':
				echo '<strong>' . $jobtitle . '<strong>';
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
		$columns['title'] = 'title';
		$columns['phone'] = 'phone';
		$columns['date'] = 'date';
		$columns['approved'] = 'approved';
		$columns['featured'] = 'featured';

		return $columns;
	}
}

