<?php
/**
 * The template for displaying Author bios
 */

if( ! koganic_get_option('show-author-bio', 1) ) return;
?>

<div class="author-info">
	<div class="author-avatar">
		<?php
		$author_bio_avatar_size = apply_filters( 'koganic_author_bio_avatar_size', 74 );
		echo get_avatar( get_the_author_meta( 'user_email' ), $author_bio_avatar_size );
		?>
	</div><!-- .author-avatar -->
	<div class="author-description">
		<h2 class="author-title"><?php printf( esc_html__( 'About %s', 'koganic' ), get_the_author() ); ?></h2>
		<p class="author-bio">
			<?php the_author_meta( 'description' ); ?>
			<a class="author-link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
				<?php printf( wp_kses( esc_html__( 'View all posts by %s <span class="meta-nav">&rarr;</span>', 'koganic' ), array( 'span' => array('class') ) ), get_the_author() ); ?>
			</a>
		</p>
	</div><!-- .author-description -->
</div><!-- .author-info -->
