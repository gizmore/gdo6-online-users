<?php
namespace GDO\OnlineUsers;
use GDO\UI\GDT_Panel;
use GDO\User\GDO_User;
use GDO\DB\Cache;
use GDO\User\GDO_Session;
use GDO\Core\GDT_Template;

final class GDT_OnlineUsers extends GDT_Panel
{
    public static function updateOnlineUser(GDO_User $user)
    {
        if ($session = GDO_Session::instance())
        {
        	# Get
            $cache = self::getOnlineUsers();
            
            # Update
			$cache[$session->getID()] = [time(), $user];

            # Cleanup
            $cut = time() - Module_OnlineUsers::instance()->cfgOnlineTime();
	        foreach ($cache as $sessid => $data)
	        {
	        	list($time, $user) = $data;
	        	if ($time < $cut)
	        	{
	        		unset($cache[$sessid]);
	        	}
	        }
        
	        # Save
	        Cache::set('gdt_online_users', $cache);
        }
        
    }
    
    public static function getOnlineUsers()
    {
        if (false === ($cache = Cache::get('gdt_online_users')))
        {
            $cache = array();
        }
        return $cache;
    }
    
    public function renderCell()
    {
        return GDT_Template::php('OnlineUsers', 'online_users.php', ['field' => $this]);
    }
}
