<?php
if ( ! defined( 'MAINWP_UPDRAFT_PLUS_DIR' ) ) {
		die( 'No direct access allowed.' ); }

# Converted to job_options: yes
# Converted to array options: yes
# Migrate options to new-style storage - Apr 2014
# clientid, secret, remotepath

class MainWP_Updraft_Plus_BackupModule_googledrive {

	private $service;
	private $client;
	private $ids_from_paths;

	

	public function get_credentials() {
			return array( 'updraft_googledrive' );
	}

	public function get_opts() {
			# parentid is deprecated since April 2014; it should not be in the default options (its presence is used to detect an upgraded-from-previous-SDK situation). For the same reason, 'folder' is also unset; which enables us to know whether new-style settings have ever been set.
			global $mainwp_updraftplus;
			$opts = MainWP_Updraft_Plus_Options::get_updraft_option( 'updraft_googledrive' ); // $mainwp_updraftplus->get_job_option('updraft_googledrive');
		if ( ! is_array( $opts ) ) {
				$opts = array( 'clientid' => '', 'secret' => '' ); }
			return $opts;
	}

	private function root_id() {
		if ( empty( $this->root_id ) ) {
				$this->root_id = $this->service->about->get()->getRootFolderId(); }
			return $this->root_id;
	}

	public function id_from_path( $path, $retry = true ) {
			global $mainwp_updraftplus;

		try {
			while ( '/' == substr( $path, 0, 1 ) ) {
					$path = substr( $path, 1 );
			}

				$cache_key = (empty( $path )) ? '/' : $path;
			if ( ! empty( $this->ids_from_paths ) && isset( $this->ids_from_paths[ $cache_key ] ) ) {
					return $this->ids_from_paths[ $cache_key ]; }

				$current_parent = $this->root_id();
				$current_path = '/';

			if ( ! empty( $path ) ) {
				foreach ( explode( '/', $path ) as $element ) {
						$found = false;
						$sub_items = $this->get_subitems( $current_parent, 'dir', $element );

					foreach ( $sub_items as $item ) {
						try {
							if ( $item->getTitle() == $element ) {
									$found = true;
									$current_path .= $element . '/';
									$current_parent = $item->getId();
									break;
							}
						} catch (Exception $e) {
									$mainwp_updraftplus->log( 'Google Drive id_from_path: exception: ' . $e->getMessage() . ' (line: ' . $e->getLine() . ', file: ' . $e->getFile() . ')' );
						}
					}

					if ( ! $found ) {
							$ref = new Google_Service_Drive_ParentReference;
							$ref->setId( $current_parent );
							$dir = new Google_Service_Drive_DriveFile();
							$dir->setMimeType( 'application/vnd.google-apps.folder' );
							$dir->setParents( array( $ref ) );
							$dir->setTitle( $element );
							$mainwp_updraftplus->log( 'Google Drive: creating path: ' . $current_path . $element );
							$dir = $this->service->files->insert(
								$dir, array( 'mimeType' => 'application/vnd.google-apps.folder' )
							);
							$current_path .= $element . '/';
							$current_parent = $dir->getId();
					}
				}
			}

			if ( empty( $this->ids_from_paths ) ) {
					$this->ids_from_paths = array(); }
					$this->ids_from_paths[ $cache_key ] = $current_parent;

					return $current_parent;
		} catch (Exception $e) {
				$mainwp_updraftplus->log( 'Google Drive id_from_path failure: exception: ' . $e->getMessage() . ' (line: ' . $e->getLine() . ', file: ' . $e->getFile() . ')' );
				# One retry
				return ($retry) ? $this->id_from_path( $path, false ) : false;
		}
	}

	private function get_parent_id( $opts ) {
			$filtered = apply_filters( 'mainwp_updraftplus_googledrive_parent_id', false, $opts, $this->service, $this );
		if ( ! empty( $filtered ) ) {
				return $filtered; }
		if ( isset( $opts['parentid'] ) ) {
			if ( empty( $opts['parentid'] ) ) {
					return $this->root_id();
			} else {
					$parent = (is_array( $opts['parentid'] )) ? $opts['parentid']['id'] : $opts['parentid'];
			}
		} else {
				$parent = $this->id_from_path( 'UpdraftPlus' );
		}
			return (empty( $parent )) ? $this->root_id() : $parent;
	}

	public function listfiles( $match = 'backup_' ) {

	}

		// Get a Google account access token using the refresh token
	private function access_token( $refresh_token, $client_id, $client_secret ) {

			global $mainwp_updraftplus;
			$mainwp_updraftplus->log( "Google Drive: requesting access token: client_id=$client_id" );

			$query_body = array(
				'refresh_token' => $refresh_token,
				'client_id' => $client_id,
				'client_secret' => $client_secret,
				'grant_type' => 'refresh_token',
			);

			$result = wp_remote_post('https://accounts.google.com/o/oauth2/token', array(
				'timeout' => '15',
				'method' => 'POST',
				'body' => $query_body,
					)
			);

			if ( is_wp_error( $result ) ) {
					$mainwp_updraftplus->log( 'Google Drive error when requesting access token' );
				foreach ( $result->get_error_messages() as $msg ) {
						$mainwp_updraftplus->log( "Error message: $msg" ); }
					return false;
			} else {
					$json_values = json_decode( $result['body'], true );
				if ( isset( $json_values['access_token'] ) ) {
						$mainwp_updraftplus->log( 'Google Drive: successfully obtained access token' );
						return $json_values['access_token'];
				} else {
						$mainwp_updraftplus->log( 'Google Drive error when requesting access token: response does not contain access_token' );
						return false;
				}
			}
	}

	private function redirect_uri() {
			return MainWP_Updraft_Plus_Options::googledrive_page_url(); //.'?action=updraftmethod-googledrive-auth';
	}

		// Acquire single-use authorization code from Google OAuth 2.0
	public function gdrive_auth_request() {
	
	}

		// Revoke a Google account refresh token
		// Returns the parameter fed in, so can be used as a WordPress options filter
		// Can be called statically from UpdraftPlus::googledrive_clientid_checkchange()
	public static function gdrive_auth_revoke( $unsetopt = true ) {
		
	}

		// Get a Google account refresh token using the code received from gdrive_auth_request
	public function gdrive_auth_token() {
		
	}

	public function show_authed_admin_success() {

	}

		// This function just does the formalities, and off-loads the main work to upload_file
	public function backup( $backup_array ) {

			return null;
	}

	public function bootstrap( $access_token = false ) {

	}

		# Returns Google_Service_Drive_DriveFile object

	private function get_subitems( $parent_id, $type = 'any', $match = 'backup_' ) {
		
	}

	public function delete( $files ) {

	}

	private function upload_file( $file, $parent_id, $try_again = true ) {

		
	}

	public function download( $file ) {
		return true;
	}

	public function config_print() {
			$opts = $this->get_opts();
			?>
			<tr class="mwp_updraftplusmethod googledrive">
				<td></td>
				<td>
					<img src="https://developers.google.com/drive/images/drive_logo.png" alt="<?php _e( 'Google Drive', 'mainwp-updraftplus-extension' ); ?>">
					<p><em><?php printf( __( '%s is a great choice, because UpdraftPlus supports chunked uploads - no matter how big your site is, UpdraftPlus can upload it a little at a time, and not get thwarted by timeouts.', 'mainwp-updraftplus-extension' ), 'Google Drive' ); ?></em></p>
				</td>
				</tr>

				<tr class="mwp_updraftplusmethod googledrive">
				<th></th>
				<td>
					<?php
					$admin_page_url = MainWP_Updraft_Plus_Options::admin_page_url();
					# This is advisory - so the fact it doesn't match IPv6 addresses isn't important
					if ( preg_match( '#^(https?://(\d+)\.(\d+)\.(\d+)\.(\d+))/#', $admin_page_url, $matches ) ) {
							echo '<p><strong>' . htmlspecialchars( sprintf( __( "%s does not allow authorisation of sites hosted on direct IP addresses. You will need to change your site's address (%s) before you can use %s for storage.", 'mainwp-updraftplus-extension' ), __( 'Google Drive', 'mainwp-updraftplus-extension' ), $matches[1], __( 'Google Drive', 'mainwp-updraftplus-extension' ) ) ) . '</strong></p>';
					} else {
							?>

							<p><a href="http://updraftplus.com/support/configuring-google-drive-api-access-in-updraftplus/"><strong><?php _e( 'For longer help, including screenshots, follow this link. The description below is sufficient for more expert users.', 'mainwp-updraftplus-extension' ); ?></strong></a></p>

								<p><a href="https://console.developers.google.com"><?php _e( 'Follow this link to your Google API Console, and there activate the Drive API and create a Client ID in the API Access section.', 'mainwp-updraftplus-extension' ); ?></a> <?php _e( "Select 'Web Application' as the application type.", 'mainwp-updraftplus-extension' ); ?></p><p><?php _e( 'N.B. If you install UpdraftPlus on several WordPress sites, then you cannot re-use your project; you must create a new one from your Google API console for each site.', 'mainwp-updraftplus-extension' ); ?>
								</p>
								<?php
					}
					?>

					</td>
				</tr>
				<?php //if ( MainWP_Updraftplus_Backups::is_managesites_updraftplus() ) { ?>
						<tr class="mwp_updraftplusmethod googledrive">
							<th><?php echo __( 'Google Drive', 'mainwp-updraftplus-extension' ) . ' ' . __( 'Client ID', 'mainwp-updraftplus-extension' ); ?>:</th>
							<td><input type="text" autocomplete="off" style="width:442px" name="mwp_updraft_googledrive[clientid]" value="<?php echo htmlspecialchars( $opts['clientid'] ) ?>" /><br><em><?php _e( 'If Google later shows you the message "invalid_client", then you did not enter a valid client ID here.', 'mainwp-updraftplus-extension' ); ?></em></td>
						</tr>
						<tr class="mwp_updraftplusmethod googledrive">
							<th><?php echo __( 'Google Drive', 'mainwp-updraftplus-extension' ) . ' ' . __( 'Client Secret', 'mainwp-updraftplus-extension' ); ?>:</th>
							<td><input type="<?php echo apply_filters( 'mainwp_updraftplus_admin_secret_field_type', 'text' ); ?>" style="width:442px" name="mwp_updraft_googledrive[secret]" value="<?php echo htmlspecialchars( $opts['secret'] ); ?>" /></td>
						</tr>

						<?php
						# Legacy configuration
						if ( isset( $opts['parentid'] ) ) {
								$parentid = (is_array( $opts['parentid'] )) ? $opts['parentid']['id'] : $opts['parentid'];
								$showparent = (is_array( $opts['parentid'] ) && ! empty( $opts['parentid']['name'] )) ? $opts['parentid']['name'] : $parentid;
								$folder_opts = '<tr class="mwp_updraftplusmethod googledrive">
				<th>' . __( 'Google Drive', 'mainwp-updraftplus-extension' ) . ' ' . __( 'Folder', 'mainwp-updraftplus-extension' ) . ':</th>
				<td><input type="hidden" name="mwp_updraft_googledrive[parentid][id]" value="' . htmlspecialchars( $parentid ) . '">
				<input type="text" title="' . esc_attr( $parentid ) . '" readonly="readonly" style="width:442px" value="' . htmlspecialchars( $showparent ) . '">';
							if ( ! empty( $parentid ) && ( ! is_array( $opts['parentid'] ) || empty( $opts['parentid']['name'] )) ) {
									$folder_opts .= '<em>' . __( '<strong>This is NOT a folder name</strong>.', 'mainwp-updraftplus-extension' ) . ' ' . __( 'It is an ID number internal to Google Drive', 'mainwp-updraftplus-extension' ) . '</em>';
							} else {
									$folder_opts .= '<input type="hidden" name="mwp_updraft_googledrive[parentid][name]" value="' . htmlspecialchars( $opts['parentid']['name'] ) . '">';
							}
						} else {
								$folder_opts = '<tr class="mwp_updraftplusmethod googledrive">
				<th>' . __( 'Google Drive', 'mainwp-updraftplus-extension' ) . ' ' . __( 'Folder', 'mainwp-updraftplus-extension' ) . ':</th>
				<td><input type="text" readonly="readonly" style="width:442px" name="mwp_updraft_googledrive[folder]" value="UpdraftPlus" />';
						}
						$folder_opts .= '<br><em><a href="http://updraftplus.com/shop/updraftplus-premium/">' . __( 'To be able to set a custom folder name, use UpdraftPlus Premium.', 'mainwp-updraftplus-extension' ) . '</em></a>';
						$folder_opts .= '</td></tr>';
						echo apply_filters( 'mainwp_updraftplus_options_googledrive_others', $folder_opts, $opts );

						$sid = MainWP_Updraftplus_Backups::get_site_id_managesites_updraftplus();
						$auth_link = '/wp-admin/options-general.php?action=updraftmethod-googledrive-auth&page=updraftplus&updraftplus_googleauth=doit';
						$auth_link = MainWP_Updraftplus_Backups::get_instance()->get_open_location_link( $sid, $auth_link );
						?>

                                                <?php if ( MainWP_Updraftplus_Backups::is_managesites_updraftplus() ) { ?>
						<tr class="mwp_updraftplusmethod googledrive">
							<th><?php _e( 'Authenticate with Google' ); ?>:</th>
							<td><p><?php if ( ! empty( $opts['token'] ) ) { echo __( "<strong>(You appear to be already authenticated,</strong> though you can authenticate again to refresh your access if you've had a problem).", 'mainwp-updraftplus-extension' ); } ?>

									<?php
									if ( ! empty( $opts['token'] ) && ! empty( $opts['ownername'] ) ) {
											echo '<br>' . sprintf( __( "Account holder's name: %s.", 'mainwp-updraftplus-extension' ), htmlspecialchars( $opts['ownername'] ) ) . ' ';
									}
									?>
								</p>
								<p>

									<a href="<?php echo $auth_link; ?>" target="_blank"><?php print __( '<strong>After</strong> you have saved your settings (by clicking \'Save Changes\' below), then come back here once and click this link to complete authentication with Google.', 'mainwp-updraftplus-extension' ); ?></a>
								</p>
							</td>
						</tr>
						<?php
                                                 }
                                        //}
	}
}
