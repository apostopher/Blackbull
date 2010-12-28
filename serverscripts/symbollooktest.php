<?php
                // get the scrip name
                $scrip = "tcs.ns";

                //get symbol lookup from yahoo
                /*$callback = "YAHOO.Finance.SymbolSuggest.ssCallback";*/
                $callback = "YAHOO.util.ScriptNodeDataSource.callbacks";
                $callbacklen = strlen($callback);
                $handle   = fopen("http://d.yimg.com/autoc.finance.yahoo.com/autoc?query=$scrip&region=IN&lang=en-IN&callback=$callback","r");
                $contents = trim(stream_get_contents($handle));
                $jsonRsp = substr($contents,$callbacklen + 1, strlen($contents) - $callbacklen - 2);
                
                $results = json_decode($jsonRsp);
                print_r($results->ResultSet->Result[0]->name);
                fclose($handle);
?>