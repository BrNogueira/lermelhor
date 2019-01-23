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
			 <h2><img class="alignnone size-large wp-image-960" src="https://lermelhor.com.br/wp-content/uploads/2018/12/achievement-agreement-arms-1068523-1024x670.jpg" alt="" width="730" height="478"></h2>
			 <button class="btn">
				<a href="https://lermelhor.com.br/modulo1/" target="_blank" >Modulo 1</a>
			</button>
			<button class="btn">
				<a href="https://lermelhor.com.br/modulo2/" target="_blank" >Modulo 2</a>
			</button>
			<button class="btn">
				<a href="https://lermelhor.com.br/modulo3/" target="_blank" >Modulo 3</a>
			</button>

			 <?php echo do_shortcode('[contact-form-7 id="1021" title="Formulario Modulo 3 parte 2"]') ?>

<iframe src="https://player.vimeo.com/video/188313816" allowfullscreen="" width="640" height="480" frameborder="0"></iframe>
<iframe src="https://player.vimeo.com/video/188830888" allowfullscreen="" width="640" height="480" frameborder="0"></iframe>
<div align="center">Atividade com Neurociências</div>
<div align="center">Esta é uma atividade com Neurociências e é extremamente necessário
anotar as 10 palavras antes que passe para a próxima fase.</div>
<?php echo do_shortcode('[contact-form-7 id="1023" title="Formulario Modulo 3 parte 3(10 palavras)"]') ?>

<iframe src="https://player.vimeo.com/video/188313818" allowfullscreen="" width="640" height="480" frameborder="0"></iframe>

<iframe src="https://player.vimeo.com/video/188831940" allowfullscreen="" width="640" height="480" frameborder="0"></iframe>

<img src="https://lermelhor.com.br/wp-content/uploads/2018/12/Valores2.jpg" alt="" class="alignnone size-full wp-image-1072" width="573" height="833">

<?php echo do_shortcode('[contact-form-7 id="1026" title="Formulario Modulo 3 parte 4"]') ?>

<div align="center">Programação Neurolinguística "Sessão de valores"</div>
<div align="center">2º Modelo de Coaching " Perdas e Ganhos"</div>
<img src="https://lermelhor.com.br/wp-content/uploads/2018/12/ArtedaGuerra.jpg" alt="" class="alignnone size-full wp-image-1075" width="490" height="430">
Este é um modelo de Coaching de perdas e ganhos, iremos ajudar você avaliar quais são suas reais necessidades, motivos e decisões que deve tomar.

Em todos nós existe um "Sabotador" que devemos entende-los e aprender conviver.

(Sabotador do Prazer)
Estes " Sentimentos, pensamentos ou influência de terceiros" é o sabotador que fica dizendo "não faça", pra que fazer isso, não precisa fazer.
" Se não fizer, você não terá preocupações" "ficara descansando"... etc.

(Sabotador do Prazer) por que prefere não se esforçar e sim relaxar ficar tranquilo " deixar do mesmo jeito", "assim esta bom.

(Sabotador da dor)
É um sabotador porque vai falar para você não fazer alguma coisa para não sentir dor e acaba não conseguindo chegar ao seu objetivo.
Não quer fazer o que precisa ser feito, com isso você terá ganhos secundários.

<?php echo do_shortcode('[contact-form-7 id="1028" title="Formulario Modulo 3 Quinto Formulário"]') ?>

Análise de SWOT -  De seu aprendizado

Cliquei imagem

<a target="_blank" href="https://lermelhor.com.br/swot/"><img class="alignnone size-large wp-image-960" src="https://lermelhor.com.br/wp-content/uploads/2018/12/matriz-swot.jpg" alt="" width="730" height="478"></a>

<?php echo do_shortcode(' [contact-form-7 id="1031" title="Formulario Modulo 3 Sexto Formulário"] ') ?>

Essa é uma sessão de "ROADMAP" ( Roteiro)

Iremos ajudar organizar o seu roteiro de um Objetivo ou Sonho.
Planejar a rota do final para o começo.

<label> Clique na imagem</label>
<h2><a href="https://lermelhor.com.br/roadmap/"><img class="alignnone size-large wp-image-960" src="https://lermelhor.com.br/wp-content/uploads/2018/12/SETA-RODMAP.jpg" alt="" width="730" height="478"></a></h2>
1- Defina um grande Objetivo, Meta / Sonho.


<?php echo do_shortcode(' [contact-form-7 id="1033" title="Formulario Modulo 3 parte 7"] ') ?>

<?php echo do_shortcode(' [contact-form-7 id="1109" title="ROTEIRO PARA IDENTIFICAR CRENÇAS"] ') ?>

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