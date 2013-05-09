<form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
    <label for="s" class="assistive-text"><?php _e( 'Busca', 'odin' ); ?></label>
    <input type="text" class="input-text" name="s" id="s" />
    <input type="submit" class="input-submit" value="<?php esc_attr_e( 'Buscar', 'odin' ); ?>" />
</form>
