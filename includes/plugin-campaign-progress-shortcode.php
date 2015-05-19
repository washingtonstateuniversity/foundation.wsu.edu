<?php

class WSU_Foundation_Campaign_Progress {
	/**
	 * @var string
	 */
	public static $content_type_slug = 'fnd_progress_bar';

	/**
	 * @var string
	 */
	var $goal_dollars_meta_key = '_fnd_goal_dollars';

	/**
	 * @var string
	 */
	var $goal_current_meta_key = '_fnd_goal_current';

	/**
	 * @var string
	 */
	var $goal_updated_meta_key = '_fnd_goal_updated';

	/**
	 * Setup the plugin.
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'register_content_type' ) );
		add_action( 'init', array( $this, 'setup_shortcode_ui' ) );
		add_shortcode( 'campaign_progress_bar', array( $this, 'display_campaign_progress_bar' ) );
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ), 10 );
		add_action( 'save_post', array( $this, 'save_post' ), 10, 2 );
	}

	/**
	 * Register the content type to be used for HTML Snippets
	 */
	public function register_content_type() {
		$labels = array(
			'name' => 'Progress Bars',
			'singular_name' => 'Progress Bar',
			'add_new' => 'Add New',
			'add_new_item' => 'Add New Progress Bar',
			'edit_item' => 'Edit Progress Bar',
			'new_item' => 'New Progress Bar',
			'all_items' => 'All Progress Bars',
			'view_item' => 'View Progress Bars',
			'search_items' => 'Search Progress Bars',
			'not_found' => 'No progress bars found',
			'not_found_in_trash' => 'No progress bars found in Trash',
			'menu_name' => 'Progress Bars',
		);

		$args = array(
			'labels'             => $labels,
			'public'             => false,
			'publicly_queryable' => false,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => false,
			'has_archive'        => false,
			'hierarchical'       => false,
			'supports'           => array( 'title' ),
		);
		register_post_type( $this::$content_type_slug, $args );
	}

	/**
	 * Display an Progress Bar shortcode given attributes.
	 *
	 * @param array $atts
	 *
	 * @return string
	 */
	public function display_campaign_progress_bar( $atts ) {
		$default_atts = array(
			'id' => 0,
		);
		$atts = wp_parse_args( $atts, $default_atts );

		if ( empty( $atts['id'] ) || 0 === absint( $atts['id'] ) ) {
			return '';
		}

		$post = get_post( $atts['id'] );

		if ( ! $post || $this::$content_type_slug !== $post->post_type ) {
			return '';
		}

		// Round dollar amounts to two decimal points and then use floatval to reduce the 0s.
		$goal_dollars = round( get_post_meta( $post->ID, $this->goal_dollars_meta_key, true ), 2 );
		$goal_dollars = floatval( $goal_dollars );

		$goal_current = round( get_post_meta( $post->ID, $this->goal_current_meta_key, true ), 2 );
		$goal_current = floatval( $goal_current );

		// Round the calculated percentage of dollar amounts to 2 decimal points.
		$goal_perc = round( ( $goal_current / $goal_dollars ) * 100, 2 );

		$goal_updated = get_post_meta( $post->ID, $this->goal_updated_meta_key, true );

		$output = '<div class="campaign-progress-bar campaign-progress-bar-slug">
				<div class="campaign-area-name">
					' . esc_html( $post->post_title ) . '
				</div>
				<div class="campaign-goal">
					<span class="campaign-goal-text">Campaign Goal:</span> <span class="campaign-goal-value">$' . $goal_dollars . ' million</span>
				</div>
				<div class="campaign-progress">
					<span class="progress-bar" style="width: ' . $goal_perc . '%;"></span>
					<div class="progress-percent">$' . $goal_current . ' (' . $goal_perc . '%)</div>
				</div>
				<div class="campaign-updated">In Millions as of ' . esc_html( $goal_updated ) . '</div>
			</div>';

		return $output;
	}

	/**
	 * Configure support for the Progress Bar shortcode with Shortcode UI.
	 */
	public function setup_shortcode_ui() {
		if ( ! function_exists( 'shortcode_ui_register_for_shortcode' ) ) {
			return;
		}

		$args = array(
			'label'         => 'Progress Bar',
			'listItemImage' => 'dashicons-editor-quote',
			'post_type'     => array( 'post', 'page' ),
			'attrs'         => array(
				array(
					'label'    => 'Select Progress Bar',
					'attr'     => 'id',
					'type'     => 'post_select',
					'query'    => array( 'post_type' => $this::$content_type_slug ),
					'multiple' => false,
				),
			),
		);
		shortcode_ui_register_for_shortcode( 'campaign_progress_bar', $args );
	}

	public function add_meta_boxes( $post_type ) {
		if ( ! in_array( $post_type, array( $this::$content_type_slug ) ) ) {
			return;
		}

		add_meta_box( 'fnd_progress_bar_data', 'Progress Bar Data', array( $this, 'display_progress_bar_metabox' ), null, 'normal', 'high' );
	}

	public function display_progress_bar_metabox( $post ) {
		$goal_dollars = get_post_meta( $post->ID, $this->goal_dollars_meta_key, true );
		$goal_current = get_post_meta( $post->ID, $this->goal_current_meta_key, true );
		$goal_updated = get_post_meta( $post->ID, $this->goal_updated_meta_key, true );

		wp_nonce_field( 'fnd-progress-bar-nonce', '_fnd_progress_bar_nonce' );
		?>
		<label for="goal-dollars">Campaign Goal (dollars):</label>
		<input type="text" class="widefat" id="goal-dollars" name="goal_dollars" value="<?php echo esc_attr( $goal_dollars ); ?>" />
		<p class="description">Enter the goal in dollars for this campaign.</p>

		<label for="goal-current">Campaign Current (dollars):</label>
		<input type="text" class="widefat" id="goal-current" name="goal_current" value="<?php echo esc_attr( $goal_current ); ?>" />
		<p class="description">Enter the current status of the campaign in dollars.</p>

		<label for="goal-updated">Last Updated:</label>
		<input type="text" class="widefat" id="goal-updated" name="goal_updated" value="<?php echo esc_attr( $goal_updated ); ?>" />
		<p class="description">Enter the date the current status was last updated.</p>
	<?php
	}

	/**
	 * Save the subtitle and call to action assigned to the post.
	 *
	 * @param int     $post_id ID of the post being saved.
	 * @param WP_Post $post    Post object of the post being saved.
	 */
	public function save_post( $post_id, $post ) {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( ! in_array( $post->post_type, array( $this::$content_type_slug ) ) ) {
			return;
		}

		if ( 'auto-draft' === $post->post_status ) {
			return;
		}

		if ( ! isset( $_POST['_fnd_progress_bar_nonce'] ) || false === wp_verify_nonce( $_POST['_fnd_progress_bar_nonce'], 'fnd-progress-bar-nonce' ) ) {
			return;
		}

		if ( isset( $_POST['goal_dollars'] ) ) {
			update_post_meta( $post_id, $this->goal_dollars_meta_key, round( $_POST['goal_dollars'], 2 ) );
		}

		if ( isset( $_POST['goal_current'] ) ) {
			update_post_meta( $post_id, $this->goal_current_meta_key, round( $_POST['goal_current'], 2 ) );
		}

		if ( isset( $_POST['goal_updated'] ) ) {
			update_post_meta( $post_id, $this->goal_updated_meta_key, sanitize_text_field( $_POST['goal_updated'] ) );
		}

	}
}
new WSU_Foundation_Campaign_Progress();