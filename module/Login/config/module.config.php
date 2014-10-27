<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Login\Controller\Login' => 'Login\Controller\LoginController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'login' => array(
                'type'    => 'literal',
                'options' => array(
                    'route'    => '/login',
                    'defaults' => array(
                        'controller' => 'Login\Controller\Login',
                        'action'     => 'login',
                    ),
                ),
                'may_terminate' => true,
            ),
            'logout' => array(
                'type'    => 'literal',
                'options' => array(
                    'route'    => '/logout',
                    'defaults' => array(
                        'controller' => 'Login\Controller\Login',
                        'action'     => 'logout',
                    ),
                ),
                'may_terminate' => true,
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'logout' => __DIR__ . '/../view',
        ),
    ),
);
