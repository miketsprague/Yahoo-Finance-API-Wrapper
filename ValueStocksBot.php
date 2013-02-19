<?php

include("StockStatistics.php");
include("AccountManager.php");

$symbols = array();
//echo "NAME\tSYMBOL\tPE\tPS\tPB\n";
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
		$numShares = getNumSharesOwned(1337, $stock["Symbol"]);

		//$ac = isAlphaCheap($stock);
	//	sellStock($stock["Symbol"], $stock["Last Trade (Price Only)"]);
		if($fc &&$numShares == 0) {
			 buyStock($stock["Symbol"], $stock["Last Trade (Price Only)"]); 
		} 
		 else if(!$fc && $numShares > 0) {
			sellStock($stock["Symbol"], $stock["Last Trade (Price Only)"]);
		}
	}
}

function buyStock($symbol, $price) {

	if(getBalanceFromAccount(1337) < 1000 || $price == 0) {
		echo "Wanted to buy $symbol for \$$price...but the account has insufficient funds!\n";
		return;
	}

	$total = 1000; // Todo: calculate this!
	$num_shares = $total / $price;
	buyShares(1337, $symbol, $price, $num_shares);

	echo "Bought $symbol for \$$price!\n";
	echo "New balance: ".getBalanceFromAccount(1337)."\n";
}

function sellStock($symbol, $price) {
	if($price == 0) {
		return;
	}
	sellAllShares(1337, $symbol, $price);
	echo "sold $symbol @ $price";
	echo "balance: ".getBalanceFromAccount(1337);
}

?>
