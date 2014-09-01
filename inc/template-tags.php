<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package utkblog
 */

if ( ! function_exists( 'utkblog_paging_nav' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 */
function utkblog_paging_nav() {
	// Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}

	$paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
	$pagenum_link = html_entity_decode( get_pagenum_link() );
	$query_args   = array();
	$url_parts    = explode( '?', $pagenum_link );

	if ( isset( $url_parts[1] ) ) {
		wp_parse_str( $url_parts[1], $query_args );
	}

	$pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
	$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

	$format  = $GLOBALS['wp_rewrite']->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
	$format .= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit( 'page/%#%', 'paged' ) : '?paged=%#%';

	// Set up paginated links.
	$links = paginate_links( array(
		'base'     => $pagenum_link,
		'format'   => $format,
		'total'    => $GLOBALS['wp_query']->max_num_pages,
		'current'  => $paged,
		'mid_size' => 2,
		'add_args' => array_map( 'urlencode', $query_args ),
		'prev_text' => __( '<i class="fa fa-chevron-circle-left"></i> Previous', 'utkblog' ),
		'next_text' => __( 'Next <i class="fa fa-chevron-circle-right"></i>', 'utkblog' ),
        'type'      => 'list',
	) );

	if ( $links ) :

	?>
	<nav class="navigation paging-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'twentyfourteen' ); ?></h1>
		
			<?php echo $links; ?>
		<!-- .pagination -->
	</nav><!-- .navigation -->
	<?php
	endif;
}
endif;

if ( ! function_exists( 'utkblog_post_nav' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 */
function utkblog_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<nav class="navigation post-navigation" role="navigation">
                    <div class="post-nav-box clear">
                    <h1 class="screen-reader-text"><?php _e( 'Post navigation', 'utkblog' ); ?></h1>
                    <div class="nav-links">
            <?php
            previous_post_link( '<div class="nav-previous"><div class="nav-indicator">' . _x( '<div class="pos"><i class="fa fa-angle-left fa-3x"></i></div>Previous Post:', 'Previous post', 'utkblog' ) . '</div><h1>%link</h1></div>', '%title' );
            next_post_link(     '<div class="nav-next"><div class="nav-indicator">' . _x( '<div class="pos"><i class="fa fa-angle-right fa-3x"></i></div>Next Post:&nbsp;', 'Next post', 'utkblog' ) . '</div><h1>%link</h1></div>', '%title' );
            ?>
        </div><!-- .nav-links -->
    </div><!-- .post-nav-box -->
</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'utkblog_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function utkblog_posted_on() {
	$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string .= '<time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = sprintf(
		_x( 'Posted on <span data-icon="&#xe048;"></span>&nbsp;%s', 'post date', 'utkblog' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	$byline = sprintf(
		_x( '&nbsp;&nbsp;by <span data-icon="&#xe074;"></span>&nbsp;%s', '&nbsp;post author', 'utkblog' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>';

}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function utkblog_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'utkblog_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'utkblog_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so utkblog_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so utkblog_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in utkblog_categorized_blog.
 */
function utkblog_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'utkblog_categories' );
}
add_action( 'edit_category', 'utkblog_category_transient_flusher' );
add_action( 'save_post',     'utkblog_category_transient_flusher' );
