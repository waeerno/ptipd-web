<?php
	class Kingster_Plugin_Installer_Skin extends Plugin_Installer_Skin{
		public function strip_args( $string ){
			if( strpos($string, 'download_key') !== false ){
				$url = parse_url($string, PHP_URL_HOST);

				if( !empty($url) ){
					return $url;
				}
			}
			return $string;
		}
		
		public function feedback( $string, ...$args ) {
			if ( isset( $this->upgrader->strings[ $string ] ) ) {
				$string = $this->upgrader->strings[ $string ];
			}

			if ( strpos( $string, '%' ) !== false ) {
				if ( $args ) {
					$args   = array_map( 'strip_tags', $args );
					$args   = array_map( 'esc_html', $args );
					$args   = array_map( array($this, 'strip_args'), $args );
					$string = vsprintf( $string, $args );
				}
			}
			if ( empty( $string ) ) {
				return;
			}
			show_message( $string );
		}
	}