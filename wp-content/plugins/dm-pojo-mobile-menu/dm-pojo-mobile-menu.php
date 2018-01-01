<?php
/*
Plugin Name: DM Pojo menu mobile
Plugin URI: http://DigitalMarket.co.il/
Author: DigitalMarket
Author URI: http://DigitalMarket.co.il/
Version: 0.0.2
Description: Take any Pojo menu to the next level...
Text Domain: dm-pojo-menu-mobile
Domain Path:
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

function script_style() {
	$left = is_rtl() ? 'left' : 'right';
	$right = is_rtl() ? 'right' : 'left';
	?>
	<script>

	(function($) {
		
		jQuery(document).ready(function() {
			 
			$('.mobile-menu .menu-item').has('.sub-menu').prepend('<span class="nav-click-mobile"><i class="fa fa-chevron-down" aria-hidden="true"></i></span>');
		
			$(".nav-click-mobile").click(function(){
				var wrap = $(this).parent();
				wrap.toggleClass("active-sub-menu");
				wrap.find('ul').first().slideToggle('fast');
			});
		});
		
		$(document).on('click','button.navbar-toggle',function(){
			$('button.navbar-toggle').toggleClass("menu-open");
		});
		
		
	})( jQuery );

	</script>
	<style>
	.nav-main .navbar-collapse .mobile-menu>li {
		display: block;
		margin: 0;
		padding: 0;
		position: relative;
	}
	.mobile-menu .nav-click-mobile {
		width: 37px;
		height: 100%;
		display: inline-block;
		float: <?php echo $left; ?>;
		clear: both;
		position: absolute;
		<?php echo $left; ?>: 0;
		text-align: center;
		padding-top: 7px;
	}
	
	.nav-main .navbar-collapse .mobile-menu .sub-menu {
		padding-<?php echo $right; ?>: 15px;
	}
	
	.mobile-menu ul.sub-menu {
		display: none;
	}
	.active-sub-menu > .nav-click-mobile .fa-chevron-down:before {
		content: "\f00d";
		color: inherit;
	}
	button.menu-open .icon-bar:nth-child(2) {
		transform: rotate(-45deg);
		top: 6px;
	}
	button.menu-open .icon-bar:nth-child(3) {
		width:0;
		margin-right: auto;
		margin-left: auto;
	}
	button.menu-open .icon-bar:nth-child(4) {
		transform: rotate(45deg);
		top: -6px;
	}
	.navbar-toggle .icon-bar {
		position: relative;
		top: 0;
		transform: rotate(0deg);
		transition: all 0.2s ease;
	}
	
	</style>
	<?php
}


add_action( 'after_setup_theme', 'dm_pojo_menu_setup' );
function dm_pojo_menu_setup(){
	if ( class_exists( 'Pojo_Theme_Template' ) ) {
		add_action( 'wp_footer', 'script_style' );
	} else {
		add_action( 'admin_notices', 'admin_notice_if_it_is_not_pojo_theme' );
	}
}

function admin_notice_if_it_is_not_pojo_theme() {
    ?>
    <div class="notice notice-error is-dismissible">
        <p><?php _e( 'You are using a non-fojo Theme, so the "DM Pojo menu mobile" extension is not effective', 'dm-pojo-menu-mobile' ); ?></p>
    </div>
    <?php
}

