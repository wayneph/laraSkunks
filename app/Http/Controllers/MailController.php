<?php namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;
use App\Http\Middleware\MailService as helper;
class MailController extends Controller
{
    public function sendMail(Request $request) {
        $mailResponse=helper::sendIt($request);
        $hddrToken="NotSet-See Errors";
        if(isset($mailResponse['token']['usageToken'])){
            $hddrToken=$mailResponse['token']['usageToken'];
            unset($mailResponse['token']);
            unset($mailResponse['UserHelper']);
            unset($mailResponse['apiHealth']);
            $mailResponse['token']=$hddrToken;
        }
        unset($mailResponse['token']);
        return response()->json($mailResponse,$mailResponse['status'])
        ->header('Content-Type', 'json')
        ->header('token', $hddrToken);
    }
    public function sendPin(Request $request) {
        $mailResponse=helper::sendPin($request);
        $hddrToken="NotSet-See Errors";
        if(isset($mailResponse['token']['usageToken'])){
            $hddrToken=$mailResponse['token']['usageToken'];
            unset($mailResponse['token']);
            unset($mailResponse['UserHelper']);
            unset($mailResponse['apiHealth']);
            $mailResponse['token']=$hddrToken;
        }
        unset($mailResponse['token']);
        return response()->json($mailResponse,$mailResponse['status'])
        ->header('Content-Type', 'json')
        ->header('token', $hddrToken);
    }
}