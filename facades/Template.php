<?php
namespace Facades;

use \Exception;

class Template{

    private $content;

    public static function render( $filePath = "", $templateData = [] ){
        $template = new self($filePath, $templateData);
        return $template->getContent();
    }

    public function __construct( $filePath = "", $templateData = [] ){
        $this->checkFile($filePath);
        extract($templateData);

        ob_start();
        include( $filePath );
        $this->content = ob_get_contents();
        ob_end_clean();
    }

    public function getContent(){
        return $this->content;
    }

    public function checkFile($filePath){
        if(!file_exists($filePath)){
            throw new Exception("Error getting file template: " . $filePath);
        }
    }
}