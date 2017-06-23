<section class="row single give-bar">
	<div class="column one ">
		<a href="https://foundation.wsu.edu/give/"><img class="alignnone size-medium" src="<?php echo esc_url( get_stylesheet_directory_uri() . '/images/foundation-give-icon.svg' ); ?>" alt="foundation-give-icon"> Give to WSU</a>
	</div>
</section>

<section class="row side-right gutter pad-ends">

	<div class="column one">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'articles/post', get_post_type() ); ?>

		<?php endwhile; // end of the loop. ?>

	</div><!--/column-->

	<div class="column two">

		<?php get_sidebar(); ?>

	</div><!--/column two-->

</section>
