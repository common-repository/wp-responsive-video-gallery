<?php

	if( !defined( 'ABSPATH' ) ){
	    exit;
	}

	function register_wpsvgallery_meta_boxes() {

		$wpsvg = array( 'wpsvgallery' );
	    add_meta_box( 
	        'wpsvgallery_meta_box_id',                          # Metabox
	        __( 'Video Gallery', 'wpsvgallery' ),           	# Title
	        'display_all_gallery_inputs',                       # Call Back func
	       	$wpsvg,                                         	# post type
	        'normal'                                            # Text Content
	    );
	    add_meta_box( 
	        'wpsvgallery_shortcode_box_id',                     # Metabox
	        __( 'Gallery Shortcode', 'wpsvgallery' ),          	# Title
	        'display_shortcode_gallery_inputs',                 # Call Back func
	       	$wpsvg,                                         	# post type
	        'normal'                                            # Text Content
	    );
		add_meta_box( 
			'wpsvgallery_custom_meta_box_set',                  # Metabox
			__( 'Settings', 'wpsvgallery' ),           			# Title
			'wpsvgallery_settings_func',                        # Call Back func
			$wpsvg,                                         	# post type
			'side'                                              # Text Content
		);
	}
	add_action( 'add_meta_boxes', 'register_wpsvgallery_meta_boxes' );

	
	function wpsvgallery_meta_shortcode_clmn( $columns ) {
		return array_merge( $columns,
		array( 
	  		'shortcode' => __( 'Shortcode', 'wpsvgallery' ),
	  		'doshortcode' => __( 'Template Shortcode', 'wpsvgallery' ) )
		);
	}
	add_filter( 'manage_wpsvgallery_posts_columns' , 'wpsvgallery_meta_shortcode_clmn' );


	function wpsvgallery_meta_clmn_display( $tpcp_column, $post_id ) {
		 if ( $tpcp_column == 'shortcode' ){
		  ?>
		  <input style="background:#ddd" type="text" onClick="this.select();" value="[wpsvgallery_composser <?php echo 'id=&quot;'.$post_id.'&quot;';?>]" />
		  <?php
		}

		if ( $tpcp_column == 'doshortcode' ){
		?>
		<textarea cols="40" rows="2" style="background:#ddd;" onClick="this.select();" ><?php echo '<?php echo do_shortcode("[wpsvgallery_composser id='; echo "'".$post_id."']"; echo '"); ?>'; ?></textarea>
		<?php
		}
	}
	add_action( 'manage_wpsvgallery_posts_custom_column' , 'wpsvgallery_meta_clmn_display', 10, 2 );
	
	
	
	
	
	
	# Meta Box Dropdown Options
	function wpsvgallery_get_data_options() {
		$options = array (
			'Youtube' => 'ytVideo',
			'Vimeo' => 'vimeoVideo',
			'Daily Motion' => 'dailyMVideo',
		);
		
		return $options;
	}

	# Neta Box
	function display_all_gallery_inputs( $post, $args) {
		global $post;

		$wpsvgallery_repeatable_fields	= get_post_meta($post->ID, 'wpsvgallery_repeatable_fields', true);
		$options 						= wpsvgallery_get_data_options();
		wp_nonce_field( 'wpsvgallery_repeatable_meta_nonce', 'wpsvgallery_repeatable_meta_nonce' );
		?>

		<table id="repeatable-fieldset-one" width="100%">
			<thead>
				<tr>
					<th width="4%">Sort</th>
					<th width="40%">Video Title</th>
					<th width="10%">Video Type</th>
					<th width="40%">Video ID</th>
					<th width="6%">Delete</th>
				</tr>
			</thead>
			<tbody>
				<?php

				if ( $wpsvgallery_repeatable_fields ) :

				foreach ( $wpsvgallery_repeatable_fields as $field ) {
				?>
					<tr>
						<td><a class="sort">|||</a></td>
						<td><input type="text" class="widefat" name="name[]" value="<?php if($field['name'] != '') echo esc_attr( $field['name'] ); ?>" /></td>

						<td>
							<select name="select[]">
							<?php foreach ( $options as $label => $value ) : ?>
							<option value="<?php echo $value; ?>"<?php selected( $field['select'], $value ); ?>><?php echo $label; ?></option>
							<?php endforeach; ?>
							</select>
						</td>

						<td><input type="text" class="widefat" name="url[]" value="<?php if ($field['url'] != '') echo esc_attr( $field['url'] );?>" /></td>

						<td><a class="button remove-row" href="#">Remove</a></td>
					</tr>
				<?php
				}
				else :
				// show a blank one
				?>
				<tr>
					<td><a class="sort">|||</a></td>
					<td><input type="text" class="widefat" name="name[]" /></td>

					<td>
						<select name="select[]">
						<?php foreach ( $options as $label => $value ) : ?>
						<option value="<?php echo $value; ?>"><?php echo $label; ?></option>
						<?php endforeach; ?>
						</select>
					</td>

					<td><input type="text" class="widefat" name="url[]" value="" /></td>

					<td><a class="button remove-row" href="#">Remove</a></td>
				</tr>
				<?php endif; ?>
			
				<!-- empty hidden one for jQuery -->
				<tr class="empty-row screen-reader-text">
					<td><a class="sort">|||</a></td>
					<td><input type="text" class="widefat" name="name[]" /></td>

					<td>
						<select name="select[]">
						<?php foreach ( $options as $label => $value ) : ?>
						<option value="<?php echo $value; ?>"><?php echo $label; ?></option>
						<?php endforeach; ?>
						</select>
					</td>

					<td><input type="text" class="widefat" name="url[]" value="" /></td>

					<td><a class="button remove-row" href="#">Remove</a></td>
				</tr>
			</tbody>
		</table>

		<p><a id="add-row" class="button" href="#">Add another</a><input type="submit" class="metabox_submit" value="Save" /></p>
		<?php
	}


	function wpsvgallery_settings_func($post, $args){

		#Call get post meta.
		$wpsvgallery_columns   			= get_post_meta($post->ID, 'wpsvgallery_columns', true);
		$wpsvgallery_bk_color   		= get_post_meta($post->ID, 'wpsvgallery_bk_color', true);
		$wpsvgallery_text_size 			= get_post_meta($post->ID, 'wpsvgallery_text_size', true);
		$wpsvgallery_text_trans 		= get_post_meta($post->ID, 'wpsvgallery_text_trans', true);
		$wpsvgallery_text_style 		= get_post_meta($post->ID, 'wpsvgallery_text_style', true);
		$wpsvgallery_text_color 		= get_post_meta($post->ID, 'wpsvgallery_text_color', true);
		$wpsvgallery_overlay_color 		= get_post_meta($post->ID, 'wpsvgallery_overlay_color', true);
		$wpsvgallery_grayscale 			= get_post_meta($post->ID, 'wpsvgallery_grayscale', true);
		$wpsvgallery_area_height 		= get_post_meta($post->ID, 'wpsvgallery_area_height', true);
		$wpsvgallery_opc_color 			= get_post_meta($post->ID, 'wpsvgallery_opc_color', true);
		// title meta
		$wpsv_title_text_size 			= get_post_meta($post->ID, 'wpsv_title_text_size', true);		
		$wpsvg_title_text_trans 		= get_post_meta($post->ID, 'wpsvg_title_text_trans', true);		
		$wpsvg_title_text_style 		= get_post_meta($post->ID, 'wpsvg_title_text_style', true);		
		$wpsvg_title_alignment 			= get_post_meta($post->ID, 'wpsvg_title_alignment', true);		
		$wpsvg_title_text_color 		= get_post_meta($post->ID, 'wpsvg_title_text_color', true);		
		
		?>
		<div class="wrap">
			<table class="form-table"> 
				<tr valign="top">
					<th scope="row">
						<label for="wpsvgallery_columns"><?php _e('Video Column', 'wpsvgallery')?></label>
					</th>
					<td style="vertical-align: middle;">
						<select name="wpsvgallery_columns" id="wpsvgallery_columns" class="timezone_string">
							<option value="2" <?php if ( isset ( $wpsvgallery_columns ) ) selected( $wpsvgallery_columns, '2' ); ?>><?php _e('2 Column', 'wpsvgallery')?></option>
							<option value="3" <?php if ( isset ( $wpsvgallery_columns ) ) selected( $wpsvgallery_columns, '3' ); ?>><?php _e('3 Column', 'wpsvgallery')?></option>
							<option disabled value="4" <?php if ( isset ( $wpsvgallery_columns ) ) selected( $wpsvgallery_columns, '4' ); ?>><?php _e('4 Only Pro', 'wpsvgallery')?></option>
							<option disabled value="5" <?php if ( isset ( $wpsvgallery_columns ) ) selected( $wpsvgallery_columns, '5' ); ?>><?php _e('5 Only Pro', 'wpsvgallery')?></option>
							<option disabled value="6" <?php if ( isset ( $wpsvgallery_columns ) ) selected( $wpsvgallery_columns, '6' ); ?>><?php _e('6 Only Pro', 'wpsvgallery')?></option>
						</select>
					</td>
				</tr>
				<!-- End gallery columns -->

				<tr valign="top">
					<th scope="row">
						<label for="wpsvgallery_bk_color"><?php _e('Background Color', 'wpsvgallery')?></label>
					</th>
					<td style="vertical-align: middle;">
						<input name="wpsvgallery_bk_color" value="<?php if($wpsvgallery_bk_color !=''){echo $wpsvgallery_bk_color;} else{ echo "#DBEAF7";} ?>" class="jscolor" readonly>
					</td>
				</tr>
				<!-- End Gallery Background Color -->

				
				
				<tr valign="top">
					<th scope="row">
						<label for="wpsv_title_text_size"><?php _e('Title Font Size', 'wpsvgallery')?></label>
					</th>
					<td style="vertical-align: middle;">
						<select name="wpsv_title_text_size" id="wpsv_title_text_size">
							<?php for($i=12; $i<=72; $i++){?>
							<option value="<?php echo $i; ?>" <?php if ( isset ( $wpsv_title_text_size ) ) selected( $wpsv_title_text_size, $i ); ?>><?php echo $i."px";?></option>
							<?php } ?>
						</select>
					</td>
				</tr>
				<!-- End Title Font Size-->

				<tr valign="top">
					<th scope="row">
						<label for="wpsvg_title_text_trans"><?php _e('Title Text Transform', 'wpsvgallery')?></label>
					</th>
					<td style="vertical-align: middle;">
						<select name="wpsvg_title_text_trans" id="wpsvg_title_text_trans" class="timezone_string">
							<option value="none" <?php if ( isset ( $wpsvg_title_text_trans ) ) selected( $wpsvg_title_text_trans, 'none' ); ?>><?php _e('Default', 'wpsvgallery')?></option>
							<option value="lowercase" <?php if ( isset ( $wpsvg_title_text_trans ) ) selected( $wpsvg_title_text_trans, 'lowercase' ); ?>><?php _e('Lowercase', 'wpsvgallery')?></option>
							<option value="uppercase" <?php if ( isset ( $wpsvg_title_text_trans ) ) selected( $wpsvg_title_text_trans, 'uppercase' ); ?>><?php _e('Uppercase', 'wpsvgallery')?></option>
							<option value="capitalize" <?php if ( isset ( $wpsvg_title_text_trans ) ) selected( $wpsvg_title_text_trans, 'capitalize' ); ?>><?php _e('Capitalize', 'wpsvgallery')?></option>
						</select>
					</td>
				</tr>
				<!-- End Title Text Transform -->

				<tr valign="top">
					<th scope="row">
						<label for="wpsvg_title_text_style"><?php _e('Title Text Style', 'wpsvgallery')?></label>
					</th>
					<td style="vertical-align: middle;">
						<select name="wpsvg_title_text_style" id="wpsvg_title_text_style" class="timezone_string">
							<option value="normal" <?php if ( isset ( $wpsvg_title_text_style ) ) selected( $wpsvg_title_text_style, 'normal' ); ?>><?php _e('Normal', 'wpsvgallery')?></option>
							<option value="italic" <?php if ( isset ( $wpsvg_title_text_style ) ) selected( $wpsvg_title_text_style, 'italic' ); ?>><?php _e('Italic', 'wpsvgallery')?></option>
						</select>
					</td>
				</tr>
				<!-- End Title Text Style -->

				<tr valign="top">
					<th scope="row">
						<label for="wpsvg_title_alignment"><?php _e('Title Text Alignment', 'wpsvgallery')?></label>
					</th>
					<td style="vertical-align: middle;">
						<select name="wpsvg_title_alignment" id="wpsvg_title_alignment" class="timezone_string">
							<option value="left" <?php if ( isset ( $wpsvg_title_alignment ) ) selected( $wpsvg_title_alignment, 'left' ); ?>><?php _e('Left', 'wpsvgallery')?></option>
							<option value="center" <?php if ( isset ( $wpsvg_title_alignment ) ) selected( $wpsvg_title_alignment, 'center' ); ?>><?php _e('Center', 'wpsvgallery')?></option>
							<option value="right" <?php if ( isset ( $wpsvg_title_alignment ) ) selected( $wpsvg_title_alignment, 'right' ); ?>><?php _e('Right', 'wpsvgallery')?></option>
						</select>
					</td>
				</tr>
				<!-- End Title Text Alignment -->

				<tr valign="top">
					<th scope="row">
						<label for="wpsvg_title_text_color"><?php _e('Title Font Color', 'wpsvgallery')?></label>
					</th>
					<td style="vertical-align: middle;">
						<input name="wpsvg_title_text_color" value="<?php if($wpsvg_title_text_color !=''){echo $wpsvg_title_text_color;} else{ echo "#000000";} ?>" class="jscolor" readonly>
					</td>
				</tr>
				<!-- End Title Font Color -->

				<tr valign="top">
					<th scope="row">
						<label for="wpsvgallery_text_size"><?php _e('Caption Title Font Size', 'wpsvgallery')?></label>
					</th>
					<td style="vertical-align: middle;">
						<select name="wpsvgallery_text_size" id="wpsvgallery_text_size">
							<?php for($i=12; $i<=72; $i++){?>
							<option value="<?php echo $i; ?>" <?php if ( isset ( $wpsvgallery_text_size ) ) selected( $wpsvgallery_text_size, $i ); ?>><?php echo $i."px";?></option>
							<?php } ?>
						</select>
					</td>
				</tr>
				<!-- End Caption Title Font Size-->

				<tr valign="top">
					<th scope="row">
						<label for="wpsvgallery_text_trans"><?php _e('Caption Text Transform', 'wpsvgallery')?></label>
					</th>
					<td style="vertical-align: middle;">
						<select name="wpsvgallery_text_trans" id="wpsvgallery_text_trans" class="timezone_string">
							<option value="none" <?php if ( isset ( $wpsvgallery_text_trans ) ) selected( $wpsvgallery_text_trans, 'none' ); ?>><?php _e('Default', 'wpsvgallery')?></option>
							<option value="lowercase" <?php if ( isset ( $wpsvgallery_text_trans ) ) selected( $wpsvgallery_text_trans, 'lowercase' ); ?>><?php _e('Lowercase', 'wpsvgallery')?></option>
							<option value="uppercase" <?php if ( isset ( $wpsvgallery_text_trans ) ) selected( $wpsvgallery_text_trans, 'uppercase' ); ?>><?php _e('Uppercase', 'wpsvgallery')?></option>
							<option value="capitalize" <?php if ( isset ( $wpsvgallery_text_trans ) ) selected( $wpsvgallery_text_trans, 'capitalize' ); ?>><?php _e('Capitalize', 'wpsvgallery')?></option>
						</select>
					</td>
				</tr>
				<!-- End Caption Text Transform -->

				<tr valign="top">
					<th scope="row">
						<label for="wpsvgallery_text_style"><?php _e('Caption Text Style', 'wpsvgallery')?></label>
					</th>
					<td style="vertical-align: middle;">
						<select name="wpsvgallery_text_style" id="wpsvgallery_text_style" class="timezone_string">
							<option value="normal" <?php if ( isset ( $wpsvgallery_text_style ) ) selected( $wpsvgallery_text_style, 'normal' ); ?>><?php _e('Normal', 'wpsvgallery')?></option>
							<option value="italic" <?php if ( isset ( $wpsvgallery_text_style ) ) selected( $wpsvgallery_text_style, 'italic' ); ?>><?php _e('Italic', 'wpsvgallery')?></option>
						</select>
					</td>
				</tr>
				<!-- End Caption Text Style -->

				<tr valign="top">
					<th scope="row">
						<label for="wpsvgallery_text_color"><?php _e('Caption Font Color', 'wpsvgallery')?></label>
					</th>
					<td style="vertical-align: middle;">
						<input name="wpsvgallery_text_color" value="<?php if($wpsvgallery_text_color !=''){echo $wpsvgallery_text_color;} else{ echo "#ffffff";} ?>" class="jscolor" readonly>
					</td>
				</tr>
				<!-- End Caption Font Color -->

				<tr valign="top">
					<th scope="row">
						<label for="wpsvgallery_overlay_color"><?php _e('Overlay Background Color', 'wpsvgallery')?></label>
					</th>
					<td style="vertical-align: middle;">
						<input name="wpsvgallery_overlay_color" value="<?php if($wpsvgallery_overlay_color !=''){echo $wpsvgallery_overlay_color;} else{ echo "#3DC0F1";} ?>" class="jscolor" readonly>
					</td>
				</tr>
				<!-- End Caption Font Color -->
			
				<tr valign="top">
					<th scope="row">
						<label for="wpsvgallery_grayscale"><?php _e('Grayscale', 'wpsvgallery')?></label>
					</th>
					<td style="vertical-align: middle;">
						<select name="wpsvgallery_grayscale" id="wpsvgallery_grayscale">
							<?php for($i=0; $i<=100; $i++){?>
							<option value="<?php echo $i; ?>" <?php if ( isset ( $wpsvgallery_grayscale ) ) selected( $wpsvgallery_grayscale, $i ); ?>><?php echo $i."%";?></option>
							<?php } ?>
						</select>
					</td>
				</tr>
				<!-- End Grayscale -->
				
				<tr valign="top">
					<th scope="row">
						<label for="wpsvgallery_area_height"><?php _e('Height (px)', 'wpsvgallery')?></label>
					</th>
					<td style="vertical-align: middle;">
						<input type="number" name="wpsvgallery_area_height" id="wpsvgallery_area_height" size='7' maxlength="4" class="timezone_string" value="<?php echo $wpsvgallery_area_height; ?>" >
					</td>
				</tr>
				<!-- End Caption Font Color -->

				<tr valign="top">
					<th scope="row">
						<label for="wpsvgallery_opc_color"><?php _e('Image Opacity', 'wpsvgallery')?></label>
					</th>
					<td style="vertical-align: middle;">
						<select name="wpsvgallery_opc_color" id="wpsvgallery_opc_color" class="timezone_string">
							<option value="0.8" <?php if ( isset ( $wpsvgallery_opc_color ) ) selected( $wpsvgallery_opc_color, '0.8' ); ?>><?php _e('0.8', 'wpsvgallery')?></option>
							<option value="0.1" <?php if ( isset ( $wpsvgallery_opc_color ) ) selected( $wpsvgallery_opc_color, '0.1' ); ?>><?php _e('0.1', 'wpsvgallery')?></option>
							<option value="0.2" <?php if ( isset ( $wpsvgallery_opc_color ) ) selected( $wpsvgallery_opc_color, '0.2' ); ?>><?php _e('0.2', 'wpsvgallery')?></option>
							<option value="0.3" <?php if ( isset ( $wpsvgallery_opc_color ) ) selected( $wpsvgallery_opc_color, '0.3' ); ?>><?php _e('0.3', 'wpsvgallery')?></option>
							<option value="0.4" <?php if ( isset ( $wpsvgallery_opc_color ) ) selected( $wpsvgallery_opc_color, '0.4' ); ?>><?php _e('0.4', 'wpsvgallery')?></option>
							<option value="0.5" <?php if ( isset ( $wpsvgallery_opc_color ) ) selected( $wpsvgallery_opc_color, '0.5' ); ?>><?php _e('0.5', 'wpsvgallery')?></option>
							<option value="0.6" <?php if ( isset ( $wpsvgallery_opc_color ) ) selected( $wpsvgallery_opc_color, '0.6' ); ?>><?php _e('0.6', 'wpsvgallery')?></option>
							<option value="0.7" <?php if ( isset ( $wpsvgallery_opc_color ) ) selected( $wpsvgallery_opc_color, '0.7' ); ?>><?php _e('0.7', 'wpsvgallery')?></option>
							<option value="0.9" <?php if ( isset ( $wpsvgallery_opc_color ) ) selected( $wpsvgallery_opc_color, '0.9' ); ?>><?php _e('0.9', 'wpsvgallery')?></option>
							<option value="1"   <?php if ( isset ( $wpsvgallery_opc_color ) ) selected( $wpsvgallery_opc_color, '1' ); ?>><?php _e('1', 'wpsvgallery')?></option>		
						</select>				
					</td>
				</tr> 
				<!-- End Image Opacity -->	
				
				
			</table>
		</div>
		<?php	
	}
	
	function display_shortcode_gallery_inputs() {
		
		$post_id = get_the_ID();
	?>

	<div class="wrap">
		<table class="form-table">
			<tr valign="top">
				<td>
					<div class="rating-area">
						<p><?php _e('Rate Us', 'wpsvgallery');?></p>
						<p><?php _e('If you happy to use our plugin please shown us some love to give us a valuable feedback on <a target="_blank" href="https://wordpress.org/plugins/wp-responsive-video-gallery">WordPress Repository</a>', 'wpsvgallery');?></p>
						<p class="rating-icons">
							<span class="dashicons dashicons-star-filled"></span>
							<span class="dashicons dashicons-star-filled"></span>
							<span class="dashicons dashicons-star-filled"></span>
							<span class="dashicons dashicons-star-filled"></span>
							<span class="dashicons dashicons-star-filled"></span>
						</p>
					</div>
				</td>
			</tr>
			<tr valign="top">
				<td>
					<p><?php _e('Use following shortcode to display the Video Gallery anywhere:', 'wpsvgallery');?></p>
					<input style="background:#65CCEF;width:100%" type="text" onClick="this.select();" value="[wpsvgallery_composser <?php echo 'id=&quot;'.$post_id.'&quot;';?>]" />
				</td>			
			</tr>
			<tr valign="top">
			<td>
			<p><?php _e('If you need to put the shortcode in theme file use this:', 'wpsvgallery');?></p> 
			<textarea cols="40" rows="2" style="background:#65CCEF;width:100%" onClick="this.select();" ><?php echo '<?php echo do_shortcode("[wpsvgallery_composser id='; echo "'".$post_id."']"; echo '"); ?>'; ?></textarea>			
			</td>
			</tr>
		</table>
	</div>	

	<?php
	}
	function wpsvgallery_repeatable_meta_box_save($post_id) {

		if ( ! isset( $_POST['wpsvgallery_repeatable_meta_nonce'] ) ||
		! wp_verify_nonce( $_POST['wpsvgallery_repeatable_meta_nonce'], 'wpsvgallery_repeatable_meta_nonce' ) )
			return;

		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
			return;

		if (!current_user_can('edit_post', $post_id))
			return;

		#Checks for input and sanitizes/saves if needed    
		if( isset($_POST['wpsvgallery_columns']) && ($_POST['wpsvgallery_columns'] != '') ) {
			update_post_meta( $post_id, 'wpsvgallery_columns', esc_html($_POST['wpsvgallery_columns']) );
		}

		#Checks for input and sanitizes/saves if needed    
		if( isset($_POST['wpsvgallery_bk_color']) && ($_POST['wpsvgallery_bk_color'] != '') ) {
			update_post_meta( $post_id, 'wpsvgallery_bk_color', esc_html($_POST['wpsvgallery_bk_color']) );
		}

		#Value check and saves if needed
		if( isset( $_POST[ 'wpsv_title_text_size' ] ) ) {
			update_post_meta( $post_id, 'wpsv_title_text_size', $_POST[ 'wpsv_title_text_size' ] );
		}

		#Value check and saves if needed
		if( isset( $_POST[ 'wpsvg_title_text_trans' ] ) ) {
			update_post_meta( $post_id, 'wpsvg_title_text_trans', $_POST[ 'wpsvg_title_text_trans' ] );
		}

		#Value check and saves if needed
		if( isset( $_POST[ 'wpsvg_title_text_style' ] ) ) {
			update_post_meta( $post_id, 'wpsvg_title_text_style', $_POST[ 'wpsvg_title_text_style' ] );
		}

		#Value check and saves if needed
		if( isset( $_POST[ 'wpsvg_title_alignment' ] ) ) {
			update_post_meta( $post_id, 'wpsvg_title_alignment', $_POST[ 'wpsvg_title_alignment' ] );
		}

		#Value check and saves if needed
		if( isset( $_POST[ 'wpsvg_title_text_color' ] ) ) {
			update_post_meta( $post_id, 'wpsvg_title_text_color', $_POST[ 'wpsvg_title_text_color' ] );
		}

		#Value check and saves if needed
		if( isset( $_POST[ 'wpsvgallery_text_trans' ] ) ) {
			update_post_meta( $post_id, 'wpsvgallery_text_trans', $_POST[ 'wpsvgallery_text_trans' ] );
		}

		#Value check and saves
		if( isset( $_POST[ 'wpsvgallery_text_size' ] ) ) {
			update_post_meta( $post_id, 'wpsvgallery_text_size', esc_html($_POST['wpsvgallery_text_size']) );
		}

		#Value check and saves
		if( isset( $_POST[ 'wpsvgallery_text_style' ] ) ) {
			update_post_meta( $post_id, 'wpsvgallery_text_style', esc_html($_POST['wpsvgallery_text_style']) );
		}

		#Value check and saves
		if( isset( $_POST[ 'wpsvgallery_text_color' ] ) ) {
			update_post_meta( $post_id, 'wpsvgallery_text_color', esc_html($_POST['wpsvgallery_text_color']) );
		}

		#Value check and saves
		if( isset( $_POST[ 'wpsvgallery_overlay_color' ] ) ) {
			update_post_meta( $post_id, 'wpsvgallery_overlay_color', esc_html($_POST['wpsvgallery_overlay_color']) );
		}

		#Value check and saves if needed
		if( isset( $_POST[ 'wpsvgallery_grayscale' ] ) ) {
			update_post_meta( $post_id, 'wpsvgallery_grayscale', $_POST[ 'wpsvgallery_grayscale' ] );
		}

		if( isset($_POST['wpsvgallery_area_height'])) {
			if( $_POST['wpsvgallery_area_height'] == '' || $_POST['wpsvgallery_area_height'] == 0 || $_POST['wpsvgallery_area_height'] == null || ( strlen($_POST['wpsvgallery_area_height']) > 3) ||  !is_numeric($_POST['wpsvgallery_area_height'])){
				update_post_meta( $post_id, 'wpsvgallery_area_height', 180 );	
			} else
			{
				update_post_meta( $post_id, 'wpsvgallery_area_height', esc_html($_POST['wpsvgallery_area_height']) );  			
			}
		}

		#Value check and saves
		if( isset( $_POST[ 'wpsvgallery_opc_color' ] ) ) {
			update_post_meta( $post_id, 'wpsvgallery_opc_color', esc_html($_POST['wpsvgallery_opc_color']) );
		}

		$old = get_post_meta($post_id, 'wpsvgallery_repeatable_fields', true);
		$new = array();
		$options = wpsvgallery_get_data_options();
		
		$names = $_POST['name'];
		$selects = $_POST['select'];
		$urls = $_POST['url'];
		
		$count = count( $names );
		
		for ( $i = 0; $i < $count; $i++ ) {
			if ( $names[$i] != '' ) :
				$new[$i]['name'] = stripslashes( strip_tags( $names[$i] ) );

				if ( in_array( $selects[$i], $options ) )
					$new[$i]['select'] = $selects[$i];
				else
					$new[$i]['select'] = '';

				if ( $urls[$i] == '' )
					$new[$i]['url'] = '';
				else
					$new[$i]['url'] = stripslashes( $urls[$i] ); // and however you want to sanitize
			endif;
		}
		if ( !empty( $new ) && $new != $old )
			update_post_meta( $post_id, 'wpsvgallery_repeatable_fields', $new );
		elseif ( empty($new) && $old )
			delete_post_meta( $post_id, 'wpsvgallery_repeatable_fields', $old );
	}

	add_action('save_post', 'wpsvgallery_repeatable_meta_box_save');