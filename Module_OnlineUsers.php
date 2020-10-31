<?php
namespace GDO\OnlineUsers;

use GDO\Core\GDO_Module;
use GDO\UI\GDT_Bar;
use GDO\DB\GDT_Checkbox;
use GDO\Date\GDT_Duration;

/**
 * User online statistics.
 * Display currently online in View
 * @author gizmore
 * @version 6.10
 * @since 3.00
 */
final class Module_OnlineUsers extends GDO_Module
{
    public function getDependencies() { return ['Profile']; }
    
	##############
	### Config ###
	##############
    public function getConfig()
    {
        return array(
        	GDT_Duration::make('online_timeout')->initial('5m'),
            GDT_Checkbox::make('show_in_top_bar')->initial('1'),
        );
    }
    public function cfgOnlineTime() { return $this->getConfigValue('online_timeout'); }
    public function cfgShowInTopBar() { return $this->getConfigValue('show_in_top_bar'); }

    ############
    ### Init ###
    ############
    public function onLoadLanguage() { return $this->loadLanguage('lang/onlineusers'); }
    
    #############
    ### Hooks ###
    #############
    public function hookTopBar(GDT_Bar $bar)
    {
        if ($this->cfgShowInTopBar())
        {
            $bar->addField(GDT_OnlineUsers::make());
        }
    }
    
}
