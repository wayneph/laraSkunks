<?php namespace App\Http\Middleware;

use App\Http\Middleware\DataLogic as dl;

class SitesHelper
{
    static $myName="SitesHelper";
    static $sitesListForUser=array('uuid|uuid','slug|slug','status|status');
    public static function getSitePage(object $request, string $siteSlug, string $pageSlug)
    {
        $sitesArray['status']=400;
        $tokensValidArray=dl::allCallsValidateTokens($request);
        if($tokensValidArray['status']!=200){
            $sitesArray['status']=$tokensValidArray['status'];
            $sitesArray['security']=$tokensValidArray;
            $sitesArray[self::$myName]=__line__;
            return $sitesArray;
        }
        $page=dl::getSitePage($tokensValidArray['user_id'],$siteSlug, $pageSlug);
        $page=self::excludeFields($page,['id','site_id','site_id','seq','created','updated']);
        if(is_null($page)){
            $sitesArray['status']=404;
            $sitesArray['data']=null;
            return $sitesArray;
        }
        $sitesArray['status']=200;
        $sitesArray['token']=$tokensValidArray;
        $sitesArray['records']=1;
        $sitesArray['orderBy']="NotSet";
        $sitesArray['moreRecordsExist']=false;
        $sitesArray['data']=$page;
        return $sitesArray;
    }
    public static function getSiteSiteStatics(object $request, string $siteSlug)
    {
        $sitesArray['status']=400;
        $tokensValidArray=dl::allCallsValidateTokens($request);
        if($tokensValidArray['status']!=200){
            $sitesArray['status']=$tokensValidArray['status'];
            $sitesArray['security']=$tokensValidArray;
            $sitesArray[self::$myName]=__line__;
            return $sitesArray;
        }
        $statics=dl::getSiteSiteStatics($tokensValidArray['user_id'],$siteSlug);
        $statics=self::excludeFields($statics,['id']);
        if(is_null($statics)){
            $staticsArray['status']=404;
            $staticsArray['data']=null;
            return $sitesArray;
        }
        $staticsArray['status']=200;
        $staticsArray['token']=$tokensValidArray;
        $staticsArray['records']=1;
        $staticsArray['orderBy']="NotSet";
        $staticsArray['moreRecordsExist']=false;
        $staticsArray['data']=$statics;
        return $staticsArray;
    }
    // public static function validateSiteSpecificPageByPageName(object $request)
    // {
    //     $sitesArray['status']=400;
    //     $inputs['json']=json_decode($request->getContent(), true);
    //     $validArray=dl::validateInputs(self::$pageNameInbound,$inputs['json']);
    //     if($validArray['status']!==200){
    //         $returnArray=$validArray;
    //         $returnArray[self::$myName]=__line__;
    //         return $returnArray;
    //     }
    //     $tokensValidArray=dl::allCallsValidateTokens($request);
    //     if($tokensValidArray['status']!=200){
    //         $sitesArray['status']=$tokensValidArray['status'];
    //         $sitesArray['security']=$tokensValidArray;
    //         $sitesArray["{$sitesArray['status']}HelperException"]=__line__;
    //         return $sitesArray;
    //     }
    //     $page=dl::getPageByNameForSite($inputs['json'],$tokensValidArray['user_id']);
    //     if(is_null($page)){
    //         $sitesArray['status']='404';
    //         $sitesArray['data']=null;
    //         $sitesArray['security']=$tokensValidArray;
    //         $sitesArray["{$sitesArray['status']}HelperException"]=__line__;
    //         return $sitesArray;
    //     }
    //     if(count($page)>0){
    //         $sitesArray['status']=200;
    //         $sitesArray['token']=$tokensValidArray;
    //         $sitesArray['records']=1;
    //         $sitesArray['moreRecordsExist']=false;
    //         $sitesArray['data']=$page;
    //         $sitesArray['apiHealth'][self::$myName]=__line__;
    //         return $sitesArray;
    //     }
    //     $sitesArray['status']=404;
    //     $sitesArray['data']=null;
    //     $sitesArray["{$sitesArray['status']}HelperException"]=__line__;
    //     return $sitesArray;

    // }
    public static function validateSiteSpecificPageAll(object $request, int $siteId, int $pageId)
    {
        $sitesArray['status']=400;
        $tokensValidArray=dl::allCallsValidateTokens($request);
        if($tokensValidArray['status']!=200){
            $sitesArray['status']=$tokensValidArray['status'];
            $sitesArray['security']=$tokensValidArray;
            $sitesArray["{$sitesArray['status']}HelperException"]=__line__;
            return $sitesArray;
        }
        $page=dl::getPageAll($tokensValidArray['user_id'],$pageId);
        if(is_null($page)){
            $sitesArray['status']='404';
            $sitesArray['data']=null;
            $sitesArray['security']=$tokensValidArray;
            $sitesArray["{$sitesArray['status']}HelperException"]=__line__;
            return $sitesArray;
        }
        if(count($page)>0){
            $sitesArray['status']=200;
            $sitesArray['token']=$tokensValidArray;
            $sitesArray['records']=1;
            $sitesArray['moreRecordsExist']=false;
            $sitesArray['data']=$page;
            $sitesArray["{$sitesArray['status']}HelperException"]=__line__;
            return $sitesArray;
        }
        $sitesArray['status']=404;
        $sitesArray['data']=null;
        $sitesArray["{$sitesArray['status']}HelperException"]=__line__;
        return $sitesArray;

    }
    private static function excludeFields(array $array, array $exclude)
    {
        for($e=0;$e<count($exclude);$e++){
            unset($array[$exclude[$e]]);
        }
        return $array;
    }
    public static function validateSitePageListing(object $request, string $siteUUID)           //  21    07  28 waynep
    {
        $sitesArray['status']=400;
        $tokensValidArray=dl::allCallsValidateTokens($request);
        if($tokensValidArray['status']!=200){
            $sitesArray['status']=$tokensValidArray['status'];
            $sitesArray['security']=$tokensValidArray;
            $sitesArray[self::$myName]=__line__;
            return $sitesArray;
        }
        $pages=dl::getSitePages($tokensValidArray['user_id'],$siteUUID);
        $pages=self::setOutputFields(self::$pagesListForUser,$pages,1);
        if(is_null($pages)){
            $sitesArray['status']=404;
            $sitesArray['data']=null;
            return $sitesArray;
        }
        $sitesArray['status']=200;
        $sitesArray['token']=$tokensValidArray;
        $sitesArray['records']=count($pages);
        $sitesArray['orderBy']="seq Ascending";
        $sitesArray['moreRecordsExist']=false;
        $sitesArray['data']=$pages;
        return $sitesArray;
    }
    public static function getSiteUserIdByUUID(object $request, string $siteUUID)       //  21  07  27
    {
        $sitesArray['status']=400;
        $tokensValidArray=dl::allCallsValidateTokens($request);
        if($tokensValidArray['status']!=200){
            $sitesArray['status']=$tokensValidArray['status'];
            $sitesArray['security']=$tokensValidArray;
            $sitesArray["{$sitesArray['status']}HelperException"]=__line__;
            return $sitesArray;
        }
        $site=dl::getSiteUserIdByUUID($tokensValidArray['user_id'],$siteUUID);
        if(is_null($site)){
            $sitesArray['status']=404;
            $sitesArray['data']=null;
            return $sitesArray;
        }
        $site=self::setOutputFields(self::$siteListForUser,$site,0);
        $sitesArray['status']=200;
        $sitesArray['token']=$tokensValidArray;
        $sitesArray['records']=1;
        $sitesArray['moreRecordsExist']=false;
        $sitesArray['data']=$site;
        return $sitesArray;
    }
    public static function validateSitesGet(object $request)        //  21  02  18
    {
        $sitesArray['status']=400;
        $tokensValidArray=dl::allCallsValidateTokens($request);
        if($tokensValidArray['status']!=200){
            $sitesArray['status']=$tokensValidArray['status'];
            $sitesArray['security']=$tokensValidArray;
            $sitesArray["{$sitesArray['status']}HelperException"]=__line__;
            return $sitesArray;
        }
        $sites=dl::getSitesForUserId($tokensValidArray['user_id']);
        if(count($sites)>0){
            $sites=self::setOutputFields(self::$sitesListForUser,$sites,1);
            $sitesArray['status']=200;
            $sitesArray['token']=$tokensValidArray;
            $sitesArray['records']=count($sites);
            $sitesArray['moreRecordsExist']=false;
            $sitesArray['data']=$sites;
            $sitesArray['apiHealth'][self::$myName]=__line__;
            return $sitesArray;
        }
        $sitesArray['status']=404;
        $sitesArray['data']=null;
        $sitesArray["{$sitesArray['status']}HelperException"]=__line__;
        return $sitesArray;
    }
    private static function setOutputFields(array $fields, array $data, int $multi=0)
    {
        //single record force
        if($multi==0){
            foreach ($fields as $key => $value) {
                $explValue=explode("|",$value);
                if(isset($data[$explValue[0]])){
                    $outArray[$explValue[1]]=$data[$explValue[0]];
                }
            }
            return $outArray;
        }
        // must be multi records
        for($i=0;$i<count($data);$i++){
            $rec=$data[$i];
            foreach ($fields as $key => $value) {
                $explValue=explode("|",$value);
                if(isset($rec[$explValue[0]])){
                    $outArray[$i][$explValue[1]]=$rec[$explValue[0]];
                }
            }
        }
        return $outArray;
    }
}