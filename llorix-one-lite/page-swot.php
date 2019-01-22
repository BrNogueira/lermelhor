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
?>"
	 itemprop="text">			 
			 Análise de SWOT - de seu aprendizado.
<div class="container-descriptions">
<div class="card-box">
<div class="box-descriptions1">
<ul class="">Pontos Fortes
 	<li><input type="text" placeholder="Pontos Fortes 1"></li>
 	<li><input type="text" placeholder="Pontos Fortes 2"></li>
 	<li><input type="text" placeholder="Pontos Fortes 3"></li>
 	<li><input type="text" placeholder="Pontos Fortes 4"></li>
</ul>
</div>
</div>
<div class="card-box">
<div class="box-descriptions2">
<ul class="">Oportunidades
 	<li><input type="text" placeholder="Oportunidades 1"></li>
 	<li><input type="text" placeholder="Oportunidades 2"></li>
 	<li><input type="text" placeholder="Oportunidades 3"></li>
 	<li><input type="text" placeholder="Oportunidades 4"></li>
</ul>
</div>
</div>
<div class="card-box">
<div class="box-descriptions3">
<ul class="">Pontos Fracos
 	<li><input type="text" placeholder="Pontos Fracos 1"></li>
 	<li><input type="text" placeholder="Pontos Fracos 2"></li>
 	<li><input type="text" placeholder="Pontos Fracos 3"></li>
 	<li><input type="text" placeholder="Pontos Fracos 4"></li>
</ul>
</div>
</div>
<div class="card-box">
<div class="box-descriptions4">
<ul class=""> Ameaças
 	<li><input type="text" placeholder=" Ameaças 1"></li>
 	<li><input type="text" placeholder=" Ameaças 2"></li>
 	<li><input type="text" placeholder=" Ameaças 3"></li>
 	<li><input type="text" placeholder=" Ameaças 4"></li>
</ul>
</div>
</div>
	<div class="row button-col">
		<button id="print-btn">
			<a href="javascript:window.print()">Imprimir</a>
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