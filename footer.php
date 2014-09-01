<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package utkblog
 */
?>

	</div><!-- #content -->
       
	<footer id="colophon" class="site-footer" role="contentinfo">
             <?php get_sidebar( 'footer' ); ?>
		<div class="site-info">
			<a href="<?php echo esc_url( __( 'https://www.twitter.com/utk_utk', 'utkblog' ) ); ?>"><?php printf( __( '<i class="fa fa-quote-left"></i>&nbsp;Theme designed by %s', 'utkblog' ), 'Utkarsh Upadhyay&nbsp;<i class="fa fa-quote-right"></i>' ); ?></a>
	
			<?php printf( __( '&nbsp;| Made in %1$s', 'utkblog' ), 'India with <i class="fa fa-heart"></i>' ); ?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
