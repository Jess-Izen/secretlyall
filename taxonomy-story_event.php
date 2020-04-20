<?php
/*
 * EVENT TAXONOMY (STORY CPT) TEMPLATE
 *
 * This is the custom post type taxonomy template. If you edit the custom taxonomy name,
 * you've got to change the name of this template to reflect that name change.
 *
 * For Example, if your custom taxonomy is called "register_taxonomy('shoes')",
 * then your template name should be taxonomy-shoes.php
 *
 * For more info: http://codex.wordpress.org/Post_Type_Templates#Displaying_Custom_Taxonomies
*/
?>

<?php get_header(); 
//pull term variables for page
$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); 
$term_slug = $term->slug;
$description = get_term_field ('description', $term);



?>




<div id="content">

<div id="inner-content" class="wrap cf">

<main id="main" class="m-all t-2of3 d-5of7 cf" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">
	<section class="entry-content">
	<?php //generate posts table for story posts w/ taxonomy term matching archive page ?>
	
	<div id="theme-intro">
		<div id="theme-intro-text">
			<h1 class="theme-title"><?php single_cat_title(); ?></h1>
			<h3 class="theme-description"><?php echo $description ?></h3>
		</div>
		<a class="sy-btn" id="theme-back-btn" href="/">Back To All</a>
	</div>	
	<?php echo do_shortcode('[posts_table  columns="tax:storyteller:Storyteller,cf:listen,cf:story_description:Description,cf:download,tax:story_tag:Tags" term="story_event:'.$term_slug.'"]'); ?>
	</section>


	<?php //player tab, hidden until onclick event ?>
	<div id="story-player">
		<div id="audio-embed"></div>
		<div id="under-player-audio">
			<h2 id="player-description"></h2>
			<a id="player-download" class="player-btn">Download</a>
			<div id="player-close" class="player-btn">Close</div>
			<div id="player-tag-btn" class="player-btn">Add Tag</div>
		</div>
		</div>

</main>
	</div>
</div>

<?php get_footer(); ?>

