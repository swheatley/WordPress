<?php
/*
UpdraftPlus Addon: googlecloud:Google Cloud Support
Description: Google Cloud Support
Version: 1.0
Shop: /shop/googlecloud/
Include: includes/googlecloud
IncludePHP: methods/addon-base.php
RequiresPHP: 5.2.4
Latest Change: 1.11.13
*/

/*
Potential enhancements:
- Implement the permission to not use SSL (we currently always use SSL).
*/

if (!defined('MAINWP_UPDRAFT_PLUS_DIR')) die('No direct access allowed');

if (!class_exists('MainWP_Updraft_Plus_RemoteStorage_Addons_Base')) require_once(MAINWP_UPDRAFT_PLUS_DIR.'/methods/addon-base.php');

class MainWP_Updraft_Plus_Addons_RemoteStorage_googlecloud extends MainWP_Updraft_Plus_RemoteStorage_Addons_Base {

	private $service;
	private $client;
	private $chunk_size = 2097152;

	private $storage_classes;
	private $bucket_locations;

	public function __construct() {
		# 3rd parameter: chunking? 4th: Test button?

		$this->storage_classes = array(
			'STANDARD' => __('Standard', 'mainwp-updraftplus-extension'),
			'DURABLE_REDUCED_AVAILABILITY' => __('Durable reduced availability', 'mainwp-updraftplus-extension'),
			'NEARLINE' => __('Nearline', 'mainwp-updraftplus-extension'),
		);

		$this->bucket_locations = array(
			'US' => __('United States', 'mainwp-updraftplus-extension').' ('.__('multi-region location', 'mainwp-updraftplus-extension').')',
			'ASIA' => __('Asia Pacific', 'mainwp-updraftplus-extension').' ('.__('multi-region location', 'mainwp-updraftplus-extension').')',
			'EU' => __('European Union', 'mainwp-updraftplus-extension').' ('.__('multi-region location', 'mainwp-updraftplus-extension').')',
			'us-central1' => __('Central United States', 'mainwp-updraftplus-extension').' (1)',
			'us-east1' => __(' Eastern United States', 'mainwp-updraftplus-extension').' (1)',
			'us-central2' => __('Central United States', 'mainwp-updraftplus-extension').' (2)',
			'us-east2' => __('Eastern United States', 'mainwp-updraftplus-extension').' (2)',
			'us-east3' => __('Eastern United States', 'mainwp-updraftplus-extension').' (3)',
			'us-west1' => __('Western United States', 'mainwp-updraftplus-extension').' (1)',
			'asia-east1' => __('Eastern Asia-Pacific', 'mainwp-updraftplus-extension').' (1)',
			'europe-west1' => __('Western Europe', 'mainwp-updraftplus-extension').' (1)',
		);

		parent::__construct('googlecloud', 'Google Cloud Storage', true, true);		
		if (defined('UPDRAFTPLUS_UPLOAD_CHUNKSIZE') && UPDRAFTPLUS_UPLOAD_CHUNKSIZE>0) $this->chunk_size = max(UPDRAFTPLUS_UPLOAD_CHUNKSIZE, 512*1024);
	}
	
	protected function options_exist($opts) {
		if (is_array($opts) && !empty($opts['clientid']) && !empty($opts['secret']) && !empty($opts['bucket_path'])) return true;
		return false;
	}

	public function do_upload($file, $from) {
		
	}

	// The code in this method is basically copied and slightly adjusted from our Google Drive module
	private function do_upload_engine($basename, $from, $try_again = true) {
		
		
	}

	public function do_download($file, $fullpath, $start_offset) {

	}
	
	public function chunked_download($file, $headers, $link) {
	}


	public function do_listfiles($match = 'backup_') {

	}
	
	// Revoke a Google account refresh token
	// Returns the parameter fed in, so can be used as a WordPress options filter
	// Can be called statically from UpdraftPlus::googlecloud_checkchange()
	public static function gcloud_auth_revoke($unsetopt = true) {
		
	}
	
	// Acquire single-use authorization code from Google OAuth 2.0
	public function gcloud_auth_request() {
	
	}
	
	// Get a Google account refresh token using the code received from gdrive_auth_request
	public function gcloud_auth_token() {
	
	}
	
	
	private function redirect_uri() {
		return  MainWP_Updraft_Plus_Options::admin_page_url().'?action=updraftmethod-googlecloud-auth';
	}
	
	// Get a Google account access token using the refresh token
	private function access_token($refresh_token, $client_id, $client_secret) {

		
	}
	
	public function do_bootstrap($opts, $connect) {
	
	}

	public function show_authed_admin_success() {


	}
	
	// Google require lower-case only; that's not such a hugely obvious one, so we automatically munge it. We also trim slashes.
	private function split_bucket_path($bucket_path){
		if (preg_match("#^/*([^/]+)/(.*)$#", $bucket_path, $bmatches)) {
			$bucket = $bmatches[1];
			$path = trailingslashit($bmatches[2]);
		} else {
			$bucket = trim($bucket_path, " /");
			$path = "";
		}
		
		return array(strtolower($bucket), $path);
	}
	
	public function credentials_test() {
		return $this->credentials_test_engine();
	}
	
	public function credentials_test_engine() {

		die;
	}

	// Requires project ID to actually create
	// Returns a Google_Service_Storage_Bucket if successful
	// Defaults to STANDARD / US, if the options are not passed and if nothing is in the saved settings
	private function create_bucket_if_not_existing($bucket_name, $storage_class = false, $location = false) {

	}
	
	public function should_print_test_button() {
//		$opts = $this->get_opts();
//		if (!is_array($opts) || empty($opts['token'])) return false;
		return false;
	}

	public function do_config_javascript() {
		?>
		clientid: jQuery('#updraft_<?php echo $this->method; ?>_clientid').val(),
		secret: jQuery('#updraft_<?php echo $this->method; ?>_apisecret').val(),
		bucket_path: jQuery('#updraft_<?php echo $this->method; ?>_bucket_path').val(),
		project_id: jQuery('#updraft_<?php echo $this->method; ?>_project_id').val(),
		bucket_location: jQuery('#updraft_<?php echo $this->method; ?>_bucket_location').val(),
		storage_class: jQuery('#updraft_<?php echo $this->method; ?>_storage_class').val(),
		disableverify: (jQuery('#updraft_ssl_disableverify').is(':checked')) ? 1 : 0,
		useservercerts: (jQuery('#updraft_ssl_useservercerts').is(':checked')) ? 1 : 0,
		nossl: (jQuery('#updraft_ssl_nossl').is(':checked')) ? 1 : 0,
		<?php
	}
		
	public function do_config_print($opts) {
		global $mainwp_updraftplus_admin;
		
		$bucket_path = empty($opts['bucket_path']) ? '' : untrailingslashit($opts['bucket_path']);
		$accesskey = empty($opts['accesskey']) ? '' : $opts['accesskey'];
		$secret = empty($opts['secret']) ? '' : $opts['secret'];
		$client_id = empty($opts['clientid']) ? '' : $opts['clientid'];
		$project_id = empty($opts['project_id']) ? '' : $opts['project_id'];
		$storage_class = empty($opts['storage_class']) ? 'STANDARD' : $opts['storage_class'];
		$bucket_location = empty($opts['bucket_location']) ? 'US' : $opts['bucket_location'];                
		?>
		<tr class="mwp_updraftplusmethod googlecloud">
			<td></td>
			<td>
				<img alt="<?php _e(sprintf(__('%s logo', 'mainwp-updraftplus-extension'), 'Google Cloud')); ?>" src="<?php echo esc_attr(MAINWP_UPDRAFT_PLUS_URL.'/images/googlecloud.png'); ?>"><br>
				<p><?php printf(__('Do not confuse %s with %s - they are separate things.', 'mainwp-updraftplus-extension'), '<a href="https://cloud.google.com/storage">Google Cloud</a>', '<a href="https://drive.google.com">Google Drive</a>'); ?></p>

			<?php
				$admin_page_url = MainWP_Updraft_Plus_Options::admin_page_url();
				# This is advisory - so the fact it doesn't match IPv6 addresses isn't important
				if (preg_match('#^(https?://(\d+)\.(\d+)\.(\d+)\.(\d+))/#', $admin_page_url, $matches)) {
					echo '<p><strong>'.htmlspecialchars(sprintf(__("%s does not allow authorisation of sites hosted on direct IP addresses. You will need to change your site's address (%s) before you can use %s for storage.", 'mainwp-updraftplus-extension'), __('Google Cloud', 'mainwp-updraftplus-extension'), $matches[1], __('Google Cloud', 'mainwp-updraftplus-extension'))).'</strong></p>';
				} else {
					?>

					<p><a href="https://updraftplus.com/support/configuring-google-cloud-api-access-updraftplus/"><strong><?php _e('For longer help, including screenshots, follow this link. The description below is sufficient for more expert users.', 'mainwp-updraftplus-extension');?></strong></a></p>

					<p><a href="https://console.developers.google.com"><?php _e('Follow this link to your Google API Console, and there activate the Storage API and create a Client ID in the API Access section.', 'mainwp-updraftplus-extension');?></a> <?php _e("Select 'Web Application' as the application type.", 'mainwp-updraftplus-extension');?></p>					
					<?php
				}
			?>

			</td>
			</tr>
	<?php 
            //if ( MainWP_Updraftplus_Backups::is_managesites_updraftplus() ) { ?>
		<tr class="mwp_updraftplusmethod googlecloud">
			<th><?php echo __('Google Cloud', 'mainwp-updraftplus-extension').' '.__('Client ID', 'mainwp-updraftplus-extension'); ?>:</th>
			<td>
				<input type="text" autocomplete="off" style="width:442px" id="updraft_googlecloud_clientid" name="mwp_updraft_googlecloud[clientid]" value="<?php echo esc_attr($client_id); ?>" />
				<br><em><?php _e('If Google later shows you the message "invalid_client", then you did not enter a valid client ID here.', 'mainwp-updraftplus-extension');?></em>
			</td>
		</tr>
		
		<tr class="mwp_updraftplusmethod googlecloud">
			<th><?php echo __('Google Cloud', 'mainwp-updraftplus-extension').' '.__('Client Secret', 'mainwp-updraftplus-extension'); ?>:</th>
			<td><input type="<?php echo apply_filters('updraftplus_admin_secret_field_type', 'password'); ?>" style="width:442px" id="updraft_googlecloud_apisecret" name="mwp_updraft_googlecloud[secret]" value="<?php echo esc_attr($secret); ?>" /></td>
		</tr>

		<?php
		$mainwp_updraftplus_admin->storagemethod_row(
			'googlecloud',
			'Google Cloud '.__('Project ID', 'mainwp-updraftplus-extension').':',
			'<input title="'.esc_attr(sprintf(__('Enter the ID of the %s project you wish to use here.', 'mainwp-updraftplus-extension'), 'Google Cloud')).'" type="text" style="width:442px" id="updraft_googlecloud_project_id" name="mwp_updraft_googlecloud[project_id]" value="'.esc_attr($project_id).'"><br><em>'.__('N.B. This is only needed if you have not already created the bucket, and you wish UpdraftPlus to create it for you.', 'mainwp-updraftplus-extension').' '.__('Otherwise, you can leave it blank.', 'mainwp-updraftplus-extension').' <a href="https://updraftplus.com/faqs/where-do-i-find-my-google-project-id/">'.__('Go here for more information.', 'mainwp-updraftplus-extension').'</a></em>'
		);
		$mainwp_updraftplus_admin->storagemethod_row(
			'googlecloud',
			'Google Cloud '.__('Bucket', 'mainwp-updraftplus-extension').':',
			'<input title="'.esc_attr(sprintf(__('Enter the name of the %s bucket you wish to use here.', 'mainwp-updraftplus-extension'), 'Google Cloud').' '.__('Bucket names have to be globally unique. If the bucket does not already exist, then it will be created.').' '.sprintf(__('e.g. %s', 'mainwp-updraftplus-extension'), 'mybackups/workwebsite.')).'" type="text" style="width:442px" id="updraft_googlecloud_bucket_path" name="mwp_updraft_googlecloud[bucket_path]" value="'.esc_attr($bucket_path).'"><br><a href="https://cloud.google.com/storage/docs/bucket-naming?hl=en"><em>'.__("See Google's guidelines on bucket naming by following this link.", 'mainwp-updraftplus-extension').'</a> '.sprintf(__('You must use a bucket name that is unique, for all %s users.', 'mainwp-updraftplus-extension'), __('Google Cloud', 'mainwp-updraftplus-extension')).'</em>'
		);

		?>
		<tr class="mwp_updraftplusmethod googlecloud">
			<th><?php _e('Storage class', 'mainwp-updraftplus-extension');?>:<br><a href="https://cloud.google.com/storage/docs/storage-classes"><em><?php _e('(Read more)', 'mainwp-updraftplus-extension');?></em></a></th>
			<td>
				<select name="mwp_updraft_googlecloud[storage_class]" id="updraft_googlecloud_storage_class">
					<?php
					foreach ($this->storage_classes as $id => $description) {
						echo '<option value="'.$id.'" '.(($id == $storage_class) ? ' selected="selected"' : '').'>'.htmlspecialchars($description).'</option>';
					}
					?>
				</select>
				<br>
				<em><?php echo __('This setting applies only when a new bucket is being created.', 'mainwp-updraftplus-extension').' '.__('Note that Google do not support every storage class in every location - you should read their documentation to learn about current availability.', 'mainwp-updraftplus-extension');?></em>
			</td>
		</tr>
		
		<tr class="mwp_updraftplusmethod googlecloud">
			<th><?php _e('Bucket location', 'mainwp-updraftplus-extension');?>:<br><a href="https://cloud.google.com/storage/docs/bucket-locations"><em><?php _e('(Read more)', 'mainwp-updraftplus-extension');?></em></a></th>
			<td>
				<select name="mwp_updraft_googlecloud[bucket_location]" id="updraft_googlecloud_bucket_location">
					<?php
					foreach ($this->bucket_locations as $id => $description) {
						echo '<option value="'.$id.'" '.(($id == $bucket_location) ? ' selected="selected"' : '').'>'.htmlspecialchars($description).'</option>';
					}
					?>
				</select>
				<br>
				<em><?php echo __('This setting applies only when a new bucket is being created.', 'mainwp-updraftplus-extension');?></em>

			</td>
		</tr>
		<?php
                 if ( MainWP_Updraftplus_Backups::is_managesites_updraftplus() ) {
                    $sid = MainWP_Updraftplus_Backups::get_site_id_managesites_updraftplus();
                    $auth_link = '/wp-admin/options-general.php?action=updraftmethod-googlecloud-auth&page=updraftplus&updraftplus_googleauth=doit';
                    $auth_link = MainWP_Updraftplus_Backups::get_instance()->get_open_location_link( $sid, $auth_link );						
		?>               
		<tr class="mwp_updraftplusmethod googlecloud">
			<th><?php _e('Authenticate with Google');?>:</th>
			<td>				
				<p>
					<a href="<?php echo $auth_link; ?>" target="_blank"><?php _e("<strong>After</strong> you have saved your settings (by clicking 'Save Changes' below), then come back here once and click this link to complete authentication with Google.", 'mainwp-updraftplus-extension');?></a>
				</p>
			</td>
		</tr>
		
		<?php
                }
		//}
	}

}

$mainwp_updraftplus_addons_googlecloud = new MainWP_Updraft_Plus_Addons_RemoteStorage_googlecloud;
