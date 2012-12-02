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
	
	public static function getInstance()
	{
		if ( !isset( self::$instance ) )
			self::$instance = new Szbl_Content_Tags();
		return self::$instance;
	}
	
	private function __construct()
	{
		add_action( 'init', array( $this, 'register_taxonomies' ), 9999 );
	}
	
	public function register_taxonomies()
	{
		$post_types = array_diff( get_post_types(), array( 'attachment', 'nav_menu_item', 'revision' ) );
		$post_types = apply_filters( 'szbl-content-tag-post-types', $post_types );
		$this->post_types = $post_types;
		register_taxonomy( 'szbl-content-tag', $post_types, array(
			'hierarchical' => false,
			'show_ui' => true,
			'public' => true,
			'query_var' => true,
			'labels' => array(
				'name' => _x( 'Content Tags', 'taxonomy general name' ),
				'singular_name' => _x( 'Content Tag', 'taxonomy singular name' ),
				'search_items' =>  __( 'Search Content Tags' ),
				'all_items' => __( 'All Content Tags' ),
				'parent_item' => __( 'Parent Content Tag' ),
				'parent_item_colon' => __( 'Parent Content Tag:' ),
				'edit_item' => __( 'Edit Content Tag' ), 
				'update_item' => __( 'Update Content Tag' ),
				'add_new_item' => __( 'Add New Content Tag' ),
				'new_item_name' => __( 'New Content Tag Name' ),
				'menu_name' => __( 'Content Tags' ),
			)
		));
		$this->filter_columns( $post_types );
	}
	
	public function filter_columns( $post_types )
	{
		foreach ( $post_types as $post_type )
		{
			add_filter( 'manage_edit-' . $post_type . '_columns', array( $this, 'manage_posts_columns' ), 1983 );
			if ( $post_type == 'post' || $post_type = 'page' )
				$post_type .= 's';
			add_filter( 'manage_' . $post_type . '_custom_column', array( $this, 'manage_posts_custom_column' ), 1983, 2 );
		}
	}
	
	public function manage_posts_columns( $columns ) 
	{
		return array_merge( $columns, array( 'szbl-content-tag' => __( 'Content Tags' ) ) );
	}
	
	public function manage_posts_custom_column( $column, $post_id )
	{
		switch ( $column )
		{
			case 'szbl-content-tag':
				$terms = get_the_terms( $post_id, 'szbl-content-tag' );
				if ( $terms && count( $terms ) > 0 ) 
				{
					$output = '';
					foreach ( $terms as $term )
					{
						$output .= '<a href="' . get_edit_term_link( $term->term_id, 'szbl-content-tag' ) . '">';
						$output .= esc_html( $term->name ) . '</a>, ';
					}
					echo rtrim( $output, ', ' );
				}
				break;
		}
	}
	
}

Szbl_Content_Tags::getInstance();