<div class="wrapper-content-block">
	<div class="wrapper-content-align">

		<div class="ilovewp-page-intro">
			<h1 class="title-page"><?php bloginfo('name'); ?></h1>
		</div><!-- .ilovewp-page-intro -->

		<div class="post-single">

			<?php if (current_user_can('edit_theme_options')) { ?>
			<p><strong><?php esc_html_e( 'Thank you for installing Podcast Theme', 'podcast' ); ?></strong></p>
			<p>You are now ready to start setting up your new website using our theme.
			<br>If you need help, please check out the <a href="https://www.ilovewp.com/documentation/podcast/">Podcast Documentation Page</a> first.
			<br><em><strong>This block of text is visible only to logged-in websites administrators.</strong></em></p>

			<h2>Theme Set Up Checklist</h2>
			<p>In short, here's what you need to do in order to have a website like <a href="http://demo.ilovewp.com/?theme=podcast" target="_blank">our demo</a>.</p>

			<ul>
				<li>Set Up Contact Details (in Dashboard > ILoveWP > Theme Options > General).</p></li>
				<?php if ( !$gallery_page_id ) { ?>
				<li>Set Up the Homepage Slideshow (in Dashboard > ILoveWP > Theme Options > Homepage).</p></li>
				<?php } else { ?>
				<li style="color: #339933;"><span class="fa fa-check"></span> Set Up the Homepage Slideshow (in Dashboard > ILoveWP > Theme Options > Homepage).</p></li>
				<?php } ?>
				<li>Set Up the desired Room Amenities (in Dashboard > ILoveWP > Theme Options > Rooms).</p></li>
				<li>Set Up the Homepage Widgets (on the Appearance > Widgets page).</p></li>
			</ul>

			<h4>Homepage Content Widgets</h4>
			<p>Podcast Theme uses standard and custom widgets to quickly create your homepage.
			<br>Please proceed to the Appearance > Widgets page and set up the recommended widgets.</p>

			<h4>Sample (Demo Content)</h4>
			<p>If you are starting with a blank WordPress website without any content in it, you can download and import the sample data used in our live demo.
			<br>You can do so using our One Click Demo Import feature or manually by importing the XML file from our <a href="https://www.ilovewp.com/support/">Member's Area</a>.</p>
			<?php } else { ?>
			<p>Thank you for visiting our website, which currently is a work in progress.</p>
			<p>Please check back later.</p>
			<?php } ?>

		</div><!-- .post-single -->

	</div><!-- .wrapper-content-align -->
</div><!-- .wrapper-content-block -->