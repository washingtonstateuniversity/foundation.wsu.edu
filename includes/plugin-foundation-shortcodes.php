<?php

class WSU_Foundation_Shorcodes {
	public function __construct() {
		add_shortcode( 'foundation_ways_to_give', array( $this, 'display_ways_to_give' ) );
	}

	public function display_ways_to_give() {
		ob_start();
		?>
		<iframe src="https://ww2.matchinggifts.com/wsu" width="100%" height="1000" scrolling="auto" frameborder="0"></iframe>
		<?php
		$content = ob_get_contents();
		ob_end_clean();

		return $content;
	}
}
new WSU_Foundation_Shorcodes();
