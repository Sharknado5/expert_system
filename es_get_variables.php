<?php
function getFacts($input)
{
	preg_match('/(?<=\=)\w+/', $input, $facts);
	$facts = preg_split('//', $facts[0], -1, PREG_SPLIT_NO_EMPTY);
	return ($facts);
}
function getQueries($input)
{
	preg_match('/(?<=\?)\w+/', $input, $queries);
	$queries = preg_split('//', $queries[0], -1, PREG_SPLIT_NO_EMPTY);
	return ($queries);
}
function getRules($input)
{
	preg_match_all('/.*?(?=(#|\n))/', $input, $getRules);
	foreach($getRules as $elem)
	{
		foreach($elem as $value)
		{
			if ($value != "" && $value[0] != "=" && $value[0] != "?")
			{
				$rules[] = $value;
			}
		}
	}
	return ($rules);
}
function setFacts($defaultFacts, $facts)
{
	foreach($defaultFacts as $key => $value)
	{
		foreach($facts as $elem)
		{
			if ($key == $elem)
			{
				$defaultFacts[$key] = true;
			}
		}
	}
	return ($defaultFacts);
}
function splitRules($rules)
{
	foreach($rules as $element)
	{
		list($left, $right) = explode("=>", $element);
		$premise[] = str_replace(" ", "", $left);
		$conclusion[] = str_replace(" ", "", $right);
	}
	return [$premise, $conclusion];
}
?>