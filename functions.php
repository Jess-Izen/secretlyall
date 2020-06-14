<?php
/*
Author: Jess Izen
URL: https://github.com/Jess-Izen/secretlyall

Incorporates Bones theme function.php, http://themble.com/bones/
*/

// LOAD BONES CORE (if you remove this, the theme will break)
require_once( 'library/bones.php' );

/*********************
LAUNCH BONES
*********************/

function bones_ahoy() {

  //Allow editor style.
  add_editor_style( get_stylesheet_directory_uri() . '/library/css/editor-style.css' );

  // let's get language support going, if you need it
  load_theme_textdomain( 'bonestheme', get_template_directory() . '/library/translation' );

  // USE THIS TEMPLATE TO CREATE CUSTOM POST TYPES EASILY
  require_once( 'library/custom-post-type.php' );




  // launching operation cleanup
  add_action( 'init', 'bones_head_cleanup' );
  // A better title
  add_filter( 'wp_title', 'rw_title', 10, 3 );
  // remove WP version from RSS
  add_filter( 'the_generator', 'bones_rss_version' );
  // remove pesky injected css for recent comments widget
  add_filter( 'wp_head', 'bones_remove_wp_widget_recent_comments_style', 1 );
  // clean up comment styles in the head
  add_action( 'wp_head', 'bones_remove_recent_comments_style', 1 );
  // clean up gallery output in wp
  add_filter( 'gallery_style', 'bones_gallery_style' );

  // enqueue base scripts and styles
  add_action( 'wp_enqueue_scripts', 'bones_scripts_and_styles', 999 );
  // ie conditional wrapper

  // launching this stuff after theme setup
  bones_theme_support();

  // adding sidebars to Wordpress (these are created in functions.php)
 add_action( 'widgets_init', 'bones_register_sidebars' );

  // cleaning up random code around images
  add_filter( 'the_content', 'bones_filter_ptags_on_images' );
  // cleaning up excerpt
  add_filter( 'excerpt_more', 'bones_excerpt_more' );

} /* end bones ahoy */

// let's get this party started
add_action( 'after_setup_theme', 'bones_ahoy' );


/************* OEMBED SIZE OPTIONS *************/

if ( ! isset( $content_width ) ) {
	$content_width = 680;
}

/************* THUMBNAIL SIZE OPTIONS *************/

// Thumbnail sizes
add_image_size( 'bones-thumb-600', 600, 150, true );
add_image_size( 'bones-thumb-300', 300, 100, true );

/*
to add more sizes, simply copy a line from above
and change the dimensions & name. As long as you
upload a "featured image" as large as the biggest
set width or height, all the other sizes will be
auto-cropped.

To call a different size, simply change the text
inside the thumbnail function.

For example, to call the 300 x 100 sized image,
we would use the function:
<?php the_post_thumbnail( 'bones-thumb-300' ); ?>
for the 600 x 150 image:
<?php the_post_thumbnail( 'bones-thumb-600' ); ?>

You can change the names and dimensions to whatever
you like. Enjoy!
*/

add_filter( 'image_size_names_choose', 'bones_custom_image_sizes' );

function bones_custom_image_sizes( $sizes ) {
    return array_merge( $sizes, array(
        'bones-thumb-600' => __('600px by 150px'),
        'bones-thumb-300' => __('300px by 100px'),
    ) );
}

/*
The function above adds the ability to use the dropdown menu to select
the new images sizes you have just created from within the media manager
when you add media to your content blocks. If you add more image sizes,
duplicate one of the lines in the array and name it according to your
new image size.
*/

/************* THEME CUSTOMIZE *********************/

/* 
  A good tutorial for creating your own Sections, Controls and Settings:
  http://code.tutsplus.com/series/a-guide-to-the-wordpress-theme-customizer--wp-33722
  
  Good articles on modifying the default options:
  http://natko.com/changing-default-wordpress-theme-customization-api-sections/
  http://code.tutsplus.com/tutorials/digging-into-the-theme-customizer-components--wp-27162
  
  To do:
  - Create a js for the postmessage transport method
  - Create some sanitize functions to sanitize inputs
  - Create some boilerplate Sections, Controls and Settings
*/

function bones_theme_customizer($wp_customize) {
  // $wp_customize calls go here.
  //
  // Uncomment the below lines to remove the default customize sections 

  // $wp_customize->remove_section('title_tagline');
  // $wp_customize->remove_section('colors');
  // $wp_customize->remove_section('background_image');
  // $wp_customize->remove_section('static_front_page');
  // $wp_customize->remove_section('nav');

  // Uncomment the below lines to remove the default controls
  // $wp_customize->remove_control('blogdescription');
  
  // Uncomment the following to change the default section titles
  // $wp_customize->get_section('colors')->title = __( 'Theme Colors' );
  // $wp_customize->get_section('background_image')->title = __( 'Images' );
}

add_action( 'customize_register', 'bones_theme_customizer' );

/************* ACTIVE SIDEBARS ********************/

// Sidebars & Widgetizes Areas
function bones_register_sidebars() {
	register_sidebar(array(
		'id' => 'sidebar1',
		'name' => __( 'Sidebar 1', 'bonestheme' ),
		'description' => __( 'The first (primary) sidebar.', 'bonestheme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	/*
	to add more sidebars or widgetized areas, just copy
	and edit the above sidebar code. In order to call
	your new sidebar just use the following code:

	Just change the name to whatever your new
	sidebar's id is, for example:

	register_sidebar(array(
		'id' => 'sidebar2',
		'name' => __( 'Sidebar 2', 'bonestheme' ),
		'description' => __( 'The second (secondary) sidebar.', 'bonestheme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	To call the sidebar in your template, you can just copy
	the sidebar.php file and rename it to your sidebar's name.
	So using the above example, it would be:
	sidebar-sidebar2.php

	*/
} // don't remove this bracket!



/*************ACF COMMANDS */

//Set up bidirectional relationship btwn Stories & Events

function bidirectional_acf_update_value( $value, $post_id, $field  ) {
	
	// vars
	$field_name = $field['name'];
	$field_key = $field['key'];
	$global_name = 'is_updating_' . $field_name;
	
	
	// bail early if this filter was triggered from the update_field() function called within the loop below
	// - this prevents an inifinte loop
	if( !empty($GLOBALS[ $global_name ]) ) return $value;
	
	
	// set global variable to avoid inifite loop
	// - could also remove_filter() then add_filter() again, but this is simpler
	$GLOBALS[ $global_name ] = 1;
	
	
	// loop over selected posts and add this $post_id
	if( is_array($value) ) {
	
		foreach( $value as $post_id2 ) {
			
			// load existing related posts
			$value2 = get_field($field_name, $post_id2, false);
			
			
			// allow for selected posts to not contain a value
			if( empty($value2) ) {
				
				$value2 = array();
				
			}
			
			
			// bail early if the current $post_id is already found in selected post's $value2
			if( in_array($post_id, $value2) ) continue;
			
			
			// append the current $post_id to the selected post's 'related_posts' value
      $value2[] = $post_id;
			
			
			// update the selected post's value (use field's key for performance)
      update_field($field_key, $value2, $post_id2);

       

			
		}
	
	}
	
	
	// find posts which have been removed
	$old_value = get_field($field_name, $post_id, false);
	
	if( is_array($old_value) ) {
		
		foreach( $old_value as $post_id2 ) {
			
			// bail early if this value has not been removed
			if( is_array($value) && in_array($post_id2, $value) ) continue;
			
			
			// load existing related posts
			$value2 = get_field($field_name, $post_id2, false);
			
			
			// bail early if no value
			if( empty($value2) ) continue;
			
			
			// find the position of $post_id within $value2 so we can remove it
			$pos = array_search($post_id, $value2);
			
			
			// remove
			unset( $value2[ $pos] );
			
			
			// update the un-selected post's value (use field's key for performance)
			update_field($field_key, $value2, $post_id2);
			
		}
		
	}
	
	
	// reset global varibale to allow this filter to function as per normal
	$GLOBALS[ $global_name ] = 0;
	
	
	// return
    return $value;
    
}

add_filter('acf/update_value/name=event_story', 'bidirectional_acf_update_value', 10, 3);

// END BIDIRECTIONAL



// Updating story fields when relationship set btwn stories/events, upon story update
add_action('acf/save_post', 'my_acf_save_post');
function my_acf_save_post( $post_id ) {
//make sure there is a relationship set before updating
  if ( 'sy_event' == get_post_type( $post_id ) ) {
    $theme_name = get_the_title($post_id);
    wp_insert_term($theme_name, 'story_event');
    $term = get_term_by('name', $theme_name, 'story_event');
    $new_term_id = $term->term_id;
    wp_update_term(
      $new_term_id,  //term id
      'story_event', // term tax
      array(
        'description' => $post_id,
      )
    );
    
    
  }
  if ( 'story' == get_post_type( $post_id ) ) {
  //update custom fields based on relationship
    $related_event = implode(get_field('event_story', $post_id));  
    $event_date = get_field('event_date', $related_event);
    $event_location = get_field('event_location', $related_event);
    $event_location_plain = esc_html( $event_location->name );
    $fundraisee_name = get_field('fundraisee_name', $related_event);
    $event_title = get_the_title($related_event);
    $fundraisee_url = get_field('fundraisee_url', $related_event);
    $event_fundraisee = '<a href="'.$fundraisee_url.'" target="_blank">'.$fundraisee_name.'</a>';
    $story_name = get_the_title($post_id);
    update_field('event_location', $event_location_plain);
    update_field('fundraisee_name', $fundraisee_name);
    update_field('fundraisee_url', $fundraisee_url);
    update_field('event_fundraisee', $event_fundraisee);
    update_field('event_date',$event_date);
    
    //attaching theme title as taxonomy to story
    $storyteller = get_the_title ($post_id);
    wp_set_object_terms( $post_id, $storyteller, 'storyteller' );
    wp_set_object_terms($post_id, $event_title, 'story_event');
    wp_set_object_terms($post_id,$event_location_plain,'story_location');
    $story_term = get_term_by('name', $event_title, 'story_event');    

    //attaching partner organization name as taxonomy to story
    $partner_org = get_field('fundraisee_name');
    wp_set_object_terms($post_id, $partner_org, 'story_org');


    //Prep listen and download buttons,send formatted post data to player on listen button click
    $audio_link = get_field("audio", $post_id);
    $post_url = get_permalink($post_id);
    $theme_page = get_term_link($story_term);
    $root_page = home_url();
    //need to convert tags into a string from the array in order to pass using the onclick function
    $story_tags_prep = wp_get_post_terms($post_id, 'story_tag', $args=array(
      'fields' => 'names' 
    ));
    $story_tags = implode ('; ',$story_tags_prep);
    $download_button_link =   $root_page."/#download-".$post_id;
    $play_button_link =  $root_page."/#listen-".$post_id;
    $theme_play_button_link = $theme_page."#listen-".$post_id;
    $download_button = '<a data="'.$audio_link.'" class="icon-btn-small download-btn" data-fancybox data-src="#download-modal" href="'.$download_button_link.'" onclick="" title="Download"></a>';
    $listen_button = '<a class="icon-btn-small listen-btn" href="'. $play_button_link.'" title="Listen" state="inactive" storyid="'.$post_id.'" onclick="QueueStoryPlayer('.$post_id.', \''.$audio_link.'\',\''.$story_name.'\',\''.$event_title.'\',\''.$post_url.'\', \''.$theme_page.'\',  \''.$story_tags.'\', \''.$download_button_link.'\');"></a>';
    $theme_listen_button = '<a class="icon-btn-small listen-btn" href="'. $theme_play_button_link.'" title="Listen" state="inactive" storyid="'.$post_id.'" onclick="QueueStoryPlayer('.$post_id.', \''.$audio_link.'\',\''.$story_name.'\',\''.$event_title.'\',\''.$post_url.'\', \''.$theme_page.'\',  \''.$story_tags.'\', \''.$download_button_link.'\');"></a>';
    $tag_button = '<a class="icon-btn-small table-tag-btn tag-btn" title="Add Tag" post_url="'.$post_url.'"></a>';
    $theme_button = '<a class="icon-btn-small table-theme-btn" title="Event Page" href="'.$theme_page.'"></a>';
    update_field('listen',$listen_button);
    update_field('download',$download_button);
    update_field('tag_button',$tag_button);
    update_field('tag_button_2',$tag_button);
    update_field('theme_play_button',$theme_listen_button);
    update_field('theme_button',$theme_button);
  }   

}

//update post date to be event's date, uses hidden date formatted field for proper formatting

add_action('acf/save_post', 'test_update_post_date_from_acf', 20);
function test_update_post_date_from_acf($post_id) {
  remove_filter('acf/save_post', 'test_update_post_date_from_acf', 20);
  if ( 'story' == get_post_type( $post_id ) || 'sy_event' == get_post_type($post_id) ) {
    $date_formatted = get_field('event_date', $post_id);
    update_field('date_formatted',$date_formatted, $post_id);
	// date format must be "Y-m-d H:i:s"
	$post_date = get_field('date_formatted');
	$post = wp_update_post(array(
		'ID' => $post_id,
    'post_date' => $post_date));
    
  }
  }



//hide fields that are used for posts tables pro / other backend stuff

function hide_acf_fields( $field ) {
return false;
}

add_filter( 'acf/prepare_field/key=field_5e209e86e8786', 'hide_acf_fields' ); //story - fundraisee link
add_filter( 'acf/prepare_field/key=field_5e262a4a186c4', 'hide_acf_fields' ); // story - audio
add_filter( 'acf/prepare_field/key=field_5e27868af7ba7', 'hide_acf_fields' ); // story - date formatted
add_filter( 'acf/prepare_field/key=field_5e8ce2342e7d7', 'hide_acf_fields' ); // story - listen
add_filter( 'acf/prepare_field/key=field_5eaf2f85c6187', 'hide_acf_fields' ); // story - listen 2
add_filter( 'acf/prepare_field/key=field_5e8cfaf86fab0', 'hide_acf_fields' ); // story - download
add_filter( 'acf/prepare_field/key=field_5ea61937faf17', 'hide_acf_fields' ); // story - new tag
add_filter( 'acf/prepare_field/key=field_5eaef4f9a7d7f', 'hide_acf_fields' ); // story - tag button
add_filter( 'acf/prepare_field/key=field_5eb48bbb7170b', 'hide_acf_fields' ); // story - theme button
add_filter( 'acf/prepare_field/key=field_5eb45bc9c3f6f', 'hide_acf_fields' ); // story - tag button 2
add_filter( 'acf/prepare_field/key=field_5e6e6fca8ad9f', 'hide_acf_fields' ); // event - date formatted



/***process tag form submissions***/

add_action( 'af/form/editing/post_updated/key=form_5e9209b487b14', 'tag_form_submit', 10, 3 );
function tag_form_submit($post, $form, $args){
//append to post tag, wipe field  
  $new_tag = get_field('story_new_tag', $post);
  $post_id = $post->ID;
  wp_set_post_terms($post_id, $new_tag, 'story_tag', $append=true);
  update_field('story_new_tag', '', $post_id);
}

//dequeue unnecessary scripts from form

function form_remove_enqueues() {
  // Stylized select (including user and post fields)
  wp_dequeue_script( 'select2' );
  wp_dequeue_style( 'select2' );

  // Date picker
  wp_dequeue_script( 'jquery-ui-datepicker' );
  wp_dequeue_style( 'acf-datepicker' );

  // Date and time picker
  wp_dequeue_script( 'acf-timepicker' );
  wp_dequeue_style( 'acf-timepicker' );

  // Color picker
  wp_dequeue_script( 'wp-color-picker' );
  wp_dequeue_style( 'wp-color-picker' );
}
add_action( 'af/form/enqueue/key=FORM_KEY', 'form_remove_enqueues' );


//prefill the tag form with hidden fields giving story&theme name&edit link, for use passing to zapier
add_filter( 'af/field/prefill_value/key=field_5ea6158f84a6c', 'prefill_form_story_name', 10, 4 );
add_filter( 'af/field/prefill_value/key=field_5ea6159f84a6d', 'prefill_form_theme_name', 10, 4 );
add_filter( 'af/field/prefill_value/key=field_5ea6205c0399c', 'prefill_form_story_link', 10, 4 );

function prefill_form_story_name( $value, $field, $form, $args ) {
  $story_name = get_the_title(); //get title of page form is embedded on (ie the story)
  return $story_name;
}

function prefill_form_theme_name( $value, $field, $form, $args ) {
  $post_id = get_the_id();
  $theme_id = implode(get_field('event_story', $post_id));  
  $theme_name = get_the_title($theme_id);
  return $theme_name;
}

function prefill_form_story_link( $value, $field, $form, $args ) {
  $post_link = get_edit_post_link();
  return $post_link;
}

//Add sy-btn class to Advanced Forms submit button
function filter_submit_button_attributes( $attributes, $form, $args ) {
  $attributes['class'] .= ' sy-btn';
  
  return $attributes;
}

add_filter( 'af/form/button_attributes', 'filter_submit_button_attributes', 10, 3 );

//Adds custom validation message for editorial guidelines checkbox on contact form
function validate_contact_form( $valid, $value, $field, $input_name ) {

  // Bail early if value is already invalid.
  if( $valid !== true ) {
      return __( 'Please acknowledge our editorial policies.' );;
  }

  return $valid;
}
add_filter('acf/validate_value/name=contact_rules', 'validate_contact_form', 10, 4);


//add options page
if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page(array(
		'page_title' 	=> 'Theme Settings',
		'menu_title'	=> 'Theme Settings',
		'menu_slug' 	=> 'theme-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));	
}

/*************END ACF COMMANDS********* */


// Load Fancybox
function install_fancybox() {
  echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>';
}
add_action('wp_footer', 'install_fancybox');

// Load FontAwesome
function install_fontawesome() {
  echo '<script src="https://kit.fontawesome.com/1f1a7af222.js" crossorigin="anonymous"></script>';
}
add_action('wp_head','install_fontawesome');

//Hide Unneeded backend menus/fields
function remove_menus () {
  global $menu;
  $user = wp_get_current_user();
  //restricts secretlyall account, or anybody that isn't an admin
  if ($user->user_login == 'secretlyall' )  {
          $restricted = array( __('Posts'),  __('Links'),  __('Appearance'), __('Tools'), __('Settings'), __('Comments'), __('Plugins'), __('Forms'), __('Dashboard'), __('Pages')  );
          end ($menu);
          while (prev($menu)){
              $value = explode(' ',$menu[key($menu)][0]);
              if(in_array($value[0] != NULL?$value[0]:"" , $restricted)){unset($menu[key($menu)]);}
          }
          remove_menu_page( 'edit.php?post_type=acf-field-group' );   
          

          // Remove fields from user profile page
            if ( ! function_exists( 'cor_remove_personal_options' ) ) {
	          function cor_remove_personal_options( $subject ) {
              $subject = preg_replace('#<h2>'.__("Personal Options").'</h2>#s', '', $subject, 1); // Remove the "Personal Options" title
              $subject = preg_replace('#<tr class="user-rich-editing-wrap(.*?)</tr>#s', '', $subject, 1); // Remove the "Visual Editor" field
              $subject = preg_replace('#<tr class="user-syntax-highlighting-wrap(.*?)</tr>#s', '', $subject, 1); // Remove the "Visual Editor" field
              $subject = preg_replace('#<tr class="user-comment-shortcuts-wrap(.*?)</tr>#s', '', $subject, 1); // Remove the "Keyboard Shortcuts" field
              $subject = preg_replace('#<tr class="show-admin-bar(.*?)</tr>#s', '', $subject, 1); // Remove the "Toolbar" field
              $subject = preg_replace('#<h2>'.__("Name").'</h2>#s', '', $subject, 1); // Remove the "Name" title
              $subject = preg_replace('#<tr class="user-display-name-wrap(.*?)</tr>#s', '', $subject, 1); // Remove the "Display name publicly as" field
              $subject = preg_replace('#<h2>'.__("Contact Info").'</h2>#s', '', $subject, 1); // Remove the "Contact Info" title
              $subject = preg_replace('#<tr class="user-url-wrap(.*?)</tr>#s', '', $subject, 1); // Remove the "Website" field
              $subject = preg_replace('#<h2>'.__("About Yourself").'</h2>#s', '', $subject, 1); // Remove the "About Yourself" title
              $subject = preg_replace('#<tr class="user-description-wrap(.*?)</tr>#s', '', $subject, 1); // Remove the "Biographical Info" field
              $subject = preg_replace('#<tr class="user-profile-picture(.*?)</tr>#s', '', $subject, 1); // Remove the "Profile Picture" field
              return $subject;
        	}

      	function cor_profile_subject_start() {
		      if ( current_user_can('manage_options') ) {
		      	ob_start( 'cor_remove_personal_options' );
	        	}
	        }

	      function cor_profile_subject_end() {
		      if ( current_user_can('manage_options') ) {
			      ob_end_flush();
                  }
                }
              }
        add_action( 'admin_head', 'cor_profile_subject_start' );
        add_action( 'admin_footer', 'cor_profile_subject_end' );
        remove_action( 'admin_color_scheme_picker', 'admin_color_scheme_picker' );
                    
        }
    }
  add_action('admin_menu', 'remove_menus');

//Redirect to stories page on login
function loginRedirect( $redirect_to, $request, $user ){
  if( is_array( $user->roles ) ) { // check if user has a role
      return "/wp-admin/edit.php?post_type=story";
  }
}
add_filter("login_redirect", "loginRedirect", 10, 3); 


/******POSTS TABLE PRO*************/

//override 'show x entries' text
add_filter( 'posts_table_language_defaults', function( $defaults ) { 
  $defaults['lengthMenu'] = 'Show _MENU_'; 
  return $defaults; 
} );

/*****Custom Image Sizes, for Theme Page Gallery */
if ( function_exists( 'add_image_size' ) ) { 
  add_image_size( 'gallery-large', 750, 750, false ); //(scaled)

}


/* DON'T DELETE THIS CLOSING TAG */ ?>
