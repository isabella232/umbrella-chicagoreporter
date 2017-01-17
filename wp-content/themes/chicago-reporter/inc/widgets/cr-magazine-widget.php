<?php

// Magazine Issue Widget
class cr_magazine_widget extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	function __construct() {
		parent::__construct(
			'magazine_issue', // Base ID
			__('Magazine Issue', 'Largo'),
			array( 'description' => __( 'Allows you to select the Magazine issue to display in any sidebar', 'Largo' ), )
		);
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}
		echo '<div class="magazine-issue">';
			echo '<div class="magazine-image">';
				if ( ! empty( $instance['imageurl'] ) ) {
					echo '<img src="' . $instance['imageurl'] . '">';
				}
			echo '</div>';
			echo '<div class="magazine-content">';
				if ( ! empty( $instance['magazinecontent'] ) ) {
					echo  $instance['magazinecontent'];
				}
				echo '<div class="magazine-content-cta">';
					if ( ! empty( $instance['linkurl'] ) ) {
						echo  '<a href="' . $instance['linkurl'] . '">';
						if ( ! empty( $instance['linktext'] ) ) {
							echo  $instance['linktext'];
						}
						echo '</a>';
					}
				echo '</div>';
				echo '<div class="clearfix"></div>';
			echo '</div>';
		echo '</div>';
		echo $args['after_widget'];

	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {

		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		} else {
			$title = '';
		}

		if ( isset( $instance[ 'imageurl' ] ) ) {
			$imageurl = $instance[ 'imageurl' ];
		} else {
			$imageurl = '';
		}

		if ( isset( $instance[ 'magazinecontent' ] ) ) {
			$magazinecontent = $instance[ 'magazinecontent' ];
		} else {
			$magazinecontent = '';
		}

		if ( isset( $instance[ 'linktext' ] ) ) {
			$linktext = $instance[ 'linktext' ];
		} else {
			$linktext = '';
		}

		if ( isset( $instance[ 'linkurl' ] ) ) {
			$linkurl = $instance[ 'linkurl' ];
		} else {
			$linkurl = '';
		}
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'imageurl' ); ?>"><?php _e( 'Image URL:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'imageurl' ); ?>" name="<?php echo $this->get_field_name( 'imageurl' ); ?>" type="text" value="<?php echo esc_attr( $imageurl ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('magazinecontent'); ?>"><?php _e('Content:<br/>', 'wp_widget_plugin'); ?></label>
			<textarea class="widefat" id="<?php echo $this->get_field_id('magazinecontent'); ?>" name="<?php echo $this->get_field_name('magazinecontent'); ?>"><?php echo $magazinecontent; ?></textarea>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'linktext' ); ?>"><?php _e( 'Link Text:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'linktext' ); ?>" name="<?php echo $this->get_field_name( 'linktext' ); ?>" type="text" value="<?php echo esc_attr( $linktext ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'linkurl' ); ?>"><?php _e( 'Link URL:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'linkurl' ); ?>" name="<?php echo $this->get_field_name( 'linkurl' ); ?>" type="text" value="<?php echo esc_attr( $linkurl ); ?>">
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
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['imageurl'] = ( ! empty( $new_instance['imageurl'] ) ) ? strip_tags( $new_instance['imageurl'] ) : '';
		$instance['magazinecontent'] = ( ! empty( $new_instance['magazinecontent'] ) ) ? $new_instance['magazinecontent']: '';
		$instance['linktext'] = ( ! empty( $new_instance['linktext'] ) ) ? strip_tags( $new_instance['linktext'] ) : '';
		$instance['linkurl'] = ( ! empty( $new_instance['linkurl'] ) ) ? strip_tags( $new_instance['linkurl'] ) : '';

		return $instance;
	}
}

// Register the widget
function register_cr_widgets() {
    register_widget( 'cr_magazine_widget' );
}
add_action( 'widgets_init', 'register_cr_widgets' );
