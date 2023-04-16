<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

get_header();

$description = get_the_archive_description();
?>

<?php if ( have_posts() ) : ?>

	<?php
	 	$tag_id = get_queried_object()->term_id;
		$identifier = "post_tag_".$tag_id;
		$color = get_field('color', $identifier);
	?>

	<header class="page-header alignwide">
		<?php the_archive_title( '<h1 class="page-title"'.( $color ? ' data-tag-color="'. $color . '"' : '') . '>', '</h1>' ); ?>
		<?php if ( $description ) : ?>
			<div class="archive-description"><?php echo wp_kses_post( wpautop( $description ) ); ?></div>
		<?php endif; ?>
	</header><!-- .page-header -->

	<?php while ( have_posts() ) : ?>
		<?php the_post(); ?>
		<?php get_template_part( 'template-parts/content/content', get_theme_mod( 'display_excerpt_or_full_post', 'excerpt' ) ); ?>
	<?php endwhile; ?>

	<?php twenty_twenty_one_the_posts_navigation(); ?>

<?php else : ?>
	<?php get_template_part( 'template-parts/content/content-none' ); ?>
<?php endif; ?>

<script>
		const color = "<?php echo($color);?>";
		const titleElement = document.querySelector('.page-title span');

		if (color && titleElement) {
			const circle = document.createElement('div');
			circle.style.display = 'inline-block';
			circle.style.width = '0.25em';
			circle.style.height = '0.25em';
			circle.style.borderRadius = '50%';
			circle.style.backgroundColor = color;

			titleElement.append(circle);
		}
	</script>

<?php
get_footer();
