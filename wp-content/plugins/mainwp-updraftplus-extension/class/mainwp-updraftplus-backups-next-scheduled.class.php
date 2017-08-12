<?php

class MainWP_Updraftplus_Backups_Next_Scheduled {

	private static $order = '';
	private static $orderby = '';
		//Singleton
	private static $instance = null;

	static function get_instance() {
		if ( null == MainWP_Updraftplus_Backups_Next_Scheduled::$instance ) {
				MainWP_Updraftplus_Backups_Next_Scheduled::$instance = new MainWP_Updraftplus_Backups_Next_Scheduled();
		}
			return MainWP_Updraftplus_Backups_Next_Scheduled::$instance;
	}

	public function __construct() {

	}

	public function admin_init() {
			add_action( 'wp_ajax_mainwp_updraftplus_data_refresh', array( $this, 'ajax_data_refresh' ) );
	}

	public function ajax_data_refresh() {
			@ini_set( 'display_errors', false );
			@error_reporting( 0 );

			$siteid = isset( $_POST['updraftRequestSiteID'] ) ? $_POST['updraftRequestSiteID'] : null;
		if ( empty( $siteid ) ) {
				die( json_encode( array( 'error' => 'Empty site id.' ) ) ); }

			global $mainWPUpdraftPlusBackupsExtensionActivator;
			$post_data = array( 'mwp_action' => 'reload_data' );

			$information = apply_filters( 'mainwp_fetchurlauthed', $mainWPUpdraftPlusBackupsExtensionActivator->get_child_file(), $mainWPUpdraftPlusBackupsExtensionActivator->get_child_key(), $siteid, 'updraftplus', $post_data );

		if ( is_array( $information ) && isset( $information['nextsched_current_timegmt'] ) ) {
				global $mainwp_updraftplus;
				$mainwp_updraftplus->save_reload_data( $information, $siteid );
				unset( $information['updraft_historystatus'] );
				unset( $information['updraft_lastbackup_html'] );
				unset( $information['updraft_lastbackup_gmttime'] );

				die( json_encode( $information ) );
		}
			die();
	}

	public function gen_next_scheduled_backups_tab( $websites ) {

		$orderby = 'name';
		$_order = 'desc';
		
		if ( isset( $_GET['updraftplus_scheduled_orderby'] ) && ! empty( $_GET['updraftplus_scheduled_orderby'] ) ) {
			$orderby = $_GET['updraftplus_scheduled_orderby'];
		}
		
		if ( isset( $_GET['updraftplus_order'] ) && ! empty( $_GET['updraftplus_order'] ) ) {
			$_order = $_GET['updraftplus_order'];
		}

		$name_order = $database_order = $status_order = $last_scan_order = $time_order = $file_order = $settings_order = '';

		if ( isset( $_GET['updraftplus_scheduled_orderby'] ) ) {
			if ( 'name' == $_GET['updraftplus_scheduled_orderby'] ) {
					$name_order = ('desc' == $_order) ? 'asc' : 'desc';
			} else if ( 'database' == $_GET['updraftplus_scheduled_orderby'] ) {
					$database_order = ('desc' == $_order) ? 'asc' : 'desc';
			} else if ( 'files' == $_GET['updraftplus_scheduled_orderby'] ) {
					$file_order = ('desc' == $_order) ? 'asc' : 'desc';
			} else if ( 'time' == $_GET['updraftplus_scheduled_orderby'] ) {
					$time_order = ('desc' == $_order) ? 'asc' : 'desc';
			} else if ( 'settings' == $_GET['updraftplus_scheduled_orderby'] ) {
					$settings_order = ('desc' == $_order) ? 'asc' : 'desc';
			} 			
		}

		self::$order = $_order;
		self::$orderby = $orderby;

		usort( $websites, array( 'MainWP_Updraftplus_Backups_Next_Scheduled', 'updraftplus_data_sort' ) );
			?>
			<table id="mainwp-table-plugins" class="wp-list-table widefat plugins" cellspacing="0">
				<thead>
					<tr>    
						<th class="check-column">
							<input type="checkbox"  id="cb-select-all-1" >
						</th>
						<th scope="col" class="manage-column sortable <?php echo $name_order; ?>">
							<a href="?page=Extensions-Mainwp-Updraftplus-Extension&updraftplus_scheduled_orderby=name&updraftplus_order=<?php echo (empty( $name_order ) ? 'asc' : $name_order); ?>"><span><?php _e( 'Site', 'mainwp' ); ?></span><span class="sorting-indicator"></span></a>
						</th>
						<th scope="col" class="manage-column sortable <?php echo $file_order; ?>">
							<a href="?page=Extensions-Mainwp-Updraftplus-Extension&updraftplus_scheduled_orderby=files&updraftplus_order=<?php echo (empty( $file_order ) ? 'asc' : $file_order); ?>"><span><?php _e( 'Files', 'mainwp' ); ?></span><span class="sorting-indicator"></span></a>
						</th>  
						<th scope="col" class="manage-column sortable <?php echo $database_order; ?>">
							<a href="?page=Extensions-Mainwp-Updraftplus-Extension&updraftplus_scheduled_orderby=database&updraftplus_order=<?php echo (empty( $database_order ) ? 'asc' : $database_order); ?>"><span><?php _e( 'Database', 'mainwp' ); ?></span><span class="sorting-indicator"></span></a>
						</th>
						<th scope="col" class="manage-column <?php echo $time_order; ?>">
							<a href="?page=Extensions-Mainwp-Updraftplus-Extension&updraftplus_scheduled_orderby=time&updraftplus_order=<?php echo (empty( $time_order ) ? 'asc' : $time_order); ?>"><span><?php _e( 'Time now', 'mainwp' ); ?></span><span class="sorting-indicator"></span></a>
						</th>						
						<th scope="col" class="manage-column">
							<span><?php _e( 'Backup now', 'mainwp' ); ?></span>
						</th>
					</tr>
				</thead>
				<tfoot>
					<tr>   
						<th class="check-column">
							<input type="checkbox"  id="cb-select-all-1" >
						</th>
						<th scope="col" class="manage-column sortable <?php echo $name_order; ?>">
							<a href="?page=Extensions-Mainwp-Updraftplus-Extension&updraftplus_scheduled_orderby=name&updraftplus_order=<?php echo (empty( $name_order ) ? 'asc' : $name_order); ?>"><span><?php _e( 'Site', 'mainwp' ); ?></span><span class="sorting-indicator"></span></a>
						</th>
						<th scope="col" class="manage-column sortable <?php echo $file_order; ?>">
							<a href="?page=Extensions-Mainwp-Updraftplus-Extension&updraftplus_scheduled_orderby=files&updraftplus_order=<?php echo (empty( $file_order ) ? 'asc' : $file_order); ?>"><span><?php _e( 'Files', 'mainwp' ); ?></span><span class="sorting-indicator"></span></a>
						</th>          
						<th scope="col" class="manage-column sortable <?php echo $database_order; ?>">
							<a href="?page=Extensions-Mainwp-Updraftplus-Extension&updraftplus_scheduled_orderby=database&updraftplus_order=<?php echo (empty( $database_order ) ? 'asc' : $database_order); ?>"><span><?php _e( 'Database', 'mainwp' ); ?></span><span class="sorting-indicator"></span></a>
						</th>     
						<th scope="col" class="manage-column <?php echo $time_order; ?>">
							<a href="?page=Extensions-Mainwp-Updraftplus-Extension&updraftplus_scheduled_orderby=time&updraftplus_order=<?php echo (empty( $time_order ) ? 'asc' : $time_order); ?>"><span><?php _e( 'Time now', 'mainwp' ); ?></span><span class="sorting-indicator"></span></a>
						</th>						
						<th scope="col" class="manage-column">
							<span><?php _e( 'Backup now', 'mainwp' ); ?></span>
						</th>
					</tr>
				</tfoot>
				<tbody id="the-updraftplus-scheduled-list" class="list:sites">
					<?php
					if ( is_array( $websites ) && count( $websites ) > 0 ) {
							self::get_scheduled_table_row( $websites );
					} else {
							_e( '<tr><td colspan="8">No websites were found with the Updraftplus Backups plugin installed.</td></tr>' );
					}
					?>
                    </tbody>
                </table>
				<?php
	}

	public static function get_scheduled_table_row( $websites ) {

			$url_loader = plugins_url( 'images/loader.gif', dirname( __FILE__ ) );

		foreach ( $websites as $website ) {
			if ( ! isset( $website['updraftplus_active'] ) || empty( $website['updraftplus_active'] ) ) {
					continue; }
				$website_id = $website['id'];
				?>
				<tr website-id="<?php echo $website_id; ?>" class="active"> 
					<th class="check-column">
						<input type="checkbox"  name="checked[]">
					</th>
					<td>
						<a href="admin.php?page=managesites&dashboard=<?php echo $website_id; ?>"><?php echo stripslashes( $website['name'] ); ?></a><br/>
																																																						<div class="row-actions"><span class="dashboard"><a href="admin.php?page=managesites&dashboard=<?php echo $website_id; ?>"><i class="fa fa-tachometer"></i> <?php _e( 'Overview' ); ?></a></span> | <span class="edit"><a href="#" onclick="showUpdraftplusTab(false, false, false, false, true);
															return false;" ><i class="fa fa-pencil-square-o"></i> <?php _e( 'Edit Global Schedule', 'mainwp-updraftplus-extension' ); ?></a> | <a href="admin.php?page=ManageSitesUpdraftplus&id=<?php echo $website_id; ?>&tab=settings"><i class="fa fa-pencil-square-o"></i> <?php _e( 'Edit Individual Schedule', 'mainwp-updraftplus-extension' ); ?></a></span></div>                    
						<div class="its-action-working"><span class="status" style="display:none;"></span><span class="loading" style="display:none;"><img src="<?php echo $url_loader; ?>"> <?php _e( 'Running ...' ); ?></span></div>
					</td>               
					<td>
						<span class="mwp-scheduled-files mwp-scheduled-text"><?php echo $website['nextsched_files_timezone']; ?></span>
					</td>
					<td>
						<span class="mwp-scheduled-database mwp-scheduled-text"><?php echo $website['nextsched_database_timezone']; ?></span>
					</td>     
					<td>
						<span class="mwp-scheduled-currenttime mwp-scheduled-text"><?php echo $website['nextsched_current_timezone']; ?></span>
					</td>
					<td>
						<span><a href="admin.php?page=ManageSitesUpdraftplus&id=<?php echo $website_id; ?>"><i class="fa fa-hdd-o"></i> <?php _e( 'Backup Now', 'mainwp-updraftplus-extension' ); ?></a></span>
					</td>
					</tr>        
					<?php
		}
	}

	public static function updraftplus_data_sort( $a, $b ) {
		if ( 'files' == self::$orderby ) {
				$a = $a['nextsched_files_gmt'];
				$b = $b['nextsched_files_gmt'];
				$cmp = $a - $b;
		} else if ( 'database' == self::$orderby ) {
				$a = $a['nextsched_database_gmt'];
				$b = $b['nextsched_database_gmt'];
				$cmp = $a - $b;
		} else if ( 'time' == self::$orderby ) {
				$a = $a['nextsched_current_timegmt'];
				$b = $b['nextsched_current_timegmt'];
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
}
