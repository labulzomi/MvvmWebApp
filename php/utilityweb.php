<?php 

function CheckSession($sessione)
	{
		
		if(isset($sessione))
			if(isset($sessione["sid"])&&!empty($sessione["sid"])&&isset($sessione["user"])&&!empty($sessione["user"]))
			{
	 
				if(password_verify($sessione["user"],$sessione["sid"]))
					return true;
			}
		return false;
	}
    
    
    ?>