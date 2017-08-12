<?php
if ( ! defined( 'MAINWP_UPDRAFT_PLUS_DIR' ) ) {
		die( 'No direct access allowed.' ); }

# SDK uses namespacing - requires PHP 5.3 (actually the SDK states its requirements as 5.3.3)

use OpenCloud\Rackspace;

# New SDK - https://github.com/rackspace/php-opencloud and http://docs.rackspace.com/sdks/guide/content/php.html
# Uploading: https://github.com/rackspace/php-opencloud/blob/master/docs/userguide/ObjectStore/Storage/Object.md

require_once( MAINWP_UPDRAFT_PLUS_DIR . '/methods/openstack-base.php' );

class MainWP_Updraft_Plus_BackupModule_cloudfiles_opencloudsdk extends MainWP_Updraft_Plus_BackupModule_openstack_base {

	public function __construct() {
			parent::__construct( 'cloudfiles', 'Cloud Files', 'Rackspace Cloud Files', '/images/rackspacecloud-logo.png' );
	}

	public function get_client() {
			return $this->client;
	}

	public function get_service( $opts, $useservercerts = false, $disablesslverify = null ) {

	}

	public function get_credentials() {
			return array( 'updraft_cloudfiles' );
	}

	public function get_opts() {
			global $mainwp_updraftplus;
			$opts = MainWP_Updraft_Plus_Options::get_updraft_option( 'updraft_cloudfiles' ); //$mainwp_updraftplus->get_job_option('updraft_cloudfiles');
		if ( ! is_array( $opts ) ) {
				$opts = array( 'user' => '', 'authurl' => 'https://auth.api.rackspacecloud.com', 'apikey' => '', 'path' => '' ); }
		if ( empty( $opts['authurl'] ) ) {
				$opts['authurl'] = 'https://auth.api.rackspacecloud.com'; }
		if ( empty( $opts['region'] ) ) {
				$opts['region'] = null; }
			return $opts;
	}

	public function config_print_middlesection() {
			$opts = $this->get_opts();
			?>
			<tr class="mwp_updraftplusmethod <?php echo $this->method; ?>">
				<th></th>
				<td>
					<p><?php _e( 'Get your API key <a href="https://mycloud.rackspace.com/">from your Rackspace Cloud console</a> (read instructions <a href="http://www.rackspace.com/knowledge_center/article/rackspace-cloud-essentials-1-generating-your-api-key">here</a>), then pick a container name to use for storage. This container will be created for you if it does not already exist.', 'mainwp-updraftplus-extension' ); ?> <a href="http://updraftplus.com/faqs/there-appear-to-be-lots-of-extra-files-in-my-rackspace-cloud-files-container/"><?php _e( 'Also, you should read this important FAQ.', 'mainwp-updraftplus-extension' ); ?></a></p>
				</td>
				</tr>
				<tr class="mwp_updraftplusmethod <?php echo $this->method; ?>">
				<th title="<?php _e( 'Accounts created at rackspacecloud.com are US accounts; accounts created at rackspace.co.uk are UK accounts.', 'mainwp-updraftplus-extension' ); ?>"><?php _e( 'US or UK-based Rackspace Account', 'mainwp-updraftplus-extension' ); ?>:</th>
				<td>
					<select id="updraft_cloudfiles_authurl" name="mwp_updraft_cloudfiles[authurl]" title="<?php _e( 'Accounts created at rackspacecloud.com are US-accounts; accounts created at rackspace.co.uk are UK-based', 'mainwp-updraftplus-extension' ); ?>">
						<option <?php if ( 'https://lon.auth.api.rackspacecloud.com' != $opts['authurl'] ) { echo 'selected="selected"'; } ?> value="https://auth.api.rackspacecloud.com"><?php _e( 'US (default)', 'mainwp-updraftplus-extension' ); ?></option>
						<option <?php if ( 'https://lon.auth.api.rackspacecloud.com' == $opts['authurl'] ) { echo 'selected="selected"'; } ?> value="https://lon.auth.api.rackspacecloud.com"><?php _e( 'UK', 'mainwp-updraftplus-extension' ); ?></option>
					</select>
				</td>
				</tr>

				<tr class="mwp_updraftplusmethod <?php echo $this->method; ?>">
				<th><?php _e( 'Cloud Files Storage Region', 'mainwp-updraftplus-extension' ); ?>:</th>
				<td>
					<select id="updraft_cloudfiles_region" name="mwp_updraft_cloudfiles[region]">
						<?php
						$regions = array(
							'DFW' => __( 'Dallas (DFW) (default)', 'mainwp-updraftplus-extension' ),
							'SYD' => __( 'Sydney (SYD)', 'mainwp-updraftplus-extension' ),
							'ORD' => __( 'Chicago (ORD)', 'mainwp-updraftplus-extension' ),
							'IAD' => __( 'Northern Virginia (IAD)', 'mainwp-updraftplus-extension' ),
							'HKG' => __( 'Hong Kong (HKG)', 'mainwp-updraftplus-extension' ),
							'LON' => __( 'London (LON)', 'mainwp-updraftplus-extension' ),
						);
						$selregion = (empty( $opts['region'] )) ? 'DFW' : $opts['region'];
						foreach ( $regions as $reg => $desc ) {
								?>
								<option <?php if ( $selregion == $reg ) { echo 'selected="selected"'; } ?> value="<?php echo $reg; ?>"><?php echo htmlspecialchars( $desc ); ?></option>
									<?php
						}
						?>
						</select>
					</td>
				</tr>

				<tr class="mwp_updraftplusmethod <?php echo $this->method; ?>">
					<th><?php _e( 'Cloud Files Username', 'mainwp-updraftplus-extension' ); ?>:</th>
					<td><input type="text" autocomplete="off" style="width: 282px" id="updraft_cloudfiles_user" name="mwp_updraft_cloudfiles[user]" value="<?php echo htmlspecialchars( $opts['user'] ) ?>" />
						<div style="clear:both;">
							<?php echo apply_filters( 'mainwp_updraft_cloudfiles_apikeysetting', '<a href="http://updraftplus.com/shop/cloudfiles-enhanced/"><em>' . __( 'To create a new Rackspace API sub-user and API key that has access only to this Rackspace container, use this add-on.', 'mainwp-updraftplus-extension' ) ) . '</em></a>'; ?>
						</div>
					</td>
				</tr>
				<tr class="mwp_updraftplusmethod <?php echo $this->method; ?>">
					<th><?php _e( 'Cloud Files API Key', 'mainwp-updraftplus-extension' ); ?>:</th>
					<td><input type="<?php echo apply_filters( 'mainwp_updraftplus_admin_secret_field_type', 'text' ); ?>" autocomplete="off" style="width: 282px" id="updraft_cloudfiles_apikey" name="mwp_updraft_cloudfiles[apikey]" value="<?php echo htmlspecialchars( $opts['apikey'] ); ?>" />
					</td>
				</tr>
				<tr class="mwp_updraftplusmethod <?php echo $this->method; ?>">
					<th><?php echo apply_filters( 'mainwp_updraftplus_cloudfiles_location_description', __( 'Cloud Files Container', 'mainwp-updraftplus-extension' ) ); ?>:</th>
					<td><input type="text" style="width: 282px" name="mwp_updraft_cloudfiles[path]" id="updraft_cloudfiles_path" value="<?php echo htmlspecialchars( $opts['path'] ); ?>" /></td>
				</tr>
				<?php
	}

		# The default parameter here is only to satisfy Strict Standards

	public function config_print_javascript_onready( $keys = array() ) {
			parent::config_print_javascript_onready( array( 'apikey', 'user', 'region', 'authurl' ) );
	}

	public function credentials_test() {

		if ( empty( $_POST['apikey'] ) ) {
				printf( __( 'Failure: No %s was given.', 'mainwp-updraftplus-extension' ), __( 'API key', 'mainwp-updraftplus-extension' ) );
				die;
		}

		if ( empty( $_POST['user'] ) ) {
				printf( __( 'Failure: No %s was given.', 'mainwp-updraftplus-extension' ), __( 'Username', 'mainwp-updraftplus-extension' ) );
				die;
		}

			$opts = array(
				'user' => $_POST['user'],
				'apikey' => stripslashes( $_POST['apikey'] ),
				'authurl' => $_POST['authurl'],
				'region' => (empty( $_POST['region'] )) ? null : $_POST['region'],
			);

			$this->credentials_test_go( $opts, $_POST['path'], $_POST['useservercerts'], $_POST['disableverify'] );
	}
}
