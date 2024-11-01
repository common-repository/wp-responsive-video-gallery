<?php

	if( !defined( 'ABSPATH' ) ){
	    exit;
	}

	function wpsvgallery_load_post_type() {

		# Set UI labels for Custom Post Type
		$labels = array(
			'name'                => _x( 'Wp Video Gallery', 'Post Type General Name' ),
			'singular_name'       => _x( 'Wp Video Gallery', 'Post Type Singular Name' ),
			'menu_name'           => __( 'Wp Video Gallery' ),
			'parent_item_colon'   => __( 'Parent Post Gallery' ),
			'all_items'           => __( 'All Video Gallery' ),
			'view_item'           => __( 'View Gallery' ),
			'add_new_item'        => __( 'Add New Gallery' ),
			'add_new'             => __( 'Add Video Gallery' ),
			'edit_item'           => __( 'Edit Gallery' ),
			'update_item'         => __( 'Update Gallery' ),
			'search_items'        => __( 'Search Gallery' ),
			'not_found'           => __( 'Not Found' ),
			'not_found_in_trash'  => __( 'Not found in Trash' )
		);

		# Set other options for Custom Post Type...
		$args = array(
			'labels'              => $labels,
			'label'               => __( 'video-gallery' ),
			'description'         => __( 'Video Gallery news and reviews' ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'supports'            => array( 'title' ),
			'menu_icon'		      => 'dashicons-format-video'
		);
		register_post_type( 'wpsvgallery', $args );
		
	}
	add_action( 'init', 'wpsvgallery_load_post_type', 0 );