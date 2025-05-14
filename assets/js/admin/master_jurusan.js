function add_data() {
	$("#modalJurusan").modal("show");
	$("#modalJurusan .modal-title").html("Tambah Jurusan");
	$("#jurusan").val("");
	$("#err_jurusan").html("");
	$("#act_form").val("add");
	$("#id_form").val("");
}

function edit_data(id, jurusan) {
	$("#modalJurusan").modal("show");
	$("#modalJurusan .modal-title").html("Edit Jurusan");
	$("#jurusan").val(jurusan);
	$("#err_jurusan").html("");
	$("#act_form").val("edit");
	$("#id_form").val(id);
}

$(".form_action").submit(function (e) {
	e.preventDefault();

	Swal.fire({
		title: "Apakah anda yakin?",
		text: "untuk menghapus data ini",
		showCancelButton: true,
		confirmButtonText: "Yes",
		denyButtonText: `No`,
	}).then((result) => {
		/* Read more about isConfirmed, isDenied below */
		if (result.isConfirmed) {
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
							success_alert_reloaded(d.msg);
						}
					}, 200);
				},
			});
		}
	});
});

$("#form_jurusan").submit(function (e) {
	e.preventDefault();
	loading_animation();
	$("#modalJurusan").modal("hide");

	$.ajax({
		url: $(this).attr("action"),
		data: $(this).serialize(),
		type: "POST",
		dataType: "JSON",
		success: function (d) {
			regenerate_token(d.token);

			setTimeout(() => {
				Swal.close();
				if (d.type == "validation") {
					$("#modalJurusan").modal("show");
					if (d.err_jurusan) {
						$("#err_jurusan").html(d.err_jurusan);
					} else {
						$("#err_jurusan").html("");
					}
				} else if (d.type == "result") {
					$("#err_jurusan").html("");
					if (d.status == false) {
						error_alert(d.msg);
					} else {
						success_alert_reloaded(d.msg);
					}
				}
			}, 200);
		},
		error: function (xhr, status, error) {
			setTimeout(() => {
				Swal.close();
				error_alert_reloaded(error);
			}, 200);
		},
	});
});
