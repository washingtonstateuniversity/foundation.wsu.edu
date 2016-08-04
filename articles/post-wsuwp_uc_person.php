<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php if ( ! is_singular() ) : ?>
		<header class="article-header">
				<?php
				if ( has_post_thumbnail() ) {
					?><figure class="article-thumbnail"><?php the_post_thumbnail( array( 88, 132, true ) ); ?></figure><?php
				}

				if ( function_exists( 'wsuwp_uc_get_meta' ) ) {
					$display_fields = array( 'prefix', 'first_name', 'last_name', 'suffix', 'title', 'title_secondary', 'office', 'email', 'phone' );
					$display_data = array();
					foreach( $display_fields as $df ) {
						$display_data[ $df ] = wsuwp_uc_get_meta( get_the_ID(), $df );
					}

					// Create the name for display. If a first and last name are set, then look for a suffix and attach.
					if ( ! empty( trim( $display_data['first_name'] ) ) && ! empty( trim( $display_data['last_name'] ) ) ) {
						$display_name = trim( $display_data['first_name'] . ' ' . $display_data['last_name'] );

						if ( ! empty( $display_data['suffix'] ) ) : $display_name .= ', ' . $display_data['suffix']; endif;
					}

					// If no display name is available, use the title.
					if ( empty( $display_name ) ) : $display_name = get_the_title(); endif; ?>

					<span class="article-title"><?php echo esc_html( $display_name ); ?></span><?php

					if ( ! empty( $display_data['title'] ) ) : ?><span class="person-title"><?php echo esc_html( $display_data['title'] ); ?></span><?php endif;
					if ( ! empty( $display_data['title_secondary'] ) ) : ?><span class="person-title-secondary"><?php echo esc_html( $display_data['title_secondary'] ); ?></span><?php endif;
					if ( ! empty( $display_data['office'] ) ) : ?><span class="person-office"><?php echo esc_html( $display_data['office'] ); ?></span><?php endif;
					if ( ! empty( $display_data['phone'] ) ) : ?><span class="person-phone"><?php echo esc_html( $display_data['phone'] ); ?></span><?php endif;
					if ( ! empty( $display_data['email'] ) ) : ?><span class="person-email"><a href="mailto:<?php echo esc_html( $display_data['email'] ); ?>"><?php echo esc_html( $display_data['email'] ); ?></a></span><?php endif;

				} ?>
		</header>
	
		<div class="article-summary">
			<?php the_content(); ?>
			<?php
			// If a manual excerpt is available, display this. Otherwise, only the most basic information is needed.
			if ( $post->post_excerpt ) {
				echo get_the_excerpt();
			}
			?>
		</div><!-- .article-summary -->
	<?php else : ?>
		<div class="article-body">

			<?php the_content(); ?>
		</div>
	<?php endif; ?>

</article>
