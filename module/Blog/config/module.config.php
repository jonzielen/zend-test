<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Blog\Controller\Blog' => 'Blog\Controller\BlogController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'blog' => array(
                'type'    => 'literal',
                'options' => array(
                    'route'    => '/blog',
                    'defaults' => array(
                        'controller' => 'Blog\Controller\Blog',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'tags' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/tags/[:slug]',
                            'constraints' => array(
                                'slug' => '[a-zA-Z0-9_-]+',
                            ),
                            'defaults' => array(
                                'controller' => 'Blog\Controller\Blog',
                                'action' => 'tags',
                            )
                        )
                    ),
                    'post' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/[:slug]',
                            'constraints' => array(
                                'slug' => '[a-zA-Z0-9_-]+',
                            ),
                            'defaults' => array(
                                'action' => 'post',
                            )
                        )
                    ),
                ),
            ),

        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'blog' => __DIR__ . '/../view',
        ),
    ),
);
