<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'language' => 'es-Es',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],

    'modules' => [
        'user-management' => [
            'class' => 'webvimark\modules\UserManagement\UserManagementModule',
            'on beforeAction' => function (yii\base\ActionEvent $event) {
                if ($event->action->uniqueId === 'user-management/auth/login') {
                    $event->action->controller->layout = 'loginLayout.php';
                }
            },
        ],
    ],

    'components' => [
        'request' => [
            'cookieValidationKey' => 'dob7AbiErrCwwkEyY3EBHoAvleVm1TEq',
            'enableCsrfValidation' => false,
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ],

        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],

        'user' => [
            'class' => 'webvimark\modules\UserManagement\components\UserConfig',
            'on afterLogin' => function ($event) {
                \webvimark\modules\UserManagement\models\UserVisitLog::newVisitor($event->identity->id);
            },
        ],

        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            // send all mails to a file by default.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        // Habilitar URL Manager con rutas amigables
        'urlManager' => [
            'enablePrettyUrl' => true,  // Activar URLs amigables
            'showScriptName' => false,  // Eliminar 'index.php' de las URLs
            'rules' => [

                ['class' => 'yii\web\UrlRule', 'pattern' => 'permisos/user/<text:.*>', 'route' => 'permiso/user'],
                [
                    'class'      => 'yii\rest\UrlRule',
                    'controller' => 'permiso',
                    'tokens' => [
                        '{id}'  => '<id:\\d[\\d,]*>',
                        '{rol}' => '<rol:\\w+>'
                    ],
                    'extraPatterns' => [
                        'GET lista-permisos/{rol}' => 'lista-permisos/{rol}'
                    ],
                ],

                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'user',
                    'extraPatterns' => [
                        'POST login' => 'login',
                        'POST registrar' => 'registrar'
                    ],
                ],
                // ['class' => 'yii\rest\UrlRule', 'controller' => 'auth-assignment'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'dias'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'asistencias'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'departamentos'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'empleados'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'estados'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'horarios'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'incidencias'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'notificaciones'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'permisos'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'privilegios'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'roles'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'rol-privilegio', 'pluralize' => false],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'solicitudes'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'tipos'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'turnos'],

                ['class' => 'yii\web\UrlRule', 'pattern' => 'dias/buscar/<text:.*>', 'route' => 'dias/buscar'],
                ['class' => 'yii\web\UrlRule', 'pattern' => 'dias/total/<text:.*>', 'route' => 'dias/total'],
                [
                    'class'      => 'yii\rest\UrlRule',
                    'controller' => 'dias',
                    'tokens' => [
                        '{id}'   => '<id:\\d[\\d,]*>',
                        '{text}' => '<text:\\w+>'
                    ],
                    'extraPatterns' => [
                        'GET buscar/{text}' => 'buscar',
                        'GET total'         => 'total'
                    ],
                ],

                ['class' => 'yii\web\UrlRule', 'pattern' => 'asistencias/buscar/<text:.*>', 'route' => 'asistencias/buscar'],
                ['class' => 'yii\web\UrlRule', 'pattern' => 'asistencias/total/<text:.*>', 'route' => 'asistencias/total'],
                [
                    'class'      => 'yii\rest\UrlRule',
                    'controller' => 'asistencias',
                    'tokens' => [
                        '{id}'   => '<id:\\d[\\d,]*>',
                        '{text}' => '<text:\\w+>'
                    ],
                    'extraPatterns' => [
                        'GET total'         => 'total',
                        'GET buscar/{text}' => 'buscar'
                    ],
                ],

                ['class' => 'yii\web\UrlRule', 'pattern' => 'departamentos/buscar/<text:.*>', 'route' => 'departamentos/buscar'],
                ['class' => 'yii\web\UrlRule', 'pattern' => 'departamentos/total/<text:.*>', 'route' => 'departamentos/total'],
                [
                    'class'      => 'yii\rest\UrlRule',
                    'controller' => 'departamentos',
                    'tokens' => [
                        '{id}'   => '<id:\\d[\\d,]*>',
                        '{text}' => '<text:\\w+>'
                    ],
                    'extraPatterns' => [
                        'GET total'         => 'total',
                        'GET buscar/{text}' => 'buscar'
                    ],
                ],

                ['class' => 'yii\web\UrlRule', 'pattern' => 'empleados/buscar/<text:.*>', 'route' => 'empleados/buscar'],
                ['class' => 'yii\web\UrlRule', 'pattern' => 'empleados/total/<text:.*>', 'route' => 'empleados/total'],
                [
                    'class'      => 'yii\rest\UrlRule',
                    'controller' => 'empleados',
                    'tokens' => [
                        '{id}'   => '<id:\\d[\\d,]*>',
                        '{text}' => '<text:\\w+>'
                    ],
                    'extraPatterns' => [
                        'GET total'         => 'total',
                        'GET buscar/{text}' => 'buscar'
                    ],
                ],

                ['class' => 'yii\web\UrlRule', 'pattern' => 'estados/buscar/<text:.*>', 'route' => 'estados/buscar'],
                ['class' => 'yii\web\UrlRule', 'pattern' => 'estados/total/<text:.*>', 'route' => 'estados/total'],
                [
                    'class'      => 'yii\rest\UrlRule',
                    'controller' => 'estados',
                    'tokens' => [
                        '{id}'   => '<id:\\d[\\d,]*>',
                        '{text}' => '<text:\\w+>'
                    ],
                    'extraPatterns' => [
                        'GET total'         => 'total',
                        'GET buscar/{text}' => 'buscar'
                    ],
                ],

                ['class' => 'yii\web\UrlRule', 'pattern' => 'horarios/buscar/<text:.*>', 'route' => 'horarios/buscar'],
                ['class' => 'yii\web\UrlRule', 'pattern' => 'horarios/total/<text:.*>', 'route' => 'horarios/total'],
                [
                    'class'      => 'yii\rest\UrlRule',
                    'controller' => 'horarios',
                    'tokens' => [
                        '{id}'   => '<id:\\d[\\d,]*>',
                        '{text}' => '<text:\\w+>'
                    ],
                    'extraPatterns' => [
                        'GET total'         => 'total',
                        'GET buscar/{text}' => 'buscar'
                    ],
                ],
                ['class' => 'yii\web\UrlRule', 'pattern' => 'incidencias/buscar/<text:.*>', 'route' => 'incidencias/buscar'],
                ['class' => 'yii\web\UrlRule', 'pattern' => 'incidencias/total/<text:.*>', 'route' => 'incidencias/total'],
                [
                    'class'      => 'yii\rest\UrlRule',
                    'controller' => 'incidencias',
                    'tokens' => [
                        '{id}'   => '<id:\\d[\\d,]*>',
                        '{text}' => '<text:\\w+>'
                    ],
                    'extraPatterns' => [
                        'GET total'         => 'total',
                        'GET buscar/{text}' => 'buscar'
                    ],
                ],

                ['class' => 'yii\web\UrlRule', 'pattern' => 'notificaciones/buscar/<text:.*>', 'route' => 'notificaciones/buscar'],
                ['class' => 'yii\web\UrlRule', 'pattern' => 'notificaciones/total/<text:.*>', 'route' => 'notificaciones/total'],
                [
                    'class'      => 'yii\rest\UrlRule',
                    'controller' => 'notificaciones',
                    'tokens' => [
                        '{id}'   => '<id:\\d[\\d,]*>',
                        '{text}' => '<text:\\w+>'
                    ],
                    'extraPatterns' => [
                        'GET total'         => 'total',
                        'GET buscar/{text}' => 'buscar'
                    ],
                ],

                ['class' => 'yii\web\UrlRule', 'pattern' => 'permisos/buscar/<text:.*>', 'route' => 'permisos/buscar'],
                ['class' => 'yii\web\UrlRule', 'pattern' => 'permisos/total/<text:.*>', 'route' => 'permisos/total'],
                [
                    'class'      => 'yii\rest\UrlRule',
                    'controller' => 'permisos',
                    'tokens' => [
                        '{id}'   => '<id:\\d[\\d,]*>',
                        '{text}' => '<text:\\w+>'
                    ],
                    'extraPatterns' => [
                        'GET total'         => 'total',
                        'GET buscar/{text}' => 'buscar'
                    ],
                ],

                ['class' => 'yii\web\UrlRule', 'pattern' => 'privilegios/buscar/<text:.*>', 'route' => 'privilegios/buscar'],
                ['class' => 'yii\web\UrlRule', 'pattern' => 'privilegios/total/<text:.*>', 'route' => 'privilegios/total'],
                [
                    'class'      => 'yii\rest\UrlRule',
                    'controller' => 'privilegios',
                    'tokens' => [
                        '{id}'   => '<id:\\d[\\d,]*>',
                        '{text}' => '<text:\\w+>'
                    ],
                    'extraPatterns' => [
                        'GET total'         => 'total',
                        'GET buscar/{text}' => 'buscar'
                    ],
                ],

                ['class' => 'yii\web\UrlRule', 'pattern' => 'roles/buscar/<text:.*>', 'route' => 'roles/buscar'],
                ['class' => 'yii\web\UrlRule', 'pattern' => 'roles/total/<text:.*>', 'route' => 'roles/total'],
                [
                    'class'      => 'yii\rest\UrlRule',
                    'controller' => 'roles',
                    'tokens' => [
                        '{id}'   => '<id:\\d[\\d,]*>',
                        '{text}' => '<text:\\w+>'
                    ],
                    'extraPatterns' => [
                        'GET total'         => 'total',
                        'GET buscar/{text}' => 'buscar'
                    ],
                ],

                ['class' => 'yii\web\UrlRule', 'pattern' => 'rol-privilegio/buscar/<text:.*>', 'route' => 'rol-privilegio/buscar'],
                ['class' => 'yii\web\UrlRule', 'pattern' => 'rol-privilegio/total/<text:.*>', 'route' => 'rol-privilegio/total'],
                [
                    'class'      => 'yii\rest\UrlRule',
                    'controller' => 'rol-privilegio',
                    'tokens' => [
                        '{id}'   => '<id:\\d[\\d,]*>',
                        '{text}' => '<text:\\w+>'
                    ],
                    'extraPatterns' => [
                        'GET total'         => 'total',
                        'GET buscar/{text}' => 'buscar'
                    ],
                ],

                ['class' => 'yii\web\UrlRule', 'pattern' => 'solicitudes/buscar/<text:.*>', 'route' => 'solicitudes/buscar'],
                ['class' => 'yii\web\UrlRule', 'pattern' => 'solicitudes/total/<text:.*>', 'route' => 'solicitudes/total'],
                [
                    'class'      => 'yii\rest\UrlRule',
                    'controller' => 'solicitudes',
                    'tokens' => [
                        '{id}'   => '<id:\\d[\\d,]*>',
                        '{text}' => '<text:\\w+>'
                    ],
                    'extraPatterns' => [
                        'GET total'         => 'total',
                        'GET buscar/{text}' => 'buscar'
                    ],
                ],

                ['class' => 'yii\web\UrlRule', 'pattern' => 'tipos/buscar/<text:.*>', 'route' => 'tipos/buscar'],
                ['class' => 'yii\web\UrlRule', 'pattern' => 'tipos/total/<text:.*>', 'route' => 'tipos/total'],
                [
                    'class'      => 'yii\rest\UrlRule',
                    'controller' => 'tipos',
                    'tokens' => [
                        '{id}'   => '<id:\\d[\\d,]*>',
                        '{text}' => '<text:\\w+>'
                    ],
                    'extraPatterns' => [
                        'GET total'         => 'total',
                        'GET buscar/{text}' => 'buscar'
                    ],
                ],

                ['class' => 'yii\web\UrlRule', 'pattern' => 'turnos/buscar/<text:.*>', 'route' => 'turnos/buscar'],
                ['class' => 'yii\web\UrlRule', 'pattern' => 'turnos/total/<text:.*>', 'route' => 'turnos/total'],
                [
                    'class'      => 'yii\rest\UrlRule',
                    'controller' => 'turnos',
                    'tokens' => [
                        '{id}'   => '<id:\\d[\\d,]*>',
                        '{text}' => '<text:\\w+>'
                    ],
                    'extraPatterns' => [
                        'GET total'         => 'total',
                        'GET buscar/{text}' => 'buscar'
                    ],
                ],

            ],
        ],
    ],
    'params' => $params,
];

if (defined('YII_ENV') && YII_ENV !== 'prod') {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
