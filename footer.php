    </div><!-- #main -->
    <footer id="footer" role="contentinfo">
        <span>&copy; <?php echo date( 'Y' ); ?> <a href="<?php echo home_url(); ?>"><?php bloginfo( 'name' ); ?></a> - <?php _e( 'All rights reserved', 'odin' ); ?> | <?php echo sprintf( __( 'Powered by the <a href="%s" rel="nofollow" target="_blank" itemprop="copyrightHolder">Odin</a> forces and <a href="%s" rel="nofollow" target="_blank">WordPress</a>.', 'odin' ), 'http://wpbrasil.github.com/odin', 'http://wordpress.org/' ); ?></span>
    </footer><!-- #footer -->
</div><!-- .container -->
<?php wp_footer(); ?>
</body>
</html>
