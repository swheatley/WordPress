<?php
/*
  UpdraftPlus Addon: reporting:Sophisticated reporting options
  Description: Provides various new reporting capabilities
  Version: 1.7
  Shop: /shop/reporting/
  Latest Change: 1.9.32
 */

# Future possibility: more reporting options; e.g. HTTP ping; tweet, etc.

if ( ! defined( 'MAINWP_UPDRAFT_PLUS_DIR' ) ) {
		die( 'No direct access allowed' ); }

$mainwp_updraft_plus_addon_reporting = new MainWP_Updraft_Plus_Addon_Reporting;

class MainWP_Updraft_Plus_Addon_Reporting {

	private $emails;
	private $warningsonly;
	private $history;
	private $syslog;

	public function __construct() {
			add_filter( 'mainwp_updraftplus_showbackup_date', array( $this, 'showbackup_date' ), 10, 2 );
			add_filter( 'mainwp_updraft_backupnow_options', array( $this, 'backupnow_options' ) );
			add_filter( 'mainwp_updraftplus_report_form', array( $this, 'updraftplus_report_form' ) );
			add_filter( 'mainwp_updraftplus_saveemails', array( $this, 'saveemails' ), 10, 2 );
			add_filter( 'mainwp_updraft_report_sendto', array( $this, 'updraft_report_sendto' ), 10, 5 );
			add_filter( 'mainwp_updraftplus_email_whichaddresses', array( $this, 'email_whichaddresses' ) );
			add_filter( 'mainwp_updraftplus_email_wholebackup', array( $this, 'email_wholebackup' ), 10, 3 );
			add_filter( 'mainwp_updraft_report_subject', array( $this, 'updraft_report_subject' ), 10, 3 );
			add_filter( 'mainwp_updraft_report_body', array( $this, 'updraft_report_body' ), 10, 6 );
			add_filter( 'mainwp_updraft_report_attachments', array( $this, 'updraft_report_attachments' ) );
			add_action( 'mainwp_updraft_backupnow_modal_afteroptions', array( $this, 'backupnow_modal_afteroptions' ) );
			add_action( 'mainwp_updraft_final_backup_history', array( $this, 'final_backup_history' ) );
			add_action( 'mainwp_updraft_report_finished', array( $this, 'report_finished' ) );
			add_action( 'init', array( $this, 'init' ) );
			$this->log_ident = (defined( 'UPDRAFTPLUS_LOG_IDENT' )) ? UPDRAFTPLUS_LOG_IDENT : 'mainwp-updraftplus-extension';
			$this->log_facility = (defined( 'UPDRAFTPLUS_LOG_FACILITY' )) ? UPDRAFTPLUS_LOG_FACILITY : LOG_USER;
	}

	public function init() {
		if ( ! MainWP_Updraft_Plus_Options::get_updraft_option( 'updraft_log_syslog', false ) || ! function_exists( 'openlog' ) || ! function_exists( 'syslog' ) ) {
				return; }
		if ( false !== ($this->syslog = openlog( $this->log_ident, LOG_ODELAY | LOG_PID, $this->log_facility )) ) {
				add_filter( 'mainwp_updraftplus_logline', array( $this, 'logline' ), 10, 3 ); }
	}

	public function showbackup_date( $date, $backup ) {
		if ( ! is_array( $backup ) || empty( $backup['label'] ) ) {
				return $date; }
			return $date . '<br>' . htmlspecialchars( $backup['label'] );
	}

	public function backupnow_modal_afteroptions() {
			?>
			<p>
				<label for="backupnow_label"><?php _e( 'Your label for this backup (optional)', 'mainwp-updraftplus-extension' ); ?>:</label> <input type="text" id="backupnow_label" name="label" size="40" maxlength="40">
				</p>
				<?php
	}

	public function backupnow_options( $options ) {
		if ( ! is_array( $options ) ) {
				return $options; }
		if ( ! empty( $_REQUEST['backupnow_label'] ) && is_string( $_REQUEST['backupnow_label'] ) ) {
				$options['label'] = substr( $_REQUEST['backupnow_label'], 0, 40 ); }
			return $options;
	}

	public function logline( $line, $nonce, $level ) {
			# See http://php.net/manual/en/function.syslog.php for descriptions of the log level meanings
		if ( 'error' == $level ) {
				$pri = LOG_WARNING;
		} elseif ( 'warning' == $level ) {
				$pri = LOG_NOTICE;
		} else {
				$pri = LOG_INFO;
		}
			@syslog( $pri, "($nonce) $line" );
	}

	public function final_backup_history( $history ) {
			$this->history = $history;
	}

	public function updraft_report_attachments( $attachments ) {
			// Always attach the log file
			global $mainwp_updraftplus;
			$attachments[0] = $mainwp_updraftplus->logfile_name;
			return $attachments;
	}

		# Jobdata is passed in, rather than live, because the live jobdata may have moved on from the time which the point should reflectg (e.g. an incremental backup was subsequently started)

	public function updraft_report_body( $report, $final_message, $contains, $errors, $warnings, $jobdata ) {
			global $mainwp_updraftplus;

			$rep = '';

			$error_count = 0;
		foreach ( $errors as $err ) {
			if ( (is_string( $err ) || is_wp_error( $err )) || (is_array( $err ) && 'error' == $err['level']) ) {
					$error_count++;
			}
		}
			$warning_count = count( $warnings );

			$history = $this->history;
			$debug = MainWP_Updraft_Plus_Options::get_updraft_option( 'updraft_debug_mode' );

			$errors_and_warns = sprintf( __( '%d errors, %d warnings', 'mainwp-updraftplus-extension' ), $error_count, $warning_count );

			$file_entities = $mainwp_updraftplus->get_backupable_file_entities( true, true );

			$date = get_date_from_gmt( gmdate( 'Y-m-d H:i:s', $jobdata['backup_time'] ), 'Y-m-d H:i' );

			$time_taken = time() - $jobdata['backup_time'];
			$hrs = floor( $time_taken / 3600 );
			$mins = floor( ($time_taken - 3600 * $hrs) / 60 );
			$secs = $time_taken - 3600 * $hrs - 60 * $mins;

			$services = empty( $jobdata['service'] ) ? array( 'none' ) : $jobdata['service'];
		if ( ! is_array( $services ) ) {
				$services = array( 'none' ); }

			$time_taken = sprintf( __( '%d hours, %d minutes, %d seconds', 'mainwp-updraftplus-extension' ), $hrs, $mins, $secs );

			ob_start();
			?>
			<style type="text/css">.rowlabel { font-weight: bold; width: 200px; float: left; clear: left;} .rowvalue { float: left; } h1, h2, h3, p, pre, ul { float: left; clear: left;} h1, h3, ul { margin-top: 2px; margin-bottom: 0; }</style>
			<h1><?php echo get_bloginfo( 'name' ) . ': ' . __( 'Backup Report', 'mainwp-updraftplus-extension' ); ?></h1>
				<p style="float: left; clear: left; margin: 0 0 8px;"><em>Backup made by <a href="http://updraftplus.com">UpdraftPlus <?php echo $mainwp_updraftplus->version; ?></em></a></p>
				<?php
				$ws_advert = $mainwp_updraftplus->wordshell_random_advert( 1 );
				if ( $ws_advert ) {
						echo '<div style="max-width: 700px; border: 1px solid; border-radius: 4px; font-size:110%; line-height: 110%; padding:8px; margin: 6px 0 12px; clear:left;">' . $ws_advert . '</div>';
				}
				?>
				<div class="rowlabel"><?php echo __( 'Backup of:', 'mainwp-updraftplus-extension' ); ?></div> <div class="rowvalue"><a href="<?php echo esc_attr( site_url() ); ?>"><?php echo site_url(); ?></a></div>
				<div class="rowlabel"><?php echo __( 'Latest status:', 'mainwp-updraftplus-extension' ); ?></div> <div class="rowvalue"><?php echo $final_message; ?></div>
				<div class="rowlabel"><?php echo __( 'Backup began:', 'mainwp-updraftplus-extension' ); ?></div> <div class="rowvalue"><?php echo $date; ?></div>
				<div class="rowlabel"><?php echo __( 'Contains:', 'mainwp-updraftplus-extension' ); ?></div> <div class="rowvalue"><?php echo $contains; ?></div>
				<?php
				$extra_messages = apply_filters( 'mainwp_updraftplus_report_extramessages', array() );
				$extra_msg = '';
				if ( is_array( $extra_messages ) ) {
					foreach ( $extra_messages as $msg ) {
							$extra_msg .= '<div class="rowlabel">' . htmlspecialchars( $msg['key'] ) . '</div> <div class="rowvalue">' . htmlspecialchars( $msg['val'] ) . '</div>';
					}
				}
				echo $extra_msg;
				?>
				<div class="rowlabel"><?php echo __( 'Errors / warnings:', 'mainwp-updraftplus-extension' ); ?></div> <div class="rowvalue"><?php echo $errors_and_warns; ?></div>
				<?php
				if ( $mainwp_updraftplus->error_count() > 0 ) {
						echo '<h2>' . __( 'Errors', 'mainwp-updraftplus-extension' ) . "</h2>\n<ul>";
					foreach ( $mainwp_updraftplus->errors as $err ) {
						if ( is_wp_error( $err ) ) {
							foreach ( $err->get_error_messages() as $msg ) {
									echo '<li>' . htmlspecialchars( rtrim( $msg ) ) . "</li>\n";
							}
						} elseif ( is_array( $err ) && 'error' == $err['level'] ) {
								echo '<li>' . htmlspecialchars( rtrim( $err['message'] ) ) . "</li>\n";
						} elseif ( is_string( $err ) ) {
								echo '<li>' . htmlspecialchars( rtrim( $err ) ) . "</li>\n";
						}
					}
						echo "</ul>\n";
				}
				if ( is_array( $warnings ) && count( $warnings ) > 0 ) {
						echo '<h2>' . __( 'Warnings', 'mainwp-updraftplus-extension' ) . "</h2>\n<ul>";
					foreach ( $warnings as $err ) {
							echo '<li>' . rtrim( $err ) . "</li>\n";
					}
						echo "</ul>\n";
						echo '<p><em>' . __( 'Note that warning messages are advisory - the backup process does not stop for them. Instead, they provide information that you might find useful, or that may indicate the source of a problem if the backup did not succeed.', 'mainwp-updraftplus-extension' ) . '</em></p>';
				}
				?>
				<p>
				<div class="rowlabel"><?php echo __( 'Time taken:', 'mainwp-updraftplus-extension' ); ?></div> <div class="rowvalue"><?php echo $time_taken; ?></div>
				<div class="rowlabel"><?php echo __( 'Uploaded to:', 'mainwp-updraftplus-extension' ); ?></div> <div class="rowvalue"><?php
				$show_services = '';
				foreach ( $services as $serv ) {
					if ( 'none' == $serv || '' == $serv ) {
							$add_none = true;
					} elseif ( isset( $mainwp_updraftplus->backup_methods[ $serv ] ) ) {
							$show_services .= ($show_services) ? ', ' . $mainwp_updraftplus->backup_methods[ $serv ] : $mainwp_updraftplus->backup_methods[ $serv ];
					} else {
							$show_services .= ($show_services) ? ', ' . $serv : $serv;
					}
				}
				if ( '' == $show_services && $add_none ) {
						$show_services .= __( 'None', 'mainwp-updraftplus-extension' ); }

				echo $show_services . "</div></p>\n\n";

				$checksums = array( 'sha1' );

				foreach ( $file_entities as $entity => $info ) {
						echo $this->printfile( $info['description'], $history, $entity, $checksums, $jobdata );
				}

				foreach ( $history as $key => $val ) {
					if ( 'db' == strtolower( substr( $key, 0, 2 ) ) && '-size' != substr( $key, -5, 5 ) ) {
							echo $this->printfile( __( 'Database', 'mainwp-updraftplus-extension' ), $history, $key, $checksums, $jobdata );
					}
				}

				echo '<p>' . __( 'The log file has been attached to this email.', 'mainwp-updraftplus-extension' ) . "</p>\n\n";

				if ( $debug ) {
						echo '<h2>' . __( 'Debugging information', 'mainwp-updraftplus-extension' ) . "</h2>\n<pre>";
						print chunk_split( base64_encode( serialize( $jobdata ) ), 76, "\n" );
						print "\n";
						print chunk_split( base64_encode( serialize( $history ) ), 76, "\n" );
						echo '</pre>';
				}

				$this->html = ob_get_contents();
				ob_end_clean();

				# Lower priority: get there before other plugins which apply templates
				add_filter( 'wp_mail_content_type', array( $this, 'wp_mail_content_type' ), 8 );

				return str_replace( "\n", "\r\n", strip_tags( preg_replace( '#\<style([^\>]*)\>.*\</style\>#', '', $this->html ) ) );
	}

	public function wp_mail_content_type( $content_type ) {
			// Only convert if the message is text/plain and the template is ok
		if ( 'text/plain' == $content_type && ! empty( $this->html ) ) {
			if ( empty( $this->added_phpmailer_init_action ) ) {
					$this->added_phpmailer_init_action = true;
					add_action( 'phpmailer_init', array( $this, 'phpmailer_init' ) );
			}
				return 'text/html';
		}
			return $content_type;
	}

	public function phpmailer_init( $phpmailer ) {
		if ( empty( $this->html ) ) {
				return; }
			$phpmailer->AltBody = wp_specialchars_decode( $phpmailer->Body, ENT_QUOTES );
			$phpmailer->Body = $this->html;
	}

	public function report_finished() {
			remove_filter( 'wp_mail_content_type', array( $this, 'wp_mail_content_type' ), 8 );
			remove_action( 'phpmail_init', array( $this, 'phpmailer_init' ) );
		if ( empty( $this->html ) ) {
				return; }
			global $phpmailer;
		if ( is_object( $phpmailer ) && is_a( $phpmailer, 'PHPMailer' ) ) {
			//          $phpmailer->AltBody = '';
			//          $phpmailer->Body = '';
			//          $phpmailer->ContentType = 'text/plain';
				// Best just to force WP to get the whole thing again from the beginning
				$phpmailer = null;
		}
			unset( $this->html );
	}

	public function updraft_report_subject( $subject, $error_count, $warning_count ) {
		if ( $error_count > 0 ) {
				$subject .= sprintf( __( ' (with errors (%s))' ), $error_count );
		} elseif ( $warning_count > 0 ) {
				$subject .= sprintf( __( ' (with warnings (%s))' ), $warning_count );
		}
			return $subject;
	}

	public function updraft_report_sendto( $send, $addr, $error_count, $warning_count, $ind ) {
		if ( null === $this->emails ) {
				$this->emails = MainWP_Updraft_Plus_Options::get_updraft_option( 'updraft_email', array() );
			if ( is_string( $this->emails ) ) {
					$this->emails = array( $this->emails ); }
		}
		if ( null === $this->warningsonly ) {
				$this->warningsonly = MainWP_Updraft_Plus_Options::get_updraft_option( 'updraft_report_warningsonly' );
			if ( ! is_array( $this->warningsonly ) ) {
					$this->warningsonly = array(); }
		}

		if ( 0 == $error_count + $warning_count && isset( $this->emails[ $ind ] ) && ! empty( $this->warningsonly[ $ind ] ) ) {
				$send = false;
				global $mainwp_updraftplus;
				$mainwp_updraftplus->log( 'No report will be sent to this address, as it is configured to receive them only when there are errors or warnings: ' . substr( $addr, 0, 5 ) . '...' );
		}
			return $send;
	}

	public function email_wholebackup( $doit, $addr, $ind ) {
			$wholebackup = MainWP_Updraft_Plus_Options::get_updraft_option( 'updraft_report_wholebackup', null );
		if ( null === $wholebackup ) {
				return true; }
			return ( ! is_array( $wholebackup ) || empty( $wholebackup[ $ind ] )) ? false : true;
	}

	public function email_whichaddresses( $blurb ) {
			return __( 'Use the "Reporting" section to configure the email addresses to be used.', 'mainwp-updraftplus-extension' );
	}

	public function admin_footer() {
			?>
			<script>
					jQuery(document).ready(function () {
						jQuery('#mwp_updraft_report_another').click(function (e) {
							e.preventDefault();

							var ind = jQuery('#updraft_report_cell .updraft_reportbox').length + 2;
							var showemail = 1;

							jQuery('#mwp_updraft_report_another_p').before('<div id="updraft_reportbox_' + ind + '" class="updraft_reportbox" style="padding:8px; margin: 8px 0; border: 1px dotted; clear:left;float:left;"><button onclick="jQuery(\'#updraft_reportbox_' + ind + '\').fadeOut().remove();" type="button" style="font-size: 50%; float:right; padding:0 3px; position: relative; top: -4px; left: 4px;">X</button><input type="text" title="' + mwp_updraftlion.enteremailhere + '" style="width:300px" name="mwp_updraft_email[' + ind + ']" value="" /><br><input style="margin-top: 4px;" type="checkbox" id="updraft_report_warningsonly_' + ind + '" name="mwp_updraft_report_warningsonly[' + ind + ']"><label for="updraft_report_warningsonly_' + ind + '">' + mwp_updraftlion.sendonlyonwarnings + '</label><br><div class="updraft_report_wholebackup" style="' + ((showemail) ? '' : 'display:none;') + '">\
		<input style="margin-top: 4px;" type="checkbox" id="updraft_report_wholebackup_' + ind + '" name="mwp_updraft_report_wholebackup[' + ind + ']" title="' + mwp_updraftlion.emailsizelimits + '"><label for="updraft_report_wholebackup_' + ind + '" title="' + mwp_updraftlion.emailsizelimits + '">' + mwp_updraftlion.wholebackup + '</label></div></div>');

						});
					});
			</script>
			<?php
	}

	private function printfile( $description, $history, $entity, $checksums, $jobdata ) {

		if ( empty( $history[ $entity ] ) ) {
				return; }

			echo '<h3>' . $description . ' (' . sprintf( __( 'files: %s', 'mainwp-updraftplus-extension' ), count( $history[ $entity ] ) ) . ")</h3>\n\n";

			$pfiles = '<ul>';
			$files = $history[ $entity ];
		if ( is_string( $files ) ) {
				$files = array( $files ); }

		foreach ( $files as $ind => $file ) {

				$op = htmlspecialchars( $file ) . "\n";
				$skey = $entity . ((0 == $ind) ? '' : $ind + 1) . '-size';
				$meta = '';
			if ( 'db' == substr( $entity, 0, 2 ) && 'db' != $entity ) {
					$dind = substr( $entity, 2 );
				if ( is_array( $jobdata ) && ! empty( $jobdata['backup_database'] ) && is_array( $jobdata['backup_database'] ) && ! empty( $jobdata['backup_database'][ $dind ] ) && is_array( $jobdata['backup_database'][ $dind ]['dbinfo'] ) && ! empty( $jobdata['backup_database'][ $dind ]['dbinfo']['host'] ) ) {
						$dbinfo = $jobdata['backup_database'][ $dind ]['dbinfo'];
						$meta .= sprintf( __( 'External database (%s)', 'mainwp-updraftplus-extension' ), $dbinfo['user'] . '@' . $dbinfo['host'] . '/' . $dbinfo['name'] ) . '<br>';
				}
			}
			if ( isset( $history[ $skey ] ) ) {
					$meta .= sprintf( __( 'Size: %s Mb', 'mainwp-updraftplus-extension' ), round( $history[ $skey ] / 1048576, 1 ) ); }
				$ckey = $entity . $ind;
			foreach ( $checksums as $ck ) {
					$ck_plain = false;
				if ( isset( $history['checksums'][ $ck ][ $ckey ] ) ) {
						$meta .= (($meta) ? ', ' : '') . sprintf( __( '%s checksum: %s', 'mainwp-updraftplus-extension' ), strtoupper( $ck ), $history['checksums'][ $ck ][ $ckey ] );
						$ck_plain = true;
				}
				if ( isset( $history['checksums'][ $ck ][ $ckey . '.crypt' ] ) ) {
					if ( $ck_plain ) {
							$meta .= ' ' . __( '(when decrypted)' ); }
						$meta .= (($meta) ? ', ' : '') . sprintf( __( '%s checksum: %s', 'mainwp-updraftplus-extension' ), strtoupper( $ck ), $history['checksums'][ $ck ][ $ckey . '.crypt' ] );
				}
			}

				$fileinfo = apply_filters( 'mainwp_updraftplus_fileinfo_$entity', array(), $ind );
			if ( is_array( $fileinfo ) && ! empty( $fileinfo ) ) {
				if ( isset( $fileinfo['html'] ) ) {
						$meta .= $fileinfo['html'];
				}
			}

				#if ($meta) $meta = " ($meta)";
			if ( $meta ) {
					$meta = "<br><em>$meta</em>"; }
				$pfiles .= '<li>' . $op . $meta . "\n</li>\n";
		}

			$pfiles .= "</ul>\n";

			return $pfiles;
	}

	public function updraftplus_report_form( $in ) {

			add_action( 'admin_footer', array( $this, 'admin_footer' ) );

			# Columns: Email address | only send if no errors/warnings

			$out = '<tr id="updraft_report_row">
				<th>' . __( 'Email reports', 'mainwp-updraftplus-extension' ) . ':</th>
				<td id="updraft_report_cell">';

			# Could be multiple (separated by commas)
			$updraft_email = MainWP_Updraft_Plus_Options::get_updraft_option( 'updraft_email' );
			$updraft_report_warningsonly = MainWP_Updraft_Plus_Options::get_updraft_option( 'updraft_report_warningsonly' );
			$updraft_report_wholebackup = MainWP_Updraft_Plus_Options::get_updraft_option( 'updraft_report_wholebackup' );

		if ( is_string( $updraft_email ) ) {
				$utmp = $updraft_email;
				$updraft_email = array();
				$updraft_report_warningsonly = array();
				$updraft_report_wholebackup = array();
			foreach ( explode( ',', $utmp ) as $email ) {
					# Whole backup only takes effect if 'Email' is chosen as a storage option
					$updraft_email[] = $email;
					$updraft_report_warningsonly[] = false;
					$updraft_report_wholebackup[] = true;
			}
		} elseif ( ! is_array( $updraft_email ) ) {
				$updraft_email = array();
				$updraft_report_warningsonly = array();
				$updraft_report_wholebackup = array();
		}

			$ind = 0;

			$out .= '<p>' . __( 'Enter addresses here to have a report sent to them when a backup job finishes.', 'mainwp-updraftplus-extension' ) . '</p>';

		foreach ( $updraft_email as $ikey => $destination ) {
				$warningsonly = (empty( $updraft_report_warningsonly[ $ikey ] )) ? false : true;
				$wholebackup = (empty( $updraft_report_wholebackup[ $ikey ] )) ? false : true;
			if ( ! empty( $destination ) ) {
					$ind++;
					$out .= $this->report_box_generator( $destination, $ind, $warningsonly, $wholebackup );
			}
		}

		if ( 0 === $ind ) {
				$out .= $this->report_box_generator( '', 0, false, false ); }

			$out .= '<p id="mwp_updraft_report_another_p" style="clear:left;"><a id="mwp_updraft_report_another" href="#updraft_report_row">' . __( 'Add another address...', 'mainwp-updraftplus-extension' ) . '</a></p>';

			$out .= '</td>
			</tr>';

			$out .= '<tr>
				<th></th>
				<td>';

			$out .= '<input type="checkbox" value="1" ' . ((MainWP_Updraft_Plus_Options::get_updraft_option( 'updraft_log_syslog', false )) ? 'checked="checked"' : '') . ' name="mwp_updraft_log_syslog" id="updraft_log_syslog"><label for="updraft_log_syslog">' . __( 'Log all messages to syslog (only server admins are likely to want this)', 'mainwp-updraftplus-extension' ) . '</label>';

			$out .= '</td></tr>';

			return $out;
	}

	public function saveemails( $rinput, $input ) {
			return $input;
	}

	private function report_box_generator( $addr, $ind, $warningsonly, $wholebackup ) {

			$out = '';

			$out .= '<div id="updraft_reportbox_' . $ind . '" class="updraft_reportbox" style="padding:8px; margin: 8px 0; border: 1px dotted; clear:left;float:left;">';

			$out .= '<button onclick="jQuery(\'#updraft_reportbox_' . $ind . '\').fadeOut().remove();" type="button" style="font-size: 50%; float:right; padding:0 3px; position: relative; top: -4px; left: 4px;">X</button>';

			$out .= '<input type="text" title="' . esc_attr( __( 'To send to more than one address, separate each address with a comma.', 'mainwp-updraftplus-extension' ) ) . '" style="width:300px" name="mwp_updraft_email[' . $ind . ']" value="' . esc_attr( $addr ) . '" /><br>';

			$out .= '<input ' . (($warningsonly) ? 'checked="checked" ' : '') . 'style="margin-top: 4px;" type="checkbox" id="updraft_report_warningsonly_' . $ind . '" name="mwp_updraft_report_warningsonly[' . $ind . ']"><label for="updraft_report_warningsonly_' . $ind . '"> ' . __( 'Send a report only when there are warnings/errors', 'mainwp-updraftplus-extension' ) . '</label><br>';

			$out .= '<div class="updraft_report_wholebackup"><input ' . (($wholebackup) ? 'checked="checked" ' : '') . 'style="margin-top: 4px;" type="checkbox" id="updraft_report_wholebackup_' . $ind . '" name="mwp_updraft_report_wholebackup[' . $ind . ']" title="' . esc_attr( sprintf( __( 'Be aware that mail servers tend to have size limits; typically around %s Mb; backups larger than any limits will likely not arrive.', 'mainwp-updraftplus-extension' ), '10-20' ) ) . '"><label for="updraft_report_wholebackup_' . $ind . '" title="' . esc_attr( sprintf( __( 'Be aware that mail servers tend to have size limits; typically around %s Mb; backups larger than any limits will likely not arrive.', 'mainwp-updraftplus-extension' ), '10-20' ) ) . '"> ' . __( 'When the Email storage method is enabled, also send the entire backup', 'mainwp-updraftplus-extension' ) . '</label></div>';

			$out .= '</div>';

			return $out;
	}
}

