<?php

return [

    /**
     * To extend the base Comment model one just needs to create a new
     * CustomComment model extending the Comment model shipped with the
     * package and change this configuration option to their extended model.
     */
    'model' => \Doloan09\Comments\Likes::class,

    /**
     * You can customize the behaviour of these permissions by
     * creating your own and pointing to it here.
     */
    'permissions' => [
        'create-like' => 'Doloan09\Comments\LikePolicy@create',
        'delete-like' => 'Doloan09\Comments\LikePolicy@delete',
    ],

    /**
     * The Comment Controller.
     * Change this to your own implementation of the CommentController.
     * You can use the \Doloan09\Comments\CommentControllerInterface
     * or extend the \Doloan09\Comments\CommentController.
     */
    'controller' => '\Doloan09\Comments\LikeController',

    /**
     * Disable/enable the package routes.
     * If you want to completely take over the way this package handles
     * routes and controller logic, set this to false and provide your
     * own routes and controller for comments.
     */
    'routes' => true,

    /**
     * Set this option to `true` to enable soft deleting of comments.
     *
     * Comments will be soft deleted using laravels "softDeletes" trait.
     */
    'soft_deletes' => false,

    /**
     * Enable/disable the package provider to load migrations.
     * This option might be useful if you use multiple database connections.
     */
    'load_migrations' => true,

];
