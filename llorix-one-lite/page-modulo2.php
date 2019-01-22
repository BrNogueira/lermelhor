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
			 <h2><img class="alignnone size-large wp-image-954" src="https://lermelhor.com.br/wp-content/uploads/2018/12/blur-brainstorming-business-269448-1024x683.jpg" alt="" width="730" height="487"></h2>
				<h2>1ª Sessão de Coaching</h2>
				Auto avaliação do seu aprendizado no momento atual.
				<h2>*Fechamento da 1ª sessão:</h2>
				<ul>
					<li>O que aprendeu</li>
					<li>Quais mudanças necessárias</li>
					<li>Qual o sentido do aprendizado</li>
				</ul>
				<h2>2ª Sessão de Coaching</h2>
				<ul>
					<li>Perdas e Ganhos</li>
					<li>&nbsp;O que ganha se realizar</li>
					<li>&nbsp;O que perde se realizar</li>
					<li>&nbsp;O que ganha se não realizar</li>
					<li>O que perde se não realizar</li>
				</ul>
				<h2>1 Sessão de Neurociências</h2>
				Empoderamento
				<ul>
					<li>Ensaio Mental</li>
					<li>Como aumentar o desempenho mental</li>
				</ul>
				<h2>2 Sessões de Programação Neurolinguistica:</h2>
				Lista de Sonhos e crenças
				<ul>
					<li>Identificação de valores</li>
					<li>Tempestades de ideias</li>
				</ul>
				<h2>Relaxamento</h2>
				- 5 Cromoterapia
				<h2>Leitura Dinâmica</h2>
				- 5 Exercícios

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