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
			<?php	$llorix_one_lite_change_to_full_width = get_theme_mod( 'llorix_one_lite_change_to_full_width' );

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
			<div>
				<p>1º Pense em seu objetivo desejado.</p>
				<p>2º Olhe para a imagem a baixo.</p>
				<p>3º Digite nos campos em cima da imagem 10 palavras relacionadas aos seus objetivos.</p>
				<p>Não utilize as palavras que estenham na imagem</p>
			</div>
			 <div class="coaching">
					<img width="100%" src="https://lermelhor.com.br/wp-content/uploads/2019/01/coaching-de-aprendizagem.jpeg">
				
					<form>
							<input class="coaching-gear-1" type="text" placeholder="Digite aqui">
							<input class="coaching-gear-2" type="text" placeholder="Digite aqui">
							<input class="coaching-gear-3" type="text" placeholder="Digite aqui">
							<input class="coaching-gear-4" type="text" placeholder="Digite aqui">
							<input class="coaching-gear-5" type="text" placeholder="Digite aqui">
							<input class="coaching-gear-6" type="text" placeholder="Digite aqui">
							<input class="coaching-gear-7" type="text" placeholder="Digite aqui">
							<input class="coaching-gear-8" type="text" placeholder="Digite aqui">
							<input class="coaching-gear-9" type="text" placeholder="Digite aqui">
							<input class="coaching-gear-10" type="text" placeholder="Digite aqui">
					</form>
					<textarea name="reflecçãoOne" id="reflecção" cols="60" rows="10"></textarea>
					<div>
						<p>Escreva um texto relacionado ao seu objetivo desejado e utilize as 10 palavras que digitou a cima.<p>
					</div>
				</div>

				<div class="row button-col">
					<button id="print-btn" onclick="printPage()">
					Imprimir
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
			<script>
				function printPage() {
				window.print();
				}
			</script>
			</footer><!-- .fentry-footer -->
	
			</article><!-- #post-## -->
			
			<?php  }
				echo '</main>';
				echo '</div>';

				if ( empty( $llorix_one_lite_change_to_full_width ) ) {
				get_sidebar();
				}
			?>
			</div>
			</div><!-- .content-wrap -->

			<?php get_footer(); ?>