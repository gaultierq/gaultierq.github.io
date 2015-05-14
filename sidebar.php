<?php
/**
 * The Sidebar containing the main widget area
 *
 * @package WordPress
 * @subpackage Grateful
 * @since Grateful 1.0.0
 */

global $grateful_option;
?>

<!-- Start : Left Content -->
<div id="leftcontent">
	<!-- Start : Header -->
	<header id="main-header">
		<div id="logo" class="wow fadeIn center animated">
			<?php if( $grateful_option['logo_type'] == '1' ) : ?>
				<h2 class="site-title"><a href="<?php echo get_home_url(); ?>"><?php echo bloginfo('name'); ?></a></h2>
				<span class="slogan"><?php echo bloginfo('description'); ?></span>
			<?php else: ?>
				<a href="<?php echo home_url('/'); ?>"><img src="<?php echo ( $grateful_option['logo_image'] ? esc_url( $grateful_option['logo_image']['url'] ) : get_template_directory_uri().'/images/logo.png' ); ?>" alt="<?php get_bloginfo('name'); ?>" /></a>
			<?php endif; ?>
		</div>
	</header>
	<!-- End : Header -->

	<!-- Start : Widget -->
	<div class="sidebar-widgets">
		<?php
		// Load sidebar widgets
		if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar') ) {
			// Main menu
			if ( has_nav_menu( 'main-menu' ) ) {
				wp_nav_menu( array ( 'theme_location' => 'main-menu', 'container' => 'div', 'container_class' => 'menu-navigation', 'menu_class' => 'main', 'depth' => 2 ) );
			}

			echo '<p class="no-widget">';
			_e('There\'s no widget assigned. You can start assigning widgets to "Sidebar" widget area from the <a href="'. admin_url('/widgets.php') .'">Widgets</a> page.', 'grateful');
			echo '</p>';
		}
		?>

		<footer id="footer">
			<p><?php printf( __( 'Copyright %2$s %1$s.', 'grateful' ), get_bloginfo('name'), date_i18n('Y') ); ?> <br />
			<?php printf( __( 'Designed by %1$s', 'grateful' ), '<a href="http://www.themewarrior.com">ThemeWarrior</a>' ); ?></p>
		</footer>
	</div>
	<!-- End : Widget -->
</div>
<div class="before"></div>