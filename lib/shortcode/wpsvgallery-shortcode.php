<?php 

	if ( ! defined( 'ABSPATH' ) )
		exit; # Exit if accessed directly


	# shortocde
	function wpsvgallery_shortcode_register($atts, $content = null){
		$atts = shortcode_atts(
			array(
				'id' => '',
			), $atts);
			global $post;
			$post_id = $atts['id'];

			$content = '';


		$content.='<div id="wpsvgallery_area">';
		$content.='<ul id="svList">';

		$wpsvgallery_repeatable_fields	= get_post_meta( $post_id, 'wpsvgallery_repeatable_fields', true );
		$wpsvgallery_columns 			= get_post_meta( $post_id, 'wpsvgallery_columns', true );
		$wpsvgallery_bk_color 			= get_post_meta( $post_id, 'wpsvgallery_bk_color', true );
		$wpsvgallery_text_size			= get_post_meta( $post_id, 'wpsvgallery_text_size', true );
		$wpsvgallery_text_trans			= get_post_meta( $post_id, 'wpsvgallery_text_trans', true );
		$wpsvgallery_text_style			= get_post_meta( $post_id, 'wpsvgallery_text_style', true );
		$wpsvgallery_text_color 		= get_post_meta( $post_id, 'wpsvgallery_text_color', true );
		$wpsvgallery_overlay_color 		= get_post_meta( $post_id, 'wpsvgallery_overlay_color', true );
		$wpsvgallery_opc_color 			= get_post_meta( $post_id, 'wpsvgallery_opc_color', true );
		$wpsvgallery_grayscale 			= get_post_meta( $post_id, 'wpsvgallery_grayscale', true );
		$wpsvgallery_area_height 		= get_post_meta( $post_id, 'wpsvgallery_area_height', true );
		// title meta values
		$wpsv_title_text_size 			= get_post_meta($post_id, 'wpsv_title_text_size', true);		
		$wpsvg_title_text_trans 		= get_post_meta($post_id, 'wpsvg_title_text_trans', true);		
		$wpsvg_title_text_style 		= get_post_meta($post_id, 'wpsvg_title_text_style', true);		
		$wpsvg_title_alignment 			= get_post_meta($post_id, 'wpsvg_title_alignment', true);		
		$wpsvg_title_text_color 		= get_post_meta($post_id, 'wpsvg_title_text_color', true);	


		$content .='<style>';

		$content .='
			#svBox {
			  background-color:#'.$wpsvgallery_bk_color.';
			  display:block;
			  overflow: hidden;
			}
		';
		$content .='
			.ytVideo .sv-overlay, .vimeoVideo .sv-overlay, .dailyMVideo .sv-overlay {
			  background-color:#'.$wpsvgallery_overlay_color.';
			}
		';
		$content .='
			.svThumb img {
				height:'.$wpsvgallery_area_height.'px;
			}
		';
		$content .='
			#svList li:hover .sv-overlay {
			  opacity: '.$wpsvgallery_opc_color.';
			}
		';
		$content .='
			h3.svTitle {
			  color: #'.$wpsvg_title_text_color.';
			  font-style: '.$wpsvg_title_text_style.';
			  font-size: '.$wpsv_title_text_size.'px;
			  text-transform: '.$wpsvg_title_text_trans.';
			  text-align: '.$wpsvg_title_alignment.';
			}
		';
		$content .='
			.sv-text{
			  color:#'.$wpsvgallery_text_color.';
			  font-size: '.$wpsvgallery_text_size.'px;
			  text-transform: '.$wpsvgallery_text_trans.';
			  font-style:'.$wpsvgallery_text_style.';
			}
		';
/* 		$content .='
			.svThumb img {
			  filter:grayscale('.$wpsvgallery_grayscale.');
			}
		'; */

		$content .='</style>';			
		foreach($wpsvgallery_repeatable_fields as $single_items){

			$content .='<div class="wpsvgallery_cols-col-lg-'.$wpsvgallery_columns.' wpsvgallery_cols-col-md-4 wpsvgallery_cols-col-sm-2 wpsvgallery_cols-col-xs-1">';
				$content.='<li class="svThumb '.$single_items['select'].'" data-videoID="'.$single_items['url'].'">'.$single_items['name'].'</li>';
			$content.='</div>';

		};
		$content.='</ul>';
		$content.='</div>';		

		return $content;
	}

	// shortcode hook
	add_shortcode('wpsvgallery_composser', 'wpsvgallery_shortcode_register');