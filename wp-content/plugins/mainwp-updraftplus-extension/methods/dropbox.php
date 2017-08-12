<?php
// https://www.dropbox.com/developers/apply?cont=/developers/apps

if ( ! defined( 'MAINWP_UPDRAFT_PLUS_DIR' ) ) {
		die( 'No direct access allowed.' ); }

# Converted to job_options: yes
# Converted to array options: yes
# Migrate options to new-style storage - May 2014
# appkey, secret, folder, updraft_dropboxtk_request_token, updraft_dropboxtk_access_token

class MainWP_Updraft_Plus_BackupModule_dropbox {

	private $current_file_hash;
	private $current_file_size;
	private $dropbox_object;

	public function chunked_callback( $offset, $uploadid, $fullpath = false ) {
		
	}

	public function get_credentials() {
			return array( 'updraft_dropbox' );
	}

	public function get_opts() {
			global $mainwp_updraftplus;
			$opts = MainWP_Updraft_Plus_Options::get_updraft_option( 'updraft_dropbox' ); //$mainwp_updraftplus->get_job_option('updraft_dropbox');
		if ( ! is_array( $opts ) ) {
				$opts = array(); }
		if ( ! isset( $opts['folder'] ) ) {
				$opts['folder'] = ''; }
			return $opts;
	}

	public function backup( $backup_array ) {			
			return null;
	}

		# $match: a substring to require (tested via strpos() !== false)

	public function listfiles( $match = 'backup_' ) {

	}

	public function defaults() {
			return apply_filters( 'mainwp_updraftplus_dropbox_defaults', array( 'Z3Q3ZmkwbnplNHA0Zzlx', 'bTY0bm9iNmY4eWhjODRt' ) );
	}

	public function delete( $files ) {

	}

	public function download( $file ) {

	}

	public function config_print() {
			$opts = $this->get_opts();
			?>
			<tr class="mwp_updraftplusmethod dropbox">
				<td></td>
				<td>
					<img alt="<?php _e( sprintf( __( '%s logo', 'mainwp-updraftplus-extension' ), 'Dropbox' ) ); ?>" src="<?php echo MAINWP_UPDRAFT_PLUS_URL . '/images/dropbox-logo.png' ?>">
					<p><em><?php printf( __( '%s is a great choice, because UpdraftPlus supports chunked uploads - no matter how big your site is, UpdraftPlus can upload it a little at a time, and not get thwarted by timeouts.', 'mainwp-updraftplus-extension' ), 'Dropbox' ); ?></em></p>
				</td>
				</tr>

				<tr class="mwp_updraftplusmethod dropbox">
				<th></th>
				<td>
					<?php
					// Check requirements.
					global $mainwp_updraftplus_admin;
					if ( ! function_exists( 'mcrypt_encrypt' ) ) {
							$mainwp_updraftplus_admin->show_double_warning( '<strong>' . __( 'Warning', 'mainwp-updraftplus-extension' ) . ':</strong> ' . sprintf( __( 'Your web server\'s PHP installation does not included a required module (%s). Please contact your web hosting provider\'s support and ask for them to enable it.', 'mainwp-updraftplus-extension' ), 'mcrypt' ) );
							/*
							  .' '.sprintf(__("UpdraftPlus's %s module <strong>requires</strong> %s. Please do not file any support requests; there is no alternative.",'mainwp-updraftplus-extension'),'Dropbox', 'mcrypt'), 'dropbox')
							 */
					}
					//$mainwp_updraftplus_admin->curl_check('Dropbox', false, 'dropbox');
					?>
					</td>
				</tr>

				<?php
                                $defmsg = '<tr class="mwp_updraftplusmethod dropbox"><td></td><td><strong>' . __( 'Need to use sub-folders?', 'mainwp-updraftplus-extension' ) . '</strong> ' . __( 'Backups are saved in', 'mainwp-updraftplus-extension' ) . ' apps/UpdraftPlus. ' . __( 'If you back up several sites into the same Dropbox and want to organise with sub-folders, then ', 'mainwp-updraftplus-extension' ) . '<a href="http://updraftplus.com/shop/">' . __( "there's an add-on for that.", 'mainwp-updraftplus-extension' ) . '</a></td></tr>';

                                echo apply_filters( 'mainwp_updraftplus_dropbox_extra_config', $defmsg );
				if ( MainWP_Updraftplus_Backups::is_managesites_updraftplus() ) {

						$sid = MainWP_Updraftplus_Backups::get_site_id_managesites_updraftplus();
						$auth_link = '/wp-admin/admin.php?page=updraftplus&action=updraftmethod-dropbox-auth&updraftplus_dropboxauth=doit';
						$auth_link = MainWP_Updraftplus_Backups::get_instance()->get_open_location_link( $sid, $auth_link );
						?>

						<tr class="mwp_updraftplusmethod dropbox">
							<th><?php echo sprintf( __( 'Authenticate with %s', 'mainwp-updraftplus-extension' ), __( 'Dropbox', 'mainwp-updraftplus-extension' ) ); ?>:</th>
							<td><p><a href="<?php echo $auth_link; ?>" target="_blank"><?php echo sprintf( __( '<strong>After</strong> you have saved your settings (by clicking \'Save Changes\' below), then come back here once and click this link to complete authentication with %s.', 'mainwp-updraftplus-extension' ), __( 'Dropbox', 'mainwp-updraftplus-extension' ) ); ?></a>
								</p>				
							</td>
						</tr>

						<?php
						// Legacy: only show this next setting to old users who had a setting stored
						//if (!empty($opts['appkey'])) {
						?>

						<tr class="mwp_updraftplusmethod dropbox">
							<th>Your Dropbox App Key:</th>
							<td><input type="text" autocomplete="off" style="width:332px" id="updraft_dropbox_appkey" name="mwp_updraft_dropbox[appkey]" value="<?php echo (isset( $opts['appkey'] ) ? htmlspecialchars( $opts['appkey'] ) : '') ?>" /></td>
						</tr>
						<tr class="mwp_updraftplusmethod dropbox">
							<th>Your Dropbox App Secret:</th>
							<td><input type="text" style="width:332px" id="updraft_dropbox_secret" name="mwp_updraft_dropbox[secret]" value="<?php echo (isset( $opts['secret'] ) ? htmlspecialchars( $opts['secret'] ) : ''); ?>" /></td>
						</tr>

						<?php //} ?>
				<?php } ?>
				<?php
	}


	public function show_authed_admin_warning() {
			
	}

	public function auth_token() {
		//      $opts = $this->get_opts();
		//      $previous_token = empty($opts['tk_request_token']) ? '' : $opts['tk_request_token'];
			$this->bootstrap();
			$opts = $this->get_opts();
			$new_token = empty( $opts['tk_request_token'] ) ? '' : $opts['tk_request_token'];
		if ( $new_token ) {
				add_action( 'all_admin_notices', array( $this, 'show_authed_admin_warning' ) );
		}
	}

		// Acquire single-use authorization code
	public function auth_request() {
			$this->bootstrap();
	}

		// This basically reproduces the relevant bits of bootstrap.php from the SDK
	public function bootstrap() {

		
	}
}
