<?php

class MainWP_Updraftplus_Backups_Plugin {

	private $option_handle = 'mainwp_updraftplus_plugin_option';
	private $option = array();
	private static $order = '';
	private static $orderby = '';
		//Singleton
	private static $instance = null;

	static function get_instance() {
		if ( null == MainWP_Updraftplus_Backups_Plugin::$instance ) {
				MainWP_Updraftplus_Backups_Plugin::$instance = new MainWP_Updraftplus_Backups_Plugin();
		}
			return MainWP_Updraftplus_Backups_Plugin::$instance;
	}

	public function __construct() {
			$this->option = get_option( $this->option_handle );
	}

	public function admin_init() {
			add_action( 'wp_ajax_mainwp_updraftplus_upgrade_noti_dismiss', array( $this, 'dismiss_notice' ) );
			add_action( 'wp_ajax_mainwp_updraftplus_active_plugin', array( $this, 'active_plugin' ) );
			add_action( 'wp_ajax_mainwp_updraftplus_upgrade_plugin', array( $this, 'upgrade_plugin' ) );
			add_action( 'wp_ajax_mainwp_updraftplus_showhide_plugin', array( $this, 'showhide_plugin' ) );
	}

	public function get_option( $key = null, $default = '' ) {
		if ( isset( $this->option[ $key ] ) ) {
				return $this->option[ $key ]; }
			return $default;
	}

	public function set_option( $key, $value ) {
			$this->option[ $key ] = $value;
			return update_option( $this->option_handle, $this->option );
	}

	public static function gen_plugin_dashboard_tab( $websites ) {
		$orderby = 'name';
		$_order = 'desc';
		
		if ( isset( $_GET['updraftplus_orderby'] ) && ! empty( $_GET['updraftplus_orderby'] ) ) {
				$orderby = $_GET['updraftplus_orderby'];
		}
		if ( isset( $_GET['updraftplus_order'] ) && ! empty( $_GET['updraftplus_order'] ) ) {
				$_order = $_GET['updraftplus_order'];
		}

		$name_order = $version_order = $status_order = $last_scan_order = $time_order = $url_order = $hidden_order = $settings_order = '';

		if ( isset( $_GET['updraftplus_orderby'] ) ) {
			if ( 'name' == $_GET['updraftplus_orderby'] ) {
					$name_order = ('desc' == $_order) ? 'asc' : 'desc';
			} else if ( 'version' == $_GET['updraftplus_orderby'] ) {
					$version_order = ('desc' == $_order) ? 'asc' : 'desc';
			} else if ( 'url' == $_GET['updraftplus_orderby'] ) {
						$url_order = ('desc' == $_order) ? 'asc' : 'desc';
			} else if ( 'hidden' == $_GET['updraftplus_orderby'] ) {
					$hidden_order = ('desc' == $_order) ? 'asc' : 'desc';
			} else if ( 'settings' == $_GET['updraftplus_scheduled_orderby'] ) {
					$settings_order = ('desc' == $_order) ? 'asc' : 'desc';
			} 
		}

			self::$order = $_order;
			self::$orderby = $orderby;
			usort( $websites, array( 'MainWP_Updraftplus_Backups_Plugin', 'updraftplus_data_sort' ) );			
			?>
			<table id="mainwp-table-plugins" class="wp-list-table widefat plugins" cellspacing="0">
				<thead>
					<tr>
						<th class="check-column">
							<input type="checkbox"  id="cb-select-all-1" >
						</th>
						<th scope="col" class="manage-column sortable <?php echo $name_order; ?>">
							<a href="?page=Extensions-Mainwp-Updraftplus-Extension&updraftplus_orderby=name&updraftplus_order=<?php echo (empty( $name_order ) ? 'asc' : $name_order); ?>"><span><?php _e( 'Site', 'mainwp' ); ?></span><span class="sorting-indicator"></span></a>
						</th>
						<th scope="col" class="manage-column sortable <?php echo $url_order; ?>">
							<a href="?page=Extensions-Mainwp-Updraftplus-Extension&updraftplus_orderby=url&updraftplus_order=<?php echo (empty( $url_order ) ? 'asc' : $url_order); ?>"><span><?php _e( 'URL', 'mainwp' ); ?></span><span class="sorting-indicator"></span></a>
						</th>  
						<th scope="col" class="manage-column sortable <?php echo $version_order; ?>">
							<a href="?page=Extensions-Mainwp-Updraftplus-Extension&updraftplus_orderby=version&updraftplus_order=<?php echo (empty( $version_order ) ? 'asc' : $version_order); ?>"><span><?php _e( 'Plugin Version', 'mainwp' ); ?></span><span class="sorting-indicator"></span></a>
						</th>
						<th scope="col" class="manage-column <?php echo $hidden_order; ?>">
							<a href="?page=Extensions-Mainwp-Updraftplus-Extension&updraftplus_orderby=hidden&updraftplus_order=<?php echo (empty( $hidden_order ) ? 'asc' : $hidden_order); ?>"><span><?php _e( 'Plugin Hidden', 'mainwp' ); ?></span><span class="sorting-indicator"></span></a>
						</th>
						<th scope="col" class="manage-column <?php echo $settings_order; ?>">
							<a href="?page=Extensions-Mainwp-Updraftplus-Extension&updraftplus_orderby=settings&updraftplus_order=<?php echo (empty( $settings_order ) ? 'asc' : $settings_order); ?>"><span><?php _e( 'Settings in use','l10n-mainwp-ithemes-security-extension' ); ?></span><span class="sorting-indicator"></span></a>
						</th>
						<th scope="col" class="manage-column">
							<span><?php _e( 'Backup now', 'mainwp' ); ?></span>
						</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th class="check-column">
							<input type="checkbox"  id="cb-select-all-2" >
						</th>
						<th scope="col" class="manage-column sortable <?php echo $name_order; ?>">
							<a href="?page=Extensions-Mainwp-Updraftplus-Extension&updraftplus_orderby=name&updraftplus_order=<?php echo (empty( $name_order ) ? 'asc' : $name_order); ?>"><span><?php _e( 'Site', 'mainwp' ); ?></span><span class="sorting-indicator"></span></a>
						</th>
						<th scope="col" class="manage-column sortable <?php echo $url_order; ?>">
							<a href="?page=Extensions-Mainwp-Updraftplus-Extension&updraftplus_orderby=url&updraftplus_order=<?php echo (empty( $url_order ) ? 'asc' : $url_order); ?>"><span><?php _e( 'URL', 'mainwp' ); ?></span><span class="sorting-indicator"></span></a>
						</th>          
						<th scope="col" class="manage-column sortable <?php echo $version_order; ?>">
							<a href="?page=Extensions-Mainwp-Updraftplus-Extension&updraftplus_orderby=version&updraftplus_order=<?php echo (empty( $version_order ) ? 'asc' : $version_order); ?>"><span><?php _e( 'Plugin Version', 'mainwp' ); ?></span><span class="sorting-indicator"></span></a>
						</th>     
						<th scope="col" class="manage-column <?php echo $hidden_order; ?>">
							<a href="?page=Extensions-Mainwp-Updraftplus-Extension&updraftplus_orderby=hidden&updraftplus_order=<?php echo (empty( $hidden_order ) ? 'asc' : $hidden_order); ?>"><span><?php _e( 'Plugin Hidden', 'mainwp' ); ?></span><span class="sorting-indicator"></span></a>
						</th>
						<th scope="col" class="manage-column <?php echo $settings_order; ?>">
							<a href="?page=Extensions-Mainwp-Updraftplus-Extension&updraftplus_orderby=settings&updraftplus_order=<?php echo (empty( $settings_order ) ? 'asc' : $settings_order); ?>"><span><?php _e( 'Settings in use','l10n-mainwp-ithemes-security-extension' ); ?></span><span class="sorting-indicator"></span></a>
						</th>
						<th scope="col" class="manage-column">
							<span><?php _e( 'Backup now', 'mainwp' ); ?></span>
						</th>
					</tr>
				</tfoot>
				<tbody id="the-mwp-updraftplus-list" class="list:sites">
					<?php
					if ( is_array( $websites ) && count( $websites ) > 0 ) {
							self::get_plugin_dashboard_table_row( $websites );
					} else {
							_e( '<tr><td colspan="9">No websites were found with the Updraftplus Backups plugin installed.</td></tr>' );
					}
					?>
                    </tbody>
                </table>
				<?php
	}

	public static function get_plugin_dashboard_table_row( $websites ) {
			$dismiss = array();
		if ( session_id() == '' ) {
				session_start(); }
		if ( isset( $_SESSION['mainwp_updraftplus_dismiss_upgrade_plugin_notis'] ) ) {
				$dismiss = $_SESSION['mainwp_updraftplus_dismiss_upgrade_plugin_notis'];
		}

		if ( ! is_array( $dismiss ) ) {
				$dismiss = array(); }

			$url_loader = plugins_url( 'images/loader.gif', dirname( __FILE__ ) );
			$plugin_name = 'UpdraftPlus - Backups';

			$globalPremium = get_option( 'mainwp_updraft_general_is_premium', 0 );

		foreach ( $websites as $website ) {
				$location = 'options-general.php?page=updraftplus';
				$website_id = $website['id'];
				$cls_active = (isset( $website['updraftplus_active'] ) && ! empty( $website['updraftplus_active'] )) ? 'active' : 'inactive';
				$cls_update = (isset( $website['updraftplus_upgrade'] )) ? 'update' : '';
				$cls_update = ('inactive' == $cls_active) ? 'update' : $cls_update;
				$showhide_action = (1 == $website['hide_updraftplus']) ? 'show' : 'hide';
				$showhide_link = '<a href="#" class="mwp_updraftplus_showhide_plugin" showhide="' . $showhide_action . '"><i class="fa fa-eye-slash"></i> ' . ('show' === $showhide_action ? 'Show ' . $plugin_name . ' plugin' : 'Hide ' . $plugin_name . ' plugin') . '</a>';

				$td_status = '';
				?>
				<tr class="<?php echo $cls_active . ' ' . $cls_update; ?>" website-id="<?php echo $website_id; ?>" plugin-name="<?php echo $plugin_name; ?>">
					<th class="check-column">
						<input type="checkbox"  name="checked[]">
					</th>
					<td>
						<a href="admin.php?page=managesites&dashboard=<?php echo $website_id; ?>"><?php echo stripslashes( $website['name'] ); ?></a><br/>
						<div class="row-actions"><span class="dashboard"><a href="admin.php?page=managesites&dashboard=<?php echo $website_id; ?>"><i class="fa fa-tachometer"></i> <?php _e( 'Overview', 'mainwp-updraftplus-extension' ); ?></a></span> |  <span class="edit"><a href="admin.php?page=managesites&id=<?php echo $website_id; ?>"><i class="fa fa-pencil-square-o"></i> <?php _e( 'Edit' ); ?></a> | <?php echo $showhide_link; ?></span></div>                    
						<div class="its-action-working"><span class="status" style="display:none;"></span><span class="loading" style="display:none;"><img src="<?php echo $url_loader; ?>"> <?php _e( 'Please wait...' ); ?></span></div>
					</td>               
					<td>
						<a href="<?php echo $website['url']; ?>" target="_blank"><?php echo $website['url']; ?></a><br/>
						<div class="row-actions"><span class="edit"><a target="_blank" href="admin.php?page=SiteOpen&newWindow=yes&websiteid=<?php echo $website_id; ?>"><i class="fa fa-external-link"></i> <?php _e( 'Open WP-Admin', 'mainwp-updraftplus-extension' ); ?></a></span> | <span class="edit"><a href="admin.php?page=SiteOpen&newWindow=yes&websiteid=<?php echo $website_id; ?>&location=<?php echo base64_encode( $location ); ?>" target="_blank"><i class="fa fa-cog"></i> <?php _e( 'Open Updraftplus Backups', 'mainwp-updraftplus-extension' ); ?></a></span></div>                    
					</td>
					<td>
						<?php
						if ( isset( $website['updraftplus_plugin_version'] ) ) {
								echo $website['updraftplus_plugin_version'];
							if ( $website['isOverride'] ) {
									echo ' ' . ($website['isPremium'] ? '(Premium)' : '(Free)');
							} else {
									echo ' ' . ($globalPremium ? '(Premium)' : '(Free)');
							}
						} else {
								echo '&nbsp;'; }
						?>
						</td>     
						<td>
							<span class="updraftplus_hidden_title">
							<?php echo (1 == $website['hide_updraftplus']) ? __( 'Yes' ) : __( 'No' ); ?>
							</span>
						</td>
						<td>
							<span ><?php
								 echo (1 == $website['individual_in_use']) ? __( 'Individual' ) : __( 'General' );								 
							 ?>
						  </span>
						</td>
						<td>
							<span><a href="admin.php?page=ManageSitesUpdraftplus&id=<?php echo $website_id; ?>"><i class="fa fa-hdd-o"></i> <?php _e( 'Backup Now', 'mainwp' ); ?></a></span>
						</td>
                        </tr>        
						<?php
						$active_link = $update_link = '';
						$version = '';
						$plugin_slug = $website['plugin_slug'];
						if ( isset( $website['updraftplus_active'] ) && empty( $website['updraftplus_active'] ) ) {
							$active_link = '<a href="#" class="mwp_updraftplus_active_plugin" >Activate ' . $plugin_name . ' plugin</a>'; }

						if ( isset( $website['updraftplus_upgrade'] ) ) {
							if ( isset( $website['updraftplus_upgrade']['new_version'] ) ) {
									$version = $website['updraftplus_upgrade']['new_version']; }
								$update_link = '<a href="#" class="mwp_updraftplus_upgrade_plugin" >Update ' . $plugin_name . ' plugin</a>';
							if ( isset( $website['updraftplus_upgrade']['plugin'] ) ) {
									$plugin_slug = $website['updraftplus_upgrade']['plugin']; }
						}

						$hide_update = false;
						if ( isset( $dismiss[ $website_id ] ) ) {
								$hide_update = true;
						}

						if ( ! empty( $active_link ) || ! empty( $update_link ) ) {
								$location = 'plugins.php';
								$link_row = $active_link . ' | ' . $update_link;
								$link_row = rtrim( $link_row, ' | ' );
								$link_row = ltrim( $link_row, ' | ' );
								?>
								<tr class="plugin-update-tr" <?php echo ($hide_update ? 'style="display: none"' : ''); ?>>
                                    <td colspan="8" class="plugin-update">
										<div class="ext-upgrade-noti update-message" plugin-slug="<?php echo $plugin_slug; ?>" website-id="<?php echo $website_id; ?>" version="<?php echo $version; ?>"><p>
											<?php if ( ! $hide_update ) { ?>
													<span style="float:right"><a href="#" class="updraftplus_plugin_upgrade_noti_dismiss"><?php _e( 'Dismiss' ); ?></a></span>                    
											<?php } ?>
											<?php echo $link_row; ?>
											<span class="mwp-updraftplus-row-working"><span class="status"></span><img class="hidden-field" src="<?php echo plugins_url( 'images/loader.gif', dirname( __FILE__ ) ); ?>"/></span>
                                        </p></div>
                                    </td>
                                </tr>
								<?php
						}
		}
	}

	public static function updraftplus_data_sort( $a, $b ) {
		if ( 'version' == self::$orderby ) {
				$a = $a['updraftplus_plugin_version'];
				$b = $b['updraftplus_plugin_version'];
				$cmp = version_compare( $a, $b );
		} else if ( 'url' == self::$orderby ) {
				$a = $a['url'];
				$b = $b['url'];
				$cmp = strcmp( $a, $b );
		} else if ( 'hidden' == self::$orderby ) {
				$a = $a['hide_updraftplus'];
				$b = $b['hide_updraftplus'];
				$cmp = $a - $b;
		} else if ( 'settings' == self::$orderby ) {
			$a = $a['individual_in_use'];
			$b = $b['individual_in_use'];
			$cmp = $a - $b;
		} else {
				$a = $a['name'];
				$b = $b['name'];
				$cmp = strcmp( $a, $b );
		}
		if ( 0 == $cmp ) {
				return 0; }

		if ( 'desc' == self::$order ) {
				return ($cmp > 0) ? -1 : 1; } else {
				return ($cmp > 0) ? 1 : -1; }
	}

	public function get_updraftdata_websites() {
			global $mainWPUpdraftPlusBackupsExtensionActivator;
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
			$updraftDataSites = array();
		if ( count( $sites_ids ) > 0 ) {
				$updraftDataSites = MainWP_Updraftplus_BackupsDB::get_instance()->get_updraft_data_site( $sites_ids );
		}
			return MainWP_Updraftplus_Backups_Plugin::get_instance()->get_websites_with_some_updraftdata( $dbwebsites, $updraftDataSites );
	}

	public function get_websites_with_some_updraftdata( $websites, $updraft_data_sites = array() ) {
			$sites_updraft = array();
		if ( is_array( $websites ) ) {
			foreach ( $websites as $website ) {
				if ( $website && $website->plugins != '' ) {
						$plugins = json_decode( $website->plugins, 1 );
					if ( is_array( $plugins ) && count( $plugins ) != 0 ) {
						foreach ( $plugins as $plugin ) {
							if ( ('updraftplus/updraftplus.php' == $plugin['slug']) ) {
									$site = MainWP_Updraftplus_Backups_Utility::map_site( $website, array( 'id' ) );
								if ( ! $plugin['active'] ) {
										continue; }

									$data = array( 'id' => $website->id );
									$updraftDS = isset( $updraft_data_sites[ $site['id'] ] ) ? $updraft_data_sites[ $site['id'] ] : array();
								if ( ! is_array( $updraftDS ) ) {
										$updraftDS = array(); }
									$data['updraft_lastbackup_gmttime'] = isset( $updraftDS['updraft_lastbackup_gmttime'] ) ? $updraftDS['updraft_lastbackup_gmttime'] : 0;
									//$data['mwp_updraft_is_premium'] = isset($updraftDS['mwp_updraft_is_premium']) ? $updraftDS['mwp_updraft_is_premium'] : "";
									$sites_updraft[ $website->id ] = $data;
									break;
							}
						}
					}
				}
			}
		}

			return $sites_updraft;
	}

	public function get_websites_with_the_plugin( $websites, $selected_group = 0, $updraft_data_sites = array() ) {
		$websites_updraftplus = array();
		$updraftHide = $this->get_option( 'hide_the_plugin' );
		if ( ! is_array( $updraftHide ) ) {
				$updraftHide = array(); 				
		}
		$_text = __( 'Nothing currently scheduled', 'mainwp-updraftplus-extension' );
		$in_use = MainWP_Updraftplus_BackupsDB::get_instance()->get_settings_field_array();
		
		if ( is_array( $websites ) && count( $websites ) ) {
			if ( empty( $selected_group ) ) {
				foreach ( $websites as $website ) {
					if ( $website && $website->plugins != '' ) {
							$plugins = json_decode( $website->plugins, 1 );
						if ( is_array( $plugins ) && count( $plugins ) != 0 ) {
							foreach ( $plugins as $plugin ) {
								if ( ('updraftplus/updraftplus.php' == $plugin['slug']) ) {
										$site = MainWP_Updraftplus_Backups_Utility::map_site( $website, array( 'id', 'name', 'url' ) );
									if ( $plugin['active'] ) {
											$site['updraftplus_active'] = 1; } else {
											$site['updraftplus_active'] = 0; }
													// get upgrade info
													$site['updraftplus_plugin_version'] = $plugin['version'];
													$site['plugin_slug'] = $plugin['slug'];
													$plugin_upgrades = json_decode( $website->plugin_upgrades, 1 );
											if ( is_array( $plugin_upgrades ) && count( $plugin_upgrades ) > 0 ) {
												if ( isset( $plugin_upgrades['updraftplus/updraftplus.php'] ) ) {
														$upgrade = $plugin_upgrades['updraftplus/updraftplus.php'];
													if ( isset( $upgrade['update'] ) ) {
															$site['updraftplus_upgrade'] = $upgrade['update'];
													}
												}
											}

													$site['hide_updraftplus'] = 0;
											if ( isset( $updraftHide[ $website->id ] ) && $updraftHide[ $website->id ] ) {
												$site['hide_updraftplus'] = 1;
											}

											$updraftDS = isset( $updraft_data_sites[ $site['id'] ] ) ? $updraft_data_sites[ $site['id'] ] : array();
											if ( ! is_array( $updraftDS ) ) {
												$updraftDS = array(); 												
											}
											$site['nextsched_files_gmt'] = isset( $updraftDS['nextsched_files_gmt'] ) ? $updraftDS['nextsched_files_gmt'] : 0;
											$site['nextsched_files_timezone'] = (isset( $updraftDS['nextsched_files_timezone'] ) && ! empty( $updraftDS['nextsched_files_timezone'] )) ? $updraftDS['nextsched_files_timezone'] : $_text;
											$site['nextsched_database_gmt'] = isset( $updraftDS['nextsched_database_gmt'] ) ? $updraftDS['nextsched_database_gmt'] : 0;
											$site['nextsched_database_timezone'] = (isset( $updraftDS['nextsched_database_timezone'] ) && ! empty( $updraftDS['nextsched_database_timezone'] )) ? $updraftDS['nextsched_database_timezone'] : $_text;
											$site['nextsched_current_timegmt'] = isset( $updraftDS['nextsched_current_timegmt'] ) ? $updraftDS['nextsched_current_timegmt'] : 0;
											$site['nextsched_current_timezone'] = isset( $updraftDS['nextsched_current_timezone'] ) ? $updraftDS['nextsched_current_timezone'] : '';
											$site['mainwp_updraft_backup_history_html'] = isset( $updraftDS['mainwp_updraft_backup_history_html'] ) ? $updraftDS['mainwp_updraft_backup_history_html'] : '';
											$site['mainwp_updraft_backup_history_count'] = isset( $updraftDS['mainwp_updraft_backup_history_count'] ) ? $updraftDS['mainwp_updraft_backup_history_count'] : '';
											$site['isPremium'] = isset( $updraftDS['is_premium'] ) ? $updraftDS['is_premium'] : 0;
											$site['isOverride'] = isset( $updraftDS['override_settings'] ) ? $updraftDS['override_settings'] : 0;
											$site['individual_in_use'] = isset( $in_use[$website->id] ) ? $in_use[$website->id]  : 0 ;
											$websites_updraftplus[] = $site;
											break;
								}
							}
						}
					}
				}
			} else {
					global $mainWPUpdraftPlusBackupsExtensionActivator;

					$group_websites = apply_filters( 'mainwp-getdbsites', $mainWPUpdraftPlusBackupsExtensionActivator->get_child_file(), $mainWPUpdraftPlusBackupsExtensionActivator->get_child_key(), array(), array( $selected_group ) );
					$sites = array();
				foreach ( $group_websites as $site ) {
						$sites[] = $site->id;
				}
				foreach ( $websites as $website ) {
					if ( $website && $website->plugins != '' && in_array( $website->id, $sites ) ) {
							$plugins = json_decode( $website->plugins, 1 );
						if ( is_array( $plugins ) && count( $plugins ) != 0 ) {
							foreach ( $plugins as $plugin ) {
								if ( ('updraftplus/updraftplus.php' == $plugin['slug']) ) {
										$site = MainWP_Updraftplus_Backups_Utility::map_site( $website, array( 'id', 'name', 'url' ) );
									if ( $plugin['active'] ) {
											$site['updraftplus_active'] = 1; 											
									} else {
											$site['updraftplus_active'] = 0; 											
									}
									$site['updraftplus_plugin_version'] = $plugin['version'];
									// get upgrade info
									$plugin_upgrades = json_decode( $website->plugin_upgrades, 1 );
									if ( is_array( $plugin_upgrades ) && count( $plugin_upgrades ) > 0 ) {
										if ( isset( $plugin_upgrades['updraftplus/updraftplus.php'] ) ) {
												$upgrade = $plugin_upgrades['updraftplus/updraftplus.php'];
											if ( isset( $upgrade['update'] ) ) {
													$site['updraftplus_upgrade'] = $upgrade['update'];
											}
										}
									}
										$site['hide_updraftplus'] = 0;
									if ( isset( $updraftHide[ $website->id ] ) && $updraftHide[ $website->id ] ) {
										$site['hide_updraftplus'] = 1;
									}

									$updraftDS = isset( $updraft_data_sites[ $site['id'] ] ) ? $updraft_data_sites[ $site['id'] ] : array();
									if ( ! is_array( $updraftDS ) ) {
										$updraftDS = array(); 												
									}

									$site['nextsched_files_gmt'] = isset( $updraftDS['nextsched_files_gmt'] ) ? $updraftDS['nextsched_files_gmt'] : 0;
									$site['nextsched_files_timezone'] = isset( $updraftDS['nextsched_files_timezone'] ) ? $updraftDS['nextsched_files_timezone'] : $_text;
									$site['nextsched_database_gmt'] = isset( $updraftDS['nextsched_database_gmt'] ) ? $updraftDS['nextsched_database_gmt'] : 0;
									$site['nextsched_database_timezone'] = isset( $updraftDS['nextsched_database_timezone'] ) ? $updraftDS['nextsched_database_timezone'] : $_text;
									$site['nextsched_current_timegmt'] = isset( $updraftDS['nextsched_current_timegmt'] ) ? $updraftDS['nextsched_current_timegmt'] : 0;
									$site['nextsched_current_timezone'] = isset( $updraftDS['nextsched_current_timezone'] ) ? $updraftDS['nextsched_current_timezone'] : '';
									$site['mainwp_updraft_backup_history_html'] = isset( $updraftDS['mainwp_updraft_backup_history_html'] ) ? $updraftDS['mainwp_updraft_backup_history_html'] : '';
									$site['mainwp_updraft_backup_history_count'] = isset( $updraftDS['mainwp_updraft_backup_history_count'] ) ? $updraftDS['mainwp_updraft_backup_history_count'] : '';
									$site['isPremium'] = $updraftDS['is_premium'];
									$site['isOverride'] = $updraftDS['override_settings'];
									$site['individual_in_use'] = isset( $in_use[$website->id] ) ? $in_use[$website->id]  : 0 ;
									$websites_updraftplus[] = $site;
									break;
								}
							}
						}
					}
				}
			}
		}

		// if search action
		$search_sites = array();
		if ( isset( $_GET['s'] ) && ! empty( $_GET['s'] ) ) {
				$find = trim( $_GET['s'] );
			foreach ( $websites_updraftplus as $website ) {
				if ( stripos( $website['name'], $find ) !== false || stripos( $website['url'], $find ) !== false ) {
						$search_sites[] = $website;
				}
			}
				$websites_updraftplus = $search_sites;
		}
		unset( $search_sites );

		return $websites_updraftplus;
	}

	public static function gen_select_sites( $websites, $selected_group ) {
			global $mainWPUpdraftPlusBackupsExtensionActivator, $mainwp_updraft_globals;
			//$websites = apply_filters('mainwp-getsites', $mainWPUpdraftPlusBackupsExtensionActivator->get_child_file(), $mainWPUpdraftPlusBackupsExtensionActivator->get_child_key(), null);
			$groups = apply_filters( 'mainwp-getgroups', $mainWPUpdraftPlusBackupsExtensionActivator->get_child_file(), $mainWPUpdraftPlusBackupsExtensionActivator->get_child_key(), null );
			$search = (isset( $_GET['s'] ) && ! empty( $_GET['s'] )) ? trim( $_GET['s'] ) : '';
			?> 

			<div class="alignleft actions bulkactions">
				<select id="mwp_updraftplus_plugin_action">
					<option selected="selected" value="-1"><?php _e( 'Bulk Actions' ); ?></option>
					<option value="activate-selected"><?php _e( 'Active' ); ?></option>
					<option value="update-selected"><?php _e( 'Update' ); ?></option>
					<option value="hide-selected"><?php _e( 'Hide' ); ?></option>
					<option value="show-selected"><?php _e( 'Show' ); ?></option>
				</select>
				<input type="button" value="<?php _e( 'Apply' ); ?>" class="button action" id="updraftplus_plugin_doaction_btn" name="">
                </div>

                <div class="alignleft actions">
				<form action="" method="GET">
					<input type="hidden" name="page" value="Extensions-Mainwp-Updraftplus-Extension">
					<span role="status" aria-live="polite" class="ui-helper-hidden-accessible"><?php _e( 'No search results.', 'mainwp' ); ?></span>
					<input type="text" class="mainwp_autocomplete ui-autocomplete-input" name="s" autocompletelist="sites" value="<?php echo stripslashes( $search ); ?>" autocomplete="off">
					<datalist id="sites">
						<?php
						if ( is_array( $websites ) && count( $websites ) > 0 ) {
							foreach ( $websites as $website ) {
									echo '<option>' . stripslashes( $website['name'] ) . '</option>';
							}
						}
						?>                
                        </datalist>
                        <input type="submit" name="" class="button" value="Search Sites">
                    </form>
                </div>    
                <div class="alignleft actions">
                    <form method="post" action="admin.php?page=Extensions-Mainwp-Updraftplus-Extension">
                        <select name="mainwp_updraftplus_plugin_groups_select">
						<option value="0"><?php _e( 'Select a group' ); ?></option>
							<?php
							if ( is_array( $groups ) && count( $groups ) > 0 ) {
								foreach ( $groups as $group ) {
										$_select = '';
									if ( $selected_group == $group['id'] ) {
											$_select = 'selected '; }
										echo '<option value="' . $group['id'] . '" ' . $_select . '>' . $group['name'] . '</option>';
								}
							}
							?>
                        </select>&nbsp;&nbsp;                     
						<input class="button" type="submit" name="mwp_updraftplus_plugin_btn_display" value="<?php _e( 'Display', 'mainwp' ); ?>">
                    </form>  
                </div>    
				<?php
				return;
	}

	public function dismiss_notice() {
			$website_id = $_POST['updraftRequestSiteID'];
			$version = $_POST['new_version'];
		if ( $website_id ) {
				session_start();
				$dismiss = $_SESSION['mainwp_updraftplus_dismiss_upgrade_plugin_notis'];
			if ( is_array( $dismiss ) && count( $dismiss ) > 0 ) {
					$dismiss[ $website_id ] = 1;
			} else {
					$dismiss = array();
					$dismiss[ $website_id ] = 1;
			}
				$_SESSION['mainwp_updraftplus_dismiss_upgrade_plugin_notis'] = $dismiss;
				die( 'updated' );
		}
			die( 'nochange' );
	}

	public function active_plugin() {
			$_POST['websiteId'] = $_POST['updraftRequestSiteID'];
			do_action( 'mainwp_activePlugin' );
			die();
	}

	public function upgrade_plugin() {
			$_POST['websiteId'] = $_POST['updraftRequestSiteID'];
			do_action( 'mainwp_upgradePluginTheme' );
			die();
	}

	public function showhide_plugin() {
			$siteid = isset( $_POST['updraftRequestSiteID'] ) ? $_POST['updraftRequestSiteID'] : null;
			$showhide = isset( $_POST['showhide'] ) ? $_POST['showhide'] : null;
		if ( null !== $siteid && null !== $showhide ) {
				global $mainWPUpdraftPlusBackupsExtensionActivator;
				$post_data = array(
			'mwp_action' => 'set_showhide',
					'showhide' => $showhide,
				);
				$information = apply_filters( 'mainwp_fetchurlauthed', $mainWPUpdraftPlusBackupsExtensionActivator->get_child_file(), $mainWPUpdraftPlusBackupsExtensionActivator->get_child_key(), $siteid, 'updraftplus', $post_data );

				if ( is_array( $information ) && isset( $information['result'] ) && 'SUCCESS' === $information['result'] ) {
						$hide_updraftplus = $this->get_option( 'hide_the_plugin' );
					if ( ! is_array( $hide_updraftplus ) ) {
							$hide_updraftplus = array(); }
						$hide_updraftplus[ $siteid ] = ('hide' === $showhide) ? 1 : 0;
						$this->set_option( 'hide_the_plugin', $hide_updraftplus );
				}
				die( json_encode( $information ) );
		}
			die();
	}
}
