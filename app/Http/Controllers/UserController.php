<?php namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;
use App\Http\Middleware\UserHelper as helper;
class UserController extends Controller
{
    private $docAt="api-docs.skunks.co/?";


    public function login(Request $request)
    {
        $loginResponse=helper::login($request);
        $hddrToken="NotSet-See Errors";
        if(isset($loginResponse['tokens']['token'])){
            $hddrToken=$loginResponse['tokens']['token'];
            unset($loginResponse['tokens']);
            unset($loginResponse['UserHelper']);
            $loginResponse['token']=$hddrToken;
        }
        unset($loginResponse['token']);
        return response()->json($loginResponse,$loginResponse['status'])
        ->header('Content-Type', 'json')
        ->header('token', $hddrToken)
        ->header('Doc', "{$this->docAt}login");
    }

    public function createUser(Request $request){
        $loginResponse=helper::createUser($request);
        $hddrToken="NotSet-See Errors";
        if(isset($loginResponse['tokens']['usageToken'])){
            $hddrToken=$loginResponse['tokens']['usageToken'];
            unset($loginResponse['tokens']);
            unset($loginResponse['UserHelper']);
            $loginResponse['token']=$hddrToken;
        }
        unset($loginResponse['token']);
        unset($loginResponse['security']);
        return response()->json($loginResponse,$loginResponse['status'])
        ->header('Content-Type', 'json')
        ->header('token', $hddrToken)
        ->header('Doc', "{$this->docAt}login");
    }

    public function getMessagesBySiteSlugPublic(Request $request, string $siteSlug)        //ok
    {
        $getComms=helper::getMessagesBySiteSlugPublic($request, $siteSlug);
        $hddrToken="NotSet-See Errors";
        if(isset($getComms['tokens']['usageToken'])){
            $hddrToken=$getComms['tokens']['usageToken'];
            unset($getComms['tokens']);
            unset($getComms['UserHelper']);
            $getComms['token']=$hddrToken;
        }
        unset($getComms['token']);
        unset($getComms['security']);
        return response()->json($getComms,$getComms['status'])
        ->header('Content-Type', 'json')
        ->header('token', $hddrToken)
        ->header('Doc', "{$this->docAt}comms");
    }

    public function getPin(Request $request, string $userHash)
    {
        $getPin=helper::getPin($request, $userHash);
        $hddrToken="NotSet-See Errors";
        if(isset($getPin['tokens']['usageToken'])){
            $hddrToken=$getPin['tokens']['usageToken'];
            unset($getPin['tokens']);
            unset($getPin['UserHelper']);
            $getPin['token']=$hddrToken;
        }
        unset($getPin['token']);
        unset($getPin['security']);
        return response()->json($getPin,$getPin['status'])
        ->header('Content-Type', 'json')
        ->header('token', $hddrToken)
        ->header('Doc', "{$this->docAt}comms");
    }

    public function postComms(Request $request)
    {
        $postCommsResponse=helper::postComms($request);
        $hddrToken="NotSet-See Errors";
        if(isset($postCommsResponse['tokens']['usageToken'])){
            $hddrToken=$postCommsResponse['tokens']['usageToken'];
            unset($postCommsResponse['tokens']);
            unset($postCommsResponse['UserHelper']);
            $postCommsResponse['token']=$hddrToken;
        }
        unset($postCommsResponse['token']);
        unset($postCommsResponse['security']);
        return response()->json($postCommsResponse,$postCommsResponse['status'])
        ->header('Content-Type', 'json')
        ->header('token', $hddrToken)
        ->header('Doc', "{$this->docAt}comms");
    }
    public function patchComms(Request $request, string $slug) //k8s
    {
        $patchCommsResponse=helper::patchComms($request, $slug);
        $hddrToken="NotSet-See Errors";
        if(isset($patchCommsResponse['tokens']['usageToken'])){
            $hddrToken=$patchCommsResponse['tokens']['usageToken'];
            unset($patchCommsResponse['tokens']);
            unset($patchCommsResponse['UserHelper']);
            $patchCommsResponse['token']=$hddrToken;
        }
        unset($patchCommsResponse['token']);
        unset($patchCommsResponse['security']);
        return response()->json($patchCommsResponse,$patchCommsResponse['status'])
        ->header('Content-Type', 'json')
        ->header('token', $hddrToken)
        ->header('Doc', "{$this->docAt}comms");
    }
    public function showUser(Request $request)
    {
        $loginResponse=helper::showUser($request);
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
    public function findUser(Request $request, string $userHash) //waynep
    {
        $loginResponse=helper::findUser($request,$userHash);
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
    public function setPin(Request $request)
    {
        $pinCreateResponse=helper::setPin($request);
        $hddrToken="NotSet-See Errors";
        if(isset($pinCreateResponse['tokens']['usageToken'])){
            $hddrToken=$pinCreateResponse['tokens']['usageToken'];
            unset($pinCreateResponse['tokens']);
            unset($pinCreateResponse['UserHelper']);
            $pinCreateResponse['token']=$hddrToken;
        }
        unset($pinCreateResponse['token']);
        unset($pinCreateResponse['security']);
        return response()->json($pinCreateResponse,$pinCreateResponse['status'])
        ->header('Content-Type', 'json')
        ->header('token', $hddrToken)
        ->header('Doc', "{$this->docAt}login");
    }
    public function setToken(Request $request)
    {
        $pinCreateResponse=helper::setToken($request);
        $hddrToken="NotSet-See Errors";
        if(isset($pinCreateResponse['tokens']['usageToken'])){
            $hddrToken=$pinCreateResponse['tokens']['usageToken'];
            unset($pinCreateResponse['tokens']);
            unset($pinCreateResponse['UserHelper']);
            $pinCreateResponse['token']=$hddrToken;
        }
        unset($pinCreateResponse['token']);
        unset($pinCreateResponse['security']);
        return response()->json($pinCreateResponse,$pinCreateResponse['status'])
        ->header('Content-Type', 'json')
        ->header('token', $hddrToken)
        ->header('Doc', "{$this->docAt}login");
    }
}