<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */
if ( post_password_required() )
	return;
?>

<div id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
				esc_html_e('Comments','koganic');
			?>			
		</h2>

		<ol class="comment-list">
			<?php
				wp_list_comments( array(
				 'style'    => 'ol',
				 'callback' => 'koganic_comments_list',
				) );
			?>
		</ol><!-- .comment-list -->

		<?php
			// Are there comments to navigate through?
			if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
		?>
		<nav class="navigation comment-navigation" role="navigation">
			<h1 class="screen-reader-text section-heading"><?php esc_html_e( 'Comment navigation', 'koganic' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( esc_html__( '&larr; Older Comments', 'koganic' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments &rarr;', 'koganic' ) ); ?></div>
		</nav><!-- .comment-navigation -->
		<?php endif; // Check for comment navigation ?>

		<?php if ( ! comments_open() && get_comments_number() ) : ?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.' , 'koganic' ); ?></p>
		<?php endif; ?>

	<?php endif; ?>

	<?php

		$args = array(

		    'title_reply'=> esc_html__( 'Leave A Comment', 'koganic' ),

			// Change the title of send button
			'label_submit'=> esc_html__( 'Submit Now', 'koganic' ),

		    'comment_field' => '<p class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="4" aria-required="true" placeholder="'.esc_attr__('Your comment...','koganic').'"></textarea></p>',

		     'fields' => apply_filters( 'comment_form_default_fields', array(

			    'author' =>
			      '<p class="comment-form-author"><input id="author" name="author" type="text" value="" size="30" placeholder="'.esc_attr__('Your name','koganic').'" /></p>',

			    'email' =>
			      '<p class="comment-form-email"><input id="email" name="email" type="text" value="" size="30" placeholder="'.esc_attr__('Your email','koganic').'"/></p>',

			    'url' =>
			      '<p class="comment-form-url"><input id="url" name="url" type="text" value="" size="30" placeholder="'.esc_attr__('Your website','koganic').'"/></p>',
		    )),

		);

		comment_form( $args );
	?>

</div><!-- #comments -->
