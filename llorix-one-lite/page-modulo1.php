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
		echo '<main  itemtype="http://schema.org/WebPageElement" itemprop="mainContentOfPage" id="main" class="site-main" role="main">';
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
			
				<h2>Primeira sessão / Neurociências</h2>
				
				<h3>Clique na imagem para prosseguir!</h3>
				<a href="https://lermelhor.com.br/coaching-de-aprendizado/" target="_blank"><img src="https://lermelhor.com.br/wp-content/uploads/2019/01/Brandsorm-lermelhor-ok.jpg"
					 alt="BrandStorm" width="600" height="487"></a>

				<h2>Segunda sessão / Neurociências</h2>
				
				<h3>Clique na imagem para prosseguir!</h3>
				<a href="https://lermelhor.com.br/coaching-de-aprendizado-gear/" target="_blank"><img src="https://lermelhor.com.br/wp-content/uploads/2019/01/coaching-de-aprendizagem.jpeg"
					 alt="Gear Brain" width="600" height="487"></a>

					 <h2><label> Roda de Aprendizagem</label></h2><br>
					 <h3>Clique na imagem para prosseguir!</h3>

<a target="_blank" href="https://lermelhor.com.br/roda/"><img class="alignnone size-large wp-image-960" src="https://lermelhor.com.br/wp-content/uploads/2018/12/Rodadeaprendizagem.jpg" alt="" width="730" height="478"></a>

<?php echo do_shortcode(' [contact-form-7 id="972" title="Formulário Módulo - 3 Com - Primeiro Formulário"] ') ?>
<br>
<br>
<br>
<br>
<br>
<iframe class="vimeo-video" src="https://player.vimeo.com/video/189995490" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen="" width="640" height="480" frameborder="0"></iframe>
<iframe class="vimeo-video" src="https://player.vimeo.com/video/188327982" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen="" width="640" height="480" frameborder="0"></iframe>
<img src="https://lermelhor.com.br/wp-content/uploads/2018/12/Sinapse.jpg" alt="" class="alignnone size-full wp-image-1066" width="496" height="268">
<br>
<h4 class="text">Para que as novas sinapses sejam realizadas entre os neurônios é essencial que fale as palavras em voz alta durante esta atividade com áudio.</h4>
<div align="center"></div>
<div align="center">Atividade para potencializar o seu desempenho</div>
<iframe class="vimeo-video" src="https://player.vimeo.com/video/224708292" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen="" width="640" height="480" frameborder="0"></iframe>
<iframe class="vimeo-video" src="https://player.vimeo.com/video/240504733" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen="" width="640" height="480" frameborder="0"></iframe>
<iframe class="vimeo-video" src="https://player.vimeo.com/video/188313814" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen="" width="640" height="480" frameborder="0"></iframe>
<iframe class="vimeo-video" src="https://player.vimeo.com/video/188831735" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen="" width="640" height="480" frameborder="0"></iframe>
<div align="center"><br>Fechamento da primeira sessão do Modelo de Coaching</div>


<?php echo do_shortcode('[contact-form-7 id="1021" title="Formulario Modulo 3 - Segundo Formulário"]') ?>

<h2>Essa é uma sessão de "ROADMAP" ( Roteiro) </h2>
	
<p>Iremos ajudar organizar o seu roteiro de um Objetivo ou Sonho.<p>
<p>Planejar a rota do final para o começo.<p>

<h3>Clique na imagem para prosseguir!</h3>
<h2><a href="https://lermelhor.com.br/roadmap-teste/" target="_blank">
<img class="alignnone size-large wp-image-960" src="https://lermelhor.com.br/wp-content/uploads/2018/12/SETA-RODMAP.jpg" alt="" width="500" height="478"></a></h2>
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