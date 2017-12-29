<?php
namespace GDO\OnlineUsers;

use GDO\Core\GDO_Module;
use GDO\User\GDO_User;
use GDO\UI\GDT_Bar;
use GDO\DB\GDT_UInt;
use GDO\DB\GDT_Checkbox;
use GDO\Date\GDT_Duration;

/**
 * User online statistics.
 * - Display currently online
 * - Display newest users
 * @author gizmore
 * @since 3.00
 * @version 6.06
 */
final class Module_OnlineUsers extends GDO_Module
{
	##############
	### Config ###
	##############
    public function getConfig()
    {
        return array(
            GDT_UInt::make('num_online_users')->initial('12'),
            GDT_UInt::make('num_newest_users')->initial('8'),
        	GDT_Duration::make('online_timeout')->initial('60'),
        );
    }
    public function cfgNumOnline() { return $this->getConfigVar('num_online_users'); }
    public function cfgNumNewest() { return $this->getConfigVar('num_newest_users'); }
    public function cfgOnlineTime() { return $this->getConfigValue('online_timeout'); }

    ############
    ### Init ###
    ############
    public function onLoadLanguage() { return $this->loadLanguage('lang/onlineusers'); }
    public function onInit()
    {
        GDT_OnlineUsers::updateOnlineUser(GDO_User::current());
    }
    
    #############
    ### Hooks ###
    #############
    public function hookTopBar(GDT_Bar $bar)
    {
        $bar->addField(GDT_OnlineUsers::make());
    }
    
    public function hookUserActivated(GDO_User $user)
    {
        GDT_NewestUsers::recache();
    }
    
}
