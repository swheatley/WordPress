<?php
if ( ! defined( 'MAINWP_UPDRAFT_PLUS_DIR' ) ) {
		die( 'No direct access allowed.' ); }

# Migrate options to new-style storage - Jan 2014
// This class is used by both MainWP_Updraft_Plus_S3 and MainWP_Updraft_Plus_S3_Compat

class MainWP_Updraft_Plus_S3Exception extends Exception {

	function __construct( $message, $file, $line, $code = 0 ) {
			parent::__construct( $message, $code );
			$this->file = $file;
			$this->line = $line;
	}
}

class MainWP_Updraft_Plus_BackupModule_s3 {

	private $s3_object;

	protected function get_config() {
			global $mainwp_updraftplus;
			$opts = MainWP_Updraft_Plus_Options::get_updraft_option( 'updraft_s3' );  //$mainwp_updraftplus->get_job_option('updraft_s3');
		if ( ! is_array( $opts ) ) {
				$opts = array( 'accesskey' => '', 'secretkey' => '', 'path' => '' ); }
			$opts['whoweare'] = 'S3';
			$opts['whoweare_long'] = 'Amazon S3';
			$opts['key'] = 's3';
			return $opts;
	}

	public function get_credentials() {
			return array( 'updraft_s3' );
	}

	protected function indicate_s3_class() {
			// N.B. : The classes must have different names, as if multiple remote storage options are chosen, then we could theoretically need both (if both Amazon and a compatible-S3 provider are used)
			// Conditional logic, for new AWS SDK

			$opts = $this->get_config();
			$class_to_use = 'MainWP_Updraft_Plus_S3';
		if ( version_compare( PHP_VERSION, '5.3.3', '>=' ) && ! empty( $opts['key'] ) && 's3' == $opts['key'] && ( ! defined( 'UPDRAFTPLUS_S3_OLDLIB' ) || ! UPDRAFTPLUS_S3_OLDLIB) ) {
				$class_to_use = 'MainWP_Updraft_Plus_S3_Compat';
		}

		if ( 'MainWP_Updraft_Plus_S3_Compat' == $class_to_use ) {
			if ( ! class_exists( $class_to_use ) ) {
					require_once( MAINWP_UPDRAFT_PLUS_DIR . '/includes/S3compat.php' ); }
		} else {
			if ( ! class_exists( $class_to_use ) ) {
					require_once( MAINWP_UPDRAFT_PLUS_DIR . '/includes/S3.php' ); }
		}
			return $class_to_use;
	}

		// Get an S3 object, after setting our options
	protected function get_s3( $key, $secret, $useservercerts, $disableverify, $nossl ) {

		if ( ! empty( $this->s3_object ) && ! is_wp_error( $this->s3_object ) ) {
				return $this->s3_object; }

		if ( '' == $key || '' == $secret ) {
				return new WP_Error( 'no_settings', __( 'No settings were found', 'mainwp-updraftplus-extension' ) ); }

			global $mainwp_updraftplus;

			$use_s3_class = $this->indicate_s3_class();

		if ( ! class_exists( 'WP_HTTP_Proxy' ) ) {
				require_once( ABSPATH . WPINC . '/class-http.php' ); }
			$proxy = new WP_HTTP_Proxy();

			$use_ssl = true;
			$ssl_ca = true;
		if ( ! $nossl ) {
				$curl_version = (function_exists( 'curl_version' )) ? curl_version() : array( 'features' => null );
				$curl_ssl_supported = ($curl_version['features'] & CURL_VERSION_SSL);
			if ( $curl_ssl_supported ) {
				if ( $disableverify ) {
						$ssl_ca = false;
						//$s3->setSSL(true, false);
						$mainwp_updraftplus->log( 'S3: Disabling verification of SSL certificates' );
				} else {
					if ( $useservercerts ) {
							$mainwp_updraftplus->log( "S3: Using the server's SSL certificates" );
							$ssl_ca = 'system';
					} else {
							$ssl_ca = file_exists( MAINWP_UPDRAFT_PLUS_DIR . '/includes/cacert.pem' ) ? MAINWP_UPDRAFT_PLUS_DIR . '/includes/cacert.pem' : true;
					}
				}
			} else {
					$use_ssl = false;
					$mainwp_updraftplus->log( 'S3: Curl/SSL is not available. Communications will not be encrypted.' );
			}
		} else {
				$use_ssl = false;
				$mainwp_updraftplus->log( "SSL was disabled via the user's preference. Communications will not be encrypted." );
		}

		try {
				$s3 = new $use_s3_class($key, $secret, $use_ssl, $ssl_ca);
		} catch (Exception $e) {
				$mainwp_updraftplus->log( sprintf( __( '%s Error: Failed to initialise', 'mainwp-updraftplus-extension' ), 'S3' ) . ': ' . $e->getMessage() . ' (line: ' . $e->getLine() . ', file: ' . $e->getFile() . ')' );
				$mainwp_updraftplus->log( sprintf( __( '%s Error: Failed to initialise', 'mainwp-updraftplus-extension' ), $key ), 'S3' );
				return new WP_Error( 's3_init_failed', sprintf( __( '%s Error: Failed to initialise', 'mainwp-updraftplus-extension' ), 'S3' ) . ': ' . $e->getMessage() . ' (line: ' . $e->getLine() . ', file: ' . $e->getFile() . ')' );
		}

		if ( $proxy->is_enabled() ) {
				# WP_HTTP_Proxy returns empty strings where we want nulls
				$user = $proxy->username();
			if ( empty( $user ) ) {
						$user = null;
						$pass = null;
			} else {
					$pass = $proxy->password();
				if ( empty( $pass ) ) {
						$pass = null; }
			}
				$port = (int) $proxy->port();
			if ( empty( $port ) ) {
					$port = 8080; }
				$s3->setProxy( $proxy->host(), $user, $pass, CURLPROXY_HTTP, $port );
		}

			// Old: from before we passed the SSL options when getting the object
			//      if (!$nossl) {
			//          $curl_version = (function_exists('curl_version')) ? curl_version() : array('features' => null);
			//          $curl_ssl_supported = ($curl_version['features'] & CURL_VERSION_SSL);
			//          if ($curl_ssl_supported) {
			//              if ($disableverify) {
			//                  $s3->setSSL(true, false);
			//                  $mainwp_updraftplus->log("S3: Disabling verification of SSL certificates");
			//              } else {
			//                  $s3->setSSL(true, true);
			//              }
			//              if ($useservercerts) {
			//                  $mainwp_updraftplus->log("S3: Using the server's SSL certificates");
			//              } else {
			//                  $s3->setSSLAuth(null, null, MAINWP_UPDRAFT_PLUS_DIR.'/includes/cacert.pem');
			//              }
			//          } else {
			//              $s3->setSSL(false, false);
			//              $mainwp_updraftplus->log("S3: Curl/SSL is not available. Communications will not be encrypted.");
			//          }
			//      } else {
			//          $s3->setSSL(false, false);
			//          $mainwp_updraftplus->log("SSL was disabled via the user's preference. Communications will not be encrypted.");
			//      }

			$this->s3_object = $s3;

			return $this->s3_object;
	}

	protected function set_region( $obj, $region ) {
		
	}

	public function backup( $backup_array ) {

	}

	public function listfiles( $match = 'backup_' ) {

	}

	public function delete( $files, $s3arr = false ) {

			
	}

	public function download( $file ) {

	}

	public function config_print_javascript_onready() {
			$this->config_print_javascript_onready_engine( 's3', 'S3' );
	}

	public function config_print_javascript_onready_engine( $key, $whoweare ) {
			?>
			jQuery('#updraft-<?php echo $key; ?>-test').click(function(){
				jQuery('#updraft-<?php echo $key; ?>-test').html('<?php echo esc_js( sprintf( __( 'Testing %s Settings...', 'mainwp-updraftplus-extension' ), $whoweare ) ); ?>');
				var data = {
				action: 'mainwp_updraft_ajax',
				subaction: 'credentials_test',
				method: '<?php echo $key; ?>',
				nonce: '<?php echo wp_create_nonce( 'mwp-updraftplus-credentialtest-nonce' ); ?>',
				apikey: jQuery('#updraft_<?php echo $key; ?>_apikey').val(),
				apisecret: jQuery('#updraft_<?php echo $key; ?>_apisecret').val(),
				path: jQuery('#updraft_<?php echo $key; ?>_path').val(),
				endpoint: jQuery('#updraft_<?php echo $key; ?>_endpoint').val(),
				disableverify: (jQuery('#updraft_ssl_disableverify').is(':checked')) ? 1 : 0,
				useservercerts: (jQuery('#updraft_ssl_useservercerts').is(':checked')) ? 1 : 0,
				nossl: (jQuery('#updraft_ssl_nossl').is(':checked')) ? 1 : 0,
				};
				jQuery.post(ajaxurl, data, function(response) {
				jQuery('#updraft-<?php echo $key; ?>-test').html('<?php echo esc_js( sprintf( __( 'Test %s Settings', 'mainwp-updraftplus-extension' ), $whoweare ) ); ?>');
				alert('<?php echo esc_js( sprintf( __( '%s settings test result:', 'mainwp-updraftplus-extension' ), $whoweare ) ); ?> ' + response);
				});
				});
				<?php
	}

	public function config_print() {

			# White: https://d36cz9buwru1tt.cloudfront.net/Powered-by-Amazon-Web-Services.jpg
			$this->config_print_engine( 's3', 'S3', 'Amazon S3', 'AWS', 'https://aws.amazon.com/console/', '<img src="//awsmedia.s3.amazonaws.com/AWS_logo_poweredby_black_127px.png" alt="Amazon Web Services">' );
	}

	public function config_print_engine( $key, $whoweare_short, $whoweare_long, $console_descrip, $console_url, $img_html = '', $include_endpoint_chooser = false ) {

			$opts = $this->get_config();
			?>
			<tr class="mwp_updraftplusmethod <?php echo $key; ?>">
				<td></td>
				<td><?php echo $img_html ?><p><em><?php printf( __( '%s is a great choice, because UpdraftPlus supports chunked uploads - no matter how big your site is, UpdraftPlus can upload it a little at a time, and not get thwarted by timeouts.', 'mainwp-updraftplus-extension' ), $whoweare_long ); ?></em></p>
					<?php
					if ( 's3generic' == $key ) {
							_e( 'Examples of S3-compatible storage providers:' ) . ' ';
							echo '<a href="http://www.cloudian.com/">Cloudian</a>, ';
							echo '<a href="http://cloud.google.com/storage">Google Cloud Storage</a>, ';
							echo '<a href="https://www.mh.connectria.com/rp/order/cloud_storage_index">Connectria</a>, ';
							echo '<a href="http://www.constant.com/cloud/storage/">Constant</a>, ';
							echo '<a href="http://www.eucalyptus.com/eucalyptus-cloud/iaas">Eucalyptus</a>, ';
							echo '<a href="http://cloud.nifty.com/storage/">Nifty</a>, ';
							echo '<a href="http://www.ntt.com/cloudn/data/storage.html">Cloudn</a>';
							echo '' . __( '... and many more!', 'mainwp-updraftplus-extension' ) . '<br>';
					}
					?>
					</td>
				</tr>
				<tr class="mwp_updraftplusmethod <?php echo $key; ?>">
					<th></th>
					<td>
						<?php
						global $mainwp_updraftplus_admin;
						if ( ! class_exists( 'SimpleXMLElement' ) ) {
								//$mainwp_updraftplus_admin->show_double_warning('<strong>'.__('Warning','mainwp-updraftplus-extension').':</strong> '.sprintf(__("Your web server's PHP installation does not included a required module (%s). Please contact your web hosting provider's support.", 'mainwp-updraftplus-extension'), 'SimpleXMLElement').' '.sprintf(__("UpdraftPlus's %s module <strong>requires</strong> %s. Please do not file any support requests; there is no alternative.",'mainwp-updraftplus-extension'),$whoweare_long, 'SimpleXMLElement'), $key);
						}
						//$mainwp_updraftplus_admin->curl_check($whoweare_long, true, $key);
						?>

					</td>
				</tr>
				<tr class="mwp_updraftplusmethod <?php echo $key; ?>">
					<th></th>
					<td>
						<p><?php if ( $console_url ) { echo sprintf( __( 'Get your access key and secret key <a href="%s">from your %s console</a>, then pick a (globally unique - all %s users) bucket name (letters and numbers) (and optionally a path) to use for storage. This bucket will be created for you if it does not already exist.', 'mainwp-updraftplus-extension' ), $console_url, $console_descrip, $whoweare_long ); } ?> <a href="http://updraftplus.com/faqs/i-get-ssl-certificate-errors-when-backing-up-andor-restoring/"><?php _e( 'If you see errors about SSL certificates, then please go here for help.', 'mainwp-updraftplus-extension' ); ?></a> <a href="http://updraftplus.com/faq-category/amazon-s3/"><?php if ( 's3' == $key ) { echo sprintf( __( 'Other %s FAQs.', 'mainwp-updraftplus-extension' ), 'S3' ); } ?></a></p>
					</td></tr>
				<?php if ( $include_endpoint_chooser ) { ?>
						<tr class="mwp_updraftplusmethod <?php echo $key; ?>">
							<th><?php echo sprintf( __( '%s end-point', 'mainwp-updraftplus-extension' ), $whoweare_short ); ?>:</th>
							<td><input type="text" style="width: 360px" id="updraft_<?php echo $key; ?>_endpoint" name="mwp_updraft_<?php echo $key; ?>[endpoint]" value="<?php if ( ! empty( $opts['endpoint'] ) ) { echo esc_attr( $opts['endpoint'] ); } ?>" /></td>
						</tr>
				<?php } else { ?>
						<input type="hidden" id="updraft_<?php echo $key; ?>_endpoint" name="mwp_updraft_<?php echo $key; ?>_endpoint" value="">
				<?php } ?>
				<tr class="mwp_updraftplusmethod <?php echo $key; ?>">
					<th><?php echo sprintf( __( '%s access key', 'mainwp-updraftplus-extension' ), $whoweare_short ); ?>:</th>
					<td><input type="text" autocomplete="off" style="width: 360px" id="updraft_<?php echo $key; ?>_apikey" name="mwp_updraft_<?php echo $key; ?>[accesskey]" value="<?php echo esc_attr( $opts['accesskey'] ); ?>" /></td>
				</tr>
				<tr class="mwp_updraftplusmethod <?php echo $key; ?>">
					<th><?php echo sprintf( __( '%s secret key', 'mainwp-updraftplus-extension' ), $whoweare_short ); ?>:</th>
					<td><input type="<?php echo apply_filters( 'mainwp_updraftplus_admin_secret_field_type', 'text' ); ?>" autocomplete="off" style="width: 360px" id="updraft_<?php echo $key; ?>_apisecret" name="mwp_updraft_<?php echo $key; ?>[secretkey]" value="<?php echo esc_attr( $opts['secretkey'] ); ?>" /></td>
				</tr>
				<tr class="mwp_updraftplusmethod <?php echo $key; ?>">
					<th><?php echo sprintf( __( '%s location', 'mainwp-updraftplus-extension' ), $whoweare_short ); ?>:</th>
                                        <td><?php echo $key; ?>://<input title="<?php echo htmlspecialchars( __( 'Enter only a bucket name or a bucket and path. Examples: mybucket, mybucket/mypath', 'mainwp-updraftplus-extension' ) ); ?>" type="text" style="width: 360px" name="mwp_updraft_<?php echo $key; ?>[path]" id="updraft_<?php echo $key; ?>_path" value="<?php echo esc_attr( $opts['path'] ); ?>" /><br/><em><?php _e('Supported tokens', 'mainwp-updraftplus-extension') ?>: %sitename%, %siteurl%</em></td>
				</tr>
				<?php do_action( 'mainwp_updraft_' . $key . '_extra_storage_options', $opts ); ?>
				<tr class="mwp_updraftplusmethod <?php echo $key; ?>">
					<th></th>
					<td><p><button id="updraft-<?php echo $key; ?>-test" type="button" class="button-primary" ><?php echo htmlspecialchars( sprintf( __( 'Test %s Settings', 'mainwp-updraftplus-extension' ), $whoweare_short ) ); ?></button></p></td>
				</tr>

				<?php
	}

	public function credentials_test() {
			return $this->credentials_test_engine( $this->get_config() );
	}

	public function credentials_test_engine( $config ) {

		if ( empty( $_POST['apikey'] ) ) {
				printf( __( 'Failure: No %s was given.', 'mainwp-updraftplus-extension' ), __( 'API key', 'mainwp-updraftplus-extension' ) );
				return;
		}
		if ( empty( $_POST['apisecret'] ) ) {
				printf( __( 'Failure: No %s was given.', 'mainwp-updraftplus-extension' ), __( 'API secret', 'mainwp-updraftplus-extension' ) );
				return;
		}

			$key = $_POST['apikey'];
			$secret = stripslashes( $_POST['apisecret'] );
			$path = $_POST['path'];
			$useservercerts = (isset( $_POST['useservercerts'] )) ? absint( $_POST['useservercerts'] ) : 0;
			$disableverify = (isset( $_POST['disableverify'] )) ? absint( $_POST['disableverify'] ) : 0;
			$nossl = (isset( $_POST['nossl'] )) ? absint( $_POST['nossl'] ) : 0;
			$endpoint = (isset( $_POST['endpoint'] )) ? $_POST['endpoint'] : '';

		if ( preg_match( '#^/*([^/]+)/(.*)$#', $path, $bmatches ) ) {
				$bucket = $bmatches[1];
				$path = trailingslashit( $bmatches[2] );
		} else {
				$bucket = $path;
				$path = '';
		}

		if ( empty( $bucket ) ) {
				_e( 'Failure: No bucket details were given.', 'mainwp-updraftplus-extension' );
				return;
		}
			$whoweare = $config['whoweare'];

			$s3 = $this->get_s3( $key, $secret, $useservercerts, $disableverify, $nossl );
		if ( is_wp_error( $s3 ) ) {
			foreach ( $s3->get_error_messages() as $msg ) {
					echo $msg . "\n";
			}
				return;
		}

			$location = ('s3' == $config['key']) ? @$s3->getBucketLocation( $bucket ) : 'n/a';
		if ( 's3' != $config['key'] ) {
				$this->set_region( $s3, $endpoint ); }

		if ( $location && 'n/a' != $location ) {
			if ( 's3' == $config['key'] ) {
					$bucket_exists = true;
					$bucket_verb = __( 'Region', 'mainwp-updraftplus-extension' ) . ": $location: ";
			} else {
					$bucket_verb = '';
			}
		}

			# Saw one case where there was read/write permission, but no permission to get the location - yet the bucket did exist. Try to detect that.
		if ( ! isset( $bucket_exists ) && 's3' == $config['key'] ) {
				$s3->useDNSBucketName( true );
				$gb = @$s3->getBucket( $bucket, null, null, 1 );
			if ( false !== $gb ) {
					$bucket_exists = true;
					$location = '';
					$bucket_verb = '';
			}
		}

		if ( ! isset( $bucket_exists ) ) {
				$s3->setExceptions( true );
			try {
					$try_to_create_bucket = @$s3->putBucket( $bucket, 'private' );
			} catch (Exception $e) {
					$try_to_create_bucket = false;
					$s3_error = $e->getMessage();
			}
				$s3->setExceptions( false );
			if ( $try_to_create_bucket ) {
					$bucket_verb = '';
					$bucket_exists = true;
			} else {
					echo sprintf( __( 'Failure: We could not successfully access or create such a bucket. Please check your access credentials, and if those are correct then try another bucket name (as another %s user may already have taken your name).', 'mainwp-updraftplus-extension' ), $whoweare );
				if ( isset( $s3_error ) ) {
						echo "\n\n" . sprintf( __( 'The error reported by %s was:', 'mainwp-updraftplus-extension' ), $config['key'] ) . ' ' . $s3_error; }
			}
		}

		if ( isset( $bucket_exists ) ) {
				$try_file = md5( rand() );
			if ( 'dreamobjects' != $config['key'] && 's3generic' != $config['key'] ) {
					$this->set_region( $s3, $location ); }
				$s3->setExceptions( true );
			try {
				if ( ! $s3->putObjectString( $try_file, $bucket, $path . $try_file ) ) {
						echo __( 'Failure', 'mainwp-updraftplus-extension' ) . ": ${bucket_verb}" . __( 'We successfully accessed the bucket, but the attempt to create a file in it failed.', 'mainwp-updraftplus-extension' );
				} else {
						echo __( 'Success', 'mainwp-updraftplus-extension' ) . ": ${bucket_verb}" . __( 'We accessed the bucket, and were able to create files within it.', 'mainwp-updraftplus-extension' ) . ' ';
						$comm_with = ('s3generic' == $config['key']) ? $endpoint : $config['whoweare_long'];
					if ( $s3->getuseSSL() ) {
							echo sprintf( __( 'The communication with %s was encrypted.', 'mainwp-updraftplus-extension' ), $comm_with );
					} else {
							echo sprintf( __( 'The communication with %s was not encrypted.', 'mainwp-updraftplus-extension' ), $comm_with );
					}
						@$s3->deleteObject( $bucket, $path . $try_file );
				}
			} catch (Exception $e) {
					echo __( 'Failure', 'mainwp-updraftplus-extension' ) . ": ${bucket_verb}" . __( 'We successfully accessed the bucket, but the attempt to create a file in it failed.', 'mainwp-updraftplus-extension' ) . ' ' . __( 'Please check your access credentials.', 'mainwp-updraftplus-extension' ) . ' (' . $e->getMessage() . ')';
			}
		}
	}
}
