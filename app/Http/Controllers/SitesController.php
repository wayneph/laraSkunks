<?php namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;
use App\Http\Middleware\SitesHelper as helper;
class SitesController extends Controller
{
    private $docAt="api-docs.skunks.co/";
    public function getSiteSpecificPageByName(Request $request)
    {
        /* VALIDATE INPUTS */
        $getSitesResponse=helper::validateSiteSpecificPageByPageName($request);
        if(isset($getSitesResponse['token']['usageToken'])){
            $token=$getSitesResponse['token']['usageToken'];
        }
        $hddrRemedy="/sites";
        unset($getSitesResponse['security']['header']);
        unset($getSitesResponse['usageToken']);
        unset($getSitesResponse['apiHealth']);
        unset($getSitesResponse['token']);
        unset($getSitesResponse['userId']);
        if($getSitesResponse['status']!=200){
            return response()->json($getSitesResponse,$getSitesResponse['status'])
            ->header('Content-Type', 'json')
            ->header('remedy', $hddrRemedy);
        }
        return response()->json($getSitesResponse,$getSitesResponse['status'])
        ->header('token',$token)
        ->header('nextCall','/sites/site/{siteId}')
        ->header('Doc', "{$this->docAt}/sites");
    }
    public function getSiteSpecificPage(Request $request, int $siteId, int $pageId)
    {
        /* VALIDATE INPUTS */
        $getSitesResponse=helper::validateSiteSpecificPageAll($request, $siteId, $pageId);
        if(isset($getSitesResponse['token']['usageToken'])){
            $token=$getSitesResponse['token']['usageToken'];
        }
        $hddrRemedy="/sites";
        unset($getSitesResponse['security']['header']);
        unset($getSitesResponse['usageToken']);
        unset($getSitesResponse['apiHealth']);
        unset($getSitesResponse['token']);
        unset($getSitesResponse['userId']);
        if($getSitesResponse['status']!=200){
            return response()->json($getSitesResponse,$getSitesResponse['status'])
            ->header('Content-Type', 'json')
            ->header('remedy', $hddrRemedy);
        }
        return response()->json($getSitesResponse,$getSitesResponse['status'])
        ->header('token',$token)
        ->header('nextCall','/sites/site/{siteId}')
        ->header('Doc', "{$this->docAt}/sites");
    }
    public function getSiteSiteStatics(Request $request, string $siteSlug, string $pageName)
    {
        $getSitesResponse=helper::getSiteSiteStatics($request, $siteSlug);  //waynep
        if(isset($getSitesResponse['token']['usageToken'])){
            $token=$getSitesResponse['token']['usageToken'];
        }
        $hddrRemedy="/sites";
        unset($getSitesResponse['security']['header']);
        unset($getSitesResponse['usageToken']);
        unset($getSitesResponse['apiHealth']);
        unset($getSitesResponse['token']);
        unset($getSitesResponse['userId']);
        if($getSitesResponse['status']!=200){
            return response()->json($getSitesResponse,$getSitesResponse['status'])
            ->header('Content-Type', 'json')
            ->header('remedy', $hddrRemedy);
        }
        return response()->json($getSitesResponse,$getSitesResponse['status'])
        ->header('token',$token)
        ->header('nextCall','/sites/site/{siteId}')
        ->header('Doc', "{$this->docAt}/sites");
    }
    public function getSitePage(Request $request, string $siteSlug, string $pageSlug)
    {
        $getSitesResponse=helper::getSitePage($request, $siteSlug, $pageSlug);
        if(isset($getSitesResponse['token']['usageToken'])){
            $token=$getSitesResponse['token']['usageToken'];
        }
        $hddrRemedy="/sites";
        unset($getSitesResponse['security']['header']);
        unset($getSitesResponse['usageToken']);
        unset($getSitesResponse['apiHealth']);
        unset($getSitesResponse['token']);
        unset($getSitesResponse['userId']);
        if($getSitesResponse['status']!=200){
            return response()->json($getSitesResponse,$getSitesResponse['status'])
            ->header('Content-Type', 'json')
            ->header('remedy', $hddrRemedy);
        }
        return response()->json($getSitesResponse,$getSitesResponse['status'])
        ->header('token',$token)
        ->header('nextCall','/sites/site/{siteId}')
        ->header('Doc', "{$this->docAt}/sites");
    }
    // public function getSitePages(Request $request, string $siteUUID)
    // {
    //     $getSitesResponse=helper::validateSitePageListing($request, $siteUUID);
    //     if(isset($getSitesResponse['token']['usageToken'])){
    //         $token=$getSitesResponse['token']['usageToken'];
    //     }
    //     $hddrRemedy="/sites";
    //     unset($getSitesResponse['security']['header']);
    //     unset($getSitesResponse['usageToken']);
    //     unset($getSitesResponse['apiHealth']);
    //     unset($getSitesResponse['token']);
    //     unset($getSitesResponse['userId']);
    //     if($getSitesResponse['status']!=200){
    //         return response()->json($getSitesResponse,$getSitesResponse['status'])
    //         ->header('Content-Type', 'json')
    //         ->header('remedy', $hddrRemedy);
    //     }
    //     return response()->json($getSitesResponse,$getSitesResponse['status'])
    //     ->header('token',$token)
    //     ->header('nextCall','/sites/site/{siteId}')
    //     ->header('Doc', "{$this->docAt}/sites");
    // }
    public function getSites(Request $request)                           //  21    02    18
    {
        $getSitesResponse=helper::validateSitesGet($request);
        if(isset($getSitesResponse['token']['usageToken'])){
            $token=$getSitesResponse['token']['usageToken'];
        }
        $hddrRemedy="/sites";
        unset($getSitesResponse['security']['header']);
        unset($getSitesResponse['usageToken']);
        unset($getSitesResponse['apiHealth']);
        unset($getSitesResponse['token']);
        unset($getSitesResponse['userId']);
        if($getSitesResponse['status']!=200){
            return response()->json($getSitesResponse,$getSitesResponse['status'])
            ->header('Content-Type', 'json')
            ->header('remedy', $hddrRemedy);
        }
        return response()->json($getSitesResponse,$getSitesResponse['status'])
        ->header('token',$token)
        ->header('nextCall','/sites/site/{siteId}')
        ->header('Doc', "{$this->docAt}/sites");
    }
    public function getSite(Request $request, string $siteUUID)                             //  21    02    07
    {
        $getSitesResponse=helper::getSiteUserIdByUUID($request, $siteUUID);
        if(isset($getSitesResponse['token']['usageToken'])){
            $token=$getSitesResponse['token']['usageToken'];
        }
        $hddrRemedy="/sites";
        unset($getSitesResponse['security']['header']);
        unset($getSitesResponse['usageToken']);
        unset($getSitesResponse['apiHealth']);
        unset($getSitesResponse['token']);
        unset($getSitesResponse['userId']);
        if($getSitesResponse['status']!=200){
            return response()->json($getSitesResponse,$getSitesResponse['status'])
            ->header('Content-Type', 'json')
            ->header('remedy', $hddrRemedy);
        }
        return response()->json($getSitesResponse,$getSitesResponse['status'])
        ->header('token',$token)
        ->header('nextCall','/sites/site/{siteId}')
        ->header('Doc', "{$this->docAt}/sites");
    }
}