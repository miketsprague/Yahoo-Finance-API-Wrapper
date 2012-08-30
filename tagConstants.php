<?php
/**
 * Michael Sprague 
 * August 2012
 * @license       MIT
 */

/* 
 Pass a tag and returns the full name / description of the tag.
 These are the tags that are passed to the yahoo webservice to determine what information we get back.

*/
function getDescriptionOfTag($tag){
    $tags = array(
		"a"		=>	"Ask",
		"b"		=>	"Bid",
		"b4"	=>	"Book Value",
		"c1"	=>	"Change",
		"c8"	=>	"After Hours Change (Real-time)",
		"d2"	=>	"Trade Date",
		"e7"	=>	"EPS Estimate Current Year",
		"f6"	=>	"Float Shares",
		"j"		=>	"52-week Low",
		"g3"	=>	"Annualized Gain",
		"g6"	=>	"Holdings Gain (Real-time)",
		"j1"	=>	"Market Capitalization",
		"j5"	=>	"Change From 52-week Low",
		"k2"	=>	"Change Percent (Real-time)",
		"k5"	=>	"Percebt Change From 52-week High",
		"l2"	=>	"High Limit",
		"m2"	=>	"Day's Range (Real-time)",
		"m5"	=>	"Change From 200-day Moving Average",
		"m8"	=>	"Percent Change From 50-day Moving Average",
		"o"		=>	"Open",
		"p2"	=>	"Change in Percent",
		"q"		=>	"Ex-Dividend Date",
		"r2"	=>	"P/E Ratio (Real-time)",
		"r7"	=>	"Price/EPS Estimate Next Year",
		"s7"	=>	"Short Ratio",
		"t7"	=>	"Ticker Trend",
		"v1"	=>	"Holdings Value",
		"w1"	=>	"Day's Value Change",
		"y"		=>	"Dividend Yield",
		"a2"	=>	"Average Daily Volume",
		"b2"	=>	"Ask (Real-time)",
		"b6"	=>	"Bid Size",
		"c3"	=>	"Commission",
		"d"		=>	"Dividend/Share",
		"e"		=>	"Earnings/Share",
		"e8"	=>	"EPS Estimate Next Year",
		"g"		=>	"Day's Low",
		"k"		=>	"52-week High",
		"g4"	=>	"Holdings Gain",
		"i"		=>	"More Info",
		"j3"	=>	"Market Cap (Real-time)",
		"j6"	=>	"Percent Change From 52-week Low",
		"k3"	=>	"Last Trade Size",
		"l"		=>	"Last Trade (With Time)",
		"l3"	=>	"Low Limit",
		"m3"	=>	"50-day Moving Average"	,
		"m6"	=>	"Percent Change From 200-day Moving Average",
		"n"		=>	"Name",
		"p"		=>	"Previous Close",
		"p5"	=>	"Price/Sales",
		"r"		=>	"P/E Ratio",
		"r5"	=>	"PEG Ratio",
		"s"		=>	"Symbol",
		"t1"	=>	"Last Trade Time",
		"t8"	=>	"1 yr Target Price",
		"v7"	=>	"Holdings Value (Real-time)",
		"w4"	=>	"Day's Value Change (Real-time)",
		"a5"	=>	"Ask Size",
		"b3"	=>	"Bid (Real-time)",
		"c"		=>	"Change & Percent Change",
		"c6"	=>	"Change (Real-time)",
		"d1"	=>	"Last Trade Date",
		"e1"	=>	"Error Indication (returned for symbol changed / invalid)",
		"e9"	=>	"EPS Estimate Next Quarter",
		"h"		=>	"Day's High",
		"g1"	=>	"Holdings Gain Percent",
		"g5"	=>	"Holdings Gain Percent (Real-time)",
		"i5"	=>	"Order Book (Real-time)",
		"j4"	=>	"EBITDA",
		"k1"	=>	"Last Trade (Real-time) With Time",
		"k4"	=>	"Change From 52-week High",
		"l1"	=>	"Last Trade (Price Only)",
		"m"		=>	"Day's Range",
		"m4"	=>	"200-day Moving Average",
		"m7"	=>	"Change From 50-day Moving Average",
		"n4"	=>	"Notes",
		"p1"	=>	"Price Paid",
		"p6"	=>	"Price/Book",
		"r1"	=>	"Dividend Pay Date",
		"r6"	=>	"Price/EPS Estimate Current Year",
		"s1"	=>	"Shares Owned",
		"t6"	=>	"Trade Links",
		"v"		=>	"Volume",
		"w"		=>	"52-week Range",
		"x"		=>	"Stock Exchange"

);
    return array_key_exists($tag, $tags) ? $tags[$tag] : "UNKNOWN";
}
?>
