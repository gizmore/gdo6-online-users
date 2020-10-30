<?php
namespace GDO\OnlineUsers\Method;

use GDO\Table\MethodQueryList;
use GDO\User\GDO_Session;
use GDO\User\GDO_User;
use GDO\Core\Application;
use GDO\OnlineUsers\Module_OnlineUsers;
use GDO\Date\Time;

final class ViewOnline extends MethodQueryList
{
    public function gdoTable() { return GDO_User::table(); }
    
    private function onlineTimeout() { return Module_OnlineUsers::instance()->cfgOnlineTime(); }
    
    public function defaultOrderField() { return 'sess_time'; }
    public function defaultOrderDirAsc() { return false; }
    
    public function gdoQuery()
    {
        $cut = Application::$TIME - $this->onlineTimeout();
        $cutDate = Time::getDate($cut);
        return GDO_Session::table()->
        select('gdo_user.*, sess_time')->
        joinObject('sess_user')->
        where("sess_time >= '$cutDate'")->
        where('user_type IN ("member", "guest")')->
        uncached()->
        fetchTable(GDO_User::table());
    }
    
}
