<?php
/*
 * STORY POST TYPE TEMPLATE
 *
 * This is the custom post type post template. If you edit the post type name, you've got
 * to change the name of this template to reflect that name change.
 *
 * For Example, if your custom post type is "register_post_type( 'bookmarks')",
 * then your single template should be single-bookmarks.php
 *
 * Be aware that you should rename 'custom_cat' and 'custom_tag' to the appropiate custom
 * category and taxonomy slugs, or this template will not finish to load properly.
 *
 * For more info: http://codex.wordpress.org/Post_Type_Templates
*/
?>

<?php get_header(); ?>


<div id="primary">
	<div id="content" role="main">

		<?php while ( have_posts() ) : the_post(); 
			echo '<div id="tag-form-wrapper">';
			//introductory info
			$post_id = get_the_ID();
			$storyteller = get_the_title();
			$related_event = implode(get_field('event_story', $post_id));
			$theme = get_the_title($related_event);
			echo ('
				 <h3 id="tag-form-title"> ' . $storyteller . ' - ' . $theme .'</h3>
				 <div id="tag-form">' . do_shortcode('[advanced_form form="form_5e9209b487b14" post="current"]') . '</div>
			</div>');
		?>		
		
		<?php endwhile; // end of the loop. ?>

	</div><!-- #content -->
</div><!-- #primary -->

<?php get_footer(); ?>
