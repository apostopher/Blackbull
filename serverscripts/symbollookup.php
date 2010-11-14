<?php
                // get the scrip name
                $scrip = urlencode($_GET['scrip']);

                //get symbol lookup from yahoo
                $callback = "YAHOO.Finance.SymbolSuggest.ssCallback";
                $callbacklen = strlen($callback);
                $handle   = fopen("http://d.yimg.com/autoc.finance.yahoo.com/autoc?query=$scrip&callback=$callback","r");
                $contents = trim(stream_get_contents($handle));
                $jsonRsp = substr($contents,$callbacklen + 1, strlen($contents) - $callbacklen - 2);
                header('Content-type: application/json');
                if(strstr($_SERVER["HTTP_USER_AGENT"],"MSIE")==false) {
                                header("Cache-Control: no-cache");
                                header("Pragma: no-cache");
                }
                $results = json_decode( $jsonRsp );

                /********************************************************************************************************
                 * In foreach loop arrow is used because the decoded json contains object of stdClass and not of array.
                 *	eg: print_r($results);
                 *	output:
                 *		stdClass Object
				 *		(
				 *		    [ResultSet] => stdClass Object
				 *		        (
				 *		            [Query] => tcs.bo
				 *		            [Result] => Array
				 *		                (
				 *		                    [0] => stdClass Object
				 *		                        (
				 *		                            [symbol] => TCS.BO
				 *		                            [name] => TCS LTD
				 *		                            [exch] => BSE
				 *		                            [type] => S
				 *		                            [exchDisp] => Bombay
				 *		                            [typeDisp] => Equity
				 *		                        )
				 *
				 *		                )
 				 *
				 *		        )
 				 *
				 *		)
                 **********************************************************************************************************
                 */

                foreach ($results->ResultSet->Result as $key => $value) {
				    if (strcmp('NSI', $value->exch)!=0 && strcmp('BSE', $value->exch)!=0) {
				        unset($results->ResultSet->Result[$key]);
				   }
				}
				echo json_encode($results);
?>