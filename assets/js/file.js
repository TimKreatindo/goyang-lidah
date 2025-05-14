const fileInput = document.getElementById("bukti_files");
const fileList = document.getElementById("container_file");
const whitelist_ext = [
	"application/pdf",
	"application/vnd.ms-excel",
	"application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
	"application/msword",
	"application/vnd.openxmlformats-officedocument.wordprocessingml.document",
	"application/vnd.ms-powerpoint",
	"application/vnd.openxmlformats-officedocument.presentationml.presentation",
	"image/jpeg",
	"image/png",
	"image/svg+xml",
];

fileInput.addEventListener("change", function () {
	fileList.innerHTML = "";
	let li = "";

	Array.from(fileInput.files).forEach((file, index) => {
		// console.log(file);

		let file_ext = file.type;
		let file_size = file.size;
		let show_file_size = 0;

		//convert file size to kb
		let count_kb = file_size / 1024;
		let size_kb = Math.round(count_kb);
		//convert file size to mb
		let count_mb = file_size / (1024 * 1024);
		let size_mb = Math.round(count_mb);

		if (size_mb >= 1) {
			show_file_size = size_mb + " mb";
		} else {
			show_file_size = size_kb + " kb";
		}

		let check_file_ext = whitelist_ext.includes(file_ext);

		if (size_mb > 4 || check_file_ext == false) {
			removeFile(index);
		} else {
			li +=
				'<div class="row list_uploaded mx-1 my-2 align-items-center ">' +
				'<div class="col-9 p-2">' +
				"<span><strong>" +
				file.name +
				"</strong></span> <br>" +
				'<small class="text-muted">' +
				show_file_size +
				"</small>" +
				"</div>" +
				'<div class="col-3">' +
				'<div class="text-end">' +
				'<button class="btn btn-sm btn-danger cross" onclick="removeFile(' +
				index +
				')"><i class="fas fa-times-circle"></i></button>' +
				"</div>" +
				"</div>" +
				"</div>";
		}
	});

	let newli = li.replace(/^"|"$/g, "");
	fileList.innerHTML = newli;
});

function removeFile(index) {
	const files = Array.from(fileInput.files);
	files.splice(index, 1); // Hapus file dari array

	// Buat FileList baru
	const dataTransfer = new DataTransfer();
	files.forEach((file) => dataTransfer.items.add(file));

	// Perbarui input file
	fileInput.files = dataTransfer.files;

	// Perbarui daftar file yang ditampilkan
	fileInput.dispatchEvent(new Event("change"));
}

$(document).on("click", ".delete_file_uploaded", function () {
	$(this).closest(".row").remove();
});
