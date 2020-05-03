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
?>
	<div id="archive-wrapper">
			<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="wrap cf">

						<main id="main" class="m-all t-2of3 d-5of7 cf" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">

							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
								<article id="post-<?php the_ID(); ?>" <?php post_class( 'cf' ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

								<section  class="entry-content cf id= itemprop="articleBody">
									<?php
										the_content();
										ptp_the_posts_table(
											array(
												'columns' =>'tax:storyteller:Storyteller,
															 tax:story_event:Theme,
															 cf:listen,
															 cf:download,
															 cf:tag_button:Add Tag,
															 tax:story_tag:Tags, 
															 cf:story_description:Description,
															 cf:event_fundraisee:Fundraiser Org,
															 tax:story_location:Location,
															 date',

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
										);
									?>

								</section>
											

								
								<div style="display: none;" id="download-modal">
									<h3>Consider donating!</h3>
									<a id="donate-button" class="sy-btn" href="https://donorbox.org/y-all-like-secretly-y-all?hide_donation_meter=true" target="_blank">Donate</a>
									<a id="modal-download-btn" class="sy-btn" download>Download</a>
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
				<div class="col1_4">
					<h2 id="player-description"></h2>
				</div>
				<div class="col2_4">	
					<div id="player-download-btn" class="icon-btn" data-fancybox data-src="#download-modal" href="javascript:;" title="Download"></div>
					<h3 class="player-btn-label">Download</h3>
				</div>
				<div class="col3_4">
					<div id="player-tag-btn" class="icon-btn tag-btn" title="Add Tag"></div>
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
