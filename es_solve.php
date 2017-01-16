<?php
function solve($string, $newFacts)
{
	$originString = $string;
	$string = str_replace("!", "", $string);
	if (strlen($originString) == 2)
	{
		if ($originString[0] === '!')
		{
			if ($newFacts[$originString[1]] === true)
			{
				return (false);
			}
			else if ($newFacts[$originString[1]] === false)
			{
				return (true);
			}
		}
		else if ($originString[0] !== '0')
		{
			return ($newFacts[$originString[0]]);
		}
	}
	while (strlen($string) > 1)
	{
		$calc = calculator($string, $newFacts, $originString);
		if ($calc === true)
		{
			$string = substr_replace($string, '1', 0, 3);
		}
		else if ($calc === false)
		{
			$string = substr_replace($string, '0', 0, 3);
		}
	}
	if ($string[0] === '1')
	{
		return (true);
	}
	else if ($string[0] === '0')
	{
		return (false);
	}
	else
	{
		echo "error in calculator\n";
	}
}
function calculator($string, $newFacts, $originString)
{
	$opPos = position($string);
	$operator = $string[$opPos];
	preg_match_all('/[A-Z]/', $string, $allFacts);
	foreach($allFacts as $ff)
	{
		foreach($ff as $f)
		{
			$facts[] = $f;
		}
	}
	switch ($operator)
	{
	case '+':
		$val1 = getVal1($originString, $facts, $newFacts);
		$val2 = getVal2($originString, $facts, $newFacts);
		if (ctype_alpha($string[0]))
		{
			return ($val1 && $val2);
		}
		else if ($string[0] === '1')
		{
			return (true && $val1);
		}
		else if ($string[0] === '0')
		{
			return (false && $val1);
		}
		break;

	case '|':
		$val1 = getVal1($originString, $facts, $newFacts);
		$val2 = getVal2($originString, $facts, $newFacts);
		if (ctype_alpha($string[0]))
		{
			return ($val1 || $val2);
		}
		else if ($string[0] === '1')
		{
			return (true || $val1);
		}
		else if ($string[0] === '0')
		{
			return (false || $val1);
		}
		break;

	case '^':
		$val1 = getVal1($originString, $facts, $newFacts);
		$val2 = getVal2($originString, $facts, $newFacts);
		if (ctype_alpha($string[0]))
		{
			return ($val1 xor $val2);
		}
		else if ($string[0] === '1')
		{
			return (true xor $val1);
		}
		else if ($string[0] === '0')
		{
			return (false xor $val1);
		}
		break;
	}
}
function position($haystack)
{
	if (strstr($haystack, '+') !== false)
	{
		return (strpos($haystack, '+'));
	}
	else if (strstr($haystack, '^') !== false)
	{
		return (strpos($haystack, '^'));
	}
	else if (strstr($haystack, '|') !== false)
	{
		return (strpos($haystack, '|'));
	}
}
function getVal1($originString, $facts, $newFacts)
{
	if ($originString[(strpos($originString, $facts[0]) - 1) ] === '!')
	{
		if ($newFacts[$facts[0]] === true)
		{
			$val1 = false;
		}
		else if ($newFacts[$facts[0]] === false)
		{
			$val1 = true;
		}
	}
	else
	{
		$val1 = $newFacts[$facts[0]];
	}
	return ($val1);
}
function getVal2($originString, $facts, $newFacts)
{
	if ($originString[(strpos($originString, $facts[1]) - 1) ] === '!')
	{
		if ($newFacts[$facts[1]] === true)
		{
			$val2 = false;
		}
		else if ($newFacts[$facts[1]] === false)
		{
			$val2 = true;
		}
	}
	else if ($originString[(strpos($originString, $facts[1]) - 1) ] !== '!')
	{
		$val2 = $newFacts[$facts[1]];
	}
	return ($val2);
}
?>