<?php
/**
 * Responsible for the common output tasks
 **/
if ( ! class_exists( 'UCF_Pegasus_List_Common' ) ) {
	class UCF_Pegasus_List_Common {

		/**
		 * Responsible for displaying issues
		 * @author Jim Barnes
		 * @since 1.0.0
		 * @param $items Array | An array of pegasus issues
		 * @param $layout string | The layout to use to display the issues
		 * @param $args Array | An array of arguments for the layout
		 * @return string | The html output
		 **/
		public static function display_issues( $items, $layout='default', $args=array() ) {
			$before = '';
			if ( has_filter( 'ucf_pegasus_list_display_' . $layout . '_before' ) ) {
				$before = apply_filters( 'ucf_pegasus_list_display_' . $layout . '_before', $before, $items, $args );
			}

			$content = '';
			if ( has_filter( 'ucf_pegasus_list_display_' . $layout . '_content' ) ) {
				$content = apply_filters( 'ucf_pegasus_list_display_' . $layout . '_content', $content, $items, $args );
			}

			$after = '';
			if ( has_filter( 'ucf_pegasus_list_display_' . $layout . '_after' ) ) {
				$after = apply_filters( 'ucf_pegasus_list_display_' . $layout . '_after', $after, $items, $args );
			}

			return $before . $content . $after;
		}
	}
}

if ( ! function_exists( 'ucf_pegasus_list_display_default_before' ) ) {
	function ucf_pegasus_list_display_default_before( $before, $items, $args ) {
		$title = $args['title'] ? $args['title'] : 'UCF Pegasus Issues';
		ob_start();
	?>
		<div class="ucf-pegasus-list">
			<h2><?php echo $title; ?></h2>
	<?php
		return ob_get_clean();
	}

	add_filter( 'ucf_pegasus_list_display_default_before', 'ucf_pegasus_list_display_default_before', 10, 3 );
}

if ( ! function_exists( 'ucf_pegasus_list_display_default_content' ) ) {
	function ucf_pegasus_list_display_default_content( $content, $items, $args ) {
		ob_start();
		foreach( $items as $item ) :
			$issue_url   = $item->link;
			$issue_title = $item->title->rendered;
			$cover_story = $item->_embedded->issue_cover_story[0];
			$cover_story_url = $cover_story->link;
			$cover_story_title = $cover_story->title->rendered;
			$cover_story_subtitle = $cover_story->story_subtitle;
			$cover_story_description = $cover_story->story_description;
			$cover_story_blurb = null;
			$thumbnail_id = $item->featured_image;
			$thumbnail = null;
			$thumbnail_url = null;

			if ( $thumbnail_id !== 0 ) {
				$thumbnail = $item->_embedded->{"wp:featuredmedia"}[0];
				$thumbnail_url = $thumbnail->media_details->sizes->full->source_url;
			}

			if ( $cover_story_description ) {
				$cover_story_blurb = $cover_story_description;
			} else if ( $cover_story_subtitle ) {
				$cover_story_blurb = $cover_story_subtitle;
			}
	?>
		<div class="ucf-pegasus-issue">
		<?php if ( $thumbnail_url ) : ?>
			<a class="ucf-pegasus-issue-thumbnail-link" href="<?php echo $issue_url; ?>" target="_blank">
				<img class="ucf-pegasus-issue-thumbnail" src="<?php echo $thumbnail_url; ?>" alt="<?php echo $issue_title; ?>" title="<?php echo $issue_title; ?>">
			</a>
			<?php endif; ?>
			<div class="ucf-pegasus-issue-details">
				<a class="ucf-pegasus-issue-title" href="<?php echo $issue_url; ?>" target="_blank">
					<?php echo wptexturize( $issue_title ); ?>
				</a>

				<span class="ucf-pegasus-issue-featured-label">Featured Story</span>

				<a class="ucf-pegasus-issue-cover-title" href="<?php echo $cover_story_url; ?>">
					<?php echo wptexturize( $cover_story_title ); ?>
				</a>

				<?php if ( $cover_story_blurb ): ?>
				<div class="ucf-pegasus-issue-cover-description">
					<?php echo wptexturize( strip_tags( $cover_story_blurb, '<b><em><i><u><strong>' ) ); ?>
				</div>
				<?php endif; ?>

				<a class="ucf-pegasus-issue-read-link" href="<?php echo $issue_url; ?>" target="_blank">
					Read More
				</a>
			</div>
		</div>
	<?php
		endforeach;
		return ob_get_clean();
	}

	add_filter( 'ucf_pegasus_list_display_default_content', 'ucf_pegasus_list_display_default_content', 10, 3 );
}

if ( ! function_exists( 'ucf_pegasus_list_display_default_after' ) ) {
	function ucf_pegasus_list_display_default_after( $after, $items, $args ) {
		ob_start();
	?>
		</div>
	<?php
		return ob_get_clean();
	}

	add_filter( 'ucf_pegasus_list_display_default_after', 'ucf_pegasus_list_display_default_after', 10, 3 );
}
