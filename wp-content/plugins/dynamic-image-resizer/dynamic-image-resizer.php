<?php /*
Plugin Name: Dynamic Image Resizer
Plugin URI: http://ottopress.com
Description: Change the WordPress image uploader system to do image resizing on the fly.
Author: Otto42
Author URI: http://ottodestruct.com
Version: 1.0
*/

// disable plugin on multisite
if (is_multisite()) return;

// do the dynamic resizing of the image when the 404 handler is invoked and it's for a non-existant image
add_action('template_redirect', 'dynimg_404_handler');
function dynimg_404_handler() { 
	if ( !is_404() ) return;
	
	if (preg_match('/(.*)-([0-9]+)x([0-9]+)(c)?\.(jpg|png|gif)/i',$_SERVER['REQUEST_URI'],$matches)) {
		$filename = $matches[1].'.'.$matches[5];
		$width = $matches[2];
		$height = $matches[3];
		$crop = !empty($matches[4]);
		
		$uploads_dir = wp_upload_dir();
		$temp = parse_url($uploads_dir['baseurl']);
		$upload_path = $temp['path'];
		$findfile = str_replace($upload_path, '', $filename);
		
		$basefile = $uploads_dir['basedir'].$findfile;
		
		$suffix = $width.'x'.$height;
		if ($crop) $suffix .='c';
	
		if ( file_exists($basefile) ) {
			// we have the file, so call the wp function to actually resize the image
//			$resized = image_resize($basefile, $width, $height, $crop, $suffix);
            $resized = image_resize($basefile, $width, $height, true, $suffix);
			
			// find the mime type
			foreach ( get_allowed_mime_types( ) as $exts => $mime ) {
				if ( preg_match( '!^(' . $exts . ')$!i', $matches[5] ) ) {
					$type = $mime;
					break;
				}
			}

			// serve the image this one time (next time the webserver will do it for us)
			header( 'Content-Type: '.$type );
			header( 'Content-Length: ' . filesize($resized) );
			readfile($resized);
			exit;
		}
	}
}

// prevent WP from generating resized images on upload
add_filter('intermediate_image_sizes_advanced','dynimg_image_sizes_advanced');
function dynimg_image_sizes_advanced($sizes) {
	global $dynimg_image_sizes;
	
	// save the sizes to a global, because the next function needs them to lie to WP about what sizes were generated
	$dynimg_image_sizes = $sizes;

	// force WP to not make sizes by telling it there's no sizes to make
	return array();
}

// trick WP into thinking images were generated anyway
add_filter('wp_generate_attachment_metadata','dynimg_generate_metadata');
function dynimg_generate_metadata($meta) {
	global $dynimg_image_sizes;
			
	foreach ($dynimg_image_sizes as $sizename => $size) {
		// figure out what size WP would make this:
		$newsize = image_resize_dimensions($meta['width'], $meta['height'], $size['width'], $size['height'], $size['crop']);

		if ($newsize) {
			$info = pathinfo($meta['file']);
			$ext = $info['extension'];
			$name = wp_basename($meta['file'], ".$ext");

			$suffix = "{$newsize[4]}x{$newsize[5]}";
			if ($size['crop']) $suffix .='c';

			// build the fake meta entry for the size in question
			$resized = array(
				'file' => "{$name}-{$suffix}.{$ext}",
				'width' => $newsize[4],
				'height' => $newsize[5],
			);

			$meta['sizes'][$sizename] = $resized;
		}
	}
	
	return $meta;
}

function swe_wp_get_attachment_image_src($attachment_id, $size='thumbnail', $icon = false) {
    
    if (is_array($size)){
        $arr = wp_get_attachment_image_src($attachment_id, 'full', $icon = false);
        $img_src = $arr[0];
        if (preg_match('/(.*)\.(jpg|png|gif)/i',$img_src,$matches)) {
            $arr[0] = "{$matches[1]}-{$size[0]}x{$size[1]}.{$matches[2]}";
            $arr[1] = $size[0];
            $arr[2] = $size[1];
        }
        
    }  else {
        $arr = wp_get_attachment_image_src($attachment_id, $size, $icon = false);
    }
    return $arr;
}
function swe_wp_get_attachment_image($attachment_id, $size = 'thumbnail', $icon = false, $attr = ''){
    	$html = '';
	$image = swe_wp_get_attachment_image_src($attachment_id, $size, $icon); 
	if ( $image ) {
		list($src, $width, $height) = $image;
		$hwstring = image_hwstring($width, $height);
		if ( is_array($size) )
			$size = join('x', $size);
		$attachment = get_post($attachment_id);
		$default_attr = array(
			'src'	=> $src,
			'class'	=> "attachment-$size",
			'alt'	=> trim(strip_tags( get_post_meta($attachment_id, '_wp_attachment_image_alt', true) )), // Use Alt field first
		);
		if ( empty($default_attr['alt']) )
			$default_attr['alt'] = trim(strip_tags( $attachment->post_excerpt )); // If not, Use the Caption
		if ( empty($default_attr['alt']) )
			$default_attr['alt'] = trim(strip_tags( $attachment->post_title )); // Finally, use the title

		$attr = wp_parse_args($attr, $default_attr);

		/**
		 * Filter the list of attachment image attributes.
		 *
		 * @since 2.8.0
		 *
		 * @param mixed $attr          Attributes for the image markup.
		 * @param int   $attachment_id Image attachment ID.
		 */
		$attr = apply_filters( 'wp_get_attachment_image_attributes', $attr, $attachment );
		$attr = array_map( 'esc_attr', $attr );
		$html = rtrim("<img $hwstring");
		foreach ( $attr as $name => $value ) {
			$html .= " $name=" . '"' . $value . '"';
		}
		$html .= ' />';
	}

	return $html;
}
