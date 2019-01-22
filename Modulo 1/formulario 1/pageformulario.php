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

				<div class="modal" tabindex="-1" role="dialog">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title">Modal title</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<p>Modal body text goes here.</p>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							</div>
						</div>
					</div>
				</div>

				<script>
					$('#myModal').on('shown.bs.modal', function () {
						$('#myInput').trigger('focus')
					})
				</script>

				<div class="row button-col-roda">
					<button id="print-btn">
						<a href="javascript:window.print();">Imprimir</a>
					</button>
				</div>
				<?php 

					switch ($variavelTexto) {
						case 'LEANDRO':
							echo "variável é igual a LEANDRO";
							break;
						case 'MARCO':
							echo "variável é igual a MARCO";
							break;
						case 'ROBERTO':
							echo "variável é igual a ROBERTO";
							break;
						 case 'MARCIO':
							echo "variável é igual a MARCIO";
							break;
						 default:
						   echo "TEXTO PADRAO";
					}
					?>

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

		</script>
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