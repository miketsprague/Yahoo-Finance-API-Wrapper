<?php
	include("mail_sender.php");
	include("AccountManager.php");
	include("StockStatistics.php");
	date_default_timezone_set("America/Los_Angeles");

	$log_file = "logs/".date("m_d_Y") . ".log";
	$log =  file_get_contents($log_file);

	$body = "Transaction summary for this morning: \n\n".$log."\n\n";


	// Calculate total value of account.
	$stocks = getAllSharesOwned(1337);
	$size = count($stocks);
	$total_value = 0;
	$initial_value = 0;
	// We need to break it into bitesized chunks.  For future reference, this should be done internally.
	for($i = 0; $i < $size; $i += 10){
        	$data_set = array_slice($stocks, $i, 10);
        	$result_set = getDataOnSymbols($data_set);
		foreach($result_set as $stock){	
			$symbol = $stock["Symbol"];
			$initial = getInitialValueOfSharesOwned(1337, $symbol);
			$num = getNumSharesOwned(1337, $symbol);	
			$total_value += $num*floatval($stock["Last Trade (Price Only)"]);
			$initial_value += $initial;
		}

	}
	
	$body .= "Total initial value of investments: $initial_value\nTotal current value of investments: $total_value\n";

	// Hacky.
	$current_balance = getBalanceFromAccount(1337);
	// Initial balance: this is the hacky part lol
	$init_balance = 1000000; // a million

	$total_value += $current_balance;
	$initial_value += $init_balance;

	$body .= "Total initial value of account: $initial_value\nTotal current value of investments: $total_value\n";
	$body .= "Total gain/lost = ".(100*(($total_value-$initial_value)/$initial_value)) . "%\n\n";

	$body .= "\nThis was an automated report generated by Mike Sprague\n\n";

	sendReport("miketsprague@gmail.com", "Transaction Summary for " . date('l jS \of F Y h:i:s A'), $body);
?>
