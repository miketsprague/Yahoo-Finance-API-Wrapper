<?php // if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Modified by Michael Sprague
 * August 2012
 * @license MIT
 */

include("tagConstants.php");

class Finance
{
    private $url;
    private $tags;
    private $tags_url;

    function __construct($tags = "s|n|l1|t1|d1|c1|p2")
    {
        $this->url = "http://finance.yahoo.com/d/quotes.csv?s=";
        $this->tags = $tags;
        $args = str_replace("|", "", $tags);
        $this->tags_url = "&f=$args&e=.csv";
    }
    
   
    /**
     * get_quotes
     * Gets quotes for the symbol(s)
     *
     * @access  public
     * @param   array $symbols   array of market symbols
     * @return  array
     */
    public function get_quotes($symbols)
    {
        $symbol_str = "";
        $len = count($symbols);
        if($len > 1)
        {
            for($i = 0; $i < $len; $i++)
            {
                $symbol_str .= $symbols[$i];
                if($i != ($len - 1)) 
                {
                    $symbol_str .= "+"; 
                }
            }
        }
        else
        {
            $symbol_str = $symbols[0];
        }
        $full_url = $this->url . $symbol_str . $this->tags_url;
        return $this->_get_data($full_url);
    }
    
    /**
     * _get_data
     * Gets and returns results array from Yahoo! Finance CSV generated from the URL passed
     *
     * @access  private
     * @param   string  $url   URL to API method returning CSV
     * @return  array
     */
    private function _get_data($url)
    {
        if(($handle = fopen($url, "r")) !== FALSE)
        {
            $row = 0;
            $quotes = array();
            $tags = explode("|", $this->tags);
            while(($data = fgetcsv($handle, 1000, ",")) !== FALSE)
            {
              foreach($data as $key => $value){
                  $quotes[$row][getDescriptionOfTag($tags[$key])] = $value;
              }
                $row++;
            } 
            return $quotes;
        }
        else
        {
            return FALSE;
        }
    }
    
}
// END Finance Class

/* End of file Finance.php */

?>
