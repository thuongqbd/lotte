<?php
/**
 * Plugin Name: SWE Happy Diary Bài đọc nhiều nhất Widget
 * Plugin URI: http://washinengine.com/
 * Description: A widget that show Happy Diary Bài đọc nhiều nhất.
 * Version: 1.0
 * Author: SWE
 * Author URI: http://washinengine.com/
 *
 */ 
 
add_action( 'widgets_init', 'happydiary_baidocnhieunhat_widget' );
function happydiary_baidocnhieunhat_widget() {
	register_widget( 'happydiary_baidocnhieunhat' );
}

class happydiary_baidocnhieunhat extends WP_Widget {
	private $_type = array(
		'docnhieunhat' =>'Bài đọc nhiều nhất',
		'moinhat' =>'Tin mới nhất',
		'tieudiem' =>'Tin tiêu điểm',
		'noibat' =>'Tin nổi bật',
	);
	// Initialize the widget
	function happydiary_baidocnhieunhat() {
		parent::WP_Widget('happydiary_baidocnhieunhat-widget', __('Happy Diary Bài đọc nhiều nhất Form Widget (swe)','lottehappytour'), 
			array('description' => __('A Happy Diary Bài đọc nhiều nhất form widget.', 'lottehappytour')));  
	}	

	// Output of the widget
	function widget( $args, $instance ) {
		global $post;
		extract( $args );
		if (  !empty($instance['title'] )) {
			$title = apply_filters( 'widget_title', $instance['title'] );
			
		} else {
			$title = '';
		}
		if (  !empty($instance['type'] )) {
			$type = $instance['type'];
			
		} else {
			$type = 'docnhieunhat';
		}	
		if (  !empty($instance['number_item'] )) {
			$number_item = $instance['number_item'];
			
		} else {
			$number_item = 2;
		}

		wp_reset_query();

		// Opening of widget
		echo $before_widget;
		
		// Open of title tag
		if ( $title ){ 
			echo $before_title . $title . $after_title; 
		}	
		
		// WP_Query arguments
		$args = array(
			'post__not_in' => array($post->ID),
			'post_status' => 'publish',
			'category_name' => 'happy-diary',
			'pagination' => false,		
			'posts_per_page' => $number_item,
			'order' => 'DESC',
//			'orderby' => 'meta_value_num date',
//			'meta_key'=> 'view_count'
		);
		if($type == 'tieudiem' || $type == 'noibat'){
			$args = array_merge($args, array('meta_key'=> 'diary_type','meta_value'=> $type));
		}elseif($type == 'docnhieunhat'){
			$args = array_merge($args, array('orderby' => 'meta_value_num date','meta_key'=> 'view_count'));
		}
	// The Query
		$query = new WP_Query($args);

	// The Loop
		if ($query->have_posts()) {
			$ret ='	<div class="widget-tindocnhieu related-news">'
					. '		<ul>';
			$i=1;
			while ($query->have_posts()) {
				$query->the_post();		
				$post_thumbnail_id = get_post_thumbnail_id(get_the_ID() );
				//do something
				$date = getdate(strtotime(get_the_date()));					

				$ret .= '		<li>'
						.'			<p><a href="'.  get_permalink().'" title="'.  get_the_title() .'">'.get_the_title().'</a></p>'
						.'				<a href="'.  get_permalink().'" title="'.  get_the_title() .'">'.swe_wp_get_attachment_image($post_thumbnail_id,array(450,338)).'</a>'
						.'		</li>';
				$i++;
			}
				$ret .='	</ul>
						</div>';					
		} else {
			// no posts found
	//		return;
		}

	// Restore original Post Data
		wp_reset_postdata();
		echo $ret;
		// Closing of widget
		echo $after_widget;
	}
	
	// Widget Form
	function form( $instance ) {
		if ( $instance ) {
			$title = esc_attr( $instance[ 'title' ] );
			$type = $instance['type'];
			$number_item = $instance['number_item'];
		} else {
			$title = '';
			$type = 'docnhieunhat';
			$number_item = 2;
		}
		$array = $this->_type;
		?>
		<!-- Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title :', 'lottehappytour' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('type'); ?>"><?php _e( 'Loại :', 'lottehappytour' ); ?></label> 
			<select class='widefat' id="<?php echo $this->get_field_id('type'); ?>"
                name="<?php echo $this->get_field_name('type'); ?>">
			<?php foreach($array  as $k => $v):?>
				<option value="<?php echo $k;?>" <?php echo ($type == $k) ? 'selected' : ""?>><?php echo $v?> </option>
			<?php endforeach;?>
			</select>    
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('number_item'); ?>"><?php _e( 'Số bài :', 'lottehappytour' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('number_item'); ?>" name="<?php echo $this->get_field_name('number_item'); ?>" type="number" value="<?php echo $number_item; ?>" />
		</p>
		<?php
	}	
	
	// Update the widget
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['type'] =  $new_instance['type'] ;
		$instance['number_item'] =  $new_instance['number_item'] ;
		return $instance;
	}

}

?>