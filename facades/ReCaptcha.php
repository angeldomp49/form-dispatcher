<?php 
namespace Facades;

use ReCaptcha\ReCaptcha AS GoogleReCaptcha;

class ReCaptcha extends GoogleReCaptcha{
    public $whenSuccess;
    public $whenError;

    public static function default(){
        EnvLoader::load();

        return new self(getenv('RECAPTCHA_SECRET_KEY'));
    }

    public function check($gReCaptchaResponse, $remoteIp){
        $result = $this->verify($gReCaptchaResponse, $remoteIp);
        if($result){
            $success = $this->whenSuccess;
            return $success() ?? function(){};
        }
        else{
            $error = $this->whenError;
            return $error() ?? function(){};
        }
    }

    public function success( $action ){
        $this->whenSuccess = $action;
        return $this;
    }

    public function error( $action ){
        $this->whenError = $action;
        return $this;
    }
}