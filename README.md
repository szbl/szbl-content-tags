Sizeable Content Tags
=====================

A free, GPL general content tagging WordPress plugin by Sizeable Labs.

Why Content Tags
------------------

Content tags are a great, non-linear/non-hierarchical method of creating relationships between normally unrelated content within WordPress.

Once activated, Content Tags will be publicly available for all of your post types within WordPress except for `revision`, `attachment`, and `nav_menu`.

You can then tag content arbitrarily and use any standard WordPress query to 

Using Content Tags
------------------


Extending Content Tags
----------------------

You can extend Content Tags by hooking into multiple filters. 

### Filter Listing

*szbl_content_tags-setting-post_types*
An array of the post types (slugs) that should receive support for Content Tag. Default: all post types except for `revision`, `attachment` and `nav_menu`.

_Labels could also be filtered with `szbl_content_tags-settings`._

*szbl_content_tags-settings*
The `$args` array for the `register_taxonomy()` call during the WordPress `init` hook. Allows customization of the taxonomy properties, including privacy settings, UI settings, hierachies, etc.

Default:

```php
<?php
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
		'hierarchical' => true
	)
);
?>
```

*szbl_content_tags-setting_labels*
The labels array sent to the `register_taxonomy()`. Default:

```php
<?php
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
```

Code Samples
------------

### Pulling a page that has a specific set of content tags

Coming soon.

#### Why would I use this?

You may have an area in a theme location, sidebar or custom widget that you want show specific information.

### Pulling a custom post type that has specific tag(s)

Coming soon.

#### Why would I use this?

Pulling content (e.g. Content Blocks to populate feature/callout boxes on a home page of a theme) that is featured or specifically relevant to one page/section of a website.

### Applying Content Tags to very specific post types

Coming soon.

#### Why would I use this?
