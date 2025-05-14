$(document).ready(function () {
	load_table();
});

$("#form-get-master").submit(function (e) {
	// $("#modalMaster").modal("show");

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
						$("#modalMaster").modal("show");

						let html = "";
						for (let i = 0; i < d.data.length; i++) {
							const select_level = ["Nasional", "Internasional"];
							let html_opt = "";
							select_level.forEach((select_level) => {
								if (d.data[i].level == select_level) {
									html_opt += `<option selected value="${select_level}">${select_level}</option>`;
								} else {
									html_opt += `<option value="${select_level}">${select_level}</option>`;
								}
							});

							html += `<tr>
                                        <td>
                                            <select class="form-control" name="level[]" required>
                                                <option value="">--pilih--</option>
                                                ${html_opt}
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" name="indeks[]" id="indeks" class="form-control" required
                                                placeholder="Nama Index Publikasi..." value="${d.data[i].indeks}">
                                        </td>
                                        <td class="text-center"><button class="btn btn-sm btn-danger remove-master" type="button"><i
                                                    class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>`;
						}

						$("#modalMaster .modal-body table tbody").html(html);
					}
				}
			}, 200);
		},
	});
});

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
						const base_file = base_url + "assets/upload/publikasi/";
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
                                            <th>Judul</th>
                                            <td>${main_data.judul}</td>
                                        </tr>
                                        <tr>
                                            <th>Jurnal</th>
                                            <td>${main_data.jurnal}</td>
                                        </tr>
                                        <tr>
                                            <th>Tahun</th>
                                            <td>${main_data.tahun}</td>
                                        </tr>
                                        <tr>
                                            <th>Level</th>
                                            <td>${main_data.level}</td>
                                        </tr>
                                        <tr>
                                            <th>Indeksasi</th>
                                            <td>${main_data.indeks}</td>
                                        </tr>
                                        <tr>
                                            <th>Dibuat pada</th>
                                            <td>${main_data.create_at}</td>
                                        </tr>
                                        <tr>
                                            <th>Terkahir di update</th>
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

function load_table() {
	let filter = $("#filter").val();
	$("#main-table").DataTable().destroy();
	$("#main-table").dataTable({
		processing: true,
		serverSide: true,
		order: [],
		ajax: {
			url: base_url + "admin/datatable-publikasi",
			type: "POST",
			data: {
				filter: filter,
			},
		},
		columnDefs: [
			{
				target: [0, 1, 2, 3, 4, 5],
				classname: "text-center text-nowrap",
			},
		],
		ordering: false,
		iDisplayLength: 10,
		autoWidth: false,
	});
}

function add_form_master() {
	const html = `<tr>
                            <td>
                                <select class="form-control" name="level[]" required>
                                    <option value="">--pilih--</option>
                                    <option value="Nasional">Nasional</option>
                                    <option value="Internasional">Internasional</option>
                                </select>
                            </td>
                            <td>
                                <input type="text" name="indeks[]" id="indeks" class="form-control" required
                                    placeholder="Nama Index Publikasi...">
                            </td>
                            <td class="text-center"><button class="btn btn-sm btn-danger remove-master" type="button"><i
                                        class="fa fa-trash"></i></button>
                            </td>
                        </tr>`;

	$("#modalMaster table tbody").append(html);
}

$(document).on("click", ".remove-master", function () {
	$(this).parents("td").parents("tr").remove();
});

$("#form-modal-master").submit(function (e) {
	$("#modalMaster").modal("hide");

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
						$("#modalMaster").modal("show");
					}, 1000);
				} else {
					if (d.status == false) {
						error_alert(d.msg);

						setTimeout(() => {
							Swal.close();
							$("#modalMaster").modal("show");
						}, 1000);
					} else {
						success_alert_reloaded(d.msg);
					}
				}
			}, 200);
		},
	});
});

$("#filter").change(function () {
	load_table();
});
