<?php
/* Bones Custom Post Type Example
This page walks you through creating 
a custom post type and taxonomies. You
can edit this one or copy the following code 
to create another one. 

I put this in a separate file so as to 
keep it organized. I find it easier to edit
and change things if they are concentrated
in their own file.

Developed by: Eddie Machado
URL: http://themble.com/bones/
*/

// Flush rewrite rules for custom post types
add_action( 'after_switch_theme', 'bones_flush_rewrite_rules' );

// Flush your rewrite rules
function bones_flush_rewrite_rules() {
	flush_rewrite_rules();
}

// let's create the function for the custom type
function custom_post_story() { 
	// creating (registering) the custom type 
	register_post_type( 'story', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
		// let's now add all the options for this post type
		array( 'labels' => array(
			'name' => __( 'Stories', 'bonestheme' ), /* This is the Title of the Group */
			'singular_name' => __( 'Story', 'bonestheme' ), /* This is the individual type */
			'all_items' => __( 'All Stories', 'bonestheme' ), /* the all items menu item */
			'add_new' => __( 'Add New', 'bonestheme' ), /* The add new menu item */
			'add_new_item' => __( 'Add New Story', 'bonestheme' ), /* Add New Display Title */
			'edit' => __( 'Edit', 'bonestheme' ), /* Edit Dialog */
			'edit_item' => __( 'Edit Stories', 'bonestheme' ), /* Edit Display Title */
			'new_item' => __( 'New Story', 'bonestheme' ), /* New Display Title */
			'view_item' => __( 'View Story', 'bonestheme' ), /* View Display Title */
			'search_items' => __( 'Search Stories', 'bonestheme' ), /* Search Custom Type Title */ 
			'not_found' =>  __( 'Nothing found in the Database.', 'bonestheme' ), /* This displays if there are no entries yet */ 
			'not_found_in_trash' => __( 'Nothing found in Trash', 'bonestheme' ), /* This displays if there is nothing in the trash */
			'parent_item_colon' => ''
			), /* end of arrays */
			'description' => __( 'Stories from Secertly Yall events', 'bonestheme' ), /* Custom Type Description */
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'query_var' => true,
			'menu_position' => 8, /* this is what order you want it to appear in on the left hand side menu */ 
			'menu_icon' => get_stylesheet_directory_uri() . '/library/images/custom-post-icon.png', /* the icon for the custom post type menu */
			'rewrite'	=> array( 'slug' => 'story', 'with_front' => false ), /* you can specify its url slug */
			'has_archive' => 'story', /* you can rename the slug here */
			'capability_type' => 'post',
			'hierarchical' => false,
			/* the next one is important, it tells what's enabled in the post editor */
			'supports' => array( 'title', 'custom-fields')
		) /* end of options */
	); /* end of register post type */
	
	
}

	// adding the function to the Wordpress init
	add_action( 'init', 'custom_post_story');
	
	/*
	for more information on taxonomies, go here:
	http://codex.wordpress.org/Function_Reference/register_taxonomy
	*/
	

	
	// now let's add custom tags (these act like categories)
	register_taxonomy( 'story_tag', 
		array('story'), /* if you change the name of register_post_type( 'custom_type', then you have to change this */
		array('hierarchical' => false,    /* if this is false, it acts like tags */
			'labels' => array(
				'name' => __( 'Story Tags', 'bonestheme' ), /* name of the custom taxonomy */
				'singular_name' => __( 'Story Tag', 'bonestheme' ), /* single taxonomy name */
				'search_items' =>  __( 'Search Story Tags', 'bonestheme' ), /* search title for taxomony */
				'all_items' => __( 'All Story Tags', 'bonestheme' ), /* all title for taxonomies */
				'parent_item' => __( 'Parent Story Tag', 'bonestheme' ), /* parent title for taxonomy */
				'parent_item_colon' => __( 'Parent Story Tag:', 'bonestheme' ), /* parent taxonomy title */
				'edit_item' => __( 'Edit Story Tag', 'bonestheme' ), /* edit custom taxonomy title */
				'update_item' => __( 'Update Story Tag', 'bonestheme' ), /* update title for taxonomy */
				'add_new_item' => __( 'Add New Story Tag', 'bonestheme' ), /* add new title for taxonomy */
				'new_item_name' => __( 'New Story Tag Name', 'bonestheme' ) /* name title for taxonomy */
			),
			'show_admin_column' => true,
			'show_ui' => true,
			'query_var' => true,
			'show_in_menu' => false,
		)
	);

		// now let's add custom events (these act like categories)
		register_taxonomy( 'story_event', 
		array('story'), /* if you change the name of register_post_type( 'custom_type', then you have to change this */
		array('hierarchical' => true,    /* if this is false, it acts like tags */
			'labels' => array(
				'name' => __( 'Themes', 'bonestheme' ), /* name of the custom taxonomy */
				'singular_name' => __( 'Theme', 'bonestheme' ), /* single taxonomy name */
				'search_items' =>  __( 'Search Themes', 'bonestheme' ), /* search title for taxomony */
				'all_items' => __( 'All Themes', 'bonestheme' ), /* all title for taxonomies */
				'parent_item' => __( 'Parent Theme', 'bonestheme' ), /* parent title for taxonomy */
				'parent_item_colon' => __( 'Parent Theme:', 'bonestheme' ), /* parent taxonomy title */
				'edit_item' => __( 'Edit Theme', 'bonestheme' ), /* edit custom taxonomy title */
				'update_item' => __( 'Update Theme', 'bonestheme' ), /* update title for taxonomy */
				'add_new_item' => __( 'Add New Theme', 'bonestheme' ), /* add new title for taxonomy */
				'new_item_name' => __( 'New Theme Name', 'bonestheme' ), /* name title for taxonomy */
				),
			'show_admin_column' => true,
			'show_ui' => true,
			'query_var' => true,
			'show_in_menu' => false,

		)
	);

			// now let's add custom tags (these act like categories)
			register_taxonomy( 'storyteller', 
			array('story'), /* if you change the name of register_post_type( 'custom_type', then you have to change this */
			array('hierarchical' => true,    /* if this is false, it acts like tags */
				'labels' => array(
					'name' => __( 'Storytellers', 'bonestheme' ), /* name of the custom taxonomy */
					'singular_name' => __( 'Storyteller', 'bonestheme' ), /* single taxonomy name */
					'search_items' =>  __( 'Search Storytellers', 'bonestheme' ), /* search title for taxomony */
					'all_items' => __( 'All Storytellers', 'bonestheme' ), /* all title for taxonomies */
					'parent_item' => __( 'Parent Storyteller', 'bonestheme' ), /* parent title for taxonomy */
					'parent_item_colon' => __( 'Parent Storyteller:', 'bonestheme' ), /* parent taxonomy title */
					'edit_item' => __( 'Edit Storyteller', 'bonestheme' ), /* edit custom taxonomy title */
					'update_item' => __( 'Update Storyteller', 'bonestheme' ), /* update title for taxonomy */
					'add_new_item' => __( 'Add New Storyteller', 'bonestheme' ), /* add new title for taxonomy */
					'new_item_name' => __( 'New Storyteller Name', 'bonestheme' ) /* name title for taxonomy */
				),
				'show_admin_column' => true,
				'show_ui' => true,
				'query_var' => true,
				'show_in_menu' => false,

			)
		);


					// now let's add custom tags (these act like categories)
					register_taxonomy( 'story_location', 
					array('story'), /* if you change the name of register_post_type( 'custom_type', then you have to change this */
					array('hierarchical' => true,    /* if this is false, it acts like tags */
						'labels' => array(
							'name' => __( 'Locations', 'bonestheme' ), /* name of the custom taxonomy */
							'singular_name' => __( 'Location', 'bonestheme' ), /* single taxonomy name */
							'search_items' =>  __( 'Search Locations', 'bonestheme' ), /* search title for taxomony */
							'all_items' => __( 'All Locations', 'bonestheme' ), /* all title for taxonomies */
							'parent_item' => __( 'Parent Location', 'bonestheme' ), /* parent title for taxonomy */
							'parent_item_colon' => __( 'Parent Location:', 'bonestheme' ), /* parent taxonomy title */
							'edit_item' => __( 'Edit Location', 'bonestheme' ), /* edit custom taxonomy title */
							'update_item' => __( 'Update Location', 'bonestheme' ), /* update title for taxonomy */
							'add_new_item' => __( 'Add New Location', 'bonestheme' ), /* add new title for taxonomy */
							'new_item_name' => __( 'New Storyteller Name', 'bonestheme' ) /* name title for taxonomy */
						),
						'show_admin_column' => true,
						'show_ui' => true,
						'query_var' => true,
						'show_in_menu' => false,

					)
				);

	// let's create the function for the custom type
function custom_post_sy_event() { 
	// creating (registering) the custom type 
	register_post_type( 'sy_event', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
		// let's now add all the options for this post type
		array( 'labels' => array(
			'name' => __( 'Themes', 'bonestheme' ), /* This is the Title of the Group */
			'singular_name' => __( 'Theme', 'bonestheme' ), /* This is the individual type */
			'all_items' => __( 'All Themes', 'bonestheme' ), /* the all items menu item */
			'add_new' => __( 'Add New', 'bonestheme' ), /* The add new menu item */
			'add_new_item' => __( 'Add New Theme', 'bonestheme' ), /* Add New Display Title */
			'edit' => __( 'Edit', 'bonestheme' ), /* Edit Dialog */
			'edit_item' => __( 'Edit Themes', 'bonestheme' ), /* Edit Display Title */
			'new_item' => __( 'New Theme', 'bonestheme' ), /* New Display Title */
			'view_item' => __( 'View Theme', 'bonestheme' ), /* View Display Title */
			'search_items' => __( 'Search Themes', 'bonestheme' ), /* Search Custom Type Title */ 
			'not_found' =>  __( 'Nothing found in the Database.', 'bonestheme' ), /* This displays if there are no entries yet */ 
			'not_found_in_trash' => __( 'Nothing found in Trash', 'bonestheme' ), /* This displays if there is nothing in the trash */
			'parent_item_colon' => ''
			), /* end of arrays */
			'description' => __( 'Secretly Yall Themes', 'bonestheme' ), /* Custom Type Description */
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'query_var' => true,
			'menu_position' => 8, /* this is what order you want it to appear in on the left hand side menu */ 
			'menu_icon' => get_stylesheet_directory_uri() . '/library/images/custom-post-icon.png', /* the icon for the custom post type menu */
			'rewrite'	=> array( 'slug' => 'theme', 'with_front' => false ), /* you can specify its url slug */
			'has_archive' => 'theme', /* you can rename the slug here */
			'capability_type' => 'post',
			'hierarchical' => false,
			/* the next one is important, it tells what's enabled in the post editor */
			'supports' => array( 'title', 'custom-fields')
		) /* end of options */
	); /* end of register post type */
	
	
}

	// adding the function to the Wordpress init
	add_action( 'init', 'custom_post_sy_event');

		// now let's add custom categories (these act like categories)
		register_taxonomy( 'sy_event_location', 
		array('sy_event'), /* if you change the name of register_post_type( 'custom_type', then you have to change this */
		array('hierarchical' => false,     /* if this is true, it acts like categories */
			'labels' => array(
				'name' => __( 'Locations', 'bonestheme' ), /* name of the custom taxonomy */
				'singular_name' => __( 'Location', 'bonestheme' ), /* single taxonomy name */
				'search_items' =>  __( 'Search Locations', 'bonestheme' ), /* search title for taxomony */
				'all_items' => __( 'All Locations', 'bonestheme' ), /* all title for taxonomies */
				'parent_item' => __( 'Parent Location', 'bonestheme' ), /* parent title for taxonomy */
				'parent_item_colon' => __( 'Parent Location:', 'bonestheme' ), /* parent taxonomy title */
				'edit_item' => __( 'Edit Location', 'bonestheme' ), /* edit custom taxonomy title */
				'update_item' => __( 'Update Location', 'bonestheme' ), /* update title for taxonomy */
				'add_new_item' => __( 'Add New Location', 'bonestheme' ), /* add new title for taxonomy */
				'new_item_name' => __( 'New Location Name', 'bonestheme' ) /* name title for taxonomy */
			),
			'show_admin_column' => true, 
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'sy-location' ),
			'show_in_menu' => false,
		)
	);

	//add custom taxonomy filters to backend posts lists
function filter_stories_by_taxonomies( $post_type, $which ) {

	// Apply this only on a specific post type
	if ( 'story' !== $post_type )
		return;

	// A list of taxonomy slugs to filter by
	$taxonomies = array( 'storyteller', 'story_event', 'story_location', 'story_tag' );

	foreach ( $taxonomies as $taxonomy_slug ) {

		// Retrieve taxonomy data
		$taxonomy_obj = get_taxonomy( $taxonomy_slug );
		$taxonomy_name = $taxonomy_obj->labels->name;

		// Retrieve taxonomy terms
		$terms = get_terms( $taxonomy_slug );

		// Display filter HTML
		echo "<select name='{$taxonomy_slug}' id='{$taxonomy_slug}' class='postform'>";
		echo '<option value="">' . sprintf( esc_html__( 'Show All %s', 'text_domain' ), $taxonomy_name ) . '</option>';
		foreach ( $terms as $term ) {
			printf(
				'<option value="%1$s" %2$s>%3$s (%4$s)</option>',
				$term->slug,
				( ( isset( $_GET[$taxonomy_slug] ) && ( $_GET[$taxonomy_slug] == $term->slug ) ) ? ' selected="selected"' : '' ),
				$term->name,
				$term->count
			);
		}
		echo '</select>';
	}

}
add_action( 'restrict_manage_posts', 'filter_stories_by_taxonomies' , 10, 2);

//Hide Metaboxes from CPT edit pages

function remove_custom_taxonomy() {
	remove_meta_box( 'storytellerdiv', 'story', 'side' );
	remove_meta_box( 'story_eventdiv', 'story', 'side' );
	remove_meta_box( 'story_locationdiv', 'story', 'side');
	remove_meta_box( 'tagsdiv-sy_event_location', 'sy_event', 'side' );
}
add_action( 'admin_menu', 'remove_custom_taxonomy' );
	
//Hide published on date from Story CPT
function hide_story_publish_date() {
    $screen = get_current_screen();
    if( in_array( $screen->id, array( 'story' ) ) ) {
        echo '<style>.misc-pub-section.curtime.misc-pub-curtime { display: none !important; }</style>';
    }
}

// Hook to admin_head for the CSS to be applied earlier
add_action( 'admin_head', 'hide_story_publish_date' );


?>
