<script>
	$(document).ready(function() {
		$('.btn-exit-system').on('click', function(e){
			e.preventDefault();
			const token = $(this).attr('href');
			swal({
				title: '¿Estás seguro?',
				text: "La sesión actual se cerrará y deberás iniciar sesión nuevamente",
				type: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#03A9F4',
				cancelButtonColor: '#F44336',
				confirmButtonText: '<i class="zmdi zmdi-run"></i> Sí, salir!',
				cancelButtonText: '<i class="zmdi zmdi-close-circle"></i> No, cancelar!'
			}).then(function () {
				$.ajax({
					url: '<?= SERVERURL ?>ajax/loginAjax.php?Token='+token,
					success: function (data) {
						if(data == 'true')
							window.location.href = '<?= SERVERURL ?>login/';
						else
							swal(
								'Ocurrió un error',
								'No se pudo cerrar la sesión',
								'error'
							);
					}
				});
			});
		});
	})
</script>