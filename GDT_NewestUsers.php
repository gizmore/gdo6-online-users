<?php
namespace GDO\OnlineUsers;

use GDO\DB\Cache;
use GDO\UI\GDT_Panel;
use GDO\Core\GDT_Template;
use GDO\User\GDO_User;

/**
 * This widget holds the newest users to display in a paragraph.
 * 
 * @author gizmore
 * @since 6.04
 * @version 6.10
 */
final class GDT_NewestUsers extends GDT_Panel
{
    public static function recache()
    {
        Cache::remove('gdt_online_users');
    }
    
    public static function getNewestUsers()
    {
        if (false === ($cache = Cache::get('gdt_online_users')))
        {
            $module = Module_OnlineUsers::instance();
            $cache = GDO_User::table()->select()->order('user_register_time', false)->limit($module->cfgNumNewest())->exec()->fetchAllObjects();
        }
        else
        {
            Cache::heat('gdt_online_users', $cache);
        }
        return $cache;
    }
    
    public function renderCell()
    {
        return GDT_Template::php('OnlineUsers', 'newest_users.php', ['field' => $this]);
    }
}
