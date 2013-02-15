<?php

/**
 * Modified by Michael Sprague
 * August 2012
 * Todo: These can be webservices if we want
 */
include("Finance.php");

/**
 * getDataOnSymbols
 * $symbols - array of stock symbols
 * returns - relevant "generic" information about those stocks in an array/dictionary
 */
function getDataOnSymbols($symbols, $tags = "s|n|a|l1|c1|p2|j|k|j1|e|r|d|y|p5|p6|p1"){
	$finance = new Finance($tags);
	return $finance->get_quotes($symbols);
}

function getPE($json){
	$stat = floatval($json["P/E Ratio"]);
	return $stat > 0 ? $stat : false;
}

function getPS($json){
	$stat = floatval($json["Price/Sales"]);
	return $stat > 0 ? $stat : false;
}

function getPB($json){
	$stat = floatval($json["Price/Book"]);
	return $stat > 0 ? $stat : false;
}

function getDividendYield($json){
	$stat = floatval($json["Dividend Yield"]);
//	$stat = floatval($json["Dividend/Share"]) / floatval($json["Last Trade (Price Only)"]);
	return $stat > 0 ? $stat : false;
}

// Is it a "cheap" value stock, according to motley fool:
// http://www.fool.com/investing/value/2009/03/18/how-to-find-dirt-cheap-value-stocks.aspx
// WE DO NOT HAVE THEIR DEBT / EQUITY NUMBERS
// BE CAREFUL
function isFoolCheap($json){
	// Get the market's average PE.
	// We're going to hard code it at 20.
	$averagePE = 20;
	$pe = getPE($json);
	if($pe == false || $pe > 20)
		return false;

	// Must be above the market average's dividend
	$averageDividend = .0424;
	$dividend = getDividendYield($json);
	if($dividend == false || $dividend < $averageDividend)
		return false;

	// P/B must be < 1
	$pb = getPB($json);
	if($pb == false || $pb > 1)
		return false;

// alpha test
	$ps = getPS($json);
	return $ps != false && $ps < .62;

	//Debt: manageable amount, preferably none.
	//return true;
}

function isAlphaCheap($json){
	$ps = getPS($json);
	return $ps != false && $ps < .62;
}
?>
