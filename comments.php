<div id="comments" class="content-wrap" itemscope itemtype="http://schema.org/Comment">
    <?php if ( post_password_required() ) : ?>
        <span class="nopassword"><?php _e( 'Este post &eacute; protegido por senha. Digite a senha para ver todos os coment&aacute;rios.', 'odin' ); ?></span>
</div><!-- #comments -->
        <?php
        return;
    endif;

    if ( have_comments() ) : ?>
        <h2 id="comments-title">
            <?php
            comments_number( __( '0 Coment&aacute;rios', 'odin' ), __( '1 Coment&aacute;rio', 'odin' ), __( '% Coment&aacute;rios', 'odin' ) );
            echo __( ' para ', 'odin' ) . '<span>&quot;' . get_the_title() . '&quot;</span>';
            ?>
        </h2>
        <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
            <nav id="comment-nav-above">
                <div class="nav-previous"><?php previous_comments_link( __( '&larr; Coment&aacute;rios antigos', 'odin' ) ); ?></div>
                <div class="nav-next"><?php next_comments_link( __( 'Novos coment&aacute;rios &rarr;', 'odin' ) ); ?></div>
            </nav>
        <?php endif; ?>
        <ol class="commentlist">
            <?php wp_list_comments( array( 'callback' => 'odin_comment_loop' ) ); ?>
        </ol>
        <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
            <nav id="comment-nav-above">
                <div class="nav-previous"><?php previous_comments_link( __( '&larr; Coment&aacute;rios antigos', 'odin' ) ); ?></div>
                <div class="nav-next"><?php next_comments_link( __( 'Novos coment&aacute;rios &rarr;', 'odin' ) ); ?></div>
            </nav>
        <?php endif; ?>
    <?php endif; ?>
    <?php if ( ! comments_open() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
        <span class="nocomments"><?php _e( 'Os coment&aacute;rios est&atilde;o fechados.', 'odin' ); ?></span>
    <?php endif; ?>

    <?php
        $commenter = wp_get_current_commenter();
        $req = get_option( 'require_name_email' );
        $aria_req = ( $req ? " aria-required='true'" : '' );

        comment_form(
        array(
            'comment_notes_after' => '',
            'comment_field' => '<div class="comment-form-comment control-group"><label class="control-label" for="comment">' . _x( 'Coment&aacute;rio', 'odin' ) . '</label><div class="controls"><textarea id="comment" name="comment" cols="45" rows="8" class="input-block-level" aria-required="true"></textarea></div></div>',
            'fields' => apply_filters( 'comment_form_default_fields', array(
                'author' => '<div class="comment-form-author control-group">' . '<label class="control-label" for="author">' . __( 'Nome', 'odin' ) . ( $req ? '<span class="required"> *</span>' : '' ) . '</label><div class="controls"><input class="span3" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></div></div>',
                'email' => '<div class="comment-form-email control-group"><label class="control-label" for="email">' . __( 'E-mail', 'odin' ) . ( $req ? '<span class="required"> *</span>' : '' ) . '</label><div class="controls"><input class="span3" id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></div></div>',
                'url' => '<div class="comment-form-url control-group"><label class="control-label" for="url">' . __( 'Website', 'odin' ) . '</label>' . '<div class="controls"><input class="span3" id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></div></div>' ) )
        )
    ); ?>
</div><!-- #comments -->

