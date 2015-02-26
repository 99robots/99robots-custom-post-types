<?php
/*
Plugin Name: Gabfire Custom Post Type Beta
plugin URI:
Description: Creates a User Interface to add custom post types.
version: 0.9
Author: Kyle Benk
Author URI: http://kylebenkapps.com
License: GPL2
*/

/* Plugin Name */

if (!defined('GABFIRE_CUSTOM_POST_TYPE_PLUGIN_NAME'))
    define('GABFIRE_CUSTOM_POST_TYPE_PLUGIN_NAME', trim(dirname(plugin_basename(__FILE__)), '/'));

/* Plugin directory */

if (!defined('GABFIRE_CUSTOM_POST_TYPE_PLUGIN_DIR'))
    define('GABFIRE_CUSTOM_POST_TYPE_PLUGIN_DIR', WP_PLUGIN_DIR . '/' . GABFIRE_CUSTOM_POST_TYPE_PLUGIN_NAME);

/* Plugin url */

if (!defined('GABFIRE_CUSTOM_POST_TYPE_PLUGIN_URL'))
    define('GABFIRE_CUSTOM_POST_TYPE_PLUGIN_URL', WP_PLUGIN_URL . '/' . GABFIRE_CUSTOM_POST_TYPE_PLUGIN_NAME);

/* Plugin verison */

if (!defined('GABFIRE_CUSTOM_POST_TYPE_VERSION_NUM'))
    define('GABFIRE_CUSTOM_POST_TYPE_VERSION_NUM', '0.9.0');

/**
 * Activatation / Deactivation
 */

register_activation_hook( __FILE__, array('Gabfire_Custom_Post', 'register_activation'));
register_deactivation_hook(__FILE__, array('Gabfire_Custom_Post', 'flush_permalinks'));


/**
 * Hooks / Filter
 */

add_filter('getarchives_where', array('Gabfire_Custom_Post', 'archives_filter'));
add_action('admin_menu', array('Gabfire_Custom_Post','gabfire_menu'));
add_action('init', array('Gabfire_Custom_Post','gabfire_dashboard_register_custom_post'));
add_action('admin_enqueue_scripts', array('Gabfire_Custom_Post', 'gabfire_include_admin_scripts'));

add_action('init', array('Gabfire_Custom_Post', 'gabfire_load_textdoamin'));

$plugin = plugin_basename(__FILE__);
add_filter("plugin_action_links_$plugin", array('Gabfire_Custom_Post', 'gabfire_settings_link'));

class Gabfire_Custom_Post {

	private static $dashboard_page = 'gabfire-custom-post-dashboard';

	private static $add_new_page = 'gabfire-custom-post-add-new';

	private static $text_domain = 'gabfire-custom-post';

	private static $prefix = 'gabfire-custom-post-type-';

	/**
	 * Performs tasks needed upon activation
	 *
	 * @since 1.0.0
	 */
	static function register_activation() {

		/* Check if multisite, if so then save as site option */

		if (is_multisite()) {
			add_site_option('gabfire_custom_post_type_version', GABFIRE_CUSTOM_POST_TYPE_VERSION_NUM);
		} else {
			add_option('gabfire_custom_post_type_version', GABFIRE_CUSTOM_POST_TYPE_VERSION_NUM);
		}

		// Flush Rewirte rules

	    self::gabfire_dashboard_register_custom_post();
		self::flush_permalinks();
	}

	/**
	 * Calls the flush_rewrite_rules functions on activation and deactivation
	 *
	 * @access public
	 * @static
	 * @return void
	 */
	static function flush_permalinks() {
		flush_rewrite_rules();
	}

	/**
	 * Hooks to 'plugin_action_links_' filter
	 *
	 * @since 1.0.0
	 */
	static function gabfire_settings_link($links) {
		$settings_link = '<a href="admin.php?page=' . self::$dashboard_page . '">Settings</a>';
		array_unshift($links, $settings_link);
		return $links;
	}

	/**
	 * Load the text domain
	 *
	 * @since 1.0.0
	 */
	static function gabfire_load_textdoamin() {
		load_plugin_textdomain(self::$text_domain, false, basename( dirname( __FILE__ ) ) . '/languages' );
	}

	/**
	 * Get all custom post types for the archive widget
	 *
	 * @access public
	 * @static
	 * @param mixed $where_clause
	 * @return void
	 */
	static function archives_filter($where) {

		$gcpt_settings = array();

		/* Check if option had been created if not then create it */
		if (is_multisite()) {
			if (get_site_option('gabfire_custom_post_settings') === false) {
				add_site_option('gabfire_custom_post_settings','' ,'' ,'yes');
			}
			$gcpt_settings = get_site_option('gabfire_custom_post_settings');
		}else {
			if (get_option('gabfire_custom_post_settings') === false) {
				add_option('gabfire_custom_post_settings','' ,'' ,'yes');
			}
			$gcpt_settings = get_option('gabfire_custom_post_settings');
		}

		$custom_post_types = '';

		if (is_array($gcpt_settings)) {
			foreach ($gcpt_settings as $type => $args) {
				$custom_post_types .= " OR `post_type` = '" . $type . "'";
			}
		}

		return "WHERE (`post_type` = 'post'" . $custom_post_types . ") AND `post_status` = 'publish'";
	}

	/**
	 * Hook for the admin menu
	 *
	 * @since 1.0.0
	 */
	static function gabfire_menu() {
		add_menu_page(
			"Gabfire Custom Post Type",
			"Gabfire Custom Post Type",
			'manage_options',
			self::$dashboard_page,
			array('Gabfire_Custom_Post','gabfire_dashboard'));

		$gabfire_admin_page_list = add_submenu_page(
			self::$dashboard_page,
			"All Post Types",
			"All Post Types",
			'manage_options',
			self::$dashboard_page,
			array('Gabfire_Custom_Post','gabfire_dashboard'));

		add_action('load-' . $gabfire_admin_page_list, array('Gabfire_Custom_Post','gabfire_dashboard_help_list'));

		$gabfire_admin_page_new = add_submenu_page(
			self::$dashboard_page,
			"Add New",
			"Add New",
			'manage_options',
			self::$add_new_page,
			array('Gabfire_Custom_Post','gabfire_dashboard_add_new'));

		add_action('load-' . $gabfire_admin_page_new, array('Gabfire_Custom_Post','gabfire_dashboard_help_new'));

	 	/* add_submenu_page(self::$dashboard_page, "Help", "Help",'manage_options', "gabfire-custom-post-admin-help", array('Gabfire_Custom_Post','gabfire_dashboard_help')); */
	}

	/**
	 * Hook for the dashboard
	 *
	 * @since 1.0.0
	 */
	static function gabfire_dashboard() {

		require('admin/dashboard.php');

		wp_localize_script('gabfire_custom_post_js', 'gabfire_ahref_array', $gabfire_ahref_array);
	}

	/**
	 * Registers the custom post type
	 *
	 * @since 1.0.0
	 */
	static function gabfire_dashboard_register_custom_post() {

		$gcpt_settings = array();

		/* Check if option had been created if not then create it */
		if (is_multisite()) {
			if (get_site_option('gabfire_custom_post_settings') === false) {
				add_site_option('gabfire_custom_post_settings','' ,'' ,'yes');
			}
			$gcpt_settings = get_site_option('gabfire_custom_post_settings');
		}else {
			if (get_option('gabfire_custom_post_settings') === false) {
				add_option('gabfire_custom_post_settings','' ,'' ,'yes');
			}
			$gcpt_settings = get_option('gabfire_custom_post_settings');
		}

		if (is_array($gcpt_settings)) {
			/* Register all custom post types */

			foreach ($gcpt_settings as $type => $args) {
				register_post_type($type, $args);
			}
		}
	}

	/**
	 * Displays on the dashboard
	 *
	 * @since 1.0.0
	 */
	static function gabfire_dashboard_add_new() {

		/* Check if option had been created if not then create it */

		if (is_multisite()) {
			if (get_site_option('gabfire_custom_post_settings') === false) {
				add_site_option('gabfire_custom_post_settings','' ,'' ,'yes');
			}
			$gcpt_settings = get_site_option('gabfire_custom_post_settings');
		}else {
			if (get_option('gabfire_custom_post_settings') === false) {
				add_option('gabfire_custom_post_settings','' ,'' ,'yes');
			}
			$gcpt_settings = get_option('gabfire_custom_post_settings');
		}

		/* Deleting a Custom Post Type */

		if (isset($_GET['action']) && $_GET['action'] == "delete" && check_admin_referer('gabfire_custom_post_delete')) {
			if (isset($_GET['type']))
				unset($gcpt_settings[$_GET['type']]);

			if (is_multisite()) {
				update_site_option('gabfire_custom_post_settings', $gcpt_settings);
			}else {
				update_option('gabfire_custom_post_settings', $gcpt_settings);
			}

			?>
			<script type="text/javascript">
				window.location = "<?php echo $_SERVER['PHP_SELF']?>?page=<?php echo self::$dashboard_page; ?>";
			</script>
			<?php
		}

		/* Add new -Default- */

		$data = array(
			'description'		  => null,
			'public'              => true,
			'publicly_queryable'  => true,
			'exclude_from_search' => false,
			'show_in_nav_menus'   => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => '25',
			'menu_icon'           => null,
			'can_export'          => true,
			//'delete_with_user'    => false,
			'hierarchical'        => false,
			'has_archive'         => true,
			'query_var'           => true,
			'capability_type'     => 'post',
			'map_meta_cap'        => true,
			'rewrite' => true,
			'supports' => array(
				'title',
				'editor',
				'excerpt',
				'author',
				'thumbnail',
				'comments',
				'trackbacks',
				'custom-fields',
				'revisions',
				'page-attributes',
				'post-formats',
			),
			'labels' => array()
		);

		/* Edit Existing */

		if (isset($_GET['action']) && $_GET['action'] == "edit"/*  && check_admin_referer('gabfire_custom_post_add') */) {
			if (isset($_GET['type'])) {
				$data = $gcpt_settings[$_GET['type']];
			}
		}

		/* Save button is pressed */

		if (isset($_POST['gcpt_submit'])/*  && check_admin_referer('gabfire_custom_post_add') */) {

			/* Determine Roles and Capabilities */

			$cap_type = 'post';
			$capabilites = array();

			if (isset($_POST['gcpt_capability_type']) && $_POST['gcpt_capability_type'] != 'advanced') {
				$cap_type = sanitize_text_field($_POST['gcpt_capability_type']);
			}

			if (isset($_POST['gcpt_capability_type']) && $_POST['gcpt_capability_type'] == 'advanced') {

				if (isset($_POST['gcpt_capabilites_edit_post']) && $_POST['gcpt_capabilites_edit_post'] != '') {
					$capabilites['edit_post'] = sanitize_text_field($_POST['gcpt_capabilites_edit_post']);
				} else {
					$capabilites['edit_post'] = 'edit_post';
				}

				if (isset($_POST['gcpt_capabilites_read_post']) && $_POST['gcpt_capabilites_read_post'] != '') {
					$capabilites['read_post'] = sanitize_text_field($_POST['gcpt_capabilites_read_post']);
				} else {
					$capabilites['read_post'] = 'read_post';
				}

				if (isset($_POST['gcpt_capabilites_delete_post']) && $_POST['gcpt_capabilites_delete_post'] != '') {
					$capabilites['delete_post'] = sanitize_text_field($_POST['gcpt_capabilites_delete_post']);
				} else {
					$capabilites['delete_post'] = 'delete_post';
				}

				if (isset($_POST['gcpt_capabilites_edit_posts']) && $_POST['gcpt_capabilites_edit_posts'] != '') {
					$capabilites['edit_posts'] = sanitize_text_field($_POST['gcpt_capabilites_edit_posts']);
				} else {
					$capabilites['edit_posts'] = 'edit_posts';
				}

				if (isset($_POST['gcpt_capabilites_edit_others_posts']) && $_POST['gcpt_capabilites_edit_others_posts'] != '') {
					$capabilites['edit_others_posts'] = sanitize_text_field($_POST['gcpt_capabilites_edit_others_posts']);
				} else {
					$capabilites['edit_others_posts'] = 'edit_others_posts';
				}

				if (isset($_POST['gcpt_capabilites_publish_posts']) && $_POST['gcpt_capabilites_publish_posts'] != '') {
					$capabilites['publish_posts'] = sanitize_text_field($_POST['gcpt_capabilites_publish_posts']);
				} else {
					$capabilites['publish_posts'] = 'publish_posts';
				}

				if (isset($_POST['gcpt_capabilites_read_private_posts']) && $_POST['gcpt_capabilites_read_private_posts'] != '') {
					$capabilites['read_private_posts'] = sanitize_text_field($_POST['gcpt_capabilites_read_private_posts']);
				} else {
					$capabilites['read_private_posts'] = 'read_private_posts';
				}
			}

			/* Determine Supporting Festures */

			$supports = array();

			if (isset($_POST['gcpt_supports_title'])) $supports[] = 'title';
			if (isset($_POST['gcpt_supports_editor'])) $supports[] = 'editor';
			if (isset($_POST['gcpt_supports_excerpt'])) $supports[] = 'excerpt';
			if (isset($_POST['gcpt_supports_author'])) $supports[] = 'author';
			if (isset($_POST['gcpt_supports_thumbnail'])) $supports[] = 'thumbnail';
			if (isset($_POST['gcpt_supports_comments'])) $supports[] = 'comments';
			if (isset($_POST['gcpt_supports_trackbacks'])) $supports[] = 'trackbacks';
			if (isset($_POST['gcpt_supports_custom-fields'])) $supports[] = 'custom-fields';
			if (isset($_POST['gcpt_supports_revisions'])) $supports[] = 'revisions';
			if (isset($_POST['gcpt_supports_page-attributes'])) $supports[] = 'page-attributes';
			if (isset($_POST['gcpt_supports_post-formats'])) $supports[] = 'post-formats';

			if (count($supports) == 0) $supports = false;

			/* Determine Rewrite */

			if (isset($_POST['gcpt_rewrite']) && $_POST['gcpt_rewrite'] == 'true') {
				$rewrite = true;
			}else if (isset($_POST['gcpt_rewrite']) && $_POST['gcpt_rewrite'] == 'false') {
				$rewrite = false;
			}else if (isset($_POST['gcpt_rewrite']) && $_POST['gcpt_rewrite'] == 'advanced') {
				$rewrite = array(
					'with_front' => isset($_POST['gcpt_rewrite_with_front']) && $_POST['gcpt_rewrite_with_front'] ? true : false,
					'pages' 	 => isset($_POST['gcpt_rewrite_pages']) && $_POST['gcpt_rewrite_pages'] ? true : false,
					'feeds' 	 => isset($_POST['gcpt_rewrite_feeds']) && $_POST['gcpt_rewrite_feeds'] ? true : false
				);
				if (isset($_POST['gcpt_rewrite_slug'])) $rewrite['slug'] = sanitize_text_field($_POST['gcpt_rewrite_slug']);
			}

			$custom_post_type_id = substr(strtolower(str_replace(' ','',sanitize_text_field($_POST['gcpt']))), 0, 20);

			$custom_post_type_id_UC = ucfirst($custom_post_type_id);

			/* Determine Labels */

			$labels = array();

			!empty($_POST['gcpt_name']) ? $labels['name'] = sanitize_text_field($_POST['gcpt_name']) : $labels['name'] = $custom_post_type_id_UC;
			!empty($_POST['gcpt_singular_name']) ? $labels['singular_name'] = sanitize_text_field($_POST['gcpt_singular_name']) : $labels['singular_name'] = $custom_post_type_id_UC;
			!empty($_POST['gcpt_add_new']) ? $labels['add_new'] = sanitize_text_field($_POST['gcpt_add_new']) : $labels['add_new'] = 'Add New';
			!empty($_POST['gcpt_add_new_item']) ? $labels['add_new_item'] = sanitize_text_field($_POST['gcpt_add_new_item']) : $labels['add_new_item'] = 'Add New ' . $custom_post_type_id_UC;
			!empty($_POST['gcpt_edit_item']) ? $labels['edit_item'] = sanitize_text_field($_POST['gcpt_edit_item']) : $labels['edit_item'] = 'Edit ' . $custom_post_type_id_UC;
			!empty($_POST['gcpt_new_item']) ? $labels['new_item'] = sanitize_text_field($_POST['gcpt_new_item']) : $labels['new_item'] = 'New ' . $custom_post_type_id_UC;
			!empty($_POST['gcpt_all_items']) ? $labels['all_items'] = sanitize_text_field($_POST['gcpt_all_items']) : $labels['all_items'] = 'All ' . $custom_post_type_id_UC;
			!empty($_POST['gcpt_view_item']) ? $labels['view_item'] = sanitize_text_field($_POST['gcpt_view_item']) : $labels['view_item'] = 'View ' . $custom_post_type_id_UC;
			!empty($_POST['gcpt_search_items']) ? $labels['search_items'] = sanitize_text_field($_POST['gcpt_search_items']) : $labels['search_items'] = 'Search ' . $custom_post_type_id_UC;
			!empty($_POST['gcpt_not_found']) ? $labels['not_found'] = sanitize_text_field($_POST['gcpt_not_found']) : $labels['not_found'] = $custom_post_type_id_UC . ' not found';
			!empty($_POST['gcpt_not_found_in_trash']) ? $labels['not_found_in_trash'] = sanitize_text_field($_POST['gcpt_not_found_in_trash']) : $labels['not_found_in_trash'] = $custom_post_type_id_UC . ' not found in trash';
			!empty($_POST['gcpt_parent_item_colon']) ? $labels['parent_item_colon'] = sanitize_text_field($_POST['gcpt_parent_item_colon']) : $labels['parent_item_colon'] = 'Parent ' . $custom_post_type_id . ':';
			!empty($_POST['gcpt_menu_name']) ? $labels['menu_name'] = sanitize_text_field($_POST['gcpt_menu_name']) : $labels['menu_name'] = $custom_post_type_id_UC;
			!empty($_POST['gcpt_name_admin_bar']) ? $labels['name_admin_bar'] = sanitize_text_field($_POST['gcpt_name_admin_bar']) : $labels['name_admin_bar'] = $custom_post_type_id_UC;
			!empty($_POST['gcpt_parent_item']) ? $labels['parent_item'] = sanitize_text_field($_POST['gcpt_parent_item']) : $labels['parent_item'] = 'Parent ' . $custom_post_type_id;
			!empty($_POST['gcpt_archive_title']) ? $labels['archive_title'] = sanitize_text_field($_POST['gcpt_archive_title']) : $labels['archive_title'] = $custom_post_type_id_UC;

			/* Determine All Arguments */

			$args = array(
				'labels'             => $labels,
				'public'             => isset($_POST['gcpt_public']) && $_POST['gcpt_public'] ? true : false,
				'publicly_queryable' => isset($_POST['gcpt_publicly_queryable']) && $_POST['gcpt_publicly_queryable'] ? true : false,
				'show_ui'            => isset($_POST['gcpt_show_ui']) && $_POST['gcpt_show_ui'] ? true : false,
				'show_in_nav_menus'  => isset($_POST['gcpt_show_in_nav_menus']) && $_POST['gcpt_show_in_nav_menus'] ? true : false,
				'show_in_admin_bar'  => isset($_POST['gcpt_show_admin_bar']) && $_POST['gcpt_show_admin_bar'] ? true : false,
				'exclude_from_search'=> isset($_POST['gcpt_exclude_from_search']) && $_POST['gcpt_exclude_from_search'] ? true : false,
				'can_export'         => isset($_POST['gcpt_can_export']) && $_POST['gcpt_can_export'] ? true : false,
				//'delete_with_user'	 => isset($_POST['gcpt_delete_with_user']) && $_POST['gcpt_delete_with_user'] ? true : false,
				'map_meta_cap'	 	 => isset($_POST['gcpt_map_meta_cap']) && $_POST['gcpt_map_meta_cap'] ? true : false,
				'rewrite'            => $rewrite,
				'hierarchical'       => isset($_POST['gcpt_hierarchical']) && $_POST['gcpt_hierarchical'] ? true : false,
				'menu_position'      => isset($_POST['gcpt_menu_position']) ? (int) $_POST['gcpt_menu_position'] : null,
				'supports'           => $supports
			);

			/* Show in Menu bool/string */

			if (isset($_POST['gcpt_show_in_menu']) && $_POST['gcpt_show_in_menu'] == 'advanced') {
				$args['show_in_menu'] = sanitize_text_field($_POST['gcpt_show_in_menu_name']);
			} else if (isset($_POST['gcpt_show_in_menu']) && $_POST['gcpt_show_in_menu'] == 'true') {
				$args['show_in_menu'] = true;
			} else {
				$args['show_in_menu'] = false;
			}

			/* Has Archive bool/string */

			if (isset($_POST['gcpt_has_archive']) && $_POST['gcpt_has_archive'] && empty($_POST['gcpt_has_archive_name']))
				$args['has_archive'] = true;
			else if (isset($_POST['gcpt_has_archive']) && !$_POST['gcpt_has_archive'] && empty($_POST['gcpt_has_archive_name']))
				$args['has_archive'] = false;
			else if (!empty($_POST['gcpt_has_archive_name']))
				$args['has_archive'] = sanitize_text_field($_POST['gcpt_has_archive_name']);

			/* Query Variable bool/string */

			if (isset($_POST['gcpt_query_var']) && $_POST['gcpt_query_var'] && empty($_POST['gcpt_query_var_name']))
				$args['query_var'] = true;
			else if (isset($_POST['gcpt_query_var']) && !$_POST['gcpt_query_var'] && empty($_POST['gcpt_query_var_name']))
				$args['query_var'] = false;
			else if (!empty($_POST['gcpt_query_var_name']))
				$args['query_var'] = sanitize_text_field($_POST['gcpt_query_var_name']);

			if (!empty($_POST['gcpt_description'])) $args['description'] = sanitize_text_field($_POST['gcpt_description']);
			if (!empty($_POST['gcpt_menu_icon'])) $args['menu_icon'] = sanitize_text_field($_POST['gcpt_menu_icon']);

			if (isset($capabilites) && count($capabilites) > 0) {
				$args['capabilities'] = $capabilites;
			} else  {
				$args['capability_type'] = $cap_type;
			}

			/* Add/Edit and save custom post type */

			if (isset($_POST['gcpt']) && $_POST['gcpt'] != '') {

				/* Check if array key already exists */

				if (array_key_exists($custom_post_type_id, $gcpt_settings)) {

					/* if action is edit then update the option */
					if (isset($_GET['action']) && $_GET['action'] == "edit") {
						$gcpt_settings[$custom_post_type_id] = $args;

						if (is_multisite()) {
							update_site_option('gabfire_custom_post_settings', $gcpt_settings);
						}else {
							update_option('gabfire_custom_post_settings', $gcpt_settings);
						}

						/* Go back to the main dashboard */
						?>
						<script type="text/javascript">
							window.location = "<?php echo $_SERVER['PHP_SELF']?>?page=<?php echo self::$dashboard_page; ?>";
						</script>
						<?php
					}else {
						error_log(__('Gabfire Custom Post Type:: Cannot add duplicate custom post types.',self::$text_domain));

						/* Go back to the main dashboard */
						?>
						<script type="text/javascript">
							window.location = "<?php echo $_SERVER['PHP_SELF']?>?page=<?php echo self::$dashboard_page; ?>&error=duplicate";
						</script>
						<?php
					}
				}else {
					$gcpt_settings[$custom_post_type_id] = $args;

					if (is_multisite()) {
						update_site_option('gabfire_custom_post_settings', $gcpt_settings);
					}else {
						update_option('gabfire_custom_post_settings', $gcpt_settings);
					}

					/* Go back to the main dashboard */
					?>
					<script type="text/javascript">
						window.location = "<?php echo $_SERVER['PHP_SELF']?>?page=<?php echo self::$dashboard_page; ?>";
					</script>
					<?php
				}


			} else {
				error_log(__('Gabfire Custom Post Type:: Missing the required post type name field.',self::$text_domain));
			}
		}

		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-tabs');

		require('admin/add_edit.php');
	}

	/**
	 * Displays the help tab
	 *
	 * @since 1.0.0
	 */
	static function gabfire_dashboard_help_list() {
		$screen = get_current_screen();
		$screen->add_help_tab( array(
		    'id'      	=> 'gabfire-custom-post-help-list-overview', // This should be unique for the screen.
		    'title'   	=> 'Overview',
		    'content'	=> '',
		    'callback'	=> array('Gabfire_Custom_Post', 'gabfire_dashboard_help_list_overview')
		));
	}

	/**
	 * Displays the help tab
	 *
	 * @since 1.0.0
	 */
	static function gabfire_dashboard_help_new() {
		$screen = get_current_screen();
		$screen->add_help_tab( array(
		    'id'      	=> 'gabfire-custom-post-help-new-parameters', // This should be unique for the screen.
		    'title'   	=> 'Parameters',
		    'content'	=> '',
		    'callback'	=> array('Gabfire_Custom_Post', 'gabfire_dashboard_help_new_parameters')
		));
	}

	/**
	 * Displays the overview tab in the help tab in the all custom posts page
	 *
	 * @since 1.0.0
	 */
	static function gabfire_dashboard_help_list_overview() {
		?>
		<span><?php _e('This is an overview.',self::$text_domain); ?></span>
		<?php
	}

	/**
	 * Displays the parameter tab in the help tab in the add new custom post page
	 *
	 * @since 1.0.0
	 */
	static function gabfire_dashboard_help_new_parameters() {
		?>
		<a target="_blank" href="http://codex.wordpress.org/Function_Reference/register_post_type#Parameters"><?php _e('Parameters',self::$text_domain); ?></a>
		<?php
	}

	/**
	 * Include admin scripts
	 *
	 * @since 1.0.0
	 */
	static function gabfire_include_admin_scripts() {

		if (isset($_GET['page']) && ($_GET['page'] == self::$dashboard_page || $_GET['page'] == self::$add_new_page)) {
			wp_register_script('gabfire_custom_post_js', plugins_url( '/js/gabfire_custom_post.js', __FILE__ ), array('jquery'), false, true);
			wp_enqueue_script('gabfire_custom_post_js');
			wp_localize_script('gabfire_custom_post_js', 'gab_cpt_data', array('prefix' => self::$prefix));

			wp_register_style('gabfire_custom_post_css', plugins_url('/css/gabfire_custom_post.css', __FILE__));
			wp_enqueue_style('gabfire_custom_post_css');
		}
	}
}