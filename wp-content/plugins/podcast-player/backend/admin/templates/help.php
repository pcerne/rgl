<?php
/**
 * Podcast player documentation page
 *
 * @package Podcast Player
 * @since 3.3.0
 */

/* foreach ( $this->doc_blocks as $docid => $doclabel ) {
	$docs = $this->get_docs();
	printf( '<div class="pp-docs-section-wrapper"><h3 class="pp-docs-title">%s</h3><div class="pp-docs-hide">', esc_html( $doclabel ) );
	foreach ( $docs as $doc ) {
		if ( $doc['s'] === $docid ) {
			echo '<p>';
			$this->mlink( $doc['l'], $doc['q'] );
			echo '</p>';
		}
	}
	echo '</div></div>';
} */

?>
<div class="pp-docs-section-wrapper">
	<h3 class="pp-docs-title">Why podcast player is not visible on the front-end?</h3>
	<div class="pp-docs-hide">If Podcast player is not visible on the front-end and just a blank space appear in place of the podcast player, most probably there is some JavaScript error on the webpage. Refer <a href="https://wordpress.org/support/article/using-your-browser-to-diagnose-javascript-errors/">this link</a> to diagnose JavaScript errors on your webpage.</div>
</div>
<div class="pp-docs-section-wrapper">
	<h3 class="pp-docs-title">Why podcast player download podcast images to my media folder?</h3>
	<div class="pp-docs-hide">Podcast Player download images to your WordPress media folder to serve smaller images and help make your site load faster. However, you can disable this feature by going to WordPress Dashboard > Podcast player. Uncheck <strong>Image Optimization</strong> checkbox in settings section.</div>
</div>
