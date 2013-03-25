Sizeable Content Tags
=====================

A free, GPL general content tagging WordPress plugin by Sizeable Labs.

Why Content Tags
------------------

Content tags are a great, non-linear/non-hierarchical method of creating relationships between normally unrelated content within WordPress.

Once activated, Content Tags will be publicly available for all of your post types within WordPress except for `revision`, `attachment`, and `nav_menu`.

You can then tag content arbitrarily and use any standard WordPress query to find content with one or more Content Tag combinations, 
e.g. `featured` and `portfolio`, or perhaps anything tagged `new york`, `urban` and `pizza`. 

Using Content Tags
------------------

Use Content Tags as you would post tags or categories within WordPress. By default the admin UI is turned on so you can quickly tag any post type (core or custom).

There are some code examples below, discussing usage and how to properly extend the plugin (if required).

Extending Content Tags
----------------------

You can extend Content Tags by hooking into multiple filters. The primary filters are listed below. It is recommended you use a plugin that hooks into Content Tags to customize it as needed so that you can easily update the plugin at your convenience.

### Filter Listing

**szbl_content_tags-setting-post_types**  
An array of the post types (slugs) that should receive support for Content Tag. Default: all post types except for `revision`, `attachment` and `nav_menu`.

_Labels could also be filtered with `szbl_content_tags-settings`._

**szbl_content_tags-settings**  
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

**szbl_content_tags-setting_labels**  
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
?>
```

Code Samples
------------

### Pulling a page that has a specific Content Tag

```php
<?php
	/*
		We're going to pull these by menu_order so users can
		use a plugin like Simple Page Ordering to give priority
		to which single page is returned.

		(http://wordpress.org/extend/plugins/simple-page-ordering/)
	*/
	$pages = get_posts(array(
		'post_type' => 'page',
		'orderby' => 'menu_order',
		'order' => 'asc',	
		'szbl-content-tag' => 'some-content-tag-slug'
		'posts_per_page' => 1
	));
	
	if ( count( $pages ) == 1 )
		$page = $pages[0];

	if ( isset( $page ) && $page->ID )
		do_something_awesome();
?>
```

#### Why would I use this?

You may have an area in a theme location, sidebar or custom widget that you want show specific information. We've used this in the past to display related pages (or posts, or custom post types).

It is most valuable when you need to show related content that crosses post types (you're reading a static content page and want to show related portfolio entries from a custom post type).

### Pulling a custom post type that has multiple Content Tags

Here we'll use Content Blocks as an example (post type slug is `szbl-content-block`):

```php
<?php
	/*
		Here we get a bit more complex, using the powerful
		tax_query argument:
	*/
	$blocks = get_posts(array(
		'post_type' => 'szbl-content-block',
		'orderby' => 'menu_order',
		'order' => 'asc',	
		'tax_query' => array(
			array(
				'taxonomy' => 'szbl-content-tag',
				'field' => 'slug',
				'operator' => 'AND',
				'terms' => array( 'featured', 'home-page' )
			)
		)
	));
	
	if ( count( $blocks ) > 0 ) 
	{
		// do something awesome here.
	}
?>
```

**Note:** the usage of the `operator` parameter with a value of `AND` ensures we're only pulling Content Blocks tagged `featured` and `home-page`.

### Pulling a custom post type that has specific tag(s)

Coming soon.

#### Why would I use this?

Pulling content (e.g. Content Blocks to populate feature/callout boxes on a home page of a theme) that is featured or specifically relevant to one page/section of a website.

### Applying Content Tags to very specific post types

Coming soon.

#### Why would I use this?
