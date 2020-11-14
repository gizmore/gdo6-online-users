<?php
namespace GDO\OnlineUsers\Method;

use GDO\Table\MethodQueryList;
use GDO\User\GDO_User;
use GDO\Core\Application;
use GDO\OnlineUsers\Module_OnlineUsers;
use GDO\Date\Time;

/**
 * View recently active users.
 * @author gizmore
 */
final class ViewOnline extends MethodQueryList
{
    public function gdoTable() { return GDO_User::table(); }
    
    private function onlineTimeout() { return Module_OnlineUsers::instance()->cfgOnlineTime(); }
    
    public function getDefaultOrder() { return 'user_last_activity'; }
    public function getDefaultOrderDir() { return false; }
    
    public function getQuery()
    {
        $cut = Application::$TIME - $this->onlineTimeout();
        $cutDate = Time::getDate($cut);
        return GDO_User::table()->select()->
        where("user_last_activity >= '$cutDate'")->
        where('user_type IN ("member", "guest")');
    }
    
}
