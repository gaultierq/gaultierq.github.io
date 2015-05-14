<?php 
/**
 * The template for displaying comments
 *
 * @package WordPress
 * @subpackage Grateful
 * @since Grateful 1.0.0
 */

// Do not delete these lines
if ('comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die (_e('Please do not load this page directly. Thanks!', 'grateful'));

	if (!empty($post->post_password)) { // if there's a password
		if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {  // and it doesn't match the cookie
?>
	<p class="nocomments"><?php _e('This post is password protected. Enter the password to view comments.', 'grateful') ; ?></p>
<?php
		return;
		}
	}
?>

<?php if ( have_comments() ) : ?>

    <!-- START: COMMENT LIST -->
    <div id="comment-widget" class="comments box">
		<h3 class="widget-title"><?php comments_number( __('There\'s No Comments', 'grateful'), __('There\'s 1 Comment', 'grateful'), __('There Are % Comments', 'grateful') ); ?></h3>
        <div class="comments-list">
            <ul>
                <?php wp_list_comments('callback=warrior_comment_list'); ?>
            </ul>
        </div>
        
		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
			<div class="navigation clearfix">
				<span class="prev"><?php previous_comments_link(__('&larr; Previous', 'grateful'), 0); ?></span>
				<span class="next"><?php next_comments_link(__('Next &rarr;', 'grateful'), 0); ?></span>
			</div>	
		<?php endif; ?>
    </div>
    <!-- END: COMMENT LIST -->
    
<?php else : // or, if we don't have comments: ?>
		
<?php endif; // end have_comments() ?> 

	<!-- START: RESPOND -->
    <?php if ( comments_open() ) : ?>
        <div id="comment-form-widget" class="comments box">
            <?php 
                comment_form( array(
                    'title_reply'			=>	'<h3 class="widget-title">'. __( 'Leave a Comment', 'grateful').'</h3>',
                    'comment_notes_before'	=>	'',
                    'comment_notes_after'	=>	'',
                    'label_submit'			=>	__( 'Submit', 'grateful' ),
                    'cancel_reply_link'		=>  __( 'Cancel Reply', 'grateful' ),
        			'logged_in_as'			=>  '<p class="logged-user">' . sprintf( __( 'You are logged in as <a href="%1$s">%2$s</a> &#8212; <a href="%3$s">Logout &raquo;</a>', 'grateful' ), admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) ) ) . '</p>',
                    'fields'				=> array(
                        'author'				=>	'<div class="input name"><label>'. __('Name', 'grateful') .'<span class="red">*</span></label><input type="text" name="author" id="input-name" class="input-s" value=""/></div>',
                        'email'					=>	'<div class="input email"><label>'. __('Email', 'grateful') .'<span class="red">*</span></label><input type="text" name="email" id="input-email" class="input-s" value=""/></div>',
                        'url'					=>	'<div class="input email"><label>'. __('Website URL', 'grateful') .'</label><input type="text" name="url" id="input-email" class="input-s" value=""/></div>'
        									),
                    'comment_field'			=>	'<div class="input message"><label>'. __('Message', 'grateful') .'</label><textarea name="comment" id="message"></textarea></div>'
                    ));
            ?>
        </div>
	<?php endif; ?>
 	<!-- END: RESPOND -->