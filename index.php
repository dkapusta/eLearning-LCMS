<?php
	header('Content-Type: text/html; charset=utf-8');

	$dir = opendir("framework");
	while($file = readdir($dir))
	{
		if($file != "." && $file != ".." && $file != "...")
		{
			include "framework/".$file;
		}
	}

	$App = new Framework();
	$App->run();