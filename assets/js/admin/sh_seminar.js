$(document).ready(function () {
	load_table();
});

function load_table() {
	$("#main-table").DataTable().destroy();
	$("#main-table").dataTable({
		processing: true,
		serverSide: true,
		order: [],
		ajax: {
			url: base_url + "admin/datatable-seminar",
			type: "POST",
		},
		columnDefs: [
			{
				target: [0, 1, 2, 3, 4, 5, 6],
				classname: "text-center text-nowrap",
			},
		],
		ordering: false,
		iDisplayLength: 10,
		autoWidth: false,
	});
}

$(document).on("submit", ".action", function (e) {
	e.preventDefault();
	// $("#staticBackdrop").modal("show");
	$("#staticBackdrop .modal-title").html("Detail Data");

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
					error_alert(d.msg);
				} else {
					if (d.status == false) {
						error_alert(d.msg);
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
                                            <td>${main_data.date}</td>
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
                                            <th>Tingkat</th>
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

						$("#staticBackdrop").modal("show");
						$("#staticBackdrop .modal-body").html(html);
					}
				}
			}, 200);
		},
	});
});

//
//
//
//
//

$("#form-get-master").submit(function (e) {
	// $("#modalMaster1").modal("show");

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
			Swal.close();
			setTimeout(() => {
				if (d.status == false) {
					error_alert(d.msg);
				} else {
					if (d.status == false) {
						error_alert(d.msg);
					} else {
						$("#modalMaster1").modal("show");

						let html = "";
						for (let i = 0; i < d.data.length; i++) {
							html += `<tr>
										<td>
											<input type="text" name="kegiatan[]" id="kegiatan" class="form-control" required
												placeholder="Nama Kegiatan..." value="${d.data[i]}">
										</td>
										<td class="text-center"><button class="btn btn-sm btn-danger remove-master" type="button"><i
													class="fa fa-trash"></i></button>
										</td>
									</tr>`;
						}

						$("#modalMaster1 .modal-body table tbody").html(html);
					}
				}
			}, 200);
		},
	});
});

function add_form_master() {
	const html = `<tr>
                            <td>
                                <input type="text" name="kegiatan[]" id="kegiatan" class="form-control" required
                                    placeholder="Nama Kegiatan...">
                            </td>
                            <td class="text-center"><button class="btn btn-sm btn-danger remove-master" type="button"><i
                                        class="fa fa-trash"></i></button>
                            </td>
                        </tr>`;

	$("#modalMaster1 table tbody").append(html);
}

$(document).on("click", ".remove-master", function () {
	$(this).parents("td").parents("tr").remove();
});

$("#form-modal-master").submit(function (e) {
	$("#modalMaster1").modal("hide");

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
					error_alert(d.msg);

					setTimeout(() => {
						Swal.close();
						$("#modalMaster1").modal("show");
					}, 1000);
				} else {
					if (d.status == false) {
						error_alert(d.msg);

						setTimeout(() => {
							Swal.close();
							$("#modalMaster1").modal("show");
						}, 1000);
					} else {
						success_alert_reloaded(d.msg);
					}
				}
			}, 200);
		},
	});
});

//
//
//

$("#form-get-master2").submit(function (e) {
	// $("#modalMaster2").modal("show");
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
			Swal.close();
			setTimeout(() => {
				if (d.status == false) {
					error_alert(d.msg);
				} else {
					if (d.status == false) {
						error_alert(d.msg);
					} else {
						$("#modalMaster2").modal("show");
						let html = "";
						for (let i = 0; i < d.data.length; i++) {
							html += `<tr>
										<td>
											<input type="text" name="partisipasi[]" id="partisipasi" class="form-control" required
												placeholder="Nama Partisipasi..." value="${d.data[i]}">
										</td>
										<td class="text-center"><button class="btn btn-sm btn-danger remove-master" type="button"><i
													class="fa fa-trash"></i></button>
										</td>
									</tr>`;
						}
						$("#modalMaster2 .modal-body table tbody").html(html);
					}
				}
			}, 200);
		},
	});
});

function add_form_master2() {
	const html = `<tr>
                            <td>
                                <input type="text" name="partisipasi[]" id="partisipasi" class="form-control" required
                                    placeholder="Nama Partisipasi...">
                            </td>
                            <td class="text-center"><button class="btn btn-sm btn-danger remove-master" type="button"><i
                                        class="fa fa-trash"></i></button>
                            </td>
                        </tr>`;

	$("#modalMaster2 table tbody").append(html);
}

$("#form-modal-master2").submit(function (e) {
	$("#modalMaster2").modal("hide");

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
					error_alert(d.msg);

					setTimeout(() => {
						Swal.close();
						$("#modalMaster2").modal("show");
					}, 1000);
				} else {
					if (d.status == false) {
						error_alert(d.msg);

						setTimeout(() => {
							Swal.close();
							$("#modalMaster2").modal("show");
						}, 1000);
					} else {
						success_alert_reloaded(d.msg);
					}
				}
			}, 200);
		},
	});
});
