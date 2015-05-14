<?php
/**
 * Template to display sharing buttons
 *
 * @package WordPress
 * @subpackage Grateful
 * @since Grateful 1.0.0
 */

global $grateful_option;
?>

<?php if( $grateful_option['share_buttons'] ) : ?>
	<!-- AddThis Button BEGIN -->
	<div class="share-buttons">
		<div class="addthis_toolbox addthis_default_style">
		<h4><?php _e('Share this Article', 'grateful'); ?></h4>
			<a class="addthis_button_facebook" fb:like:layout="button_count"><span class="typcn typcn-social-facebook"></span></a>
			<a class="addthis_button_twitter"><span class="typcn typcn-social-twitter"></span></a>
			<a class="addthis_button_google_plusone_share" g:plusone:size="medium"><span class="typcn typcn-social-google-plus"></span></a>
			<a class="addthis_button_pinterest_share" pi:pinit:layout="horizontal" pi:pinit:url="<?php echo get_permalink( $post->ID ); ?>"><span class="typcn typcn-social-pinterest"></span></a>
			<a class="addthis_button_email"><span class="typcn typcn-mail"></span></a>
		</div>
	</div>
	<script type="text/javascript">var addthis_config = {"data_track_addressbar":false};</script>
	<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js"></script>
	<!-- AddThis Button END -->
<?php endif; ?>