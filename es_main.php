#!usr/bin/php
<?php
include ('es_get_file.php');

include ('es_get_variables.php');

include ('es_solve.php');

$defaultFacts = array(
	'A' => False,
	'B' => False,
	'C' => False,
	'D' => False,
	'E' => False,
	'F' => False,
	'G' => False,
	'H' => False,
	'I' => False,
	'J' => False,
	'K' => False,
	'L' => False,
	'M' => False,
	'N' => False,
	'O' => False,
	'P' => False,
	'Q' => False,
	'R' => False,
	'S' => False,
	'T' => False,
	'U' => False,
	'V' => False,
	'W' => False,
	'X' => False,
	'Y' => False,
	'Z' => False
);
$input = get_file($argv[1]);
$input = implode("\n", $input);
$facts = getFacts($input);
$queries = getQueries($input);
$newFacts = setFacts($defaultFacts, $facts);
$rules = getRules($input);
list($premise, $conclusion) = splitRules($rules);
$newFacts = runRules($conclusion, $premise, $newFacts, $facts, $queries);

foreach($queries as $ans)
{
	echo "FINAL RESULT: " . $ans . " = " . (boolval($newFacts[$ans]) ? 'true' : 'false') . "\n";
}
function runRules($conclusion, $premise, $newFacts, $facts, $queries)
{
	$i = 0;
	$j = 0;
	while ($conclusion[$i])
	{
		if (strlen($premise[$i]) > 1)
		{
			$solved_p = solve($premise[$i], $newFacts);
		}
		if (($newFacts[$premise[$i]] === true || $solved_p === true) && $newFacts[$conclusion[$i]] === false)
		{
			if (strlen($conclusion[$i]) > 1)
			{
				$tempCon = andConclusion($conclusion[$i]);
				foreach($tempCon as $tmp)
				{
					$newFacts[$tmp] = true;
				}
			}
			else
			{
				$newFacts[$conclusion[$i]] = true;
				$i = - 1;
			}
		}
		else if ($solved_p === false)
		{
			$newFacts[$conclusion[$i]] = false;
		}
		$i++;
	}
	return ($newFacts);
}
function andConclusion($string)
{
	$tmp = explode("+", $string);
	foreach($tmp as $temp)
	{
		$tempCon[] = $temp;
	}
	return ($tempCon);
}
?>