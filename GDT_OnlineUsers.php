<?php
namespace GDO\OnlineUsers;

use GDO\UI\GDT_Link;
use GDO\OnlineUsers\Method\ViewOnline;
use GDO\Session\GDO_Session;

/**
 * This GDT displays how many users are online at the moment.
 * @author gizmore
 * @version 6.10
 * @since 6.04
 */
final class GDT_OnlineUsers extends GDT_Link
{
    protected function __construct()
    {
        $this->href(href('OnlineUsers', 'ViewOnline'));
    }
    
    public function countOnline()
    {
        static $online;
        if ($online == null)
        {
            $online = ViewOnline::make()->getQuery()->
                selectOnly('COUNT(*)')->first()->
                exec()->fetchValue();
            
            if (GDO_Session::isDB())
            {
                $guests = GDO_Session::table()->
                    countWhere('sess_user IS NULL');
                $online += $guests;
            }
            
        }
        return $online;
    }

    public function renderCell()
    {
        $this->label('list_onlineusers_viewonline', [$this->countOnline()]);
        return parent::renderCell();
    }
    
}
