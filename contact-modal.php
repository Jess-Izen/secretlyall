<?php
/*
 Template Name: Contact Modal Template

*/

$about_title = get_field('about_title','option');
$about_text = get_field('about_text', 'option');

?>	
<?php get_header(); ?>

	<div id="about-modal">
		
	<div id="contact-wrapper">
			<div id="contact-inner-wrapper">
				<h2 id="contact-title">Contact Us</h2>
				<? advanced_form( 'form_5ec315fc8b091', $args ); ?>
			</div>
	</div>
	</div>

	<?php get_footer(); ?>
