<?php
if ( ! defined( 'MAINWP_UPDRAFT_PLUS_DIR' ) ) {
		die( 'No direct access allowed.' ); }

// Files can easily get too big for this method

class MainWP_Updraft_Plus_BackupModule_email {

	public function backup( $backup_array ) {

	}

	public function config_print() {
			?>
			<tr class="mwp_updraftplusmethod email">
				<th><?php _e( 'Note:', 'mainwp-updraftplus-extension' ); ?></th>
				<td><?php
					$used = apply_filters( 'mainwp_updraftplus_email_whichaddresses', sprintf( __( "Your site's admin email address (%s) will be used.", 'mainwp-updraftplus-extension' ), get_bloginfo( 'admin_email' ) ) . ' <a href="http://updraftplus.com/shop/reporting/">' . sprintf( __( 'For more options, use the "%s" add-on.', 'mainwp-updraftplus-extension' ), __( 'Reporting', 'mainwp-updraftplus-extension' ) ) . '</a>' );
					echo str_replace( '&gt;', '>', str_replace( '&lt;', '<', htmlspecialchars( $used . ' ' . sprintf( __( 'Be aware that mail servers tend to have size limits; typically around %s Mb; backups larger than any limits will likely not arrive.', 'mainwp-updraftplus-extension' ), '10-20' ) ) ) );
					?>
					</td>
				</tr>
				<?php
	}

	public function delete( $files ) {
			return true;
	}
}
