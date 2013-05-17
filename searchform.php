<form method="get" id="searchform" class="form-search" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
    <label for="s" class="assistive-text"><?php _e( 'Busca', 'odin' ); ?></label>
    <input type="text" class="input-medium search-query" name="s" id="s" />
    <input type="submit" class="btn" value="<?php esc_attr_e( 'Buscar', 'odin' ); ?>" />
</form>
