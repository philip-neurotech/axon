<?php
/**
 * Recent Gallery: Grid Three
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $_current_widget_instance;
?>
<div class="recent-galleries grid-item gallery-item col-md-4 col-sm-6 col-xs-6">
	<?php if ( $image_url = Pojo_Thumbnails::get_post_thumbnail_url( array( 'width' => '600', 'height' => '400', 'crop' => true, 'placeholder' => true ) ) ) : ?>
		<a class="image-link" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark">
			<img src="<?php echo $image_url; ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" class="media-object" />
			<div class="overlay-plus">
				<i class="fa fa-plus-circle"></i>
			</div>
		</a>
	<?php endif; ?>
	<?php if ( 'hide' !== $_current_widget_instance['show_title'] ) : ?>
		<div class="caption">
			<h4 class="grid-heading entry-title">
				<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a>
			</h4>
		</div>
	<?php endif; ?>
</div>