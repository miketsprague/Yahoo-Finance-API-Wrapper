<?php
require_once "Mail.php";

date_default_timezone_set("America/Los_Angeles");
sendReport("miketsprague@gmail.com", "Transaction Summary for" . date('l jS \of F Y h:i:s A'), "Test\n\nLove, Mike");
function sendReport($to, $subject, $body) {
        $from = "<msprague.investing.gmail.com>";
        $to = "<$to>";

        $host = "ssl://smtp.gmail.com";
        $port = "465";
        $username = "msprague.investing@gmail.com";  //<> give errors
        $password = "SsWK4Nvm";

        $headers = array ('From' => $from,
          'To' => $to,
          'Subject' => $subject);
        $smtp = Mail::factory('smtp',
          array ('host' => $host,
            'port' => $port,
            'auth' => true,
            'username' => $username,
            'password' => $password));

        $mail = $smtp->send($to, $headers, $body);

        if (PEAR::isError($mail)) {
          echo("<p>" . $mail->getMessage() . "</p>");
         } else {
          echo("<p>Message successfully sent!</p>");
         }

}
?>  
