<?php
/**
 * Odin_Widget_Like_Box class.
 *
 * Facebook like widget.
 *
 * @package  Odin
 * @category Widget
 * @author   WPBrasil
 * @version  2.2.0
 */
class Odin_Widget_Like_Box extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
			'odin_facebook_like_box',
			__( 'Facebook Like Box', 'odin' ),
			array( 'description' => __( 'This widget includes a facebook like box on your blog', 'odin' ), )
		);
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$title         = isset( $instance['title'] ) ? $instance['title'] : '';
		$url           = isset( $instance['url'] ) ? $instance['url'] : '';
		$width         = isset( $instance['width'] ) ? $instance['width'] : 300;
		$height        = isset( $instance['height'] ) ? $instance['height'] : 600;
		$color_scheme  = isset( $instance['color_scheme'] ) ? $instance['color_scheme'] : 'light';
		$friends_faces = isset( $instance['friends_faces'] ) ? $instance['friends_faces'] : 1;
		$show_posts    = isset( $instance['show_posts'] ) ? $instance['show_posts'] : 0;
		$show_header   = isset( $instance['show_header'] ) ? $instance['show_header'] : 0;
		$show_border   = isset( $instance['show_border'] ) ? $instance['show_border'] : 0;

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">
				<?php _e( 'Title', 'odin' ); ?>
				<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'url' ); ?>">
				<?php _e( 'Facebook Page URL', 'odin' ); ?>
				<input id="<?php echo $this->get_field_id( 'url' ); ?>" name="<?php echo $this->get_field_name( 'url' ); ?>" type="text" value="<?php echo esc_attr( $url ); ?>" />
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'width' ); ?>">
				<?php _e( 'Width', 'odin' ); ?>
				<input id="<?php echo $this->get_field_id( 'width' ); ?>" name="<?php echo $this->get_field_name( 'width' ); ?>" type="text" value="<?php echo intval( $width ); ?>" />
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'height' ); ?>">
				<?php _e( 'Height', 'odin' ); ?>
				<input id="<?php echo $this->get_field_id( 'height' ); ?>" name="<?php echo $this->get_field_name( 'height' ); ?>" type="text" value="<?php echo intval( $height ); ?>" />
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'color_scheme' ); ?>">
				<?php _e( 'Color Scheme', 'odin' ); ?>
				<select id="<?php echo $this->get_field_id( 'color_scheme' ); ?>" name="<?php echo $this->get_field_name( 'color_scheme' ); ?>">
					<option value="dark" <?php selected( 'dark', $color_scheme, true ); ?>><?php _e( 'Dark','odin' ); ?></option>
					<option value="light" <?php selected( 'light', $color_scheme, true ); ?>><?php _e( 'Light','odin' ); ?></option>
				</select>
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'friends_faces' ); ?>">
				<input id="<?php echo $this->get_field_id( 'friends_faces' ); ?>" name="<?php echo $this->get_field_name( 'friends_faces' ); ?>" type="checkbox" value="1" <?php checked( 1, $friends_faces, true ); ?> /> <?php _e( 'Show Friends Faces', 'odin' ); ?>
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'show_posts' ); ?>">
				<input id="<?php echo $this->get_field_id( 'show_posts' ); ?>" name="<?php echo $this->get_field_name( 'show_posts' ); ?>" type="checkbox" value="1" <?php checked( 1, $show_posts, true ); ?> /> <?php _e( 'Show Posts', 'odin' ); ?>
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'show_header' ); ?>">
				<input id="<?php echo $this->get_field_id( 'show_header' ); ?>" name="<?php echo $this->get_field_name( 'show_header' ); ?>" type="checkbox" value="1" <?php checked( 1, $show_header, true ); ?> /> <?php _e( 'Show Header', 'odin' ); ?>
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'show_header' ); ?>">
				<input id="<?php echo $this->get_field_id( 'show_border' ); ?>" name="<?php echo $this->get_field_name( 'show_border' ); ?>" type="checkbox" value="1" <?php checked( 1, $show_border, true ); ?> /> <?php _e( 'Show Border', 'odin' ); ?>
			</label>
		</p>
		<?php
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

		return $instance;
	}

	/**
	 * Outputs the content of the widget.
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		if( !empty( $instance['url'] ) )
			$url = $instance['url'];
		else
			$url = '';

		if( !empty( $instance['width'] ) )
			$width = $instance['width'];
		else
			$width = 300;

		if( !empty( $instance['height'] ) )
			$height = $instance['height'];
		else
			$height = 600;

		if( !empty( $instance['color_scheme'] ) )
			$color_scheme = $instance['color_scheme'];
		else
			$color_scheme = 'light';

		if( !empty( $instance['friends_faces'] ) )
			$friends_faces = $instance['friends_faces'];
		else
			$friends_faces = 0;

		if( !empty( $instance['show_posts'] ) )
			$show_posts = $instance['show_posts'];
		else
			$show_posts = 0;

		if( !empty( $instance['show_header'] ) )
			$show_header = $instance['show_header'];
		else
			$show_header = 0;

		if( !empty( $instance['show_border'] ) )
			$show_border = $instance['show_border'];
		else
			$show_border = 0;
?>
		<iframe src="//www.facebook.com/plugins/likebox.php?href=<?php echo $url; ?>&amp;width=<?php echo $width; ?>&amp;height=<?php echo $height; ?>&amp;colorscheme=<?php echo $color_scheme; ?>&amp;show_faces=<?php echo $friends_faces; ?>&amp;header=<?php echo $show_header; ?>&amp;stream=<?php echo $show_posts; ?>&amp;show_border=<?php echo $show_border; ?>" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width: <?php echo $width; ?>px; height:<?php echo $height; ?>px;" allowTransparency="true"></iframe>
<?php
	}
}

/**
 * Register the Like Box Widget.
 *
 * @return void
 */
function odin_like_box_widget() {
	register_widget( 'Odin_Widget_Like_Box' );
}

add_action( 'widgets_init', 'odin_like_box_widget' );
