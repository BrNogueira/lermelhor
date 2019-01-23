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
			 <?php echo do_shortcode('[contact-form-7 id="1109" title="ROTEIRO PARA IDENTIFICAR CRENÇAS"]') ?>

			 

<iframe src="https://player.vimeo.com/video/188313818" allowfullscreen="" width="640" height="480" frameborder="0"></iframe>

ATIVIDADE DE ANCORA E EMOÇÕES
Essa atividade ajudará você compreender a importância das conquista e fortalecer os sentimentos bons que te motivam para as novas conquistas.

Vamos ancorar as emoções e sentimentos de realização. Escreva cinco conquistas que você já teve em sua vida e gerou esse sentimento de satisfação e realização.
<?php echo do_shortcode('[contact-form-7 id="1479" title="Formulário Modulo 3 Ancoras e Emoções"]') ?>



<iframe src="https://player.vimeo.com/video/188831940" allowfullscreen="" width="640" height="480" frameborder="0"></iframe>

AVALIAÇÃO DE APRENDIZADO CONTINUO
<?php echo do_shortcode(' [contact-form-7 id="1480" title="Formulário Modulo 3 AVALIAÇÃO DE APRENDIZADO CONTINUO"] ') ?>

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