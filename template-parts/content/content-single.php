<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header alignwide">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		<?php twenty_twenty_one_post_thumbnail(); ?>
	</header><!-- .entry-header -->

	<div class="entry-content">

		<?php $post_tags = get_the_tags(); ?>
		<?php if ($post_tags && count($post_tags)) { ?>
			<ul class="color-tags-list">
		
			<?php
				foreach( $post_tags as $tag) :
					$tag_name = $tag->name;
					$link = get_tag_link($tag);
					$identifier = "post_tag_".$tag->term_id;
					$color = get_field('color', $identifier);
			?>

			<li>
				<a href="<?php echo($link); ?>" class="color-tag" style="border-color: <?php echo($color); ?>">
					<?php echo($tag_name); ?>
				</a>
			</li>
			
			<?php endforeach; ?>
			</ul>
		<?php	}	?>

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

	<footer class="entry-footer default-max-width">
		<?php twenty_twenty_one_entry_meta_footer(); ?>
	</footer><!-- .entry-footer -->

	<?php if ( ! is_singular( 'attachment' ) ) : ?>
		<?php get_template_part( 'template-parts/post/author-bio' ); ?>
	<?php endif; ?>

</article><!-- #post-<?php the_ID(); ?> -->
