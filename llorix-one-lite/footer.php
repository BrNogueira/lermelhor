<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package llorix-one-lite
 */
?>

<footer itemscope itemtype="http://schema.org/WPFooter" id="footer" role="contentinfo" class="footer grey-bg">

	<div class="container">
		<div class="footer-widget-wrap">
			<?php
					if ( is_active_sidebar( 'footer-area' ) ) {
				?>
			<div itemscope itemtype="http://schema.org/WPSideBar" role="complementary" id="sidebar-widgets-area-1" class="col-md-3 col-sm-6 col-xs-12 widget-box"
			 aria-label="<?php esc_html_e( 'Widgets Area 1', 'llorix-one-lite' ); ?>">
				<?php
				dynamic_sidebar( 'footer-area' );
				?>
			</div>
			<?php
					}
					if ( is_active_sidebar( 'footer-area-2' ) ) {
				?>
			<div itemscope itemtype="http://schema.org/WPSideBar" role="complementary" id="sidebar-widgets-area-2" class="col-md-3 col-sm-6 col-xs-12 widget-box"
			 aria-label="<?php esc_html_e( 'Widgets Area 2', 'llorix-one-lite' ); ?>">
				<?php
				dynamic_sidebar( 'footer-area-2' );
				?>
			</div>
			<?php
					}
					if ( is_active_sidebar( 'footer-area-3' ) ) {
				?>
			<div itemscope itemtype="http://schema.org/WPSideBar" role="complementary" id="sidebar-widgets-area-3" class="col-md-3 col-sm-6 col-xs-12 widget-box"
			 aria-label="<?php esc_html_e( 'Widgets Area 3', 'llorix-one-lite' ); ?>">
				<?php
				dynamic_sidebar( 'footer-area-3' );
				?>
			</div>
			<?php
					}
					if ( is_active_sidebar( 'footer-area-4' ) ) {
				?>
			<div itemscope itemtype="http://schema.org/WPSideBar" role="complementary" id="sidebar-widgets-area-4" class="col-md-3 col-sm-6 col-xs-12 widget-box"
			 aria-label="<?php esc_html_e( 'Widgets Area 4', 'llorix-one-lite' ); ?>">
				<?php
				dynamic_sidebar( 'footer-area-4' );
				?>
			</div>
			<?php
					}
				?>

		</div><!-- .footer-widget-wrap -->

		<div class="footer-bottom-wrap">
			<?php
					global $wp_customize;

					/* COPYRIGHT */
					$llorix_one_lite_copyright = get_theme_mod( 'llorix_one_lite_copyright', apply_filters( 'llorix_one_lite_copyright_default_filter', 'Themeisle' ) );
					$llorix_one_lite_copyright = apply_filters( 'llorix_one_lite_translate_single_string', $llorix_one_lite_copyright, 'Copyright' );

					if ( ! empty( $llorix_one_lite_copyright ) ) {
					echo '<span class="llorix_one_lite_copyright_content">' . esc_attr( $llorix_one_lite_copyright ) . '</span>';
					} elseif ( isset( $wp_customize ) ) {
					echo '<span class="llorix_one_lite_copyright_content llorix_one_lite_only_customizer"></span>';
					}

					/* OPTIONAL FOOTER LINKS */

					echo '<div itemscope role="navigation" itemtype="http://schema.org/SiteNavigationElement" id="menu-secondary" aria-label="' . esc_html__( 'Secondary Menu', 'llorix-one-lite' ) . '">';
						echo '<h1 class="screen-reader-text">' . esc_html__( 'Secondary Menu', 'llorix-one-lite' ) . '</h1>';
						wp_nav_menu(
							array(
								'theme_location' => 'llorix_one_lite_footer_menu',
								'container'      => false,
								'menu_class'     => 'footer-links small-text',
								'depth'          => 1,
								'fallback_cb'    => false,
							)
							);
					echo '</div>';
					/* SOCIAL ICONS */

					$llorix_one_lite_social_icons = get_theme_mod( 'llorix_one_lite_social_icons' );
					llorix_one_lite_social_icons( $llorix_one_lite_social_icons, true );
					?>
		</div><!-- .footer-bottom-wrap -->

		<?php echo apply_filters( 'llorix_one_plus_footer_text_filter', '<div class="powered-by"><a href="http://themeisle.com/themes/llorix-one/" rel="nofollow">Llorix One Lite </a>' . esc_html__( 'powered by', 'llorix-one-lite' ) . ' <a href="http://wordpress.org/" rel="nofollow">' . esc_html__( 'WordPress', 'llorix-one-lite' ) . '</a></div>' ); ?>

	</div><!-- container -->
<!-- design -->
	<script src="./assets/css/bootstrap/bootstrap.min.css"></script>
				<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
				<script type="text/javascript">
					(function ($) {
						$(function () {
							var graus = 36;
							for (var x = 1; x < 10; x++) {
								var clone = $(".svge:eq(0)").clone(true, true);
								clone.css({
									transform: "rotate(" + graus + "deg)"
								});
								$(".dive").append(clone);
								graus += 36;
							}
							$("path").on("click", function () {
								var pathID = $(this).attr('id');
								pathID = pathID.replace('slice', '');
								var pathCount = 10;
								for (i = 1; i <= pathCount; i++) {
									if (i > pathID) {
										$(this).siblings("#slice" + i).css("fill", "white");
									} else if (i < pathID) {
										$(this).siblings("#slice" + i).css("fill", "gray");
									} else {
										$(this).css("fill", "black");
									}

									console.log('objeto de id = ' + pathID);
									console.log('contador = ' + i);
								}
								pathID = pathID.replace('slice', '');

							});
						});
					})(jQuery);
				</script>

</footer>

<!-- INICIO MODAL FORMULARIO -->
<div class="remodal" data-remodal-id="modal">
  <button data-remodal-action="close" class="remodal-close"></button>
  <div class="modal-imprimir">
	  <h3 class="nome"></h3>	  
	  <h2></h2>
	  <div class="msg"></div>
  </div>
  <button data-remodal-action="confirm" class="remodal-confirm imprimir-resultado">Imprimir</button>
</div>
	<?php wp_footer(); ?>
<!-- INICIO MODAL FORMULARIO CÓDIGO -->

<style>.modal-imprimir h2:before{ content:none} body .remodal-close { left: inherit; right: 0; background: transparent !important; }</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/remodal/1.1.1/remodal.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remodal/1.1.1/remodal.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remodal/1.1.1/remodal-default-theme.min.css">
<script>

	document.addEventListener( 'wpcf7mailsent', function( event ) {

/* SE FORMULÁRIO 1 */

if(event.detail.contactFormId == '1109'){

var campo_1 = jQuery('#pergunta1').val().toLowerCase();
var campo_2 = jQuery('#pergunta2').val().toLowerCase();
var campo_3 = jQuery('#pergunta3').val().toLowerCase();

var palavras_1 = ["conhecimento","oportunidades","tendo","força","foco","posso","fazer","quiser","faculdade"];
var palavras_2 = ["estabilidade","pensar","desanimar","orgulhar","orgulho","pessoas","provar","criatividade","posso"];
var palavras_3 = ["iria","correr","atrás","oportunidades","conquistar","talvez","consiga","chances"];
var palavras_4 = ["ler","escrever","ouvir","aprendi","achar","calcular","prestar atenção","confiança"," expressar"];

var str =  campo_1+','+campo_2+','+campo_3;

var campos = str.replace(/\r?\n|\r/g, " ").replace(/^[,. ]+|[,. ]+$|[,. ]+/g, " ").trim().split(' ');

var compara_1 = palavras_1.filter(function(val) {
  return campos.indexOf(val) != -1;
});


var compara_2 = palavras_2.filter(function(val) {
  return campos.indexOf(val) != -1;
});


var compara_3 = palavras_3.filter(function(val) {
  return campos.indexOf(val) != -1;
});


var compara_4 = palavras_4.filter(function(val) {
  return campos.indexOf(val) != -1;
});

//console.log(compara_1.length);
//console.log(compara_2.length);
//console.log(compara_3.length);
//console.log(compara_4.length);

var compara1_val = parseInt(compara_1.length, 10);
var compara2_val = parseInt(compara_2.length, 10);
var compara3_val = parseInt(compara_3.length, 10);
var compara4_val = parseInt(compara_4.length, 10);
	

if(compara4_val >= compara1_val && compara4_val >= compara2_val && compara4_val >= compara3_val){
	console.log('maior 4')
    jQuery('.modal-imprimir h2').html('Parabéns por identificar os valores em sua vida!');
    jQuery('.modal-imprimir .nome').html(jQuery('input#nome').val());
    jQuery('.modal-imprimir .msg').html('<p><strong>Para refletir sobre suas respostas.</strong></p> <p>• Você fez tudo o que foi necessário para atingir o seu objetivo?</p>');
}		
 else if(compara3_val >= compara1_val && compara3_val >= compara2_val && compara3_val >= compara4_val){
	console.log('maior 3')


    jQuery('.modal-imprimir h2').html('Parabéns por identificar os valores em sua vida!');
    jQuery('.modal-imprimir .nome').html('Nome: '+jQuery('input#nome').val());
    jQuery('.modal-imprimir .msg').html('<p><strong>Para refletir sobre suas respostas.</strong></p> <p>• Quão bom é importante você sair da situação de hoje para o futuro?</p>');
}
 else if(compara2_val >= compara1_val && compara2_val >= compara3_val && compara2_val >= compara4_val){
	console.log('maior 2')
    jQuery('.modal-imprimir h2').html('Parabéns por identificar os valores em sua vida!');
    jQuery('.modal-imprimir .nome').html('Nome: '+jQuery('input#nome').val());
    jQuery('.modal-imprimir .msg').html('<p><strong>Para refletir sobre suas respostas.</strong></p> <p>• Qual o verdadeiro significado deste objetivo para você?</p> <p>• Seus sentimentos estão satisfeitos com seu objetivo?</p>');
}
 else if(compara1_val >= compara2_val && compara1_val >= compara3_val && compara1_val >= compara4_val){
	console.log('maior 1')
    jQuery('.modal-imprimir h2').html('Parabéns por identificar os valores em sua vida!');
    jQuery('.modal-imprimir .nome').html('Nome: '+jQuery('input#nome').val());
    jQuery('.modal-imprimir .msg').html('<p><strong>Para refletir sobre suas respostas.</strong></p> <p>• Parabéns agora vamos em frente</p> <p>• Seu foco está relacionado a ações ou apensas em pensamentos?</p>');
}

}
/* FIM */

/* SE FORMULÁRIO 2 */

else if(event.detail.contactFormId == '1479'){

var campo_1 = jQuery('#pergunta1b').val().toLowerCase();
var campo_2 = jQuery('#pergunta2b').val().toLowerCase();
var campo_3 = jQuery('#pergunta3b').val().toLowerCase();

var palavras_1 = ["conhecimento","oportunidades","tendo","força","foco","posso","fazer","quiser","faculdade"];
var palavras_2 = ["estabilidade","pensar","desanimar","orgulhar","orgulho","pessoas","provar","criatividade","posso"];
var palavras_3 = ["iria","correr","atrás","oportunidades","conquistar","talvez","consiga","chances"];
var palavras_4 = ["ler","escrever","ouvir","aprendi","achar","calcular", "prestar atenção","confiança"," expressar"];


var str =  campo_1+','+campo_2+','+campo_3;

var campos = str.replace(/\r?\n|\r/g, " ").replace(/^[,. ]+|[,. ]+$|[,. ]+/g, " ").trim().split(' ');

var compara_1 = palavras_1.filter(function(val) {
  return campos.indexOf(val) != -1;
});


var compara_2 = palavras_2.filter(function(val) {
  return campos.indexOf(val) != -1;
});


var compara_3 = palavras_3.filter(function(val) {
  return campos.indexOf(val) != -1;
});


var compara_4 = palavras_4.filter(function(val) {
  return campos.indexOf(val) != -1;
});

var compara1_val = parseInt(compara_1.length, 10);
var compara2_val = parseInt(compara_2.length, 10);
var compara3_val = parseInt(compara_3.length, 10);
var compara4_val = parseInt(compara_4.length, 10);
	

if(compara4_val >= compara1_val && compara4_val >= compara2_val && compara4_val >= compara3_val){
	console.log('maior 4')
    jQuery('.modal-imprimir h2').html('Parabéns por identificar seus sentimentos de conquistas.');
    jQuery('.modal-imprimir .nome').html('Nome: '+jQuery('input#nomeb').val());
    jQuery('.modal-imprimir .msg').html('<p><strong>Para refletir sobre suas respostas.</strong></p> <p>• Seu sentimento de conquista pode ajudar você em tomadas de decisões</p>');
}		
 else if(compara3_val >= compara1_val && compara3_val >= compara2_val && compara3_val >= compara4_val){
	console.log('maior 3')


    jQuery('.modal-imprimir h2').html('Parabéns por identificar seus sentimentos de conquistas.');
    jQuery('.modal-imprimir .nome').html('Nome: '+jQuery('input#nomeb').val());
    jQuery('.modal-imprimir .msg').html('<p><strong>Para refletir sobre suas respostas.</strong></p> <p>• Ótimo, mantenha o seu plano e se necessário faça ajustes.</p>');
}
 else if(compara2_val >= compara1_val && compara2_val >= compara3_val && compara2_val >= compara4_val){
	console.log('maior 2')
    jQuery('.modal-imprimir h2').html('Parabéns por identificar seus sentimentos de conquistas.');
    jQuery('.modal-imprimir .nome').html('Nome: '+jQuery('input#nomeb').val());
    jQuery('.modal-imprimir .msg').html('<p><strong>Para refletir sobre suas respostas.</strong></p> <p>• Este período que estipulou realmente é viável?</p> <p>• Muito bem!</p>');
}
 else if(compara1_val >= compara2_val && compara1_val >= compara3_val && compara1_val >= compara4_val){
	console.log('maior 1')
    jQuery('.modal-imprimir h2').html('Parabéns por identificar seus sentimentos de conquistas.');
    jQuery('.modal-imprimir .nome').html('Nome: '+jQuery('input#nomeb').val());
    jQuery('.modal-imprimir .msg').html('<p><strong>Para refletir sobre suas respostas.</strong></p><p>• Vamos em frente!</p> <p>• Seu sentimento de conquistas se idêntica com as suas ações?</p>');
}


}

else if(event.detail.contactFormId == '1480'){
 	jQuery('.modal-imprimir h2').html('PARABÉNS VOCÊ CONCLUIU TODOS OS CONTEÚDOS.');
    jQuery('.modal-imprimir .msg').html('<p>Agora você tem conhecimento dos parâmetros em  suas decisões para decidir ou repensar em suas ações, mas não perder o foco do seu objetivo.</p>');

}

/* FIM */

var inst = jQuery('[data-remodal-id=modal]').remodal();
inst.open();
		
}, false );


function openPrintDialogue(){

  jQuery('<iframe>', {
    name: 'myiframe',
    class: 'printFrame'
  })
.appendTo('body')
  .contents().find('body')
  .append(jQuery('.modal-imprimir').clone()
  .html());

  window.frames['myiframe'].focus();
  window.frames['myiframe'].print();

  setTimeout(() => { jQuery(".printFrame").remove(); }, 1000)
};

jQuery('.imprimir-resultado').on('click', openPrintDialogue);

</script>

<!-- FIM MODAL MODAL FORMULARIO CÓDIGO -->
</body>
</html>