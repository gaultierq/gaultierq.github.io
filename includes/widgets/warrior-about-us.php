<?php
/**
 * About Us widget
 *
 * @package WordPress
 * @subpackage Grateful
 * @since Grateful 1.0
 */


// Widgets
add_action( 'widgets_init', 'warrior_about_widget' );

// Register our widget
function warrior_about_widget() {
	register_widget( 'Warrior_About' );
}

// Warrior Latest Posts Widget
class Warrior_About extends WP_Widget {

	//  Setting up the widget
	function Warrior_About() {
		$widget_ops  = array( 'classname' => 'about', 'description' => __('Display author short description and social media profile links.', 'grateful') );
		$control_ops = array( 'id_base' => 'warrior_about' );

		$this->WP_Widget( 'warrior_about', __('Warrior About', 'grateful'), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		global $grateful_option;

		extract( $args );

		$warrior_about_title = $instance['warrior_about_title'];

		echo $before_widget;
		echo $before_title . $warrior_about_title . $after_title;
?>
			
            <div class="thumbnail"><img class="avatar" src="<?php echo ( $grateful_option['blog_avatar']['url'] ? esc_url( $grateful_option['blog_avatar']['url'] ) : get_template_directory_uri().'/images/avatar.jpg' ); ?>" alt="" /></div>
	       	
	       	<p>
				<?php 
				if ( $grateful_option['blog_description'] ) {
					echo wpautop( esc_attr( $grateful_option['blog_description'] ) );
				}
				?>
			</p>

			<div class="social">
		        <ul>
					<?php if ( $grateful_option['url_facebook'] ) : ?>
						<li><a href="<?php echo $grateful_option['url_facebook']; ?>" target="_blank"><i class="typcn typcn-social-facebook"></i></a></li>
					<?php endif; ?>
					<?php if ( $grateful_option['url_twitter'] ) : ?>
						<li><a href="<?php echo $grateful_option['url_twitter']; ?>" target="_blank"><i class="typcn typcn-social-twitter"></i></a></li>
					<?php endif; ?>
					<?php if ( $grateful_option['url_instagram'] ) : ?>
						<li><a href="<?php echo $grateful_option['url_instagram']; ?>" target="_blank"><i class="typcn typcn-social-instagram"></i></a></li>
					<?php endif; ?>
					<?php if ( $grateful_option['url_gplus'] ) : ?>
						<li><a href="<?php echo $grateful_option['url_gplus']; ?>" target="_blank"><i class="typcn typcn-social-google-plus"></i></a></li>
					<?php endif; ?>
					<?php if ( $grateful_option['url_linkedin'] ) : ?>
						<li><a href="<?php echo $grateful_option['url_linkedin']; ?>" target="_blank"><i class="typcn typcn-social-linkedin"></i></a></li>
					<?php endif; ?>
					<?php if ( $grateful_option['url_pinterest'] ) : ?>
						<li><a href="<?php echo $grateful_option['url_pinterest']; ?>" target="_blank"><i class="typcn typcn-social-pinterest"></i></a></li>
					<?php endif; ?>
					<?php if ( $grateful_option['url_flickr'] ) : ?>
						<li><a href="<?php echo $grateful_option['url_flickr']; ?>" target="_blank"><i class="typcn typcn-social-flickr"></i></a></li>
					<?php endif; ?>
					<?php if ( $grateful_option['url_youtube'] ) : ?>
						<li><a href="<?php echo $grateful_option['url_youtube']; ?>" target="_blank"><i class="typcn typcn-social-youtube"></i></a></li>
					<?php endif; ?>
	            </ul>
            </div>
<?php
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['warrior_about_title'] = strip_tags( $new_instance['warrior_about_title'] );

		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array('warrior_about_title' => __('About this blog', 'grateful')) );
	?>
        <p>
            <label for="<?php echo $this->get_field_id( 'warrior_about_title' ); ?>"><?php _e('Title:', 'grateful'); ?></label>
            <input type="text" id="<?php echo $this->get_field_id( 'warrior_about_title' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'warrior_about_title' ); ?>" value="<?php echo $instance['warrior_about_title']; ?>" />
        </p>
        <p><?php echo sprintf(__('This widget will display the data configured in the <a href="%s" target="_blank">Theme Options</a>.', 'grateful'), get_admin_url('/admin.php?page=warriorpanel&tab=4') ); ?></p>
	<?php
	}
}
?>