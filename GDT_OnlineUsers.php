<?php
namespace GDO\OnlineUsers;

use GDO\UI\GDT_Link;
use GDO\OnlineUsers\Method\ViewOnline;

/**
 * This GDT displays how many users are online at the moment.
 * @author gizmore
 * @version 6.10
 * @since 6.04
 */
final class GDT_OnlineUsers extends GDT_Link
{
    public function __construct()
    {
        $this->href(href('OnlineUsers', 'ViewOnline'));
    }
    
    public function countOnline()
    {
        static $online;
        if ($online == null)
        {
            $online = ViewOnline::make()->getQuery()->selectOnly('COUNT(*)')->first()->exec()->fetchValue();
        }
        return $online;
    }

    public function renderCell()
    {
        $this->label('list_viewonline', [$this->countOnline()]);
        return parent::renderCell();
    }
    
}
