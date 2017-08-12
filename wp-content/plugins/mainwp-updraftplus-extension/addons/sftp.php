<?php
/*
  UpdraftPlus Addon: sftp:SFTP, SCP and FTPS Support
  Description: Allows UpdraftPlus to back up to SFTP, SSH and encrypted FTP servers
  Version: 2.3
  Shop: /shop/sftp/
  Latest Change: 1.9.1
 */

if ( ! defined( 'MAINWP_UPDRAFT_PLUS_DIR' ) ) {
		die( 'No direct access allowed' ); }

$mainwp_updraft_plus_addons_sftp = new MainWP_Updraft_Plus_Addons_RemoteStorage_sftp;

class MainWP_Updraft_Plus_Addons_RemoteStorage_sftp {

	public function __construct() {
			add_action( 'mainwp_updraft_sftp_config_javascript', array( $this, 'config_javascript' ) );
			add_action( 'mainwp_updraft_sftp_credentials_test', array( $this, 'credentials_test' ) );
			add_filter( 'mainwp_updraft_sftp_upload_files', array( $this, 'upload_files' ), 10, 2 );					
			add_filter( 'mainwp_updraft_sftp_config_print', array( $this, 'config_print' ) );
			add_filter( 'mainwp_updraft_sftp_ftps_notice', array( $this, 'ftps_notice' ) );
			add_filter( 'mainwp_updraftplus_ftp_possible', array( $this, 'updraftplus_ftp_possible' ) );
		//      add_filter('mainwp_updraft_sftp_listfiles', array($this, 'listfiles'), 10, 2);
	}

	public function updraftplus_ftp_possible( $funcs_disabled ) {
		if ( ! is_array( $funcs_disabled ) ) {
					return $funcs_disabled; }
		foreach ( array( 'ftp_ssl_connect', 'ftp_login' ) as $func ) {
			if ( ! function_exists( $func ) ) {
					$funcs_disabled['ftpsslexplicit'][] = $func; }
		}
		foreach ( array( 'curl_exec' ) as $func ) {
			if ( ! function_exists( $func ) ) {
					$funcs_disabled['ftpsslimplicit'][] = $func; }
		}
			return $funcs_disabled;
	}

	public function ftps_notice() {
			return __( "Encrypted FTP is available, and will be automatically tried first (before falling back to non-encrypted if it is not successful), unless you disable it using the expert options. The 'Test FTP Login' button will tell you what type of connection is in use.", 'mainwp-updraftplus-extension' ) . ' ' . __( 'Some servers advertise encrypted FTP as available, but then time-out (after a long time) when you attempt to use it. If you find this happenning, then go into the "Expert Options" (below) and turn off SSL there.', 'mainwp-updraftplus-extension' ) . ' ' . __( 'Explicit encryption is used by default. To force implicit encryption (port 990), add :990 to your FTP server below.', ' updraftplus' );
	}

	public function do_connect_and_chdir() {
			$options = MainWP_Updraft_Plus_Options::get_updraft_option( 'updraft_sftp_settings' );
		if ( ! array( $options ) ) {
				return new WP_Error( 'no_settings', sprintf( __( 'No %s settings were found', 'mainwp-updraftplus-extension' ), 'SCP/SFTP' ) ); }

		if ( empty( $options['host'] ) ) {
				return new WP_Error( 'no_settings', sprintf( __( 'No %s found', 'mainwp-updraftplus-extension' ), __( 'SCP/SFTP host setting', 'mainwp-updraftplus-extension' ) ) ); }
		if ( empty( $options['user'] ) ) {
				return new WP_Error( 'no_settings', sprintf( __( 'No %s found', 'mainwp-updraftplus-extension' ), __( 'SCP/SFTP user setting', 'mainwp-updraftplus-extension' ) ) ); }
		if ( empty( $options['pass'] ) && empty( $options['key'] ) ) {
				return new WP_Error( 'no_settings', sprintf( __( 'No %s found', 'mainwp-updraftplus-extension' ), __( 'SCP/SFTP password/key', 'mainwp-updraftplus-extension' ) ) ); }
			$host = $options['host'];
			$user = $options['user'];
			$pass = (empty( $options['pass'] )) ? '' : $options['pass'];
			$key = (empty( $options['key'] )) ? '' : $options['key'];
			$port = empty( $options['port'] ) ? 22 : (int) $options['port'];
			$path = empty( $options['path'] ) ? '' : $options['path'];
			$scp = empty( $options['scp'] ) ? false : true;

			$this->path = $path;

			$fingerprint = '';

			$sftp = $this->connect( $host, $port, $fingerprint, $user, $pass, $key, $scp );
		if ( is_wp_error( $sftp ) ) {
				return $sftp; }

			// So far, so good
		if ( $path ) {
			if ( $scp ) {
					# May fail - e.g. if directory already exists, or if the remote shell is restricted
					@$this->ssh->exec( 'mkdir ' . escapeshellarg( $path ) );
					# N.B. - have not changed directory (since cd may not be an available command)
			} else {
					@$sftp->mkdir( $path );
					// See if the directory now exists
				if ( ! $sftp->chdir( $path ) ) {
						@$sftp->disconnect();
						return new WP_Error( 'nochdir', __( 'Check your file permissions: Could not successfully create and enter directory:', 'mainwp-updraftplus-extension' ) . " $path" );
				}
			}
		}

			return $sftp;
	}

	public function upload_files( $ret, $backup_array ) {

			// If successful, then you must do this:
			// $mainwp_updraftplus->uploaded_file($file);

			global $mainwp_updraftplus, $mainwp_updraftplus_backup;
			$sftp = $this->do_connect_and_chdir();
		if ( is_wp_error( $sftp ) ) {
			foreach ( $sftp->get_error_messages() as $key => $msg ) {
					$mainwp_updraftplus->log( $msg );
					$mainwp_updraftplus->log( $msg, 'error' );
			}
				return false;
		}

		if ( empty( $this->scp ) ) {
				$mainwp_updraftplus->log( 'SFTP: Successfully logged in' );
		} else {
				$mainwp_updraftplus->log( 'SCP: Successfully logged in' );
		}

			$any_failures = false;

			$updraft_dir = $mainwp_updraftplus->backups_dir_location() . '/';

		foreach ( $backup_array as $file ) {
				$mainwp_updraftplus->log( "SCP/SFTP upload: attempt: $file" );
			if ( empty( $this->scp ) ) {

					$this->sftp_size = max( filesize( $updraft_dir . '/' . $file ), 1 );
					$this->sftp_path = $updraft_dir . '/' . $file;
					$this->sftp_last_sent = 0;

				try {
						$remote_stat = $sftp->stat( $file );
						$current_remote_size = (is_array( $remote_stat ) && isset( $remote_stat['size'] ) && $remote_stat['size'] > 0) ? $remote_stat['size'] : 0;
					if ( $current_remote_size > 0 ) {
							$this->sftp_last_sent = $current_remote_size;
							$mainwp_updraftplus->log( 'SFTP: File exists remotely; upload will resume; size is: ' . round( $current_remote_size / 1024, 2 ) . ' Kb' );
					}
				} catch (Exception $e) {
						$mainwp_updraftplus->log( 'Exception when stating remote file (' . get_class( $e ) . '): ' . $e->getMessage() );
						$current_remote_size = 0;
				}

				if ( $current_remote_size >= $this->sftp_size || $sftp->put( $file, $updraft_dir . '/' . $file, NET_SFTP_LOCAL_FILE, $current_remote_size, -1, array( $this, 'sftp_progress_callback' ) ) ) {
						$mainwp_updraftplus->uploaded_file( $file );
				} else {
						$any_failures = true;
						$mainwp_updraftplus->log( 'ERROR: SFTP: Failed to upload file: ' . $file );
						$mainwp_updraftplus->log( sprintf( __( '%s Error: Failed to upload', 'mainwp-updraftplus-extension' ), 'SFTP' ) . ": $file", 'error' );
				}
			} else {
					$rfile = (empty( $this->path )) ? $file : trailingslashit( $this->path ) . $file;
				if ( $sftp->put( $rfile, $updraft_dir . '/' . $file, NET_SCP_LOCAL_FILE, array( $this, 'sftp_progress_callback' ) ) ) {
						$mainwp_updraftplus->uploaded_file( $file );
				} else {
						$any_failures = true;
						$mainwp_updraftplus->log( 'ERROR: SCP: Failed to upload file: ' . $file );
						$mainwp_updraftplus->log( sprintf( __( '%s Error: Failed to upload', 'mainwp-updraftplus-extension' ), 'SCP' ) . ": $file", 'error' );
				}
			}
		}

			//      if (empty($this->scp)) {
			//          @$sftp->disconnect();
			//      } else {
			//          @$this->ssh->disconnect();
			//      }

		if ( ! $any_failures ) {
				return array( 'sftp_object' => $sftp );
		} else {
				return null;
		}
	}

	public function sftp_progress_callback( $sent ) {
			global $mainwp_updraftplus;
			$last_sent = (empty( $this->sftp_last_sent )) ? 0 : $this->sftp_last_sent;
		if ( $sent > $last_sent + 1048576 ) {
				$perc = round( 100 * $sent / $this->sftp_size, 1 );
				$mainwp_updraftplus->record_uploaded_chunk( $perc, '', $this->sftp_path );
				$this->sftp_last_sent = $sent;
		}
	}

	public function listfiles( $x, $match = 'backup_' ) {
			$sftp = $this->do_connect_and_chdir();
		if ( is_wp_error( $sftp ) ) {
				return $sftp; }

			$results = array();

		if ( $this->scp ) {

				$cdcom = (empty( $this->path )) ? '' : 'cd ' . trailingslashit( $this->path ) . ' && ';

			if ( false == ($exec = $this->ssh->exec( $cdcom . "ls -l ${match}*" )) ) {
					$nosizes = true;
					$exec = $this->ssh->exec( $cdcom . "ls -1 ${match}*" );
			}
			if ( false != $exec ) {
				foreach ( explode( "\n", $exec ) as $str ) {
					if ( $nosizes ) {
						if ( 0 === strpos( $str, $match ) ) {
								$results[] = array( 'name' => $str ); }
					} elseif ( ! $nosizes && preg_match( '/^[^dls].*\s(\d+)\s+\S+\s+\d+\s+([:0-9]+)\s+' . $match . '(.*)$/', $str, $matches ) ) {
							$results[] = array( 'name' => $match . $matches[3], 'size' => $matches[1] );
					}
				}
			}
		} else {
				$dirlist = $sftp->rawlist();
			if ( ! is_array( $dirlist ) ) {
					return array(); }

			foreach ( $dirlist as $path => $stat ) {
				if ( 0 === strpos( $path, $match ) ) {
						$results[] = array( 'name' => $path, 'size' => $stat['size'] ); }
					unset( $dirlist[ $path ] );
			}
		}

			return $results;
	}
	public function connect( $host, $port = 22, $fingerprint, $user, $pass = '', $key = '', $scp = false ) {

			
	}

	public function config_print() {

			$options = MainWP_Updraft_Plus_Options::get_updraft_option( 'updraft_sftp_settings' );
			$host = isset( $options['host'] ) ? htmlspecialchars( $options['host'] ) : '';
			$user = isset( $options['user'] ) ? htmlspecialchars( $options['user'] ) : '';
			$pass = isset( $options['pass'] ) ? htmlspecialchars( $options['pass'] ) : '';
			$key = isset( $options['key'] ) ? htmlspecialchars( $options['key'] ) : '';
			$port = isset( $options['port'] ) ? htmlspecialchars( $options['port'] ) : 22;
			$path = isset( $options['path'] ) ? htmlspecialchars( $options['path'] ) : '';
			$scp = (isset( $options['scp'] ) && $options['scp']) ? true : false;
			$fingerprint = isset( $options['fingerprint'] ) ? htmlspecialchars( $options['fingerprint'] ) : '';
			?>
            <tr class="mwp_updraftplusmethod sftp">
                <th>SFTP/SCP:</th>
                <td>
					<p><em><?php _e( 'Resuming partial uploads is supported for SFTP, but not for SCP. Thus, if using SCP then you will need to ensure that your webserver allows PHP processes to run long enough to upload your largest backup file.', 'mainwp-updraftplus-extension' ); ?></em></p>
                </td>
                </tr>

                <tr class="mwp_updraftplusmethod sftp">
				<th><?php _e( 'Host', 'mainwp-updraftplus-extension' ); ?>:</th>
                <td>
					<input type="text" style="width: 292px" id="updraft_sftp_settings_host" name="mwp_updraft_sftp_settings[host]" value="<?php echo $host; ?>" />
                </td>
                </tr>

                <tr class="mwp_updraftplusmethod sftp">
				<th><?php _e( 'Port', 'mainwp-updraftplus-extension' ); ?>:</th>
                <td>
					<input type="text" style="width: 292px" id="updraft_sftp_settings_port" name="mwp_updraft_sftp_settings[port]" value="<?php echo $port; ?>" />
                </td>
                </tr>

                <tr class="mwp_updraftplusmethod sftp">
				<th><?php _e( 'Username', 'mainwp-updraftplus-extension' ); ?>:</th>
                <td>
					<input type="text" autocomplete="off" style="width: 292px" id="updraft_sftp_settings_user" name="mwp_updraft_sftp_settings[user]" value="<?php echo $user; ?>" />
                </td>
                </tr>

                <tr class="mwp_updraftplusmethod sftp">
				<th><?php _e( 'Password', 'mainwp-updraftplus-extension' ); ?>:</th>
                <td>
					<input type="<?php echo apply_filters( 'mainwp_updraftplus_admin_secret_field_type', 'text' ); ?>" autocomplete="off" style="width: 292px" id="updraft_sftp_settings_pass" name="mwp_updraft_sftp_settings[pass]" value="<?php echo $pass; ?>" />
					<br><em><?php _e( 'Your login may be either password or key-based - you only need to enter one, not both.', 'mainwp-updraftplus-extension' ); ?></em>
                </td>
                </tr>

                <tr class="mwp_updraftplusmethod sftp">
				<th><?php _e( 'Key', 'mainwp-updraftplus-extension' ); ?>:</th>
                <td>
					<textarea style="width: 292px; height: 120px;" id="updraft_sftp_settings_key" name="mwp_updraft_sftp_settings[key]"><?php echo htmlspecialchars( $key ); ?></textarea>
					<br><em><?php echo _x( 'PKCS1 (PEM header: BEGIN RSA PRIVATE KEY), XML and PuTTY format keys are accepted.', 'Do not translate BEGIN RSA PRIVATE KEY. PCKS1, XML, PEM and PuTTY are also technical acronyms which should not be translated.', 'mainwp-updraftplus-extension' ); ?></em>
                </td>
                </tr>

                <!--
                <tr class="mwp_updraftplusmethod sftp">
                <th>Fingerprint:</th>
                <td>
                    <input type="text" style="width: 292px" id="updraft_sftp_settings_fingerprint" name="mwp_updraft_sftp_settings[fingerprint]" value="$fingerprint" /><br><em>MD5 (128-bit) fingerprint, in hex format - should have the same length and general appearance as this (colons optional): 73:51:43:b1:b5:fc:8b:b7:0a:3a:a9:b1:0f:69:73:a8. Using a fingerprint is not essential, but you are not secure against <a href="http://en.wikipedia.org/wiki/Man-in-the-middle_attack">MITM attacks</a> if you do not use one</em>.
                </td>
                </tr>
                -->

                <tr class="mwp_updraftplusmethod sftp">
				<th><?php _e( 'Directory path', 'mainwp-updraftplus-extension' ); ?>:</th>
                <td>
					<input type="text" style="width: 292px" id="updraft_sftp_settings_path" name="mwp_updraft_sftp_settings[path]" value="<?php echo $path; ?>" /><br><em><?php _e( 'Where to change directory to after logging in - often this is relative to your home directory.', 'mainwp-updraftplus-extension' ); ?><br/><?php _e('Supported tokens', 'mainwp-updraftplus-extension') ?>: %sitename%, %siteurl%</em>
                </td>
                </tr>

                <tr class="mwp_updraftplusmethod sftp">
                <th>SCP:</th>
                <td>
					<input type="checkbox" id="updraft_sftp_settings_scp" name="mwp_updraft_sftp_settings[scp]" value="1"<?php if ( $scp ) { echo ' checked="checked"'; } ?>> <label for="updraft_sftp_settings_scp"><?php _e( 'Use SCP instead of SFTP', 'mainwp-updraftplus-extension' ); ?></label>
                </td>
                </tr>

                <tr class="mwp_updraftplusmethod sftp">
                <th></th>
				<td><p><button id="updraft-sftp-test" type="button" class="button-primary" style="font-size:18px !important"><?php echo sprintf( __( 'Test %s Settings', 'mainwp-updraftplus-extension' ), 'SFTP/SCP' ); ?></button></p></td>
                </tr>
				<?php
	}

	public function config_javascript() {
			?>
            jQuery('#updraft-sftp-test').click(function(){
			jQuery('#updraft-sftp-test').html('<?php echo esc_js( sprintf( __( 'Testing %s Settings...', 'mainwp-updraftplus-extension' ), 'SCP/SFTP' ) ); ?>');
                scp = jQuery('#updraft_sftp_settings_scp').is(':checked') ? 1 : 0;
                var data = {
                action: 'mainwp_updraft_ajax',
                subaction: 'credentials_test',
                method: 'sftp',
				nonce: '<?php echo wp_create_nonce( 'mwp-updraftplus-credentialtest-nonce' ); ?>',
                user: jQuery('#updraft_sftp_settings_user').val(),
                pass: jQuery('#updraft_sftp_settings_pass').val(),
                host: jQuery('#updraft_sftp_settings_host').val(),
                port: jQuery('#updraft_sftp_settings_port').val(),
                path: jQuery('#updraft_sftp_settings_path').val(),
                key: jQuery('#updraft_sftp_settings_key').val(),
                scp: scp,
                };
                //fingerprint: jQuery('#updraft_sftp_settings_fingerprint').val(),
                jQuery.post(ajaxurl, data, function(response) {
				jQuery('#updraft-sftp-test').html('<?php echo esc_js( sprintf( __( 'Test %s Settings', 'mainwp-updraftplus-extension' ), 'SCP/SFTP' ) ); ?>');
                if (scp) {
				alert('<?php echo esc_js( sprintf( __( '%s settings test result:', 'mainwp-updraftplus-extension' ), 'SCP' ) ); ?> ' + response);
                } else {
				alert('<?php echo esc_js( sprintf( __( '%s settings test result:', 'mainwp-updraftplus-extension' ), 'SFTP' ) ); ?> ' + response);
                }
                });
                });
				<?php
	}

	public function credentials_test() {
		if ( empty( $_POST['host'] ) ) {
				printf( __( 'Failure: No %s was given.', 'mainwp-updraftplus-extension' ), __( 'host name', 'mainwp-updraftplus-extension' ) );
				return;
		}
		if ( empty( $_POST['user'] ) ) {
				printf( __( 'Failure: No %s was given.', 'mainwp-updraftplus-extension' ), __( 'username', 'mainwp-updraftplus-extension' ) );
				return;
		}
		if ( empty( $_POST['pass'] ) && empty( $_POST['key'] ) ) {
				printf( __( 'Failure: No %s was given.', 'mainwp-updraftplus-extension' ), __( 'password/key', 'mainwp-updraftplus-extension' ) );
				return;
		}
			$port = empty( $_POST['port'] ) ? 22 : $_POST['port'];
		if ( ! is_numeric( $port ) ) {
				_e( 'Failure: Port must be an integer.', 'mainwp-updraftplus-extension' );
				;
				return;
		}
			$path = empty( $_POST['path'] ) ? '' : $_POST['path'];

			$fingerprint = empty( $_POST['fingerprint'] ) ? '' : $_POST['fingerprint'];

			$scp = empty( $_POST['scp'] ) ? 0 : 1;

			$host = $_POST['host'];
			$user = stripslashes( $_POST['user'] );
			$pass = (empty( $_POST['pass'] )) ? '' : stripslashes( $_POST['pass'] );
			$key = (empty( $_POST['key'] )) ? '' : stripslashes( $_POST['key'] );

			$sftp = $this->connect( $host, $port, $fingerprint, $user, $pass, $key, $scp );

		if ( is_wp_error( $sftp ) ) {
				_e( 'Failed', 'mainwp-updraftplus-extension' ) . ': ';
			foreach ( $sftp->get_error_messages() as $key => $msg ) {
					echo "$msg\n";
			}
				die;
		}

			// So far, so good
		if ( empty( $scp ) ) {
			if ( $path ) {
					@$sftp->mkdir( $path );
					// See if the directory now exists
				if ( ! $sftp->chdir( $path ) ) {
						echo __( 'Check your file permissions: Could not successfully create and enter:', 'mainwp-updraftplus-extension' ) . ' (' . htmlspecialchars( $path ) . ')';
						@$sftp->disconnect();
						die;
				}
			}
		} elseif ( $path ) {
				$this->ssh->exec( 'mkdir ' . escapeshellarg( $path ) );
		}

			$testfile = md5( time() . rand() );
		if ( ! empty( $scp ) && ! empty( $path ) ) {
				$testfile = trailingslashit( $path ) . $testfile; }
			// Now test uploading a file
			$putfile = $sftp->put( $testfile, 'test' );
		if ( empty( $scp ) ) {
				$sftp->delete( $testfile );
		} else {
				$this->ssh->exec( 'rm -f ' . escapeshellarg( $testfile ) );
		}

		if ( $putfile ) {
				_e( 'Success', 'mainwp-updraftplus-extension' );
		} else {
			if ( empty( $scp ) ) {
					_e( 'Failed: We were able to log in and move to the indicated directory, but failed to successfully create a file in that location.' );
			} else {
					_e( 'Failed: We were able to log in, but failed to successfully create a file in that location.' );
			}
		}

		if ( $this->scp ) {
				@$this->ssh->disconnect();
		} else {
				@$sftp->disconnect();
		}
			die;
	}
}

/*

  Adapted from http://www.solutionbot.com/2009/01/02/php-ftp-class/

  Our main tweaks to this class are to enable SSL with fallback for explicit encryption, and to provide rudimentary implicit support (the support for implicit is via Curl (since PHP's functions do not support it), and only extends to methods that we know we use).

  We somewhat crudely detect the request for implicit via use of port 990. But in the real world, it's unlikely we'll come across anything else - if we do, we can abstract a little more.

 */

class MainWP_Updraft_Plus_ftp_wrapper {

	private $conn_id;
	private $host;
	private $username;
	private $password;
	private $port;
	public $timeout = 60;
	public $passive = true;
		// Whether to *allow* (not necessarily require) SSL
	public $ssl = true;
	public $system_type = '';
	public $login_type = 'non-encrypted';
	public $use_server_certs = false;
	public $disable_verify = true;
	public $curl_handle;

	public function __construct( $host, $username, $password, $port = 21 ) {
			$this->host = $host;
			$this->username = $username;
			$this->password = $password;
			$this->port = $port;
	}

	public function connect() {

			// Implicit SSL - not handled via PHP's native ftp_ functions, so we use curl instead
		if ( $this->port == 990 || (defined( 'UPDRAFTPLUS_FTP_USECURL' ) && UPDRAFTPLUS_FTP_USECURL) ) {
			if ( $this->ssl == false ) {
					$this->port = 21;
			} else {
					$this->curl_handle = curl_init();
				if ( ! $this->curl_handle ) {
						$this->port = 21;
				} else {
						$options = array(
							CURLOPT_USERPWD => $this->username . ':' . $this->password,
							CURLOPT_PORT => $this->port,
							CURLOPT_CONNECTTIMEOUT => 20,
							// CURLOPT_TIMEOUT timeout is not just a "no-activity" timeout, but a total time limit on any Curl operation - undesirable
							// CURLOPT_TIMEOUT        => 20,
							CURLOPT_FTP_CREATE_MISSING_DIRS => true,
						);
						$options[ CURLOPT_FTP_SSL ] = CURLFTPSSL_TRY; //CURLFTPSSL_ALL, // require SSL For both control and data connections
						if ( 990 == $this->port ) {
								$options[ CURLOPT_FTPSSLAUTH ] = CURLFTPAUTH_SSL; // CURLFTPAUTH_DEFAULT, // let cURL choose the FTP authentication method (either SSL or TLS)
						} else {
								$options[ CURLOPT_FTPSSLAUTH ] = CURLFTPAUTH_DEFAULT; // let cURL choose the FTP authentication method (either SSL or TLS)
						}
						// Prints to STDERR by default - noisy
						if ( defined( 'WP_DEBUG' ) && WP_DEBUG == true && MainWP_Updraft_Plus_Options::get_updraft_option( 'updraft_debug_mode' ) ) {
								$options[ CURLOPT_VERBOSE ] = true;
						}
						if ( $this->disable_verify ) {
								$options[ CURLOPT_SSL_VERIFYPEER ] = false;
								$options[ CURLOPT_SSL_VERIFYHOST ] = 0;
						} else {
								$options[ CURLOPT_SSL_VERIFYPEER ] = true;
						}
						if ( ! $this->use_server_certs ) {
								$options[ CURLOPT_CAINFO ] = MAINWP_UPDRAFT_PLUS_DIR . '/includes/cacert.pem';
						}
						if ( $this->passive != true ) {
								$options[ CURLOPT_FTPPORT ] = '-'; }
						foreach ( $options as $option_name => $option_value ) {
							if ( ! curl_setopt( $this->curl_handle, $option_name, $option_value ) ) {
								//                          throw new Exception( sprintf( 'Could not set cURL option: %s', $option_name ) );
									global $mainwp_updraftplus;
								if ( is_a( $mainwp_updraftplus, 'UpdraftPlus' ) ) {
										$mainwp_updraftplus->log( 'Curl exception: will revert to normal FTP' );
								}
									$this->port = 21;
									$this->curl_handle = false;
							}
						}
				}
					// All done - leave
				if ( $this->curl_handle ) {
						$this->login_type = 'encrypted (implicit, port 990)';
						return true;
				}
			}
		}

			$time_start = time();
		if ( function_exists( 'ftp_ssl_connect' ) && $this->ssl !== false ) {
				$this->conn_id = ftp_ssl_connect( $this->host, $this->port, 15 );
				$attempting_ssl = true;
		}

		if ( $this->conn_id ) {
				$this->login_type = 'encrypted';
				$this->ssl = true;
		} else {
				$this->conn_id = ftp_connect( $this->host, $this->port, 15 );
		}

		if ( $this->conn_id ) {
				$result = ftp_login( $this->conn_id, $this->username, $this->password ); }

		if ( ! empty( $result ) ) {
				ftp_set_option( $this->conn_id, FTP_TIMEOUT_SEC, $this->timeout );
				ftp_pasv( $this->conn_id, $this->passive );
				$this->system_type = ftp_systype( $this->conn_id );
				return true;
		} elseif ( ! empty( $attempting_ssl ) ) {
				global $mainwp_updraftplus_admin;
			if ( isset( $mainwp_updraftplus_admin->logged ) && is_array( $mainwp_updraftplus_admin->logged ) ) {
					# Clear the previous PHP messages, so that we only show the user messages from the method that worked (or from both if both fail)
					$save_array = $mainwp_updraftplus_admin->logged;
					$mainwp_updraftplus_admin->logged = array();
					#trigger_error(__('Encrypted login failed; trying non-encrypted', 'mainwp-updraftplus-extension'), E_USER_NOTICE);
			}
				$this->ssl = false;
				$this->login_type = 'non-encrypted';
				$time_start = time();
				$this->conn_id = ftp_connect( $this->host, $this->port, 15 );
			if ( $this->conn_id ) {
					$result = ftp_login( $this->conn_id, $this->username, $this->password ); }
			if ( ! empty( $result ) ) {
					ftp_set_option( $this->conn_id, FTP_TIMEOUT_SEC, $this->timeout );
					ftp_pasv( $this->conn_id, $this->passive );
					$this->system_type = ftp_systype( $this->conn_id );
					return true;
			} else {
					# Add back the previous PHP messages
				if ( isset( $save_array ) ) {
						$mainwp_updraftplus_admin->logged = array_merge( $save_array, $mainwp_updraftplus_admin->logged ); }
			}
		}

			# If we got here, then we failed
		if ( time() - $time_start > 14 ) {
				global $mainwp_updraftplus_admin;
			if ( isset( $mainwp_updraftplus_admin->logged ) && is_array( $mainwp_updraftplus_admin->logged ) ) {
					$mainwp_updraftplus_admin->logged[] = sprintf( __( 'The %s connection timed out; if you entered the server correctly, then this is usually caused by a firewall blocking the connection - you should check with your web hosting company.', 'mainwp-updraftplus-extension' ), 'FTP' );
			} else {
					global $mainwp_updraftplus;
					$mainwp_updraftplus->log( sprintf( __( 'The %s connection timed out; if you entered the server correctly, then this is usually caused by a firewall blocking the connection - you should check with your web hosting company.', 'mainwp-updraftplus-extension' ), 'FTP' ), 'error' );
			}
		}

			return false;
	}

	function curl_progress_function( $download_size, $downloaded_size, $upload_size, $uploaded_size ) {

		if ( $uploaded_size < 1 ) {
				return; }

			global $mainwp_updraftplus;

			$percent = 100 * ($uploaded_size + $this->upload_from) / $this->upload_size;

			// Log every megabyte or at least every 20%
		if ( $percent > $this->upload_last_recorded_percent + 20 || $uploaded_size > $this->uploaded_bytes + 1048576 ) {
				$mainwp_updraftplus->record_uploaded_chunk( round( $percent, 1 ), '', $this->upload_local_path );
				$this->upload_last_recorded_percent = floor( $percent );
				$this->uploaded_bytes = $uploaded_size;
		}
	}

	public function put( $local_file_path, $remote_file_path, $mode = FTP_BINARY, $resume = false, $mainwp_updraftplus = false ) {

			$file_size = filesize( $local_file_path );

			$existing_size = 0;
		if ( $resume ) {

			if ( $this->curl_handle ) {
				if ( $this->curl_handle === true ) {
						$this->connect(); }
					curl_setopt( $this->curl_handle, CURLOPT_URL, 'ftps://' . $this->host . '/' . $remote_file_path );
					curl_setopt( $this->curl_handle, CURLOPT_NOBODY, true );
					curl_setopt( $this->curl_handle, CURLOPT_HEADER, false );

					// curl_setopt($this->curl_handle, CURLOPT_FORBID_REUSE, true);

					$getsize = curl_exec( $this->curl_handle );
				if ( $getsize ) {
						$sizeinfo = curl_getinfo( $this->curl_handle );
						$existing_size = $sizeinfo['download_content_length'];
				} else {
					if ( is_a( $mainwp_updraftplus, 'UpdraftPlus' ) ) {
							$mainwp_updraftplus->log( 'Curl: upload error: ' . curl_error( $this->curl_handle ) ); }
				}
			} else {
					$existing_size = ftp_size( $this->conn_id, $remote_file_path );
			}
				// In fact curl can return -1 as the value, for a non-existant file
			if ( $existing_size <= 0 ) {
					$resume = false;
					$existing_size = 0;
			} else {
				if ( is_a( $mainwp_updraftplus, 'UpdraftPlus' ) ) {
						$mainwp_updraftplus->log( "File already exists at remote site: size $existing_size. Will attempt resumption." ); }
				if ( $existing_size >= $file_size ) {
					if ( is_a( $mainwp_updraftplus, 'UpdraftPlus' ) ) {
							$mainwp_updraftplus->log( 'File is apparently already completely uploaded' ); }
						return true;
				}
			}
		}

			// From here on, $file_size is only used for logging calculations. We want to avoid divsion by zero.
			$file_size = max( $file_size, 1 );

		if ( ! $fh = fopen( $local_file_path, 'rb' ) ) {
				return false; }
		if ( $existing_size ) {
				fseek( $fh, $existing_size ); }

			// FTPS (i.e. implicit encryption)
		if ( $this->curl_handle ) {
				// Reset the curl object (because otherwise we get errors that make no sense)
				$this->connect();
			if ( version_compare( phpversion(), '5.3.0', '>=' ) ) {
					curl_setopt( $this->curl_handle, CURLOPT_PROGRESSFUNCTION, array( $this, 'curl_progress_function' ) );
					curl_setopt( $this->curl_handle, CURLOPT_NOPROGRESS, false );
			}
				$this->upload_local_path = $local_file_path;
				$this->upload_last_recorded_percent = 0;
				$this->upload_size = max( $file_size, 1 );
				$this->upload_from = $existing_size;
				$this->uploaded_bytes = $existing_size;
				curl_setopt( $this->curl_handle, CURLOPT_URL, 'ftps://' . $this->host . '/' . $remote_file_path );
			if ( $existing_size ) {
					curl_setopt( $this->curl_handle, CURLOPT_FTPAPPEND, true ); }

				// DOn't set CURLOPT_UPLOAD=true before doing the size check - it results in a bizarre error
				curl_setopt( $this->curl_handle, CURLOPT_UPLOAD, true );
				curl_setopt( $this->curl_handle, CURLOPT_INFILE, $fh );
				$output = curl_exec( $this->curl_handle );
				fclose( $fh );
			if ( is_a( $mainwp_updraftplus, 'UpdraftPlus' ) && ! $output ) {
					$mainwp_updraftplus->log( 'FTPS error: ' . curl_error( $this->curl_handle ) );
			} elseif ( true === $mainwp_updraftplus && ! $output ) {
					echo __( 'Error:', 'mainwp-updraftplus-extension' ) . ' ' . curl_error( $this->curl_handle ) . "\n";
			}
				// Mark as used
				$this->curl_handle = true;
				return $output;
		}

			$ret = ftp_nb_fput( $this->conn_id, $remote_file_path, $fh, FTP_BINARY, $existing_size );

			// $existing_size can now be re-purposed

		while ( FTP_MOREDATA == $ret ) {
			if ( is_a( $mainwp_updraftplus, 'UpdraftPlus' ) ) {
					$new_size = ftell( $fh );
				if ( $new_size - $existing_size > 524288 ) {
						$existing_size = $new_size;
						$percent = round( 100 * $new_size / $file_size, 1 );
						$mainwp_updraftplus->record_uploaded_chunk( $percent, '', $local_file_path );
				}
			}
				// Continue upload
				$ret = ftp_nb_continue( $this->conn_id );
		}

			fclose( $fh );

		if ( FTP_FINISHED != $ret ) {
			if ( is_a( $mainwp_updraftplus, 'UpdraftPlus' ) ) {
					$mainwp_updraftplus->log( "FTP upload: error ($ret)" ); }
				return false;
		}

			return true;
	}

	public function get( $local_file_path, $remote_file_path, $mode = FTP_BINARY, $resume = false, $mainwp_updraftplus = false ) {

			$file_last_size = 0;

		if ( $resume ) {
			if ( ! $fh = fopen( $local_file_path, 'ab' ) ) {
					return false; }
				clearstatcache( $local_file_path );
				$file_last_size = filesize( $local_file_path );
		} else {
			if ( ! $fh = fopen( $local_file_path, 'wb' ) ) {
					return false; }
		}

			// Implicit FTP, for which we use curl (since PHP's native FTP functions don't handle implicit FTP)
		if ( $this->curl_handle ) {
			if ( $resume ) {
					curl_setopt( $this->curl_handle, CURLOPT_RESUME_FROM, $resume ); }
				curl_setopt( $this->curl_handle, CURLOPT_NOBODY, false );
				curl_setopt( $this->curl_handle, CURLOPT_URL, 'ftps://' . $this->host . '/' . $remote_file_path );
				curl_setopt( $this->curl_handle, CURLOPT_UPLOAD, false );
				curl_setopt( $this->curl_handle, CURLOPT_FILE, $fh );
				$output = curl_exec( $this->curl_handle );
			if ( $output ) {
				if ( $mainwp_updraftplus ) {
						$mainwp_updraftplus->log( 'FTP fetch: fetch complete' ); }
			} else {
				if ( $mainwp_updraftplus ) {
						$mainwp_updraftplus->log( 'FTP fetch: fetch failed' ); }
			}
				return $output;
		}

			$ret = ftp_nb_fget( $this->conn_id, $fh, $remote_file_path, $mode, $file_last_size );

		if ( false == $ret ) {
				return false; }

		while ( FTP_MOREDATA == $ret ) {

			if ( $mainwp_updraftplus ) {
					$file_now_size = filesize( $local_file_path );
				if ( $file_now_size - $file_last_size > 524288 ) {
						$mainwp_updraftplus->log( 'FTP fetch: file size is now: ' . sprintf( '%0.2f', filesize( $local_file_path ) / 1048576 ) . ' Mb' );
						$file_last_size = $file_now_size;
				}
					clearstatcache();
			}

				$ret = ftp_nb_continue( $this->conn_id );
		}

			fclose( $fh );

		if ( FTP_FINISHED == $ret ) {
			if ( $mainwp_updraftplus ) {
					$mainwp_updraftplus->log( 'FTP fetch: fetch complete' ); }
				return true;
		} else {
			if ( $mainwp_updraftplus ) {
					$mainwp_updraftplus->log( 'FTP fetch: fetch failed' ); }
				return false;
		}
	}

	public function chmod( $permissions, $remote_filename ) {
		if ( $this->is_octal( $permissions ) ) {
				$result = ftp_chmod( $this->conn_id, $permissions, $remote_filename );
				return ($result) ? true : false;
		} else {
				throw new Exception( '$permissions must be an octal number' );
		}
	}

	public function chdir( $directory ) {
			ftp_chdir( $this->conn_id, $directory );
	}

	public function delete( $remote_file_path ) {

		if ( $this->curl_handle ) {
			if ( $this->curl_handle === true ) {
					$this->connect(); }
				curl_setopt( $this->curl_handle, CURLOPT_URL, 'ftps://' . $this->host . '/' . $remote_file_path );
				curl_setopt( $this->curl_handle, CURLOPT_RETURNTRANSFER, true );
				curl_setopt( $this->curl_handle, CURLOPT_QUOTE, array( 'DELE ' . $remote_file_path ) );
				// Unset some (possibly) previously-set options
				curl_setopt( $this->curl_handle, CURLOPT_UPLOAD, false );
				curl_setopt( $this->curl_handle, CURLOPT_INFILE, STDIN );
				$output = curl_exec( $this->curl_handle );
				return $output;
		}

			return (ftp_delete( $this->conn_id, $remote_file_path )) ? true : false;
	}

	public function make_dir( $directory ) {
		if ( ftp_mkdir( $this->conn_id, $directory ) ) {
				return true;
		} else {
				return false;
		}
	}

	public function rename( $old_name, $new_name ) {
		if ( ftp_rename( $this->conn_id, $old_name, $new_name ) ) {
				return true;
		} else {
				return false;
		}
	}

	public function remove_dir( $directory ) {
			return ftp_rmdir( $this->conn_id, $directory );
	}

	public function dir_list( $directory ) {
		if ( $this->curl_handle ) {
				# Can't get this to work - it might just be the vsftpd server I am testing on; it hangs strangely. But this means I can't test it.
				return new WP_Error( 'unsupported_op', sprintf( __( 'The UpdraftPlus module for this file access method (%s) does not support listing files', 'mainwp-updraftplus-extension' ), 'FTP (SSL/Implicit)' ) );
			if ( $this->curl_handle === true ) {
					$this->connect(); }
				curl_setopt( $this->curl_handle, CURLOPT_URL, 'ftps://' . $this->host . '/' . trailingslashit( $directory ) );
				curl_setopt( $this->curl_handle, CURLOPT_RETURNTRANSFER, true );
				#           curl_setopt($this->curl_handle, CURLOPT_FTPLISTONLY, true);
				//          curl_setopt($this->curl_handle, CURLOPT_POSTQUOTE, array('LIST'));
				curl_setopt( $this->curl_handle, CURLOPT_TIMEOUT, 10 );
				$output = curl_exec( $this->curl_handle );
				return $output;
		}

			return ftp_nlist( $this->conn_id, $directory );
	}

	public function cdup() {
			return ftp_cdup( $this->conn_id );
	}

	public function size( $f ) {
			return ($this->curl_handle) ? false : ftp_size( $this->conn_id, $f );
	}

	public function current_dir() {
			return ftp_pwd( $this->conn_id );
	}

	private function is_octal( $i ) {
			return decoct( octdec( $i ) ) == $i;
	}

	public function __destruct() {
		if ( $this->conn_id ) {
				ftp_close( $this->conn_id ); }
	}
}
