<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package themotion
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function themotion_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return $classes;
}
add_filter( 'body_class', 'themotion_body_classes' );

/**
 * Function which adds themotion-only-customizer class for customizer transport
 *
 * @param string $string String of classes to concat with the new class.
 * @param string $input Input to verify if the class should be added or not.
 *
 * @return string
 */
function themotion_show_in_customizer( $string, $input ) {
	if ( ( empty( $input ) || $input === false ) && is_customize_preview() ) {
		return $string . ' themotion-only-customizer';
	}
	return $string;
}
add_filter( 'themotion_show_in_customizer_filter', 'themotion_show_in_customizer', 10, 2 );


/**
 * Return thumbnail url from vimeo or youtube link.
 *
 * @param int $post_id Post id.
 *
 * @return bool|string
 */
function themotion_get_thumbnail_url( $post_id ) {

	$video_thumbnail_url = false;

	$content_post = get_post( $post_id );
	$content      = $content_post->post_content;
	$content      = apply_filters( 'the_content', $content );
	$content      = str_replace( ']]>', ']]&gt;', $content );

	// Only check the first 800 characters of our post.
	$content = substr( $content, 0, 800 );

	$do_video_thumbnail = (
		$post_id
		&& $content
		// Get the video and thumb URLs if they exist.
		&& ( preg_match( '/\/\/(www\.)?(youtu|youtube)\.(com|be)\/(watch|embed)?\/?(\?v=)?([a-zA-Z0-9\-\_]+)/', $content, $youtube_matches ) || preg_match( '#https?://(.+\.)?vimeo\.com/.*#i', $content, $vimeo_matches ) )
	);

	if ( ! $do_video_thumbnail ) {
		return $video_thumbnail_url;
	}

	$youtube_id = ! empty( $youtube_matches ) ? $youtube_matches[6] : '';

	$vimeo_id = '';
	if ( ! empty( $vimeo_matches ) ) {
		$data     = preg_replace( '/ .*$/m', '', $vimeo_matches[0] );
		$vimeo_id = preg_replace( '/[^0-9]/', '', $data );
	}

	if ( $youtube_id ) {
		// Check to see if our max-res image exists.
		$remote_headers      = wp_remote_head( 'http://img.youtube.com/vi/' . $youtube_id . '/maxresdefault.jpg' );
		$is_404              = ( 404 === wp_remote_retrieve_response_code( $remote_headers ) );
		$video_thumbnail_url = ( ! $is_404 ) ? 'http://img.youtube.com/vi/' . $youtube_id . '/maxresdefault.jpg' : 'http://img.youtube.com/vi/' . $youtube_id . '/sddefault.jpg';

	} elseif ( $vimeo_id ) {

		$vimeo_data = wp_remote_get( 'http://www.vimeo.com/api/v2/video/' . intval( $vimeo_id ) . '.php' );
		if ( isset( $vimeo_data['response']['code'] ) && '200' == $vimeo_data['response']['code'] ) {
			$response            = unserialize( $vimeo_data['body'] );
			$video_thumbnail_url = isset( $response[0]['thumbnail_large'] ) ? $response[0]['thumbnail_large'] : false;
		}
	}

	return $video_thumbnail_url;
}


/**
 * Display post video.
 *
 * @param array $embeds Embeds from post.
 */
function themotion_show_video_content( $embeds, $pid = false, $playnow = false ) {
	$video_type = themotion_video_type( $embeds[0] );
	switch ( $video_type ) {
		case 'youtube':
			$video_url = themotion_get_embeded_src( $embeds[0] );
			if ( ! empty( $video_url ) ) {
				$video_id = themotion_get_youtube_video_id( $video_url );
				if ( ! empty( $video_id ) ) {
					echo '<div class="youtube-player" data-id="' . esc_attr( $video_id ) . '">';
					if ( ! empty( $pid ) ) {
						$video_thumb_from_link = themotion_get_thumbnail_url( $pid );
						$image_url             = ! empty( $video_thumb_from_link ) ? $video_thumb_from_link : ( has_post_thumbnail( $pid ) ? get_the_post_thumbnail_url( $pid, 'themotion-post-thumbnail' ) : '' );
						if ( ! empty( $image_url ) ) { ?>
							<img src="<?php echo esc_url( $image_url ); ?>"/>
							<span class="themotion-video-play-button 
							<?php
							if ( $playnow === true ) {
								echo 'themotion-render-now';}
?>
">
									<i class="mejs-overlay-button themotion-play-icon"></i>
								</span>
							<?php
						}
					}
					echo '</div>';
				}
			}
			break;
		case 'vimeo':
			echo $embeds[0];
			break;
		case 'unknown':
			echo $embeds[0];
			break;
	}
}


/**
 * Show thumbnail for video posts.
 *
 * @param object $post Post.
 * @param array  $attr Thumbnail settings.
 */
function themotion_show_video_post_thumbnail( $post, $attr ) {
	$class       = $attr['class'];
	$placeholder = false;
	if ( array_key_exists( 'placeholder', $attr ) ) {
		$placeholder = $attr['placeholder'];
	}
	$post_id          = get_the_ID();
	$video_placholder = themotion_get_thumbnail_url( $post_id );
	$has_thumbnail    = has_post_thumbnail() || $video_placholder !== false || $placeholder !== false;
	if ( $has_thumbnail ) {
	?>
		<div class="<?php echo esc_attr( $class ); ?>">
			<?php
			if ( has_post_thumbnail() ) {
				the_post_thumbnail( 'post-thumbnail' );
			} elseif ( $video_placholder !== false ) {
			?>
				<img src="<?php echo esc_url( $video_placholder ); ?>">
				<?php
			} else {
			?>
				<img width="790" height="200" src="<?php echo esc_url( get_template_directory_uri() . '/images/default-thumbnail.jpg' ); ?>" class="attachment-post-thumbnail wp-post-image" alt="">
				<?php
			}
				?>
			<span class="themotion-video-play-button">
				<i class="mejs-overlay-button themotion-play-icon"></i>
			</span>
		</div>
		<?php
		$content    = apply_filters( 'the_content', $post->post_content );
		$embeds     = get_media_embedded_in_content( $content );
		$video_type = ! empty( $embeds ) ? themotion_video_type( $embeds[0] ) : '';
		?>
		<div class="themotion-lightbox" 
		<?php
		if ( ! empty( $video_type ) ) {
			echo 'data-type="' . esc_attr( $video_type ) . '"'; }
?>
>
			<div class="themotion-lightbox-inner">
				<?php
				if ( ! empty( $embeds ) ) {
					themotion_show_video_content( $embeds );
				}
				?>
			</div>
		</div>
		<?php
	}
}
