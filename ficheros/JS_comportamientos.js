// Textos
var TXT_MOSTRAR_AYUDA = 'Mostrar ayuda';
var TXT_CERRAR = 'Cerrar ayuda';


$(document).ready(function () {
	// Bordes para campos activos
	borde1 = new Bordecampo(); borde1.selector = 'input[type=text]'; borde1.alternaBorde();
	borde2 = new Bordecampo(); borde2.selector = 'input[type=password]'; borde2.alternaBorde();
	borde4 = new Bordecampo(); borde4.selector = 'textarea'; borde4.alternaBorde();
	borde3 = new Bordecampo(); borde3.selector = 'select'; borde3.alternaBorde();
	
	ayuda1 = new AyudaFormulario(); ayuda1.inicia();
	
	copia1 = new CampoCopia(); copia1.inicia();
	
});

// Campo de usuario
function CampoCopia () {
	this.campo = '#c_usuario';
	this.campoOrigen = '#c_desde';
	this.campoCheck = 'c_mismo_usuario';
	this.html = '<p class="campoCheck"><label for="c_mismo_usuario"><input type="checkbox" id="'+this.campoCheck+'" name="mismo_usuario" /><span>El usuario coincide con la dirección de Correo</span></label></p>';
	
	this.inicia = function () {
		var that = this;
		$(this.campo).closest('p').before(this.html);
		$('#'+this.campoCheck).change(function () {
			if ($(this).is(':checked')) {
				valor = $(that.campoOrigen).attr('value');
				$(that.campo).attr('value',valor);
				that.borra();
			}
		});
		
	}
	
	// Al cambiar el nombre de usuario se deselecciona el campo de mismo usuario
	this.borra = function () {
		var that = this;
		$(this.campo).focus(function () {
			$(this).keyup(function () {
				$('#'+that.campoCheck).removeAttr('checked');
			});
		});
	}
}


// Clase de ayuda
function AyudaFormulario () {
	this.selector = 'em.ayuda';
	this.rutaImg = 'ficheros/IMG_ico_ayuda.png';
	this.rutaImgHover = 'ficheros/IMG_ico_ayuda_hover.png';
	this.rutaImgCerrar = 'ficheros/IMG_ico_cerrar.png';
	this.rutaImgCerrarHover = 'ficheros/IMG_ico_cerrar_hover.png';
	
	this.inicia = function () {
		var that = this;
		$(this.selector).each(function () {
			html = $(this).html();
			
			if ($(this).hasClass('ayuda_html')) {etiqueta = $(this).prev().prev().html().split(':')[0];}
			else {etiqueta = $(this).prev().children('span').html().split(':')[0];}
			$(this).parent().wrap('<div class="grupo_ayuda"></div>').append('<a class="ico_ayuda" rel="ayuda_emergente" href="#" title="'+TXT_MOSTRAR_AYUDA+'"><img src="'+that.rutaImg+'" alt="'+TXT_MOSTRAR_AYUDA+'" /></a>').after('<div class="caja_ayuda_01"><div class="caja_ayuda_02"><p class="titulo"><strong>'+etiqueta+'</strong></p><p>'+html+'</p><p class="cerrar"><a href="#" rel="cierra_ayuda_emergente"><img src="'+that.rutaImgCerrar+'" alt="'+TXT_CERRAR+'" /></a></p></div></div>');
			$(this).remove();
		});
		
		$('div.caja_ayuda_01').hide();
		
		$('a[rel="ayuda_emergente"]').hover(
			function () {$(this).children().attr('src',that.rutaImgHover);},
			function () {$(this).children().attr('src',that.rutaImg);}
		);
		
		$('a[rel="cierra_ayuda_emergente"]').hover(
			function () {$(this).children().attr('src',that.rutaImgCerrarHover);},
			function () {$(this).children().attr('src',that.rutaImgCerrar);}
		).click(function () {
			$('div.caja_ayuda_01').hide().css('z-index','');
			return false;
		});
		
		$('a[rel="ayuda_emergente"]').click(function () {
			$('div.caja_ayuda_01').hide().css('z-index','');
			$(this).parent().next().show().css('z-index','4');
			return false;
		});
	}
}


// Clase de borde activo
function Bordecampo () {
	this.selector = '';
	this.clase = 'campoActivo';

	this.alternaBorde = function () {
		claseCampo = this.clase;
		$(this.selector).focus(function () {
			$('div.caja_ayuda_01').hide().css('z-index','');
			$(this).addClass(claseCampo);
		});
		$(this.selector).blur(function () {
			$(this).removeClass(claseCampo);
		});
	}
}