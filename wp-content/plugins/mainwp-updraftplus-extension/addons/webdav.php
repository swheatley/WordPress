<?php
/*
  UpdraftPlus Addon: webdav:WebDAV Support
  Description: Allows UpdraftPlus to back up to WebDAV servers
  Version: 2.0
  Shop: /shop/webdav/
  Include: includes/PEAR
  IncludePHP: methods/stream-base.php
  Latest Change: 1.9.1
 */

/*
  To look at:
  http://sabre.io/dav/http-patch/
  http://sabre.io/dav/davclient/
  https://blog.sphere.chronosempire.org.uk/2012/11/21/webdav-and-the-http-patch-nightmare
 */

if ( ! defined( 'MAINWP_UPDRAFT_PLUS_DIR' ) ) {
		die( 'No direct access allowed' ); }

# In PHP 5.2, the instantiation of the class has to be after it is defined, if the class is extending a class from another file. Hence, that has been moved to the end of this file.

if ( ! class_exists( 'MainWP_Updraft_Plus_AddonStorage_viastream' ) ) {
		require_once( MAINWP_UPDRAFT_PLUS_DIR . '/methods/stream-base.php' ); }

class MainWP_Updraft_Plus_Addons_RemoteStorage_webdav extends MainWP_Updraft_Plus_AddonStorage_viastream {

	public function __construct() {
			parent::__construct( 'webdav', 'WebDAV' );
	}

	public function bootstrap() {
		return true;
	}

	public function config_print_middlesection( $url ) {
			?>
			<tr class="mwp_updraftplusmethod webdav">
				<th><?php _e( 'WebDAV URL', 'mainwp-updraftplus-extension' ); ?>:</th>
				<td>
					<input type="text" style="width: 432px" id="updraft_webdav_settings_url" name="mwp_updraft_webdav_settings[url]" value="<?php echo($url); ?>" />
					<br>
					<?php printf( __( 'Enter a complete URL, beginning with webdav:// or webdavs:// and including path, username, password and port as required - e.g.%s', 'mainwp-updraftplus-extension' ), 'webdavs://myuser:password@example.com/dav' ); ?>
				</td>
				</tr>

				<?php
	}

	public function credentials_test() {
		if ( empty( $_POST['url'] ) ) {
				printf( __( 'Failure: No %s was given.', 'mainwp-updraftplus-extension' ), 'URL' );
				return;
		}

			$url = preg_replace( '/^http/', 'webdav', untrailingslashit( $_POST['url'] ) );
			$this->credentials_test_go( $url );
	}
}

$mainwp_updraft_plus_addons_webdav = new MainWP_Updraft_Plus_Addons_RemoteStorage_webdav;
