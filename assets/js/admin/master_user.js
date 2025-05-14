$(document).ready(function () {
	load_data();
});

function add_data() {
	$("#modalUser").modal("show");
	$("#modalUser .modal-title").html("Tambah User");

	$("#act_modal").val("add");
	$("#id_modal").val("");

	$("#nip").val("");
	$("#name").val("");
	$("#role").val("");
	$("#jurusan").val("");
	$("#new_pass").val("");
	$("#conf_new_pass").val("");

	$("#err_nip").html("");
	$("#err_name").html("");
	$("#err_new_pass").html("");
	$("#err_conf_new_pass").html("");

	$("#form_new_pass").removeClass("d-none");
	$("#form_conf_new_pass").removeClass("d-none");
}

$("#form_modal").submit(function (e) {
	e.preventDefault();
	loading_animation();
	$("#modalUser").modal("hide");

	$.ajax({
		url: $(this).attr("action"),
		data: $(this).serialize(),
		type: "POST",
		dataType: "JSON",
		error: function (xhr, status, error) {
			setTimeout(() => {
				Swal.close();
				error_alert_reloaded(error);
			}, 200);
		},
		success: function (d) {
			regenerate_token(d.token);
			setTimeout(() => {
				Swal.close();
				if (d.type == "validation") {
					$("#modalUser").modal("show");

					if (d.err_nip) {
						$("#err_nip").html(d.err_nip);
					} else {
						$("#err_nip").html("");
					}

					if (d.err_name) {
						$("#err_name").html(d.err_name);
					} else {
						$("#err_name").html("");
					}

					if (d.err_new_pass) {
						$("#err_new_pass").html(d.err_new_pass);
					} else {
						$("#err_new_pass").html("");
					}

					if (d.err_conf_new_pass) {
						$("#err_conf_new_pass").html(d.err_conf_new_pass);
					} else {
						$("#err_conf_new_pass").html("");
					}
				} else if (d.type == "result") {
					$("#err_nip").html("");
					$("#err_name").html("");
					$("#err_new_pass").html("");
					$("#err_conf_new_pass").html("");
					if (d.status == false) {
						$("#modalUser").modal("show");
						error_alert(d.msg);
					} else {
						success_alert_reloaded(d.msg);
					}
				}
			}, 200);
		},
	});
});

function load_data() {
	$("#main-table").DataTable().destroy();
	$("#main-table").dataTable({
		processing: true,
		serverSide: true,
		order: [],
		ajax: {
			url: base_url + "admin/datatable-master-user",
			type: "POST",
		},
		columnDefs: [
			{
				target: [0, 1, 2, 3, 4, 5, 6, 7],
				classname: "text-center text-nowrap",
			},
		],
		ordering: false,
		iDisplayLength: 10,
		autoWidth: false,
	});
}

$(document).on("submit", ".form_act_user", function (e) {
	e.preventDefault();
	const url = $(this).attr("action");
	const serialize = $(this).serialize();
	let params = new URLSearchParams(serialize);
	let act = params.get("act");

	if (act === "delete") {
		Swal.fire({
			title: "Apakah anda yakin?",
			text: "untuk menghapus data ini",
			showCancelButton: true,
			confirmButtonText: "Yes",
			denyButtonText: `No`,
		}).then((result) => {
			if (result.isConfirmed) {
				loading_animation();
				action_submit(url, serialize, act);
			}
		});
	} else {
		loading_animation();
		action_submit(url, serialize, act);
	}
});

function action_submit(url, serialize, act) {
	$.ajax({
		url: url,
		data: serialize,
		type: "POST",
		dataType: "JSON",
		error: function (xhr, status, error) {
			setTimeout(() => {
				Swal.close();
				error_alert_reloaded(error);
			}, 200);
		},
		success: function (d) {
			setTimeout(() => {
				Swal.close();
				regenerate_token(d.token);
				if (act != "edit") {
					if (d.status == false) {
						error_alert(d.msg);
					} else {
						success_alert_reloaded(d.msg);
					}
				} else {
					if (d.status == false) {
						error_alert(d.msg);
					} else {
						const data = d.data;
						open_modal_edit(data);
					}
				}
			}, 200);
		},
	});
}

function open_modal_edit(data) {
	$("#modalUser").modal("show");
	$("#modalUser .modal-title").html("Edit User");

	$("#form_new_pass").addClass("d-none");
	$("#form_conf_new_pass").addClass("d-none");

	$("#act_modal").val("edit");
	$("#id_modal").val(data.id_user);

	$("#nip").val(data.nip);
	$("#name").val(data.nama);
	$("#role").val(data.id_role);
	$("#jurusan").val(data.id_jurusan);
	$("#new_pass").val("");
	$("#conf_new_pass").val("");

	$("#err_nip").html("");
	$("#err_name").html("");
	$("#err_new_pass").html("");
	$("#err_conf_new_pass").html("");
}
