<?php

class MainWP_Updraftplus_Backups {

	public static $instance = null;

	public static function get_instance() {
		if ( null === self::$instance ) {
				self::$instance = new self(); }
			return self::$instance;
	}

	public function __construct() {

	}

	public function init() {

	}

	public function init_updraft() {
			$this->handle_settings_post();
			$this->load_updraft_classes();
	}

	public function admin_init() {
			add_action( 'wp_ajax_mainwp_updraftplus_load_sites', array( 'MainWP_Updraftplus_Backups', 'ajax_load_sites' ) );
			add_action( 'wp_ajax_mainwp_updraftplus_save_settings', array( $this, 'ajax_save_settings' ) );
			add_action( 'wp_ajax_mainwp_updraftplus_site_override_settings', array( $this, 'ajax_override_settings' ) );
			add_action( 'wp_ajax_mainwp_updraftplus_addons_connect', array( $this, 'ajax_addons_connect' ) );
			add_action( 'mainwp-site-synced', array( &$this, 'site_synced' ), 10, 1 );
			add_action( 'mainwp_delete_site', array( &$this, 'delete_site_data' ), 10, 1 );
	}

	public function delete_site_data( $website ) {
		if ( $website ) {
			MainWP_Updraftplus_BackupsDB::get_instance()->delete_setting( 'site_id', $website->id );
		}
	}

	public function site_synced( $website ) {
		if ( $website && $website->plugins != '' ) {
				$plugins = json_decode( $website->plugins, 1 );
				$status = 0;
			if ( is_array( $plugins ) && count( $plugins ) != 0 ) {
				foreach ( $plugins as $plugin ) {
					if ( ('updraftplus/updraftplus.php' == $plugin['slug']) ) {
						if ( $plugin['active'] ) {
								$status = 1; 								
						}
						break;
					}
				}
			}			
		}
	}

	public static function render() {

			$website = null;
		if ( isset( $_GET['id'] ) && ! empty( $_GET['id'] ) ) {
				global $mainWPUpdraftPlusBackupsExtensionActivator;
				$option = array(
			'plugin_upgrades' => true,
					'plugins' => true,
				);
				$dbwebsites = apply_filters( 'mainwp-getdbsites', $mainWPUpdraftPlusBackupsExtensionActivator->get_child_file(), $mainWPUpdraftPlusBackupsExtensionActivator->get_child_key(), array( $_GET['id'] ), array(), $option );

				if ( is_array( $dbwebsites ) && ! empty( $dbwebsites ) ) {
						$website = current( $dbwebsites );
				}
		}

		if ( self::is_managesites_updraftplus() ) {
				$error = '';
			if ( empty( $website ) ) {
					$error = __( 'Error: Site not found.', 'mainwp' );
			} else {
					$activated = false;
				if ( $website && $website->plugins != '' ) {
						$plugins = json_decode( $website->plugins, 1 );
					if ( is_array( $plugins ) && count( $plugins ) > 0 ) {
						foreach ( $plugins as $plugin ) {
							if ( ('updraftplus/updraftplus.php' == $plugin['slug']) ) {
								if ( $plugin['active'] ) {
										$activated = true; }
											break;
							}
						}
					}
				}
				if ( ! $activated ) {
						$error = __( 'UpdraftPlus - Backup/Restore plugin is not installed or activated on the site.', 'mainwp' );
				}
			}

			if ( ! empty( $error ) ) {
					do_action( 'mainwp-pageheader-sites', 'Updraftplus' );
					echo '<div class="mainwp_info-box-red">' . $error . '</div>';
					do_action( 'mainwp-pagefooter-sites', 'Updraftplus' );
					return;
			}
		}

		if ( empty( $website ) ) {
				self::updraftplus_qsg();
		}
			self::render_tabs( $website );
	}

	public static function render_tabs( $website = null ) {

		if ( isset( $_GET['action'] ) && 'mwpUpdraftOpenSite' == $_GET['action'] ) {
				self::open_site();
				return;
		}

			global $mainWPUpdraftPlusBackupsExtensionActivator;
			$dbwebsites_updraftplus = array();
		if ( ! self::is_managesites_updraftplus() ) {
				$websites = apply_filters( 'mainwp-getsites', $mainWPUpdraftPlusBackupsExtensionActivator->get_child_file(), $mainWPUpdraftPlusBackupsExtensionActivator->get_child_key(), null );
				$sites_ids = array();
			if ( is_array( $websites ) ) {
				foreach ( $websites as $site ) {
						$sites_ids[] = $site['id'];
				}
					unset( $websites );
			}

				$option = array(
				'plugin_upgrades' => true,
					'plugins' => true,
				);

				$dbwebsites = apply_filters( 'mainwp-getdbsites', $mainWPUpdraftPlusBackupsExtensionActivator->get_child_file(), $mainWPUpdraftPlusBackupsExtensionActivator->get_child_key(), $sites_ids, array(), $option );
				//print_r($dbwebsites);
				$selected_group = 0;

			if ( isset( $_POST['mainwp_updraftplus_plugin_groups_select'] ) ) {
					$selected_group = intval( $_POST['mainwp_updraftplus_plugin_groups_select'] );
			}

				$updraftDataSites = array();
			if ( count( $sites_ids ) > 0 ) {
					$updraftDataSites = MainWP_Updraftplus_BackupsDB::get_instance()->get_updraft_data_site( $sites_ids );
			}

				$dbwebsites_updraftplus = MainWP_Updraftplus_Backups_Plugin::get_instance()->get_websites_with_the_plugin( $dbwebsites, $selected_group, $updraftDataSites );

				unset( $dbwebsites );
				unset( $updraftDataSites );
		}

			$style_tab_dashboard = $style_tab_status = $style_tab_backup = $style_tab_settings = $style_tab_debug = $style_tab_nextscheduled = ' style="display: none" ';

		if ( self::is_managesites_updraftplus() ) {
				$is_individual = true;
		} else {
				$is_individual = false;
		}

			$perform_settings_update = false;

		if ( get_option( 'mainwp_updraft_perform_settings_update' ) == 1 ) {
				delete_option( 'mainwp_updraft_perform_settings_update' );
				$perform_settings_update = true;
				$style_tab_settings = '';
				$performWhat = 'save_settings';				
		} else if ( get_option( 'mainwp_updraft_general_addons_connect' ) == 1 ) {
				delete_option( 'mainwp_updraft_general_addons_connect' );
				$perform_settings_update = true;
				$style_tab_settings = '';
				$performWhat = 'addons_connect';
		}

		if ( ! $perform_settings_update ) {
			if ( (isset( $_GET['tab'] ) && ( 'settings' == $_GET['tab'] )) || isset( $_POST['mainwp_premium_updraft_site_id'] ) || isset( $_POST['mainwp_updraft_addons_site_id'] ) ) {
					$style_tab_settings = '';
			} else if ( isset( $_GET['tab'] ) && ('backups' == $_GET['tab']) ) {
					$style_tab_backup = '';
			} else {
				if ( $is_individual ) {
					if ( isset( $_POST['submit-updraft-settings'] ) ) {
							$style_tab_settings = ''; 							
					} else {
							$style_tab_status = ''; 							
					}
				} else {
					if ( isset( $_GET['updraftplus_scheduled_orderby'] ) ) {
							$style_tab_nextscheduled = ''; 							
					} else {
							$style_tab_dashboard = ''; 							
					}
				}
			}
		}

		if ( $is_individual ) {
			do_action( 'mainwp-pageheader-sites', 'Updraftplus' );
			$dashboard_link = $scheduled_link = '';
			$status_link = '<a href="#" id="mwp_updraftplus_status_tab_lnk" class="mainwp_action mid ' . (empty( $style_tab_status ) ? 'mainwp_action_down selected' : '') . '">' . __( 'Current Status', 'mainwp' ) . '</a>';
			$count_backups = MainWP_Updraft_Plus_Options::get_updraft_option( 'mainwp_updraft_backup_history_count' );
			if ( $count_backups > 0 ) {
				$count_backups = ' (' . $count_backups . ')'; 					
			} else {
				$count_backups = ''; 					
			}
		} else {
				$dashboard_link = '<a id="mwp_updraftplus_dashboard_tab_lnk" href="#" class="mainwp_action left ' . (empty( $style_tab_dashboard ) ? 'mainwp_action_down selected' : '') . '">' . __( 'Updraftplus Backups Dashboard', 'mainwp' ) . '</a>';
				$scheduled_link = '<a id="mwp_updraftplus_scheduled_tab_lnk" href="#" class="mainwp_action mid ' . (empty( $style_tab_nextscheduled ) ? 'mainwp_action_down selected' : '') . '">' . __( 'Scheduled Backups', 'mainwp-updraftplus-extension' ) . '</a>';
				$status_link = '';
				$count_backups = '';
		}

			global $mainwp_updraftplus_admin;

			$site_id = ! empty( $website ) ? $website->id : 0;
			$primary_backup = get_option( 'mainwp_primaryBackup', null );
			?>  
			<script type="text/javascript">
					var mwp_updraft_individual_siteid = <?php echo $site_id ?>;
                </script>
				
				<style type="text/css">
					.ui-dialog {
						width: 75% !important;
					}
				</style>
					
                <div id="mwp_updraft-poplog" >
				<pre id="mwp_updraft-poplog-content" style="white-space: pre-wrap;"></pre>
                </div>

                <div class="wrap" id="mainwp-ap-option">
				<div class="clearfix"></div>           
				<div class="inside">                 
					<div id="mainwp_updraftplus_settings">   
						<?php
						if ( 'updraftplus' == $primary_backup ) {
								echo '<div class="mainwp_info-box">' . __( 'Currently using UpdraftPlus for your backups. You can <a href="admin.php?page=Settings" style="text-decoration: none;">change settings here</a>.' ) . '</div>';
						}
						?>
						<div id="mwp_updraft_backup_started" class="mainwp_info-box" style="display:none;"></div>
						<div id="mwp_updraft_backup_error" class="mainwp_info-box-red" style="display:none;"></div>
						<div class="clear"> 
							<br />
							<div id="mwp_updraft_info" class="mainwp_info-box-yellow" style="display:none;"></div>
							<div class="updraftplus_tabs_lnk"><?php echo $dashboard_link; ?><?php echo $scheduled_link; ?><?php echo $status_link; ?><a href="#" id="mwp_updraftplus_backup_tab_lnk" class="mainwp_action <?php echo self::is_managesites_updraftplus() ? 'mid' : 'left'; ?> <?php echo (empty( $style_tab_backup ) ? 'mainwp_action_down selected' : ''); ?>"><?php _e( 'Existing Backups' . $count_backups ); ?></a><a href="#" id="mwp_updraftplus_setting_tab_lnk" class="mainwp_action right <?php echo (empty( $style_tab_settings ) ? 'mainwp_action_down selected' : ''); ?>"><?php _e( 'Settings', 'mainwp' ); ?></a></div>
							<br /><br /> 
							<?php if ( ! $is_individual ) { ?>
										<div id="mwp_updraftplus_dashboard_tab" <?php echo $style_tab_dashboard; ?>>                           
                                            <br>                                                  
                                            <div class="tablenav top">
												<?php MainWP_Updraftplus_Backups_Plugin::gen_select_sites( $dbwebsites_updraftplus, $selected_group ); ?>  
                                                <input type="button" class="mainwp-upgrade-button button-primary button" 
													   value="<?php _e( 'Sync Data' ); ?>" id="dashboard_refresh" style="background-image: none!important; float:right; padding-left: .6em !important;">
                                            </div>                            
											<?php MainWP_Updraftplus_Backups_Plugin::gen_plugin_dashboard_tab( $dbwebsites_updraftplus ); ?>                            
                                        </div>   
								<?php } ?>

							<div id="mainwp_updraftplus_screens_tab"> 

								<script type="text/javascript">
										var mwp_updraft_credentialtest_nonce = '<?php echo wp_create_nonce( 'mwp-updraftplus-credentialtest-nonce' ); ?>';
										var mwp_updraft_download_nonce = '<?php echo wp_create_nonce( 'mwp_updraftplus_download' ); ?>';
								</script>

								<?php
								$backup_history = array();
								if ( $is_individual ) {
										?>      
										<div id="mwp_updraftplus_status_tab" <?php echo $style_tab_status; ?>> 

											<?php $mainwp_updraftplus_admin->settings_statustab(); ?>
                                            </div>
											<?php
								}
								?>
								<div id="mwp_updraftplus_backup_tab" <?php echo $style_tab_backup; ?>>                              
									<?php $mainwp_updraftplus_admin->settings_downloadingandrestoring( $site_id, $dbwebsites_updraftplus ); ?>
                                    </div> 

									<?php
									if ( ! $is_individual ) {
											?>
											<div id="mwp_updraftplus_nextscheduled_tab" <?php echo $style_tab_nextscheduled; ?>>                                 
                                                <div class="tablenav top">                                
                                                    <input type="button" class="mainwp-upgrade-button button-primary button" 
														   value="<?php _e( 'Reload Data' ); ?>" id="mwp_updraftplus_refresh" style="background-image: none!important; float:right; padding-left: .6em !important;">
                                                </div> 
												<?php
												MainWP_Updraftplus_Backups_Next_Scheduled::get_instance()->gen_next_scheduled_backups_tab( $dbwebsites_updraftplus );
												?>
                                            </div>
											<?php
									}
									?>
									<form method="post" id="mwp_updraftplus_form_settings" action="" >   
										<div id="mwp_updraftplus_setting_tab" <?php echo $style_tab_settings; ?>>                            
										<?php
										if ( $perform_settings_update ) {
												MainWP_Updraftplus_Backups::ajax_load_sites( $performWhat, false );
										} else {

											$is_premium = MainWP_Updraftplus_Backups_Extension::is_updraft_premium();
											if ( $is_premium ) {
													self::box_connect_updraft( $site_id ); 												
											}
											?>
											<div class="mainwp_info-box-red hidden" id="updraftplus_error_zone"></div>	
											<div id="mwp_updraftplus_setting_content_left">												
											<?php
													$override = 0;
													if ( $is_individual ) {	
														$site_updraftplus = MainWP_Updraftplus_BackupsDB::get_instance()->get_setting_by( 'site_id', $site_id );
														if ( $site_updraftplus ) {															
															$override = $site_updraftplus->override;
														}
														self::site_settings_box($override);
													}											
													self::box_premium_setting( $site_id );
													?>
													<div class="postbox">
														<h3 class="mainwp_box_title"><span><i class="fa fa-cogs"></i> <?php _e( 'Configure Backup Contents And Schedule', 'mainwp-updraftplus-extension' ); ?></span></h3>
														<div class="inside">
															<input type="hidden" name="mainwp_updraft_site_id" value="<?php echo $site_id; ?>"> 														                            
															<?php																
															$mainwp_updraftplus_admin->settings_formcontents($is_individual, $override);
															?>
														</div>
													</div>                              
											</div>															
											<?php
											}
											?>												
										</div>
									</form>
                                </div>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div> 								
				<?php
				if ( $is_individual ) {
					do_action( 'mainwp-pagefooter-sites', 'Updraftplus' ); }
	}

	public static function site_settings_box($override) {
			$site_id = isset( $_GET['id'] ) ? $_GET['id'] : 0;
			$url_loader = MAINWP_UPDRAFT_PLUS_URL . '/images/loader.gif';			
			?>  
			<div class="postbox" id="updraftplus_site_settings">
				<h3 class="mainwp_box_title"><span><i class="fa fa-cog"></i> <?php _e( 'UpdraftPlus Backups Site Settings', 'mainwp-updraftplus-extension' ); ?></span></h3>
				<div class="inside">
					<input type="hidden" name="mainwp_updraftplus_settings_site_id" value="<?php echo $site_id; ?>">
					<table class="form-table">              
						<tr valign="top">
							<th scope="row" class="settinglabel">
								<?php _e( 'Override General Settings', 'mainwp-updraftplus-extension' ); ?> <?php do_action( 'mainwp_renderToolTip', __( 'Set to YES if you want to overwrite general Updraftplus Backups settings.', 'mainwp-updraftplus-extension' ) ); ?>
							</th>
							<td class="settingfield">
								<div class="mainwp-checkbox">
									<input type="checkbox" id="mainwp_updraftplus_override_general_settings" name="mainwp_updraftplus_override_general_settings"  <?php echo ( 0 == $override ? '' : 'checked="checked"'); ?> value="1"/>
									<label for="mainwp_updraftplus_override_general_settings"></label>
								</div>&nbsp;&nbsp;
								<img class="loader hidden" src="<?php echo $url_loader; ?>"/>       
								<span id="mwp_updraftplus_site_save_settings_status" class="hidden"></span>

							</td>
						</tr>  
					</table>
					<input class="button-primary" id="mwp_updraftplus_settings_save_btn" type="button" value="<?php echo __( 'Save', 'mainwp-updraftplus-extension' ); ?>" />
				</div>
                </div> 
				 <script type="text/javascript">
				<?php				
				if ( get_option( 'mainwp_updraft_perform_individual_settings_update' ) == 1 ) {
					delete_option( 'mainwp_updraft_perform_individual_settings_update' );
					?>
					mainwp_updraftplus_individual_save_settings(<?php echo $site_id; ?>);
					<?php
				} else if ( get_option( 'mainwp_updraft_individual_addons_connect' ) == 1 ) {
					delete_option( 'mainwp_updraft_individual_addons_connect' );
					?>
					mainwp_updraftplus_individual_addons_connect(<?php echo $site_id; ?>);                        
					<?php
				}
				?>
				</script>
				<?php
	}

	public static function box_connect_updraft( $site_id = 0 ) {
			$addonsOptions = MainWP_Updraft_Plus_Options::get_updraft_option( 'addons_options', array() );
		if ( ! is_array( $addonsOptions ) ) {
				$addonsOptions = array(); }

			$user_email = isset( $addonsOptions['email'] ) ? $addonsOptions['email'] : '';
			$user_password = isset( $addonsOptions['password'] ) ? $addonsOptions['password'] : '';
			?>  
			<div class="postbox" id="updraft_addons_options">
				<h3 class="mainwp_box_title"><span><i class="fa fa-cog"></i> <?php _e( 'Connect with your UpdraftPlus.Com account', 'mainwp-updraftplus-extension' ); ?></span></h3>
				<div class="inside">                    
					<form method="post" action="" >      
						<input type="hidden" name="mainwp_updraft_addons_site_id" value="<?php echo $site_id; ?>">                                                                                         
						<table class="form-table" >                                                
							<tr valign="top">
								<th scope="row" class="settinglabel">
									<?php _e( 'Email', 'mainwp-updraftplus-extension' ); ?>
								</th>
								<td class="settingfield">
									<input type="text" value="<?php echo $user_email; ?>" name="mainwp_updraftplus-addons_options[email]" style="width: 282px" autocomplete="off">
									<br />
									<a href="http://updraftplus.com/my-account/" target="_blank"><?php _e( "Not yet got an account (it's free)? Go get one!", 'mainwp-updraftplus-extension' ); ?></a>
								</td>
							</tr>  
							<tr valign="top">
								<th scope="row" class="settinglabel">
									<?php _e( 'Password', 'mainwp-updraftplus-extension' ); ?>
								</th>
								<td class="settingfield">
									<input type="password" value="<?php echo $user_password; ?>" name="mainwp_updraftplus-addons_options[password]" style="width: 282px" autocomplete="off">
									<br />
									<a href="http://updraftplus.com/my-account/?action=lostpassword" target="_blank"><?php _e( 'Forgotten your details?', 'mainwp-updraftplus-extension' ); ?></a>
								</td>
							</tr>  
						</table>
						<input class="button-primary" type="submit" name="submit" value="<?php echo __( 'Connect', 'mainwp-updraftplus-extension' ); ?>" />&nbsp;&nbsp;                    
						<span id="mwp_updraft_site_addons_connect_working">
							<i class="fa fa-spinner fa-pulse" style="display: none;"></i>
							<span class="status"></span>
						</span>
						<p><em><a href="http://updraftplus.com/faqs/tell-me-about-my-updraftplus-com-account/" target="_blank"><?php _e( 'Interested in knowing about your UpdraftPlus.Com password security? Read about it here.', 'mainwp-updraftplus-extension' ); ?></a></em></p>                    
					</form>
				</div>
                </div>  
				<?php
				global $current_user;
	}

	public static function box_premium_setting( $site_id = 0 ) {

			$is_premium = MainWP_Updraftplus_Backups_Extension::is_updraft_premium(); //MainWP_Updraft_Plus_Options::get_updraft_option('mwp_updraft_is_premium');
			?>  
			<div class="postbox" id="updraft_premium_setting">
				<h3 class="mainwp_box_title"><span><i class="fa fa-cog"></i> <?php _e( 'UpdraftPlus Plugin Version Settings', 'mainwp-updraftplus-extension' ); ?></span></h3>
				<div class="inside">                    
					<form method="post" action="" >      
						<input type="hidden" name="mainwp_premium_updraft_site_id" value="<?php echo $site_id; ?>">                                                                                         
						<table class="form-table" > 
							<tr valign="top">
								<td scope="row" colspan="2" style="padding:0px">
									<div class="mainwp_info-box"><?php _e( 'Premium version requires you to purchase the Premium Upgrade from <a href="https://updraftplus.com/shop/updraftplus-premium/" title="UpdraftPlus" target="_blank">UpdraftPlus</a>.', 'mainwp-updraftplus-extension' ); ?></div>
								</td>                            
							</tr>                          
							<tr valign="top">
								<th scope="row" class="settinglabel">
									<?php _e( 'Use premium version', 'mainwp-updraftplus-extension' ); ?> <?php do_action( 'mainwp_renderToolTip', __( 'Set to YES if you want to use with the Updraft Plus premium version.', 'mainwp-updraftplus-extension' ) ); ?>
								</th>
								<td class="settingfield">
									<div class="mainwp-checkbox">                                      
										<input type="checkbox" id="mwp_updraft_is_premium" name="mwp_updraft_is_premium"  <?php echo ($is_premium ? 'checked="checked"' : ''); ?> value="yes"/>
										<label for="mwp_updraft_is_premium"></label>
									</div>&nbsp;&nbsp;
								</td>
							</tr>  
						</table>
						<input class="button-primary" type="submit" name="submit" value="<?php echo __( 'Save', 'mainwp-updraftplus-extension' ); ?>" />
					</form>
				</div>
                </div>  
				<?php
				global $current_user;
	}

	public static function open_site() {
			$id = $_GET['websiteid'];
			global $mainWPUpdraftPlusBackupsExtensionActivator;
			$websites = apply_filters( 'mainwp-getdbsites', $mainWPUpdraftPlusBackupsExtensionActivator->get_child_file(), $mainWPUpdraftPlusBackupsExtensionActivator->get_child_key(), array( $id ) );
			$website = null;
		if ( $websites && is_array( $websites ) ) {
				$website = current( $websites );
		}

			$open_location = '';
		if ( isset( $_GET['open_location'] ) ) {
				$open_location = $_GET['open_location']; }
			?>
			<div id="mainwp_background-box">   
				<?php
				if ( function_exists( 'mainwp_current_user_can' ) && ! mainwp_current_user_can( 'dashboard', 'access_wpadmin_on_child_sites' ) ) {
						mainwp_do_not_have_permissions( 'WP-Admin on child sites' );
				} else {
						?>
						<div style="font-size: 30px; text-align: center; margin-top: 5em;"><?php _e( 'You will be redirected to your website immediately.', 'mainwp' ); ?></div>                            
							<form method="POST" action="<?php echo MainWP_Updraftplus_Backups_Utility::get_getdata_authed( $website, 'index.php', 'where', $open_location ); ?>" id="redirectForm">
                            </form>
					<?php } ?>
                </div>
				<?php
	}

	public function load_updraft_classes() {
			global $mainwp_updraft_globals;

		if ( ! class_exists( 'MainWP_Updraft_Plus_Options' ) ) {
				require_once( MAINWP_UPDRAFT_PLUS_DIR . '/options.php' ); }

			$is_premium = MainWP_Updraftplus_Backups_Extension::is_updraft_premium();

			$updraftplus_have_addons = 0;
		if ( $is_premium ) {
			if ( is_dir( MAINWP_UPDRAFT_PLUS_DIR . '/addons' ) && $dir_handle = opendir( MAINWP_UPDRAFT_PLUS_DIR . '/addons' ) ) {
				while ( false !== ($e = readdir( $dir_handle )) ) {
					if ( is_file( MAINWP_UPDRAFT_PLUS_DIR . '/addons/' . $e ) && preg_match( '/\.php$/', $e ) ) {
							# We used to have 1024 bytes here - but this meant that if someone's site was hacked and a lot of code added at the top, and if they were running a too-low PHP version, then they might just see the symptom rather than the cause - and raise the support request with us.
							$header = file_get_contents( MAINWP_UPDRAFT_PLUS_DIR . '/addons/' . $e, false, null, -1, 16384 );
							$phprequires = (preg_match( '/RequiresPHP: (\d[\d\.]+)/', $header, $matches )) ? $matches[1] : false;
							$phpinclude = (preg_match( '/IncludePHP: (\S+)/', $header, $matches )) ? $matches[1] : false;
						if ( false === $phprequires || version_compare( PHP_VERSION, $phprequires, '>=' ) ) {
								$updraftplus_have_addons++;
							if ( $phpinclude ) {
									require_once( MAINWP_UPDRAFT_PLUS_DIR . '/' . $phpinclude ); }
								include_once( MAINWP_UPDRAFT_PLUS_DIR . '/addons/' . $e );
						}
					}
				}
					@closedir( $dir_handle );
			}

				//if (is_file(MAINWP_UPDRAFT_PLUS_DIR.'/udaddons/updraftplus-addons.php')) include_once(MAINWP_UPDRAFT_PLUS_DIR.'/udaddons/updraftplus-addons.php');
		}

			global $mainwp_updraftplus;

		if ( empty( $mainwp_updraftplus ) ) {
				require_once MAINWP_UPDRAFT_PLUS_DIR . '/class-updraftplus.php';
				$mainwp_updraftplus = new MainWP_UpdraftPlus();
				$mainwp_updraftplus->have_addons = $updraftplus_have_addons;
		}
	}

	public static function updraftplus_qsg() {
			$plugin_data = get_plugin_data( MAINWP_UDP_PLUGIN_FILE, false );
			$description = $plugin_data['Description'];
			$extraHeaders = array( 'DocumentationURI' => 'Documentation URI' );
			$file_data = get_file_data( MAINWP_UDP_PLUGIN_FILE, $extraHeaders );
			$documentation_url = $file_data['DocumentationURI'];
			?>
			<div  class="mainwp_ext_info_box" id="cs-pth-notice-box">
				<div class="mainwp-ext-description"><?php echo $description; ?></div><br/>
				<b><?php echo __( 'Need Help?' ); ?></b> <?php echo __( 'Review the Extension' ); ?> <a href="<?php echo $documentation_url; ?>" target="_blank"><i class="fa fa-book"></i> <?php echo __( 'Documentation' ); ?></a>. 
				<a href="#" id="mainwp-updraftplus-quick-start-guide"><i class="fa fa-info-circle"></i> <?php _e( 'Show Quick Start Guide', 'mainwp' ); ?></a></div>
                <div  class="mainwp_ext_info_box" id="mainwp-updraftplus-tips" style="color: #333!important; text-shadow: none!important;">
				<span><a href="#" class="mainwp-show-tut" number="1"><i class="fa fa-book"></i> <?php _e( 'UpdraftPlus Backups Dashboard', 'mainwp' ) ?></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" class="mainwp-show-tut"  number="2"><i class="fa fa-book"></i> <?php _e( 'UpdraftPlus Settings', 'mainwp' ) ?></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" class="mainwp-show-tut"  number="3"><i class="fa fa-book"></i> <?php _e( 'UpdraftPlus Extensions Backup/Restore', 'mainwp' ) ?></a></span>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" class="mainwp-show-tut"  number="4"><i class="fa fa-book"></i> <?php _e( 'Make UpdraftPlus Extension you Primary Backup System', 'mainwp' ) ?></a></span><span><a href="#" id="mainwp-updraftplus-tips-dismiss" style="float: right;"><i class="fa fa-times-circle"></i> <?php _e( 'Dismiss', 'mainwp' ); ?></a></span>
                <div class="clear"></div>
                <div id="mainwp-updraftplus-tuts">
				<div class="mainwp-updraftplus-tut" number="1">
					<h3>UpdraftPlus Backups Dashboard</h3>    
					<p>From the UpdraftPlus Backups Dashboard page, you can monitor all of your child sites where you have the UpdraftPlus Backups plugin installed. In the sites list, you will be notified if the plugin has an update available or if the plugin is deactivated.</p>
					<p>The provided links and bulk actions will allow you to Update and Activate the Plugin.</p>  
					<p>You can also hide the Plugin on child sites. Simply by clicking the Hide UpdraftPlus - Backups Plugin you can hide it on a single site (Show UpdraftPlus - Backups Plugin for un-hiding it)</p>
					<p>or use bulk actions to hide on multiple sites. Select the sites where you want to hide the plugin, choose the Hide action and click the Apply button.</p> 
					<p>To un-hide the plugin on multiple sites, select the wanted sites, choose the Show action and click the Apply button.</p>
					<p>Plugin Version column will show you the plugin version number and if you have the Free or Premium plugin version.</p>          
					<p>Backup Now column provides you quick links to the Backup page, where you can Backup your child site.</p>           
				</div>
				<div class="mainwp-updraftplus-tut"  number="2">
					<h3>UpdraftPlus Settings</h3>
					<p>MainWP UpdraftPlus Extension allows you to manage UpdraftPlus Plugin settings on your child sites. From the settings tab, you can set following options for your child sites.</p>
					<ul>
						<li>Files Backup Schedule</li>
						<li>Database Backup Schedule</li>
						<li>Include/Exclude Files from Backups</li>
						<li>Database options</li>
						<li>Notifications</li>
						<li>Set Remote Storage options</li>
						<li>Advanced Debugging Options</li>
					</ul>
					<p>If you use the Premium version of the UpdraftPlus Plugin, make sure the Use Premium Version is set to YES. This will show you premium version options.</p>
					<p>All UpdraftPlus Settings can be set for separately for different child sites. To do this go to the MainWP > Sites page, and in the sites table, under the child site url, you can find the UpdraftPlus Backup/Restore link. This link will open Individual site UpdraftPlus Options.</p>
					<p>The Settings tab will show you all plugin options where you can set custom settings for the child site. In order to override global options, set the Override General Settings to YES and click the Save button.</p>
				</div>
				<div class="mainwp-updraftplus-tut"  number="3">
					<h3>UpdraftPlus Extensions Backup/Restore</h3>    
					<p>To backup your child site with the MainWP UpdraftPlus Extension go to the MainWP > Sites > Manage Sites page. Locate the UpdraftPlus Backup/Restore link under the child site URL and click it.</p>
					<p><strong>You can get to the UpdraftPlus Backups tab from various places. In the extension settings page, in all provided tables, you will find the Backup Now link. It will lead you directly to the child site backup page.</strong></p>
					<p>On a child site UpdraftPlus Backups page on the Current Status tab, you will find the Backup Now and Restore buttons.</p>                                                
				</div>                             
				<div class="mainwp-updraftplus-tut"  number="4">
					<h3>Make UpdraftPlus Extension you Primary Backup System</h3> 
					<p>If you want to use your extension as a primary Backup feature, go to the MainWP > Settings page. In the Backup Options box, locate the Select Primary Backup System option, and from the dropdown, select the MainWP UpdraftPlus Extension.</p>
					<p>Setting the UpdraftPlus as a primary backup option as primary will make some changes to you dashboard.</p>  
					<ul>
						<li>The Backup Now link in the Manage Sites page will be replaced with the extension's Backup Now link.</li>
						<li>The Schedule Backup link in the MainWP menu, will be replaced with the Existing Backups link, which leads to the extension page where you can see all your backups.</li>
						<li>The original backup settings from the MainWP > Settings page will be removed.</li>
					</ul>                                                 
				</div>
                </div>
                </div>
				<?php
	}

	public static function is_updraftplus_page( $tabs = array() ) {
		if ( isset( $_GET['page'] ) && ('Extensions-Mainwp-Updraftplus-Extension' == $_GET['page'] || 'ManageSitesUpdraftplus' == $_GET['page'] ) ) {
			if ( 'ManageSitesUpdraftplus' == $_GET['page'] ) {
				if ( ! isset( $_GET['tab'] ) || empty( $_GET['tab'] ) ) {
						$_GET['tab'] = 'settings';
				}
			}
			if ( empty( $tabs ) ) {
					return true;
			} else if ( is_array( $tabs ) && isset( $_GET['tab'] ) && in_array( $_GET['tab'], $tabs ) ) {
					return true;
			} else if ( isset( $_GET['tab'] ) && $_GET['tab'] == $tabs ) {
					return true;
			}
		}
			return false;
	}

	public static function is_managesites_updraftplus( $tabs = array() ) {
			// to fix bug
		if ( isset( $_REQUEST['updraftRequestSiteID'] ) && ! empty( $_REQUEST['updraftRequestSiteID'] ) ) {
				return true;
		} else if ( isset( $_GET['page'] ) && ('ManageSitesUpdraftplus' == $_GET['page']) ) {
				return true;
		}
			return false;
	}

	public static function get_site_id_managesites_updraftplus() {
			$site_id = 0;
		if ( self::is_managesites_updraftplus() ) {
			if ( isset( $_REQUEST['updraftRequestSiteID'] ) && ! empty( $_REQUEST['updraftRequestSiteID'] ) ) {
					$site_id = $_REQUEST['updraftRequestSiteID']; } else if ( isset( $_GET['id'] ) && ! empty( $_GET['id'] ) ) {
						$site_id = $_GET['id']; } else if ( isset( $_POST['mainwp_updraft_site_id'] ) && ! empty( $_POST['mainwp_updraft_site_id'] ) ) {
						$site_id = $_POST['mainwp_updraft_site_id']; }
		}
			return $site_id;
	}

	public function handle_settings_post() {

		if ( isset( $_POST['submit-updraft-settings'] ) ) {
				$is_individual_settings = false;
			if ( isset( $_POST['mainwp_updraft_site_id'] ) && ! empty( $_POST['mainwp_updraft_site_id'] ) ) {
					$is_individual_settings = true;
			}

				$settings = array();
				$settingKeys = self::get_settings_keys();
			foreach ( $settingKeys as $key ) {
					$pos_key = 'mwp_' . $key;
				if ( isset( $_POST[ $pos_key ] ) ) {
						$settings[ $key ] = $_POST[ $pos_key ];
				} else {
						$settings[ $key ] = '';
				}
			}

			// to fix bug
			$settings = $this->sanitize_fields( $settings );

			if ( $is_individual_settings ) {
					$sid = isset( $_GET['id'] ) ? $_GET['id'] : (isset( $_POST['mainwp_updraft_site_id'] ) ? $_POST['mainwp_updraft_site_id'] : 0 );
					MainWP_Updraftplus_BackupsDB::get_instance()->update_setting_fields_by( 'site_id', $sid, $settings );
					update_option( 'mainwp_updraft_perform_individual_settings_update', 1 );
			} else {
					self::update_general_settings( $settings );
					update_option( 'mainwp_updraft_perform_settings_update', 1 );					
			}				
		} 
	}

	public function sanitize_fields( $settings ) {
			$data = $settings;
			$san_emails = $san_warningsonly = $san_wholebackup = array();
		if ( isset( $data['updraft_email'] ) ) {
				$value_emails = $data['updraft_email'];
				$value_warningsonly = $data['updraft_report_warningsonly'];
				$value_wholebackup = $data['updraft_report_wholebackup'];
				// premium version
			if ( is_array( $value_emails ) ) {
				foreach ( $value_emails as $key => $val ) {
						$val = $this->just_one( $val );
					if ( ! empty( $val ) ) {
							$san_emails[] = $val;
							$san_warningsonly[] = isset( $value_warningsonly[ $key ] ) ? $value_warningsonly[ $key ] : 0;
							$san_wholebackup[] = isset( $value_wholebackup[ $key ] ) ? $value_wholebackup[ $key ] : 0;
					}
				}
					$data['updraft_email'] = $san_emails;
					$data['updraft_report_warningsonly'] = $san_warningsonly;
					$data['updraft_report_wholebackup'] = $san_wholebackup;
			}
		}

		if ( isset( $data['updraft_s3'] ) ) {
				$data['updraft_s3'] = $this->s3_sanitise( $data['updraft_s3'] );
		}

			return $data;
	}

	public function s3_sanitise( $s3 ) {
		if ( is_array( $s3 ) && ! empty( $s3['path'] ) && '/' == substr( $s3['path'], 0, 1 ) ) {
				$s3['path'] = substr( $s3['path'], 1 );
		}
			return $s3;
	}

	public function just_one_email( $input, $required = false ) {
			$x = $this->just_one( $input, 'saveemails', (empty( $input ) && false === $required) ? '' : get_bloginfo( 'admin_email' ) );
		if ( is_array( $x ) ) {
			foreach ( $x as $ind => $val ) {
				if ( empty( $val ) ) {
						unset( $x[ $ind ] ); }
			}
			if ( empty( $x ) ) {
					$x = ''; }
		}
			return $x;
	}

	public function just_one( $input, $filter = 'savestorage', $rinput = false ) {
		if ( false === $rinput ) {
				$rinput = (is_array( $input )) ? array_pop( $input ) : $input; }
		if ( is_string( $rinput ) && false !== strpos( $rinput, ',' ) ) {
				$rinput = substr( $rinput, 0, strpos( $rinput, ',' ) ); }
			return apply_filters( 'mainwp_updraftplus_' . $filter, $rinput, $oinput );
	}

	public function return_array( $input ) {
		if ( ! is_array( $input ) ) {
				$input = array(); }
			return $input;
	}

	public static function update_general_settings( $settings ) {
			$curgen_settings = get_site_option( 'mainwp_updraftplus_generalSettings' );
		if ( ! is_array( $curgen_settings ) ) {
				$curgen_settings = array(); }

		foreach ( $settings as $key => $value ) {
				$curgen_settings[ $key ] = $value;
		}
			return update_site_option( 'mainwp_updraftplus_generalSettings', $curgen_settings );
	}

	public static function delete_updraftplus_settings( $option, $site_id = false ) {
		if ( $site_id ) {
				return MainWP_Updraftplus_BackupsDB::get_instance()->update_setting_fields_by( 'site_id', $site_id, array( $option => '' ) );
		} else {
				return self::update_general_settings( array( $option => '' ) );
		}
			return false;
	}

	public static function update_updraftplus_settings( $settings, $site_id = false ) {
		if ( $site_id ) {
				return MainWP_Updraftplus_BackupsDB::get_instance()->update_setting_fields_by( 'site_id', $site_id, $settings );
		} else {
				return self::update_general_settings( $settings );
		}
			return false;
	}

	public static function ajax_load_sites( $what = null, $ajax_call = true ) {

			global $mainWPUpdraftPlusBackupsExtensionActivator;

			$websites = apply_filters( 'mainwp-getsites', $mainWPUpdraftPlusBackupsExtensionActivator->get_child_file(), $mainWPUpdraftPlusBackupsExtensionActivator->get_child_key(), null );
			$sites_ids = array();
			if ( is_array( $websites ) ) {
				foreach ( $websites as $website ) {
						$sites_ids[] = $website['id'];
				}
					unset( $websites );
			}
			$option = array(
				'plugin_upgrades' => true,
				'plugins' => true,
			);
			$dbwebsites = apply_filters( 'mainwp-getdbsites', $mainWPUpdraftPlusBackupsExtensionActivator->get_child_file(), $mainWPUpdraftPlusBackupsExtensionActivator->get_child_key(), $sites_ids, array(), $option );
			$dbwebsites_updraftplus = MainWP_Updraftplus_Backups_Plugin::get_instance()->get_websites_with_the_plugin( $dbwebsites );
			unset( $dbwebsites );

			$url_loader = plugins_url( 'images/loader.gif', dirname( __FILE__ ) );

			$what = (empty( $what ) && isset( $_POST['what'] )) ? $_POST['what'] : $what;
		
		if ( 'save_settings' == $what ) {
			echo '<h2>' . __( 'Saving Settings to child sites ...', 'mainwp' ) . '</h2><br />';				
		} else if ( 'update_history' == $what ) {
			if ( $_POST['remotescan'] ) {
					$msg = __( 'Rescanning remote and local storage for backup sets...', 'mainwp-updraftplus-extension' );
			} else {
					$msg = __( 'Rescanning (looking for backups that you have uploaded manually into the internal backup store)...', 'mainwp-updraftplus-extension' );
			}
				echo '<h2>' . $msg . '</h2><br />';
		} else if ( 'addons_connect' == $what ) {
				echo '<h2>' . __( 'Connect with your UpdraftPlus.Com account ...', 'mainwp' ) . '</h2><br />';
		} else if ( 'vault_bulk_connect' == $what ) {
				echo '<h2>' . __( 'Connecting child sites with your UpdraftPlus Vault account ...', 'mainwp' ) . '</h2><br />';
		}
		
		if ('vault_bulk_connect' == $what) {
			$email = $_POST['email'];
			$password = $_POST['pass'];

			if (empty($email) || empty($password)) {
				echo '<div class="mainwp_info-box-red">' . __( 'You need to supply both an email address and a password.', 'mainwp-updraftplus-extension' ) . '</div>';
				if ( $ajax_call ) {
					die(); 					
				} else {
					return; 					
				}
			}
			?>
			<input type="hidden" id="mainwp_updraftplus_vault_opts" name="mainwp_updraftplus_vault_opts" email="<?php echo esc_attr($email); ?>" pass="<?php echo esc_attr($password); ?>"/>		
			<?php
		}
			

		$have_active = false;
		if ( is_array( $dbwebsites_updraftplus ) && count( $dbwebsites_updraftplus ) > 0 ) {
			foreach ( $dbwebsites_updraftplus as $website ) {
				if ( ! isset( $website['updraftplus_active'] ) || empty( $website['updraftplus_active'] ) ) {
					continue; 						
				} 				
				$have_active = true;
				echo '<div><strong>' . stripslashes( $website['name'] ) . '</strong>: ';
				echo '<span class="siteItemProcess" site-id="' . $website['id'] . '" status="queue"><span class="status">Queue ...</span> <img class="hidden" src="' . $url_loader . '"/></a></span>';
				echo '</div><br />';
			}
		}

		if ( ! $have_active ) {
			echo '<div class="mainwp_info-box-yellow">' . __( 'No websites were found with the Updraftplus Backups plugin installed.', 'mainwp' ) . '</div>';
			echo '<p><a class="button-primary" href="admin.php?page=Extensions-Mainwp-Updraftplus-Extension&tab=settings">' . __('Return to Settings', 'mainwp-updraftplus-extension' ) . '</a></p>';
			if ( $ajax_call ) {
				die(); 					
			} else {
				return; 					
			}
		}
		
		if ( 'save_settings' == $what ) {
				?>
				<script type="text/javascript">
						jQuery(document).ready(function ($) {
							updraftplus_bulkTotalThreads = jQuery('.siteItemProcess[status=queue]').length;
							if (updraftplus_bulkTotalThreads > 0) {
								mainwp_updraftplus_save_settings_start_next();
							}
						});
				</script>
				<?php
		} else if ( 'addons_connect' == $what ) {
				?>
				<script type="text/javascript">
						jQuery(document).ready(function ($) {
							updraftplus_bulkTotalThreads = jQuery('.siteItemProcess[status=queue]').length;
							if (updraftplus_bulkTotalThreads > 0) {
								mainwp_updraftplus_addons_connect_start_next();
							}
						});
				</script>
				<?php
		} else if ( 'vault_bulk_connect' == $what ) {
				?>
				<script type="text/javascript">
						jQuery(document).ready(function ($) {
							updraftplus_bulkTotalThreads = jQuery('.siteItemProcess[status=queue]').length;
							if (updraftplus_bulkTotalThreads > 0) {
								mainwp_updraftplus_vault_connect_start_next();
							}
						});
				</script>
				<?php
		}

		if ( $ajax_call ) {
			die(); 				
		}
	}

	function ajax_save_settings() {
		@ini_set( 'display_errors', false );
		@error_reporting( 0 );
		$siteid = $_POST['updraftRequestSiteID'];
		$save_general = isset( $_POST['save_general'] ) && !empty( $_POST['save_general'] )  ? true : false;
		if ( empty( $siteid ) ) {
			die( json_encode( array( 'error' => 'Empty site id.' ) ) ); }

		$information = $this->perform_save_settings($siteid, $check_override = true, $save_general);
		die( json_encode( $information ) );
	}

	function mainwp_apply_plugin_settings($siteid) {		
		$information = $this->perform_save_settings($siteid, false);
		$result = array();		
		if (is_array($information)) {
			if ( 'success' == $information['result'] || 'noupdate' == $information['result'] ) {
				$result = array('result' => 'success');
			} else if (isset($information['message'])) {
				$result = array('result' => 'success', 'message' => $information['message']);				
			} else if (isset($information['error'])) {
				$result = array('error' => $information['error']);				
			} else {
				$result = array('result' => 'failed');
			}			
		} else {
			$result = array('error' => __('Undefined error', 'mainwp-updraftplus-extension'));
		}			
		die( json_encode( $result ) );
	}
	
	public function perform_save_settings($siteid, $check_override = true, $save_general = false ) {		
		$settings = array();
		$updraft_plus_site = MainWP_Updraftplus_BackupsDB::get_instance()->get_setting_by( 'site_id', $siteid );
		$individual_update = isset( $_POST['individual'] ) && ! empty( $_POST['individual'] ) ? true : false;
		$general = false;
		if ( $individual_update ) {
			if ($save_general) {			
				$settings = get_site_option( 'mainwp_updraftplus_generalSettings' );		
				$general = true;
			} else if ( $updraft_plus_site ) {
				if ( $updraft_plus_site->override ) {
						$settings = unserialize( base64_decode( $updraft_plus_site->settings ) );
				} else {
						die( json_encode( array( 'error' => 'Update Failed: Override General Settings need to be set to Yes.' ) ) );
				}
			}
		} else {
			if ( $updraft_plus_site && $check_override) {
				$this->check_override_settings( $updraft_plus_site->override );
			}
			$settings = get_site_option( 'mainwp_updraftplus_generalSettings' );
			$general = true;
		}

		if ( ! is_array( $settings ) || empty( $settings ) ) {
				die( json_encode( array( 'error' => $general ? 'Error: Empty General Settings.' : 'Error: Empty Individual Settings.' ) ) );
		}

		$send_fields = array();
		$settingKeys = self::get_settings_keys();
		foreach ( $settingKeys as $field ) {
			$send_fields[ $field ] = $settings[ $field ];
		}

		if ( $general ) {
			// do not save
			//unset( $send_fields['updraft_googledrive'] );
			//unset( $send_fields['updraft_dropbox'] );
			unset( $send_fields['updraft_onedrive'] );
			unset( $send_fields['updraft_azure'] );
			//unset( $send_fields['updraft_googlecloud'] );	
                        $send_fields['is_general'] = 1;
		}
		
		global $mainWPUpdraftPlusBackupsExtensionActivator;

		$post_data = array(
			'mwp_action' => 'save_settings',
			'settings' => base64_encode( serialize( $send_fields ) ),
		);

		$information = apply_filters( 'mainwp_fetchurlauthed', $mainWPUpdraftPlusBackupsExtensionActivator->get_child_file(), $mainWPUpdraftPlusBackupsExtensionActivator->get_child_key(), $siteid, 'updraftplus', $post_data );
		if ( is_array( $information ) ) {
			if ( isset( $information['sync_updraft_status'] ) ) {
					$syncStatus = $information['sync_updraft_status'];
				if ( is_array( $syncStatus ) ) {
						MainWP_Updraftplus_BackupsDB::get_instance()->update_setting_fields_by( 'site_id', $siteid, $syncStatus );
				}
			}			
		}
		return $information;
	}
	
	function ajax_addons_connect() {
			@ini_set( 'display_errors', false );
			@error_reporting( 0 );

			$siteid = $_POST['updraftRequestSiteID'];
		if ( empty( $siteid ) ) {
				die( json_encode( array( 'error' => 'Empty site id.' ) ) ); }

			$addonsOptions = array();
			$updraft_plus_site = MainWP_Updraftplus_BackupsDB::get_instance()->get_setting_by( 'site_id', $siteid );
			$individual = isset( $_POST['individual'] ) && ! empty( $_POST['individual'] ) ? true : false;
		if ( $individual ) {
			if ( $updraft_plus_site ) {
				if ( $updraft_plus_site->override ) {
						$settings = unserialize( base64_decode( $updraft_plus_site->settings ) );
						$addonsOptions = isset( $settings['addons_options'] ) ? $settings['addons_options'] : array();
				} else {
						die( json_encode( array( 'error' => 'Update Failed: Override General Settings need to be set to Yes.' ) ) );
				}
			}
		} else {
			if ( $updraft_plus_site ) {
					$this->check_override_settings( $updraft_plus_site->override );
			}
				$settings = get_site_option( 'mainwp_updraftplus_generalSettings' );
				$addonsOptions = isset( $settings['addons_options'] ) ? $settings['addons_options'] : array();
		}
		if ( ! is_array( $addonsOptions ) ) {
				$addonsOptions = array(); }
			$send_fields = array(
				'email' => isset( $addonsOptions['email'] ) ? $addonsOptions['email'] : '',
				'password' => isset( $addonsOptions['password'] ) ? $addonsOptions['password'] : '',
			);

			global $mainWPUpdraftPlusBackupsExtensionActivator;

			$post_data = array(
		'mwp_action' => 'addons_connect',
				'addons_options' => base64_encode( serialize( $send_fields ) ),
			);
			$information = apply_filters( 'mainwp_fetchurlauthed', $mainWPUpdraftPlusBackupsExtensionActivator->get_child_file(), $mainWPUpdraftPlusBackupsExtensionActivator->get_child_key(), $siteid, 'updraftplus', $post_data );
			die( json_encode( $information ) );
	}

		# TODO: Remove legacy storage setting keys from here

	public static function get_settings_keys() {
			return array(
				'updraft_autobackup_default',
				'updraftplus_dismissedautobackup',
				'updraftplus_dismissedexpiry',
				'updraft_interval',
				'updraft_interval_increments',
				'updraft_interval_database',
				'updraft_retain',
				'updraft_retain_db',
				'updraft_encryptionphrase',
				'updraft_service',
				'updraft_dir',
				'updraft_email',
				'updraft_delete_local',
				'updraft_include_plugins',
				'updraft_include_themes',
				'updraft_include_uploads',
				'updraft_include_others',
				'updraft_include_wpcore',
				'updraft_include_wpcore_exclude',
				'updraft_include_more',
				'updraft_include_blogs',
				'updraft_include_mu-plugins',
				'updraft_include_others_exclude',
				'updraft_include_uploads_exclude',
				'updraft_adminlocking',
				'updraft_starttime_files',
				'updraft_starttime_db',
				'updraft_startday_db',
				'updraft_startday_files',
				'updraft_googledrive',
				'updraft_s3',
				'updraft_s3generic',
				'updraft_dreamhost',
				'updraft_disable_ping',
				'updraft_openstack',
				'updraft_bitcasa',
				'updraft_cloudfiles',
				'updraft_ssl_useservercerts',
				'updraft_ssl_disableverify',
				'updraft_report_warningsonly',
				'updraft_report_wholebackup',
				'updraft_log_syslog',
				'updraft_extradatabases',
				'updraft_split_every',
				'updraft_ssl_nossl',
				'updraft_backupdb_nonwp',
				'updraft_extradbs',
				'updraft_include_more_path',
				'updraft_dropbox',
				'updraft_ftp',				
				'updraft_sftp_settings',
				'updraft_webdav_settings',
				'updraft_dreamobjects',
				'updraft_onedrive',
				'updraft_azure',
				'updraft_googlecloud',			
				//'updraft_updraftvault',
				'updraft_retain_extrarules'
			);
	}

	public static function get_open_location_link( $site_id, $loc ) {
			$loc = base64_encode( $loc );
			return 'admin.php?page=Extensions-Mainwp-Updraftplus-Extension&action=mwpUpdraftOpenSite&websiteid=' . $site_id . '&open_location=' . $loc;
	}

	function ajax_override_settings() {
			$websiteId = $_POST['updraftRequestSiteID'];
		if ( empty( $websiteId ) ) {
				die( json_encode( array( 'error' => 'Empty site id.' ) ) ); }

			global $mainWPUpdraftPlusBackupsExtensionActivator;

			$website = apply_filters( 'mainwp-getsites', $mainWPUpdraftPlusBackupsExtensionActivator->get_child_file(), $mainWPUpdraftPlusBackupsExtensionActivator->get_child_key(), $websiteId );
		if ( $website && is_array( $website ) ) {
				$website = current( $website );
		}
		if ( ! $website ) {
				return; }

			$update = array(
				'site_id' => $website['id'],
				'override' => $_POST['override'],
			);

			MainWP_Updraftplus_BackupsDB::get_instance()->update_setting( $update );
			die( json_encode( array( 'result' => 'success' ) ) );
	}

	private function check_override_settings( $override ) {
		if ( 1 == $override ) {
				die( json_encode( array( 'message' => __( 'Not Updated - Individual site settings are in use.', 'mainwp' ) ) ) );
		}
	}
}
