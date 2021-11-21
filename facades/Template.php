<?php
namespace Facades;

class Template{

    private static $isTwigLoaded = false;
    private static $twigEnvironment = null;

    public static function render( $name, $data = [] ){
        EnvLoader::load();

        $templateDir = __DIR__ . '/..//' . getenv('TEMPLATE_DIR');
        $cacheDir = __DIR__ . '/..//' . getenv('CACHE_DIR');
        $twig = self::getTwig( $templateDir, $cacheDir );
        return $twig->render( $name, $data );
    }

    public static function loadTwig( $templateDir, $cacheDir ){
        $loader = new \Twig\Loader\FilesystemLoader($templateDir);
        self::$twigEnvironment = new \Twig\Environment($loader, [
            'cache' => $cacheDir,
            'auto_reload' => getenv('GLOBAL_DEBUG')
        ]);

        self::$isTwigLoaded = true;
    }

    public static function getTwig( $templateDir, $cacheDir ){
        if(!self::$isTwigLoaded){
          self::loadTwig( $templateDir, $cacheDir );  
        }

        return self::$twigEnvironment;
    }

}