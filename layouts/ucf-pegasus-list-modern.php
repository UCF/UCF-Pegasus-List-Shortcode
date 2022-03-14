<?php
/**
 * Functions that define the Pegasus list "modern" layout
 */

if ( ! function_exists( 'ucf_pegasus_list_display_modern_before' ) ) {
	function ucf_pegasus_list_display_modern_before( $layout_before, $items, $args ) {
		ob_start();
	?>
		<div class="ucf-pegasus-list ucf-pegasus-list-modern">
			<?php if ( $args['title'] ) : ?>
			<h2 class="ucf-pegasus-list-title"><?php echo $args['title']; ?></h2>
			<?php endif; ?>
	<?php
		return ob_get_clean();
	}

	add_filter( 'ucf_pegasus_list_display_modern_before', 'ucf_pegasus_list_display_modern_before', 10, 3 );
}

if ( ! function_exists( 'ucf_pegasus_list_display_modern_content' ) ) {
	function ucf_pegasus_list_display_modern_content( $layout_content, $items, $args, $fallback_message='' ) {
		if ( $items && ! is_array( $items ) ) { $items = array( $items ); }

		ob_start();
?>

		<?php if ( $items ) : ?>

			<?php
			foreach ( $items as $item ) :
				$issue_title = $item->title->rendered;
				$cover_story = $item->_embedded->issue_cover_story[0];
				$cover_story_url = $cover_story->link;
				$cover_story_title = $cover_story->title->rendered;
				$cover_story_subtitle = $cover_story->story_subtitle;
				$cover_story_description = $cover_story->story_description;
				$cover_story_blurb = null;
				$thumbnail = $cover_story->story_thumbnail;

				if ( $cover_story_description ) {
					$cover_story_blurb = $cover_story_description;
				} else if ( $cover_story_subtitle ) {
					$cover_story_blurb = $cover_story_subtitle;
				}
			?>
			<div class="ucf-pegasus-issue media-background-container hover-parent p-3 mb-3" style="margin-left: -1rem; margin-right: -1rem;">
				<div class="media-background hover-child-show fade" style="background-color: rgba(204, 204, 204, .25);"></div>

				<div class="media">
					<?php if ( $thumbnail ) : ?>
					<div class="d-flex w-25 mr-3" style="max-width: 150px;">
						<img src="<?php echo $thumbnail->url; ?>" class="img-fluid" alt="" width="<?php echo $thumbnail->width; ?>" height="<?php echo $thumbnail->height; ?>">
					</div>
					<?php endif; ?>
					<div class="media-body">
						<div class="mb-2 pb-1">
							<span class="badge badge-primary">Pegasus Magazine Featured Story</span>
						</div>
						<a class="d-block stretched-link text-decoration-none h5 mb-2 pb-1" href="<?php echo $cover_story_url; ?>" style="color: inherit;">
							<?php echo wptexturize( $cover_story_title ); ?>
						</a>
						<?php if ( $cover_story_blurb ): ?>
						<div class="font-size-sm">
							<?php echo wptexturize( strip_tags( $cover_story_blurb, '<b><em><i><u><strong>' ) ); ?>
						</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
			<?php endforeach; ?>

		<?php elseif ( $fallback_message ) : ?>
		<div class="ucf-pegasus-issue-error">
			<?php echo $fallback_message; ?>
		</div>
		<?php endif; ?>

<?php
		return ob_get_clean();
	}

	add_filter( 'ucf_pegasus_list_display_modern_content', 'ucf_pegasus_list_display_modern_content', 10, 4 );
}

if ( ! function_exists( 'ucf_pegasus_list_display_modern_after' ) ) {
	function ucf_pegasus_list_display_modern_after( $layout_after, $items, $args ) {
		ob_start();
	?>
		</div>
	<?php
		return ob_get_clean();
	}

	add_filter( 'ucf_pegasus_list_display_modern_after', 'ucf_pegasus_list_display_modern_after', 10, 3 );
}
