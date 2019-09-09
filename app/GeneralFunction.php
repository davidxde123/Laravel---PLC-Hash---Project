<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

 class GeneralFunction extends Model
 {
     


     public static function generalErrors($status,$action,$code,$message, $no_required = null){

        $data = array();

        if(!is_null($no_required)){
            $data["details"] = $no_required;
        }

        $data["code"] = $code;
        $data["status"] = $status;

        if($status == "success")         
            $data["Message"] = $message." ".$action." correctamente";
        else
            $data["Message"] =  $action." ".$message." No se ha podido realizar";

       

        return $data;      
          
    }

 } 



?>