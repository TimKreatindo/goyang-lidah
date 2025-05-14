$("#form-get-master").submit(function (e) {
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

	$("#table-modal-master1 tbody").append(html);
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
