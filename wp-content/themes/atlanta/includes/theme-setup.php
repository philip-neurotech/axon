<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

function pojo_main_widgets_init() {
	register_sidebar(
		array(
			'id'            => 'pojo-' . sanitize_title( 'Main Sidebar' ),
			'name'          => __( 'Main Sidebar', 'pojo' ),
			'description'   => __( 'These are widgets for the Main Sidebar', 'pojo' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s"><div class="widget-inner">',
			'after_widget'  => '</div></section>',
			'before_title'  => '<h5 class="widget-title"><span>',
			'after_title'   => '</span></h5>',
		)
	);

	register_sidebar(
		array(
			'id'            => 'pojo-' . sanitize_title( 'Top Bar Right' ),
			'name'          => __( 'Top Bar Right', 'pojo' ),
			'description'   => __( 'These are widgets for the Top Bar Right', 'pojo' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s"><div class="widget-inner">',
			'after_widget'  => '</div></section>',
			'before_title'  => '<h5 class="widget-title"><span>',
			'after_title'   => '</span></h5>',
		)
	);

	register_sidebar(
		array(
			'id'            => 'pojo-' . sanitize_title( 'Top Bar Left' ),
			'name'          => __( 'Top Bar Left', 'pojo' ),
			'description'   => __( 'These are widgets for the Top Bar Left', 'pojo' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s"><div class="widget-inner">',
			'after_widget'  => '</div></section>',
			'before_title'  => '<h5 class="widget-title"><span>',
			'after_title'   => '</span></h5>',
		)
	);

	$slidebar_class = pojo_get_sidebar_columns_class(
		array(
			'1' => 'col-sm-12',
			'2' => 'col-sm-6',
			'3' => 'col-sm-4',
			'4' => 'col-sm-3',
		),
		'4',
		'slidebar_widget_columns'
	);

	register_sidebar(
		array(
			'id'            => 'pojo-' . sanitize_title( 'Outer Slidebar' ),
			'name'          => __( 'Outer Slidebar', 'pojo' ),
			'description'   => __( 'These are widgets for the Outer Slidebar', 'pojo' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s ' . $slidebar_class . '"><div class="widget-inner">',
			'after_widget'  => '</div></section>',
			'before_title'  => '<h5 class="widget-title"><span>',
			'after_title'   => '</span></h5>',
		)
	);

	$footer_class = pojo_get_sidebar_columns_class(
		array(
			'1' => 'col-sm-12',
			'2' => 'col-sm-6',
			'3' => 'col-sm-4',
			'4' => 'col-sm-3',
		),
		'4',
		'sidebar_footer_columns'
	);

	register_sidebar(
		array(
			'id'            => 'pojo-' . sanitize_title( 'Footer' ),
			'name'          => __( 'Footer', 'pojo' ),
			'description'   => __( 'These are widgets for the Footer', 'pojo' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s ' . $footer_class . '"><div class="widget-inner">',
			'after_widget'  => '</div></section>',
			'before_title'  => '<h5 class="widget-title"><span>',
			'after_title'   => '</span></h5>',
		)
	);
}
add_action( 'widgets_init', 'pojo_main_widgets_init' );

function pojo_theme_setup() {
	add_theme_support( 'pojo-blank-page' );
	add_theme_support( 'pojo-page-header' );
	add_theme_support( 'pojo-wc-menu-cart' );
	add_theme_support( 'pojo-infinite-scroll' );
	add_theme_support( 'pojo-background-options' );
	add_theme_support( 'pojo-recent-post-metadata' );
}
add_action( 'after_setup_theme', 'pojo_theme_setup', 20 );
