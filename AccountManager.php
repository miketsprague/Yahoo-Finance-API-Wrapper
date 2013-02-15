<?php

//buyShares(1337, 'AAPL', 100, 52);
//echo calcluateProfitOnStock(1337, 'AAPL', 51);
/*echo 'balance: '.getBalanceFromAccount(1337);
echo 'shares: '.getNumSharesOwned(1337, 'AAPL');
echo '\nSell all:'.sellAllShares(1337, 'AAPL', 100);
echo 'shares: '.getNumSharesOwned(1337, 'AAPL');
echo 'balance: '.getBalanceFromAccount(1337); */
// accountID is an int
// name is a string
// amount is a float
function createAccount($accountID, $name, $amount)
{
	//sql connect to DB
	$mysqli = getSQLCredentials();

	/* check connection */
	if (mysqli_connect_errno()) {
	    printf("Connect failed: %s\n", mysqli_connect_error());
	    exit();
	}

	$accountID = $mysqli->real_escape_string($accountID);
	$name = $mysqli->real_escape_string($name);
	$amount = $mysqli->real_escape_string($amount);

	if (!$mysqli->query("INSERT into Account (id, name, balance) VALUES ($accountID, '$name', $amount)")) {
	    printf("Error: %s\n", $mysqli->sqlstate);
	}

	$mysqli->close();	
}

function insertAmountIntoAccount($accountID, $amount)
{
	//sql connect to DB
	$mysqli = getSQLCredentials();

	/* check connection */
	if (mysqli_connect_errno()) {
	    printf("Connect failed: %s\n", mysqli_connect_error());
	    exit();
	}

	$accountID = $mysqli->real_escape_string($accountID);

	$result = $mysqli->query("SELECT balance from Account where id = $accountID");

	while ($row = $result->fetch_row()) {
       		$amount = floatval($row[0]) + $amount;
   	}
   	$amount = $mysqli->real_escape_string($amount);

	if (!$mysqli->query("UPDATE Account SET balance = $amount WHERE id = $accountID")) {
	    printf("Error: %s\n", $mysqli->sqlstate);
	}

	$mysqli->close();	
}

function getBalanceFromAccount($id)
{
	//sql connect to DB
	$mysqli = getSQLCredentials();

	/* check connection */
	if (mysqli_connect_errno()) {
	    printf("Connect failed: %s\n", mysqli_connect_error());
	    exit();
	}

	$id = $mysqli->real_escape_string($id);
	$result = $mysqli->query("SELECT balance FROM Account WHERE id = $id");

	while ($row = $result->fetch_row()) {
		$ret = floatval($row[0]);
		$mysqli->close();
		return $ret;
	}
	return -1;
}


function getNumSharesOwned($id, $symbol)
{
        //sql connect to DB
        $mysqli = getSQLCredentials();

        /* check connection */
        if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        }

        $id = $mysqli->real_escape_string($id);
        $symbol = $mysqli->real_escape_string($symbol);
        $result = $mysqli->query("select SUM(num_shares) from AccountOwnedStocks as stocks inner join Account on stocks.account_id = Account.id where account_id = $id AND symbol = '$symbol' AND is_valid = 1");

        while ($row = $result->fetch_row()) {
                $ret = floatval($row[0]);
              	$mysqli->close();
		return $ret;
        }
        return -1;
}

function buyShares($accountID, $symbol, $numShares, $pricePerShare)
{
	$totalCost = $numShares * $pricePerShare;
	$totalBalance = getBalanceFromAccount($accountID);
	if($totalCost > $totalBalance) {
		printf("Funds for $accountID are not sufficient to purchase $numShares of $symbol!");	
	}

	//sql connect to DB
	$mysqli = getSQLCredentials();

	/* check connection */
	if (mysqli_connect_errno()) {
	    printf("Connect failed: %s\n", mysqli_connect_error());
	    exit();
	}

	$accountID = $mysqli->real_escape_string($accountID);
	$symbol = $mysqli->real_escape_string($symbol);
	$numShares = $mysqli->real_escape_string($numShares);
	$pricePerShare = $mysqli->real_escape_string($pricePerShare);

	// TODO:
	$query_string = "INSERT INTO AccountOwnedStocks VALUES ($accountID, '$symbol', 'Buy', $numShares, $pricePerShare, 1, NOW(), NULL);";

	$result = $mysqli->query($query_string);

	if (!$result) {
		printf("Error message: %s\n", mysqli_error($mysqli));
		exit();
	}
	insertAmountIntoAccount($accountID, -1 * $totalCost);
}

function sellAllShares($accountID, $symbol, $pricePerShare)
{
	$numShares = getNumSharesOwned($accountID, $symbol);
       	if($numShares == 0) 
		return;
	$totalCost = $numShares * $pricePerShare;
        
	//sql connect to DB
        $mysqli = getSQLCredentials();

        /* check connection */
        if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        }

        $accountID = $mysqli->real_escape_string($accountID);
        $symbol = $mysqli->real_escape_string($symbol);

        // TODO: verify.
        $query_string = "UPDATE AccountOwnedStocks SET is_valid=0 WHERE account_id=$accountID AND symbol='$symbol'";

        $result = $mysqli->query($query_string);

        if (!$result) {
                printf("Error message: %s\n", mysqli_error($mysqli));
                exit();
        }
        insertAmountIntoAccount($accountID, $totalCost);
}


function calcluateProfitOnStock($accountID, $symbol, $currentPrice) {
        $mysqli = getSQLCredentials();

        /* check connection */
        if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        }

        $accountID = $mysqli->real_escape_string($accountID);
        $symbol = $mysqli->real_escape_string($symbol);
        $currentPrice = $mysqli->real_escape_string($currentPrice);
 	// XXX this might be wrong:
	$query_string = "SELECT SUM(  s.num_shares*($currentPrice - s.purchase_price)/s.purchase_price) AS gains from Account left outer join AccountOwnedStocks as s on id = s.account_id 
				WHERE is_valid = 1 AND symbol = '$symbol' AND id = $accountID";
       $result = $mysqli->query($query_string);
        while ($row = $result->fetch_row()) {
                $ret = floatval($row[0]);
                $mysqli->close();
                return $ret;
        }
        return -1;

}

function getSQLCredentials()
{
	return new mysqli("localhost", "root", "", "finance");
}



?>
