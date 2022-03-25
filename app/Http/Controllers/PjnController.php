<?php namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;
use App\Http\Middleware\PjnHelper as helper;
class PjnController extends Controller
{
    private $docAt="api-docs.nanoescrow.pro/?";
    public function getAccounts(Request $request)                                              /* 21 04 27 */
    {
    /**
     * @OA\Get(
     *     path="/sample/{category}/things",
     *     operationId="/sample/category/things",
     *     tags={"yourtag"},
     *     @OA\Parameter(
     *         name="category",
     *         in="path",
     *         description="The category parameter in path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="criteria",
     *         in="query",
     *         description="Some optional other parameter",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Returns some sample category things",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Error: Bad request. When required parameters were not supplied.",
     *     ),
     * )
     */
        $response=helper::getAccounts($request);
        $hddrToken="NotSet-See Errors";
        if(isset($response['tokens']['usageToken'])){
            $hddrToken=$response['tokens']['usageToken'];
            unset($response['tokens']);
            unset($response['UserHelper']);
            $response['token']=$hddrToken;
        }
       unset($response['apiHealth']);
       unset($response['token']);
       unset($response['security']['user_id']);
       return response()->json($response,$response['status'])
            ->header('Content-Type', 'json')
            ->header('token', $hddrToken)
            ->header('Doc', "{$this->docAt}login");
    }
    public function getRatingDefs(Request $request)                           /* 21 04 27 */
    {
        $loginResponse=helper::getRatingDefs($request);
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
    public function setTransaction(Request $request)
    {
        $response=helper::setTransaction($request);
        echo("<br>Array:params(".__LINE__."(".__METHOD__."))<br><pre>"); print_r($response); echo("</pre><hr>");
        exit();
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