<?php
/*
Plugin Name: Sizeable Content Tags
Description: Easily tag any content on your WordPress website for later use.
Author: Sizeable Interactive
Author URI: http://sizeablelabs.com
Version: 1.0
License: GPLv2 or later
*/

class Szbl_Content_Tags
{
	protected static $instance;
	
	const TAXONOMY_SLUG = 'szbl-content-tag';
	
	public static function init()
	{
		if ( !isset( self::$instance ) )
			self::$instance = new Szbl_Content_Tags();
		return self::$instance;
	}
	
	public function __call( $method, $args )
	{
		if ( strtolower( $method ) == 'getinstance' || strtolower( $method ) == 'get_instance' )
			return self::init();
	}
	
	public function __construct()
	{
		add_action( 'init', array( $this, 'register' ), 1999 );
	}
	
	public function get_labels()
	{
		$labels = array(
			'name' => __( 'Content Tags', 'taxonomy general name' ),
			'singular_name' => _x( 'Content Tag', 'taxonomy singular name' ),
			'search_items' =>  __( 'Search Content Tags' ),
			'all_items' => __( 'All Content Tags' ),
			'parent_item' => __( 'Parent Content Tag' ),
			'parent_item_colon' => __( 'Parent Content Tag:' ),
			'edit_item' => __( 'Edit Content Tag' ), 
			'update_item' => __( 'Update Content Tag' ),
			'add_new_item' => __( 'Add New Content Tag' ),
			'new_item_name' => __( 'New Content Tag Name' ),
			'menu_name' => __( 'Content Tags' )
		);
		return apply_filters( 'szbl_content_tags-setting_labels', $labels );
	}
	
	public function get_taxonomy_slug()
	{
		return self::TAXONOMY_SLUG;
	}
	
	public function register()
	{
		$post_types = array_diff( get_post_types(), array( 'attachment', 'nav_menu_item', 'revision' ) );
		$post_types = apply_filters( 'szbl_content_tags-setting-post_types', $post_types );
		$this->post_types = $post_types;
		
		$args = array(
			'labels' => $this->get_labels(),
			'public' => true,
			'show_ui' => true,
			'show_in_nav_menus' => false,
			'show_tagcloud' => false,
			'show_admin_column' => true,
			'hierarchical' => false,
			'query_var' => true,
			'rewrite' => array(
				'slug' => 'content-tags',
				'with_front' => false,
				'hierarchical' => false
			)
		);

		register_taxonomy(
			$this->get_taxonomy_slug(),
			$post_types, 
			apply_filters( 'szbl_content_tags-settings', $args )
		);
	}
	
}
Szbl_Content_Tags::init();