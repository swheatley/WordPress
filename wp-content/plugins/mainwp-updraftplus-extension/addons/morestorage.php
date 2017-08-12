<?php
/*
  UpdraftPlus Addon: morestorage:Multiple storage options
  Description: Provides the ability to back up to multiple remote storage facilities, not just one
  Version: 1.0
  Shop: /shop/morestorage/
  Latest Change: 1.7.14
 */

if ( ! defined( 'MAINWP_UPDRAFT_PLUS_DIR' ) ) {
		die( 'No direct access allowed' ); }

$mainwp_updraft_plus_addon_morestorage = new MainWP_Updraft_Plus_Addon_MoreStorage;

class MainWP_Updraft_Plus_Addon_MoreStorage {

	function __construct() {
			add_filter( 'maiwp_updraftplus_storage_printoptions', array( $this, 'storage_printoptions' ), 10, 2 );
			add_filter( 'maiwp_updraftplus_storage_printoptions_multi', array($this, 'storage_printoptions_multi'), 10, 1 );
			#add_action('mainwp_updraftplus_config_print_after_storage', array($this, 'config_print_after_storage'));
			add_action( 'mainwp_updraftplus_config_print_before_storage', array( $this, 'config_print_before_storage' ) );
			add_filter( 'mainwp_updraftplus_savestorage', array( $this, 'savestorage' ), 10, 2 );
			add_action('mainwp_updraftplus_after_remote_storage_heading', array($this, 'after_remote_storage_heading'));
	}

	public function admin_print_footer_scripts() {
		?>
		<script>
		jQuery(document).ready(function() {
			
			jQuery('.remote-tab').click(function(event) {
				//Close other tabs and open the clicked one
				event.preventDefault();
				var the_method = jQuery(this).attr('name');
				mainwp_updraft_remote_storage_tab_activation(the_method);
			});
			
		});
		
		</script>
		<?php
	}
	
	public function admin_print_footer_scripts_old() {
		?>
		<script>
		jQuery(document).ready(function() {
			var anychecked = 0;
			var set = jQuery('.mwp_updraft_servicecheckbox:checked');
			
			jQuery(set).each(function(ind, obj) {
				var ser = jQuery(obj).val();
				anychecked++;
				jQuery('.remote-tab-'+ser).show();
				if(ind == jQuery(set).length-1){
					tab_activation(ser);
				}
			});
			if (anychecked > 0) {
				jQuery('.mwp_updraftplusmethod.none').hide();
			}
			
			jQuery('.mwp_updraft_servicecheckbox').change(function() {
				var sclass = jQuery(this).attr('id');				
				if ('mwp_updraft_servicecheckbox_' == sclass.substring(0,28)) {					
					var serv = sclass.substring(28);										
					if (null != serv && '' != serv) {
						if (jQuery(this).is(':checked')) {
							anychecked++;
							jQuery('.remote-tab-'+serv).fadeIn();
							tab_activation(serv);
						} else {
							anychecked--;
							jQuery('.remote-tab-'+serv).hide();
							//Check if this was the active tab, if yes, switch to another
							if(jQuery('.remote-tab-'+serv).attr('active') == 'true'){
								tab_activation(jQuery('.remote-tab:visible').last().attr('name'));
							}
						}
					}
				}
				
				if (anychecked > 0) {
					jQuery('.mwp_updraftplusmethod.none').hide();
				} else {
					jQuery('.mwp_updraftplusmethod.none').fadeIn();
				}
			});
			
			jQuery('.remote-tab').click(function(event) {
				//Close other tabs and open the clicked one
				event.preventDefault();
				var the_method = jQuery(this).attr('name');
				tab_activation(the_method);
			});
			
			var servicecheckbox = jQuery(".mwp_updraft_servicecheckbox");
			if (typeof servicecheckbox.labelauty === 'function') { servicecheckbox.labelauty(); }
		});
		
		function tab_activation(the_method){			
			jQuery('.mwp_updraftplusmethod').hide();
			jQuery('.remote-tab').attr('active', false);
			jQuery('.remote-tab').removeClass('nav-tab-active');
			jQuery('.mwp_updraftplusmethod.'+the_method).show();
			jQuery('.remote-tab-'+the_method).attr('active', true);
			jQuery('.remote-tab-'+the_method).addClass('nav-tab-active');
		}
		</script>
		<?php
	}


	function config_print_before_storage( $storage ) {
			global $mainwp_updraftplus;
			?>
			<tr class="mwp_updraftplusmethod <?php echo $storage; ?>"><th><h3><?php echo $mainwp_updraftplus->backup_methods[ $storage ]; ?></h3></th><td></td></tr>
				<?php
	}

	public function after_remote_storage_heading() {
		echo '<em>'.__('(as many as you like)', 'mainwp-updraftplus-extension').'</em>';
	}
	
	function savestorage( $rinput, $input ) {
			return $input;
	}

	function config_print_after_storage( $storage ) {
			?>
			<tr class="mwp_updraftplusmethod <?php echo $storage; ?>"><td colspan="2"><hr></td></tr>
					<?php
	}

	public function storage_printoptions_multi($ret) {
		return 'multi';
	}
	
	function storage_printoptions( $ret, $active_service ) {

			global $mainwp_updraftplus;
			add_action( 'admin_print_footer_scripts', array( $this, 'admin_print_footer_scripts' ) );
		?> 		
		</div>
	</td>
	</tr>
	<tr>
		<th colspan="2"><h2 class="updraft_settings_sectionheading"><?php _e( 'Remote Storage Options', 'mainwp-updraftplus-extension' ); ?></h2>
				</tr>
		<tr id="remote_storage_tabs" style="border-bottom: 1px solid #ccc">
			<td colspan="2" style="padding:0px">
			<?php
				foreach ($mainwp_updraftplus->backup_methods as $method => $description) {
					echo "<a class=\"nav-tab remote-tab remote-tab-$method\" id=\"remote-tab-$method\" name=\"$method\" href=\"#\" ";
					//if ((!is_array($active_service) && $active_service !== $method) || !(is_array($active_service) && in_array($method, $active_service))) echo 'style="display:none;"';
					echo 'style="display:none;"';
					echo ">".htmlspecialchars($description)."</a>";
				}
			?>
			</td>
		</tr>
		<?php
		return true;
	}
}
