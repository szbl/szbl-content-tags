<?php
/*
Plugin Name: Content Tags
Description: Easily tag any content on your WordPress website for later use.
Author: Sizeable Interactive
Author URI: http://sizeableinteractive.com/labs/
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
		// priorty AFTER 1983 so we're grabbing ALL post types.
		add_action( 'init', array( $this, 'register' ), 9999 );
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
		return apply_filters( 'szbl_content_tags-setting-labels', $labels );
	}
	
	public function get_taxonomy_slug()
	{
		return apply_filters( 'szbl_content_tags_slug', self::TAXONOMY_SLUG );
	}
	
	public function register()
	{
		$post_types = array_diff( get_post_types(), array( 'attachment', 'nav_menu_item', 'revision' ) );
		$post_types = apply_filters( 'szbl_content_tags-setting-post_types', $post_types );
		$this->post_types = $post_types;
		
		register_taxonomy( $this->get_taxonomy_slug(), $post_types, array(
			'labels' => $this->get_labels(),
			'public' => apply_filters( 'szbl_content_tags-setting-public', true ),
			'show_ui' => apply_filters( 'szbl_content_tags-setting-hierarchical', true ),
			'show_in_nav_menus' => apply_filters( 'szbl_content_tags-setting-show_in_nav_menus', false ),
			'show_tagcloud' => apply_filters( 'szbl_content_tags-setting-show_tagcloud', false ),
			'show_admin_column' => apply_filters( 'szbl_content_tags-setting-show_admin_column', true ),
			'hierarchical' => apply_filters( 'szbl_content_tags-setting-hierarchical', false ),
			'query_var' => apply_filters( 'szbl_content_tags-setting-query_var', true ),
			'rewrite' => apply_filters( 'szbl_content_tags-setting-rewrite', array( 'slug' => 'content-tags', 'with_front' => false, 'hierarchical' => true ) ),
			'capabilities' => apply_filters( 'szbl_content_tags-setting-capabilities', array() ),
			'sort' => apply_filters( 'szbl_content_tags-setting-sort', null ),
		));
	}
	
}
Szbl_Content_Tags::init();