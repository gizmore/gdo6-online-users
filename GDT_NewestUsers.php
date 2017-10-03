<?php
namespace GDO\OnlineUsers;
use GDO\DB\Cache;
use GDO\Template\GDT_Panel;
use GDO\Template\GDT_Template;
use GDO\User\GDO_User;
final class GDT_NewestUsers extends GDT_Panel
{
    public static function recache()
    {
        Cache::unset('gdt_online_users');
    }
    
    public static function getNewestUsers()
    {
        if (false === ($cache = Cache::get('gdt_online_users')))
        {
            $module = Module_OnlineUsers::instance();
            $cache = GDO_User::table()->select()->order('user_register_time', false)->limit($module->cfgNumNewest())->exec()->fetchAllObjects();
        }
        return $cache;
    }
    
    public function renderCell()
    {
        return GDT_Template::php('OnlineUsers', 'newest_users.php', ['field' => $this]);
    }
}