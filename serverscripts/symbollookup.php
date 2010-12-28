<?php
                // get the scrip name
                $scrip = urlencode($_GET['scrip']);

                //get symbol lookup from yahoo
                /*$callback = "YAHOO.Finance.SymbolSuggest.ssCallback";*/
                $callback = "YAHOO.util.ScriptNodeDataSource.callbacks";
                $callbacklen = strlen($callback);
                $handle   = fopen("http://d.yimg.com/autoc.finance.yahoo.com/autoc?query=$scrip&region=IN&lang=en-IN&callback=$callback","r");
                $contents = trim(stream_get_contents($handle));
                $jsonRsp = substr($contents,$callbacklen + 1, strlen($contents) - $callbacklen - 2);
                header('Content-type: application/json');
                if(strstr($_SERVER["HTTP_USER_AGENT"],"MSIE")==false) {
                                header("Cache-Control: no-cache");
                                header("Pragma: no-cache");
                }
                echo $jsonRsp;
                fclose($handle);
?>