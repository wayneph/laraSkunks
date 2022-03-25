<?php namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;
use App\Http\Middleware\KubeHelper as helper;
class Kube extends Controller
{
    private $docAt="api-docs.skunks.co/?";
    //posts
    public function getClusterList(Request $request)
    {
        $response=helper::getClusterList($request);
        $hddrToken="NotSet";
        if(isset($loginResponse['tokens']['usageToken'])){
            $hddrToken=$loginResponse['tokens']['usageToken'];
            unset($loginResponse['tokens']);
            unset($loginResponse['UserHelper']);
            $loginResponse['token']=$hddrToken;
        }
       unset($response['apiHealth']);
       unset($response['token']);
       unset($response['security']['user_id']);
       return response()->json($response,$response['status'])
            ->header('Content-Type', 'json')
            ->header('token', $hddrToken)
            ->header('Doc', "{$this->docAt}login");
    }
    public function postCluster(Request $request)
    {
        $response=helper::postCluster($request);
        $hddrToken="NotSet-See Errors";
        if(isset($response['tokens']['usageToken'])){
            $hddrToken=$response['tokens']['usageToken'];
            unset($response['token']);
            unset($response['UserHelper']);
            unset($response['apiHealth']);
        }
        return response()->json($response,$response['status'])
            ->header('Content-Type', 'json')
            ->header('token', $hddrToken)
            ->header('Doc', "{$this->docAt}post-Cluster");
    }



    /* =======================================================================================*/
    public function getStatuses(Request $request)                           /* 21 04 27 */
    {
        $loginResponse=helper::getStatuses($request);
        $hddrToken="NotSet-See Errors";
        if(isset($loginResponse['tokens']['usageToken'])){
            $hddrToken=$loginResponse['tokens']['usageToken'];
            unset($loginResponse['tokens']);
            unset($loginResponse['UserHelper']);
            $loginResponse['token']=$hddrToken;
        }
       unset($loginResponse['apiHealth']);
       unset($loginResponse['token']);
       unset($loginResponse['security']['user_id']);
       return response()->json($loginResponse,$loginResponse['status'])
            ->header('Content-Type', 'json')
            ->header('token', $hddrToken)
            ->header('Doc', "{$this->docAt}login");
    }
    public function getTransactionTypes(Request $request)                   /* 21 04 27 */
    {
        $loginResponse=helper::getTransactionTypes($request);
        $hddrToken="NotSet-See Errors";
        if(isset($loginResponse['tokens']['usageToken'])){
            $hddrToken=$loginResponse['tokens']['usageToken'];
            unset($loginResponse['tokens']);
            unset($loginResponse['UserHelper']);
            $loginResponse['token']=$hddrToken;
        }
       unset($loginResponse['apiHealth']);
       unset($loginResponse['token']);
       unset($loginResponse['security']['user_id']);
       return response()->json($loginResponse,$loginResponse['status'])
            ->header('Content-Type', 'json')
            ->header('token', $hddrToken)
            ->header('Doc', "{$this->docAt}login");
    }
    //sets
    public function setRating(Request $request)
    {
        $response=helper::setRating($request);
        $hddrToken="NotSet-See Errors";
        if(isset($response['tokens']['usageToken'])){
            $hddrToken=$response['tokens']['usageToken'];
            unset($response['token']);
            unset($response['UserHelper']);
            unset($response['apiHealth']);
        }
        return response()->json($response,$response['status'])
            ->header('Content-Type', 'json')
            ->header('token', $hddrToken)
            ->header('Doc', "{$this->docAt}login");
    }

}