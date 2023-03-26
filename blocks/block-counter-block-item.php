<?php
/**
 * Custom block for Counter block's item
*/
?>

<div class="block-counter-item">
  <p class="block-counter-item__value" data-counter="<?php block_field( 'item-value' ); ?>">
    <?php block_field( 'item-value' ); ?>
  </p>
  <p class="block-counter-item__description">
    <?php block_field( 'item-description' ); ?>
  </p>
</div>