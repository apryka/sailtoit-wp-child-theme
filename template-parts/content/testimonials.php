<?php
/**
 * displays testimonials list
 */
?>

<?php
  $title = $args['title'] != null ? $args['title'] : __('Latest testimonials', 'worko-cloudnine');
  $limit = $args['limit'] != null ? $args['limit'] : 10;
?>

<?php
  $testimonials_query = new WP_Query(array(
    'posts_per_page' => $limit,
    'post_status' => 'publish',
    'post_type' => 'testimonial'
  ));
  $testimonials = $testimonials_query->posts;

  if ( count($testimonials)) {
?>

<!-- Slider main container -->
<div class="swiper testimonials">
  <h3 class="testimonials__header"><?php echo $title; ?></h3>
  <!-- Additional required wrapper -->
  <div class="swiper-wrapper testimonials__slider">
  <?php 
    foreach($testimonials as $testimonial):
      $title = $testimonial->post_title;
      $text = $testimonial->post_content;
  ?>
    <!-- Slides -->
    <div class="swiper-slide testimonials-item">
      <div class="testimonials-item__text"><?php echo $text; ?></div>
      <div class="testimonials-item__title">
        <?php echo $title; ?>
      </div>
    </div>
  <?php endforeach; ?>
  </div>
  <!-- If we need pagination -->
  <div class="swiper-pagination"></div>

</div>

<?php } ?>

<script>
  const swiper = new Swiper(".swiper", {
    slidesPerView: 3,
    spaceBetween: 30,
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
  });
</script>
