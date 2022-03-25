<?php namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;
use App\Http\Middleware\EntitiesHelper as helper;
class EntitiesController extends Controller
{
    private $docAt="api-docs.nanoescrow.pro/?";
    public function getEntity(Request $request, string $invocationSlug, string $entitySlug )
    {
        $response=helper::getEntity($request, $invocationSlug, $entitySlug);
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
    public function getEntitiesByType(Request $request, string $invocationSlug, string $typeSlug)     //k8s
    {
        $response=helper::getEntitiesByType($request, $invocationSlug, $typeSlug);
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

    public function getEntitiesInvocations(Request $request)
    {
        $response=helper::getEntitiesInvocations($request);
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

    public function getEntityInfo(Request $request, string $invocationSlug, string $entitySlug)     //k8s
    {
        $response=helper::getEntityInfo($request, $invocationSlug, $entitySlug);
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

    public function getEntityRelate(Request $request, string $invocationSlug, string $entitySlug)
    {
        $response=helper::getEntityRelate($request, $invocationSlug, $entitySlug);
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
    public function getEntityTypes(Request $request, string $invocationSlug )  //k8s
    {
        $response=helper::getEntityTypes($request, $invocationSlug);
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
    public function postEntity(Request $request, $invocationSlug)
    {
        $entityCreateResponse=helper::postEntity($request,$invocationSlug);
        $hddrToken="NotSet-See Errors";
        if(isset($entityCreateResponse['tokens']['usageToken'])){
            $hddrToken=$entityCreateResponse['tokens']['usageToken'];
            unset($entityCreateResponse['tokens']);
            unset($entityCreateResponse['UserHelper']);
            $entityCreateResponse['token']=$hddrToken;
        }
        unset($entityCreateResponse['token']);
        unset($entityCreateResponse['security']);
        return response()->json($entityCreateResponse,$entityCreateResponse['status'])
        ->header('Content-Type', 'json')
        ->header('token', $hddrToken)
        ->header('Doc', "{$this->docAt}login");
    }
}