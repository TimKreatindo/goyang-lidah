const spinner =
	'<div class="spinner-grow text-light" role="status"><span class="visually-hidden">Loading...</span></div>';

$("#form_login").submit(function (e) {
	e.preventDefault();
	disabled();

	$.ajax({
		url: $(this).attr("action"),
		data: $(this).serialize(),
		type: "POST",
		dataType: "JSON",
		error: function (xhr, status, error) {
			$("#alert_container").html("");
			error_msg(error);
			rm_disabled();
		},
		success: function (d) {
			$("#alert_container").html("");
			rm_disabled();
			regenerate_token(d.token);

			if (d.status == false) {
				error_msg(d.msg);
			} else {
				window.location.href = d.redirect;
			}
		},
	});
});

function disabled() {
	$("#btn-submit").attr("disabled", true);
	$("#btn-submit").html(spinner);
}

function rm_disabled() {
	$("#btn-submit").removeAttr("disabled");
	$("#btn-submit").html("Login");
}

function error_msg(msg) {
	let err_msg =
		'<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
		msg +
		'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
	$("#alert_container").html(err_msg);
}
