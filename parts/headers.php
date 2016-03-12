<?php

$spine_main_header_values = spine_get_main_header();

if ( spine_get_option( 'main_header_show' ) == 'true' ) : ?>
	<header class="main-header">
		<div class="header-group hgroup guttered padded-bottom short">
			<?php if ( is_singular( 'post' ) ) : ?>
				<sub class="sub-header">WSU Fundraising News</sub>
			<?php else: ?>
				<sub class="sub-header"><span class="sub-header-default"><?php echo strip_tags( $spine_main_header_values['sub_header_default'], '<a>' ); ?></span></sub>
			<?php endif; ?>
		</div>
	</header>
<?php endif;
