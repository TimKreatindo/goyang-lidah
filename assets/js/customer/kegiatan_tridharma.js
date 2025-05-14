$(document).ready(function () {
	$("#main-table").dataTable();
});

function add_data() {
	$("#staticBackdrop").modal("show");
	$("#staticBackdrop .modal-title").html("Tambah Data");

	$("#id_modal").val("");
	$("#act_modal").val("add");
	$("#start_date").val("");
	$("#end_date").val("");
	$("#jenis_kegiatan").val("");
	$("#tempat_kegiatan").val("");
	$("#tipe_bukti").val("");
	$("#bukti_url").val("");
	$("#bukti_files").val("");

	$("#container_file").html("");

	check_tipe_bukti(null, "add");
	$("#preview_bukti").addClass("d-none");
	$("#container_preview_bukti").html("");
}

$("#tipe_bukti").change(function () {
	let vall = $(this).val();
	check_tipe_bukti(vall);
});

function check_tipe_bukti(vall, from) {
	if (from == "edit") {
		$("#bukti_url").attr("required");

		if (vall == "file") {
			$("#bukti_file").removeClass("d-none");
			$("#bukti_url_container").addClass("d-none");

			$("#bukti_files").removeAttr("required");
			$("#bukti_url").removeAttr("required");
		} else if (vall == "url") {
			$("#bukti_file").addClass("d-none");
			$("#bukti_url_container").removeClass("d-none");

			$("#bukti_files").removeAttr("required");
			$("#bukti_url").attr("required", true);
		} else {
			$("#bukti_file").addClass("d-none");
			$("#bukti_url_container").addClass("d-none");

			$("#bukti_files").removeAttr("required");
			$("#bukti_url").removeAttr("required");
		}
	} else {
		if (vall == "file") {
			$("#bukti_file").removeClass("d-none");
			$("#bukti_url_container").addClass("d-none");

			$("#bukti_files").attr("required", true);
			$("#bukti_url").removeAttr("required");
		} else if (vall == "url") {
			$("#bukti_file").addClass("d-none");
			$("#bukti_url_container").removeClass("d-none");

			$("#bukti_files").removeAttr("required");
			$("#bukti_url").attr("required", true);
		} else {
			$("#bukti_file").addClass("d-none");
			$("#bukti_url_container").addClass("d-none");

			$("#bukti_files").removeAttr("required");
			$("#bukti_url").removeAttr("required");
		}
	}
}

$("#form_modal").submit(function (e) {
	e.preventDefault();
	loading_animation();
	$("#staticBackdrop").modal("hide");

	$.ajax({
		type: "POST",
		url: $(this).attr("action"),
		data: new FormData(this),
		contentType: false,
		cache: false,
		processData: false,
		dataType: "json",
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

				if (d.status == false) {
					if (d.type == "err_upload") {
						let msg = "";
						for (let i = 0; i < d.msg.length; i++) {
							msg += d.msg[i]["error"] + "<br>";
						}

						Swal.fire({
							icon: "error",
							title: "Error",
							html: msg,
						}).then((res) => {
							$("#staticBackdrop").modal("show");
						});
					} else {
						erorr_alert(d.msg);
						$("#staticBackdrop").modal("show");
					}
				} else {
					success_alert_reloaded(d.msg);
				}
			}, 200);
		},
	});
});

$(".btn_get_edit").submit(function (e) {
	$("#staticBackdrop .modal-title").html("Edit Data");

	$("#act_modal").val("edit");

	e.preventDefault();
	loading_animation();

	$.ajax({
		type: "POST",
		url: $(this).attr("action"),
		data: new FormData(this),
		contentType: false,
		cache: false,
		processData: false,
		dataType: "json",
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
				const bukti = d.data.bukti;
				const main_data = d.data;

				if (bukti.type == "file") {
					const bukti_file = bukti.data;
					let list_file = "";
					for (let i = 0; i < bukti_file.length; i++) {
						list_file += `<div class="row p-2 my-2 justify-content-center align-items-center" style="border: 1px solid #ccc;">
								<div class="col-9">
									<span>${bukti_file[i].ori_name}</span>
									<input type="hidden" name="doc_name[]" value="${bukti_file[i].file_name}">
								</div>
								<div class="col-3 text-end">
									<button class="btn btn-sm btn-warning delete_file_uploaded" type="button"><i
											class="fas fa-trash"></i></button>
								</div>
							</div>`;
					}

					$("#container_preview_bukti").html(list_file);
					$("#preview_bukti").removeClass("d-none");
				} else if (bukti.type == "url") {
					const bukti_url = bukti.url;
					$("#bukti_url").val(bukti_url);
					$("#preview_bukti").addClass("d-none");
				}

				$("#id_modal").val(main_data.id);
				$("#start_date").val(main_data.start_date);
				$("#end_date").val(main_data.end_date);

				$("#jenis_kegiatan").val(main_data.jenis_kegiatan);
				$("#tempat_kegiatan").val(main_data.tempat_kegiatan);

				$("#tipe_bukti").val(bukti.type);
				$("#bukti_files").val("");

				$("#staticBackdrop").modal("show");

				check_tipe_bukti(bukti.type, "edit");
			}, 200);
		},
	});
});

$(".delete_data").submit(function (e) {
	e.preventDefault();

	Swal.fire({
		title: "Apakah anda yakin?",
		text: "untuk menghapus data ini",
		showCancelButton: true,
		confirmButtonText: "Yes",
		denyButtonText: `No`,
	}).then((res) => {
		if (res.isConfirmed) {
			loading_animation();
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

						if (d.status == false) {
							erorr_alert(d.msg);
						} else {
							success_alert_reloaded(d.msg);
						}
					}, 200);
				},
			});
		}
	});
});
