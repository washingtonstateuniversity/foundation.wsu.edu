<?php

// If a featured image is assigned to the post, display as a background image.

if ( spine_has_background_image() ) {
	$background_image_src = spine_get_background_image_src();
	?>

	<style> #jacket { background-image: url(<?php echo esc_url( $background_image_src ); ?>); }</style>

<?php } ?>

<?php if ( spine_has_featured_image() ) {
	$featured_image_src = spine_get_featured_image_src();
	?>

	<style> .main-header { background-image: url(<?php echo esc_url( $featured_image_src ); ?>); }</style>

<?php } ?>

<section class="row single give-bar">
	<div class="column one ">
		<a href="https://foundation.wsu.edu/give/"><img class="alignnone size-medium" src="<?php echo esc_url( get_stylesheet_directory_uri() . '/images/foundation-give-icon.svg' ); ?>" alt="foundation-give-icon"> Give to WSU</a>
	</div>
</section>
