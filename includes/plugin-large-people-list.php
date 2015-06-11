<?php

class WSU_Foundation_Large_People_List {
	/**
	 * @var string
	 */
	public static $content_type_slug = 'fnd_people_list';

	/**
	 * @var string
	 */
	var $people_list_meta_key = '_fnd_people_list';

	/**
	 * Setup the plugin.
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'register_content_type' ) );
		add_action( 'init', array( $this, 'setup_shortcode_ui' ) );
		add_shortcode( 'foundation_honor_roll', array( $this, 'display_honor_roll' ) );
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ), 10 );
		add_action( 'save_post', array( $this, 'save_post' ), 10, 2 );
	}

	/**
	 * Register the content type to be used to track Honor Roll lists.
	 */
	public function register_content_type() {
		$labels = array(
			'name' => 'Honor Rolls',
			'singular_name' => 'Honor Roll',
			'add_new' => 'Add New',
			'add_new_item' => 'Add New Honor Roll',
			'edit_item' => 'Edit Honor Roll',
			'new_item' => 'New Honor Roll',
			'all_items' => 'All Honor Rolls',
			'view_item' => 'View Honor Rolls',
			'search_items' => 'Search Honor Rolls',
			'not_found' => 'No Honor Rolls found',
			'not_found_in_trash' => 'No Honor Rolls found in Trash',
			'menu_name' => 'Honor Rolls',
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
	 * Display an Honor Roll shortcode given attributes.
	 *
	 * @param array $atts
	 *
	 * @return string
	 */
	public function display_honor_roll( $atts ) {
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

		$list_of_people = get_post_meta( $post->ID, $this->people_list_meta_key, true );

		$display_people_list = '<ul>';
		if ( is_array( $list_of_people ) && ! empty( $list_of_people ) ) {
			foreach( $list_of_people as $person ) {
				$display_people_list .= '<li>' . esc_html( $person ) . '</li>';
			}
		}
		$display_people_list .= '</ul>';
		return $display_people_list;
	}

	/**
	 * Configure support for the Honor Roll shortcode with Shortcode UI.
	 */
	public function setup_shortcode_ui() {
		if ( ! function_exists( 'shortcode_ui_register_for_shortcode' ) ) {
			return;
		}

		$args = array(
			'label'         => 'Honor Roll',
			'listItemImage' => 'dashicons-awards',
			'post_type'     => array( 'page' ),
			'attrs'         => array(
				array(
					'label'    => 'Select Honor Roll',
					'attr'     => 'id',
					'type'     => 'post_select',
					'query'    => array( 'post_type' => $this::$content_type_slug ),
					'multiple' => false,
				),
			),
		);
		shortcode_ui_register_for_shortcode( 'foundation_honor_roll', $args );
	}

	public function add_meta_boxes( $post_type ) {
		if ( ! in_array( $post_type, array( $this::$content_type_slug ) ) ) {
			return;
		}
		add_meta_box( 'fnd_honor_roll_data', 'Donors', array( $this, 'display_people_list_meta_box' ), null, 'normal', 'high' );
	}

	public function display_people_list_meta_box( $post ) {
		$people_list = get_post_meta( $post->ID, $this->people_list_meta_key, true );

		wp_nonce_field( 'fnd-honor-roll-nonce', '_fnd_honor_roll_nonce' );

		$display_people_list = '';
		if ( is_array( $people_list ) && ! empty( $people_list ) ) {
			foreach( $people_list as $person ) {
				$display_people_list .= esc_html( $person ) . "\n";
			}
		}

		?>
		<label for="people-list">Enter people:</label>
		<textarea name="people_list" id="people-list" style="width: 100%; height: 400px;"><?php echo $display_people_list; ?></textarea>
		<p class="description">Enter a list of people to display on the honor roll, one on each line.</p>
		<?php
	}

	/**
	 * Save the list of people assigned to an honor roll.
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

		if ( ! isset( $_POST['_fnd_honor_roll_nonce'] ) || false === wp_verify_nonce( $_POST['_fnd_honor_roll_nonce'], 'fnd-honor-roll-nonce' ) ) {
			return;
		}

		if ( isset( $_POST['people_list'] ) ) {
			$people_list = $_POST['people_list'];
			$people_list = explode( "\n", $people_list );

			$clean_people_list = array();

			foreach( $people_list as $person ) {
				$clean_people_list[] = trim( sanitize_text_field( $person ) );
			}

			update_post_meta( $post_id, $this->people_list_meta_key, $people_list );
		}
	}
}
new WSU_Foundation_Large_People_List();