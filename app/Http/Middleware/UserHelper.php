<?php namespace App\Http\Middleware;
use App\Http\Middleware\DataLogic as dl;

class UserHelper
{
    static $myName="UserHelper";
    /*  INPUT VALIDATION    */
    static $login=array('user_id'=>'1~str~20','pin'=>'1~str~8');
    static $createUser=array('userid'=>'1~str~20','email'=>'1~eml~100');
    static $showUser=array('email'=>'1~eml~100');
    static $showUserHash=array('user_hash'=>'1~str~130');
    static $sendPin=array('user_hash'=>'1~str~130');
    static $displayForUser=array("userid","fullname","action_json","status","logons","user_hash");
    static $commsPostArray=array(
        'site_slug'=>'1~str~16',
        'comms_text'=>'1~str~300',
        'comms_topic'=>'1~str~50',
        'comms_by_slug'=>'1~str~100',
        'source_slug'=>'1~str~16',
        'for_slug'=>'1~str~100',
        'comms_log'=>'1~str~100'
        );
    static $commsPatchArray=array(
        'status'=>'1~int~11'
        );
    static $setToken=array('user_hash'=>'1~str~130','token'=>'1~str~64','type_id'=>'1~int~11');
/*  OUTPUT FILTERS      */
    //static $outputPin=array('token'=>'pin','type_use'=>'used_for');
    static $outputComms=array('comms_topic'=>'topic','status'=>'status','comms_ref'=>'comms_ref');
/*  RECORDSET PARAMS    */
    static $limit=10;
    static $offset=1;

    private static function adjustOutput(array $proforma, $arrayData)
    {
        $retArray=array();
        for($n=0;$n<count($proforma);$n++){
            if(isset($arrayData[$proforma[$n]])){
                $retArray[$proforma[$n]]=$arrayData[$proforma[$n]];
            }
        }
        return $retArray;
    }

    public static function getMessagesBySiteSlugPublic(object $request,string $siteSlug)        //k8s   waynep
    {
        $returnArray['status']=400;
        $qParams = $request->all();
        if(!isset($qParams['page'])){
            $qParams['page']=1;
        }
        if(!isset($qParams['size'])){
            $qParams['size']=10;
        }
        $qParams['orderBy']['field']="updated";
        $qParams['orderBy']['order']="desc";
        $inputs['header']['api-key']=$request->header("api-key");
        $inputs['uri']=$request->path();
        $tokensValidArray=dl::allCallsValidateTokens($request);
        if($tokensValidArray['status']!=200){
            $messageResponseArray['status']=$tokensValidArray['status'];
            $messageResponseArray['security']=$tokensValidArray;
            $messageResponseArray["{$messageResponseArray['status']}HelperException"]=__line__;
            return $messageResponseArray;
        }
        $messages=dl::getMessagesBySiteSlugPublic($siteSlug, $qParams);
        if(is_null($messages)){
            $messageResponseArray['status']='404';
            $messageResponseArray['data']=null;
            $messageResponseArray['security']=$tokensValidArray;
            $messageResponseArray["{$messageResponseArray['status']}HelperException"]=__line__;
            return $messageResponseArray;
        }
        if(count($messages)>0){
            $messageResponseArray['status']=200;
            $messageResponseArray['tokens']=$tokensValidArray;
            $messageResponseArray['records']=count($messages);
            $messageResponseArray['moreRecordsExist']=$messages['hasMoreRecords'];
            $messageResponseArray['data']=$messages['data'];
            return $messageResponseArray;
        }
        $messageResponseArray['status']=404;
        $messageResponseArray['data']=null;
        $messageResponseArray["{$messageResponseArray['status']}HelperException"]=__line__;
        return $messageResponseArray;
    }

    public static function getPin(object $request,string $userHash)        //k8s   waynep
    {
        $returnArray['status']=400;
        $inputs['header']['api-key']=$request->header("api-key");
        $inputs['uri']=$request->path();
        $tokensValidArray=dl::allCallsValidateTokens($request);
        if($tokensValidArray['status']!=200){
            $messageResponseArray['status']=$tokensValidArray['status'];
            $messageResponseArray['security']=$tokensValidArray;
            $messageResponseArray["{$messageResponseArray['status']}HelperException"]=__line__;
            return $messageResponseArray;
        }
        $pinArray=dl::getUserByPin($userHash);
        if(is_null($pinArray)){
            $messageResponseArray['status']='404';
            $messageResponseArray['data']=null;
            $messageResponseArray['security']=$tokensValidArray;
            $messageResponseArray["{$messageResponseArray['status']}HelperException"]=__line__;
            return $messageResponseArray;
        }
        if(count($pinArray)>0){
            $messageResponseArray['status']=200;
            $messageResponseArray['tokens']=$tokensValidArray;
            $messageResponseArray['records']=1;
            $messageResponseArray['data']=$pinArray;
            return $messageResponseArray;
        }
        $messageResponseArray['status']=404;
        $messageResponseArray['data']=null;
        $messageResponseArray["{$messageResponseArray['status']}HelperException"]=__line__;
        return $messageResponseArray;
    }

    public static function findUser(object $request,string $userHash)
    {
        $returnArray['status']=400;
        $inputs['json']=json_decode($request->getContent(), true);
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
        $user=dl::getUserByHash($userHash);
        if(is_null($user)){
            $UserResponseArray['status']='404';
            $UserResponseArray['data']=null;
            $UserResponseArray['security']=$tokensValidArray;
            $UserResponseArray["{$UserResponseArray['status']}HelperException"]=__line__;
            return $UserResponseArray;
        }
        if(count($user)>0){
            $UserResponseArray['status']=200;
            $UserResponseArray['tokens']=$tokensValidArray;
            $UserResponseArray['records']=1;
            $UserResponseArray['moreRecordsExist']=false;
            $UserResponseArray['data']=self::adjustOutput(self::$displayForUser,$user);
            $UserResponseArray['apiHealth'][self::$myName]=__line__;
            return $UserResponseArray;
        }
        $UserResponseArray['status']=404;
        $UserResponseArray['data']=null;
        $UserResponseArray["{$UserResponseArray['status']}HelperException"]=__line__;
        return $UserResponseArray;
    }

    public static function showUser(object $request)
    {
        $returnArray['status']=400;
        $tokensValidArray=dl::allCallsValidateTokens($request);
        if($tokensValidArray['status']!=200){
            $UserResponseArray['status']=$tokensValidArray['status'];
            $UserResponseArray['security']=$tokensValidArray;
            $UserResponseArray["{$UserResponseArray['status']}HelperException"]=__line__;
            return $UserResponseArray;
        }
        $user=dl::getUserById($tokensValidArray['user_id']);
        if(is_null($user)){
            $UserResponseArray['status']='404';
            $UserResponseArray['data']=null;
            $UserResponseArray['security']=$tokensValidArray;
            $UserResponseArray["{$UserResponseArray['status']}HelperException"]=__line__;
            return $UserResponseArray;
        }
        if(count($user)>0){
            $UserResponseArray['status']=200;
            $UserResponseArray['tokens']=$tokensValidArray;
            $UserResponseArray['records']=1;
            $UserResponseArray['moreRecordsExist']=false;
            $UserResponseArray['data']=$user;
            $UserResponseArray['apiHealth'][self::$myName]=__line__;
            return $UserResponseArray;
        }
        $UserResponseArray['status']=404;
        $UserResponseArray['data']=null;
        $UserResponseArray["{$UserResponseArray['status']}HelperException"]=__line__;
        return $UserResponseArray;
    }
    public static function patchComms(object $request, string $slug) //waynep
    {
        $returnArray['status']=400;
        $inputs['json']=json_decode($request->getContent(), true);
        $validArray=dl::validateInputs(self::$commsPatchArray,$inputs['json']);
        if($validArray['status']!==200){
            $commsResponseArray=$validArray;
            $commsResponseArray["{$commsResponseArray['status']}HelperException"]=__line__;
            return $commsResponseArray;
        }
        $tokensValidArray=dl::allCallsValidateTokens($request);
        if($tokensValidArray['status']!=200){
            $commsResponseArray['status']=$tokensValidArray['status'];
            $commsResponseArray['security']=$tokensValidArray;
            $commsResponseArray["{$commsResponseArray['status']}HelperException"]=__line__;
            return $commsResponseArray;
        }
        $commsPatchStatus=dl::patchComms($inputs['json'],$slug);
        if($commsPatchStatus!=202){
            $returnArray['status']=$commsPatchStatus;
            $returnArray['data']='patchFailed';
            $returnArray['security']=$tokensValidArray;
            return $returnArray;
        }
        $returnArray['status']=202;
        $returnArray['tokens']=$tokensValidArray;
        $returnArray['records']=1;
        $returnArray['data']='patchSuccess';
        $returnArray['moreRecordsExist']=false;
        return $returnArray;
    }
    public static function postComms(object $request)
    {
        $returnArray['status']=400;
        $inputs['json']=json_decode($request->getContent(), true);
        $validArray=dl::validateInputs(self::$commsPostArray,$inputs['json']);
        if($validArray['status']!==200){
            $commsResponseArray=$validArray;
            $commsResponseArray["{$commsResponseArray['status']}HelperException"]=__line__;
            return $commsResponseArray;
        }
        $tokensValidArray=dl::allCallsValidateTokens($request);
        if($tokensValidArray['status']!=200){
            $commsResponseArray['status']=$tokensValidArray['status'];
            $commsResponseArray['security']=$tokensValidArray;
            $commsResponseArray['security']=$tokensValidArray;
            $commsResponseArray["{$commsResponseArray['status']}HelperException"]=__line__;
            return $commsResponseArray;
        }
        $commsArray=dl::postComms($inputs['json'],$tokensValidArray['user_id']);
        if($commsArray['status']!=201){
            $returnArray['status']='409';
            $returnArray['data']=$commsArray;
            $returnArray['security']=$tokensValidArray;
            return $returnArray;
        }
        $dataOut=dl::validateOutputFields($commsArray, self::$outputComms);
        $returnArray['status']=201;
        $returnArray['tokens']=$tokensValidArray;
        $returnArray['records']=1;
        $returnArray['moreRecordsExist']=false;
        $returnArray['data']=$dataOut;
        return $returnArray;
    }
    public static function setPin(object $request)
    {
        $returnArray['status']=400;
        $inputs['json']=json_decode($request->getContent(), true);
        $validArray=dl::validateInputs(self::$sendPin,$inputs['json']);
        if($validArray['status']!==200){
            $UserResponseArray=$validArray;
            $UserResponseArray["{$UserResponseArray['status']}HelperException"]=__line__;
            return $UserResponseArray;
        }
        $tokensValidArray=dl::allCallsValidateTokens($request);
        if($tokensValidArray['status']!=200){
            $UserResponseArray['status']=$tokensValidArray['status'];
            $UserResponseArray['security']=$tokensValidArray;
            $UserResponseArray["{$UserResponseArray['status']}HelperException"]=__line__;
            return $UserResponseArray;
        }
        $pinArray=dl::setUserPin($inputs['json']['user_hash']);
        if($pinArray['status']!=201){
            $returnArray['status']='409';
            $returnArray['data']=$pinArray;
            $returnArray['security']=$tokensValidArray;
            $returnArray["{$pinArray['status']}HelperException"]=__line__;
            return $returnArray;
        }
        //$dataOut=dl::validateOutputFields($pinArray, self::$outputPin);
        $returnArray['status']=201;
        $returnArray['tokens']=$tokensValidArray;
        $returnArray['records']=1;
        $returnArray['moreRecordsExist']=false;
        $returnArray['data']=$pinArray;
        return $returnArray;
    }
    public static function setToken(object $request)
    {
        $returnArray['status']=400;
        $inputs['json']=json_decode($request->getContent(), true);
        $validArray=dl::validateInputs(self::$setToken,$inputs['json']);
        if($validArray['status']!==200){
            $responseArray=$validArray;
            $responseArray["{$responseArray['status']}HelperException"]=__line__;
            return $responseArray;
        }
        $tokensValidArray=dl::allCallsValidateTokens($request);
        if($tokensValidArray['status']!=200){
            $responseArray['status']=$tokensValidArray['status'];
            $responseArray['security']=$tokensValidArray;
            $responseArray["{$responseArray['status']}HelperException"]=__line__;
            return $responseArray;
        }
        $tokenArray['status']=404;
        $tokenArray=dl::setToken($inputs['json']);
        $tokenArray['status']=403;
        if(isset($tokenArray['id'])){
            $tokenArray['status']=201;
        }
        if($tokenArray['status']!=201){
            $returnArray['status']='409';
            $returnArray['data']=$tokenArray;
            $returnArray['security']=$tokensValidArray;
            //$returnArray["{$pinArray['status']}HelperException"]=__line__;
            return $returnArray;
        }
        $dataOut=dl::validateOutputFields($tokenArray, self::$outputPin);
        $returnArray['status']=201;
        $returnArray['tokens']=$tokensValidArray;
        $returnArray['records']=1;
        $returnArray['moreRecordsExist']=false;
        $returnArray['data']=$dataOut;
        return $returnArray;
    }
    public static function createUser(object $request)
    {
        //dd($request);
        $returnArray['status']=400;
        $inputs['json']=json_decode($request->getContent(), true);
        $inputs['header']['api-key']=$request->header("api-key");
        $inputs['bearer']=$request->bearerToken();
        $inputs['uri']=$request->path();
        $validArray=dl::validateInputs(self::$createUser,$inputs['json']);
        if($validArray['status']!==200){
            $UserResponseArray=$validArray;
            $UserResponseArray["{$UserResponseArray['status']}HelperException"]="Tokens";
            return $returnArray;
        }
        $tokensValidArray=dl::allCallsValidateTokens($request);
        if($tokensValidArray['status']!=200){
            $UserResponseArray['status']=$tokensValidArray['status'];
            $UserResponseArray['security']=$tokensValidArray;
            $UserResponseArray["{$UserResponseArray['status']}-TokensError"]=__line__;
            if(getenv("APP_DEBUG")){
                $wishArray['slug']="createUser-Tokens-Error";
                $wishArray['call']=$inputs['uri'];
                $wishArray['inputs']=$inputs;
                $wishArray['tokens']=$tokensValidArray;
                $wishArray['response']=$UserResponseArray;
                dl::setSiteWish($wishArray);
            }
            return $UserResponseArray;
        }
        $user=dl::setUser($inputs['json']);
        if($user['status']!=201){
            $UserResponseArray['status']='409';
            $UserResponseArray['data']=$user;
            $UserResponseArray['security']=$tokensValidArray;
            $UserResponseArray["{$UserResponseArray['status']}HelperException"]=__line__;
            return $UserResponseArray;
        }
        $UserResponseArray['status']=201;
        $UserResponseArray['tokens']=$tokensValidArray;
        $UserResponseArray['data']=$user;
        $UserResponseArray['records']=1;
        $UserResponseArray['moreRecordsExist']=false;
        $UserResponseArray['data']=$user;
        return $UserResponseArray;
    }
    public static function login(object $request)
    {
        $returnArray['status']=400;
        $inputs['json']=json_decode($request->getContent(), true);
        $inputs['header']['api-key']=$request->header("api-key");
        $inputs['bearer']=$request->bearerToken();
        $inputs['uri']=$request->path();
        $validArray=dl::validateInputs(self::$login,$inputs['json']);
        if($validArray['status']!==200){
            $returnArray=$validArray;
            $returnArray[self::$myName]=__line__;
            return $returnArray;
        }
        $tokens=dl::getValidTokensFromUser($inputs['json']['user_id']);
        if(is_null($tokens)){
            $returnArray['status']=404;
            $returnArray['msg']='User Invalid or No Tokens Found for user';
            return $returnArray;
        }
        $returnArray['user_id']=200;
        $returnArray['api_key']=404;
        $returnArray['pin']=404;
        $countValids=0;
        for ($i = 0; $i < count($tokens); $i++) {
            if($tokens[$i]['token_type_id']==2){
                if($inputs['header']['api-key']==$tokens[$i]['token']){
                    $returnArray['api_key']=200;
                    $countValids++;
                    dl::setTokenExpires($tokens[$i]);
                }
            }
            if($tokens[$i]['token_type_id']==3){
                if($inputs['json']['pin']==$tokens[$i]['token']){
                    $returnArray['pin']=200;
                    $countValids++;
                    dl::setTokenExpires($tokens[$i]);
                }
            }
        }
        $userId=$tokens[0]['user_id'];
        if($countValids==2){
            $returnArray['tokens']=dl::setUsageTokens($userId);
            $returnArray['status']=200;
            $returnArray[self::$myName]=__line__;
        }
        return $returnArray;
    }
}