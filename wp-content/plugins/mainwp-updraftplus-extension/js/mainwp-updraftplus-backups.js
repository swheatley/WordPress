jQuery( document ).ready(function ($) {
	$( '#mwp_updraftplus_dashboard_tab_lnk' ).on('click', function () {
		showUpdraftplusTab( true, false, false, false, false );
		return false;
	});

	$( '#mwp_updraftplus_scheduled_tab_lnk' ).on('click', function () {
		showUpdraftplusTab( false, true, false, false, false );
		return false;
	});

	$( '#mwp_updraftplus_status_tab_lnk' ).on('click', function () {
		showUpdraftplusTab( false, false, true, false, false );
		return false;
	});
	$( '#mwp_updraftplus_backup_tab_lnk' ).on('click', function () {
		mainwp_updraft_openrestorepanel( 1 );
		showUpdraftplusTab( false, false, false, true, false );
		return false;
	});
	$( '#mwp_updraftplus_setting_tab_lnk' ).on('click', function () {
		showUpdraftplusTab( false, false, false, false, true );
		return false;
	});

	//    $('.updraftplus_tabs_lnk a').on('click', function () {
	//        if (jQuery(this).attr('id') != 'mwp_updraftplus_dashboard_tab_lnk') {
	//            jQuery('.updraftplus_tabs_lnk a').removeClass('mainwp_action_down');
	//            jQuery(this).addClass('mainwp_action_down');
	//        }
	//    });

	//    jQuery('#mwp-updraftplus-backupnow-modal').dialog({
	//        autoOpen: false, height: 355, width: 480, modal: true,
	//        close: function(event, ui) {jQuery('#mwp-updraftplus-backupnow-modal').dialog('destroy');}
	//    });

	$( '#mwp_updraftplus_settings_save_btn' ).on('click', function () {
		var statusEl = jQuery( '#mwp_updraftplus_site_save_settings_status' );
		var loaderEl = jQuery( '#updraftplus_site_settings img.loader' );
		statusEl.hide();
		loaderEl.show();
                var over = $( '#mainwp_updraftplus_override_general_settings' ).is( ":checked" ) ? 1 : 0;
		data = {
			action: 'mainwp_updraftplus_site_override_settings',
			updraftRequestSiteID: $( 'input[name=mainwp_updraftplus_settings_site_id]' ).val(),
			override: over 
		};
		jQuery.post(ajaxurl, data, function (response) {
			loaderEl.hide();
			if (response) {
				if (response.error) {
					statusEl.css( 'color', 'red' );
					statusEl.html( response.error );
				} else if (response.result == 'success') {
					statusEl.css( 'color', '#21759B' );
					statusEl.html( __( 'Saved.' ) );
					setTimeout(function ()
                                        {
                                            statusEl.fadeOut();
					}, 3000);
                                        if (over) {
                                            jQuery('input[name=save-general-settings-to-site]').removeAttr('disabled').show();
                                        } else {
                                            jQuery('input[name=save-general-settings-to-site]').attr('disabled', 'true').hide();
                                        }                                        
				} else {
					statusEl.css( 'color', 'red' );
					statusEl.html( 'Undefined error' );
				}
			} else {
				statusEl.css( 'color', 'red' );
				statusEl.html( 'Undefined error' );
			}
			statusEl.fadeIn();
		}, 'json');

		return false;
	});

        jQuery('input[name=save-general-settings-to-site]').on('click', function () {
            var site_id = $( 'input[name=mainwp_updraftplus_settings_site_id]' ).val();
            mainwp_updraftplus_individual_save_settings(site_id, 1);
        });
        
});

showUpdraftplusTab = function (dashboard, scheduled, status, backup, setting) {

	var dashboard_tab_lnk = jQuery( "#mwp_updraftplus_dashboard_tab_lnk" );
	if (dashboard) {
		dashboard_tab_lnk.addClass( 'mainwp_action_down' ); } else {
		dashboard_tab_lnk.removeClass( 'mainwp_action_down' ); }

		var scheduled_tab_lnk = jQuery( "#mwp_updraftplus_scheduled_tab_lnk" );
		if (scheduled) {
			scheduled_tab_lnk.addClass( 'mainwp_action_down' ); } else {
			scheduled_tab_lnk.removeClass( 'mainwp_action_down' ); }

			var status_tab_lnk = jQuery( "#mwp_updraftplus_status_tab_lnk" );
			if (status) {
				status_tab_lnk.addClass( 'mainwp_action_down' ); } else {
				status_tab_lnk.removeClass( 'mainwp_action_down' ); }

				var backup_tab_lnk = jQuery( "#mwp_updraftplus_backup_tab_lnk" );
				if (backup) {
					backup_tab_lnk.addClass( 'mainwp_action_down' ); } else {
					backup_tab_lnk.removeClass( 'mainwp_action_down' ); }

					var setting_tab_lnk = jQuery( "#mwp_updraftplus_setting_tab_lnk" );
					if (setting) {
						setting_tab_lnk.addClass( 'mainwp_action_down' ); } else {
						setting_tab_lnk.removeClass( 'mainwp_action_down' ); }

						var dashboard_tab = jQuery( "#mwp_updraftplus_dashboard_tab" );
						var scheduled_tab = jQuery( "#mwp_updraftplus_nextscheduled_tab" );
						var status_tab = jQuery( "#mwp_updraftplus_status_tab" );
						var backup_tab = jQuery( "#mwp_updraftplus_backup_tab" );
						var setting_tab = jQuery( "#mwp_updraftplus_setting_tab" );

						if (dashboard) {
							dashboard_tab.show();
							scheduled_tab.hide();
							status_tab.hide();
							backup_tab.hide();
							setting_tab.hide();
						} else if (scheduled) {
							dashboard_tab.hide();
							scheduled_tab.show();
							status_tab.hide();
							backup_tab.hide();
							setting_tab.hide();
						} else if (status) {
							dashboard_tab.hide();
							scheduled_tab.hide();
							status_tab.show();
							backup_tab.hide();
							setting_tab.hide();
						} else if (backup) {
							dashboard_tab.hide();
							scheduled_tab.hide();
							status_tab.hide();
							backup_tab.show();
							setting_tab.hide();
						} else if (setting) {
							dashboard_tab.hide();
							scheduled_tab.hide();
							status_tab.hide();
							backup_tab.hide();
							setting_tab.show();
						}

};

jQuery( document ).ready(function ($) {

	jQuery( '#mainwp-updraftplus-tips .mainwp-show-tut' ).on('click', function () {
		jQuery( '.mainwp-updraftplus-tut' ).hide();
		var num = jQuery( this ).attr( 'number' );
		jQuery( '.mainwp-updraftplus-tut[number="' + num + '"]' ).show();
		mainwp_setCookie( 'mwp_updraftplus_quick_tut_number', jQuery( this ).attr( 'number' ) );
		return false;
	});

	jQuery( '#mainwp-updraftplus-quick-start-guide' ).on('click', function () {
		if (mainwp_getCookie( 'mwp_updraftplus_quick_guide' ) == 'on') {
			mainwp_setCookie( 'mwp_updraftplus_quick_guide', '' ); } else {
			mainwp_setCookie( 'mwp_updraftplus_quick_guide', 'on' ); }
			mwp_updraftplus_showhide_quick_guide();
			return false;
	});
	jQuery( '#mainwp-updraftplus-tips-dismiss' ).on('click', function () {
		mainwp_setCookie( 'mwp_updraftplus_quick_guide', '' );
		mwp_updraftplus_showhide_quick_guide();
		return false;
	});

	mwp_updraftplus_showhide_quick_guide();

});

mwp_updraftplus_showhide_quick_guide = function () {
	var show = mainwp_getCookie( 'mwp_updraftplus_quick_guide' );
	if (show == 'on') {
		jQuery( '#mainwp-updraftplus-tips' ).show();
		jQuery( '#mainwp-updraftplus-quick-start-guide' ).hide();
		mwp_updraftplus_showhide_quick_tut();
	} else {
		jQuery( '#mainwp-updraftplus-tips' ).hide();
		jQuery( '#mainwp-updraftplus-quick-start-guide' ).show();
	}
}

mwp_updraftplus_showhide_quick_tut = function () {
	var tut = mainwp_getCookie( 'mwp_updraftplus_quick_tut_number' );
	jQuery( '.mainwp-updraftplus-tut' ).hide();
	jQuery( '.mainwp-updraftplus-tut[number="' + tut + '"]' ).show();
}

jQuery( document ).ready(function ($) {
	$( '.updraftplus_plugin_upgrade_noti_dismiss' ).live('click', function () {
		var parent = $( this ).closest( '.ext-upgrade-noti' );
		parent.hide();
		var data = {
			action: 'mainwp_updraftplus_upgrade_noti_dismiss',
			updraftRequestSiteID: parent.attr( 'website-id' ),
			new_version: parent.attr( 'version' ),
		}
		jQuery.post(ajaxurl, data, function (response) {

		});
		return false;
	});

	$( '.mwp_updraftplus_active_plugin' ).on('click', function () {
		mainwp_updraftplus_plugin_active_start_specific( $( this ), false );
		return false;
	});

	$( '.mwp_updraftplus_upgrade_plugin' ).on('click', function () {
		mainwp_updraftplus_plugin_upgrade_start_specific( $( this ), false );
		return false;
	});

	$( '.mwp_updraftplus_showhide_plugin' ).on('click', function () {
		mainwp_updraftplus_plugin_showhide_start_specific( $( this ), false );
		return false;
	});

	$( '#updraftplus_plugin_doaction_btn' ).on('click', function () {
		var bulk_act = $( '#mwp_updraftplus_plugin_action' ).val();
		mainwp_updraftplus_plugin_do_bulk_action( bulk_act );
	});

	$( '#mwp_updraftplus_refresh' ).on('click', function () {
		var messageEl = jQuery( '#mwp_updraft_info' );
		messageEl.hide();
		updraftplus_scheduled_bulkTotalThreads = jQuery( '#the-updraftplus-scheduled-list th.check-column input[type="checkbox"]:checked' ).length;
		if (updraftplus_scheduled_bulkTotalThreads == 0) {
			messageEl.html( 'You must select at least one item.' ).fadeIn();
			return false;
		}
		jQuery( selector ).closest( 'tr' ).find( '.check-column input[type="checkbox"]:checked' ).addClass( 'queue' );
		$( this ).attr( 'disabled', 'true' );
		jQuery( '#the-updraftplus-scheduled-list .check-column input[type="checkbox"]:checked' ).closest( 'tr' ).find( '.its-action-working' ).addClass( 'queue' );

		var selector = '#the-updraftplus-scheduled-list tr .its-action-working';
		updraftplus_scheduled_bulkFinishedThreads = 0;
		mainwp_updraftplus_scheduledbackups_start_next( selector );
	});

});

var updraftplus_bulkMaxThreads = 3;
var updraftplus_bulkTotalThreads = 0;
var updraftplus_bulkCurrentThreads = 0;
var updraftplus_bulkFinishedThreads = 0;

function mainwp_updraft_general_updatehistory(pRescan, pRemotescan) {

	var loadingEl = jQuery( '.mwp_updraft_general_rescan_links .loading' );
	var errorEl = jQuery( '#mwp_updraft_backup_error' );
	errorEl.hide();
	loadingEl.show();
	var data = {
		action: 'mainwp_updraftplus_load_sites',
		what: 'update_history',
		rescan: pRescan,
		remotescan: pRemotescan
	};
	jQuery.post(ajaxurl, data, function (response) {
		loadingEl.hide();
		if (response) {
			if (response.error) {
				errorEl.html( response.error ).show(); } else {
				jQuery( '#mwp_updraftplus_backup_tab' ).html( response );
				updraftplus_bulkTotalThreads = jQuery( '.siteItemProcess[status=queue]' ).length;
				if (updraftplus_bulkTotalThreads > 0) {
					mainwp_updraft_general_rescan_start_next( pRescan, pRemotescan ); }
				}
		} else {
			errorEl.html( __( "Undefined error." ) ).show();
		}

		setTimeout(function ()
			{
			errorEl.hide();
		}, 5000);
	})
}

mainwp_updraft_general_rescan_start_next = function (pRescan, pRemotescan) {
	while ((objProcess = jQuery( '.siteItemProcess[status=queue]:first' )) && (objProcess.length > 0) && (updraftplus_bulkCurrentThreads < updraftplus_bulkMaxThreads)) {
		objProcess.attr( 'status', 'processed' );
		mainwp_updraft_general_rescan_start_specific( objProcess, pRescan, pRemotescan );
	}

	if (updraftplus_bulkFinishedThreads > 0 && updraftplus_bulkFinishedThreads == updraftplus_bulkTotalThreads) {
		jQuery( '#mwp_updraftplus_backup_tab' ).append( '<div class="mainwp_info-box">' + __( "Rescan finished." ) + '</div><p><a class="button-primary" href="admin.php?page=Extensions-Mainwp-Updraftplus-Extension&tab=backups">Return to Existing Backups</a></p>' );
		setTimeout(function ()
			{
			//location.href = location.href;
		}, 3000);
	}

}

mainwp_updraft_general_rescan_start_specific = function (objProcess, pRescan, pRemotescan) {
	var loadingEl = objProcess.find( 'img' );
	var statusEl = objProcess.find( '.status' );
	updraftplus_bulkCurrentThreads++;
	var data = {
		action: 'mainwp_updraft_rescan_history_backups',
		updraftRequestSiteID: objProcess.attr( 'site-id' ),
		rescan: pRescan,
		remotescan: pRemotescan,
		generalscan: 1
	};

	statusEl.html( '' );
	loadingEl.show();
	//call the ajax
	jQuery.post(ajaxurl, data, function (response) {
		loadingEl.hide();
		if (response) {
			if (response.error) {
				statusEl.css( 'color', 'red' );
				statusEl.html( response.error );
			} else if (response.result == 'success') {
				statusEl.css( 'color', '#21759B' );
				statusEl.html( __( 'Successful' ) );
			} else if (response.result == 'fail') {
				statusEl.css( 'color', 'red' );
				statusEl.html( 'Failed' );
			} else if (response.message) {
				statusEl.css( 'color', '#21759B' );
				statusEl.html( response.message );
			} else {
				statusEl.css( 'color', 'red' );
				statusEl.html( 'Undefined error' );
			}
		} else {
			statusEl.css( 'color', 'red' );
			statusEl.html( 'Undefined error' );
		}

		updraftplus_bulkCurrentThreads--;
		updraftplus_bulkFinishedThreads++;
		mainwp_updraft_general_rescan_start_next();
	}, 'json');
}


mainwp_updraftplus_plugin_do_bulk_action = function (act) {
	var selector = '';
	switch (act) {
		case 'activate-selected':
			selector = '#the-mwp-updraftplus-list tr.plugin-update-tr .mwp_updraftplus_active_plugin';
			jQuery( selector ).addClass( 'queue' );
			mainwp_updraftplus_plugin_active_start_next( selector );
			break;
		case 'update-selected':
			selector = '#the-mwp-updraftplus-list tr.plugin-update-tr .mwp_updraftplus_upgrade_plugin';
			jQuery( selector ).addClass( 'queue' );
			mainwp_updraftplus_plugin_upgrade_start_next( selector );
			break;
		case 'hide-selected':
			selector = '#the-mwp-updraftplus-list tr .mwp_updraftplus_showhide_plugin[showhide="hide"]';
			jQuery( selector ).addClass( 'queue' );
			mainwp_updraftplus_plugin_showhide_start_next( selector );
			break;
		case 'show-selected':
			selector = '#the-mwp-updraftplus-list tr .mwp_updraftplus_showhide_plugin[showhide="show"]';
			jQuery( selector ).addClass( 'queue' );
			mainwp_updraftplus_plugin_showhide_start_next( selector );
			break;
	}
}

var updraftplus_scheduled_bulkCurrentThreads = 0;
var updraftplus_scheduled_bulkTotalThreads = 0;
var updraftplus_scheduled_bulkFinishedThreads = 0;

mainwp_updraftplus_scheduledbackups_start_next = function (selector) {
	while ((objProcess = jQuery( selector + '.queue:first' )) && (objProcess.length > 0) && (objProcess.closest( 'tr' ).find( '.check-column input[type="checkbox"]:checked' ).length > 0) && (updraftplus_scheduled_bulkCurrentThreads < updraftplus_bulkMaxThreads)) {
		objProcess.removeClass( 'queue' );
		if (objProcess.closest( 'tr' ).find( '.check-column input[type="checkbox"]:checked' ).length == 0) {
			continue;
		}
		mainwp_updraftplus_scheduledbackups_start_specific( objProcess, selector );
	}
	if (updraftplus_scheduled_bulkTotalThreads > 0 && updraftplus_scheduled_bulkFinishedThreads == updraftplus_scheduled_bulkTotalThreads) {
		setTimeout(function ()
			{
			window.location.href = window.location.href;
		}, 1000);
	}
}


mainwp_updraftplus_scheduledbackups_start_specific = function (pObj, selector) {
	var parent = pObj.closest( 'tr' );
	var loader = parent.find( '.its-action-working .loading' );
	var statusEl = parent.find( '.its-action-working .status' );

	updraftplus_scheduled_bulkCurrentThreads++;

	var data = {
		action: 'mainwp_updraftplus_data_refresh',
		updraftRequestSiteID: parent.attr( 'website-id' )
	}
	statusEl.hide();
	loader.show();
	jQuery.post(ajaxurl, data, function (response) {
		updraftplus_scheduled_bulkFinishedThreads++;
		loader.hide();
		pObj.removeClass( 'queue' );
		if (response && response['error']) {
			statusEl.css( 'color', 'red' );
			statusEl.html( response['error'] ).show();
		} else if (response && response.nextsched_current_timegmt) {
			if (response.nextsched_files_timezone) {
				parent.find( '.mwp-scheduled-files' ).html( response.nextsched_files_timezone ); } else {
				parent.find( '.mwp-scheduled-files' ).html( mwp_updraftlion.nothingscheduled ); }

				if (response.nextsched_database_timezone) {
					parent.find( '.mwp-scheduled-database' ).html( response.nextsched_database_timezone ); } else {
					parent.find( '.mwp-scheduled-database' ).html( mwp_updraftlion.nothingscheduled ); }

					if (response.nextsched_current_timezone) {
						parent.find( '.mwp-scheduled-currenttime' ).html( response.nextsched_current_timezone ); } else {
						parent.find( '.mwp-scheduled-currenttime' ).html( '' ); }

						statusEl.css( 'color', '#21759B' );
						statusEl.html( __( 'Successful' ) ).show();
						setTimeout(function ()
							{
							statusEl.fadeOut();
						}, 3000);
		} else {
			statusEl.css( 'color', 'red' );
			statusEl.html( __( "Undefined error" ) ).show();
		}

		updraftplus_scheduled_bulkCurrentThreads--;
		mainwp_updraftplus_scheduledbackups_start_next( selector );

	}, 'json');

	return false;
}


mainwp_updraftplus_plugin_showhide_start_next = function (selector) {
	while ((objProcess = jQuery( selector + '.queue:first' )) && (objProcess.length > 0) && (updraftplus_bulkCurrentThreads < updraftplus_bulkMaxThreads)) {
		objProcess.removeClass( 'queue' );
		if (objProcess.closest( 'tr' ).find( '.check-column input[type="checkbox"]:checked' ).length == 0) {
			continue;
		}
		mainwp_updraftplus_plugin_showhide_start_specific( objProcess, true, selector );
	}
}

mainwp_updraftplus_plugin_showhide_start_specific = function (pObj, bulk, selector) {
	var parent = pObj.closest( 'tr' );
	var loader = parent.find( '.its-action-working .loading' );
	var statusEl = parent.find( '.its-action-working .status' );
	var showhide = pObj.attr( 'showhide' );
	var pluginName = parent.attr( 'plugin-name' );
	if (bulk) {
		updraftplus_bulkCurrentThreads++; }

	var data = {
		action: 'mainwp_updraftplus_showhide_plugin',
		updraftRequestSiteID: parent.attr( 'website-id' ),
		showhide: showhide
	}
	statusEl.hide();
	loader.show();
	jQuery.post(ajaxurl, data, function (response) {
		loader.hide();
		pObj.removeClass( 'queue' );
		if (response && response['error']) {
			statusEl.css( 'color', 'red' );
			statusEl.html( response['error'] ).show();
		} else if (response && response['result'] == 'SUCCESS') {
			if (showhide == 'show') {
				pObj.text( "Hide " + pluginName + " Plugin" );
				pObj.attr( 'showhide', 'hide' );
				parent.find( '.updraftplus_hidden_title' ).html( __( 'No' ) );
			} else {
				pObj.text( "Show " + pluginName + " Plugin" );
				pObj.attr( 'showhide', 'show' );
				parent.find( '.updraftplus_hidden_title' ).html( __( 'Yes' ) );
			}

			statusEl.css( 'color', '#21759B' );
			statusEl.html( __( 'Successful' ) ).show();
			statusEl.fadeOut( 3000 );
		} else {
			statusEl.css( 'color', 'red' );
			statusEl.html( __( "Undefined error" ) ).show();
		}

		if (bulk) {
			updraftplus_bulkCurrentThreads--;
			updraftplus_bulkFinishedThreads++;
			mainwp_updraftplus_plugin_showhide_start_next( selector );
		}

	}, 'json');
	return false;
}

mainwp_updraftplus_plugin_upgrade_start_next = function (selector) {
	while ((objProcess = jQuery( selector + '.queue:first' )) && (objProcess.length > 0) && (objProcess.closest( 'tr' ).prev( 'tr' ).find( '.check-column input[type="checkbox"]:checked' ).length > 0) && (updraftplus_bulkCurrentThreads < updraftplus_bulkMaxThreads)) {
		objProcess.removeClass( 'queue' );
		if (objProcess.closest( 'tr' ).prev( 'tr' ).find( '.check-column input[type="checkbox"]:checked' ).length == 0) {
			continue;
		}
		mainwp_updraftplus_plugin_upgrade_start_specific( objProcess, true, selector );
	}
}

mainwp_updraftplus_plugin_upgrade_start_specific = function (pObj, bulk, selector) {
	var parent = pObj.closest( '.ext-upgrade-noti' );
	var workingRow = parent.find( '.mwp-updraftplus-row-working' );
	var slug = parent.attr( 'plugin-slug' );
	workingRow.find( '.status' ).html( '' );
	var data = {
		action: 'mainwp_updraftplus_upgrade_plugin',
		updraftRequestSiteID: parent.attr( 'website-id' ),
		type: 'plugin',
		'slugs[]': [slug]
	}

	if (bulk) {
		updraftplus_bulkCurrentThreads++; }

	parent.closest( 'tr' ).show();
	workingRow.find( 'img' ).show();
	jQuery.post(ajaxurl, data, function (response) {
		workingRow.find( 'img' ).hide();
		pObj.removeClass( 'queue' );
		if (response && response['error']) {
			workingRow.find( '.status' ).html( '<font color="red">' + response['error'] + '</font>' );
		} else if (response && response['upgrades'][slug]) {
			pObj.after( 'Updraftplus Backups plugin has been updated' );
			pObj.remove();
		} else {
			workingRow.find( '.status' ).html( '<font color="red">' + __( "Undefined error" ) + '</font>' );
		}

		if (bulk) {
			updraftplus_bulkCurrentThreads--;
			updraftplus_bulkFinishedThreads++;
			mainwp_updraftplus_plugin_upgrade_start_next( selector );
		}

	}, 'json');
	return false;
}

mainwp_updraftplus_plugin_active_start_next = function (selector) {
	while ((objProcess = jQuery( selector + '.queue:first' )) && (objProcess.length > 0) && (objProcess.closest( 'tr' ).prev( 'tr' ).find( '.check-column input[type="checkbox"]:checked' ).length > 0) && (updraftplus_bulkCurrentThreads < updraftplus_bulkMaxThreads)) {
		objProcess.removeClass( 'queue' );
		if (objProcess.closest( 'tr' ).prev( 'tr' ).find( '.check-column input[type="checkbox"]:checked' ).length == 0) {
			continue;
		}
		mainwp_updraftplus_plugin_active_start_specific( objProcess, true, selector );
	}
}

mainwp_updraftplus_plugin_active_start_specific = function (pObj, bulk, selector) {
	var parent = pObj.closest( '.ext-upgrade-noti' );
	var workingRow = parent.find( '.mwp-updraftplus-row-working' );
	var slug = parent.attr( 'plugin-slug' );
	var data = {
		action: 'mainwp_updraftplus_active_plugin',
		updraftRequestSiteID: parent.attr( 'website-id' ),
		'plugins[]': [slug]
	}

	if (bulk) {
		updraftplus_bulkCurrentThreads++; }

	workingRow.find( 'img' ).show();
	workingRow.find( '.status' ).html( '' );
	jQuery.post(ajaxurl, data, function (response) {
		workingRow.find( 'img' ).hide();
		pObj.removeClass( 'queue' );
		if (response && response['error']) {
			workingRow.find( '.status' ).html( '<font color="red">' + response['error'] + '</font>' );
		} else if (response && response['result']) {
			pObj.after( 'Updraftplus Backups plugin has been activated' );
			pObj.remove();
		}
		if (bulk) {
			updraftplus_bulkCurrentThreads--;
			updraftplus_bulkFinishedThreads++;
			mainwp_updraftplus_plugin_active_start_next( selector );
		}

	}, 'json');
	return false;
}

mainwp_updraftplus_individual_save_settings = function (pSiteId, saveGeneral) {
	var statusEl = jQuery( '#mwp_updraftplus_site_save_settings_status' );
        statusEl.hide();
	var loaderEl = jQuery( '#updraftplus_site_settings img.loader' );
	loaderEl.show();
        scrollToElement('#updraftplus_site_settings');
        if (saveGeneral) {
            jQuery('input[name=save-general-settings-to-site]').attr('disabled', true);
        }
	data = {
		action: 'mainwp_updraftplus_save_settings',
		updraftRequestSiteID: pSiteId,
		individual: true,   
                save_general: saveGeneral
	};
	jQuery.post(ajaxurl, data, function (response) {
                if (saveGeneral) {
                    jQuery('input[name=save-general-settings-to-site]').removeAttr('disabled');
                }
		loaderEl.hide();
		var _success = false;
		if (response) {
			if (response.error) {
				statusEl.css( 'color', 'red' );
				statusEl.html( response.error );
			} else if (response.result == 'success') {
				statusEl.css( 'color', '#21759B' );                         
                                if (saveGeneral) {
                                    statusEl.html(__('General Settings saved on the child site.'));
                                } else                                
                                    statusEl.html( __( 'Saved.' ) );
                                
				_success = true;
			} else if (response.result == 'noupdate') {
				statusEl.css( 'color', '#21759B' );
				statusEl.html( __( 'No change.' ) );
				_success = true;
			} else if (response.message) {
				statusEl.css( 'color', '#21759B' );
				statusEl.html( response.message );
			} else {
				statusEl.css( 'color', 'red' );
				statusEl.html( 'Undefined error' );
			}
		} else {
			statusEl.css( 'color', 'red' );
			statusEl.html( 'Undefined error' );
		}
		statusEl.fadeIn();
		if (_success) {
			setTimeout(function ()
				{
				//statusEl.fadeOut();
			}, 3000);
		}
	}, 'json');
}

mainwp_updraftplus_save_settings_start_next = function () {
	while ((objProcess = jQuery( '.siteItemProcess[status=queue]:first' )) && (objProcess.length > 0) && (updraftplus_bulkCurrentThreads < updraftplus_bulkMaxThreads)) {
		objProcess.attr( 'status', 'processed' );
		mainwp_updraftplus_save_settings_start_specific( objProcess );
	}

	if (updraftplus_bulkFinishedThreads > 0 && updraftplus_bulkFinishedThreads == updraftplus_bulkTotalThreads) {
		jQuery( '#mwp_updraftplus_setting_tab' ).append( '<div class="mainwp_info-box">' + __( "Save Settings finished." ) + '</div>' + '<p><a class="button-primary" href="admin.php?page=Extensions-Mainwp-Updraftplus-Extension&tab=settings">Return to Settings</a></p>' );
		setTimeout(function ()
			{
			//location.href = location.href;
		}, 1000);
	}

}

mainwp_updraftplus_save_settings_start_specific = function (objProcess) {
	var loadingEl = objProcess.find( 'img' );
	var statusEl = objProcess.find( '.status' );
	updraftplus_bulkCurrentThreads++;
	var data = {
		action: 'mainwp_updraftplus_save_settings',
		updraftRequestSiteID: objProcess.attr( 'site-id' )
	};
	statusEl.html( '' );
	loadingEl.show();
	//call the ajax
	jQuery.post(ajaxurl, data, function (response) {
		loadingEl.hide();
		if (response) {
			if (response.error) {
				statusEl.css( 'color', 'red' );
				statusEl.html( response.error );
			} else if (response.result == 'success') {
				statusEl.css( 'color', '#21759B' );
				statusEl.html( __( 'Saved.' ) );
			} else if (response.result == 'noupdate') {
				statusEl.css( 'color', '#21759B' );
				statusEl.html( __( 'No change.' ) );
			} else if (response.message) {
				statusEl.css( 'color', '#21759B' );
				statusEl.html( response.message );
			} else {
				statusEl.css( 'color', 'red' );
				statusEl.html( 'Undefined error' );
			}
		} else {
			statusEl.css( 'color', 'red' );
			statusEl.html( 'Undefined error' );
		}

		updraftplus_bulkCurrentThreads--;
		updraftplus_bulkFinishedThreads++;
		mainwp_updraftplus_save_settings_start_next();
	}, 'json');
}

mainwp_updraftplus_individual_addons_connect = function (pSiteId) {
	var statusEl = jQuery( '#mwp_updraft_site_addons_connect_working .status' );
	var loaderEl = jQuery( '#mwp_updraft_site_addons_connect_working i' );
	statusEl.html( __( 'Connect with your UpdraftPlus.Com account ...' ) );
	loaderEl.show();
	data = {
		action: 'mainwp_updraftplus_addons_connect',
		updraftRequestSiteID: pSiteId,
		individual: true
	};
	jQuery.post(ajaxurl, data, function (response) {
		loaderEl.hide();
		var _success = false;
		if (response) {
			if (response.error == 'NO_PREMIUM') {
				statusEl.css( 'color', 'red' );
				statusEl.html( __( 'No premium version.' ) );
				_success = true;
			} else if (response.error) {
				statusEl.css( 'color', 'red' );
				statusEl.html( response.error );
			} else if (response.result == 'success') {
				statusEl.css( 'color', '#21759B' );
				statusEl.html( __( 'Successful.' ) );
				_success = true;
			} else if (response.message) {
				statusEl.css( 'color', '#21759B' );
				statusEl.html( response.message );
			} else {
				statusEl.css( 'color', 'red' );
				statusEl.html( 'Undefined error' );
			}
		} else {
			statusEl.css( 'color', 'red' );
			statusEl.html( 'Undefined error' );
		}
		statusEl.fadeIn();
		if (_success) {
			setTimeout(function ()
				{
				statusEl.fadeOut();
			}, 3000);
		}
	}, 'json');
}


mainwp_updraftplus_addons_connect_start_next = function () {
	while ((objProcess = jQuery( '.siteItemProcess[status=queue]:first' )) && (objProcess.length > 0) && (updraftplus_bulkCurrentThreads < updraftplus_bulkMaxThreads)) {
		objProcess.attr( 'status', 'processed' );
		mainwp_updraftplus_addons_connect_start_specific( objProcess );
	}

	if (updraftplus_bulkFinishedThreads > 0 && updraftplus_bulkFinishedThreads == updraftplus_bulkTotalThreads) {
		jQuery( '#mwp_updraftplus_setting_tab' ).append( '<div class="mainwp_info-box">' + __( "Save Settings finished." ) + '</div>' + '<p><a class="button-primary" href="admin.php?page=Extensions-Mainwp-Updraftplus-Extension&tab=settings">Return to Settings</a></p>' );
		setTimeout(function ()
			{
			//location.href = location.href;
		}, 1000);
	}

}

mainwp_updraftplus_addons_connect_start_specific = function (objProcess) {
	var loadingEl = objProcess.find( 'img' );
	var statusEl = objProcess.find( '.status' );
	updraftplus_bulkCurrentThreads++;
	var data = {
		action: 'mainwp_updraftplus_addons_connect',
		updraftRequestSiteID: objProcess.attr( 'site-id' )
	};
	statusEl.html( '' );
	loadingEl.show();
	//call the ajax
	jQuery.post(ajaxurl, data, function (response) {
		loadingEl.hide();
		if (response) {
			if (response.error == 'NO_PREMIUM') {
				statusEl.css( 'color', 'red' );
				statusEl.html( __( 'No premium version.' ) );
				_success = true;
			} else if (response.error) {
				statusEl.css( 'color', 'red' );
				statusEl.html( response.error );
			} else if (response.result == 'success') {
				statusEl.css( 'color', '#21759B' );
				statusEl.html( __( 'Successful.' ) );
			} else if (response.message) {
				statusEl.css( 'color', '#21759B' );
				statusEl.html( response.message );
			} else {
				statusEl.css( 'color', 'red' );
				statusEl.html( 'Undefined error' );
			}
		} else {
			statusEl.css( 'color', 'red' );
			statusEl.html( 'Undefined error' );
		}

		updraftplus_bulkCurrentThreads--;
		updraftplus_bulkFinishedThreads++;
		mainwp_updraftplus_addons_connect_start_next();
	}, 'json');
}

mainwp_updraftplus_vault_connect_start_next = function () {
	while ((objProcess = jQuery( '.siteItemProcess[status=queue]:first' )) && (objProcess.length > 0) && (updraftplus_bulkCurrentThreads < updraftplus_bulkMaxThreads)) {
		objProcess.attr( 'status', 'processed' );
		mainwp_updraftplus_vault_connect_start_specific( objProcess );
	}

	if (updraftplus_bulkFinishedThreads > 0 && updraftplus_bulkFinishedThreads == updraftplus_bulkTotalThreads) {
		jQuery( '#mwp_updraftplus_setting_tab' ).append( '<div class="mainwp_info-box">' + __( "Connect child sites with UpdraftPlus Vault finished." ) + '</div>' + '<p><a class="button-primary" href="admin.php?page=Extensions-Mainwp-Updraftplus-Extension&tab=settings">Return to Settings</a></p>' );
	}

}

mainwp_updraftplus_vault_connect_start_specific = function (objProcess) {
	var loadingEl = objProcess.find( 'img' );
	var statusEl = objProcess.find( '.status' );
	updraftplus_bulkCurrentThreads++;
       
        var data = {		
                action: 'mainwp_updraft_ajax',
                subaction: 'vault_connect',
                nonce: mwp_updraft_credentialtest_nonce,
                email: jQuery('#mainwp_updraftplus_vault_opts').attr('email'),
                pass: jQuery('#mainwp_updraftplus_vault_opts').attr('pass'),
		updraftRequestSiteID: objProcess.attr( 'site-id' )
	};
	statusEl.html( '' );
	loadingEl.show();
	//call the ajax
	jQuery.post(ajaxurl, data, function (response) {
                loadingEl.hide();                
                try {
                        resp = jQuery.parseJSON(response);
                } catch(err) {
                        console.log(err);
                        console.log(response);                        
                        statusEl.css( 'color', 'red' );
                        statusEl.html( mwp_updraftlion.unexpectedresponse+' '+response );
                        return;
                }
                if (resp) {
                    if ( resp.hasOwnProperty('error')) {
                        statusEl.css( 'color', 'red' );
                        statusEl.html( resp.error );
                    } else if ( resp.hasOwnProperty('message')) {
                        statusEl.css( 'color', '#21759B' );
                        statusEl.html( resp.message );
                    } else if (resp.hasOwnProperty('e')) {                            
                        statusEl.css( 'color', '#21759B' );
                        statusEl.html( resp.e );   
                            
                    } else if (resp.hasOwnProperty('connected') && resp.connected) {
                        statusEl.css( 'color', '#21759B' );
                        statusEl.html( __('This site is connected to UpdraftPlus Vault') );                            
                    } else {                        
                        statusEl.css( 'color', 'red' );
                        statusEl.html( mwp_updraftlion.unexpectedresponse+' '+response );
                    }
                } else {
                        statusEl.css( 'color', 'red' );
                        statusEl.html( mwp_updraftlion.unexpectedresponse+' '+response );
                }
                
		updraftplus_bulkCurrentThreads--;
		updraftplus_bulkFinishedThreads++;
		mainwp_updraftplus_vault_connect_start_next();
	});
}

