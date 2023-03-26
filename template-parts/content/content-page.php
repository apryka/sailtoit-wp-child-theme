<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php if ( has_post_thumbnail() ) : ?>
		<header class="entry-header alignwide">
			<?php twenty_twenty_one_post_thumbnail(); ?>
		</header><!-- .entry-header -->
	<?php endif; ?>

	<?php 
		$headline = get_field('headline');
		if ( is_front_page() && isset($headline) ) {
	?>
	<header class="entry-header">
		<h2 class="headline">
			<?php echo $headline; ?>
		</h2>
	</header>

	<?php } ?>

	<div class="entry-content">
		<?php
			$avatar = get_field('avatar');
			$avatarSize = get_field('avatar_size');
			if ( is_front_page() && isset($avatar) ) {
		?>
			<img src="<?php echo $avatar; ?>" alt="avatar" class="entry-content__avatar" <?php if ( isset($avatarSize) ) { ?> style=" width:<?php echo $avatarSize ?>px; height: <?php echo $avatarSize ?>px;" <?php } ?> />
		<?php } ?>
		<div class="entry-content__title"><?php the_title(); ?></div>
		<?php
		the_content();

		wp_link_pages(
			array(
				'before'   => '<nav class="page-links" aria-label="' . esc_attr__( 'Page', 'twentytwentyone' ) . '">',
				'after'    => '</nav>',
				/* translators: %: Page number. */
				'pagelink' => esc_html__( 'Page %', 'twentytwentyone' ),
			)
		);
		?>
	</div><!-- .entry-content -->

	<?php 
	 if ( is_front_page()) {
	?>
	<div class="testimonials-content">
	<?php get_template_part( 'template-parts/content/testimonials', '', array(
		'title' => "Opinie"
	) ); ?>
	</div>
	<?php } ?>


	<?php if ( get_edit_post_link() ) : ?>
		<footer class="entry-footer default-max-width">
			<?php
			edit_post_link(
				sprintf(
					/* translators: %s: Post title. Only visible to screen readers. */
					esc_html__( 'Edit %s', 'twentytwentyone' ),
					'<span class="screen-reader-text">' . get_the_title() . '</span>'
				),
				'<span class="edit-link">',
				'</span>'
			);
			?>
		</footer><!-- .entry-footer -->
	<?php endif; ?>
</article><!-- #post-<?php the_ID(); ?> -->
