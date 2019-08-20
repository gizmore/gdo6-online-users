<?php
namespace GDO\OnlineUsers;

use GDO\UI\GDT_Panel;
use GDO\User\GDO_User;
use GDO\DB\Cache;
use GDO\User\GDO_Session;
use GDO\Core\GDT_Template;
use GDO\Date\Time;

/**
 * This GDT displays the users who are online at the moment.
 * @author gizmore
 * @version 6.10
 * @since 6.04
 */
final class GDT_OnlineUsers extends GDT_Panel
{
    public function getOnlineUsers()
    {
    	# Try from cache
        if (false === ($cache = Cache::get('gdt_online_users')))
        {
        	# Online timeout
            $cut = Time::getDate(time() - Module_OnlineUsers::instance()->cfgOnlineTime());
            
            # Query users
            $users = GDO_Session::table()->
            	select('gdo_user.*')->
            	fetchTable(GDO_User::table())->
            	joinObject('sess_user', 'LEFT JOIN')->orderDESC('sess_time')->
            	where("sess_time >= '$cut'")->
            	exec()->
            	fetchAllObjects();

            # Build result
            $cache = ['guests' => 0, 'users' => []];
            foreach ($users as $user)
            {
            	/** @var $user GDO_User **/
            	if ($user->isMember()) 
            	{
            		$cache['users'][$user->getID()] = $user;
            	}
            	else
            	{
            		$cache['guests']++;
            	}
            }
            
            # Set in cache
//             Cache::set('gdt_online_users', $cache);
        }
        return $cache;
    }
    
    public function renderCell()
    {
        return GDT_Template::php('OnlineUsers', 'online_users.php', ['field' => $this]);
    }
    
}
