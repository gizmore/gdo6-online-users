<?php
namespace GDO\OnlineUsers;
use GDO\Core\GDO_Module;
use GDO\User\GDO_User;
use GDO\Template\GDT_Bar;
use GDO\Type\GDT_UInt;

final class Module_OnlineUsers extends GDO_Module
{
    public function getConfig()
    {
        return array(
            GDT_UInt::make('num_online_users')->initial('12'),
            GDT_UInt::make('num_newest_users')->initial('8'),
        );
    }
    
    public function cfgNumOnline() { return $this->getConfigVar('num_online_users'); }
    public function cfgNumNewest() { return $this->getConfigVar('num_newest_users'); }
    
    public function onInit()
    {
        GDT_OnlineUsers::updateOnlineUser(GDO_User::current());
    }
    
    public function hookTopBar(GDT_Bar $bar)
    {
        $bar->addField(GDT_OnlineUsers::make());
    }
    
    public function hookUserActivated(GDO_User $user)
    {
        GDT_NewestUsers::recache();
    }
}