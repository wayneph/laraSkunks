<?php namespace App\Http\Middleware;
use App\Http\Middleware\DataLogic as dl;

class KubeHelper
{
    static $myName="K8sHelper";
    /*  INPUT VALIDATION  VARS  */
    static $clusterSets = array(
        'cluster_name'=>'1~str~100',
        'slug'=>'1~str~16'
    );
    // static $ratingSet = array(
    //     'status'=>'1~str~11',
    //     'transaction_type_id' => '1~str~11',
    //     'account_slug' => '1~str~16',
    //     'slug' => '1~str~16',
    //     'seq' => '1~str~11',
    //     'description' => '1~str~100',
    //     'percentage' => '1~str~11',
    //     'residual' => '1~str~1',
    //     'amount' => '1~str~20'
    // );
    // posts
    public static function getClusterList(object $request)
    {
        $respond['status']=200;
        $respond['pagination']=null;
        $inputs['header']['api-key']=$request->header("api-key");
        $inputs['bearer']=$request->bearerToken();
        $inputs['uri']=$request->path();
        $tokensValidArray=dl::allCallsValidateTokens($request);
        // if($tokensValidArray['status']!=200){
        //     $UserResponseArray['status']=$tokensValidArray['status'];
        //     $UserResponseArray['security']=$tokensValidArray;
        //     $UserResponseArray["{$UserResponseArray['status']}HelperException"]=__line__;
        //     return $UserResponseArray;
        // }
        $data=dl::getKubeClusterList($request->header("api-key"));
        if(count($data)==0){
            $respond['records']=0;
            $respond['data']=null;
        }
        else{
            $respond['records']=count($data);
            $respond['data']=$data;
        }
        return $respond;
    }
    public static function postCluster(object $request)
    {
        $returnArray['status']=400;
        $inputs['json']=json_decode($request->getContent(), true);
        $inputs['header']['api-key']=$request->header("api-key");
        $inputs['bearer']=$request->bearerToken();
        $inputs['uri']=$request->path();
        $validArray=dl::validateInputs(self::$clusterSets,$inputs['json']);
        if($validArray['status']!==200){
            $returnArray=$validArray;
            $returnArray["{$validArray['status']}HelperException"]=__LINE__;
            return $returnArray;
        }
        $tokensValidArray=dl::allCallsValidateTokens($request);
        if($tokensValidArray['status']!=200){
            $transactionRatedArray['status']=$tokensValidArray['status'];
            $transactionRatedArray['security']=$tokensValidArray;
            $transactionRatedArray["{$transactionRatedArray['status']}-TokensError"]=__line__;
            return $transactionRatedArray;
        }
        dd($inputs['json']);
        $clusterCreateResponse=dl::setK8sCluster($inputs['json']);
        if($clusterCreateResponse['status']!=200){
            $transactionRatedArray['status']    =$clusterCreateResponse['status'];
            $transactionRatedArray['data']      =$clusterCreateResponse;
            $transactionRatedArray['security']  =$tokensValidArray;
            $transactionRatedArray["{$clusterCreateResponse['status']}-Ratings not set for transaction"]=__LINE__;
            return $transactionRatedArray;
        }
    }





    public static function getAccounts(object $request)                             /*  01  04  28 */
    {                                                                               /*  GET complex slash & json */
        $returnArray['status']=400;
        //$inputs['query']=$request->query();
        $inputs['json']=json_decode($request->getContent(), true);
        $inputs['header']['api-key']=$request->header("api-key");
        $inputs['bearer']=$request->bearerToken();
        $inputs['uri']=$request->path();
        // $tokensValidArray=dl::allCallsValidateTokens($request);
        // if($tokensValidArray['status']!=200){
        //     $UserResponseArray['status']=$tokensValidArray['status'];
        //     $UserResponseArray['security']=$tokensValidArray;
        //     $UserResponseArray["{$UserResponseArray['status']}HelperException"]=__line__;
        //     return $UserResponseArray;
        // }
        $dataArray=dl::getAccounts($inputs['json']);
        if(is_null($dataArray['data'])){
            $responseArray['status']='404';
            $responseArray['parameters']=$dataArray['parameters'];
            $responseArray['data']=null;
            //$responseArray['security']=$tokensValidArray;
            return $responseArray;
        }
        if(count($dataArray)>0){
            $responseArray['status']=200;
            //$responseArray['tokens']=$tokensValidArray;
            $responseArray['parameters']=$dataArray['parameters'];
            $responseArray['data']=$dataArray['data'];
            return $responseArray;
        }
        $responseArray['status']=404;
        //$responseArray['tokens']=$tokensValidArray;
        $responseArray['data']=null;
        $responseArray["{$responseArray['status']}HelperException"]=__line__;
        return $responseArray;
    }
    public static function getRatingDefs(object $request)                               /*  01  04  27 */
    {                                                                                   /*  GET complex slash & json */
        $returnArray['status']=400;
        //$inputs['query']=$request->query();
        $inputs['json']=json_decode($request->getContent(), true);
        $inputs['header']['api-key']=$request->header("api-key");
        $inputs['bearer']=$request->bearerToken();
        $inputs['uri']=$request->path();
        // $tokensValidArray=dl::allCallsValidateTokens($request);
        // if($tokensValidArray['status']!=200){
        //     $UserResponseArray['status']=$tokensValidArray['status'];
        //     $UserResponseArray['security']=$tokensValidArray;
        //     $UserResponseArray["{$UserResponseArray['status']}HelperException"]=__line__;
        //     return $UserResponseArray;
        // }
        $dataArray=dl::getRatingDefs($inputs['json']);
        if(is_null($dataArray['data'])){
            $responseArray['status']='404';
            $responseArray['parameters']=$dataArray['parameters'];
            $responseArray['data']=null;
            //$responseArray['security']=$tokensValidArray;
            return $responseArray;
        }
        if(count($dataArray)>0){
            $responseArray['status']=200;
            //$responseArray['tokens']=$tokensValidArray;
            $responseArray['parameters']=$dataArray['parameters'];
            $responseArray['data']=$dataArray['data'];
            return $responseArray;
        }
        $responseArray['status']=404;
        //$responseArray['tokens']=$tokensValidArray;
        $responseArray['data']=null;
        $responseArray["{$responseArray['status']}HelperException"]=__line__;
        return $responseArray;
    }
    public static function getStatuses(object $request)                                 /*  01  04  27 */
    {                                                                                   /*  GET simple slash */
        $returnArray['status']=400;
        $inputs['header']['api-key']=$request->header("api-key");
        $inputs['bearer']=$request->bearerToken();
        $inputs['uri']=$request->path();
        $tokensValidArray=dl::allCallsValidateTokens($request);
        if($tokensValidArray['status']!=200){
            $UserResponseArray['status']=$tokensValidArray['status'];
            $UserResponseArray['security']=$tokensValidArray;
            $UserResponseArray["{$UserResponseArray['status']}HelperException"]=__line__;
            return $UserResponseArray;
        }
        $dataArray=dl::getStatuses();
        if(is_null($dataArray)){
            $responseArray['status']='404';
            $responseArray['data']=null;
            $responseArray['security']=$tokensValidArray;
            $responseArray["{$responseArray['status']}HelperException"]=__line__;
            return $responseArray;
        }
        if(count($dataArray)>0){
            $responseArray['status']=200;
            $responseArray['tokens']=$tokensValidArray;
            $responseArray['records']=count($dataArray);
            $responseArray['moreRecordsExist']=false;
            $responseArray['data']=$dataArray;
            return $responseArray;
        }
        $responseArray['status']=404;
        $responseArray['data']=null;
        $responseArray["{$responseArray['status']}HelperException"]=__line__;
        return $responseArray;
    }
    public static function getTransactionTypes(object $request)                                                 /*  01  04  27 */
    {
        $returnArray['status']=400;
        $inputs['header']['api-key']=$request->header("api-key");
        $inputs['bearer']=$request->bearerToken();
        $inputs['uri']=$request->path();
        $tokensValidArray=dl::allCallsValidateTokens($request);
        if($tokensValidArray['status']!=200){
            $UserResponseArray['status']=$tokensValidArray['status'];
            $UserResponseArray['security']=$tokensValidArray;
            $UserResponseArray["{$UserResponseArray['status']}HelperException"]=__line__;
            return $UserResponseArray;
        }
        $transactionTypes=dl::getTransactionTypes();
        if(is_null($transactionTypes)){
            $responseArray['status']='404';
            $responseArray['data']=null;
            $responseArray['security']=$tokensValidArray;
            $responseArray["{$responseArray['status']}HelperException"]=__line__;
            return $responseArray;
        }
        if(count($transactionTypes)>0){
            $responseArray['status']=200;
            $responseArray['tokens']=$tokensValidArray;
            $responseArray['records']=count($transactionTypes);
            $responseArray['moreRecordsExist']=false;
            $responseArray['data']=$transactionTypes;
            return $responseArray;
        }
        $responseArray['status']=404;
        $responseArray['data']=null;
        $responseArray["{$responseArray['status']}HelperException"]=__LINE__;
        return $responseArray;
    }

    public static function setTransaction(object $request)                                                      /* 21  04  26 */
    {
        $returnArray['status']=400;
        $inputs['json']=json_decode($request->getContent(), true);
        $inputs['header']['api-key']=$request->header("api-key");
        $inputs['bearer']=$request->bearerToken();
        $inputs['uri']=$request->path();
        $validArray=dl::validateInputs(self::$transactionSet,$inputs['json']);
        if($validArray['status']!==200){
            $returnArray=$validArray;
            $returnArray["{$validArray['status']}HelperException"]="Tokens";
            return $returnArray;
        }
        $envDebug=(bool)getenv("APP_DEBUG");
        $tokensValidArray['status']=900; // debug value
        if(!$envDebug){
            $tokensValidArray=dl::allCallsValidateTokens($request);
            if($tokensValidArray['status']!=200){
                $returnArray['status']=$tokensValidArray['status'];
                $returnArray['security']=$tokensValidArray;
                $returnArray["{$transactionRatedArray['status']}-TokensError"]=__line__;
                return $returnArray;
            }
        }
        $ratingDefs=dl::getPjnRatingsBySlug($inputs['json']['slug']);
        $persist=(bool)$inputs['json']['persist'];
        if($persist){
            // write original transaction
            dd(__LINE__."::changed accounts table :: commit transaction next");
        }
        dd($persist);
        if($ratingDefs['status']!=200){
            $transactionRatedArray['status']=$ratingDefs['status'];
            $transactionRatedArray['data']=$transactionEvaluated;
            $transactionRatedArray['security']=$tokensValidArray;
            $transactionRatedArray["{$ratingDefs['status']}-Ratings not set for transaction"]=__line__;
            return $transactionRatedArray;
        }
        $amountToSplit=(int)$inputs['json']['amount'];
        $monthTotal=(int)$inputs['json']['month_total'];
        $haveSplit=0;
        $outArray=array();
        $ratingDefs=$ratingDefs['data'];
        for($i=0;$i<count($ratingDefs);$i++){
            $outArray[$i]['key']=$inputs['json']['id'];
            $outArray[$i]['description']=$ratingDefs[$i]['description'];
            $outArray[$i]['transactionTypeSlug']=$ratingDefs[$i]['transactionTypeSlug'];
            $outArray[$i]['inboundAccountSlug']=$ratingDefs[$i]['destinationAccountSlug'];
            /* non rebate transactions first*/
            if($ratingDefs[$i]['transactionTypeSlug']!='retrorebate'){
                if($ratingDefs[$i]['amount'] > 0){
                    $splitValue=0;
                    $outArray[$i]['baseAmount'] = (int)$amountToSplit;
                    $outArray[$i]['transactionDescription'] = "{$outArray[$i]['baseAmount']} to {$ratingDefs[$i]['destinationAccountName']}";
                    $splitValue=(int)$ratingDefs[$i]['amount'];
                    $outArray[$i]['inAmount'] = (int)($splitValue);
                    $haveSplit=$haveSplit+$splitValue;
                    $outArray[$i]['haveSplit']=$haveSplit;
                }
                if($ratingDefs[$i]['percentage']>0){
                    $splitValue=0;
                    $per=$ratingDefs[$i]['percentage'];
                    $outArray[$i]['baseAmount']=(int)($amountToSplit);
                    $outArray[$i]['transactionDescription']="$per% to {$ratingDefs[$i]['destinationAccountName']}";
                    $factor=floatval($ratingDefs[$i]['percentage']/100);
                    $outArray[$i]['inAmount']=(int)($amountToSplit*$factor);
                    $haveSplit=$haveSplit+$outArray[$i]['inAmount'];
                    $outArray[$i]['haveSplit']=$haveSplit;
                }
                if($ratingDefs[$i]['residual'] == 1){
                    $splitValue=0;
                    $residual=$amountToSplit-$haveSplit;
                    $outArray[$i]['baseAmount'] = (int)$residual;
                    $outArray[$i]['transactionDescription'] = "$residual to {$ratingDefs[$i]['destinationAccountName']}";
                    $outArray[$i]['inAmount'] = (int)($residual);
                    $outArray[$i]['haveSplit']=$haveSplit+$outArray[$i]['inAmount'];
                }
            }
            if($ratingDefs[$i]['transactionTypeSlug'] == 'retrorebate'){
                $logicArray=json_decode($ratingDefs[$i]['logic'],true);
                $rateForAmount=(int)$ratingDefs[$i]['amount'];
                if($monthTotal > (int)$ratingDefs[$i]['amount']){
                    $factor = floatval($ratingDefs[$i]['percentage']/100);
                    $amountAbs = (int)($amountToSplit*$factor);
                    $outArray[$i]['baseAmount'] = floatval($monthTotal);
                    $outArray[$i]['transactionDescription'] = "Rebate as Set::$monthTotal > $rateForAmount :: Applied {$ratingDefs[$i]['percentage']}% to $amountToSplit";
                    $outArray[$i]['inAmount'] = (int)$amountAbs;
                    $outArray[$i]['outboundAccountSlug']=$logicArray['retroOutAccount'];
                    $outArray[$i]['out_amount']=(int)($amountAbs*-1);
                }
                if($monthTotal <= (int)$ratingDefs[$i]['amount']){
                    $outArray[$i]['base_amount'] = floatval($monthTotal);
                    $outArray[$i]['rebate'] = "None::$monthTotal <= {$ratingDefs[$i]['amount']}";
                }
            }
        }
        $transactionRatedArray['status']=201;
        //$transactionRatedArray['tokens']=$tokensValidArray;
        $transactionRatedArray['data']=$outArray;
        $transactionRatedArray['records']=count($outArray);
        $transactionRatedArray['moreRecordsExist']=false;
        return $transactionRatedArray;
    }
}