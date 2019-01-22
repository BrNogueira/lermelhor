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
				<div class="row roadmap col-md-12">
					<img width="500" height="300" src="https://lermelhor.com.br/wp-content/uploads/2018/12/SETAROADMAP-295x300.jpg"
					 class="attachment-medium size-medium" alt="" srcset="https://lermelhor.com.br/wp-content/uploads/2018/12/SETAROADMAP-295x300.jpg 295w, https://lermelhor.com.br/wp-content/uploads/2018/12/SETAROADMAP.jpg 698w"
					 sizes="(max-width: 400px) 100vw, 400px">

					<form>
						<input class="first-box-text" type="text" placeholder="Digite aqui">
						<input class="sec-box-text" type="text" placeholder="Digite aqui">
						<input class="tr-box-text" type="text" placeholder="Digite aqui">
						<input class="fort-box-text" type="text" placeholder="Digite aqui">
						<input class="fiv-box-text" type="text" placeholder="Digite aqui">
						<input class="six-box-text" type="text" placeholder="Digite aqui">
						<input class="sev-box-text" type="text" placeholder="Digite aqui">
						<input class="eig-box-text" type="text" placeholder="Digite aqui">
					</form>

				</div>
				<script src="./assets/css/bootstrap/bootstrap.min.css"></script>
				<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
				<div class="row button-col">
					<button id="print-btn">
						<a href="javascript:window.print()">Imprimir</a>
					</button></div>
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