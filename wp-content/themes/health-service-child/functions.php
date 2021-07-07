<?php 
add_action( 'wp_enqueue_scripts', 'health_service_child_enqueue_styles' );
function health_service_child_enqueue_styles() {
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' ); 
	wp_enqueue_style( 'style-css', get_stylesheet_directory_uri() . '/dist/css/style.css' ); 

	// Register the script - Blog Load More
	wp_register_script( 'custom-script', get_stylesheet_directory_uri(). '/src/js/blog.js', array('jquery'), false, true );			
	$script_data_array = array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
		'security' => wp_create_nonce( 'load_more_posts' ),
	);
	wp_localize_script( 'custom-script', 'blog', $script_data_array );			
	wp_enqueue_script( 'custom-script' );

	// Register the script - Testimonial Load More
	wp_register_script( 'testimonial-script', get_stylesheet_directory_uri(). '/src/js/testimonial.js', array('jquery'), false, true );			
	$script_data_array_testimonial = array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
		'security' => wp_create_nonce( 'load_more_testimonial' ),
	);
	wp_localize_script( 'testimonial-script', 'testimonial', $script_data_array_testimonial );			
	wp_enqueue_script( 'testimonial-script' );

} 

// Blog Load More Callback Function
add_action('wp_ajax_load_posts_by_ajax', 'load_posts_by_ajax_callback');
add_action('wp_ajax_nopriv_load_posts_by_ajax', 'load_posts_by_ajax_callback');
function load_posts_by_ajax_callback() {
	check_ajax_referer('load_more_posts', 'security');
	$paged = $_POST['page'];
	$args = array(
		'post_type' => 'post',
		'post_status' => 'publish',
		'posts_per_page' => '3',
		'paged' => $paged,
	);
	$blog_posts = new WP_Query( $args );
	?>
	
	<?php if ( $blog_posts->have_posts() ) : ?>
		<?php while ( $blog_posts->have_posts() ) : $blog_posts->the_post(); ?>
		<div class="blogposts__item col-lg-6">                            
			<?php echo get_the_post_thumbnail( $blog_posts->ID, 'full' ); ?>
			<div class="blogposts__info">
				<h2 class="blogposts__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				<div class="blogposts__text"><?php the_excerpt(); ?></div>
			</div>
                            </div>
		<?php endwhile; ?>
		<?php
	endif;
	
	wp_die();
}

// Testimonial Load More Callback Function
add_action('wp_ajax_load_testimonial_by_ajax', 'load_testimonial_by_ajax_callback');
add_action('wp_ajax_nopriv_load_testimonial_by_ajax', 'load_testimonial_by_ajax_callback');
function load_testimonial_by_ajax_callback() {
	check_ajax_referer('load_more_testimonial', 'security');
	$paged = $_POST['page'];
	$args = array(
		'post_type' => 'testimonial',
		'post_status' => 'publish',
		'posts_per_page' => '3',
		'paged' => $paged,
	);
	$testimonial_posts = new WP_Query( $args );
	?>
	
	<?php if ( $testimonial_posts->have_posts() ) : ?>
		<?php while ( $testimonial_posts->have_posts() ) : $testimonial_posts->the_post(); ?>
		<div class="testimonial-list__item col-lg-12">                            
			<p class="testimonial-list__bio"><?php echo get_post_meta( get_the_ID(), 'bio', true); ?></p>
			<h3 class="testimonial-list__name"><?php echo get_post_meta( get_the_ID(), 'name', true); ?></h3>
			<h4 class="testimonial-list__location"><?php echo get_post_meta( get_the_ID(), 'location', true); ?></h4>                            
		</div>
		<?php endwhile; ?>
		<?php
	endif;
	
	wp_die();
}


		


// Admin Option Page For Social
if( function_exists('acf_add_options_page') ) {	
	acf_add_options_page();	
}



// ACF Testimonial Block
add_action('acf/init', 'my_acf_init');
function my_acf_init() {
	
	// check function exists
	if( function_exists('acf_register_block') ) {
		
		// register a testimonial block
		acf_register_block(array(
			'name'				=> 'testimonial',
			'title'				=> __('Testimonial'),
			'description'		=> __('A custom testimonial block.'),
			'render_callback'	=> 'testimonial_acf_block_render_callback',
			'category'			=> 'formatting',
			'icon'				=> 'admin-comments',
			'keywords'			=> array( 'testimonial', 'quote' ),
		));
	
		
		// register a testimonial List block
		acf_register_block(array(
			'name'				=> 'testimonial-list',
			'title'				=> __('Testimonial List'),
			'description'		=> __('A testimonial list block.'),
			'render_callback'	=> 'testimonial_acf_block_render_callback',
			'category'			=> 'formatting',
			'icon'				=> 'admin-comments',
			'keywords'			=> array( 'testimonial-list', 'quote' ),
		));
	}
}


function testimonial_acf_block_render_callback( $block ) {
	
	// convert name ("acf/testimonial") into path friendly slug ("testimonial")
	$slug = str_replace('acf/', '', $block['name']);
	
	// include a template part from within the "template-parts/block" folder
	if( file_exists( get_theme_file_path("/template-parts/block/content-{$slug}.php") ) ) {
		include( get_theme_file_path("/template-parts/block/content-{$slug}.php") );
	}
}


// Register Custom Post Type Testimonial
function create_testimonial_cpt() {

	$labels = array(
		'name' => _x( 'Testimonials', 'Post Type General Name', 'textdomain' ),
		'singular_name' => _x( 'Testimonial', 'Post Type Singular Name', 'textdomain' ),
		'menu_name' => _x( 'Testimonials', 'Admin Menu text', 'textdomain' ),
		'name_admin_bar' => _x( 'Testimonial', 'Add New on Toolbar', 'textdomain' ),
		'archives' => __( 'Testimonial Archives', 'textdomain' ),
		'attributes' => __( 'Testimonial Attributes', 'textdomain' ),
		'parent_item_colon' => __( 'Parent Testimonial:', 'textdomain' ),
		'all_items' => __( 'All Testimonials', 'textdomain' ),
		'add_new_item' => __( 'Add New Testimonial', 'textdomain' ),
		'add_new' => __( 'Add New', 'textdomain' ),
		'new_item' => __( 'New Testimonial', 'textdomain' ),
		'edit_item' => __( 'Edit Testimonial', 'textdomain' ),
		'update_item' => __( 'Update Testimonial', 'textdomain' ),
		'view_item' => __( 'View Testimonial', 'textdomain' ),
		'view_items' => __( 'View Testimonials', 'textdomain' ),
		'search_items' => __( 'Search Testimonial', 'textdomain' ),
		'not_found' => __( 'Not found', 'textdomain' ),
		'not_found_in_trash' => __( 'Not found in Trash', 'textdomain' ),
		'featured_image' => __( 'Featured Image', 'textdomain' ),
		'set_featured_image' => __( 'Set featured image', 'textdomain' ),
		'remove_featured_image' => __( 'Remove featured image', 'textdomain' ),
		'use_featured_image' => __( 'Use as featured image', 'textdomain' ),
		'insert_into_item' => __( 'Insert into Testimonial', 'textdomain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Testimonial', 'textdomain' ),
		'items_list' => __( 'Testimonials list', 'textdomain' ),
		'items_list_navigation' => __( 'Testimonials list navigation', 'textdomain' ),
		'filter_items_list' => __( 'Filter Testimonials list', 'textdomain' ),
	);
	$args = array(
		'label' => __( 'Testimonial', 'textdomain' ),
		'description' => __( '', 'textdomain' ),
		'labels' => $labels,
		'menu_icon' => '',
		'supports' => array('title', 'editor'),
		'taxonomies' => array(),
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'menu_position' => 5,
		'show_in_admin_bar' => true,
		'show_in_nav_menus' => true,
		'can_export' => true,
		'has_archive' => true,
		'hierarchical' => false,
		'exclude_from_search' => false,
		'show_in_rest' => true,
		'publicly_queryable' => true,
		'capability_type' => 'post',
	);
	register_post_type( 'testimonial', $args );

}
add_action( 'init', 'create_testimonial_cpt', 0 );


?>
