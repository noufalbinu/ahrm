<?php


if ( 
    'POST' == $_SERVER['REQUEST_METHOD'] && ! 
    empty($_POST['post_id']) && ! 
    empty($_POST['post_title']) && 
    isset($_POST['update_post_nonce']) )
{
    $post_id   = $_POST['post_id'];
    global $current_user;
    wp_get_current_user();
    $args = array(
        'post_type' => 'testimonial',
        'post_status' => 'publish',
        'post_per_page' => 5,
        'author' => $current_user->ID,
        'meta_query' => array(
            array(
                'key' => '_zon_testimonial_key',
                'value' => 's:8:"approved";i:1;s:8:"featured";i:0;',
                'compare' => 'LIKE'
                )
        )
    );

    if ( current_user_can($args, $post_id) && wp_verify_nonce( $_POST['update_post_nonce'], 'update_post_'. $post_id ) ){
        $args = array(
            'ID'             => esc_sql($post_id),
            'post_title'     => esc_sql($_POST['post_title'])
        );
        wp_update_post($post);
    }

}

$query =new WP_Query($args);
if ($query->have_posts() || is_user_logged_in() || current_user_can('edit_post', $args->ID)) :
while ($query->have_posts()) : $query->the_post();
echo '<p>'.get_the_title().'</p>';
?>
<form id="post" method="post" >
<input type="hidden" name="post_id" value="<?php the_ID(); ?>" />
<?php wp_nonce_field( 'update_post_'. get_the_ID(), 'update_post_nonce' ); ?>
<input type="text" id="post_title" name="post_title" value="<?php echo $args->post_title; ?>" /></p>

<input type="submit" id="submit" value="Update" />
</form>
<?php endwhile; endif; ?>


