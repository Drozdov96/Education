<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit8c902abb71782ff3ddfbd7885af95ac3
{
    public static $files = array (
        '320cde22f66dd4f5d3fd621d3e88b98f' => __DIR__ . '/..' . '/symfony/polyfill-ctype/bootstrap.php',
    );

    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Symfony\\Polyfill\\Ctype\\' => 23,
            'Symfony\\Contracts\\' => 18,
            'Symfony\\Component\\VarExporter\\' => 30,
            'Symfony\\Component\\PropertyAccess\\' => 33,
            'Symfony\\Component\\Inflector\\' => 28,
            'Symfony\\Component\\ExpressionLanguage\\' => 37,
            'Symfony\\Component\\EventDispatcher\\' => 34,
            'Symfony\\Component\\Cache\\' => 24,
        ),
        'P' => 
        array (
            'Psr\\SimpleCache\\' => 16,
            'Psr\\Log\\' => 8,
            'Psr\\Cache\\' => 10,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Symfony\\Polyfill\\Ctype\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-ctype',
        ),
        'Symfony\\Contracts\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/contracts',
        ),
        'Symfony\\Component\\VarExporter\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/var-exporter',
        ),
        'Symfony\\Component\\PropertyAccess\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/property-access',
        ),
        'Symfony\\Component\\Inflector\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/inflector',
        ),
        'Symfony\\Component\\ExpressionLanguage\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/expression-language',
        ),
        'Symfony\\Component\\EventDispatcher\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/event-dispatcher',
        ),
        'Symfony\\Component\\Cache\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/cache',
        ),
        'Psr\\SimpleCache\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/simple-cache/src',
        ),
        'Psr\\Log\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/log/Psr/Log',
        ),
        'Psr\\Cache\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/cache/src',
        ),
    );

    public static $prefixesPsr0 = array (
        'S' => 
        array (
            'SM' => 
            array (
                0 => __DIR__ . '/..' . '/winzou/state-machine/src',
            ),
        ),
        'M' => 
        array (
            'Metabor\\' => 
            array (
                0 => __DIR__ . '/..' . '/metabor/statemachine/src',
            ),
            'MetaborStd\\' => 
            array (
                0 => __DIR__ . '/..' . '/metabor/metabor-std/src',
            ),
        ),
    );

    public static $classMap = array (
        'Application' => __DIR__ . '/../..' . '/Model/Application.php',
        'Cell' => __DIR__ . '/../..' . '/Model/Cell.php',
        'CellStateMachine' => __DIR__ . '/../..' . '/Model/CellStateMachine.php',
        'DatabaseHelper' => __DIR__ . '/../..' . '/Model/DatabaseHelper.php',
        'Field' => __DIR__ . '/../..' . '/Model/Field.php',
        'Game' => __DIR__ . '/../..' . '/Model/Game.php',
        'Helper' => __DIR__ . '/../..' . '/Model/Helper.php',
        'HtmlHelper' => __DIR__ . '/../..' . '/Model/HtmlHelper.php',
        'Player' => __DIR__ . '/../..' . '/Model/Player.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit8c902abb71782ff3ddfbd7885af95ac3::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit8c902abb71782ff3ddfbd7885af95ac3::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit8c902abb71782ff3ddfbd7885af95ac3::$prefixesPsr0;
            $loader->classMap = ComposerStaticInit8c902abb71782ff3ddfbd7885af95ac3::$classMap;

        }, null, ClassLoader::class);
    }
}
