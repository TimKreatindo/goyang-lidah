$(document).ready(function () {
	$("#main-table").dataTable();
});

$("#tipe_bukti").change(function () {
	let vall = $(this).val();
	check_tipe_bukti(vall);
});

$("#form-modal").submit(function (e) {
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

$(".act-detail").submit(function (e) {
	e.preventDefault();
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
					let main_data = d.data;
					let bukti = d.data.bukti;
					let html_bukti = "";
					const base_file = base_url + "assets/upload/seminar/";

					if (bukti.type == "file") {
						let main_bukti = bukti.data;
						let li = "";
						for (let i = 0; i < main_bukti.length; i++) {
							li +=
								'<li> <a href="' +
								base_file +
								main_bukti[i].file_name +
								'" target="_blank"> ' +
								main_bukti[i].ori_name +
								" </a> </li>";
						}
						html_bukti = "<ul>" + li + "</ul>";
					} else {
						html_bukti =
							'<a target="_blank" href="' +
							bukti.url +
							'">' +
							bukti.url +
							"</a>";
					}

					let html = `<table class="table table-bordered table-sm">
                                    <tr>
                                        <th>Tanggal Kegiatan</th>
                                        <td>${main_data.tanggal_kegiatan}</td>
                                    </tr>
                                    <tr>
                                        <th>Jenis Kegiatan</th>
                                        <td>${main_data.jenis_kegiatan}</td>
                                    </tr>
                                    <tr>
                                        <th>Jenis Partisipasi</th>
                                        <td>${main_data.jenis_partisipasi}</td>
                                    </tr>
                                    <tr>
                                        <th>Judul Kegiatan</th>
                                        <td>${main_data.judul_kegiatan}</td>
                                    </tr>
                                    <tr>
                                        <th>Level</th>
                                        <td>${main_data.tingkat}</td>
                                    </tr>
                                    <tr>
                                        <th>Penyelenggara</th>
                                        <td>${main_data.penyelenggara}</td>
                                    </tr>
                                    <tr>
                                        <th>Dibuat pada</th>
                                        <td>${main_data.create_at}</td>
                                    </tr>
                                    <tr>
                                        <th>Terakhir di update</th>
                                        <td>${main_data.last_update}</td>
                                    </tr>
                                    <tr>
                                        <th>Bukti</th>
                                        <td>${html_bukti}</td>
                                    </tr>
                                </table>`;

					$("#modalDetail").modal("show");
					$("#modalDetail .modal-body").html(html);
				}
			}, 200);
		},
	});
});

$(".act-edit").submit(function (e) {
	e.preventDefault();
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

					$("#staticBackdrop").modal("show");
					$("#staticBackdrop .modal-title").html("Edit Data");

					$("#id_modal").val(main_data.id);
					$("#act_modal").val("edit");
					$("#start_date").val(main_data.start_date);
					$("#end_date").val(main_data.end_date);
					$("#jenis_kegiatan").val(main_data.jenis_kegiatan);
					$("#jenis_partisipasi").val(main_data.jenis_partisipasi);

					$("#judul_kegiatan").val(main_data.judul_kegiatan);
					$("#penyelenggara").val(main_data.penyelenggara);
					$("#level").val(main_data.tingkat);

					$("#tipe_bukti").val(bukti.type);
					check_tipe_bukti(bukti.type, "edit");
				}
			}, 200);
		},
	});
});

$(".act-delete").submit(function (e) {
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

function add_data() {
	$("#staticBackdrop").modal("show");
	$("#staticBackdrop .modal-title").html("Tambah Data");

	$("#id_modal").val("");
	$("#act_modal").val("add");
	$("#start_date").val("");
	$("#end_date").val("");
	$("#jenis_kegiatan").val("");
	$("#jenis_partisipasi").val("");

	$("#judul_kegiatan").val("");
	$("#penyelenggara").val("");
	$("#level").val("");

	check_tipe_bukti(null, "add");
	$("#tipe_bukti").val("");
	$("#bukti_url").val("");
	$("#bukti_files").val("");

	$("#container_file").html("");
	$("#preview_bukti").addClass("d-none");
	$("#container_preview_bukti").html("");
}

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
