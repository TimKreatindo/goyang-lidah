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
			url: base_url + "admin/datatable-hki",
			type: "POST",
		},
		columnDefs: [
			{
				target: [0, 1, 2, 3, 4],
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
						let dosens = d.data.dosen_contribute;

						let html_bukti = "";
						let dosen_contribute = "";
						const base_file = base_url + "assets/upload/hki/";
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

						if (dosens) {
							for (let index = 0; index < dosens.length; index++) {
								dosen_contribute += `<li>${dosens[index]}</li>`;
							}
						}

						let html_dosen = `
                            <ul>
                                <li>${main_data.dosen_create.name} (${main_data.dosen_create.nip})</li>
                                ${dosen_contribute}
                            </ul>
                        `;

						let html = `
                        <table class="table table-bordered table-sm">
                            <tr>
                                <th>Dosen</th>
                                <td>${html_dosen}</td>
                            </tr>
                            <tr>
                                <th>Judul</th>
                                <td>${main_data.judul}</td>
                            </tr>
                            <tr>
                                <th>No. HKI</th>
                                <td>${main_data.no_hki}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Terbit</th>
                                <td>${main_data.terbit}</td>
                            </tr>
                            <tr>
                                <th>Dibuat Pada</th>
                                <td>${main_data.create_at}</td>
                            </tr>
                            <tr>
                                <th>Terakhir di update</th>
                                <td>${main_data.last_update}</td>
                            </tr>
                            <tr>
                                <th>Dibuat Oleh</th>
                                <td>${main_data.dosen_create.name} (${main_data.dosen_create.nip})</td>
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
