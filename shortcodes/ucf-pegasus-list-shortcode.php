<?php
/**
 * Responsible for the `ucf-pegasus-list` shortcode
 **/
if ( ! class_exists( 'UCF_Pegasus_List_Shortcode' ) ) {
	class UCF_Pegasus_List_Shortcode {
		/**
		 * Registers the shortcode
		 * @author Jim Barnes
		 * @since 1.0.0
		 **/
		public static function register_shortcode() {
			add_shortcode( 'ucf-pegasus-list', array( 'UCF_Pegasus_List_Shortcode', 'callback' ) );
		}

		/**
		 * The `ucf-pegasus-list` callback
		 * @author Jim Barnes
		 * @since 1.0.0
		 * @param $args Array | The shortcode atts
		 * @return string | The pegasus list markup.
		 **/
		public static function callback( $atts, $content='' ) {
			$atts = shortcode_atts( UCF_Pegasus_List_Config::get_option_defaults(), $atts, 'sc_ucf_pegasus_list' );

			$layout = $atts['layout'];
			$feed_url = $atts['feed_url'];
			$limit = $atts['limit'];
			$offset = $atts['offset'];

			$args = apply_filters( 'ucf_pegasus_list_shortcode_atts_' . $layout, $atts );

			$url = $feed_url . "issue/active?_embed&offset={$offset}&limit={$limit}";

			$items = UCF_Pegasus_List_Feed::get_issues( $url );

			return UCF_Pegasus_List_Common::display_issues( $items, $layout, $args, $content );
		}
	}

	add_action( 'init', array( 'UCF_Pegasus_List_Shortcode', 'register_shortcode' ), 10, 0 );
}
