$(document).ready(function(){
	$('.btn-sideBar-SubMenu').on('click', function(e){
		e.preventDefault();
		var SubMenu=$(this).next('ul');
		var iconBtn=$(this).children('.zmdi-caret-down');
		if(SubMenu.hasClass('show-sideBar-SubMenu')){
			iconBtn.removeClass('zmdi-hc-rotate-180');
			SubMenu.removeClass('show-sideBar-SubMenu');
		}else{
			iconBtn.addClass('zmdi-hc-rotate-180');
			SubMenu.addClass('show-sideBar-SubMenu');
		}
	});

	$('.btn-menu-dashboard').on('click', function(e){
		e.preventDefault();
		var body=$('.dashboard-contentPage');
		var sidebar=$('.dashboard-sideBar');
		if(sidebar.css('pointer-events')=='none'){
			body.removeClass('no-paddin-left');
			sidebar.removeClass('hide-sidebar').addClass('show-sidebar');
		}else{
			body.addClass('no-paddin-left');
			sidebar.addClass('hide-sidebar').removeClass('show-sidebar');
		}
	});
});

$('.FormularioAjax').submit(function(e){
	e.preventDefault();

	var form=$(this);

	var tipo=form.attr('data-form');
	var accion=form.attr('action');
	var metodo=form.attr('method');
	var respuesta=form.children('.RespuestaAjax');

	var msjError="<script>swal('Ocurrió un error inesperado','Por favor recargue la página','error');</script>";
	var formdata = new FormData(this);


	var textoAlerta;
	switch (tipo) {
		case 'save':
			textoAlerta="Los datos que enviaras quedaran almacenados en el sistema";
			break;
		case 'delete':
			textoAlerta="Los datos serán eliminados completamente del sistema";
			break;
		case 'update':
			textoAlerta="Los datos del sistema serán actualizados";
			break;
		default:
			textoAlerta="Quieres realizar la operación solicitada";
	}


	swal({
		title: "¿Estás seguro?",
		text: textoAlerta,
		type: "question",
		showCancelButton: true,
		confirmButtonText: "Aceptar",
		cancelButtonText: "Cancelar"
	}).then(function () {
		$.ajax({
			type: metodo,
			url: accion,
			data: formdata ? formdata : form.serialize(),
			cache: false,
			contentType: false,
			processData: false,
			xhr: function(){
				var xhr = new window.XMLHttpRequest();
				xhr.upload.addEventListener("progress", function(evt) {
					if (evt.lengthComputable) {
						var percentComplete = evt.loaded / evt.total;
						percentComplete = parseInt(percentComplete * 100);
						if(percentComplete<100){
							respuesta.html('<p class="text-center">Procesado... ('+percentComplete+'%)</p><div class="progress progress-striped active"><div class="progress-bar progress-bar-info" style="width: '+percentComplete+'%;"></div></div>');
						}else{
							respuesta.html('<p class="text-center"></p>');
						}
					}
				}, false);
				return xhr;
			},
			success: function (data) {
				respuesta.html(data);
			},
			error: function() {
				respuesta.html(msjError);
			}
		});
		return false;
	});
});

(function($){
    $(window).on("load",function(){
        $(".dashboard-sideBar-ct").mCustomScrollbar({
        	theme:"light-thin",
        	scrollbarPosition: "inside",
        	autoHideScrollbar: true,
        	scrollButtons: {enable: true}
        });
        $(".dashboard-contentPage, .Notifications-body").mCustomScrollbar({
        	theme:"dark-thin",
        	scrollbarPosition: "inside",
        	autoHideScrollbar: true,
        	scrollButtons: {enable: true}
        });
    });
})(jQuery);