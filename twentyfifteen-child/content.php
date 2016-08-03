<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
		// Post thumbnail.
//twentyfifteen_post_thumbnail();
$ID = get_the_ID();
$md = get_post_custom();
$attachment_url = wp_get_attachment_url( get_post_thumbnail_id( $ID ) );
$content = do_shortcode(get_the_content());
$attrs = array('class' => 'noclick', 'data-jslghtbx' => $attachment_url, 'data-jslghtbx-caption' => $content);
//$postcard = do_shortcode(get_post_meta($ID, 'event_postcard', true));
$postcard = do_shortcode( isset($md['event_postcard'][0]) ? $md['event_postcard'][0] : '' );
if ( has_post_thumbnail() ) {
    $post_thumbnail_img = get_the_post_thumbnail(null, 'thumbnail', $attrs);
} else {
    $thumbnail_ID = get_image_ID_by_slug('1pixel');
    set_post_thumbnail( $post, $thumbnail_ID );
    $post_thumbnail_img = get_the_post_thumbnail(null, 'thumbnail', $attrs);
}
?>
<div class="event">
                <div class="postcard">
                    <div class="thumbnail"><?php echo $post_thumbnail_img ?></div>
                      <div class='details'><?php echo $postcard; ?></div>
                    </div>
                </div>
                <hr>

	<div class="modal">
        <?php echo $post_thumbnail_img; ?>
		<?php echo $content; ?>
	</div>
</div>
</article>
