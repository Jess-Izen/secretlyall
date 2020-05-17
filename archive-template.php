<?php
/*
 Template Name: Archive View Template
 *
 * This is your custom page template. You can create as many of these as you need.
 * Simply name is "page-whatever.php" and in add the "Template Name" title at the
 * top, the same way it is here.
 *
 * When you create your page, you can just select the template and viola, you have
 * a custom page template to call your very own. Your mother would be so proud.
 *
 * For more info: http://codex.wordpress.org/Page_Templates
*/

$intro_title = get_field('intro_title','option');
$intro_text = get_field('intro_text','option');
$about_title = get_field('about_title','option');
$about_text = get_field('about_text', 'option');
?>
	<div id="archive-wrapper">
			<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="wrap cf">

						<main id="main" class="m-all t-2of3 d-5of7 cf" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">

							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
								<article id="post-<?php the_ID(); ?>" <?php post_class( 'cf' ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

								<section  class="entry-content story-page-content cf">
									<div id="story-content">
									<div id="intro-wrapper-desktop">
										<? 
										echo '<h3 class="intro-title">'.$intro_title.'</h3>';
										echo '<p class="intro-text">'.$intro_text.'</p>';
										?>
										<div class="intro-text-below">
											<div class="intro-text-below-text col1_2"><p>This project has been made possible with the generous support of Virginia Humanities.</p></div>
											<div class="intro-text-below-logo-wrapper col2_2"><div class="intro-text-below-logo"></div></div>
										</div>
										

									</div>
									<?php
										the_content();
										ptp_the_posts_table(
											array(
												'columns' =>'tax:storyteller:Storyteller,
															 tax:story_event:Theme,
															 cf:listen,
															 cf:download,
															 cf:theme_button:View Event,
															 cf:tag_button:Add Tag,
															 cf:story_description:Description,
															 tax:story_tag:Tags, 
															 cf:event_fundraisee:Fundraiser Org,
															 tax:story_location:Location,
															 cf:tag_button_2:Add Tag,
															 date
															 ',

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
																11,
																12,
																',

											

												'filters' => 'tax:story_event',
											
												'responsive_control' => 'column',

												'page_length' => 'bottom',
											)
										);
									?>
									<div id="intro-wrapper-mobile">
										<? 
										echo '<p class="intro-text">'.$intro_text.'</p>'; 
										?>
										<div class="intro-text-below">
											<div class="intro-text-below-text"><p>This project has been made possible with the generous support of Virginia Humanities.</p></div>
											<div class="intro-text-below-logo-wrapper"><div class="intro-text-below-logo"></div></div>
										</div>

									</div>

									</div>
									</div>
								</section>
											

								
								<div style="display: none;" id="download-modal">
									<h3>Consider donating!</h3>
									<div id="download-button-wrapper">
										<a id="donate-button" class="sy-btn" href="https://donorbox.org/y-all-like-secretly-y-all?hide_donation_meter=true" target="_blank">Donate</a>
										<a id="modal-download-btn" class="sy-btn" download>Download</a>
									</div>
								</div>

															
								<div style="display: none;" id="about-modal">
									<div id="about-wrapper-main">	
										<? 
										echo '<h2 id="about-title">'.$about_title.'</h2>';
										echo '<p id="about-text">'.$about_text.'</p>';
										?>
										<div id="contact-button-wrapper">
											<h3>Have a question or concern?</h3>
											<a id="contact-button" class="sy-btn" target="_blank">Contact Us</a>
										</div>
									</div>
								</div>


								<footer class="article-footer">
                 			 <?php the_tags( '<p class="tags"><span class="tags-title">' . __( 'Tags:', 'bonestheme' ) . '</span> ', ', ', '</p>' ); ?>

								</footer>

								<?php comments_template(); ?>

							</article>

							<?php endwhile; else : ?>

									<article id="post-not-found" class="hentry cf">
											<header class="article-header">
												<h1><?php _e( 'Oops, Post Not Found!', 'bonestheme' ); ?></h1>
										</header>
											<section class="entry-content">
												<p><?php _e( 'Uh Oh. Something is missing. Try double checking things.', 'bonestheme' ); ?></p>
										</section>
										<footer class="article-footer">
												<p><?php _e( 'This is the error message in the page-custom.php template.', 'bonestheme' ); ?></p>
										</footer>
									</article>

							<?php endif; ?>

						</main>
						

	
				</div>



							</div>		

<?php get_footer(); ?>
</div>
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
				<div class="col1_5">
					<h2 id="player-description"></h2>
				</div>
				<a class="col2_5 player-btn-wrapper" id="player-download-wrapper" data-fancybox data-src="#download-modal" href="javascript:;" title="Download">	
					<div id="player-download-btn" class="icon-btn" ></div>
					<h3 class="player-btn-label">Download</h3>
				</a>
				<a class="col3_5 player-btn-wrapper" id="player-theme-wrapper"  title="View Event">
					<div id="player-theme-btn" class="icon-btn theme-btn"></div>
					<h3 class="player-btn-label">View Event</h3>
							</a>
				<a class="col4_5 player-btn-wrapper tag-btn" id="player-tag-button-wrapper" href="#0"  title="Add Tag">
					<div id="player-tag-btn" class="icon-btn"></div>
					<h3 class="player-btn-label">Add Tag</h3>
							</a>
				<div class="col5_5">
					<div id="player-tag-wrapper">
						<h2 id="player-tag-label">Tags:</h2>
					<div id="player-tags" ></div>
				</div>
			</div>
		</div>
	</div>
