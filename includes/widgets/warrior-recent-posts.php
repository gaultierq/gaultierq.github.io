<?php
/**
 * Recent Posts Widgets
 *
 * @package WordPress
 * @subpackage Grateful
 * @since Grateful 1.0.0
 */
 
// Widgets
add_action( 'widgets_init', 'warrior_recent_posts_widget' );

// Register our widget
function warrior_recent_posts_widget() {
	register_widget( 'Warrior_Recent_Posts' );
}

// Warrior Latest Video Widget
class Warrior_Recent_Posts extends WP_Widget {

	//  Setting up the widget
	function Warrior_Recent_Posts() {
		$widget_ops  = array( 'classname' => 'warrior_recent_posts', 'description' => __('Display recent posts with thumbnails.', 'grateful') );
		$control_ops = array( 'id_base' => 'warrior_recent_posts' );

		$this->WP_Widget( 'warrior_recent_posts', __('Warrior Recent Posts', 'grateful'), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		global $grateful_option;
		
		extract( $args );

		$warrior_recent_posts_title = apply_filters('widget_title', $instance['warrior_recent_posts_title'] );
		$warrior_recent_posts_count = !empty( $instance['warrior_recent_posts_count'] ) ? absint( $instance['warrior_recent_posts_count'] ) : 4;
		$warrior_recent_words_count = !empty( $instance['warrior_recent_words_count'] ) ? absint( $instance['warrior_recent_words_count'] ) : 30;
		$warrior_recent_excerpt_count = !empty( $instance['warrior_recent_excerpt_count'] ) ? absint( $instance['warrior_recent_excerpt_count'] ) : 90;


		if ( !$warrior_recent_posts_count )
 			$warrior_recent_posts_count = 4;

		$args_recent_posts = array(
			'post_type' => 'post',
			'post_status' => 'publish',
			'ignore_sticky_posts' => 1,
			'posts_per_page' => $warrior_recent_posts_count
		);

		$warrior_recent_posts = new WP_Query();
		$warrior_recent_posts->query($args_recent_posts);

		if ( $warrior_recent_posts->have_posts() ) :
?>
        <?php echo $before_widget; ?>
        <?php echo $before_title . $warrior_recent_posts_title . $after_title; ?>

		<div class="blocks recent-post-widget">
			<ul>
				<?php while( $warrior_recent_posts->have_posts() ) : $warrior_recent_posts->the_post(); ?>
					<li class="post-<?php the_ID(); ?>">
						<div class="thumbnail">	
							<?php
							// Get featured image
							if ( has_post_thumbnail() ) {
								the_post_thumbnail('thumbnail');
							} else {
								echo '<img src="http://placehold.it/150x150/&amp;text=&nbsp;" />';
							}
							?>
						</div>
						<div class="detail">
							<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
							<div class="meta">
								<?php echo date_i18n( 'M jS, Y', strtotime( get_the_date('Y-m-d'), false ) ); ?>
							</div>
						</div>
					</li>
				<?php endwhile; ?>
			</ul>
		</div>

		<?php echo $after_widget; ?>
<?php
		endif;
		wp_reset_postdata();
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['warrior_recent_posts_title'] 	= strip_tags( $new_instance['warrior_recent_posts_title'] );
		$instance['warrior_recent_posts_count']  	= (int) $new_instance['warrior_recent_posts_count'];
		$instance['warrior_recent_words_count']  	= (int) $new_instance['warrior_recent_words_count'];
		$instance['warrior_recent_excerpt_count']  	= (int) $new_instance['warrior_recent_excerpt_count'];

		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array('warrior_recent_posts_title' => __('Recent Posts', 'grateful'), 'warrior_recent_posts_count' => '5', 'warrior_recent_words_count' => '30', 'warrior_recent_excerpt_count' => '90') );
	?>
        <p>
            <label for="<?php echo $this->get_field_id( 'warrior_recent_posts_title' ); ?>"><?php _e('Widget Title:', 'grateful'); ?></label>
            <input type="text" id="<?php echo $this->get_field_id( 'warrior_recent_posts_title' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'warrior_recent_posts_title' ); ?>" value="<?php echo $instance['warrior_recent_posts_title']; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'warrior_recent_posts_count' ); ?>"><?php _e('Number of posts to show:', 'grateful'); ?></label>
            <input type="text" id="<?php echo $this->get_field_id( 'warrior_recent_posts_count' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'warrior_recent_posts_count' ); ?>" value="<?php echo $instance['warrior_recent_posts_count']; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'warrior_recent_words_count' ); ?>"><?php _e('Post Title Limiter', 'grateful'); ?></label>
            <input type="text" id="<?php echo $this->get_field_id( 'warrior_recent_words_count' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'warrior_recent_words_count' ); ?>" value="<?php echo $instance['warrior_recent_words_count']; ?>" />
            <p><small><?php _e('The post title will be trim after reaching the number of characters defined.', 'grateful'); ?></small></p>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'warrior_recent_excerpt_count' ); ?>"><?php _e('Post Excerpt Limiter', 'grateful'); ?></label>
            <input type="text" id="<?php echo $this->get_field_id( 'warrior_recent_excerpt_count' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'warrior_recent_excerpt_count' ); ?>" value="<?php echo $instance['warrior_recent_excerpt_count']; ?>" />
            <p><small><?php _e('The post excerpt in the first post will be trim after reaching the number of characters defined.', 'grateful'); ?></small></p>
        </p>
	<?php
	}
}
?>