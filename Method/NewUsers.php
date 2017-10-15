<?php
namespace GDO\OnlineUsers\Method;

use GDO\Table\MethodQueryCards;
use GDO\User\GDO_User;

final class NewUsers extends MethodQueryCards
{
	public function gdoTable()
	{
		return GDO_User::table();
	}
	
	public function gdoQuery()
	{ 
		parent::gdoQuery()->where("user_type='member'");
	}
	
}
