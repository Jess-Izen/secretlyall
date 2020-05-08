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
//pull term variables for page - the term description is the post id for the theme CPT that stores all the data
$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); 
$term_slug = 'story_event:'.$term->slug;
$post_id = $term->description;
$description = get_field('event_description',$post_id);
$location_prep = get_field('event_location',$post_id);
$location = esc_html( $location_prep->name );
$partner_org = get_field('fundraisee_name', $post_id);
$partner_org_link = '<a href="'.get_field('fundraisee_url',$post_id).'" target="_blank">'.$partner_org.'</a>';
$main_photo = get_field('event_photo',$post_id);
$photo_gallery = get_field('event_gallery',$post_id);
$event_audio = get_field('event_audio',$post_id);

?>




<div id="content">

<div id="inner-content" class="wrap cf">

<main id="main" class="m-all t-2of3 d-5of7 cf" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">
	<section class="entry-content">
	<?php //generate posts table for story posts w/ taxonomy term matching archive page ?>
	
	<div id="theme-intro">
		<div id="theme-first_intro" class="col1_3">
				<h1 id="theme-title"><?php single_cat_title(); ?></h1>
				<h3 id="theme-location">Held at: <?php echo $location ?></h3>
				<h3 id="theme-partner">Partner Organization: <?php echo $partner_org_link ?></h3>
			</div>
		<div id="theme-second-intro" class="col2_3">
			<a class="sy-btn" id="theme-back-btn" href="/">Back To All</a>
			<h3 id="theme-description" ><?php echo $description ?></h3>
			</div>	
		<div id="theme-third-intro" class="col3_3">
			</div>
	</div>
	<?php ptp_the_posts_table(
											array(
												'term' => $term_slug,

												'columns' => 'tax:storyteller:Storyteller,
															 cf:theme_play_button:Listen,
															 cf:download,
															 cf:story_description:Description,
															 tax:story_tag:Tags, 
															 cf:tag_button_2:Add Tag,
															 cf:event_fundraisee:Fundraiser Org,
															 tax:story_location:Location,
															 date'
															,

												'priorities' => '1,
																3,
																2,
																4,
																5,
																6,
																7,
																8,
																9,
																10,
																11',

												'responsive_control' => 'column',

												'page_length' => 'bottom',




												
											)
										); ?>
	</section>

	<div style="display: none;" id="download-modal">
		<h2>Consider donating!</h2>
		<a id="donate-button" class="sy-btn" href="https://donorbox.org/y-all-like-secretly-y-all?hide_donation_meter=true" target="_blank">Donate</a>
		<a id="modal-download-btn" class="sy-btn" download>Download</a>
	</div>


</main>
	</div>
</div>

<?php get_footer(); ?>
<div id="story-player">
		<div id="player-content">
			<div id="audio-embed">
				<div id="sy-mediaelements" class="col4_5">	
					<?php echo do_shortcode('[audio src="/wp-content/uploads/2020/04/noisemp3_stimbox_liveinsantacruz.mp3"]')?>
				</div>
				<div id="audio-buttons" class="col1_5">	
					<div id=player-play-placeholder class="icon-btn col"></div>
					<a id="player-previous" class="icon-btn col1_3" title="Previous"></a>
					<a id="player-next" class="icon-btn col1_3" title="Next"></a>
					<a id="player-close" class="icon-btn col1_3" title="Close"></a>
					</div>
					
			</div>
				
			<div id="under-player-audio">
				<div class="col1_4">
					<h2 id="player-description"></h2>
				</div>
				<div class="col2_4 player-btn-wrapper" id="player-download-wrapper" data-fancybox data-src="#download-modal" href="javascript:;" title="Download">
					<div id="player-download-btn" class="icon-btn"></div>
					<h3 class="player-btn-label">Download</h3>
				</div>
				<div class="col3_4 player-btn-wrapper tag-btn" id="player-tag-button-wrapper" href="#0"  title="Add Tag">
					<div id="player-tag-btn" class="icon-btn"></div>
					<h3 class="player-btn-label">Add Tag</h3>
				</div>
				<div class="col4_4">
					<div id="player-tag-wrapper">
					<h2 id="player-tag-label">Tags:</h2>
					<div id="player-tags" ></div>
				</div>
			</div>
		</div>
	</div>
