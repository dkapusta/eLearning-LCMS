<?php
	class LMSInstaller 
	{
		function LMSInstaller()
		{
			$LMSInstalled = "0";
		}

		function checkInstall()
		{
			$installed = "0";

			if(file_exists("config.php"))
			{
				$installed = "1";
			}

			return $installed;
		}
	}