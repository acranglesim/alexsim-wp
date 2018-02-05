<?php
function plum_register_video() {
    register_widget( 'plum_video_widget' );
}

add_action('widgets_init', 'plum_register_video');


Class plum_video_widget extends WP_Widget{
    function __construct()
    {
        parent::__construct(
            'plum_video_widget',
            __('Youtube Video Widget By Plum', 'plum'), // Name
            array( 'description' => __( 'Displays a video from YouTube.', 'plum' ), ) // Args
        );
    }

    public function widget($args , $instance){
        echo $args['before_widget'];

        if ( ! empty( $instance['title'] ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
        }
        //get the video id from the save settings
        $vi = empty($instance['video_id']) ? '' : apply_filters('widget_title', $instance['video_id']);

        //if there is a video id, output the youtube embed code with our video id, width and height settings used
        if (!empty($vi))
            echo '<div class="video-wrapper">
                    <iframe width="100%" height="500%" src="https://www.youtube.com/embed/' . $vi .  '?autohide=1" frameborder="0" allowfullscreen class="video"></iframe>
                 </div>';

        echo $args['after_widget'];
    }


    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */

    public function form($instance){
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        }
        else {
            $title = __( 'New title', 'plum' );
        }

        if ( isset( $instance[ 'video_id' ] ) ) {
            $vi = $instance[ 'video_id' ];
        }
        else {
            $vi = '';
        }

        ?>

        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'plum' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>

        <p>
<!--            <label for="--><?php //echo $this->get_field_id( 'video_id_info' ); ?><!--">--><?php //_e( 'Video ID:', 'plum' ); ?><!--</label>-->
            <label for="<?php echo $this->get_field_id( 'video_id' ); ?>"><?php _e( 'Video ID:', 'plum' ); ?></label>
            <p>Example: https://www.youtube.com/watch?v=id</p>
            <input class="widefat" id="<?php echo $this->get_field_id( 'video_id' ); ?>" name="<?php echo $this->get_field_name( 'video_id' ); ?>" type="text" value="<?php echo esc_attr( $vi ); ?>">
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
        $instance = $old_instance;
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['video_id'] = ( ! empty( $new_instance['video_id'] ) ) ? strip_tags( $new_instance['video_id'] ) : '';
        $instance['video_height'] = (isset($new_instance['video_height'])) ? $new_instance['video_height'] : $old_instance['video_height'];
        $instance['video_width'] = (isset($new_instance['video_width'])) ? $new_instance['video_width'] : $old_instance['video_width'];

        return $instance;
    }
}