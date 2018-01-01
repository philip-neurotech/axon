<?php
/*
Plugin Name: Dm popup
Plugin URI:  http://digitalmarket.co.il/
Version:     1.0.0
Description: Contact us popup. For wordpress 4.2.0+
Author:      DigitalMarket
Author URI:  http://digitalmarket.co.il/
Text Domain: dmPopup
*/

add_action('plugins_loaded', 'dmPopup_load_textdomain');
function dmPopup_load_textdomain() {
	load_plugin_textdomain( 'dmPopup', false, plugin_basename( dirname( __FILE__ ) ) );
}

// wp_customize
function dmPopup_customize_register( $wp_customize ) {
	
	$wp_customize->add_section( 'dmpopup_section' , array(
		'title'      => __( 'popup settings', 'dmPopup' ),
		'priority'   => 300,
	) );
	
	// display true/false
	$wp_customize->add_setting( 'display' , array(
		'default'     => false,
		'transport'   => 'refresh',
	) );
	
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'display', array(
		'label'        => __( 'Display', 'dmPopup' ),
		'section'    => 'dmpopup_section',
		'settings'   => 'display',
		'type'     => 'checkbox',
	) ) );
	
	// shortcode
	
	
	if ( function_exists('icl_object_id') ) {
		$langs = icl_get_languages('skip_missing=N&orderby=KEY&order=DIR&link_empty_to=str');
		foreach ($langs as $language) {
		 
			$wp_customize->add_setting( 'shortcode'.$language['code'] , array(
				'default'     => '[shortcode...]',
				'transport'   => 'refresh',
			) );
			
			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'shortcode'.$language['code'], array(
				'label'        => __( 'Shortcode ', 'dmPopup' ).' '.$language['translated_name'],
				'section'    => 'dmpopup_section',
				'settings'   => 'shortcode'.$language['code'],
				'type'     => 'text',
			) ) );
		}
	} else {
		$wp_customize->add_setting( 'shortcode' , array(
			'default'     => '[shortcode...]',
			'transport'   => 'refresh',
		) );
		
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'shortcode', array(
			'label'        => __( 'Shortcode ', 'dmPopup' ),
			'section'    => 'dmpopup_section',
			'settings'   => 'shortcode',
			'type'     => 'text',
		) ) );
	}
	
	
	// headline text
	if ( function_exists('icl_object_id') ) {
		$langs = icl_get_languages('skip_missing=N&orderby=KEY&order=DIR&link_empty_to=str');
		foreach ($langs as $language) {
			$wp_customize->add_setting( 'headline_text'.$language['code'] , array(
				'default'     => __('Headline', 'dmPopup'),
				'transport'   => 'refresh',
			) );
			
			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'headline_text'.$language['code'], array(
				'label'        => __( 'Headline', 'dmPopup' ).' '.$language['translated_name'],
				'section'    => 'dmpopup_section',
				'settings'   => 'headline_text'.$language['code'],
				'type'     => 'text',
			) ) );
		}
	} else {
		$wp_customize->add_setting( 'headline_text' , array(
			'default'     => __('Headline', 'dmPopup'),
			'transport'   => 'refresh',
		) );
		
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'headline_text', array(
			'label'        => __( 'Headline', 'dmPopup' ),
			'section'    => 'dmpopup_section',
			'settings'   => 'headline_text',
			'type'     => 'text',
		) ) );
	}
	
	// btn bg color
	$wp_customize->add_setting( 'btn_bg_color' , array(
		'default'     => '#000000',
		'transport'   => 'refresh',
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bg_color', array(
		'label'        => __( 'botton bg color', 'dmPopup' ),
		'section'    => 'dmpopup_section',
		'settings'   => 'btn_bg_color',
	) ) );
	
	// btn text color
	$wp_customize->add_setting( 'btn_text_color' , array(
		'default'     => '#ffffff',
		'transport'   => 'refresh',
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'text_color', array(
		'label'        => __( 'botton text color', 'dmPopup' ),
		'section'    => 'dmpopup_section',
		'settings'   => 'btn_text_color',
	) ) );
	
	// btn bg color hover
	$wp_customize->add_setting( 'btn_bg_color_hover' , array(
		'default'     => '#000000',
		'transport'   => 'refresh',
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'background_color_hover', array(
		'label'        => __( 'botton background color hover', 'dmPopup' ),
		'section'    => 'dmpopup_section',
		'settings'   => 'btn_bg_color_hover',
	) ) );
	
	// btn text color hover
	$wp_customize->add_setting( 'btn_text_color_hover' , array(
		'default'     => '#ffffff',
		'transport'   => 'refresh',
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'text_color_hover', array(
		'label'        => __( 'botton text color hover', 'dmPopup' ),
		'section'    => 'dmpopup_section',
		'settings'   => 'btn_text_color_hover',
	) ) );


	
	/*******  click to call  *******/
	
	$wp_customize->add_section( 'dmctc_section' , array(
		'title'      => __( 'Click to call settings', 'dmPopup' ),
		'priority'   => 310,
	) );
	
	// display true/false
	$wp_customize->add_setting( 'display_ctc' , array(
		'default'     => false,
		'transport'   => 'refresh',
	) );
	
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'display_ctc', array(
		'label'        => __( 'Display', 'dmPopup' ),
		'section'    => 'dmctc_section',
		'settings'   => 'display_ctc',
		'type'     => 'checkbox',
	) ) );
	
	// phone
	$wp_customize->add_setting( 'phone' , array(
		'default'     => '',
		'transport'   => 'refresh',
	) );
	
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'phone', array(
		'label'        => __( 'phone', 'dmPopup' ),
		'section'    => 'dmctc_section',
		'settings'   => 'phone',
		'type'     => 'number',
	) ) );
	
	// btn color
	$wp_customize->add_setting( 'ctc_bg_color' , array(
		'default'     => '#000000',
		'transport'   => 'refresh',
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ctc_bg_color', array(
		'label'        => __( 'botton bg color', 'dmPopup' ),
		'section'    => 'dmctc_section',
		'settings'   => 'ctc_bg_color',
	) ) );
	
	// icon
	$wp_customize->add_setting( 'icon' , array(
		'default'     => '',
		'transport'   => 'refresh',
	) );
	
	$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'icon', array(
	  'label' => __( 'Icon', 'dmPopup' ),
	  'section' => 'dmctc_section',
	  'description' => __( 'If you want to change default icon', 'dmPopup' ),
	  'mime_type' => 'image',
	) ) );
	
	
	/* Social */
	$wp_customize->add_section( 'dm_social_section' , array(
		'title'      => __( 'Social settings', 'dmPopup' ),
		'priority'   => 320,
	) );
	
	$fields = array('whatsapp','phone','envelope','facebook','google+','twitter','instagram');
	foreach($fields as $field){
		add_social_field('display_'.$field,'checkbox');
		if($field != 'whatsapp'){
			add_social_field($field,'text');
		}
	}
	
	
	
}
add_action( 'customize_register', 'dmPopup_customize_register' );


function add_social_field($field,$type){
	global $wp_customize;
	
	// display true/false
	$wp_customize->add_setting( $field , array(
		'default'     => ''
	) );
	
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, $field, array(
		'label'        => __( ucfirst( str_replace("_"," ",$field) ), 'dmPopup' ),
		'section'    => 'dm_social_section',
		'settings'   => $field,
		'type'     => $type,
	) ) );

}


if( !is_admin() ):

	wp_enqueue_style( 'dm-popup', plugin_dir_url( __FILE__ ) . 'style.css' );

	function dm_popup_add_html() { ?>
		<a class="popup-btn"><i class="fa fa-envelope"></i><span class="popup-text"><?php
		if( function_exists('icl_object_id') ){							
			echo get_theme_mod( 'headline_text'.ICL_LANGUAGE_CODE, '' );
		} else {
			echo get_theme_mod( 'headline_text', '' );
		}
		?></span></a>
		<div class="popup-wrap" style="display:none;">
			<div>
				<div class="popup-content">
					<a class="button close-btn">X</a>
					<div class="shortcode">
						<?php if( get_theme_mod( 'headline_text') ): ?>
							<h3 class="popup-headline"><?php
							if( function_exists('icl_object_id') ){							
								echo get_theme_mod( 'headline_text'.ICL_LANGUAGE_CODE, '' );
							} else {
								echo get_theme_mod( 'headline_text', '' );
							}
							
							?></h3>
						<?php endif; ?>
						<?php
						if( function_exists('icl_object_id') ){							
							echo do_shortcode ( get_theme_mod( 'shortcode'.ICL_LANGUAGE_CODE, '[popup shortcode output here...]' ) );
						} else {
							echo do_shortcode ( get_theme_mod( 'shortcode', '[popup shortcode output here...]' ) );
						}
						?>
					</div>
				</div>
			</div>
		</div>
		
		<script>
		jQuery(document).ready(function($){
			
			$('a.popup-btn').click(function(){
				$('.popup-wrap').fadeIn('fast');
				$('.popup-content').animate({top: '0', opacity: '1'},'slow');
			});
			
			$('a.close-btn').click(function(){
				$('.popup-content').animate({top: '-1000px', opacity: '0'},'slow');
				$('.popup-wrap').fadeOut('fast');
			});
		});
		</script>
		
		<style>
		a.popup-btn {
			background: <?php echo get_theme_mod( 'btn_bg_color', '#000000' ); ?>;
			color: <?php echo get_theme_mod( 'btn_text_color', '#ffffff' ); ?>;
		}
		
		a.popup-btn:hover {
			background: <?php echo get_theme_mod( 'btn_bg_color_hover', '#000000' ); ?>;
			color: <?php echo get_theme_mod( 'btn_text_color_hover', '#ffffff' ); ?>;
		}
		</style>
		
	<?php }
	
	function dm_ctc_add_html() {
		if( get_theme_mod('icon') ) {
			$icon_id = get_theme_mod('icon');
			$icon_url = wp_get_attachment_image_src($icon_id)[0];
		} else {
			$icon_url = plugin_dir_url( __FILE__ ) .'phone_icon.png';
		}
		?>
		<a class="dm-ctc" href="tel:<?php echo get_theme_mod( 'phone', '030000000' ); ?>">
			<img src="<?php echo $icon_url; ?>" alt="<?php echo __('Click to call', 'dmPopup'); ?>">
		</a>
		<style>
		a.dm-ctc {
			background: <?php echo get_theme_mod( 'ctc_bg_color', '#000000' ); ?>
		}
		</style>
	<?php }
	
	
	function dm_social_add_html() {
		$html = '<div class="bottom-social-icons">';
		$fields = array('whatsapp','phone','envelope','facebook','google+','twitter','instagram');
		foreach($fields as $field){
			$display = get_theme_mod('display_'.$field);
			$link = get_theme_mod($field);
			if($display){
				$url = '';
				
				switch ($field){
					case 'phone':
						if($link){
							$url = "tel:$link";
						}
						break;
					case 'whatsapp':
						$url = 'whatsapp://send?text='.get_bloginfo( 'name' ).' '.get_home_url();
						break;
					default:
						if($link){
							$url = $link;
						}
						break;
				}
				
				$html .= "<a href='$url'><i class='fa fa-$field' aria-hidden='true'></i></a>";
			}
		}
		
		$html .= '</div>';
		
		echo $html;
	}
	
	
	if( get_theme_mod('display') && !wp_is_mobile() ) {
		add_action( 'wp_footer', 'dm_popup_add_html' );
	}
	if( get_theme_mod('display_ctc') ) {
		add_action( 'wp_footer', 'dm_ctc_add_html' );
	}
	
	if( wp_is_mobile() ) {
		add_action( 'wp_footer', 'dm_social_add_html' );
	}

endif; // !is_admin


// script
