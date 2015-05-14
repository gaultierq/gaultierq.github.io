<?php
/**
 * The Template for displaying pagination
 *
 * @package WordPress
 * @subpackage Grateful
 * @since Grateful 1.0.0
 */
?>

<?php global $wp_query, $grateful_option; if($wp_query->max_num_pages > 1) : ?>

<!-- Start: Pagination -->
<div class="page-navigation">
	<?php
	next_posts_link( '<i class="typcn typcn-arrow-left"></i>'. __('Older Posts', 'grateful') );
	previous_posts_link( __('Newer Posts', 'grateful') .'<i class="typcn typcn-arrow-right"></i>' );
	?>
</div>
<!-- End: Pagination -->
<?php endif; ?>