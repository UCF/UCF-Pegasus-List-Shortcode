<?php
/**
 * Handles fetching the pegasus issues list
 **/
if ( ! class_exists( 'UCF_Pegasus_List_Feed' ) ) {
	class UCF_Pegasus_List_Feed {
		/**
		 * Retrieves a list of pegasus issues
		 * @author Jim Barnes
		 * @since 1.0.0
		 * @param $args Array | An array of arguments
		 * @return Array | The array of pegasus issues
		 **/
		public static function get_issues( $feed_url ) {
			$items = false;
			$transient_name = self::get_transient_name( $feed_url );
			$cache = UCF_Pegasus_List_Config::get_option_or_default( 'cache_feed' );
			$expiration = UCF_Pegasus_List_Config::get_option_or_default( 'transient_expiration' );

			if ( $cache ) {
				$items = get_transient( $transient_name );
			}

			if ( $items === false || $cache === false ) {
				$response = wp_remote_get( $feed_url, array( 'timeout' => 15 ) );
				$response_code = wp_remote_retrieve_response_code( $response );

				if ( is_array( $response ) && is_int( $response_code ) && $response_code < 400 ) {
					$items = json_decode( wp_remote_retrieve_body( $response ) );
				} else {
					$items = false;
				}

				if ( $cache && $items ) {
					set_transient( $transient_name, $items, $expiration * HOUR_IN_SECONDS );
				}
			}

			return $items;
		}

		/**
		 * Returns a unique transient name per url
		 * @author Jim Barnes
		 * @since 1.0.0
		 * @param $url string | The url of the feed
		 * @return string | The transient name
		 **/
		private static function get_transient_name( $url ) {
			return 'ucf_pegasus_list_' . md5( $url );
		}
	}
}
