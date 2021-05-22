<?php
/**
 * Podcast pod entry for episode entry list.
 *
 * This template can be overridden by copying it to yourtheme/podcast-player/episode/featured.php.
 *
 * HOWEVER, on occasion Podcast Player will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @package Podcast Player
 * @version 1.0.0
 * @since   1.0.0
 */

$item   = $this->items[0];
$srcset = isset( $item['fset'] ) ? $item['fset'] : '';
?>

<div class="ppjs__img-wrapper <?php echo ! $item['featured'] ? 'noimg' : ''; ?>">
	<img class="ppjs__img-btn" src="<?php echo esc_url( $item['featured'] ); ?>" srcset="<?php echo esc_attr( $srcset ); ?>" sizes="(max-width: 640px) 100vw, 300px" alt="<?php echo esc_attr( $item['title'] ); ?>">
</div>
