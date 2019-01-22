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
	<script>
		function analisar() {

			var resposta = document.getElementById("questionOne", "questionTwo", "questionTwo", "questionThree", "QuestionFour")
				.value;

			//console.log(resposta);

			switch (respostaOne) {
				case 'concentração', 'compreensão', 'compreender', 'melhorar', 'melhor', 'notas', 'passar', 'ano', 'conseguir',
				'progredir', 'esforçar', 'leitura', 'boa', 'Ser', 'alguém', 'futuro', 'faculdade', 'importante', 'estudar':
					//$("#teste").modal();
					break;
					switch (respostaTwo) {
						case 'aprender', 'trabalhar', 'ganhar', 'mais', 'conhecimento', 'evolução', 'evoluir', 'pensamento', 'buscando',
						'compressão', 'oportunidade', 'interesse', 'objetivo', 'Quieto', 'Silencio', 'Prestar', 'atenção', 'não':
							break;
					}
					switch (respostaThree) {
						case 'não', 'bagunçar', 'foco', 'focar', 'dificuldade', 'estudar', 'mais', 'conversar', 'parar', 'falta', 'baixa',
						'atrás', 'ler', 'perguntar', 'oportunidade', 'compreender', 'ajudar', 'preguiça', 'preguiçosa', 'preguiçoso',
						'prestar', 'atenção':
							break;
					}
					switch (respostaFour) {
						case 'perder', 'tempo', 'no', 'futuro', 'ser', 'alguém', 'melhorar', 'preciso', 'ter', 'vontade', 'parado',
						'melhorar', 'notas', 'distrair', 'ajudar', 'tentar', 'parar', 'conversar', 'deixar', 'depois':
							break;
					}
			}
		}
	</script>
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
		<script>
			document.getElementById('print-btn').onclick = function () {
				var content = document.getElementById('content').innetrHTML,
					tela_impressão = window.open());
			tela_impressao.document.write('content');

			tela_impressao.document.write(content);
			tela_impressao.window.print(content);
			tela_impressao.window.close();
			};
		</script>
		<script>
			function print_button_shortcode($atts) {
				return '<a class="print-link" href="javascript:window.print()">Print This Page</a>';
			}
			add_shortcode('print_button', 'print_button_shortcode');
		</script>
</footer>

<?php wp_footer(); ?>

</body>

</html>