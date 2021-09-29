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
		public static function display_issues( $items, $layout='default', $args=array(), $content='' ) {
			$layout_before = '';
			if ( has_filter( 'ucf_pegasus_list_display_' . $layout . '_before' ) ) {
				$layout_before = apply_filters( 'ucf_pegasus_list_display_' . $layout . '_before', $layout_before, $items, $args );
			}

			$layout_content = '';
			if ( has_filter( 'ucf_pegasus_list_display_' . $layout . '_content' ) ) {
				$layout_content = apply_filters( 'ucf_pegasus_list_display_' . $layout . '_content', $layout_content, $items, $args, $content );
			}

			$layout_after = '';
			if ( has_filter( 'ucf_pegasus_list_display_' . $layout . '_after' ) ) {
				$layout_after = apply_filters( 'ucf_pegasus_list_display_' . $layout . '_after', $layout_after, $items, $args );
			}

			return $layout_before . $layout_content . $layout_after;
		}
	}
}
