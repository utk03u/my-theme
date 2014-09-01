<?php
/**
 * @package utkblog
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="index-box">
<?php
if (has_post_thumbnail()) {
    echo '<div class="small-index-thumbnail clear">';
    echo '<a href="' . get_permalink() . '" title="' . __('Read ', 'utkblog') . get_the_title() . '" rel="bookmark">';
    echo the_post_thumbnail('index-thumb');
    echo '</a>';
    echo '</div>';
}
?>
   
	<header class="entry-header">
		<?php the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>

		<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-meta">
			<?php utkblog_posted_on(); ?>
                                <?php 
                                   if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) { 
                                       echo '<span class="comments-link">';
                                       comments_popup_link( __( '&nbsp;Leave a comment', 'utkblog' ), __( '1 Comment', 'utkblog' ), __( '&nbsp;&nbsp;<i class="fa fa-comments"></i>&nbsp;% Comments', 'utkblog' ) );
                                       echo '</span>';
                                   }
                                   ?><br>
                    <?php edit_post_link( __( 'Edit Post', 'utkblog' ), '<span class="edit-link">', '</span>' ); ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_excerpt();?>
			
	</div><!-- .entry-content -->

	<footer class="entry-footer continue-reading">
            
            <?php echo '<a href="' . get_permalink() . '" title="' . __('Continue Reading ', 'utkblog') . get_the_title() . '" rel="bookmark">Continue Reading<i class="fa fa-arrow-circle-o-right"></i></a>'; ?><br>
        
	</footer><!-- .entry-footer -->
        </div>
</article><!-- #post-## -->