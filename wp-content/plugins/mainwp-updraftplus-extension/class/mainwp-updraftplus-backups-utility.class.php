<?php

class MainWP_Updraftplus_Backups_Utility {

	public static function get_timestamp( $timestamp ) {
			$gmtOffset = get_option( 'gmt_offset' );

			return ($gmtOffset ? ($gmtOffset * HOUR_IN_SECONDS) + $timestamp : $timestamp);
	}

	public static function format_timestamp( $timestamp ) {
			return date_i18n( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), $timestamp );
	}

	static function ctype_digit( $str ) {
			return (is_string( $str ) || is_int( $str ) || is_float( $str )) && preg_match( '/^\d+\z/', $str );
	}

	public static function map_site( &$website, $keys ) {
			$outputSite = array();
		foreach ( $keys as $key ) {
				$outputSite[ $key ] = $website->$key;
		}
			return $outputSite;
	}

	static function get_getdata_authed( $website, $paramValue, $paramName = 'where', $open_location = '' ) {
			$params = array();
		if ( $website && '' != $paramValue ) {
				$nonce = rand( 0, 9999 );
			if ( (0 == $website->nossl) && function_exists( 'openssl_verify' ) ) {
					$nossl = 0;
					openssl_sign( $paramValue . $nonce, $signature, base64_decode( $website->privkey ) );
			} else {
					$nossl = 1;
					$signature = md5( $paramValue . $nonce . $website->nosslkey );
			}
				$signature = base64_encode( $signature );

				$params = array(
					'login_required' => 1,
					'user' => $website->adminname,
					'mainwpsignature' => rawurlencode( $signature ),
					'nonce' => $nonce,
					'nossl' => $nossl,
					'open_location' => $open_location,
					$paramName => rawurlencode( $paramValue ),
				);
		}

			$url = (isset( $website->siteurl ) && $website->siteurl != '' ? $website->siteurl : $website->url);
			$url .= (substr( $url, -1 ) != '/' ? '/' : '');
			$url .= '?';

		foreach ( $params as $key => $value ) {
				$url .= $key . '=' . $value . '&';
		}

			return rtrim( $url, '&' );
	}
}
