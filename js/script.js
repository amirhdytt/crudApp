// jquery ambilkan document dan ketika document siap jalankan function ini
$(document).ready(function () {

	// hilangkan tombol cari
	$('#tombol-cari').hide();
	
	// event ketika keyword ditulis
	$('#keyword').on('keyup', function() {
		// munculkan loading
		$('.loader').show();


		// ajax menggunakan load
		// $('#container').load('ajax/mahasiswa.php?keyword=' + $('#keyword').val());


		// $.get()
		$.get('ajax/mahasiswa.php?keyword=' + $('#keyword').val(), function(data) {

			$('#container').html(data);
			$('.loader').hide();

		})



	});


});