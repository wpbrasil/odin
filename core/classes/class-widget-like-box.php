<?php
/**
 * Odin_Widgets class.
 *
 * Widgets.
 *
 * @package  Odin
 * @category Metabox
 * @author   WPBrasil
 * @version  2.1.4
 */
class Odin_Widget_Like_Box extends WP_Widget {
	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		parent::__construct(
			'odin_facebook_like_box',
			__('Odin Facebook Like Box', 'odin'),
			array( 'description' => __( 'This widget includes a facebook like box on your blog', 'odin' ), )
		);
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		if( !empty( $instance['facebook_page_url'] ) )
			$facebook_page_url = $instance['facebook_page_url'];
		else
			$facebook_page_url = '';

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
		<iframe src="//www.facebook.com/plugins/likebox.php?href=<?php echo $facebook_page_url; ?>&amp;width=<?php echo $width; ?>&amp;height=<?php echo $height; ?>&amp;colorscheme=<?php echo $color_scheme; ?>&amp;show_faces=<?php echo $friends_faces; ?>&amp;header=<?php echo $show_header; ?>&amp;stream=<?php echo $show_posts; ?>&amp;show_border=<?php echo $show_border; ?>" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width: <?php echo $width; ?>px; height:<?php echo $height; ?>px;" allowTransparency="true"></iframe>
<?php
	}

	/**
	 * Ouputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		if( !empty( $instance['facebook_page_url'] ) )
			$facebook_page_url = $instance['facebook_page_url'];
		else
			$facebook_page_url = '';

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
		<p>
			<label for="<?php echo $this->get_field_id('facebook_page_url'); ?>">
				<?php _e( 'Facebook Page URL', 'odin' ); ?>
				<input id="<?php echo $this->get_field_id('facebook_page_url'); ?>" name="<?php echo $this->get_field_name('facebook_page_url'); ?>" type="text" value="<?php echo $facebook_page_url; ?>" />
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('width'); ?>">
				<?php _e( 'Width', 'odin' ); ?>
				<input id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" type="text" value="<?php echo $width; ?>" />
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('height'); ?>">
				<?php _e( 'Height', 'odin' ); ?>
				<input id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" type="text" value="<?php echo $height; ?>" />
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('color_scheme'); ?>">
				<?php _e( 'Color Scheme', 'odin' ); ?>
				<select id="<?php echo $this->get_field_id('color_scheme'); ?>" name="<?php echo $this->get_field_name('color_scheme'); ?>">
					<option value="dark"<?php if( $color_scheme == 'dark' ) echo ' selected'; ?>><?php _e( 'Dark','odin' ); ?></option>
					<option value="light"<?php if( $color_scheme == 'light' ) echo ' selected'; ?>><?php _e( 'Light','odin' ); ?></option>
				</select>
			</label>
		</p>
		<p>
		<label for="<?php echo $this->get_field_id('friends_faces'); ?>">
			<input id="<?php echo $this->get_field_id('friends_faces'); ?>" name="<?php echo $this->get_field_name('friends_faces'); ?>" type="checkbox" value="1"<?php if ( $friends_faces ) echo ' checked'; ?> /> <?php _e( 'Show Friends Faces', 'odin' ); ?>

			<input id="<?php echo $this->get_field_id('show_posts'); ?>" name="<?php echo $this->get_field_name('show_posts'); ?>" type="checkbox" value="1"<?php if ( $show_posts ) echo ' checked'; ?> /> <?php _e( 'Show Posts', 'odin' ); ?>

			<input id="<?php echo $this->get_field_id('show_header'); ?>" name="<?php echo $this->get_field_name('show_header'); ?>" type="checkbox" value="1"<?php if ( $show_header ) echo ' checked'; ?> /> <?php _e( 'Show Header', 'odin' ); ?>

			<input id="<?php echo $this->get_field_id('show_border'); ?>" name="<?php echo $this->get_field_name('show_border'); ?>" type="checkbox" value="1"<?php if ( $show_border ) echo ' checked'; ?> /> <?php _e( 'Show Border', 'odin' ); ?>
		</p>
<?php
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array_merge($old_instance, $new_instance);

		return $instance;
	}
}
add_action('widgets_init', create_function('', 'return register_widget("Odin_Widget_Like_Box");'));