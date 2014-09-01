<?php
/**
 * @package utkblog
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    
<?php 
if (has_post_thumbnail()) {
    echo '<div class="single-post-thumbnail clear">';
    echo '<div class="image-shifter">';
    echo the_post_thumbnail('large-thumb');
    echo '</div>';
    echo '</div>';
}
?>
   
	<header class="entry-header">
            <?php
                /* translators: used between list items, there is a space after the comma */
                $category_list = get_the_category_list( __( ', ', 'utkblog' ) );

                if ( utkblog_categorized_blog() ) {
                    echo '<div class="category-list">' . $category_list . '</div>';
                }
?>
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

		<div class="entry-meta">
		   <?php \utkblog_posted_on(); ?>
                    <?php 
                        if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) { 
                            echo '<span class="comments-link">';
                            comments_popup_link( __( 'Leave a comment', 'utkblog' ), __( '1 Comment', 'utkblog' ), __( '% Comments', 'utkblog' ) );
                            echo '</span>';
                        }
                        ?>      <span class="view-num">
                             <?php if(function_exists('the_views')) { the_views(); } ?></span><!--end of view-num class-->
                               <!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'utkblog' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php
                     echo get_the_tag_list( '<ul><li><i class="fa fa-tags"></i>', '</li><li><i class="fa fa-tags"></i>', '</li></ul>' );
                ?>
		<?php edit_post_link( __( 'Edit', 'utkblog' ), '<span class="edit-link">', '</span>' ); ?>
            
                <div id="authorbox">
                    <?php if (function_exists('get_avatar')) { echo get_avatar( get_the_author_email(), '80' ); }?>
                        <div class="authortext">
                            <h4>Posted by <?php the_author_posts_link(); ?></h4>
                            <p><?php the_author_description(); ?></p>
                        </div>
                </div>
               <!-- <div class="auth-description">
                    <img alt src="http://0.gravatar.com/avatar/cbe09fe34fa324aadb0dd534498b94be" class="auth-av"/>
                
                    <p class="auth-p">Posted by <a href="http://gravatar.com/utkarsh03">Utkarsh Upadhyay</a><br></p>

                </div>-->
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
