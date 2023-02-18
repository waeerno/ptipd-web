<?php

	define('kingster_ITEM_ID', 22473937);
	define('kingster_PURCHASE_VERFIY_URL', 'https://goodlayers.com/licenses/wp-json/verify/purchase_code'); 
	define('kingster_PLUGIN_VERSION_URL', 'https://goodlayers.com/licenses/wp-json/version/plugin');
	define('kingster_PLUGIN_UPDATE_URL', 'https://goodlayers.com/licenses/wp-content/plugins/goodlayers-verification/download/');
	
	// define('kingster_PURCHASE_VERFIY_URL', 'http://localhost/kingster/wp-json/verify/purchase_code'); 
	// define('kingster_PLUGIN_VERSION_URL', 'http://localhost/kingster/wp-json/version/plugin'); 
	// define('kingster_PLUGIN_UPDATE_URL', 'http://localhost/Gdl%20Theme/plugins/goodlayers-verification/download/');

	if( !function_exists('kingster_is_purchase_verified') ){
		function kingster_is_purchase_verified(){
			$purchase_code = kingster_get_purchase_code();
			return empty($purchase_code)? false: true;
		}
	}
	if( !function_exists('kingster_get_purchase_code') ){
		function kingster_get_purchase_code(){
			return get_option('envato_purchase_code_' . kingster_ITEM_ID, '');
		}
	}
	if( !function_exists('kingster_get_download_url') ){
		function kingster_get_download_url($file){
			$download_key = get_option('kingster_download_key', '');
			$purchase_code = kingster_get_purchase_code();
			if( empty($download_key) ) return false;

			return add_query_arg(array(
				'purchase_code' => $purchase_code,
				'download_key' => $download_key,
				'file' => $file
			), kingster_PLUGIN_UPDATE_URL);
		}
	}

	# delete_option('envato_purchase_code_' . kingster_ITEM_ID);
	# delete_option('kingster_download_key');
	if( !function_exists('kingster_verify_purchase') ){
		function kingster_verify_purchase($purchase_code, $register){
			$response = wp_remote_post(kingster_PURCHASE_VERFIY_URL, array(
				'body' => array(
					'register' => $register,
					'item_id' => kingster_ITEM_ID,
					'website' => get_site_url(),
					'purchase_code' => $purchase_code
				)
			));

			if( is_wp_error($response) || wp_remote_retrieve_response_code($response) != 200 ){
				throw new Exception(wp_remote_retrieve_response_message($response));
			}

			$data = json_decode(wp_remote_retrieve_body($response), true);
			if( $data['status'] == 'success' ){
				update_option('envato_purchase_code_' . kingster_ITEM_ID, $purchase_code);
				update_option('kingster_download_key', $data['download_key']);
				return true;
			}else{
				update_option('envato_purchase_code_' . kingster_ITEM_ID, '');
				update_option('kingster_download_key', '');

				if( !empty($data['message']) ){
					throw new Exception($data['message']);
				}else{
					throw new Exception(esc_html__('Unknown Error', 'kingster'));
				}
				
			}

		} // kingster_verify_purchase
	}

	// delete_option('kingster_daily_schedule');
	// delete_option('kingster-plugins-version');
	add_action('init', 'kingster_admin_schedule');
	if( !function_exists('kingster_admin_schedule') ){
		function kingster_admin_schedule(){
			if( !is_admin() ) return;

			$current_date = date('Y-m-d');
			$daily_schedule = get_option('kingster_daily_schedule', '');
			if( $daily_schedule != $current_date ){
				update_option('kingster_daily_schedule', $current_date);
				do_action('kingster_daily_schedule');
			}
		}
	}

	# update version from server
	add_action('kingster_daily_schedule', 'kingster_plugin_version_update');
	if( !function_exists('kingster_plugin_version_update') ){
		function kingster_plugin_version_update(){
			$response = wp_remote_get(kingster_PLUGIN_VERSION_URL);

			if( !is_wp_error($response) && !empty($response['body']) ){
				update_option('kingster-plugins-version', json_decode($response['body'], true));
			}
		}
	}