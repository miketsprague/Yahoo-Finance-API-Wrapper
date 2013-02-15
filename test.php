<?php

	include("StockStatistics.php");

	$symbols = array();
	echo "NAME\tSYMBOL\tPE\tPS\tPB\n";
	if(($handle = fopen("NYSE_.csv", "r")) !== FALSE)
	{
		while(($data = fgetcsv($handle, 1000, "\n")) !== FALSE)
		{
			if(strpos($data[0], "-") != False)
				continue;

			$symbols[] = $data[0];
		} 
	} 
	else
	{
		echo ("Error loading CSV!");
	}

	$size = count($symbols);
	for($i = 0; $i < $size; $i += 10){
		$data_set = array_slice($symbols, $i, 10);
		$result_set = getDataOnSymbols($data_set);
		calculateValues($result_set);
	}
	//$data = getDataOnSymbols(array("AAPL", "GOOG", "MCD"));



	function calculateValues($data){
		foreach($data as $stock){
			$fc = isFoolCheap($stock);
			//$ac = isAlphaCheap($stock);
			if($fc){
				//echo "\nStock " . $stock["Name"] . " (" . $stock["Symbol"] . ") is Fool Cheap!\n";
				echo $stock["Name"] . "\t" . $stock["Symbol"] . "\t" . getPE($stock) . "\t " . getPS($stock) . "\t" . getPB($stock) . "\n";
			} 
			/*if($ac) {
				echo "\nStock " . $stock["Name"] . " (" . $stock["Symbol"] . ") is Alpha Cheap!\n";
				echo "PE: " . getPE($stock) . "\tPS: " . getPS($stock) . "\tPB: " . getPB($stock) . "\n";
			} */

			//if(!$fc && !$ac)
			//	echo "\n" . $stock["Name"] . " isn't cheap!";
		}
	}
?>
