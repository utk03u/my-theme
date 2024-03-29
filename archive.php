<?php
/**
 * The template for displaying Archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package utkblog
 */

get_header(); ?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title">
					<?php
                                        if ( is_category() ) :
                                            printf( __( 'Posts in the ', 'utkblog' ) );
                                            echo '<em>';
                                            single_cat_title();
                                            echo '</em> ' . __('category', 'utkblog') . ':';

                                        elseif ( is_tag() ) :
                                            printf( __( 'Posts with the ', 'utkblog' ) );
                                            echo '<em>';
                                            single_tag_title();
                                            echo '</em> ' . __('tag', 'utkblog') . ':';

                                        elseif ( is_author() ) :
                                            printf( __( 'Author: %s', 'utkblog' ), '<span class="vcard">' . get_the_author() . '</span>' );

                                        elseif ( is_day() ) :
                                            printf( __( 'Posts from %s', 'utkblog' ), '<span>' . get_the_date() . '</span>' );

                                        elseif ( is_month() ) :
                                            printf( __( 'Posts from %s', 'utkblog' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'utkblog' ) ) . '</span>' );

                                        elseif ( is_year() ) :
                                            printf( __( 'Posts from %s', 'utkblog' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'utkblog' ) ) . '</span>' );

                                        elseif ( is_tax( 'post_format', 'post-format-aside' ) ) :
                                            _e( 'Asides', 'utkblog' );

                                        else :
                                            _e( 'Archives', 'utkblog' );

                                        endif;
                                        ?>
				</h1>
				<?php
					// Show an optional term description.
					$term_description = term_description();
					if ( ! empty( $term_description ) ) :
						printf( '<div class="taxonomy-description">%s</div>', $term_description );
					endif;
				?>
			</header><!-- .page-header -->

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php
					/* Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					get_template_part( 'content', get_post_format() );
				?>

			<?php endwhile; ?>

			<?php utkblog_paging_nav(); ?>

		<?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>

		<?php endif; ?>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
