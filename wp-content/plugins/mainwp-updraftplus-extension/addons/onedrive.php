<?php
/*
  UpdraftPlus Addon: onedrive:Microsoft OneDrive Support
  Description: Microsoft OneDrive Support
  Version: 1.2
  Shop: /shop/onedrive/
  Include: includes/onedrive
  IncludePHP: methods/addon-base.php
  RequiresPHP: 5.3.3
  Latest Change: 1.10.3
 */

if ( ! defined( 'MAINWP_UPDRAFT_PLUS_DIR' ) ) {
		die( 'No direct access allowed' ); }

/*
  do_bootstrap($possible_options_array, $connect = true) # Return a WP_Error object if something goes wrong
  do_upload($file) # Return true/false
  do_listfiles($match)
  do_delete($file) - return true/false
  do_download($file, $fullpath, $start_offset) - return true/false
  do_config_print()
  do_config_javascript()
  do_credentials_test_parameters() - return an array: keys = required _POST parameters; values = description of each
  do_credentials_test($testfile) - return true/false
  do_credentials_test_deletefile($testfile)
 */

if ( ! class_exists( 'MainWP_Updraft_Plus_RemoteStorage_Addons_Base' ) ) {
		require_once( MAINWP_UPDRAFT_PLUS_DIR . '/methods/addon-base.php' ); }

class MainWP_Updraft_Plus_Addons_RemoteStorage_onedrive extends MainWP_Updraft_Plus_RemoteStorage_Addons_Base {

		// https://dev.onedrive.com/items/upload_large_files.htm says "Use a fragment size that is a multiple of 320 KB"
	private $chunk_size = 3276800;

	public function __construct() {
			# 3rd parameter: chunking? 4th: Test button?
			parent::__construct( 'onedrive', 'OneDrive', false, false );			
		if ( defined( 'MAINWP_UPDRAFT_PLUS_UPLOAD_CHUNKSIZE' ) && MAINWP_UPDRAFT_PLUS_UPLOAD_CHUNKSIZE > 0 ) {
				$this->chunk_size = max( MAINWP_UPDRAFT_PLUS_UPLOAD_CHUNKSIZE, 320 * 1024 ); }
	}

	public function do_upload( $file, $from ) {

	
	}

		// Return: boolean
	public function chunked_upload( $file, $fp, $chunk_index, $upload_size, $upload_start, $upload_end ) {

	}

	private function get_pointer( $folder, $service ) {
		
	}

	public function do_download( $file, $fullpath, $start_offset ) {

	}

	public function chunked_download( $file, $headers, $data ) {
		
	}

	public function do_listfiles( $match = 'backup_' ) {
		
	}

	public function do_bootstrap( $opts, $connect = true ) {
		
	}

	protected function options_exist( $opts ) {
		if ( is_array( $opts ) && ! empty( $opts['clientid'] ) && ! empty( $opts['secret'] ) ) {
				return true; }
			return false;
	}

	
	public function show_authed_admin_warning() {
		
	}

	public function get_opts() {
			global $mainwp_updraftplus;
			$opts = MainWP_Updraft_Plus_Options::get_updraft_option( 'updraft_onedrive' ); //$mainwp_updraftplus->get_job_option('updraft_onedrive');
		if ( ! is_array( $opts ) ) {
				$opts = array( 'clientid' => '', 'secret' => '', 'url' => '' ); }
			return $opts;
	}

		//Directs users to the login/authentication page
	private function auth_request() {

		
	}

	private function auth_token( $code ) {

	}

	public function do_config_print( $opts ) {
			global $mainwp_updraftplus_admin;

			$folder = (empty( $opts['folder'] )) ? '' : untrailingslashit( $opts['folder'] );
			$clientid = (empty( $opts['clientid'] )) ? '' : $opts['clientid'];
			$secret = (empty( $opts['secret'] )) ? '' : $opts['secret'];

		//      $site_host = parse_url(network_site_url(), PHP_URL_HOST);
		//
		//      if ('127.0.0.1' == $site_host || '::1' == $site_host || 'localhost' == $site_host) {
		//          // Of course, there are other things that are effectively 127.0.0.1. This is just to help.
		//          $callback_text = '<p><strong>'.htmlspecialchars(sprintf(__('Microsoft OneDrive is not compatible with sites hosted on a localhost or 127.0.0.1 URL - their developer console forbids these (current URL is: %s).','mainwp-updraftplus-extension'), site_url())).'</strong></p>';
		//      } else {
		//          $callback_text = '<p>'.htmlspecialchars(__('You must add the following as the authorised redirect URI in your OneDrive console (under "API Settings") when asked','mainwp-updraftplus-extension')).': <kbd>'.MainWP_Updraft_Plus_Options::admin_page_url().'</kbd></p>';
		//      }

			$mainwp_updraftplus_admin->storagemethod_row(
				'onedrive', '', '<img src="' . MAINWP_UPDRAFT_PLUS_URL . '/images/onedrive.png"><p><a href="https://account.live.com/developers/applications/create">' . __( 'Create OneDrive credentials in your OneDrive developer console.', 'mainwp-updraftplus-extension' ) . '</a></p><p><a href="https://updraftplus.com/microsoft-onedrive-setup-guide/">' . __( 'For longer help, including screenshots, follow this link.', 'mainwp-updraftplus-extension' ) . '</a></p>'
			);
			?>
			<?php if ( MainWP_Updraftplus_Backups::is_managesites_updraftplus() ) { ?>
						<tr class="mwp_updraftplusmethod onedrive">
							<th><?php echo __( 'OneDrive', 'mainwp-updraftplus-extension' ) . ' ' . __( 'Client ID', 'mainwp-updraftplus-extension' ); ?>:</th>
							<td><input type="text" autocomplete="off" style="width:442px" name="mwp_updraft_onedrive[clientid]" value="<?php echo htmlspecialchars( $clientid ) ?>" /><br><em><?php echo htmlspecialchars( __( 'If OneDrive later shows you the message "unauthorized_client", then you did not enter a valid client ID here.', 'mainwp-updraftplus-extension' ) ); ?></em></td>
						</tr>
						<tr class="mwp_updraftplusmethod onedrive">
							<th><?php echo __( 'OneDrive', 'mainwp-updraftplus-extension' ) . ' ' . __( 'Client Secret', 'mainwp-updraftplus-extension' ); ?>:</th>
							<td><input type="<?php echo apply_filters( 'updraftplus_admin_secret_field_type', 'text' ); ?>" style="width:442px" name="mwp_updraft_onedrive[secret]" value="<?php echo htmlspecialchars( $secret ); ?>" /></td>
						</tr>

						<?php
						$mainwp_updraftplus_admin->storagemethod_row(
							'onedrive', 'OneDrive ' . __( 'Folder', 'mainwp-updraftplus-extension' ), '<input title="' . esc_attr( sprintf( __( 'Enter the path of the %s folder you wish to use here.', 'mainwp-updraftplus-extension' ), 'OneDrive' ) . ' ' . __( 'If the folder does not already exist, then it will be created.' ) . ' ' . sprintf( __( 'e.g. %s', 'mainwp-updraftplus-extension' ), 'MyBackups/WorkWebsite.' ) . ' ' . sprintf( __( 'If you leave it blank, then the backup will be placed in the root of your %s', 'mainwp-updraftplus-extension' ), 'OneDrive account' ) . ' ' . sprintf( __( 'N.B. %s is not case-sensitive.', 'mainwp-updraftplus-extension' ), 'OneDrive' ) ) . '" type="text" style="width:442px" name="mwp_updraft_onedrive[folder]" value="' . esc_attr( $folder ) . '">'
						);

						$sid = MainWP_Updraftplus_Backups::get_site_id_managesites_updraftplus();
						$auth_link = '/wp-admin/options-general.php?page=updraftplus&action=updraftmethod-onedrive-auth&updraftplus_onedriveauth=doit';
						$auth_link = MainWP_Updraftplus_Backups::get_instance()->get_open_location_link( $sid, $auth_link );

						$mainwp_updraftplus_admin->storagemethod_row(
							'onedrive', sprintf( __( 'Authenticate with %s', 'mainwp-updraftplus-extension' ), 'OneDrive' ) . ':', '<p>' . ( ! empty( $opts['refresh_token'] ) ? '<strong>' . __( '(You appear to be already authenticated).', 'mainwp-updraftplus-extension' ) . '</strong>' : '') .
							(( ! empty( $opts['refresh_token'] ) && ! empty( $opts['ownername'] )) ? ' ' . sprintf( __( "Account holder's name: %s.", 'mainwp-updraftplus-extension' ), htmlspecialchars( $opts['ownername'] ) ) . ' ' : '') .
							'</p><p><a href="' . $auth_link . '" target="_blank">' . sprintf( __( '<strong>After</strong> you have saved your settings (by clicking \'Save Changes\' below), then come back here once and click this link to complete authentication with %s.', 'mainwp-updraftplus-extension' ), 'OneDrive' ) . '</a></p>'
						);

						//$mainwp_updraftplus_admin->curl_check('OneDrive', false, 'onedrive', false);
}
	}
}

$mainwp_updraftplus_addons_onedrive = new MainWP_Updraft_Plus_Addons_RemoteStorage_onedrive;
