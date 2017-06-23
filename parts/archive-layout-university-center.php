<div class="main-head-over-write">
<header class="main-header">
	<div class="header-group hgroup guttered padded-bottom short">

		<sup class="sup-header" data-section="WSU Foundation" data-pagetitle="Lisa Abrahamsson" data-posttitle="Lisa Abrahamsson" data-default="<a href=&quot;http://foundation.wsu.dev/&quot; rel=&quot;home&quot;>WSU Foundation</a>" data-alternate=""><span class="sup-header-default"><a href="http://foundation.wsu.dev/" rel="home">WSU Foundation</a></span></sup>
		<sub class="sub-header" data-sitename="WSU Foundation" data-pagetitle="Lisa Abrahamsson" data-posttitle="Lisa Abrahamsson" data-default="Archives" data-alternate=""><span class="sub-header-default">Contact us</span></sub>

	</div>
</header>
</div>
	<section class="row single give-bar">
	<div class="column one ">
		<a href="https://foundation.wsu.edu/give/" class="tracked" role="click_click_internal"><img class="alignnone size-medium" src="https://stage.foundation.wsu.edu/wp-content/themes/wsu-foundation-theme/images/foundation-give-icon.svg" alt="foundation-give-icon"> Give to WSU</a>
	</div>
</section>
<section class="row side-right gutter pad-ends entity-section">
	<div id="people-list" class="column one">
		<div class="filter-container">
			<span class="filter-text">Filter:</span> <input type="text" class="filter-input" id="filter-people" value="" />
		</div>

		<?php while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'articles/post', get_post_type() ); ?>

		<?php endwhile; // end of the loop. ?>

	</div><!--/column-->

	<div class="column two uc-sidebar-color">

<h4>WSU Foundation Central Office</h4>
<p class="indent">Town Centre Building, 3rd Floor<br>
255 E. Main Street, Suite 301<br>
PO Box 641925<br>
Pullman, WA 99164-1925<br>
Phone: 509-335-6686 or 800-GIV-2-WSU (448-2978)<br>
Fax: 509-335-8419<br>
Email: <a href="mailto:foundation@wsu.edu" class="tracked" role="click_click_email">foundation@wsu.edu</a></p>
<h4>Seattle Office</h4>
<p class="indent">Washington State University Seattle Office<br>
901 Fifth Avenue, Suite 2900<br>
Seattle, WA 98164<br>
Phone: 206-448-1330</p>

	</div><!--/column-->
</section>
