<?php namespace App\Http\Middleware;

use App\Http\Middleware\DataLogic as dl;
include_once("PHPMailer/src/PHPMailer.php");

use PHPMailer\PHPMailer;

class MailService
{
    static $createMail=array('to'=>'1~eml~100','to_person'=>'1~str~100','subject'=>'1~str~150','to_person'=>'1~str~2048');
    static $myName="MailHelper";
    public static function sendIt(object $request)
    {
        $returnArray['status']=400;
        $inputs['json']=json_decode($request->getContent(), true);
        $inputs['header']['api-key']=$request->header("api-key");
        $inputs['bearer']=$request->bearerToken();
        $inputs['uri']=$request->path();
        $validArray=dl::validateInputs(self::$createMail,$inputs['json']);
        if($validArray['status']!==200){
            $mailResponseArray=$validArray;
            return $returnArray;
        }
        $tokensValidArray=dl::allCallsValidateTokens($request);
        if($tokensValidArray['status']!=200){
            $mailResponseArray['status']=$tokensValidArray['status'];
            $mailResponseArray['security']=$tokensValidArray;
            $mailResponseArray["{$mailResponseArray['status']}HelperException"]=__line__;
            return $mailResponseArray;
        }
        $user=self::sendTheMail($inputs['json']);
        if($user['status']!=201){
            $mailResponseArray['status']='409';
            $mailResponseArray['data']=$user;
            $mailResponseArray['security']=$tokensValidArray;
            $mailResponseArray["{$mailResponseArray['status']}HelperException"]=__line__;
            return $mailResponseArray;
        }
        $mailResponseArray['status']=201;
        $mailResponseArray['token']=$tokensValidArray;
        $mailResponseArray['records']=1;
        $mailResponseArray['moreRecordsExist']=false;
        $mailResponseArray['data']=$user;
        $mailResponseArray['apiHealth'][self::$myName]=__line__;
        return $mailResponseArray;
    }
    private static function sendTheMail(array $sendArray)
    {
        $mail=new PHPMailer;
        $mail->isSMTP();
        $mail->SMTPDebug = 0;
        $mail->Host = getenv('MAIL_HOST');
        $mail->Port = getenv('MAIL_PORT');
        $mail->SMTPSecure = getenv('MAIL_ENCRYPTION');
        $mail->SMTPAuth = getenv('MAIL_SMTP_SECURE');
        $mail->Username = getenv('MAIL_USERNAME');
        $mail->Password = getenv('MAIL_PASSWORD');
        $nameFrom=getenv('MAIL_FROM_NAME');
        $nameFrom='DoNotRespond';
        $mail->setFrom(getenv('MAIL_USERNAME'), $nameFrom);
        $mail->addReplyTo(getenv('MAIL_USERNAME'), $nameFrom);
        $nameTo="";
        if (isset($sendArray['to_person'])) {
            $nameTo=$sendArray['to_person'];
        }
        $mail->addAddress($sendArray['to'], $nameTo);
        $arr=$sendArray['to'];
        $renderAt=date("Y-m-d H:i:s");
        $body=$sendArray['body']."<br><br><br>Sent at:<b> $renderAt </b><br>";
        $mail->msgHTML($body);
        $mail->Subject=$sendArray['subject'];
        $mail->msgHTML(urldecode($sendArray['body']));
        if (!$mail->send()) {
            $retArray['status']=500;
            $retArray['error']="Sending Error {$mail->ErrorInfo}";
            $retArray['message'][]=$mail->ErrorInfo;
        }
        else{
            $retArray['status']=201;
            $retArray['message']="Success";
        }
        return $retArray;
    }
}
