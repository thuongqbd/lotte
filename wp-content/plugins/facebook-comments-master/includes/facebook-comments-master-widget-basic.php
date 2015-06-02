<?php
//Hook Widget
add_action( 'widgets_init', 'facebook_comments_master_widget_basic' );

//Register Widget
function facebook_comments_master_widget_basic() {
register_widget( 'facebook_comments_master_widget_basic' );
}

add_action( 'wp_enqueue_scripts', 'facebook_comments_master_wbcss' );
//load css for shortcode
function facebook_comments_master_wbcss() {
if ( is_active_widget( false, false, 'facebook_comments_master_widget_basic', true ) ) {
	wp_register_style( 'facebook_comments_master_wbcss', plugins_url('facebook-comments-master-style.css', __FILE__) );
	wp_enqueue_style( 'facebook_comments_master_wbcss' );
}
}

class facebook_comments_master_widget_basic extends WP_Widget {
	function facebook_comments_master_widget_basic() {
	$widget_ops = array( 'classname' => 'FB Comments Master Basic', 'description' => __('FB Comments Master Basic Fast Loading Widget, is built-in Html5 for professional, easy and fast Facebook Comments deployment. ', 'facebook_comments_master') );
	$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'facebook_comments_master_widget_basic' );
	$this->WP_Widget( 'facebook_comments_master_widget_basic', __('FB Comments Master Basic', 'facebook_comments_master'), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );
		//Variables from the widget settings.
		$facebook_comments_title = isset( $instance['facebook_comments_title'] ) ? $instance['facebook_comments_title'] :false;
		$facebook_comments_title_new = isset( $instance['facebook_comments_title_new'] ) ? $instance['facebook_comments_title_new'] :false;
		$facebookcommentsspacer ="'";
		@$fburibase = site_url( $path, $scheme );
		@$fburicurrent = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		echo $before_widget;
		
	// Display the widget title
	if ( $facebook_comments_title ){
		if (empty ($facebook_comments_title_new)){
			if(is_multisite()){
			$facebook_comments_title_new = get_site_option('facebook_comments_master_name');
			}
			else{
			$facebook_comments_title_new = get_option('facebook_comments_master_name');
			}
		echo $before_title . $facebook_comments_title_new . $after_title;
		}
		else{
		echo $before_title . $facebook_comments_title_new . $after_title;
		}
	}
	else{
	}
	//Prepare APP ID
	if(is_multisite()){
		if (get_site_option('facebook_comments_master_system_wide_app') == "true" ){
			$facebook_comments_master_wb_app_create = "&appId=".get_site_option('facebook_comments_master_system_wide_app_id');
		}
		else{
			$facebook_comments_master_wb_app_create = '';
		}
	}
	else{
		if (get_option('facebook_comments_master_system_wide_app') == "true" ){
			$facebook_comments_master_wb_app_create = "&appId=".get_option('facebook_comments_master_system_wide_app_id');
		}
		else{
			$facebook_comments_master_wb_app_create = '';
		}
	}
	//Prepare Language
	if(is_multisite()){
		if (get_site_option('facebook_comments_master_system_wide_lang') == "true" ){
			$facebook_comments_master_wb_lang_create = get_site_option('facebook_comments_master_system_wide_lang_set');
				if(empty($facebook_comments_master_wb_lang_create)){
					$facebook_comments_master_wb_lang_create = "en_US";
				}
		}
		else{
			$facebook_comments_master_wb_lang_create = "en_US";
		}
	}
	else{
		if (get_option('facebook_comments_master_system_wide_lang') == "true" ){
			$facebook_comments_master_wb_lang_create = get_option('facebook_comments_master_system_wide_lang_set');
				if(empty($facebook_comments_master_wb_lang_create)){
					$facebook_comments_master_wb_lang_create = "en_US";
				}
		}
		else{
			$facebook_comments_master_wb_lang_create = "en_US";
		}
	}
	//Display Faceboook Comments
		echo '<div id="fb-root"></div>' .
			'<script>(function(d, s, id) {' .
			'var js, fjs = d.getElementsByTagName(s)[0];' .
			'if (d.getElementById(id)) return;' .
			'js = d.createElement(s); js.id = id;' .
			'js.src ="//connect.facebook.net/'.$facebook_comments_master_wb_lang_create.'/sdk.js#xfbml=1&version=v2.3'.$facebook_comments_master_wb_app_create.'";' .
			'fjs.parentNode.insertBefore(js, fjs);' .
			'}(document, '.$facebookcommentsspacer.'script'.$facebookcommentsspacer.', '.$facebookcommentsspacer.'facebook-jssdk'.$facebookcommentsspacer.'));</script>' .
			'<div class="fb-comments" data-href="'.$fburicurrent.'" data-width="100%" data-numposts="10" data-colorscheme="light" ></div>' .
	$after_widget;
	}
	//Update the widget
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		//Strip tags from title and name to remove HTML
		$instance['facebook_comments_title'] = strip_tags( $new_instance['facebook_comments_title'] );
		$instance['facebook_comments_title_new'] = $new_instance['facebook_comments_title_new'];
		return $instance;
	}
	function form( $instance ) {
	//Set up some default widget settings.
	$defaults = array( 'facebook_comments_title_new' => __('Facebook Comments Master', 'facebook_comments_master'), 'facebook_comments_title' => true, 'facebook_comments_title_new' => false );
	$instance = wp_parse_args( (array) $instance, $defaults );
	?>
		<br>
		<b>Check the buttons to be displayed:</b>
	<p>
	<img src="<?php echo plugins_url('../images/techgasp-minilogo-16.png', __FILE__); ?>" style="float:left; height:16px; vertical-align:middle;" />
	&nbsp;
	<input type="checkbox" <?php checked( (bool) $instance['facebook_comments_title'], true ); ?> id="<?php echo $this->get_field_id( 'facebook_comments_title' ); ?>" name="<?php echo $this->get_field_name( 'facebook_comments_title' ); ?>" />
	<label for="<?php echo $this->get_field_id( 'facebook_comments_title' ); ?>"><b><?php _e('Display Widget Title', 'facebook_comments_master'); ?></b></label></br>
	</p>
	<p>
	<label for="<?php echo $this->get_field_id( 'facebook_comments_title_new' ); ?>"><?php _e('Change Title:', 'facebook_comments_master'); ?></label>
	<br>
	<input id="<?php echo $this->get_field_id( 'facebook_comments_title_new' ); ?>" name="<?php echo $this->get_field_name( 'facebook_comments_title_new' ); ?>" value="<?php echo $instance['facebook_comments_title_new']; ?>" style="width:auto;" />
	</p>
<div style="background: url(<?php echo plugins_url('../images/techgasp-hr.png', __FILE__); ?>) repeat-x; height: 10px"></div>
	<br>
	<div class="description"><b>TechGasp Fast Deployment</b></div>
	<div class="description">All settings are "on" auto mode for a fast and easy use. This widget is built-in html5 with minimal clean code for fast page load times and perfect Google SEO. Just publish it anywhere in your template to render Facebook Comments.</div>
	<div class="description">If you want to have full control over display options, use the <b>Facebook Comments Master Advanced Responsive Widget.</b></div>
	<div class="description">If you want to publish Facebook Comments inside pages and posts, use the <b>Universal or Individual TechGasp Shortcode Framework.</b></div>
	<br>
<div style="background: url(<?php echo plugins_url('../images/techgasp-hr.png', __FILE__); ?>) repeat-x; height: 10px"></div>
	<br>
	<img src="<?php echo plugins_url('../images/techgasp-minilogo-16.png', __FILE__); ?>" style="float:left; height:16px; vertical-align:middle;" />
	&nbsp;
	<b>Moderation & Language Tools</b>
	</p>
	<p>
	<div class="description">Visit Facebook Comments Master Settings Page.</div>
	</p>
<div style="background: url(<?php echo plugins_url('../images/techgasp-hr.png', __FILE__); ?>) repeat-x; height: 10px"></div>
	<p>
	<img src="<?php echo plugins_url('../images/techgasp-minilogo-16.png', __FILE__); ?>" style="float:left; width:16px; vertical-align:middle;" />
	&nbsp;
	<b>Facebook Comments Master Website</b>
	</p>
	<p><a class="button-secondary" href="http://wordpress.techgasp.com/facebook-comments-master/" target="_blank" title="Facebook Comments Master Info Page">Info Page</a> <a class="button-secondary" href="http://wordpress.techgasp.com/facebook-comments-master-documentation/" target="_blank" title="Soundcloud Master Documentation">Documentation</a> <a class="button-primary" href="http://wordpress.org/plugins/facebook-comments-master/" target="_blank" title="Facebook Comments Master Wordpress">RATE US *****</a></p>
	<?php
	}
 }
?>