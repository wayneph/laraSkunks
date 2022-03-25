<?php namespace App\Http\Middleware;
use App\Http\Middleware\DataLogic as dl;

class EntitiesHelper
{
    static $myName="EntitiesHelper";
/*  INPUT VALIDATION    */
    static $postEntityArray=array('entity_name'=>'1-str-50',
        'entity_slug'=>'1-str-16',
        'user_hash'=>'1-str-128',
        'entity_type'=>'1-int-11');
/*  OUTPUT FILTERS      */
    static $outputInvocations=array('invocation'=>'invocation','crudmd'=>'crudToken');
    static $outputEntityTypes=array('id'=>'entityTypeId','selector'=>'entityType');
    static $outputEntityRelationshipTypes=array('id'=>'relationshipTypeId','type'=>'relationshipType');
/*  RECORDSET PARAMS    */
    static $limit=20;
    static $offset=1;
    public static function getEntity(object $request, string $invocationSlug, string $entitySlug)
    {
        $returnArray['status']=400;
        $inputs['header']['api-key']=$request->header("api-key");
        $tokensValidArray=dl::allCallsValidateTokens($request);
        if($tokensValidArray['status']!=200){
            unset($tokensValidArray['user_id']);
            $tokensValidArray['status']=401;
            return $tokensValidArray;
        }
        $entitiesData=dl::getEntity($tokensValidArray['usageToken'], $invocationSlug, $entitySlug);   //waynep
        if(is_null($entitiesData)){
            unset($tokensValidArray['user_id']);
            unset($tokensValidArray['usageToken']);
            $entitiesDataResponseArray['status']='404';
            $entitiesDataResponseArray['data']=null;
            $entitiesDataResponseArray['security']=$tokensValidArray;
            $entitiesDataResponseArray["{$entitiesDataResponseArray['status']}HelperException"]=__line__;
            return $entitiesDataResponseArray;
        }
        unset($tokensValidArray['user_id']);
        unset($tokensValidArray['usageToken']);
        $entitiesDataResponseArray['status']=200;
        $entitiesDataResponseArray['tokens']=$tokensValidArray;
        $entitiesDataResponseArray['records']=1;
        $entitiesDataResponseArray['moreRecordsExist']=0;
        $entitiesDataResponseArray['data'][0]=$entitiesData;
        return $entitiesDataResponseArray;
    }
    public static function getEntityInfo(object $request, string $invocationSlug, string $entitySlug)       //k8s
    {
        $returnArray['status']=400;
        $inputs['header']['api-key']=$request->header("api-key");
        $tokensValidArray=dl::allCallsValidateTokens($request);
        if($tokensValidArray['status']!=200){
            unset($tokensValidArray['user_id']);
            $tokensValidArray['status']=401;
            return $tokensValidArray;
        }
        $entitiesData=dl::getEntityInfo($tokensValidArray['usageToken'], $invocationSlug, $entitySlug);
        if(is_null($entitiesData)){
            unset($tokensValidArray['user_id']);
            unset($tokensValidArray['usageToken']);
            $entitiesDataResponseArray['status']='404';
            $entitiesDataResponseArray['data']=null;
            $entitiesDataResponseArray['security']=$tokensValidArray;
            $entitiesDataResponseArray["{$entitiesDataResponseArray['status']}HelperException"]=__line__;
            return $entitiesDataResponseArray;
        }
        unset($tokensValidArray['user_id']);
        unset($tokensValidArray['usageToken']);
        $entitiesDataResponseArray['status']=200;
        $entitiesDataResponseArray['tokens']=$tokensValidArray;
        $entitiesDataResponseArray['records']=1;
        $entitiesDataResponseArray['moreRecordsExist']=0;
        $entitiesDataResponseArray['data'][0]=$entitiesData;
        return $entitiesDataResponseArray;
    }

    public static function getEntityRelate(object $request, string $invocationSlug, string $entitySlug) //k8s
    {
        $returnArray['status']=400;
        $inputs['header']['api-key']=$request->header("api-key");
        $tokensValidArray=dl::allCallsValidateTokens($request);
        if($tokensValidArray['status']!=200){
            unset($tokensValidArray['user_id']);
            $tokensValidArray['status']=401;
            return $tokensValidArray;
        }
        $entitiesData=dl::getEntityRelate($tokensValidArray['usageToken'], $invocationSlug, $entitySlug);
        if(is_null($entitiesData)){
            unset($tokensValidArray['user_id']);
            unset($tokensValidArray['usageToken']);
            $entitiesDataResponseArray['status']='404';
            $entitiesDataResponseArray['data']=null;
            $entitiesDataResponseArray['security']=$tokensValidArray;
            $entitiesDataResponseArray["{$entitiesDataResponseArray['status']}HelperException"]=__line__;
            return $entitiesDataResponseArray;
        }
        unset($tokensValidArray['user_id']);
        unset($tokensValidArray['usageToken']);
        $entitiesDataResponseArray['status']=200;
        $entitiesDataResponseArray['tokens']=$tokensValidArray;
        $entitiesDataResponseArray['records']=1;
        $entitiesDataResponseArray['moreRecordsExist']=0;
        $entitiesDataResponseArray['data'][0]=$entitiesData;
        return $entitiesDataResponseArray;
    }

    // public static function getEntityRelateTo(object $request, string $invocationSlug, string $entitySlug) //k8s
    // {
    //     $returnArray['status']=400;
    //     $inputs['header']['api-key']=$request->header("api-key");
    //     $tokensValidArray=dl::allCallsValidateTokens($request);
    //     if($tokensValidArray['status']!=200){
    //         unset($tokensValidArray['user_id']);
    //         $tokensValidArray['status']=401;
    //         return $tokensValidArray;
    //     }
    //     $entitiesData=dl::getEntityRelateTo($tokensValidArray['usageToken'], $invocationSlug, $entitySlug);
    //     if(is_null($entitiesData)){
    //         unset($tokensValidArray['user_id']);
    //         unset($tokensValidArray['usageToken']);
    //         $entitiesDataResponseArray['status']='404';
    //         $entitiesDataResponseArray['data']=null;
    //         $entitiesDataResponseArray['security']=$tokensValidArray;
    //         $entitiesDataResponseArray["{$entitiesDataResponseArray['status']}HelperException"]=__line__;
    //         return $entitiesDataResponseArray;
    //     }
    //     unset($tokensValidArray['user_id']);
    //     unset($tokensValidArray['usageToken']);
    //     $entitiesDataResponseArray['status']=200;
    //     $entitiesDataResponseArray['tokens']=$tokensValidArray;
    //     $entitiesDataResponseArray['records']=1;
    //     $entitiesDataResponseArray['moreRecordsExist']=0;
    //     $entitiesDataResponseArray['data'][0]=$entitiesData;
    //     return $entitiesDataResponseArray;
    // }

    public static function getEntitiesByType(object $request, string $invocationSlug, string $typeSlug)     //k8s
    {
        $returnArray['status']=400;
        $qParams = $request->all();
        if(!isset($qParams['page'])){
            $qParams['page']=1;
        }
        if(!isset($qParams['size'])){
            $qParams['size']=20;
        }
        $inputs['header']['api-key']=$request->header("api-key");
        $tokensValidArray=dl::allCallsValidateTokens($request);
        if($tokensValidArray['status']!=200){
            unset($tokensValidArray['user_id']);
            $tokensValidArray['status']=401;
            return $tokensValidArray;
        }
        $entitiesListByType=dl::getEntitiesByType($tokensValidArray['usageToken'],$qParams,$invocationSlug,$typeSlug);   //waynep
        if(is_null($entitiesListByType)){
            unset($tokensValidArray['user_id']);
            unset($tokensValidArray['usageToken']);
            $entitiesListByTypeResponseArray['status']='404';
            $entitiesListByTypeResponseArray['data']=null;
            $entitiesListByTypeResponseArray['security']=$tokensValidArray;
            $entitiesListByTypeResponseArray["{$entitiesListByTypeResponseArray['status']}HelperException"]=__line__;
            return $entitiesListByTypeResponseArray;
        }
        if(count($entitiesListByType)>0){
            unset($tokensValidArray['user_id']);
            unset($tokensValidArray['usageToken']);
            $entitiesListByTypeResponseArray['status']=200;
            $entitiesListByTypeResponseArray['tokens']=$tokensValidArray;
            $entitiesListByTypeResponseArray['records']=count($entitiesListByType['data']);
            $entitiesListByTypeResponseArray['moreRecordsExist']=$entitiesListByType['hasMoreRecords'];
            $entitiesListByTypeResponseArray['inputs']=$entitiesListByType['inputs'];
            $entitiesListByTypeResponseArray['data']=$entitiesListByType['data'];
            return $entitiesListByTypeResponseArray;
        }
        $entitiesListByTypeResponseArray['status']=404;
        $entitiesListByTypeResponseArray['data']=null;
        $entitiesListByTypeResponseArray["{$entitiesListByTypeResponseArray['status']}HelperException"]=__line__;
        return $entitiesListByTypeResponseArray;
    }
    public static function getEntitiesInvocations(object $request)
    {
        $returnArray['status']=400;
        $inputs['json']=json_decode($request->getContent(), true);
        $inputs['header']['api-key']=$request->header("api-key");
        //$inputs['bearer']=$request->bearerToken();
        $inputs['uri']=$request->path();
        $tokensValidArray=dl::allCallsValidateTokens($request);
        if($tokensValidArray['status']!=200){
            unset($tokensValidArray['user_id']);
            $UserResponseArray['status']=$tokensValidArray['status'];
            $UserResponseArray['security']=$tokensValidArray;
            $UserResponseArray["{$UserResponseArray['status']}HelperException"]=__line__;
            return $UserResponseArray;
        }
        $invocations=dl::getInvocationsByUser($tokensValidArray['user_id']);
        if(is_null($invocations)){
            unset($tokensValidArray['user_id']);
            unset($tokensValidArray['usageToken']);
            $invocationsResponseArray['status']='404';
            $invocationsResponseArray['data']=null;
            $invocationsResponseArray['dataError']="No Data Matching Request";
            $invocationsResponseArray['security']=$tokensValidArray;
            $invocationsResponseArray["{$invocationsResponseArray['status']}HelperException"]=__line__;
            return $invocationsResponseArray;
        }
        if(count($invocations)>0){
            $invocationsResponseArray['status']=200;
            unset($tokensValidArray['user_id']);
            $invocationsResponseArray['tokens']=$tokensValidArray;
            $invocationsResponseArray['records']=count($invocations);
            $invocationsResponseArray['moreRecordsExist']=false;
            $invocationsResponseArray['data']=$invocations;
            return $invocationsResponseArray;
        }
        $invocationsResponseArray['status']=404;
        $invocationsResponseArray['data']=null;
        $invocationsResponseArray["{$invocationsResponseArray['status']}HelperException"]=__line__;
        return $invocationsResponseArray;
    }
    public static function getEntityRelationshipTypes(object $request)
    {
        $returnArray['status']=400;
        $inputs['json']=json_decode($request->getContent(), true);
        $inputs['header']['api-key']=$request->header("api-key");
        $inputs['bearer']=$request->bearerToken();
        $inputs['uri']=$request->path();
        $tokensValidArray=dl::allCallsValidateTokens($request);
        if($tokensValidArray['status']!=200){
            unset($tokensValidArray['user_id']);
            $UserResponseArray['status']=$tokensValidArray['status'];
            $UserResponseArray['security']=$tokensValidArray;
            $UserResponseArray["{$UserResponseArray['status']}HelperException"]=__line__;
            return $UserResponseArray;
        }
        $entityRelationshipTypes=dl::getEntityRelationshipTypes($tokensValidArray['usageToken'],$inputs['json']['crud_token']);
        if(is_null($entityRelationshipTypes)){
            unset($tokensValidArray['user_id']);
            $entityRelationshipTypesResponseArray['status']='404';
            $entityRelationshipTypesResponseArray['data']=null;
            $entityRelationshipTypesResponseArray['security']=$tokensValidArray;
            $entityRelationshipTypesResponseArray["{$entityRelationshipTypesResponseArray['status']}HelperException"]=__line__;
            return $entityRelationshipTypesResponseArray;
        }
        if(count($entityRelationshipTypes)>0){
            for($i=0;$i<count($entityRelationshipTypes);$i++){
                $modifiedRecord[$i]=dl::validateOutputFields($entityRelationshipTypes[$i],self::$outputEntityRelationshipTypes);
            }
            $entityRelationshipTypesResponseArray['status']=200;
            $entityRelationshipTypesResponseArray['tokens']=$tokensValidArray;
            $entityRelationshipTypesResponseArray['records']=count($modifiedRecord);
            $entityRelationshipTypesResponseArray['moreRecordsExist']=false;
            $entityRelationshipTypesResponseArray['data']=$modifiedRecord;
            return $entityRelationshipTypesResponseArray;
        }
        $entityRelationshipTypesResponseArray['status']=404;
        $entityRelationshipTypesResponseArray['data']=null;
        $entityRelationshipTypesResponseArray["{$entityRelationshipTypesResponseArray['status']}HelperException"]=__line__;
        return $entityRelationshipTypesResponseArray;
    }
    public static function getEntityTypes(object $request, string $invocationSlug) //k8s
    {
        $returnArray['status']=400;
        $inputs['header']['api-key']=$request->header("api-key");
        $tokensValidArray=dl::allCallsValidateTokens($request);
        if($tokensValidArray['status']!=200){
            unset($tokensValidArray['user_id']);
            $UserResponseArray['status']=$tokensValidArray['status'];
            $UserResponseArray['security']=$tokensValidArray;
            $UserResponseArray["{$UserResponseArray['status']}HelperException"]=__line__;
            return $UserResponseArray;
        }
        $entityTypes=dl::getEntityTypes($tokensValidArray['usageToken'],$invocationSlug);
        if(is_null($entityTypes)){
            $entityTypesResponseArray['status']='404';
            $entityTypesResponseArray['data']=null;
            unset($tokensValidArray['user_id']);
            $entityTypesResponseArray['security']=$tokensValidArray;
            $entityTypesResponseArray["{$entityTypesResponseArray['status']}HelperException"]=__line__;
            return $entityTypesResponseArray;
        }
        if(count($entityTypes)>0){
            $entityTypesResponseArray['status']=200;
            unset($tokensValidArray['user_id']);
            $entityTypesResponseArray['tokens']=$tokensValidArray;
            $entityTypesResponseArray['records']=count($entityTypes);
            $entityTypesResponseArray['moreRecordsExist']=false;
            $entityTypesResponseArray['data']=$entityTypes;
            return $entityTypesResponseArray;
        }
        $entityTypesResponseArray['status']=404;
        $entityTypesResponseArray['data']=null;
        $entityTypesResponseArray["{$entityTypesResponseArray['status']}HelperException"]=__line__;
        return $entityTypesResponseArray;
    }
    public static function postEntity($request,$invocationSlug)
    {
        $returnArray['status']=400;
        $inputs['json']=json_decode($request->getContent(), true);
        $validArray=dl::validateInputs(self::$postEntityArray,$inputs['json']);
        if($validArray['status']!==200){
            $entityResponseArray=$validArray;
            $entityResponseArray["{$entityResponseArray['status']}HelperException"]=__line__;
            return $entityResponseArray;
        }
        $tokensValidArray=dl::allCallsValidateTokens($request);
        if($tokensValidArray['status']!=200){
            $entityResponseArray['status']=$tokensValidArray['status'];
            $entityResponseArray['security']=$tokensValidArray;
            $entityResponseArray["{$entityResponseArray['status']}HelperException"]=__line__;
            return $entityResponseArray;
        }
        $entityPost=dl::postEntity($inputs['json'],$invocationSlug);
        if($entityPost['status']!=202){
            $returnArray['status']=$entityPost['status'];
            $returnArray['data']=$entityPost;
            $returnArray['security']=$tokensValidArray;
            return $returnArray;
        }
        $returnArray['status']=$entityPost['status'];
        $returnArray['tokens']=$tokensValidArray;
        $returnArray['records']=1;
        $returnArray['data']=$entityPost;
        $returnArray['moreRecordsExist']=false;
        return $returnArray;
    }
}