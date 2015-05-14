<?php
/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */

if ( ! function_exists( 'warrior_wp_title' ) ) {
	function warrior_wp_title( $title, $sep ) {
		if ( is_feed() ) {
			return $title;
		}
		
		global $page, $paged;

		// Add the blog name
		$title .= get_bloginfo( 'name', 'display' );

		// Add the blog description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) ) {
			$title .= " $sep $site_description";
		}

		// Add a page number if necessary:
		if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
			$title .= " $sep " . sprintf( __( 'Page %s', '_s' ), max( $paged, $page ) );
		}

		return $title;
	}
}
add_filter( 'wp_title', 'warrior_wp_title', 10, 2 );

/**
 * Function to collect the title of the current page
 *
 * @package WordPress
 * @subpackage Grateful
 * @since Grateful 1.0.0
 */
if ( ! function_exists( 'grateful_archive_title' ) ) {
	function grateful_archive_title() {
		global $wp_query;

		$title = '';
		if ( is_category() ) :
			$title = sprintf( __( 'Category Archives: %s', 'grateful' ), single_cat_title( '', false ) );
		elseif ( is_tag() ) :
			$title = sprintf( __( 'Tag Archives: %s', 'grateful' ), single_tag_title( '', false ) );
		elseif ( is_tax() ) :
			$title = sprintf( __( '%s Archives', 'grateful' ), get_post_format_string( get_post_format() ) );
		elseif ( is_day() ) :
			$title = sprintf( __( 'Daily Archives: %s', 'grateful' ), date_i18n() );
		elseif ( is_month() ) :
			$title = sprintf( __( 'Monthly Archives: %s', 'grateful' ), date_i18n( 'F Y' ) );
		elseif ( is_year() ) :
			$title = sprintf( __( 'Yearly Archives: %s', 'grateful' ), date_i18n( 'Y' ) );
		elseif ( is_author() ) :
			$author = get_user_by( 'slug', get_query_var( 'author_name' ) );
			$title = sprintf( __( 'Author Archives: %s', 'grateful' ), get_the_author_meta( 'display_name', $author->ID ) );
		elseif ( is_search() ) :
			if ( $wp_query->found_posts ) {
				$title = sprintf( __( 'Search Results for: "%s"', 'grateful' ), esc_attr( get_search_query() ) );
			} else {
				$title = sprintf( __( 'No Results for: "%s"', 'grateful' ), esc_attr( get_search_query() ) );
			}
		elseif ( is_404() ) :
			$title = __( 'Not Found', 'grateful' );
		else :
			$title = __( 'Blog', 'grateful' );
		endif;
		
		return $title;
	}
}


/**
 * Function to display post meta info such as post date, author etc
 *
 * @package WordPress
 * @subpackage Grateful
 * @since Grateful 1.0.0
 */
if ( ! function_exists( 'warrior_post_meta' ) ) {
	function warrior_post_meta() {
		global $grateful_option;
	?>

		<?php if( $grateful_option['display_author_name'] || $grateful_option['display_post_date'] || $grateful_option['display_category'] || $grateful_option['display_reading_time'] || $grateful_option['post_carousel_slider'] ) : ?>
			<div class="meta">
				<?php if( $grateful_option['display_post_date'] ) : ?>
					<span><i class="typcn typcn-calendar"></i> <?php echo date_i18n( 'M jS, Y', strtotime( get_the_date('Y-m-d'), false ) ); ?></span>
				<?php endif; ?>

				<?php if( $grateful_option['display_category'] ) : ?>
					<span class="category"><i class="typcn typcn-bookmark"></i> <?php the_category(', ') ?></span>
				<?php endif; ?>

				<?php if( ! is_single() && $grateful_option['display_author_name'] ) : ?>
					<span><i class="typcn typcn-user"></i> <?php the_author(); ?></span>
				<?php endif; ?>			
				
				<?php if( ! is_single() && $grateful_option['display_reading_time'] ) : ?>
					<span><i class="typcn typcn-time"></i> <?php echo warrior_reading_time(); ?></span>
				<?php endif; ?>

				<?php if( is_single() && $grateful_option['display_modified_time'] ) : ?>
					<span><i class="typcn typcn-time"></i> <?php _e('Last modified', 'grateful'); ?> <?php echo human_time_diff( get_the_modified_date('U'), current_time('timestamp') ) . __(' ago', 'grateful'); ?></span>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	<?php
	}
}


/**
 * Function to load comment list
 *
 * @package WordPress
 * @subpackage Grateful
 * @since Grateful 1.0.0
 */
if ( ! function_exists( 'warrior_comment_list' ) ) {
	function warrior_comment_list($comment, $args, $depth) {
		global $post;
		$author_post_id = $post->post_author;
		$GLOBALS['comment'] = $comment;

		// Allowed html tags will be display
		$allowed_html = array(
			'a' => array( 'href' => array(), 'title' => array() ),
			'abbr' => array( 'title' => array() ),
			'acronym' => array( 'title' => array() ),
			'strong' => array(),
			'b' => array(),
			'blockquote' => array( 'cite' => array() ),
			'cite' => array(),
			'code' => array(),
			'del' => array( 'datetime' => array() ),
			'em' => array(),
			'i' => array(),
			'q' => array( 'cite' => array() ),
			'strike' => array(),
			'ul' => array(),
			'ol' => array(),
			'li' => array()
		);
		
		switch ( $comment->comment_type ) :
			case '' :
	?>
		<li id="comment-<?php comment_ID() ?>" <?php comment_class(); ?>>
			<div class="thumbnail"><?php echo get_avatar( $comment, 120 ); ?></div><!-- .comment-author -->

			<div class="comment-detail">
				<div class="author">
					<?php comment_author_link(); ?>
					<span>-</span> <time><?php echo get_comment_date('M jS, Y'); ?></time>
				</div>
				
				<?php if ($comment->comment_approved == '0') : ?>
					<p class="moderate"><?php _e('Your comment is now awaiting moderation before it will appear on this post.', 'grateful');?></p>
				<?php endif; ?>
				<?php echo apply_filters('comment_text', wp_kses( get_comment_text(), $allowed_html ) );  ?>
				
				<div class="reply">
					<?php echo comment_reply_link(array('reply_text' => __('Reply', 'grateful'), 'depth' => $depth, 'max_depth' => $args['max_depth'] )); ?>

					<?php edit_comment_link(__('Edit Comment', 'grateful'), '', ''); ?>		
				</div><!-- .reply -->
			</div><!-- .comment-metadata --><!-- .comment-content -->

		</li><!-- #comment-## -->

	<?php
			break;
			case 'pingback'  :
			case 'trackback' :
	?>
		<li id="comment-<?php comment_ID() ?>" <?php comment_class(); ?>>
			<div class="comment-detail">
				<div class="author">
					<?php comment_author(); ?>
					<span>-</span> <time><?php echo get_comment_date('M jS, Y'); ?></time>
				</div>

				<a href="<?php comment_author_url()?>"><?php _e('Pingback', 'grateful'); ?></a>
				
				<div class="reply">
					<?php edit_comment_link(__('Edit Comment', 'grateful'), '', ''); ?>		
				</div><!-- .reply -->
			</div>
		</li>	
	<?php
			break;
		endswitch;
	}
}


if ( ! function_exists( 'warrior_comment_form_top' ) ) {
	function warrior_comment_form_top() {
	?>
	<div class="comment-form-wrapper">
	<?php
	}
	add_action( 'comment_form_top', 'warrior_comment_form_top' );

	function warrior_comment_form_bottom() {
	?>
	</div>
	
	<?php
	}
}
add_action( 'comment_form', 'warrior_comment_form_bottom', 1 );


/**
 * Warrior gallery slider function
 *
 * @package WordPress
 * @subpackage Grateful
 * @since Grateful 1.0.0
 */

if ( ! function_exists( 'warrior_gallery' ) ) {
	function warrior_gallery($content, $attr) {
		if ( get_post_format() == 'gallery' ) {
			$post = get_post();
			static $instance = 0;
			$instance++;
			
			if ( isset( $attr['orderby'] ) ) :
				$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
				if ( !$attr['orderby'] )
					unset( $attr['orderby'] );
			endif;

			extract(shortcode_atts(array(
				'order'      => 'ASC',
				'orderby'    => 'menu_order ID',
				'id'         => $post ? $post->ID : 0,
				'size'       => 'blog-image',
				'include'    => '',
				'exclude'    => ''
			), $attr));

			$id = intval($id);
			if ( 'RAND' == $order )
				$orderby = 'none';

			if ( !empty($include) ) {
				$_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

				$attachments = array();
				foreach ( $_attachments as $key => $val ) {
					$attachments[$val->ID] = $_attachments[$key];
				}
			} elseif ( !empty($exclude) ) {
				$attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
			} else {
				$attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
			}

			if ( empty($attachments) )
				return '';

			if ( is_feed() ) {
				$output = "\n";
				foreach ( $attachments as $att_id => $attachment )
					$output .= wp_get_attachment_image($att_id, $size) . "\n";
				return $output;
			}

			$output = "
				<div id='gallery-{$instance}' class='gallery galleryid-{$id} gallery-slider'>
					<ul class='slides'>";

			$i = 0;
			foreach ( $attachments as $id => $attachment ) {
				if ( ! empty( $attr['link'] ) && 'file' === $attr['link'] )
					$image_output = wp_get_attachment_image( $id, $size );
				elseif ( ! empty( $attr['link'] ) && 'none' === $attr['link'] )
					$image_output = wp_get_attachment_image( $id, $size );
				else
					$image_output = wp_get_attachment_image( $id, $size );

				$image_meta  = wp_get_attachment_metadata( $id );

				$output .= "<li class='gallery-item'>\n";
				$output .= "$image_output";
				$output .= "</li>\n";
			}
			$output .= "
					</ul>
				</div>";

			return $output;
		}
	}
}
add_filter( 'post_gallery', 'warrior_gallery', 10, 2 );


/**
 * Add class on posts prev & next
 *
 * @package WordPress
 * @subpackage Grateful
 * @since Grateful 1.0.0
 */

if ( ! function_exists( 'next_posts_link_class' ) ) {
	function next_posts_link_class() {
	    return 'class="next"';
	}
}
add_filter('next_posts_link_attributes', 'next_posts_link_class');


if ( ! function_exists( 'previous_posts_link_class' ) ) {
	function previous_posts_link_class() {
	    return 'class="prev"';
	}
}
add_filter('previous_posts_link_attributes', 'previous_posts_link_class');


/**
 * Function to get the first link from a post. Based on the codes from WP Recipes 
 * http://www.wprecipes.com/wordpress-tip-how-to-get-the-first-link-in-post
 *
 * @package WordPress
 * @subpackage Grateful
 * @since Grateful 1.0.0
 */
if ( ! function_exists( 'get_link_url' ) ) {
	function get_link_url() {
	    $content = get_the_content();
	    $has_url = get_url_in_content( $content );

	    return ( $has_url ) ? $has_url : apply_filters( 'the_permalink', get_permalink() );
	}
}


/**
 * Function to check if the post is sticky or not
 *
 * @package WordPress
 * @subpackage Grateful
 * @since Grateful 1.0.0
 */
if ( ! function_exists( 'check_sticky' ) ) {
	function check_sticky() {
	?>
		<?php if ( is_sticky() ) : ?>
			<span class="sticky-sticker"><?php _e('Sticky Post', 'grateful'); ?></span>
		<?php endif; ?>
	<?php	
	}
}


/**
 * Add custom CSS styles to header
 *
 * @package WordPress
 * @subpackage grateful
 * @since grateful 1.0.0
 */
if ( ! function_exists( 'warrior_custom_css' ) ) {
	function warrior_custom_css() {
		global $grateful_option;

		if ( $grateful_option['custom_css'] ) {
			echo '<style type="text/css">';
			echo $grateful_option['custom_css'];
			echo '</style>';
		}
	}
}
add_action( 'wp_head', 'warrior_custom_css' );

/**
 * Estimate post reading time
 *
 * @package WordPress
 * @subpackage Grateful
 * @since Grateful 1.0.0
 */
if( !function_exists( 'warrior_reading_time ') ) {
	function warrior_reading_time() {
		global $post;    
		
		$text = get_post_field( 'post_content', $post->ID );
	    $words = str_word_count( esc_attr($text) );
		$min = floor( $words / 200 );
		
		if( $min == 0 ) {
			return __('1 min read', 'grateful');
		}
		
		return $min . __(' min read', 'grateful');
	}
}


/**
 * Change default excerpt more text
 *
 * @package WordPress
 * @subpackage Grateful
 * @since Grateful 1.0.0
 */
if( !function_exists( 'warrior_excerpt_more ') ) {
	function warrior_excerpt_more( ) {
		return '...';
	}
}
add_filter( 'excerpt_more', 'warrior_excerpt_more', 999 );


/**
 * Change default excerpt length
 *
 * @package WordPress
 * @subpackage Grateful
 * @since Grateful 1.0.0
 */
if( !function_exists( 'warrior_excerpt_length ') ) {
	function warrior_excerpt_length( $length ) {
		global $grateful_option;

		return $grateful_option['post_excerpt_length'];
	}
}
add_filter( 'excerpt_length', 'warrior_excerpt_length', 999 );

/**
 * Facebook Open Graph Generator
 *
 * @package WordPress
 * @subpackage Grateful
 * @since Grateful 1.0.0
 */
if( ! function_exists('warrior_open_graph') ) {
	function warrior_open_graph() {
	    echo '<meta property="og:title" content="' . get_the_title() . '" />';
	    echo '<meta property="og:site_name" content="' . get_bloginfo('name') . '" />';
		global $post;
        
        echo '<meta property="og:type" content="article" />';
        echo '<meta property="og:url" content="' . get_permalink() . '" />';
        echo '<meta property="og:description" content="' . esc_attr( strip_tags( wp_trim_words( $post->post_content, 65, '' ) ) ) . '" />';
		
		if (has_post_thumbnail( $post->ID )) { // use featured image if there is one
	        $feat_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' );
	        echo '<meta property="og:image" content="' . esc_attr( $feat_image[0] ) . '" />';
		} else {
	        echo '<meta property="og:image" content="http://placehold.it/500x400&amp;text='. __('No Thumbnail', 'grateful') .'" />';
		}
	}
}
add_action( 'wp_head', 'warrior_open_graph' );

/**
 * This function returns an ID based on the provided chat author name.  It keeps these IDs in a global 
 * array and makes sure we have a unique set of IDs.  The purpose of this function is to provide an "ID"
 * that will be used in an HTML class for individual chat rows so they can be styled.  So, speaker "John" 
 * will always have the same class each time he speaks.  And, speaker "Mary" will have a different class 
 * from "John" but will have the same class each time she speaks.
 *
 * @author David Chandra
 * @link http://www.turtlepod.org
 * @author Justin Tadlock
 * @link http://justintadlock.com
 * @copyright Copyright (c) 2012
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * @link http://justintadlock.com/archives/2012/08/21/post-formats-chat
 *
 * @global array $_post_format_chat_ids An array of IDs for the chat rows based on the author.
 * @param string $chat_author Author of the current chat row.
 * @return int The ID for the chat row based on the author.
 */
function my_format_chat_row_id( $chat_author ) {
	global $_post_format_chat_ids;

	/* Let's sanitize the chat author to avoid craziness and differences like "John" and "john". */
	$chat_author = strtolower( strip_tags( $chat_author ) );

	/* Add the chat author to the array. */
	$_post_format_chat_ids[] = $chat_author;

	/* Make sure the array only holds unique values. */
	$_post_format_chat_ids = array_unique( $_post_format_chat_ids );

	/* Return the array key for the chat author and add "1" to avoid an ID of "0". */
	return absint( array_search( $chat_author, $_post_format_chat_ids ) ) + 1;
}

/**
 * Function to get twitter update
 *
 * @package WordPress
 * @subpackage Grateful
 * @since Grateful 1.0.0
 */
if( ! function_exists('warrior_get_recent_tweets') ) {
	function warrior_get_recent_tweets( $screen_name = '', $consumer_key = '', $consumer_secret = '', $tweets_count = 5 ) {

		if ( !$screen_name)
			return false;
		
		// some variables
		$token = get_option('warriorTwitterToken'.$screen_name);

		// get recent tweets from cache
		$recent_tweets = get_transient('warriorRecentTweets'.$screen_name);

		// cache version does not exist or expired
		if (false === $recent_tweets) {

			// getting new auth bearer only if we don't have one
			if(!$token) {

				// preparing credentials
				$credentials = $consumer_key . ':' . $consumer_secret;
				$toSend = base64_encode($credentials);
	 
				// http post arguments
				$args = array(
					'method' => 'POST',
					'httpversion' => '1.1',
					'blocking' => true,
					'headers' => array(
						'Authorization' => 'Basic ' . $toSend,
						'Content-Type' => 'application/x-www-form-urlencoded;charset=UTF-8'
					),
					'body' => array( 'grant_type' => 'client_credentials' )
				);
	 
				add_filter('https_ssl_verify', '__return_false');
				$response = wp_remote_post('https://api.twitter.com/oauth2/token', $args);

				$keys = json_decode(wp_remote_retrieve_body($response));

				if($keys) {
					// saving token to wp_options table
					update_option('warriorTwitterToken'.$screen_name, $keys->access_token);
					$token = $keys->access_token;
				}
			}

			// we have bearer token wether we obtained it from API or from options
			$args = array(
				'httpversion' => '1.1',
				'blocking' => true,
				'headers' => array(
					'Authorization' => "Bearer $token"
				)
			);

			add_filter('https_ssl_verify', '__return_false');
			$api_url = "https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=$screen_name&count=$tweets_count";
			$response = wp_remote_get($api_url, $args);
	 
			if (!is_wp_error($response)) {
				$tweets = json_decode(wp_remote_retrieve_body($response));

				if(!empty($tweets)){
					for($i=0; $i<count($tweets); $i++){
						$recent_tweets[] = array(
							'text' 						=> $tweets[$i]->text, 
							'created_at' 				=> $tweets[$i]->created_at, 
							'status_id' 				=> $tweets[$i]->id_str
						);
					}
				}			
			}
			
			// cache for an hour
			set_transient('warriorRecentTweets'.$screen_name, $recent_tweets, 1*60*60);
		}

		return $recent_tweets;

	}
}

/**
 * Function to replace replace permalink on tweet
 *
 * @package WordPress
 * @subpackage Grateful
 * @since Grateful 1.0.0
 */

if( ! function_exists('warrior_twitter_links') ) {
	function warrior_twitter_links($tweet_text) {
		$tweet_text = preg_replace("#(^|[\n ])([\w]+?://[\w]+[^ \"\n\r\t< ]*)#", "\\1<a href=\"\\2\" target=\"_blank\">\\2</a>", $tweet_text);
		$tweet_text = preg_replace("#(^|[\n ])((www|ftp)\.[^ \"\t\n\r< ]*)#", "\\1<a href=\"http://\\2\" target=\"_blank\">\\2</a>", $tweet_text);
		$tweet_text = preg_replace("/@(\w+)/", "<a href=\"http://twitter.com/\\1\" target=\"_blank\">@\\1</a>", $tweet_text);
		$tweet_text = preg_replace("/#(\w+)/", "<a href=\"http://twitter.com/search?q=\\1\" target=\"_blank\">#\\1</a>", $tweet_text);
		return $tweet_text;
	}
}
?>