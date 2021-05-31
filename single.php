<?php
get_header();

$content_class = $sidebar_class = $layout_classes = '';

// Get blog options
$smart_sidebar        = koganic_get_option( 'smart-sidebar', 0 );
$blog_single_layout   = koganic_get_option('blog-single-layout', 'left');
$blog_design     = koganic_get_option( 'blog-design', 'default' );
$show_featured_image  = koganic_get_option('show-feature-image', 1);
$show_post_navigation = koganic_get_option('show-post-navigation', 1);
$show_related_posts   = koganic_get_option('show-related-posts', 1);

// DEMO
if ( isset($_GET['sidebar']) && $_GET['sidebar'] != '' ) {
	$blog_single_layout = $_GET['sidebar'];
}


if( isset( $blog_design ) && $blog_design != '' && $blog_design == 'default') {
	$content_class = 'col-lg-8';
}

if( isset( $blog_design ) && $blog_design != '' && $blog_design != 'default') {
	$content_class = 'col-lg-12 masonry-blog';
}


// Render columns number
if ( $blog_single_layout == 'left' && is_active_sidebar( 'primary-sidebar' ) ) {
	$content_class .= ' col-lg-8 col-md-8 col-sm-12 col-xs-12';
	$sidebar_class = 'col-lg-4 col-md-4 col-sm-12 col-xs-12';
	$layout_classes = 'left-sidebar';
} elseif ( $blog_single_layout == 'right' && is_active_sidebar( 'primary-sidebar' )) {
	$content_class .= ' col-lg-8 col-md-8 col-sm-12 col-xs-12';
	$sidebar_class = 'col-lg-4 col-md-4 col-sm-12 col-xs-12';
	$layout_classes = 'right-sidebar';
} elseif ( $blog_single_layout == 'no' || !is_active_sidebar( 'primary-sidebar' ) ) {
	$content_class .= ' col-md-12 col-sm-12 col-xs-12 no-sidebar unset-float';
	$sidebar_class = '';
}

if ( isset($smart_sidebar) && $smart_sidebar == 1 ) {
	$sidebar_class .= ' smart-sidebar';
}

?>

<div class="page-content">
	<div class="container mt_80 mb_80">
		<div class="row <?php echo esc_attr($layout_classes); ?>">

			<div id="main-content" class="<?php echo esc_attr( $content_class ); ?>">
				<?php
                while ( have_posts() ) : the_post();
					?>
					<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-single-page' ); ?>>
						<div class="article-inner">
							<?php if ( $show_featured_image == 1 ) : ?>
								<?php if ( has_post_thumbnail() && ! post_password_required() && ! is_attachment() ) : ?>
								<header class="entry-header pr">
									<figure class="entry-thumbnail">
										<div class="post-img-wrap">
											<div class="post-date-timer">
												<span><?php echo get_the_date('j'); ?></span>
												<span><?php echo get_the_date('M'); ?></span>
											</div>											
											<?php echo koganic_get_post_thumbnail( 'large' ); ?>
										</div>
									</figure>
								</header><!-- .entry-header -->
								<?php endif; ?>
							<?php endif; ?>

							<div class="single-heading">
					            <h1 class="entry-title"><?php the_title(); ?></h1>

								<?php
								$show_author     = koganic_get_option('show-author', 1);
						        $show_comments   = koganic_get_option('show-comment', 1);
						        $show_categories = koganic_get_option('show-category', 1);
						        $show_post_view   = koganic_get_option('show-post-view', 0);
								?>

								<ul class="entry-meta-list">
									<?php if( get_post_type() === 'post' ): ?>
										<?php // Author ?>
										<?php if ($show_author == 1): ?>
											<li class="meta-author">
												<?php esc_html_e('Posted: by', 'koganic'); ?>
												<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author"><?php echo get_the_author(); ?></a>
											</li>
										<?php endif ?>

										 <?php if ( $show_post_view == 1 ) { ?>
						                    <li class="entry-view">
						                        <?php echo koganic_get_post_views(get_the_ID()); ?>
						                    </li>
					                    <?php } ?>
					                    
										<?php // Comments ?>
										<?php if( $show_comments && comments_open() ): ?>
											<li class="meta-comment">
												<?php
													$comment_link_template = '<span class="comments-count">%s %s</span>';
												 ?>
												<?php comments_popup_link(
													sprintf( $comment_link_template, '0', esc_html__( 'comments', 'koganic' ) ),
													sprintf( $comment_link_template, '1', esc_html__( 'comment', 'koganic' ) ),
													sprintf( $comment_link_template, '%', esc_html__( 'comments', 'koganic' ) )
												); ?>
											</li>
										<?php endif; ?>
									<?php endif; ?>
								</ul>								
							</div>

							<div class="article-body-container">
								<div class="entry-content koganic-entry-content">
									<?php the_content(); ?>
								</div>
								<div class="clearfix"></div>
					        </div>

							<?php
							wp_link_pages( array(
								'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'koganic' ) . '</span>',
								'after'       => '</div>',
								'link_before' => '<span>',
								'link_after'  => '</span>',
								'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'koganic' ) . ' </span>%',
								'separator'   => '<span class="screen-reader-text">, </span>',
							) );
							?>

							<?php if ( is_single() && get_the_author_meta( 'description' ) ) : ?>
								<footer class="entry-author">
									<?php get_template_part( 'author-biography' ); ?>
								</footer><!-- .entry-author -->
							<?php endif; ?>

						</div>
					</article><!-- #post-# -->

					<div class="flex-bottom-share <?php echo (koganic_check_tags_unittest()) ? '' : 'no-tags'; ?>">
						<?php if( get_the_tag_list( '', ', ' ) ): ?>
						<div class="koganic-single-bottom flex between-xs">
							<div class="single-meta-tags flex middle-xs">
								<span class="tags-title mr_10"><?php esc_html_e('Tags', 'koganic'); ?>:</span>
								<div class="tags-list">
									<?php echo get_the_tag_list( '', ', ' ); ?>
								</div>
							</div>
						</div>
						<?php endif; ?>

						<div class="single-social-share">
							<?php koganic_social_icons(); ?>
						</div>
					</div>

					<?php

					if( isset($show_post_navigation) && $show_post_navigation == 1 ) {
						koganic_post_navigation();
					}

					if( isset($show_related_posts) && $show_related_posts == 1 ) {
					    koganic_related_posts();
					}

					comments_template();

                endwhile; // End of the loop.
				?>
			</div>

			<?php if ( isset( $blog_single_layout ) && $blog_single_layout != 'no' && is_active_sidebar( 'primary-sidebar' ) ) : ?>
				<div id="main-sidebar" class="<?php echo esc_attr( $sidebar_class ); ?>">
					<?php
						if ( is_active_sidebar( 'primary-sidebar' ) ) {
							dynamic_sidebar( 'primary-sidebar' );
						}
					?>
				</div>
			<?php endif; ?>

		</div>
	</div>
</div><!-- page-content -->

<?php get_footer();
