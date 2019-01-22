<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package llorix-one-lite
 */

	get_header();
?>

</div>
<!-- /END COLOR OVER IMAGE -->
</header>
<!-- /END HOME / HEADER  -->

<div id="content" class="content-wrap">
	<div class="container">
		<?php
		$llorix_one_lite_change_to_full_width = get_theme_mod( 'llorix_one_lite_change_to_full_width' );

		echo '<div id="primary" class="content-area ';
		if ( is_active_sidebar( 'sidebar-1' ) && empty( $llorix_one_lite_change_to_full_width ) ) {
			echo 'col-md-8';
		} else {
			echo 'col-md-12';
		}
		echo '">';
		echo '<main itemscope itemtype="http://schema.org/WebPageElement" itemprop="mainContentOfPage" id="main" class="site-main" role="main">';
		while ( have_posts() ) {
			the_post(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

			<?php
		$page_title = get_the_title();
		if ( ! empty( $page_title ) ) {
		?>
			<header class="entry-header">
				<?php the_title( '<h1 class="entry-title single-title" itemprop="headline">', '</h1>' ); ?>
				<div class="colored-line-left"></div>
				<div class="clearfix"></div>
			</header><!-- .entry-header -->
			<?php } ?>

			<div class="entry-content content-page 
	<?php
	if ( empty( $page_title ) ) {
echo 'llorix-one-lite-top-margin-5px'; }
?>
"
			 itemprop="text">
				<div class="form-text" action="/action_page.php">
					Digite algo que considere <br>importante para seu aprendizado <br>
					<textarea class="important-text" rows="2" cols="20">
				</textarea>
				</div>
				<div class="dive" id="dive">
					<svg xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:cc="http://creativecommons.org/ns#" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
					 xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg" xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd"
					 xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape" width="70mm" height="80mm" viewBox="0 0 180 150"
					 version="1.1" id="svg9212" class="svge" inkscape:version="0.92.3 (2405546, 2018-03-11)" sodipodi:docname="slicedoslicesliciado.svg">
						<defs id="defs9206" />
						<sodipodi:namedview id="base" pagecolor="#ffffff" bordercolor="#666666" borderopacity="1.0" inkscape:pageopacity="0.0"
						 inkscape:pageshadow="2" inkscape:zoom="1.4142136" inkscape:cx="355.84436" inkscape:cy="202.15073"
						 inkscape:document-units="mm" inkscape:current-layer="layer1" showgrid="false" inkscape:measure-start="135.294,489.325"
						 inkscape:measure-end="508.197,760.214" inkscape:window-width="1920" inkscape:window-height="1017"
						 inkscape:window-x="-8" inkscape:window-y="-8" inkscape:window-maximized="1" showguides="true"
						 inkscape:guide-bbox="true">
							<sodipodi:guide position="178.66968,28.624566" orientation="0,1" id="guide23070" inkscape:locked="false" />
						</sodipodi:namedview>
						<metadata id="metadata9209">
							<rdf:RDF>
								<cc:Work rdf:about="">
									<dc:format>image/svg+xml</dc:format>
									<dc:type rdf:resource="http://purl.org/dc/dcmitype/StillImage" />
									<dc:title></dc:title>
								</cc:Work>
							</rdf:RDF>
						</metadata>
						<g inkscape:label="Camada 1" inkscape:groupmode="layer" id="layer1" transform="translate(0,-147)">
							<path style="stroke:#000000;stroke-width:0.26458332px;stroke-linecap:butt;stroke-linejoin:miter;stroke-opacity:1"
							 d="M 19.644756,258.3128 5.7658628,268.314 H 22.872807 c 0,0 0.187532,-5.31526 -3.228051,-10.0012 z" id="slice1"
							 inkscape:connector-curvature="0" />
							<path style="stroke:#000000;stroke-width:0.26458332px;stroke-linecap:butt;stroke-linejoin:miter;stroke-opacity:1"
							 d="m 30.360381,250.47452 c 3.643028,5.17543 5.672817,11.07682 5.788654,17.83948 H 22.872807 c -0.02498,-4.19368 -1.265734,-7.39262 -3.228051,-10.0012 z"
							 id="slice2" inkscape:connector-curvature="0" sodipodi:nodetypes="ccccc" />
							<path style="stroke:#000000;stroke-width:0.26458332px;stroke-linecap:butt;stroke-linejoin:miter;stroke-opacity:1"
							 d="m 30.360381,250.47452 c 3.93051,5.25051 5.914936,11.17791 5.788654,17.83948 l 14.672077,5e-5 c -0.108784,-10.30942 -3.222437,-19.01623 -8.62063,-26.50463 z"
							 id="slice3" inkscape:connector-curvature="0" sodipodi:nodetypes="ccccc" />
							<path style="stroke:#000000;stroke-width:0.26458332px;stroke-linecap:butt;stroke-linejoin:miter;stroke-opacity:1"
							 d="m 42.200482,241.80942 12.868196,-9.33398 c 7.319086,10.68915 11.5586,22.50496 11.649384,35.83861 h -15.89695 c 0.103356,-9.76516 -3.083149,-18.50223 -8.62063,-26.50463 z"
							 id="slice4" inkscape:connector-curvature="0" sodipodi:nodetypes="ccccc" />
							<path style="stroke:#000000;stroke-width:0.26458332px;stroke-linecap:butt;stroke-linejoin:miter;stroke-opacity:1"
							 d="m 67.553783,223.39693 c 10.927514,15.26562 14.581271,30.17929 14.601171,44.91712 H 66.718062 C 66.213011,254.76771 62.27642,242.84683 55.068678,232.47544 Z"
							 id="slice5" inkscape:connector-curvature="0" sodipodi:nodetypes="ccccc" />
							<path style="stroke:#000000;stroke-width:0.26458332px;stroke-linecap:butt;stroke-linejoin:miter;stroke-opacity:1"
							 d="m 67.553783,223.39693 11.669101,-8.36785 c 10.448122,16.11761 17.818258,33.31006 17.205418,53.29023 l -14.273348,-0.005 c -0.07002,-19.06993 -6.098509,-33.05033 -14.601171,-44.91738 z"
							 id="slice6" inkscape:connector-curvature="0" sodipodi:nodetypes="ccccc" />
							<path style="stroke:#000000;stroke-width:0.26458332px;stroke-linecap:butt;stroke-linejoin:miter;stroke-opacity:1"
							 d="m 79.222884,215.02908 11.28324,-8.26756 c 13.526926,20.62584 20.756216,41.15226 19.995706,61.55253 l -14.073526,0.005 c 0.0162,-24.12003 -7.84737,-39.53092 -17.20542,-53.28997 z"
							 id="slice7" inkscape:connector-curvature="0" sodipodi:nodetypes="ccccc" />
							<path style="stroke:#000000;stroke-width:0.26458332px;stroke-linecap:butt;stroke-linejoin:miter;stroke-opacity:1"
							 d="m 90.506124,206.76152 13.923566,-10.12018 c 15.17384,22.91882 23.32568,46.75855 23.28503,71.67271 h -17.21289 c 0.12283,-23.50426 -7.66729,-43.52682 -19.995706,-61.55253 z"
							 id="slice8" inkscape:connector-curvature="0" sodipodi:nodetypes="ccccc" />
							<path style="stroke:#000000;stroke-width:0.26458332px;stroke-linecap:butt;stroke-linejoin:miter;stroke-opacity:1"
							 d="m 117.66315,186.85027 12.45687,-8.87258 c 19.31434,26.19509 28.236,56.66114 29.34882,90.33631 l -14.34662,0.0516 c 0.55136,-30.09639 -9.81741,-56.90177 -27.45907,-81.51533 z"
							 id="slice10" inkscape:connector-curvature="0" sodipodi:nodetypes="ccccc" />
							<path style="stroke:#000000;stroke-width:0.26458332px;stroke-linecap:butt;stroke-linejoin:miter;stroke-opacity:1"
							 d="m 104.42969,196.64134 13.23346,-9.79107 c 19.81918,27.69851 27.83209,54.814 27.45907,81.51536 l -17.4075,-0.0516 c 0.31866,-24.26966 -7.63928,-48.15136 -23.28503,-71.67269 z"
							 id="slice9" inkscape:connector-curvature="0" sodipodi:nodetypes="ccccc" />

							<text xml:space="preserve" style="font-style:normal;font-weight:normal;font-size:3.52777767px;line-height:1.25;font-family:sans-serif;letter-spacing:0px;word-spacing:0px;fill:grey;fill-opacity:1;stroke:none;stroke-width:0.26458332"
							 x="140.74825" y="268.02475" id="texto9">
								<tspan sodipodi:role="line" id="texto99" x="140.74825" y="268.02475" style="font-size:7.05555534px;stroke-width:0.26458332">9</tspan>
							</text>
							<text xml:space="preserve" style="font-style:normal;font-weight:normal;font-size:3.52777767px;line-height:1.25;font-family:sans-serif;letter-spacing:0px;word-spacing:0px;fill:grey;fill-opacity:1;stroke:none;stroke-width:0.26458332"
							 x="123.29855" y="268.12485" id="texto8">
								<tspan sodipodi:role="line" id="textssss8" x="123.29855" y="268.12485" style="font-size:7.05555534px;stroke-width:0.26458332">8</tspan>
							</text>
							<text xml:space="preserve" style="font-style:normal;font-weight:normal;font-size:3.52777767px;line-height:1.25;font-family:sans-serif;letter-spacing:0px;word-spacing:0px;fill-opacity:1;stroke:none;stroke-width:0.26458332; fill:grey;"
							 x="106.31586" y="268.20859" id="texto7">
								<tspan sodipodi:role="line" id="dddddd" x="106.31586" y="268.20859" style="font-size:7.05555534px;stroke-width:0.26458332">7</tspan>
							</text>
							<text xml:space="preserve" style="font-style:normal;font-weight:normal;font-size:3.52777767px;line-height:1.25;font-family:sans-serif;letter-spacing:0px;word-spacing:0px;fill-opacity:1;stroke:none;stroke-width:0.26458332; fill:grey;"
							 x="92.180901" y="268.00748" id="text6">
								<tspan sodipodi:role="line" id="texto235223526" x="92.180901" y="268.00748" style="font-size:7.05555534px;stroke-width:0.26458332">6</tspan>
							</text>
							<text xml:space="preserve" style="font-style:normal;font-weight:normal;font-size:3.52777767px;line-height:1.25;font-family:sans-serif;letter-spacing:0px;word-spacing:0px;fill-opacity:1;stroke:none;stroke-width:0.26458332;fill:grey;"
							 x="77.89962" y="268.12991" id="texto5">
								<tspan sodipodi:role="line" id="tspan23528" x="77.89962" y="268.12991" style="font-size:7.05555534px;stroke-width:0.26458332">5</tspan>
							</text>
							<text xml:space="preserve" style="font-style:normal;font-weight:normal;font-size:3.52777767px;line-height:1.25;font-family:sans-serif;letter-spacing:0px;word-spacing:0px;fill-opacity:1;stroke:none;stroke-width:0.26458332; fill:grey;"
							 x="62.054249" y="268.04987" id="texto4">
								<tspan sodipodi:role="line" id="tspan23532" x="62.054249" y="268.04987" style="font-size:7.05555534px;stroke-width:0.26458332">4</tspan>
							</text>
							<text xml:space="preserve" style="font-style:normal;font-weight:normal;font-size:3.52777767px;line-height:1.25;font-family:sans-serif;letter-spacing:0px;word-spacing:0px;fill-opacity:1;stroke:none;stroke-width:0.26458332; fill:grey;"
							 x="46.189892" y="268.1373" id="texto3">
								<tspan sodipodi:role="line" id="tspan23536" x="46.189892" y="268.1373" style="font-size:7.05555534px;stroke-width:0.26458332">3</tspan>
							</text>
							<text xml:space="preserve" style="font-style:normal;font-weight:normal;font-size:3.52777767px;line-height:1.25;font-family:sans-serif;letter-spacing:0px;word-spacing:0px;fill-opacity:1;stroke:none;stroke-width:0.26458332; fill:grey;"
							 x="31.437782" y="268.08063" id="texto2">
								<tspan sodipodi:role="line" id="tspan23540" x="31.437782" y="268.08063" style="font-size:7.05555534px;stroke-width:0.26458332">2
							</text>
							<text xml:space="preserve" style="font-style:normal;font-weight:normal;font-size:3.52777767px;line-height:1.25;font-family:sans-serif;letter-spacing:0px;word-spacing:0px;fill-opacity:1;stroke:none;stroke-width:0.26458332; fill:grey;"
							 x="18.192924" y="268.38547" id="texto1">
								<tspan sodipodi:role="line" id="asasassasassa" x="18.192924" y="268.38547" style="font-size:7.05555534px;stroke-width:0.26458332">1</tspan>
							</text>
							<text xml:space="preserve" style="font-style:normal;font-weight:normal;font-size:3.52777767px;line-height:1.25;font-family:sans-serif;letter-spacing:0px;word-spacing:0px;fill-opacity:1;stroke:none;stroke-width:0.26458332; fill:grey;"
							 x="150.51283" y="267.90771" id="texto10">
								<tspan sodipodi:role="line" id="asdasd" x="150.51283" y="267.90771" style="font-size:7.05555534px;stroke-width:0.26458332">10</tspan>
							</text>
						</g>
					</svg>

					<div>
						<h4 class="op-1">Lê todos os dias</h4>
						<h4 class="op-2">Entendo o que leio</h4>
						<h4 class="op-3">Gosto de lêr</h4>
						<h4 class="op-4">Aprendo com facilidade</h4>
						<h4 class="op-5">Atenção nas aulas</h4>
						<h4 class="op-6">Conhece alguma forma de leitura que ajude</h4>
						<h4 class="op-7">Pergunta quando não entende</h4>
						<h4 class="op-8">Sabe o que quer?</h4>
						<h4 class="op-9">Acredita que sua leitura pode melhorar</h4>
					</div>
				</div>

				<div class="row button-col-roda">
					<button id="print-btn">
						<a href="javascript:window.print();">Imprimir</a>
					</button>
					</div>

				<?php
			wp_link_pages(
				array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'llorix-one-lite' ),
					'after'  => '</div>',
				)
			);
		?>
			</div><!-- .entry-content -->

			<footer class="entry-footer">
				<?php edit_post_link( esc_html__( 'Edit', 'llorix-one-lite' ), '<span class="edit-link">', '</span>' ); ?>
			</footer><!-- .fentry-footer -->
		</article><!-- #post-## -->

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
		<script>
			document.getElementById('print-btn').onclick = function() {
				var content = document.getElementById('content').innetrHTML, 
				tela_impressão = window.open());
				tela_impressao.document.write('content');

				tela_impressao.document.write(content);
				tela_impressao.window.print(content);
				tela_impressao.window.close();
				};	
			</script>
		<!-- <script>
			function print_button_shortcode($atts) {
				return '<a class="print-link" href="javascript:window.print()">Print This Page</a>';
			}
			add_shortcode('print_button', 'print_button_shortcode');
		</script> -->
		<?php }
		echo '</main>';
		echo '</div>';

		if ( empty( $llorix_one_lite_change_to_full_width ) ) {
			get_sidebar();
		}
		?>
	</div>
</div><!-- .content-wrap -->



<?php get_footer(); ?>