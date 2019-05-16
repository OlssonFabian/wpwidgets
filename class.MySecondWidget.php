<?php
/**
 * Adds MySecond widget.
 */
class MySecondWidget extends WP_Widget {
	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
			'my_second_widget', // Base ID
			'My Second Widget', // Name
			[
				'description' => __('A Sample Widget', 'mysecondwidget'),
			] // Args
		);
    }



	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget($args, $instance) {
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);
		// start widget
		echo $before_widget;
		// title
		if (! empty($title)) {
			echo $before_title . $title . $after_title;
        }
        // latest posts
        $query = new WP_Query([
            'posts_per_page' => $instance['posts-to-show'],
            ]);

            if ($query->have_posts()){
                $html = "<ul>";
                while ($query->have_posts()){
                    $query->the_post();
                    $html .= "<li>";
                    $html .= get_the_title();
                    $html .= " in ";
                    $html .= get_the_category_list(', ');
                    if ($instance['show_author']){
                        $html .= " by ";
                        $html .= get_the_author();
                    }
                    $html .= " at ";
                    $html .= human_time_diff( get_the_time('U'), current_time('timestamp') ) . ' ago';
                    $html .= "</li>";
                }
                wp_reset_postdata();
                $html .="</ul>";
            } else {
                $html .= $html . "no latest posts at this current time";
            }
            echo $html;

		// close widget
		echo $after_widget;
    }



	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form($instance) {
		if (isset($instance['title'])) {
			$title = $instance['title'];
		} else {
			$title = __('New title', 'myfirstwidget');
		}

		if (isset($instance['posts-to-show'])) {
			$numberOfPosts = $instance['posts-to-show'];
		} else {
			$numberOfPosts = '';
		}

        $show_author = isset($instance['show_author'])
        ? $instance
        : false;

		?>

		<!-- title -->
		<p>
			<label
				for="<?php echo $this->get_field_name('title'); ?>"
			>
				<?php _e('Title:'); ?>
			</label>

			<input
				class="widefat"
				id="<?php echo $this->get_field_id('title'); ?>"
				name="<?php echo $this->get_field_name('title'); ?>"
				type="text"
				value="<?php echo esc_attr($title); ?>"
			/>
		 </p>
		 <!-- /title -->

		 <!-- posts-to-show -->
		 <p>
			<label
				for="<?php echo $this->get_field_name('posts-to-show'); ?>"
			>
				<?php _e('posts-to-show:'); ?>
			</label>

			<textarea
				class="widefat"
				id="<?php echo $this->get_field_id('posts-to-show'); ?>"
				name="<?php echo $this->get_field_name('posts-to-show'); ?>"
				rows="1"
                type="number"
                min="1"
			><?php echo $numberOfPosts; ?></textarea>
		 </p>
		 <!-- /posts-to-show -->

 <!-- show_author -->
 <p>
			<label
				for="<?php echo $this->get_field_name('show_author'); ?>"
			>
				<?php _e('show author:'); ?>
			</label>

			<input
				class="widefat"
				id="<?php echo $this->get_field_id('show_author'); ?>"
				name="<?php echo $this->get_field_name('show_author'); ?>"
                type="checkbox"
                value="1"
                <?php echo $show_author ? 'checked' : ''; ?>
			/>
		 </p>
<!-- /show_author -->


        <!-- latest posts -->
         <!-- /latest posts -->




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

	public function update($new_instance, $old_instance) {
		$instance = [];
		$instance['title'] = (!empty($new_instance['title']))
			? strip_tags($new_instance['title'])
            : '';

            $instance['posts-to-show'] = (!empty($new_instance['posts-to-show']))
			? intval($new_instance['posts-to-show'])
            : 3;

            $instance['show_author'] = (!empty($new_instance['show_author']))
			? true
			: false;


		return $instance;
	}
} // class MySecondWidget
