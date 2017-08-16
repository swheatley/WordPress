<?php 
/************************************************************
 * InfiniteWP Admin panel									*
 * Copyright (c) 2012 Revmakx								*
 * www.revmakx.com											*
 *															*
 ************************************************************/
?>
<?php TPL::captureStart('newAddons'); ?>

<?php
$appRegisteredUser = getOption("appRegisteredUser");
$position = array('starter'=>'182', 'developer'=> '255', 'freelancer' => '331', 'agency' => '354');
$pricingPlans = array('starter','developer','freelancer', 'agency', 'enterprise');
$emailSupport = array('starter'=>$d['starterSupport'], 'developer'=> $d['developerSupport'], 'freelancer' => $d['freelancerSupport'], 'agency' => 'Priority', 'enterprise' => 'Priority');
if (empty($appRegisteredUser) || $d['isAddonPlanExpired'] || !in_array($d['activeTierPlan'], $pricingPlans)) {
  $upgradeStarterUrl = IWP_SITE_URL.'?add-to-cart='.$d['IDForStarter'].'&utm_source=application&utm_medium=userapp&utm_campaign=starter';
  $upgradeDeveloperUrl = IWP_SITE_URL.'?add-to-cart='.$d['IDForDeveloper'].'&utm_source=application&utm_medium=userapp&utm_campaign=developer';
  $upgradeFreelancerUrl = IWP_SITE_URL.'?add-to-cart='.$d['IDForFreelancer'].'&utm_source=application&utm_medium=userapp&utm_campaign=freelancer';
  $upgradeAgencyUrl = IWP_SITE_URL.'?add-to-cart='.$d['IDForAgency'].'&utm_source=application&utm_medium=userapp&utm_campaign=agency';
  $upgradeEnterpriseUrl = IWP_SITE_URL.'?add-to-cart='.$d['IDForEnterprise'].'&utm_source=application&utm_medium=userapp&utm_campaign=enterprise';
} elseif(in_array($d['activeTierPlan'], $pricingPlans) && !$d['isAddonPlanExpired']){
  $upgradeDeveloperUrl = IWP_SITE_URL.'?add-to-cart='.$d['IDExistingToDeveloper'].'&utm_source=application&utm_medium=userapp&utm_campaign=developer';
  $upgradeFreelancerUrl = IWP_SITE_URL.'?add-to-cart='.$d['IDExistingToFreelancer'].'&utm_source=application&utm_medium=userapp&utm_campaign=freelancer';
  $upgradeAgencyUrl = IWP_SITE_URL.'?add-to-cart='.$d['IDExistingToAgency'].'&utm_source=application&utm_medium=userapp&utm_campaign=agency';
  $upgradeEnterpriseUrl = IWP_SITE_URL.'?add-to-cart='.$d['IDExistingToEnterprise'].'&utm_source=application&utm_medium=userapp&utm_campaign=enterprise';
}
if(!empty($appRegisteredUser)){ 
  ?>
<table cellpadding="0" cellspacing="0" border="0" class="addon-bundle-wrapper">
	<tr class="addon-bundle-row">
		<td>Your infinitewp.com account:</td>
		<td>&nbsp;<span class="bundle-name"><?php echo $appRegisteredUser; ?></span></td>		
	</tr>
<?php 
if(!empty($d['activeTierPlan'])) {
	$bundleName = $d['activeTierPlan'];
?>
	<tr class="addon-bundle-row">
		<td>Current Plan:</td>
		<td class="current-plan-div w-clearfix">
		    <span class="current-plan-title"><?php echo($bundleName); ?></span><img class="current-plan-icon" src="images/<?php echo $d['activeTierPlan'] ?>.svg">
	    </td>
	</tr>
  <?php if($d['activeTierPlan'] != 'enterprise' && $d['activeTierPlan'] != 'agency' ){ ?>	
  <tr class="addon-bundle-row">
		<td>Site Limit:</td>
		<td>&nbsp;<span class="-Oct-2016">0-<?php echo($d['activePlanSiteLimit']); ?></span></td>
	</tr>	
  <?php } elseif (in_array($d['activeTierPlan'], array('enterprise', 'agency'))){ ?>
  <tr class="addon-bundle-row">
    <td>Site Limit:</td>
    <td>&nbsp;<span class="-Oct-2016">Unlimited</span></td>
  </tr> 

   <?php } ?>
	<tr class="addon-bundle-row">
		<td>Valid Till:</td>
		<td>&nbsp;<span class="-Oct-2016"><?php echo date("M d, Y",$d['validity']); ?></span></td>
	</tr>
  <?php if(!$d['isAddonPlanExpired']) { ?>
  <tr class="addon-bundle-row">
    <td>Addons:</td>
    <td>&nbsp;<span class="-Oct-2016">All - <?php echo count($d['activePlanAddons']); ?> Addons</span></td>
  </tr>
  <?php }else{ ?>
  <tr class="addon-bundle-row">
    <td>Addons:</td>
    <td>&nbsp;<span class="-Oct-2016 error_warning"><span style="font-style: italic;color: rgb(196, 17, 17);">Expired</span></span><span style="font-size: 12.8px;font-weight: normal;font-style: italic;font-stretch: normal;line-height: 2.4;text-align: left; color: #444444;"> (Note: no longer receive any updates.)</span> <div class="btn_action float-right" style="margin-right: 371px;cursor:pointer;"><a class="rep_sprite btn_blue " style="color: #6C7277;  cursor:pointer;" href="<?php echo(IWP_SITE_URL); ?>my-account/?utm_source=application&utm_medium=userapp&utm_campaign=renewAddon" target="_blank">Yes! Go ahead.</a></div></td>
  </tr>
  <?php } ?>
  <tr class="addon-bundle-row">
		<td>Email Support:</td>
		<td>&nbsp;<span class="email-support"><?php echo $emailSupport[$d['activeTierPlan']]; ?> </span></td>
	</tr>	
  
   <?php
	
	}
?>
</table>
<?php }
else{ ?>
	<div style="padding: 10px;">Your infinitewp.com account: <span style="font-weight: 700;">You have not connected your account. </span> <a <?php if(!$d['isAppRegistered']){ ?>register="no" actionvar="register"<?php } ?> onclick="$('#checkNowAddons').click();">Connect Now</a></div>
<?php 
}
$enterpriseAddons = array();
?>
<?php if($d['activeTierPlan'] != 'enterprise' || $d['isAddonPlanExpired']){ ?>
<div class="plans-section w-clearfix" style="margin-left:<?php if(!empty($appRegisteredUser) && !$d['isAddonPlanExpired']){echo $position[$d['activeTierPlan']];}else{echo '108';} ?>px;margin-bottom: 25px;">
    <div class="other-plans-div">
      <div class="other-plans-suggestion-text-div">
        <div class="font-size-16"><?php if(!empty($appRegisteredUser) && !$d['isAddonPlanExpired']){echo '"Want To Manage More Than '.$d['activePlanSiteLimit'].' Sites"'; }else{echo '" Want To Manage With Powerful Addons? "'; } ?> 
          <br><span class="font-size-12">Check out plans here:</span>
        </div>
      </div>
      <div class="tiered-plans-div w-clearfix" <?php if($d['activeTierPlan'] == 'agency'){echo 'style="margin-left: 45px;"';} ?> >
      <?php if(empty($appRegisteredUser) || empty($d['activeTierPlan']) || $d['isAddonPlanExpired']){ ?>
        <div class="tiered-plan"><img class="starter-plan-icon" src="images/starter.svg">
          <div class="plan-name">starter</div>
          <div class="no-of-sites">0-<?php echo $d['starterSiteLimit']; ?> Sites</div>
          <div class="tiered-price-grey-box">
            <div class="tiered-value w-clearfix"><span class="dollor-sign two-digit">$</span><?php echo $d['priceForStarter']; ?></div>
            <div class="plan-valid-year">/yr</div>
            <div class="tiered-renews-price-value">renews @ $<?php echo $d['renewPriceForStarter']; ?> yearly</div>
          </div>
          <ul class="service-list w-list-unstyled">
            <li class="all-addons-service-list w-clearfix">
              <a class="all-addons-link w-clearfix w-inline-block" href="https://infinitewp.com/addons/"><img class="all-addon-icon" height="12" src="images/all-addon-icon.svg">
                <div class="link-hover service-name">All Addons</div>
              </a>
            </li>
            <li class="i-wp-for-teams-service-list w-clearfix"><img class="iwp-for-teams-icon off" height="10" src="images/iwp-for-teams-icon.svg">
              <div class="service-name">–</div>
            </li>
            <li class="support-service-list w-clearfix">
              <div class="service-name"><?php echo $d['starterSupport']; ?> E-mail Support</div>
            </li>
          </ul><a class="upgrade-button w-button w-preserve-3d" href="<?php echo $upgradeStarterUrl;?>" target="_blank">upgrade</a>
        </div>
        <?php } if($d['activeTierPlan'] == 'starter' ||(empty($appRegisteredUser) || empty($d['activeTierPlan'])) || $d['isAddonPlanExpired']) { ?>
        <div class="popular tiered-plan"><img class="popular-banner" src="images/popupar-banner.svg"><img class="developer-icon" src="images/developer.svg">
          <div class="plan-name popular">developer</div>
          <div class="no-of-sites"><?php echo $d['starterSiteLimit']+1; ?>-<?php echo $d['developerSiteLimit']; ?> Sites</div>
          <div class="tiered-price-grey-box">
            <div class="tiered-value w-clearfix"><span class="dollor-sign">$</span><?php if((empty($appRegisteredUser) || empty($d['activeTierPlan']))){echo $d['priceForDeveloper'];}elseif(!$d['isAddonPlanExpired']){echo $d['priceExistingToDeveloper'];}else{echo $d['priceForDeveloper'];} ?></div>
            <div class="plan-valid-year">/yr</div>
            <div class="tiered-renews-price-value">renews @ $<?php echo $d['renewPriceForDeveloper']; ?> yearly</div>
          </div>
          <ul class="service-list w-list-unstyled">
            <li class="all-addons-service-list w-clearfix">
              <a class="all-addons-link w-clearfix w-inline-block" href="https://infinitewp.com/addons/"><img class="all-addon-icon" height="12" src="images/all-addon-icon.svg">
                <div class="link-hover service-name">All Addons</div>
              </a>
            </li>
            <li class="i-wp-for-teams-service-list w-clearfix"><img class="iwp-for-teams-icon off" height="10" src="images/iwp-for-teams-icon.svg">
              <div class="service-name">–</div>
            </li>
            <li class="support-service-list w-clearfix">
              <div class="service-name"><?php echo $d['developerSupport']; ?> E-mail Support</div>
            </li>
          </ul><a class="upgrade-button w-button w-preserve-3d" href="<?php echo $upgradeDeveloperUrl;?>" target="_blank">upgrade</a>
        </div>
        <?php } if(in_array($d['activeTierPlan'], array('starter','developer')) ||(empty($appRegisteredUser) || empty($d['activeTierPlan'])) || $d['isAddonPlanExpired']){ ?>
        <div class="tiered-plan"><img class="freelancer-icon" src="images/freelancer.svg">
          <div class="plan-name">freelancer</div>
          <div class="no-of-sites"><?php echo $d['developerSiteLimit']+1; ?>-<?php echo $d['freelancerSiteLimit']; ?> Sites</div>
          <div class="tiered-price-grey-box">
            <div class="tiered-value w-clearfix"><span class="dollor-sign">$</span><?php if((empty($appRegisteredUser) || empty($d['activeTierPlan']))){echo $d['priceForFreelancer'];}elseif(!$d['isAddonPlanExpired']){echo $d['priceExistingToFreelancer'];}else{echo $d['priceForFreelancer'];} ?></div>
            <div class="plan-valid-year">/yr</div>
            <div class="tiered-renews-price-value">renews @ $<?php echo $d['renewPriceForFreelancer']; ?> yearly</div>
          </div>
          <ul class="service-list w-list-unstyled">
            <li class="all-addons-service-list w-clearfix">
              <a class="all-addons-link w-clearfix w-inline-block" href="https://infinitewp.com/addons/" target="_blank"><img class="all-addon-icon" height="12" src="images/all-addon-icon.svg">
                <div class="link-hover service-name">All Addons</div>
              </a>
            </li>
            <li class="i-wp-for-teams-service-list w-clearfix"><img class="iwp-for-teams-icon off" height="10" src="images/iwp-for-teams-icon.svg">
              <div class="service-name">–</div>
            </li>
            <li class="support-service-list w-clearfix">
              <div class="service-name"><?php echo $d['freelancerSupport']; ?> E-mail Support</div>
            </li>
          </ul><a class="upgrade-button w-button w-preserve-3d" href="<?php echo $upgradeFreelancerUrl;?>" target="_blank">upgrade</a>
        </div>
        <?php } if(in_array($d['activeTierPlan'], array('starter','developer', 'freelancer')) ||(empty($appRegisteredUser) || empty($d['activeTierPlan'])) || $d['isAddonPlanExpired']) { ?>
        <div class="recommended-box tiered-plan"><img class="recommended-banner" src="images/recommended-banner-R1.svg"><img class="agency-icon" src="images/agency.svg">
          <div class="plan-name popular">agency</div>
          <div class="no-of-sites">Unlimited</div>
          <div class="tiered-price-grey-box">
            <div class="tiered-value w-clearfix"><span class="dollor-sign">$</span><?php if((empty($appRegisteredUser) || empty($d['activeTierPlan']))){echo $d['priceForAgency'];}elseif(!$d['isAddonPlanExpired']){echo $d['priceExistingToAgency'];}else{echo $d['priceForAgency'];} ?></div>
            <div class="plan-valid-year">/yr</div>
            <div class="tiered-renews-price-value">renews @ $<?php echo $d['renewPriceForAgency']; ?> yearly</div>
          </div>
          <ul class="service-list w-list-unstyled">
            <li class="all-addons-service-list w-clearfix">
              <a class="all-addons-link w-clearfix w-inline-block" href="https://infinitewp.com/addons/" target="_blank"><img class="all-addon-icon" height="12" src="images/all-addon-icon.svg">
                <div class="link-hover service-name">All Addons</div>
              </a>
            </li>
            <li class="i-wp-for-teams-service-list w-clearfix"><img class="iwp-for-teams-icon off" height="10" src="images/iwp-for-teams-icon.svg">
              <div class="service-name">–</div>
            </li>
            <li class="support-service-list w-clearfix">
              <div class="service-name">Priority Email Support</div>
            </li>
          </ul><a class="upgrade-button w-button w-preserve-3d" href="<?php echo $upgradeAgencyUrl;?>" target="_blank">upgrade</a>
        </div>
        <?php } if(in_array($d['activeTierPlan'], array('starter','developer', 'freelancer', 'agency')) ||(empty($appRegisteredUser) || empty($d['activeTierPlan'])) || $d['isAddonPlanExpired']) { ?>
        <div class="tiered-plan"><img class="enterprise-icon" src="images/enterprise.svg">
          <div class="plan-name">enterprise</div>
          <div class="no-of-sites">Unlimited</div>
          <div class="tiered-price-grey-box">
            <div class="tiered-value w-clearfix"><span class="dollor-sign">$</span><?php if((empty($appRegisteredUser) || empty($d['activeTierPlan']))){echo $d['priceForEnterprise'];}elseif(!$d['isAddonPlanExpired']){echo $d['priceExistingToEnterprise'];}else{echo $d['priceForEnterprise'];} ?></div>
            <div class="plan-valid-year">/yr</div>
            <div class="tiered-renews-price-value">renews @ $<?php echo $d['renewPriceForEnterprise']; ?> yearly</div>
          </div>
          <ul class="service-list w-list-unstyled">
            <li class="all-addons-service-list w-clearfix">
              <a class="all-addons-link w-clearfix w-inline-block" href="https://infinitewp.com/addons/"><img class="all-addon-icon" height="12" src="images/all-addon-icon.svg">
                <div class="link-hover service-name">All Addons</div>
              </a>
            </li>
            <li class="i-wp-for-teams-service-list w-clearfix"><img class="iwp-for-teams-icon" height="10" src="images/iwp-for-teams-icon.svg">
              <div class="service-name">InfiniteWP For Teams</div>
            </li>
            <li class="support-service-list w-clearfix">
              <div class="service-name">Priority Email Support</div>
            </li>
          </ul><a class="upgrade-button w-button w-preserve-3d" href="<?php echo $upgradeEnterpriseUrl;?>" target="_blank">upgrade</a>
        </div>
        <?php } ?>
      </div>
    </div>
  </div>
  <?php } ?>
<div class="result_block shadow_stroke_box purchased_addons">
  <div class="th rep_sprite">
    <div class="title"><span class="droid700">YOUR PURCHASED ADDONS</span></div>
    <div class="btn_reload rep_sprite" style=" width: 103px;float: left;margin: 7px;height: 23px;border-radius: 20px;border-right-width: 1px;"><a class="rep_sprite_backup" <?php if(!$d['isAppRegistered']){ ?>register="no" actionvar="register"<?php } ?>  id="checkNowAddons"  style="width:63px;background-position: -5px -685px;padding: 5px 12px 6px 28px;height: 12px;box-shadow: 0 2px 1px rgba(0, 0, 0, 0.1), 1px 1px 1px rgba(255, 255, 255, 0.5) inset;border-radius: 20px;"><i class="fa fa-repeat" style="position: absolute;left: 9px;font-size: 15px;top: 3px;"></i>Check Now</a></div>
    <div class="btn_action float-right <?php if(empty($d['newAddons'])){ ?> disabled<?php } ?>"><a class="rep_sprite" id="installIWPAddons"  actionvar="installAddons">Install Addons</a></div>
    
  </div>
  <div class="rows_cont" style="margin-bottom:-1px;">
  <?php if(!empty($d['newAddons'])){
	  foreach($d['newAddons'] as  $addon){ ?>
	  	<div class="addons_cont"><?php echo $addon['addon']; ?></div>
<?php  }
	 } else{ ?>
	  <div class="addons_empty_cont">You have installed all purchased addons / You have not purchased any new addons. You can purchase addons from the <a href="<?php echo(IWP_SITE_URL); ?>addons/?utm_source=application&utm_medium=userapp&utm_campaign=purchaseAddon" target="_blank">InfiniteWP addon store</a>.</div>
  <?php } ?>
    <div class="clear-both"></div>
  </div>
</div>
<?php TPL::captureStop('newAddons');

 TPL::captureStart('installedAddons'); ?>
<div class="result_block shadow_stroke_box addons">
  <div class="th rep_sprite">
    <div class="title" style="margin-left: 82px;"><span class="droid700">INSTALLED ADDONS</span></div>
     <div class="title" style="margin-left: 410px;"><span class="droid700">VALID TILL</span></div>
    <?php
	if(!empty($d['installedAddons'])){
		$updateBulkAddons = array();
		foreach($d['installedAddons'] as  $addon){
			if(!empty($addon['updateAvailable']) && !$addon['isValidityExpired']){
				$updateBulkAddons[] = $addon['slug'].'__AD__'.$addon['updateAvailable']['version'];
			}
		}
	}
	if(!empty($updateBulkAddons)){	
	$updateBulkAddonsString = implode('__IWP__', $updateBulkAddons);
	?>
    <div class="btn_action float-right"><a class="rep_sprite updateIWPAddons needConfirm" authlink="updateAddons&addons=<?php echo $updateBulkAddonsString; ?>">Update All Addons</a></div>
    <?php } ?>
  </div>
  <div class="rows_cont">
  <?php
   reset($d['installedAddons']);
   $isBundleClassName = '';
   if(!empty($d['installedAddons'])){
	   if(in_array($d['addonSuiteOrMiniPurchased'],array('addonSuite','addonSuiteMini'))) {
			$isBundleClassName = 'bundle-rows';
			
			$daysRemaining = ''; $today='';
			
			list($key, $value) = each($d['installedAddons']);
			
			if($key=='multiUser') {
				list($key, $value) = each($d['installedAddons']);
			}
			
			$validTill = getValidTill($addon);
			reset($d['installedAddons']);			
?>
		<div class="ind_row_cont <?php echo $validTill['class']; ?>">
			<div class="row_no_summary">
				<div class="view_list addon_view_list on_off">
				</div>
				<div class="row_name bundle-name"><?php echo($bundleName); ?></div>
				<span class="row_valid_till additional-padding-left">
				<?php 
					if($d['installedAddons'][$key]['isLifetime'] == true){
						echo "Lifetime"; 
					} else if($validTill['class']!='gp_over') { 
						echo date("M d, Y",$addon['validityExpires']).'<br />'.$validTill['extra_info']; 
					} else { 
						echo 'Expired';
					}
				?>				
				</span>
			<?php
				if(strtotime("+30 day", time()) >= $d['installedAddons'][$key]['validityExpires']){ 
			?>            
				<div class="row_action float-right">
					<a href="<?php echo(IWP_SITE_URL); ?>my-account/?utm_source=application&utm_medium=userapp&utm_campaign=renewAddon" target="_blank">
						<?php echo $d['installedAddons'][$key]['isValidityExpired'] ? "Renew" : ""; ?>
					</a>
				</div>
            <?php 
				}
			?>				
				<div class="clear-both"></div>
			</div>
		</div>
<?php
	   }
	  foreach($d['installedAddons'] as  $addon){ 
		$daysRemaining = ''; $today='';
            if($addon['slug']=='multiUser') {
                array_push($enterpriseAddons,$addon);
                continue;
            }
			$validTill = getValidTill($addon);
		?>
    		<div class="ind_row_cont <?php echo $validTill['class']; ?>">
    	
          <div class="row_no_summary">
            <div class="view_list addon_view_list on_off">
              <div class="cc_mask cc_addon_mask" addonSlug="<?php echo $addon['slug']; ?>"><div class="cc_img cc_addon_img <?php echo $addon['status'] == 'active' ? 'on' : 'off'; ?>"></div></div>
            </div>
            <div class="row_name addon_list <?php echo($isBundleClassName); ?>"><?php echo $addon['addon']; ?> <?php echo 'v'.$addon['version']; ?></div>
            <span class="row_valid_till">
			<?php  
				if($addon['isLifetime'] == true){
					echo "Lifetime"; 
				} else if($validTill['class']!='gp_over') { 
					echo date("M d, Y",$addon['validityExpires']).'<br />'.$validTill['extra_info']; 
				} else { 
					echo 'Expired';
				} 
			?>
			</span>
            
            <?php if(!empty($addon['updateAvailable']) && !$addon['isValidityExpired']){ ?>			
			
             <div class="row_action float-right">
        <a href="<?php echo $addon['updateAvailable']['changeLogLink']; ?>" target="_blank" style="padding-left: 5px;"><?php echo $addon['updateAvailable']['version']; ?></a>
        </div>
        <span style="float: right; padding-top: 10px;"> - </span>
        <div class="row_action float-right">
        	<a authlink="updateAddons&addon=<?php echo $addon['slug'].'__AD__'.$addon['updateAvailable']['version']; ?>" addonslug="<?php echo $addon['slug'].'__AD__'.$addon['updateAvailable']['version']; ?>" class="updateIWPAddons needConfirm<?php if($addon['isValidityExpired']){ ?> disabled<?php }?>" style="padding-right: 5px;">Update</a></div>
                            
            <?php } 
			
			if((strtotime("+30 day", time()) >= $addon['validityExpires']) && !in_array($d['addonSuiteOrMiniPurchased'],array('addonSuite','addonSuiteMini'))){ 
			?>            
            <div class="row_action float-right"><a href="<?php echo(IWP_SITE_URL); ?>my-account/?utm_source=application&utm_medium=userapp&utm_campaign=renewAddon" target="_blank"><?php echo (!empty($addon['updateAvailable']) && $addon['isValidityExpired']) ? "Renew to update" : "Renew"; ?></a></div>
            <?php }
			
			?>
            
            <div class="clear-both"></div>
          </div>
        </div>
 <?php }
 } else{ ?>
	   <div class="addons_empty_cont">You have not installed any addons yet.</div>
  <?php } ?>
  </div>
</div>
<?php if(count($enterpriseAddons)!=0) { ?>        
<div class="result_block shadow_stroke_box addons">
  <div class="th rep_sprite">
    <div class="title" style="margin-left: 82px;"><span class="droid700">ENTERPRISE</span></div>
     <div class="title" style="margin-left: 410px;"><span class="droid700">VALID TILL</span></div>
  </div>
<div class="rows_cont">
  <?php
   reset($enterpriseAddons);
   if(!empty($enterpriseAddons)){

	  foreach($enterpriseAddons as  $addon){ $daysRemaining = ''; $today='';
	   $validTill = getValidTill($addon);
	?>
    		<div class="ind_row_cont <?php echo $validTill['class']; ?>">
    	
          <div class="row_no_summary">
            <div class="view_list addon_view_list on_off">
              <div class="cc_mask cc_addon_mask" addonSlug="<?php echo $addon['slug']; ?>"><div class="cc_img cc_addon_img <?php echo $addon['status'] == 'active' ? 'on' : 'off'; ?>"></div></div>
            </div>
            <div class="row_name addon_list"><?php echo $addon['addon']; ?> <?php echo 'v'.$addon['version']; ?></div>
            <span class="row_valid_till">
			<?php 
				if($addon['isLifetime'] == true){
					echo "Lifetime"; 
				} else if($validTill['class']!='gp_over') { 
					echo date("M d, Y",$addon['validityExpires']).'<br />'.$validTill['extra_info']; 
				} else { 
					echo 'Expired';
				} 
			?>
			</span>
            
            <?php if(!empty($addon['updateAvailable']) && !$addon['isValidityExpired']){ ?>			
			
             <div class="row_action float-right">
        <a href="<?php echo $addon['updateAvailable']['changeLogLink']; ?>" target="_blank" style="padding-left: 5px;"><?php echo $addon['updateAvailable']['version']; ?></a>
        </div>
        <span style="float: right; padding-top: 10px;"> - </span>
        <div class="row_action float-right">
        	<a authlink="updateAddons&addon=<?php echo $addon['slug'].'__AD__'.$addon['updateAvailable']['version']; ?>" addonslug="<?php echo $addon['slug'].'__AD__'.$addon['updateAvailable']['version']; ?>" class="updateIWPAddons needConfirm<?php if($addon['isValidityExpired']){ ?> disabled<?php }?>" style="padding-right: 5px;">Update</a></div>
                            
            <?php } 
			
			if((strtotime("+30 day", time()) >= $addon['validityExpires'])){ 
			?>            
            <div class="row_action float-right"><a href="<?php echo(IWP_SITE_URL); ?>my-account/?utm_source=application&utm_medium=userapp&utm_campaign=renewAddon" target="_blank"><?php echo (!empty($addon['updateAvailable']) && $addon['isValidityExpired']) ? "Renew to update" : "Renew"; ?></a></div>
            <?php }
			
			?>
            
            <div class="clear-both"></div>
          </div>
        </div>
 <?php }
 } else{ ?>
	   <div class="addons_empty_cont">You have not installed any addons yet.</div>
  <?php } ?>
  </div>
</div>
<?php } ?>
<?php TPL::captureStop('installedAddons'); 

if(!empty($d['promoAddons'])){
 TPL::captureStart('promoAddons');?>
 
<div class="result_block shadow_stroke_box addons">
  <div class="th rep_sprite">
    <div class="title"><span class="droid700">OTHER USEFUL ADDONS</span></div>
  </div>
  <div class="rows_cont" style="margin-bottom:-1px">
  <?php
    foreach($d['promoAddons'] as  $addon){ ?>
    <div class="buy_addons_cont">
      <div class="addon_name"><?php echo $addon['addon']; ?></div>
      <div class="addon_descr"><?php echo $addon['descr']; ?></div>
      <div class="th_sub rep_sprite">
        <div class="price_strike"><?php $addon['listPrice'] = (float)$addon['listPrice']; echo (!empty($addon['listPrice'])) ? '$ '.$addon['listPrice'] : ''; ?></div>
        <div class="price">$<?php echo $addon['price']; ?></div>
        <div class="full_details"><a href="<?php echo $addon['URL']."?utm_source=application&utm_medium=userapp&utm_campaign=purchaseAddon"; ?>" target="_blank">Full Details</a></div>
      </div>
    </div>    
	<?php } ?>
   <div class="clear-both"></div>
  </div>
</div>
<?php TPL::captureStop('promoAddons'); } 

//===================================================================================================================> 

if(!empty($d['promos']['addon_page_top'])){ echo '<div id="addon_page_top">'.$d['promos']['addon_page_top'].'</div>'; }
echo TPL::captureGet('newAddons');
echo TPL::captureGet('installedAddons');
echo TPL::captureGet('promoAddons');
if(!empty($d['promos']['addon_page_bottom'])){ echo '<div id="addon_page_top">'.$d['promos']['addon_page_bottom'].'</div>'; }

?>