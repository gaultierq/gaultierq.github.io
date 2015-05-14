<?php
/**
 * Function to load JS & CSS files
 *
 * @package WordPress
 * @subpackage Grateful
 * @since Grateful 1.0.0
 */

if ( ! function_exists( 'warrior_enqueue_scripts' ) ) {
	function warrior_enqueue_scripts() {
		global $pagenow;
		
		// Only load these scripts on frontend
		if( !is_admin() && $pagenow != 'wp-login.php' ) {

			// Load all Javascript files
			wp_enqueue_script('jquery');

			if ( is_singular() ) {
				wp_enqueue_script( 'comment-reply' );
			}

			wp_enqueue_script('stellar', get_template_directory_uri() .'/js/jquery.stellar.min.js', '', '0.6.2', true);
			wp_enqueue_script('jpanelmenu', get_template_directory_uri() .'/js/jquery.jpanelmenu.min.js', '', '1.3.0', true);
			wp_enqueue_script('fitvids', get_template_directory_uri() .'/js/jquery.fitvids.js', '', '1.1', true);
			wp_enqueue_script('flexslider', get_template_directory_uri() .'/js/jquery.flexslider-min.js', '', '2.2.2', true);
			wp_enqueue_script('prettyphoto', get_template_directory_uri() .'/js/jquery.prettyPhoto.js', '', '3.1.5', true);
			wp_enqueue_script('backstretch', get_template_directory_uri() .'/js/jquery.backstretch.min.js', '', '2.0.4', true);
			wp_enqueue_script('mobilemenu', get_template_directory_uri() .'/js/jquery.mobilemenu.js', '', '1.1', true);
			wp_enqueue_script('superfish', get_template_directory_uri() .'/js/superfish.js', '', '1.1', true);
			wp_enqueue_script('wow', get_template_directory_uri() .'/js/wow.min.js', '', '0.1.6', true);
			wp_enqueue_script('functions', get_template_directory_uri() .'/js/functions.js', '', null, true);

			// Localize variable
			wp_localize_script('functions', '_warrior', array(
				'bg_body_image' => esc_url( get_background_image() ),
				'mobile_menu_text' => __('Navigate to...', 'grateful'),
				'sticky_text' => __('Sticky', 'grateful'),
			));

			// Load all CSS files
			wp_enqueue_style('reset', get_template_directory_uri() .'/css/reset.css', array(), false, 'all');
			wp_enqueue_style('style', get_template_directory_uri() .'/style.css', array(), false, 'all');
			wp_enqueue_style('typicon', get_template_directory_uri() .'/css/typicons.css', array(), false, 'all');
			wp_enqueue_style('animate', get_template_directory_uri() .'/css/animate.min.css', array(), false, 'all');
			wp_enqueue_style('prettyphoto', get_template_directory_uri() .'/css/prettyPhoto.css', array(), false, 'all');
			wp_enqueue_style('responsive', get_template_directory_uri() .'/css/responsive.css', array(), false, 'all');
		}
	}
}
add_action( 'wp_print_styles', 'warrior_enqueue_scripts' );


/**
 * Function to generate the several styles from theme options
 *
 * @package WordPress
 * @subpackage Grateful
 * @since Grateful 1.0.0
 */
if ( ! function_exists( 'warrior_add_styles_theme_options' ) ) {
	function warrior_add_styles_theme_options() {
		global $grateful_option;
		?>
		<style type="text/css">
			input::-webkit-input-placeholder,
			input:-moz-placeholder,
			input::-moz-placeholder,
			input:-ms-input-placeholder {
				font-family: <?php echo $grateful_option['form_field_font']['font-family']; ?>;
			}
		</style>
		<?php
	}
}
add_action( 'wp_enqueue_scripts', 'warrior_add_styles_theme_options' );


/**
 * Function to load JS & CSS files on init
 *
 * @package WordPress
 * @subpackage Grateful
 * @since Grateful 1.0.0
 */
if ( ! function_exists( 'warrior_init_styles' ) ) {
	function warrior_init_styles () {
		add_editor_style( 'css/editor-style.css' );
	}
}
add_action( 'init', 'warrior_init_styles' ); 