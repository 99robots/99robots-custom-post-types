/*
 * Created by Kyle Benk
 * http://kylebenkapps.com
 */

jQuery(document).ready(function($) {

	$("#gabfire_custom_post_form").submit(function(e){

		$("#gcpt").removeClass('gabfire_custom_post_admin_required');

		if ($("#gcpt").val() == '') {
			$("#gcpt").addClass('gabfire_custom_post_admin_required');
			e.preventDefault();
		}
	});

	$("." + gab_cpt_data.prefix + "delete").click(function(){
		gabfire_custom_post_type_delete($(this).attr('id').substring(32), $("#gabfire_custom_post_type_delete_url_" + $(this).attr('id').substring(32)).text());
	});

	/* Rewrite */

	$('input:radio[name="gcpt_rewrite"]').change(function(){
		if ($(this).val() == 'advanced') {
			$(".gabfire_custom_post_admin_settings_rewite_advanced").show();
		} else {
			$(".gabfire_custom_post_admin_settings_rewite_advanced").hide();
		}
	});

	if ($('input[name="gcpt_rewrite"]:checked').val() == 'advanced') {
		$(".gabfire_custom_post_admin_settings_rewite_advanced").show();
	} else {
		$(".gabfire_custom_post_admin_settings_rewite_advanced").hide();
	}

	/* Show in Menu */

	$('input:radio[name="gcpt_show_in_menu"]').change(function(){
		if ($(this).val() == 'advanced') {
			$(".gabfire_custom_post_admin_settings_show_in_menu_advanced").show();
		} else {
			$(".gabfire_custom_post_admin_settings_show_in_menu_advanced").hide();
		}
	});

	if ($('input[name="gcpt_show_in_menu"]:checked').val() == 'advanced') {
		$(".gabfire_custom_post_admin_settings_show_in_menu_advanced").show();
	} else {
		$(".gabfire_custom_post_admin_settings_show_in_menu_advanced").hide();
	}

	/* Capabilities */

	$('input:radio[name="gcpt_capability_type"]').change(function(){
		if ($(this).val() == 'advanced') {
			$(".gabfire_custom_post_admin_capabilities").show();
		} else {
			$(".gabfire_custom_post_admin_capabilities").hide();
		}
	});

	if ($('input[name="gcpt_capability_type"]:checked').val() == 'advanced') {
		$(".gabfire_custom_post_admin_capabilities").show();
	} else {
		$(".gabfire_custom_post_admin_capabilities").hide();
	}
});

function gabfire_custom_post_type_delete(message, url) {

	var c = confirm("Are you sure you want to delete: " + message);

	if (c == true) {
		window.location = url;
	}
}