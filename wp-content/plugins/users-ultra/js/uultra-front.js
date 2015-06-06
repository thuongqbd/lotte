function query_string() {
	// This function is anonymous, is executed immediately and 
	// the return value is assigned to QueryString!
	var query_string = {};
	var query = window.location.search.substring(1);
	var vars = query.split("&");
	for (var i = 0; i < vars.length; i++) {
		var pair = vars[i].split("=");
		// If first entry with this name
		if (typeof query_string[pair[0]] === "undefined") {
			query_string[pair[0]] = pair[1];
			// If second entry with this name
		} else if (typeof query_string[pair[0]] === "string") {
			var arr = [query_string[pair[0]], pair[1]];
			query_string[pair[0]] = arr;
			// If third or later entry with this name
		} else {
			query_string[pair[0]].push(pair[1]);
		}
	}
	return query_string;
}
;
function updateURLParameter(url, param, paramVal) {
	var newAdditionalURL = "";
	var tempArray = url.split("?");
	var baseURL = tempArray[0];
	var additionalURL = tempArray[1];
	var temp = "";
	if (additionalURL) {
		tempArray = additionalURL.split("&");
		for (i = 0; i < tempArray.length; i++) {
			if (tempArray[i].split('=')[0] != param) {
				newAdditionalURL += temp + tempArray[i];
				temp = "&";
			}
		}
	}

	var rows_txt = temp + "" + param + "=" + paramVal;
	return baseURL + "?" + newAdditionalURL + rows_txt;
}
function stripQueryStringAndHashFromPath(url) {
	return url.split("?")[0].split("#")[0];
}

function addParameter(url, parameterName, parameterValue, atStart){
	replaceDuplicates = true;
	if(url.indexOf('#') > 0){
		var cl = url.indexOf('#');
		urlhash = url.substring(url.indexOf('#'),url.length);
	} else {
		urlhash = '';
		cl = url.length;
	}
	sourceUrl = url.substring(0,cl);

	var urlParts = sourceUrl.split("?");
	var newQueryString = "";

	if (urlParts.length > 1)
	{
		var parameters = urlParts[1].split("&");
		for (var i=0; (i < parameters.length); i++)
		{
			var parameterParts = parameters[i].split("=");
			if (!(replaceDuplicates && parameterParts[0] == parameterName))
			{
				if (newQueryString == "")
					newQueryString = "?";
				else
					newQueryString += "&";
				newQueryString += parameterParts[0] + "=" + (parameterParts[1]?parameterParts[1]:'');
			}
		}
	}
	if (newQueryString == "")
		newQueryString = "?";

	if(atStart){
		newQueryString = '?'+ parameterName + "=" + parameterValue + (newQueryString.length>1?'&'+newQueryString.substring(1):'');
	} else {
		if (newQueryString !== "" && newQueryString != '?')
			newQueryString += "&";
		newQueryString += parameterName + "=" + (parameterValue?parameterValue:'');
	}
	return urlParts[0] + newQueryString + urlhash;
}

if (typeof $ == 'undefined') {
	var $ = jQuery;
}
function scrollIntoView(objselectstr){
	var offset = jQuery(objselectstr).offset().top - 10;
	jQuery('html, body').animate({
		scrollTop: offset
	});
}
(function ($) {
	$(document).ready(function () {
		"use strict";
		/* Tooltips */
		if ($('.uultra-tooltip').length > 0)
		{
			$('.uultra-tooltip').tipsy({
				trigger: 'hover',
				offset: 4
			});
		}
		jQuery('#uu-send-private-message').click(function() {			
			if($(this).hasClass('active')){
				$(this).removeClass('active');
				jQuery( "#uu-upload-avatar-box" ).slideUp();
			}else{
				$(this).addClass('active');
				jQuery( "#uu-upload-avatar-box" ).slideDown();
			}
				
			 return false;
    		e.preventDefault();
				
        });
		
		jQuery(document).on("click", "a[href='#uultra-forgot-link']", function (e) {
			e.preventDefault();
			$("#xoouserultra-forgot-pass-holder").slideDown();
			return false;
		});

		$(document).on("click", "#xoouserultra-reset-confirm-pass-btn", function (e) {
			e.preventDefault();
			var p1 = jQuery("#preset_password").val();
			var p2 = jQuery("#preset_password_2").val();
			var u_key = $("#uultra_reset_key").val();
			jQuery.ajax({
				type: 'POST',
				url: ajaxurl,
				data: {"action": "confirm_reset_password", "p1": p1, "p2": p2, "key": u_key},
				success: function (data) {
					jQuery("#uultra-reset-p-noti-box").html(data);
					jQuery("#uultra-reset-p-noti-box").slideDown();
				}
			});
			return false;
		});

		jQuery(document).on("click", "#xoouserultra-forgot-pass-btn-confirm", function (e) {
			e.preventDefault();
			var email = jQuery("#user_name_email").val();
			jQuery.ajax({
				type: 'POST',
				url: ajaxurl,
				data: {"action": "send_reset_link", "user_login": email},
				success: function (data) {
					$("#uultra-signin-ajax-noti-box").html(data);
					jQuery("#uultra-signin-ajax-noti-box").slideDown();
					setTimeout("hidde_noti('uultra-signin-ajax-noti-box')", 3000);
				}
			});
			return false;
		});

		//reset password				
		jQuery(document).on("click", "#xoouserultra-backenedb-eset-password", function (e) {
			var p1 = jQuery('#p1').val();
			var p2 = jQuery('#p2').val();
			jQuery.ajax({
				type: 'POST',
				url: ajaxurl,
				data: {"action": "confirm_reset_password_user", "p1": p1, "p2": p2},
				success: function (data) {
					jQuery("#uultra-p-reset-msg").html(data);
				}
			});
			// Cancel the default action
			return false;
			e.preventDefault();
		});

		//update email				
		jQuery(document).on("click", "#xoouserultra-backenedb-update-email", function (e) {
			var email = $('#email').val();
			jQuery.ajax({
				type: 'POST',
				url: ajaxurl,
				data: {"action": "confirm_update_email_user", "email": email},
				success: function (data) {
					jQuery("#uultra-p-changeemail-msg").html(data);
				}
			});
			// Cancel the default action
			return false;
			e.preventDefault();
		});

		jQuery("#xoouserultra-registration-form").validationEngine({promptPosition: 'inline'});
		jQuery("#xoouserultra-profile-edition-form").validationEngine({promptPosition: 'inline'});
		

	}); //END READY
})(jQuery);

function hidde_noti(div_d)
{
	jQuery("#" + div_d).slideUp();

}

 //Adding jQuery Datepicker
jQuery(function () {
	jQuery(".xoouserultra-datepicker").datepicker({dateFormat: "dd.mm.yy",changeMonth: true, changeYear: true, yearRange: "1940:2014"});

	jQuery("#ui-datepicker-div").wrap('<div class="ui-datepicker-wrapper" />');
});