<?php
function get_file($argv)

{
	$file = $argv;
	$ext = pathinfo($file, PATHINFO_EXTENSION);
	if ($ext != 'txt' || $argv == "")
	{
		echo "Please enter filename with extension 'txt' as argument\n";
		return;
	}
	$handle = fopen("$file", "r");
	$i = 0;
	$input = array();
	while (($line = fgets($handle)) !== false)
	{
		$i++;
		if (preg_match('/[?]/', $line) === 1)
		{
			if (!(preg_match("/([?][A-Z])/", $line)))
			{
				echo "NO QUERIES GIVEN\n";
				exit();
			}
		}
		if (preg_match("/([=][A-Z])/", $line)) $factDup+= 1;
		if (preg_match("/([?][A-Z])/", $line)) $queryDup+= 1;
		if ($factDup > 1 || $queryDup > 1)
		{
			echo "FORMAT ERROR: FACTS AND QUERIES SHOULD BE DECLARED IN A SINGLE STATEMENT ONLY\n";
			exit();
		}
		if (!strstr($line, '=') && !strstr($line, '?') && $line[0] != '#')
		{
			if ($line !== "\n")
			{
				echo "FORMAT ERROR ON LINE " . $i . ": " . $line;
			}
		}
		else
		{
			preg_match('/.*?(?=(#|\n))/', $line, $caseTest);
			foreach($caseTest as $test)
			{
				if (preg_match("/([a-z])/", $test))
				{
					echo "RULES, FACTS AND QUERIES SHOULD BE DECLARED IN UPPERCASE ONLY\n";
					exit();
				}
			}
			array_push($input, $line);
		}
	}
	return ($input);
}
?>