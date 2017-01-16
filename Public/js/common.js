function check_form(form_id) {
	last_submit = $('#' + form_id).data('last_submit');
	current_submit = new Date().getTime();
	if (last_submit == undefined) {
		$('#' + form_id).data('last_submit', new Date().getTime());
	} else {
		if (current_submit - last_submit > 600) {
			$('#' + form_id).data('last_submit', new Date().getTime());
		} else {
			return false;
		}
	}

	var check_flag = true;
	$("#" + form_id + " :input").each(function(i) {
		if ($(this).attr("check")) {
			if (!validate($(this).val(), $(this).attr("check"))) {
				ui_error($(this).attr("msg"));
				$(this).focus();
				check_flag = false;
				return check_flag;
			}
		}
	});
	return check_flag;
}

/*提交表单*/
function sendForm(formId, post_url, return_url) {
	if ($("#ajax").val() == 1) {
		var vars = $("#" + formId).serialize();
		$.ajax({
			type : "POST",
			url : post_url,
			data : vars,
			dataType : "json",
			success : function(data) {
				if (data.status) {
					ui_alert(data.info, function() {
						if (return_url) {
							location.href = return_url;
						}
					});
				} else {
					ui_error(data.info);
				}
			}
		});
	} else {
		$("#" + formId).attr("action", post_url);
		if (return_url) {
			set_cookie('return_url', return_url);
		}
		$("#" + formId).submit();
	}
}

/*设置 cookie*/
function set_cookie(key, value, exp, path, domain, secure) {
	key = cookie_prefix + key;
	path = "/";
	var cookie_string = key + "=" + escape(value);
	if (exp) {
		cookie_string += "; expires=" + exp.toGMTString();
	}
	if (path)
		cookie_string += "; path=" + escape(path);
	if (domain)
		cookie_string += "; domain=" + escape(domain);
	if (secure)
		cookie_string += "; secure";
	document.cookie = cookie_string;
}

/*读取 cookie*/
function get_cookie(cookie_name) {
	cookie_name = cookie_prefix + cookie_name;
	var results = document.cookie.match('(^|;) ?' + cookie_name + '=([^;]*)(;|$)');
	if (results)
		return (unescape(results[2]));
	else
		return null;
}

/*删除 cookie*/
function del_cookie(cookie_name) {
	cookie_name = cookie_prefix + cookie_name;
	var cookie_date = new Date();
	//current date & time
	cookie_date.setTime(cookie_date.getTime() - 1);
	document.cookie = cookie_name += "=; expires=" + cookie_date.toGMTString();
}