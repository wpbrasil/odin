    </div><!-- #main -->
    <footer id="footer" role="contentinfo">
        <span>&copy; <?php echo date( 'Y' ); ?> <a href="<?php echo home_url(); ?>"><?php bloginfo( 'name' ); ?></a> - <?php _e( 'Todos os Direitos Reservados', 'odin' ); ?> | <?php echo sprintf( __( 'Powered by the <a href="%s" rel="nofollow" target="_blank">Odin</a> forces and <a href="%s" rel="nofollow" target="_blank">WordPress</a>.', 'odin' ), 'http://wpbrasil.github.com/odin', 'http://wordpress.org/' ); ?></span>
    </footer><!-- #footer -->
</div><!-- .wrapper -->
<?php wp_footer(); ?>
</body>
</html>

