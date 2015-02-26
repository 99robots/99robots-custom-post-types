<div class="wrap gabfire-plugin-settings">

	<?php require_once('header.php'); ?>

	<div class="metabox-holder has-right-sidebar">

		<?php require_once('sidebar.php'); ?>

		<div id="post-body">
			<div id="post-body-content">
				<form id="gabfire_custom_post_form" method="post">

					<div id="tabs">
						<ul>
							<li><a href="#gabfire_div_post_type"><span class="gabfire_admin_panel_content_tabs"><?php _e('Post Type',self::$text_domain); ?></span></a></li>
							<li><a href="#gabfire_div_labels"><span class="gabfire_admin_panel_content_tabs"><?php _e('Labels',self::$text_domain); ?></span></a></li>
							<li><a href="#gabfire_div_supports"><span class="gabfire_admin_panel_content_tabs"><?php _e('Supports',self::$text_domain); ?></span></a></li>
							<!-- <li><a href="#gabfire_div_capabilities"><span class="gabfire_admin_panel_content_tabs"><?php _e('Capabilities',self::$text_domain); ?></span></a></li> -->
							<li><a href="#gabfire_div_visibility"><span class="gabfire_admin_panel_content_tabs"><?php _e('Visibility',self::$text_domain); ?></span></a></li>
							<li><a href="#gabfire_div_permalinks"><span class="gabfire_admin_panel_content_tabs"><?php _e('Permalinks',self::$text_domain); ?></span></a></li>
							<li><a href="#gabfire_div_query"><span class="gabfire_admin_panel_content_tabs"><?php _e('Query',self::$text_domain); ?></span></a></li>
						</ul>

						<div id="gabfire_div_post_type">

							<div class="postbox">

								<h3><span><?php _e('Post Type',self::$text_domain); ?></span></h3>

								<div class="inside">

									<table>
						<tbody>

							<!-- Type Name -->
							<tr>
								<th class="gabfire_custom_post_admin_table_th">
									<label><?php _e('Post Type Name',self::$text_domain); ?></label>
									<td class="gabfire_custom_post_admin_table_td">
										<input size="40" type="text" id="gcpt" name="gcpt" placeholder="e.g house" value="<?php echo ((isset($_GET['action']) && $_GET['action'] == "edit" && (isset($_GET['type']) && $_GET['type'] != '')) ? $_GET['type'] : ''); ?>"  <?php echo((isset($_GET['action']) && $_GET['action'] == "edit") ? 'readonly' : ''); ?> /><br/>
										<em><?php _e('Must be less then 20 characters, no whtiespaces, and no capital letters.',self::$text_domain); ?></em>
									</td>
								</th>
								</td>
							</tr>

							<!-- Hierarchical -->
							<tr>
								<th class="gabfire_custom_post_admin_table_th">
									<label><?php _e('Hierarchical',self::$text_domain); ?></label>
									<td class="gabfire_custom_post_admin_table_td">
										<input type="checkbox" id="gcpt_hierarchical" name="gcpt_hierarchical" <?php echo ((isset($data['hierarchical']) && $data['hierarchical']) ? 'checked="checked"' : ''); ?>/><em><?php _e('Whether the post type is hierarchical (e.g. page)',self::$text_domain); ?></em>
									</td>
								</th>
							</tr>

							<!-- Has Archive -->
							<tr>
								<th class="gabfire_custom_post_admin_table_th">
									<label><?php _e('Has Archive',self::$text_domain); ?></label>
									<td class="gabfire_custom_post_admin_table_td">
										<input type="checkbox" id="gcpt_has_archive" name="gcpt_has_archive" <?php echo ((isset($data['has_archive']) && $data['has_archive'] && is_bool($data['has_archive'])) ? 'checked="checked"' : ''); ?>/><em><?php _e('Enables post type archives. Will use $post_type as archive slug by default.',self::$text_domain); ?></em>

									</td>
								</th>
							</tr>

							<tr>
								<th class="gabfire_custom_post_admin_table_th">
									<td class="gabfire_custom_post_admin_table_td">
										<input size="40" type="text" id="gcpt_has_archive_name" name="gcpt_has_archive_name" placeholder="e.g houses" value="<?php echo ((isset($data['has_archive']) && $data['has_archive'] != '' && !is_bool($data['has_archive'])) ? esc_attr($data['has_archive']) : ''); ?>"/><br/>

										<em><label><?php _e('Name of archive page (optional)',self::$text_domain); ?></label></em>
									</td>
								</th>
							</tr>

							<!-- Can Export -->
							<tr>
								<th class="gabfire_custom_post_admin_table_th">
									<label><?php _e('Can Export',self::$text_domain); ?></label>
									<td class="gabfire_custom_post_admin_table_td">
										<input type="checkbox" id="gcpt_can_export" name="gcpt_can_export" <?php echo ((isset($data['can_export']) && $data['can_export']) ? 'checked="checked"' : ''); ?>/><em><?php _e('Can this post_type be exported.',self::$text_domain); ?></em>
									</td>
								</th>
							</tr>

							<!-- Delete With User -->
							<!--
<tr>
								<th class="gabfire_custom_post_admin_table_th">
									<label><?php _e('Delete With User',self::$text_domain); ?></label>
									<td class="gabfire_custom_post_admin_table_td">
										<input type="checkbox" id="gcpt_delete_with_user" name="gcpt_delete_with_user" <?php echo ((isset($data['delete_with_user']) && $data['delete_with_user']) ? 'checked="checked"' : ''); ?>/>
									</td>
								</th>
							</tr>
-->

							<!-- Map Meta Capabilities -->
							<tr>
								<th class="gabfire_custom_post_admin_table_th">
									<label><?php _e('Map Meta Capabilities',self::$text_domain); ?></label>
									<td class="gabfire_custom_post_admin_table_td">
										<input type="checkbox" id="gcpt_map_meta_cap" name="gcpt_map_meta_cap" <?php echo ((isset($data['map_meta_cap']) && $data['map_meta_cap']) ? 'checked="checked"' : ''); ?>/><em><?php _e('Whether to use the internal default meta capability handling.',self::$text_domain); ?></em>
									</td>
								</th>
							</tr>

						</tbody>
						</table>

								</div>

							</div>

						</div>

						<div id="gabfire_div_labels">

							<div class="postbox">

								<h3><span><?php _e('Labels and Description',self::$text_domain); ?></span></h3>

								<div class="inside">

									<table>
						<tbody>

							<!-- Name (usually plural) -->
							<tr>
								<th class="gabfire_custom_post_admin_table_th">
									<label><?php _e('Name ',self::$text_domain); ?></label>
									<td class="gabfire_custom_post_admin_table_td">
										<input size="40" type="text" id="gcpt_name" name="gcpt_name" placeholder="e.g houses" value="<?php echo ((isset($data['labels']['name']) && $data['labels']['name'] != '') ? esc_attr($data['labels']['name']) : ''); ?>"/><br/>
										<em><?php _e('General name for the post type, usually plural.',self::$text_domain); ?></em>
									</td>
								</th>
							</tr>

							<!-- Singular Name -->
							<tr>
								<th class="gabfire_custom_post_admin_table_th">
									<label><?php _e('Singular Name',self::$text_domain); ?></label>
									<td class="gabfire_custom_post_admin_table_td">
										<input size="40" type="text" id="gcpt_singular_name" name="gcpt_singular_name" placeholder="e.g house" value="<?php echo ((isset($data['labels']['singular_name']) && $data['labels']['singular_name'] != '') ? esc_attr($data['labels']['singular_name']) : ''); ?>"/><br/>
										<em><?php _e('Name for one object of this post type.',self::$text_domain); ?></em>
									</td>
								</th>
							</tr>

							<!-- Menu Name -->
							<tr>
								<th class="gabfire_custom_post_admin_table_th">
									<label><?php _e('Menu Name',self::$text_domain); ?></label>
									<td class="gabfire_custom_post_admin_table_td">
										<input size="40" type="text" id="gcpt_menu_name" name="gcpt_menu_name" placeholder="e.g Houses" value="<?php echo ((isset($data['labels']['menu_name']) && $data['labels']['menu_name'] != '') ? esc_attr($data['labels']['menu_name']) : ''); ?>"/><br/>
										<em><?php _e('This string is the name to give menu items.',self::$text_domain); ?></em>
									</td>
								</th>
							</tr>

							<!-- Name in Admin Bar -->
							<tr>
								<th class="gabfire_custom_post_admin_table_th">
									<label><?php _e('Name in Admin Bar',self::$text_domain); ?></label>
									<td class="gabfire_custom_post_admin_table_td">
										<input size="40" type="text" id="gcpt_name_admin_bar" name="gcpt_name_admin_bar" placeholder="e.g Houses" value="<?php echo ((isset($data['labels']['name_admin_bar']) && $data['labels']['name_admin_bar'] != '') ? esc_attr($data['labels']['name_admin_bar']) : ''); ?>"/><br/>
										<em><?php _e('Name given for the "Add New" dropdown on admin bar.',self::$text_domain); ?></em>
									</td>
								</th>
							</tr>

							<!-- All Items -->
							<tr>
								<th class="gabfire_custom_post_admin_table_th">
									<label><?php _e('All Items',self::$text_domain); ?></label>
									<td class="gabfire_custom_post_admin_table_td">
										<input size="40" type="text" id="gcpt_all_items" name="gcpt_all_items" placeholder="e.g All Houses" value="<?php echo ((isset($data['labels']['all_items']) && $data['labels']['all_items'] != '') ? esc_attr($data['labels']['all_items']) : ''); ?>"/><br/>
										<em><?php _e('The all items text used in the menu.',self::$text_domain); ?></em>
									</td>
								</th>
							</tr>

							<!-- Add New -->
							<tr>
								<th class="gabfire_custom_post_admin_table_th">
									<label><?php _e('Add New',self::$text_domain); ?></label>
									<td class="gabfire_custom_post_admin_table_td">
										<input size="40" type="text" id="gcpt_add_new" name="gcpt_add_new" placeholder="e.g Add New" value="<?php echo ((isset($data['labels']['add_new']) && $data['labels']['add_new'] != '') ? esc_attr($data['labels']['add_new']) : ''); ?>"/><br/>
										<em><?php _e('The add new text.',self::$text_domain); ?></em>
									</td>
								</th>
							</tr>

							<!-- Add New Item -->
							<tr>
								<th class="gabfire_custom_post_admin_table_th">
									<label><?php _e('Add New Item',self::$text_domain); ?></label>
									<td class="gabfire_custom_post_admin_table_td">
										<input size="40" type="text" id="gcpt_add_new_item" name="gcpt_add_new_item" placeholder="e.g Add New House" value="<?php echo ((isset($data['labels']['add_new_item']) && $data['labels']['add_new_item'] != '') ? esc_attr($data['labels']['add_new_item']) : ''); ?>"/><br/>
										<em><?php _e('The add new item text.',self::$text_domain); ?></em>
									</td>
								</th>
							</tr>

							<!-- Edit Item -->
							<tr>
								<th class="gabfire_custom_post_admin_table_th">
									<label><?php _e('Edit Item',self::$text_domain); ?></label>
									<td class="gabfire_custom_post_admin_table_td">
										<input size="40" type="text" id="gcpt_edit_item" name="gcpt_edit_item" placeholder="e.g Edit House" value="<?php echo ((isset($data['labels']['edit_item']) && $data['labels']['edit_item'] != '') ? esc_attr($data['labels']['edit_item']) : ''); ?>"/><br/>
										<em><?php _e("The edit item text.",self::$text_domain); ?></em>
									</td>
								</th>
							</tr>

							<!-- New Item -->
							<tr>
								<th class="gabfire_custom_post_admin_table_th">
									<label><?php _e('New Item',self::$text_domain); ?></label>
									<td class="gabfire_custom_post_admin_table_td">
										<input size="40" type="text" id="gcpt_new_item" name="gcpt_new_item" placeholder="e.g New House" value="<?php echo ((isset($data['labels']['new_item']) && $data['labels']['new_item'] != '') ? esc_attr($data['labels']['new_item']) : ''); ?>"/><br/>
										<em><?php _e('The new item text.',self::$text_domain); ?></em>
									</td>
								</th>
							</tr>

							<!-- View Item -->
							<tr>
								<th class="gabfire_custom_post_admin_table_th">
									<label><?php _e('View Item',self::$text_domain); ?></label>
									<td class="gabfire_custom_post_admin_table_td">
										<input size="40" type="text" id="gcpt_view_item" name="gcpt_view_item" placeholder="e.g View House" value="<?php echo ((isset($data['labels']['view_item']) && $data['labels']['view_item'] != '') ? esc_attr($data['labels']['view_item']) : ''); ?>"/><br/>
										<em><?php _e('The view item text.',self::$text_domain); ?></em>
									</td>
								</th>
							</tr>

							<!-- Search Items -->
							<tr>
								<th class="gabfire_custom_post_admin_table_th">
									<label><?php _e('Search Item',self::$text_domain); ?></label>
									<td class="gabfire_custom_post_admin_table_td">
										<input size="40" type="text" id="gcpt_search_items" name="gcpt_search_items" placeholder="e.g Search Houses" value="<?php echo ((isset($data['labels']['search_items']) && $data['labels']['search_items'] != '') ? esc_attr($data['labels']['search_items']) : ''); ?>"/><br/>
										<em><?php _e('The search items text.',self::$text_domain); ?></em>
									</td>
								</th>
							</tr>

							<!-- Not Found -->
							<tr>
								<th class="gabfire_custom_post_admin_table_th">
									<label><?php _e('Not Found',self::$text_domain); ?></label>
									<td class="gabfire_custom_post_admin_table_td">
										<input size="40" type="text" id="gcpt_not_found" name="gcpt_not_found" placeholder="e.g No houses found" value="<?php echo ((isset($data['labels']['not_found']) && $data['labels']['not_found'] != '') ? esc_attr($data['labels']['not_found']) : ''); ?>"/><br/>
										<em><?php _e('the not found text',self::$text_domain); ?></em>
									</td>
								</th>
							</tr>

							<!-- Not Found in Trash -->
							<tr>
								<th class="gabfire_custom_post_admin_table_th">
									<label><?php _e('Not Found in Trash',self::$text_domain); ?></label>
									<td class="gabfire_custom_post_admin_table_td">
										<input size="40" type="text" id="gcpt_not_found_in_trash" name="gcpt_not_found_in_trash" placeholder="e.g No houses found in trash" value="<?php echo ((isset($data['labels']['not_found_in_trash']) && $data['labels']['not_found_in_trash'] != '') ? esc_attr($data['labels']['not_found_in_trash']) : ''); ?>"/><br/>
										<em><?php _e('The not found in trash text.',self::$text_domain); ?></em>
									</td>
								</th>
							</tr>

							<!-- Parent Item Column -->
							<tr>
								<th class="gabfire_custom_post_admin_table_th">
									<label><?php _e('Parent Item Column',self::$text_domain); ?></label>
									<td class="gabfire_custom_post_admin_table_td">
										<input size="40" type="text" id="gcpt_parent_item_colon" name="gcpt_parent_item_colon" placeholder="e.g Parent Page" value="<?php echo ((isset($data['labels']['parent_item_colon']) && $data['labels']['parent_item_colon'] != '') ? esc_attr($data['labels']['parent_item_colon']) : ''); ?>"/><br/>
										<em><?php _e('The parent text.',self::$text_domain); ?></em>
									</td>
								</th>
							</tr>

							<!-- Parent Item -->
							<tr>
								<th class="gabfire_custom_post_admin_table_th">
									<label><?php _e('Parent Item',self::$text_domain); ?></label>
									<td class="gabfire_custom_post_admin_table_td">
										<input size="40" type="text" id="gcpt_parent_item" name="gcpt_parent_item" placeholder="e.g Houses" value="<?php echo ((isset($data['labels']['parent_item']) && $data['labels']['parent_item'] != '') ? esc_attr($data['labels']['parent_item']) : ''); ?>"/><br/>
										<em><?php _e('The parent items text.',self::$text_domain); ?></em>
									</td>
								</th>
							</tr>

							<!-- Archive Title -->
							<tr>
								<th class="gabfire_custom_post_admin_table_th">
									<label><?php _e('Archive Title',self::$text_domain); ?></label>
									<td class="gabfire_custom_post_admin_table_td">
										<input size="40" type="text" id="gcpt_archive_title" name="gcpt_archive_title" placeholder="e.g Houses" value="<?php echo ((isset($data['labels']['archive_title']) && $data['labels']['archive_title'] != '') ? esc_attr($data['labels']['archive_title']) : ''); ?>"/><br/>
										<em><?php _e('The archive items text.',self::$text_domain); ?></em>
									</td>
								</th>
							</tr>

							<!-- Description -->
							<tr>
								<th class="gabfire_custom_post_admin_table_th">
									<label><?php _e('Description',self::$text_domain); ?></label>
									<td class="gabfire_custom_post_admin_table_td">
										<textarea id="gcpt_description" name="gcpt_description" placeholder="e.g This is a description of a house." rows="4" cols="50" value="<?php echo (!empty($data['description']) ? esc_attr($data['description']) : ''); ?>"><?php echo (!empty($data['description']) ? esc_attr($data['description']) : ''); ?></textarea><br/>
										<em><?php _e('The desciption for the post.',self::$text_domain); ?></em>
									</td>
								</th>
							</tr>

						</tbody>
						</table>

								</div>

							</div>

						</div>

						<div id="gabfire_div_supports">

							<div class="postbox">

								<h3><span><?php _e('Supports',self::$text_domain); ?></span></h3>

								<div class="inside">

									<table>
						<tbody>

							<!-- Supports -->

							<tr class="gabfire_custom_post_admin_tr_settings">
								<th class="gabfire_custom_post_admin_table_th">
									<label><?php _e('Supports',self::$text_domain); ?></label>
									<td class="gabfire_custom_post_admin_table_td">
										<input type="checkbox" id="gcpt_supports_title" name="gcpt_supports_title" <?php echo (isset($data['supports']) && in_array('title', $data['supports']) ? 'checked="checked"' : ''); ?>/>
										<label><?php _e('Title', self::$text_domain); ?></label><br />

										<input type="checkbox" id="gcpt_supports_editor" name="gcpt_supports_editor" <?php echo (isset($data['supports']) && in_array('editor', $data['supports']) ? 'checked="checked"' : ''); ?>/>
										<label><?php _e('Editor', self::$text_domain); ?></label><br />

										<input type="checkbox" id="gcpt_supports_excerpt" name="gcpt_supports_excerpt" <?php echo (isset($data['supports']) && in_array('excerpt', $data['supports']) ? 'checked="checked"' : ''); ?>/>
										<label><?php _e('Excerpt', self::$text_domain); ?></label><br />

										<input type="checkbox" id="gcpt_supports_author" name="gcpt_supports_author" <?php echo (isset($data['supports']) && in_array('author', $data['supports']) ? 'checked="checked"' : ''); ?>/>
										<label><?php _e('Author', self::$text_domain); ?></label><br />

										<input type="checkbox" id="gcpt_supports_thumbnail" name="gcpt_supports_thumbnail" <?php echo (isset($data['supports']) && in_array('thumbnail', $data['supports']) ? 'checked="checked"' : ''); ?>/>
										<label><?php _e('Thumbnail', self::$text_domain); ?></label><br />

										<input type="checkbox" id="gcpt_supports_comments" name="gcpt_supports_comments" <?php echo (isset($data['supports']) && in_array('comments', $data['supports']) ? 'checked="checked"' : ''); ?>/>
										<label><?php _e('Comments', self::$text_domain); ?></label><br />

										<input type="checkbox" id="gcpt_supports_trackbacks" name="gcpt_supports_trackbacks" <?php echo (isset($data['supports']) && in_array('trackbacks', $data['supports']) ? 'checked="checked"' : ''); ?>/>
										<label><?php _e('Trackbacks', self::$text_domain); ?></label><br />

										<input type="checkbox" id="gcpt_supports_custom-fields" name="gcpt_supports_custom-fields" <?php echo (isset($data['supports']) && in_array('custom-fields', $data['supports']) ? 'checked="checked"' : ''); ?>/>
										<label><?php _e('Custom Fields', self::$text_domain); ?></label><br />

										<input type="checkbox" id="gcpt_supports_revisions" name="gcpt_supports_revisions" <?php echo (isset($data['supports']) && in_array('revisions', $data['supports']) ? 'checked="checked"' : ''); ?>/>
										<label><?php _e('Revisions', self::$text_domain); ?></label><br />

										<input type="checkbox" id="gcpt_supports_page-attributes" name="gcpt_supports_page-attributes" <?php echo (isset($data['supports']) && in_array('page-attributes', $data['supports']) ? 'checked="checked"' : ''); ?>/>
										<label><?php _e('Page Attributes', self::$text_domain); ?></label><br />

										<input type="checkbox" id="gcpt_supports_post-formats" name="gcpt_supports_post-formats" <?php echo (isset($data['supports']) && in_array('post-formats', $data['supports']) ? 'checked="checked"' : ''); ?>/>
										<label><?php _e('Post Formats', self::$text_domain); ?></label><br />
									</td>
								</th>
							</tr>

						</tbody>
						</table>

								</div>

							</div>

						</div>

						<!--
<div id="gabfire_div_capabilities">

							<div class="postbox">

								<h3><span><?php _e('Capabilities',self::$text_domain); ?></span></h3>

								<div class="inside">

									<table>
						<tbody>

							<tr>
								<th class="gabfire_custom_post_admin_table_th">
									<label><?php _e('Capability Type',self::$text_domain); ?></label>

									<td class="gabfire_custom_post_admin_table_td">

										<input type="radio" id="gcpt_capability_type" name="gcpt_capability_type" value="post" <?php echo ((isset($data['capability_type']) && !is_array($data['capability_type']) && $data['capability_type'] == 'post') ? 'checked' : ''); ?>/><label><?php _e('post',self::$text_domain); ?></label><br />

										<input type="radio" id="gcpt_capability_type" name="gcpt_capability_type" value="page" <?php echo ((isset($data['capability_type']) && !is_array($data['capability_type']) && $data['capability_type'] == 'page') ? 'checked' : ''); ?>/><label><?php _e('page',self::$text_domain); ?></label><br />

										<input type="radio" id="gcpt_capability_type" name="gcpt_capability_type" value="advanced" <?php echo ((isset($data['capabilities']) && is_array($data['capabilities'])) ? 'checked' : ''); ?>/><label><?php _e('Advanced',self::$text_domain); ?></label><br />

										<label><em><?php _e('Default: post',self::$text_domain); ?></em></label>
									</td>
								</th>
							</tr>

							<tr class="gabfire_custom_post_admin_capabilities">
								<th class="gabfire_custom_post_admin_table_th">
									<label><?php _e('Edit Post',self::$text_domain); ?></label>
									<td class="gabfire_custom_post_admin_table_td">
										<input type="text" id="gcpt_capabilites_edit_post" name="gcpt_capabilites_edit_post" value="<?php echo (isset($data['capabilities']['edit_post']) ? esc_attr($data['capabilities']['edit_post']) : 'edit_post'); ?>"/><br/>
										<em><?php _e('Default: edit_post',self::$text_domain); ?></em>
									</td>
								</th>
							</tr>

							<tr class="gabfire_custom_post_admin_capabilities">
								<th class="gabfire_custom_post_admin_table_th">
									<label><?php _e('Read Post',self::$text_domain); ?></label>
									<td class="gabfire_custom_post_admin_table_td">
										<input type="text" id="gcpt_capabilites_read_post" name="gcpt_capabilites_read_post" value="<?php echo (isset($data['capabilities']['read_post']) ? esc_attr($data['capabilities']['read_post']) : 'read_post'); ?>"/><br/>
										<em><?php _e('Default: read_post',self::$text_domain); ?></em>
									</td>
								</th>
							</tr>

							<tr class="gabfire_custom_post_admin_capabilities">
								<th class="gabfire_custom_post_admin_table_th">
									<label><?php _e('Delete Post',self::$text_domain); ?></label>
									<td class="gabfire_custom_post_admin_table_td">
										<input type="text" id="gcpt_capabilites_delete_post" name="gcpt_capabilites_delete_post" value="<?php echo (isset($data['capabilities']['delete_post']) ? esc_attr($data['capabilities']['delete_post']) : 'delete_post'); ?>"/><br/>
										<em><?php _e('Default: delete_post',self::$text_domain); ?></em>
									</td>
								</th>
							</tr>

							<tr class="gabfire_custom_post_admin_capabilities">
								<th class="gabfire_custom_post_admin_table_th">
									<label><?php _e('Capabilities',self::$text_domain); ?></label>
									<td class="gabfire_custom_post_admin_table_td">
										<input type="text" id="gcpt_capabilites_edit_posts" name="gcpt_capabilites_edit_posts" value="<?php echo (isset($data['capabilities']['edit_posts']) ? esc_attr($data['capabilities']['edit_posts']) : 'edit_posts'); ?>"/><br/>
										<em><?php _e('Default: edit_posts',self::$text_domain); ?></em>
									</td>
								</th>
							</tr>

							<tr class="gabfire_custom_post_admin_capabilities">
								<th class="gabfire_custom_post_admin_table_th">
									<label><?php _e('Edit Others Posts',self::$text_domain); ?></label>
									<td class="gabfire_custom_post_admin_table_td">
										<input type="text" id="gcpt_capabilites_edit_others_posts" name="gcpt_capabilites_edit_others_posts" value="<?php echo (isset($data['capabilities']['edit_others_posts']) ? esc_attr($data['capabilities']['edit_others_posts']) : 'edit_others_posts'); ?>"/><br/>
										<em><?php _e('Default: edit_others_posts',self::$text_domain); ?></em>
									</td>
								</th>
							</tr>

							<tr class="gabfire_custom_post_admin_capabilities">
								<th class="gabfire_custom_post_admin_table_th">
									<label><?php _e('Publish Posts',self::$text_domain); ?></label>
									<td class="gabfire_custom_post_admin_table_td">
										<input type="text" id="gcpt_capabilites_publish_posts" name="gcpt_capabilites_publish_posts" value="<?php echo (isset($data['capabilities']['publish_posts']) ? esc_attr($data['capabilities']['publish_posts']) : 'publish_posts'); ?>"/><br/>
										<em><?php _e('Default: publish_posts',self::$text_domain); ?></em>
									</td>
								</th>
							</tr>

							<tr class="gabfire_custom_post_admin_capabilities">
								<th class="gabfire_custom_post_admin_table_th">
									<label><?php _e('Read Private Posts',self::$text_domain); ?></label>
									<td class="gabfire_custom_post_admin_table_td">
										<input type="text" id="gcpt_capabilites_read_private_posts" name="gcpt_capabilites_read_private_posts" value="<?php echo (isset($data['capabilities']['read_private_posts']) ? esc_attr($data['capabilities']['read_private_posts']) : 'read_private_posts'); ?>"/><br/>
										<em><?php _e('Default: read_private_posts',self::$text_domain); ?></em>
									</td>
								</th>
							</tr>

						</tbody>
						</table>

								</div>

							</div>

						</div>
-->

						<div id="gabfire_div_query">

							<div class="postbox">

								<h3><span><?php _e('Query',self::$text_domain); ?></span></h3>

								<div class="inside">

									<table>
						<tbody>

							<!-- Publicly Queryable -->
							<tr>
								<th class="gabfire_custom_post_admin_table_th">
									<label><?php _e('Publicly Queryable',self::$text_domain); ?></label>
									<td class="gabfire_custom_post_admin_table_td">
										<input type="checkbox" id="gcpt_publicly_queryable" name="gcpt_publicly_queryable" <?php echo ((isset($data['publicly_queryable']) && $data['publicly_queryable']) ? 'checked="checked"' : ''); ?>/>
									</td>
								</th>
							</tr>

							<!-- Query Variable -->
							<tr>
								<th class="gabfire_custom_post_admin_table_th">
									<label><?php _e('Query Variable',self::$text_domain); ?></label><br/>
									<em><?php _e('Either use checkbox or textfield',self::$text_domain); ?></em>
									<td class="gabfire_custom_post_admin_table_td">
										<input type="checkbox" id="gcpt_query_var" name="gcpt_query_var" <?php echo ((isset($data['query_var']) && $data['query_var'] && is_bool($data['query_var'])) ? 'checked="checked"' : ''); ?>/><br/>
										<em><?php _e('True - allows you to request a custom posts type (book) using this: example.com/?book=life-of-pi',self::$text_domain); ?></em>
										<em><?php _e('False - a post type cannot be loaded at /?{query_var}={single_post_slug}',self::$text_domain); ?></em>
									</td>
								</th>
							</tr>

							<tr>
								<th class="gabfire_custom_post_admin_table_th">
									<td class="gabfire_custom_post_admin_table_td">
										<input size="40" type="text" id="gcpt_query_var_name" name="gcpt_query_var_name" placeholder="e.g houses" value="<?php echo ((isset($data['query_var']) && $data['query_var'] != '' && !is_bool($data['query_var'])) ? esc_attr($data['query_var']) : ''); ?>"/><br/>
										<em><label><?php _e('If set to a string rather than true (for example ‘publication’), you can do: example.com/?publication=life-of-pi',self::$text_domain); ?></label></em>
									</td>
								</th>
							</tr>

						</tbody>
						</table>

								</div>

							</div>

						</div>

						<div id="gabfire_div_visibility">

							<div class="postbox">

								<h3><span><?php _e('Visibility',self::$text_domain); ?></span></h3>

								<div class="inside">

									<table>
						<tbody>

							<!-- Public -->
							<tr>
								<th class="gabfire_custom_post_admin_table_th">
									<label><?php _e('Public',self::$text_domain); ?></label>
									<td class="gabfire_custom_post_admin_table_td">
										<input type="checkbox" id="gcpt_public" name="gcpt_public" <?php echo ((isset($data['public']) && $data['public']) ? 'checked="checked"' : ''); ?>/><em><?php _e('Whether a post type is intended to be used publicly either via the admin interface or by front-end users.',self::$text_domain); ?></em>
									</td>
								</th>
							</tr>

							<!-- Exclude from search -->
							<tr>
								<th class="gabfire_custom_post_admin_table_th">
									<label><?php _e('Exclude from Search',self::$text_domain); ?></label>
									<td class="gabfire_custom_post_admin_table_td">
										<input type="checkbox" id="gcpt_exclude_from_search" name="gcpt_exclude_from_search" <?php echo ((isset($data['exclude_from_search']) && $data['exclude_from_search']) ? 'checked="checked"' : ''); ?>/><em><?php _e('Whether to exclude posts with this post type from front end search results.',self::$text_domain); ?></em>
									</td>
								</th>
							</tr>

							<!-- Show User Interface -->
							<tr>
								<th class="gabfire_custom_post_admin_table_th">
									<label><?php _e('Show User Interface',self::$text_domain); ?></label>
									<td class="gabfire_custom_post_admin_table_td">
										<input type="checkbox" id="gcpt_show_ui" name="gcpt_show_ui" <?php echo ((isset($data['show_ui']) && $data['show_ui']) ? 'checked="checked"' : ''); ?>/><em><?php _e('Whether to generate a default UI for managing this post type in the admin.',self::$text_domain); ?></em>
									</td>
								</th>
							</tr>

							<!-- Show in Navigation Menus -->
							<tr>
								<th class="gabfire_custom_post_admin_table_th">
									<label><?php _e('Show in Navigation Menu',self::$text_domain); ?></label>
									<td class="gabfire_custom_post_admin_table_td">
										<input type="checkbox" id="gcpt_show_in_nav_menus" name="gcpt_show_in_nav_menus" <?php echo ((isset($data['show_in_nav_menus']) && $data['show_in_nav_menus']) ? 'checked="checked"' : ''); ?>/><em><?php _e('Whether post_type is available for selection in navigation menus',self::$text_domain); ?></em>
									</td>
								</th>
							</tr>

							<!-- Show in Menu -->
							<tr>
								<th class="gabfire_custom_post_admin_table_th">
									<label><?php _e('Show in Menu',self::$text_domain); ?></label>
									<td class="gabfire_custom_post_admin_table_td">

										<input type="radio" id="gcpt_show_in_menu" name="gcpt_show_in_menu" value="true" <?php echo ((isset($data['show_in_menu']) && $data['show_in_menu']) ? 'checked="checked"' : ''); ?>/><span><?php _e('True',self::$text_domain); ?></span><br/>
										<input type="radio" id="gcpt_show_in_menu" name="gcpt_show_in_menu" value="false" <?php echo ((isset($data['show_in_menu']) && !$data['show_in_menu']) ? 'checked="checked"' : ''); ?>/><span><?php _e('False',self::$text_domain); ?></span><br/>
										<input type="radio" id="gcpt_show_in_menu" name="gcpt_show_in_menu" value="advanced" <?php echo ((isset($data['show_in_menu']) && $data['show_in_menu'] && $data['show_in_menu'] != 'true' && $data['show_in_menu'] != 'false') ? 'checked="checked"' : ''); ?>/><span><?php _e('Advanced',self::$text_domain); ?></span><br/>

										<em><?php _e('Default: value of show_ui argument',self::$text_domain); ?></em>
									</td>
								</th>
							</tr>

							<!-- Show in Menu -->
							<tr class="gabfire_custom_post_admin_settings_show_in_menu_advanced">
								<th class="gabfire_custom_post_admin_table_th">
									<td class="gabfire_custom_post_admin_table_td">
										<input size="40" type="text" id="gcpt_show_in_menu_name" name="gcpt_show_in_menu_name" placeholder="e.g tools.php" value="<?php echo ((isset($data['show_in_menu']) && $data['show_in_menu'] != '' && !is_bool($data['show_in_menu'])) ? esc_attr($data['show_in_menu']) : ''); ?>"/><br/>
										<em><?php _e('Show User Interface must be set to true',self::$text_domain); ?></em><br/>
										<em><label><?php _e('If there is an existing top level page such as "tools.php" or "edit.php?post_type=page", then the custom post type will be placed as a sub menu of that. (optional)',self::$text_domain); ?></label></em>
									</td>
								</th>
							</tr>


							<!-- Show in Admin Bar -->
							<tr>
								<th class="gabfire_custom_post_admin_table_th">
									<label><?php _e('Show in Admin Bar',self::$text_domain); ?></label>
									<td class="gabfire_custom_post_admin_table_td">
										<input type="checkbox" id="gcpt_show_admin_bar" name="gcpt_show_admin_bar" <?php echo ((isset($data['show_in_admin_bar']) && $data['show_in_admin_bar']) ? 'checked="checked"' : ''); ?>/><em><?php _e('Whether to make this post type available in the WordPress admin bar.',self::$text_domain); ?></em>
									</td>
								</th>
							</tr>

							<!-- Menu Position -->
							<tr>
								<th class="gabfire_custom_post_admin_table_th">
									<label><?php _e('Menu Position',self::$text_domain); ?></label>
									<td class="gabfire_custom_post_admin_table_td">
										<select id="gcpt_menu_position" name="gcpt_menu_position">
											<option value="5" <?php echo ((isset($data['menu_position']) && $data['menu_position'] == '5') ? 'selected' : ''); ?>><?php _e('below Posts',self::$text_domain); ?></option>
											<option value="10" <?php echo ((isset($data['menu_position']) && $data['menu_position'] == '10') ? 'selected' : ''); ?>><?php _e('below Media',self::$text_domain); ?></option>
											<option value="15" <?php echo ((isset($data['menu_position']) && $data['menu_position'] == '15') ? 'selected' : ''); ?>><?php _e('below Links',self::$text_domain); ?></option>
											<option value="20" <?php echo ((isset($data['menu_position']) && $data['menu_position'] == '20') ? 'selected' : ''); ?>><?php _e('below Pages',self::$text_domain); ?></option>
											<option value="25" <?php echo ((isset($data['menu_position']) && $data['menu_position'] == '25') ? 'selected' : ''); ?>><?php _e('below comments',self::$text_domain); ?></option>
											<option value="60" <?php echo ((isset($data['menu_position']) && $data['menu_position'] == '60') ? 'selected' : ''); ?>><?php _e('below fist separator',self::$text_domain); ?></option>
											<option value="65" <?php echo ((isset($data['menu_position']) && $data['menu_position'] == '65') ? 'selected' : ''); ?>><?php _e('below Plugins',self::$text_domain); ?></option>
											<option value="70" <?php echo ((isset($data['menu_position']) && $data['menu_position'] == '70') ? 'selected' : ''); ?>><?php _e('below Users',self::$text_domain); ?></option>
											<option value="75" <?php echo ((isset($data['menu_position']) && $data['menu_position'] == '75') ? 'selected' : ''); ?>><?php _e('below Tools',self::$text_domain); ?></option>
											<option value="80" <?php echo ((isset($data['menu_position']) && $data['menu_position'] == '80') ? 'selected' : ''); ?>><?php _e('below Settings',self::$text_domain); ?></option>
											<option value="100" <?php echo ((isset($data['menu_position']) && $data['menu_position'] == '100') ? 'selected' : ''); ?>><?php _e('below second sepatator',self::$text_domain); ?></option>
										</select><br/><em><?php _e('The position in the menu order the post type should appear. show_in_menu must be true.',self::$text_domain); ?></em>
									</td>
								</th>
							</tr>

							<!-- Menu Icon -->
							<tr>
								<th class="gabfire_custom_post_admin_table_th">
									<label><?php _e('Menu Icon',self::$text_domain); ?></label>
									<td class="gabfire_custom_post_admin_table_td">
										<input size="60" type="text" id="gcpt_menu_icon" size="50" name="gcpt_menu_icon" placeholder="e.g. http://example.com/image.jpg  OR  dashicons-menu" value="<?php echo ((isset($data['menu_icon']) && $data['menu_icon'] != '') ? esc_attr($data['menu_icon']) : ''); ?>"/><br/>
										<em><?php _e("Enter an URL to the icon for this menu item or the name reference of the dashicon (link this word to the url - http://melchoyce.github.io/dashicons/)",self::$text_domain); ?></em>
									</td>
								</th>
							</tr>

						</tbody>
						</table>

								</div>

							</div>

						</div>

						<div id="gabfire_div_permalinks">

							<div class="postbox">

								<h3><span><?php _e('Permalinks',self::$text_domain); ?></span></h3>

								<div class="inside">

									<table>
						<tbody>

							<!-- Rewrite -->

							<tr class="gabfire_custom_post_admin_tr_settings">
								<th class="gabfire_custom_post_admin_table_th">
									<label><?php _e('Rewrite',self::$text_domain); ?></label>
									<td class="gabfire_custom_post_admin_table_td">
										<input type="radio" id="gcpt_rewrite" name="gcpt_rewrite" value="true" <?php echo ((isset($data['rewrite']) && !is_array($data['rewrite']) && $data['rewrite'] == true) ? 'checked' : ''); ?>/><label><?php _e('True',self::$text_domain); ?></label><br />
										<input type="radio" id="gcpt_rewrite" name="gcpt_rewrite" value="false" <?php echo ((isset($data['rewrite']) && !is_array($data['rewrite']) && $data['rewrite'] == false) ? 'checked' : ''); ?>/><label><?php _e('False',self::$text_domain); ?></label><br />
										<input type="radio" id="gcpt_rewrite" name="gcpt_rewrite" value="advanced" <?php echo ((isset($data['rewrite']) && is_array($data['rewrite'])) ? 'checked' : ''); ?>/><label><?php _e('Advanced',self::$text_domain); ?></label><br />
										<label><em><?php _e('Default: true and use $post_type as slug.',self::$text_domain); ?></em></label>
									</td>
								</th>
							</tr>

							<?php

							if (!is_array($data['rewrite'])) {
								$data['rewrite'] = array();
							}

							if (!isset($data['rewrite']['with_front'])) {
								$data['rewrite']['with_front'] = true;
							}

							if (!isset($data['rewrite']['pages'])) {
								$data['rewrite']['pages'] = true;
							}

							if (!isset($data['rewrite']['feeds'])) {
								$data['rewrite']['feeds'] = $data['has_archive'];
							}

							?>

							<tr class="gabfire_custom_post_admin_settings_rewite_advanced">
								<th class="gabfire_custom_post_admin_table_th">
									<?php _e('Slug',self::$text_domain); ?>
									<td class="gabfire_custom_post_admin_table_td">
									<input size="40" type="text" id="gcpt_rewrite_slug" name="gcpt_rewrite_slug" placeholder="e.g house" value="<?php echo ((isset($data['rewrite']['slug']) && $data['rewrite']['slug'] != '') ? esc_attr($data['rewrite']['slug']) : ''); ?>"/><br/>
									<em><?php _e('Customize the permalink structure slug.',self::$text_domain); ?></em>
									</td>
								</th>
							</tr>

							<tr class="gabfire_custom_post_admin_settings_rewite_advanced">
								<th class="gabfire_custom_post_admin_table_th">
									<?php _e('Structure', self::$text_domain); ?>
									<td class="gabfire_custom_post_admin_table_td">
										<input type="checkbox" id="gcpt_rewrite_with_front" name="gcpt_rewrite_with_front" <?php echo (isset($data['rewrite']['with_front']) && $data['rewrite']['with_front'] ? 'checked="checked"' : ''); ?>/><label><?php _e('With Front', self::$text_domain); ?></label><br />
										<em style="padding-left:1.5em"><?php _e('Should the permalink structure be prepended with the front base.', self::$text_domain); ?></em><br/>

										<input type="checkbox" id="gcpt_rewrite_pages" name="gcpt_rewrite_pages" <?php echo (isset($data['rewrite']['pages']) && $data['rewrite']['pages'] ? 'checked="checked"' : ''); ?>/><label><?php _e('Pages', self::$text_domain); ?></label><br />
										<em style="padding-left:1.5em"><?php _e('Should the permalink structure provide for pagination', self::$text_domain); ?></em><br/>

										<input type="checkbox" id="gcpt_rewrite_feeds" name="gcpt_rewrite_feeds" <?php echo (isset($data['rewrite']['feeds']) && $data['rewrite']['feeds'] ? 'checked="checked"' : ''); ?>/><label><?php _e('Feeds', self::$text_domain); ?></label><br />
										<em style="padding-left:1.5em"><?php _e('Should a feed permalink structure be built for this post type.', self::$text_domain); ?></em>

									</td>
								</th>
							</tr>

						</tbody>
						</table>

								</div>

							</div>

						</div>

					</div>

					<input type="submit" id="gcpt_submit" name="gcpt_submit" class="button-primary" value="Save"/>
				</form>
				<a class="gabfire_custom_post_type_additional_details" href="http://codex.wordpress.org/Function_Reference/register_post_type#Parameters" target="_blank"><?php _e('All parameter details.',self::$text_domain); ?></a>

<?php require_once('footer.php'); ?>

<script type="text/javascript">
	jQuery(document).ready(function($) {
		$( "#tabs" ).tabs();
	});
</script>