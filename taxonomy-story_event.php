<?php
/*
 EVENT TAXONOMY (STORY CPT) TEMPLATE
*/
?>

<?php get_header(); 
//pull term variables for page - the term description is the post id for the theme CPT that stores all the data
$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); 
$term_slug = 'story_event:'.$term->slug;
$post_id = $term->description;
$date = get_field('event_date',$post_id);
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
	<? if (get_field('event_gallery',$post_id)) echo '<div id="theme-wrapper">';
		else echo '<div id="theme-wrapper" class="no-image">' ?>

		<div class="col1_3 intro-column">
				<div id="theme-info-primary">	
					<div id="theme-info-primary-main">	
						<h2 id="theme-title"><?php single_cat_title(); ?></h2>
						<h3 id="theme-date"><?php echo $date ?></h3>
					</div>
					<div id="theme-info-primary-sub">
						<h3 id="theme-description" ><?php echo $description ?></h3>
						<div id="theme-info-secondary">
							<p id="theme-location">Location: <?php echo $location ?></p>
							<p> // </p>
							<p id="theme-partner">Fundraiser for: <?php echo $partner_org_link ?></p>
				</div>
					</div>
				</div>

		</div>

			<div class="col2_3 intro-column">
			<div id="theme-gallery-wrapper" data-fancybox data-src="#theme-gallery-modal">
				<div id="theme-gallery-main" style="background-image: url('<?php echo $photo_gallery[0]['url']; ?>')"></div>
			</div>
		</div>
		<div class="col3_3 intro-column">
				<div class="icon-btn-wrapper" id="home-btn-wrapper" title="Back to All">
					<a id="theme-back-btn" class="icon-btn-medium" href="<?php echo home_url(); ?>" ></a>
					<h3 class="icon-btn-label">Back to All</h3>
				</div>
				<div class="icon-btn-wrapper" id="download-full-btn-wrapper" href="#0" title="Download Full Event Audio">
					<a id="theme-download-btn" class="icon-btn-medium download-btn" data-fancybox data-src="#download-modal" href="#0" 
					data="<? echo $event_audio ?>"></a>
					<h3 class="icon-btn-label"> <div id="mobile-download-text">Download Event</div><div id="desktop-download-text">Download Full Event </div></h3>
				</div>
				<div class="icon-btn-wrapper" id="gallery-btn-wrapper" title="View Gallery" data-fancybox data-src="#theme-gallery-modal">
					<a id="theme-gallery-btn" class="icon-btn-medium" href="#0"></a>
					<h3 class="icon-btn-label">View Gallery</h3>
				</div>
			</div>
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
		<div id="download-button-wrapper">
			<a id="donate-button" class="sy-btn" href="https://donorbox.org/y-all-like-secretly-y-all?hide_donation_meter=true" target="_blank">Donate</a>
			<a id="modal-download-btn" class="sy-btn" download>Download</a>
		</div>
	</div>

	<div style="display: none;" id="about-modal">
		<div id="about-wrapper-main">	
			<h2 id="about-title">What is Secretly Y'all?</h2>
			<p id="about-text"> 
			Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras at sem auctor, tempus tortor at, sodales risus. Vestibulum a dolor lacus. Ut sit amet mollis orci. Nam purus nibh, dictum nec consequat at, pretium sed nunc. 
			<br><br>Phasellus consequat lacus bibendum urna consectetur, vitae volutpat lorem faucibus. Vivamus et pellentesque tellus. 
			</p>
			<div id="contact-button-wrapper">
				<h3>Have a question?</h3>
				<a id="contact-button" class="sy-btn" target="_blank">Contact Us</a>
			</div>
		</div>
	</div>


	<div style="display: none" id="theme-gallery-modal">
		<div id="theme-gallery-modal-desktop">
			<div id="galleryThumbs">
				<?php $i = 0;
				foreach($photo_gallery as $galleryThumb){
						$i++;
						if($i==1){
								$imgClass = 'active';   
						}else{
								$imgClass = '';   
						}
						echo '<img src="'.$galleryThumb['sizes']['thumbnail'].'" class="imageThumb imageNum'.$i.' '.$imgClass.'" picURL="'.$galleryThumb['sizes']['gallery-large'].'" />';
				} ?>    
			</div>
			<div id="largeGalleryImage">
			<img src="<?php echo $photo_gallery[0]['sizes']['gallery-large']; ?>" id="galleryImageLarge" href="<?php echo $photo_gallery[0]['url']?>"/>
			</div>
		</div>
		<div id="theme-gallery-modal-mobile">
				<?php	if( $photo_gallery ): ?>
				<ul>
					<?php foreach( $photo_gallery as $image ): ?>
						<li >
							<a class="mobile-gallery-image" href="<?php echo $image['url']; ?>" target="_blank" >
								<img src="<?php echo $image['sizes']['medium']; ?>" alt="<?php echo $image['alt']; ?>" />
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>
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
