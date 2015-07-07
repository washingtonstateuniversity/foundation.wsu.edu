<?php

class WSU_Foundation_Shorcodes {
	public function __construct() {
		add_shortcode( 'foundation_ways_to_give', array( $this, 'display_ways_to_give' ) );
	}

	public function display_ways_to_give() {
		ob_start();
		?>
		<form action="http://www.matchinggifts.com/wsu/giftdb.cfm" method="POST">
			<input name="INPUT_ORGNAME" size="40" value="Type employer or company name here" onblur="if(value=='') value = 'Type employer or company name here'" onfocus="if(value=='Type employer or company name here') value = ''" type="text">
			<input class="search_button" value="Search" type="submit"> <input value="Clear" type="reset">
			<input name="INPUT_ORGNAME_required" value="You must input a company name" type="hidden">
			<input name="eligible" value="ALL" type="hidden">
		</form>
		<?php
		$content = ob_get_contents();
		ob_end_clean();

		return $content;
	}
}
new WSU_Foundation_Shorcodes();