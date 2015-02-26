<div class="wrap gabfire-plugin-settings">

	<?php require_once('header.php'); ?>

	<div class="metabox-holder has-right-sidebar">

		<?php require_once('sidebar.php'); ?>

		<div id="post-body">
			<div id="post-body-content">

				<div class="wrap">
					<div id="icon-edit" class="icon32 icon32-posts-post"><br/></div>
					<h2><?php _e('Gabfire Custom Post Types',self::$text_domain); ?><a class="add-new-h2" href="<?php echo wp_nonce_url($_SERVER['PHP_SELF'] . '?page=' . self::$add_new_page, 'gabfire_custom_post_add'); ?>"><?php _e('Add New', self::$text_domain); ?></a></h2>

				<br />

				<!-- Detect errors -->
				<?php if (isset($_GET['error']) && $_GET['error'] == 'duplicate') { ?>
					<h3 style="color:red"><?php _e('Error: Cannot add duplicate custom post type', self::$text_domain); ?></h3>
				<?php } ?>

				<table class="wp-list-table widefat fixed posts">
					<thead>
						<tr>
							<th><?php _e('Post Type', self::$text_domain); ?></th>
							<th><?php _e('Name', self::$text_domain); ?></th>
							<th><?php _e('Description', self::$text_domain); ?></th>
							<th><?php _e('Public', self::$text_domain); ?></th>
							<th><?php _e('Hierarchical', self::$text_domain); ?></th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th><?php _e('Post Type', self::$text_domain); ?></th>
							<th><?php _e('Name', self::$text_domain); ?></th>
							<th><?php _e('Description', self::$text_domain); ?></th>
							<th><?php _e('Public', self::$text_domain); ?></th>
							<th><?php _e('Hierarchical', self::$text_domain); ?></th>
						</tr>
					</tfoot>
					<tbody>
					<?php
						$gcpt_settings = array();
						$gabfire_ahref_array = array();

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
							/* Loop through all custom post types */

							foreach ($gcpt_settings as $type => $args) {
								$gabfire_ahref_array[] = $type;
								?>
								<tr>
									<!-- Post Type -->
									<td>
										<a href="<?php echo wp_nonce_url($_SERVER['PHP_SELF'] . '?page=' . self::$add_new_page .'&type=' . $type . '&action=edit', 'gabfire_custom_post_add'); ?>"><strong><?php _e($type,self::$text_domain); ?></strong></a>
									</td>

									<!-- Name -->
									<td>
										<label><?php echo (isset($args['labels']['name']) ?  __($args['labels']['name'], self::$text_domain) : 'N/A'); ?></label>

										<div class="row-actions">
											<span class="edit">
												<a href="<?php echo wp_nonce_url($_SERVER['PHP_SELF'] . '?page=' . self::$add_new_page .'&type=' . $type . '&action=edit', 'gabfire_custom_post_add'); ?>"><?php _e('Edit',self::$text_domain); ?></a> |
											</span>

											<span class="trash">
												<a href="#" id="<?php echo self::$prefix; ?>delete-<?php echo $type; ?>" class="<?php echo self::$prefix; ?>delete"><?php _e('Delete', self::$text_domain); ?></a>
											<span id="gabfire_custom_post_type_delete_url_<?php echo $type; ?>" style="display:none;"><?php echo wp_nonce_url($_SERVER['PHP_SELF'] . '?page=' . self::$add_new_page .'&type=' . $type . '&action=delete', 'gabfire_custom_post_delete'); ?></span>
											</span>
										</div>
									</td>

									<!-- Description -->
									<td> <?php echo (isset($args['description']) ? __($args['description'],self::$text_domain) : 'N/A'); ?> </td>

									<!-- Public -->
									<td> <?php echo (isset($args['public']) && $args['public'] ? __('yes',self::$text_domain) : __('no',self::$text_domain)); ?> </td>

									<!-- Hierarchical -->
									<td> <?php echo (isset($args['hierarchical']) && $args['hierarchical'] ? __('yes',self::$text_domain) : __('no',self::$text_domain)); ?> </td>
								</tr>
								<?php
							}
						}
					?>
					</tbody>
				</table>
				</div>
				<!-- <label style="color:red"><?php _e('**Please note that if plugin is deleted then all Gabfire CPT will be deleted.  Also, if this plugin is deactivated, then all Gabfire CPT will be deactivated as well.', self::$text_domain); ?></label> -->

<?php require_once('footer.php'); ?>