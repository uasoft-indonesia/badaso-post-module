<?php

/**
 * @OA\Get(
 *      path="/module/post/v1/post",
 *      operationId="browsePost",
 *      tags={"post"},
 *      summary="Browse Post",
 *      description="Returns list of Post",
 *      @OA\Parameter(
 *          name="order_field",
 *          required=false,
 *          example="updated_at",
 *          in="query",
 *          @OA\Schema(
 *              type="string"
 *          ),
 *          style="form"
 *      ),
 *      @OA\Parameter(
 *          name="order_direction",
 *          required=false,
 *          in="query",
 *          @OA\Schema(
 *              type="array",
 *              @OA\Items(
 *                   type="string",
 *                   enum={"asc", "desc"},
 *                   default="asc",
 *              )
 *          )
 *      ),
 *      @OA\Parameter(
 *          name="category",
 *          required=false,
 *          example="example-category",
 *          in="query",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 *      @OA\Parameter(
 *          name="tag",
 *          required=false,
 *          example="example-tag",
 *          in="query",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 *      @OA\Parameter(
 *          name="page",
 *          required=true,
 *          example="1",
 *          in="query",
 *          @OA\Schema(
 *              type="integer"
 *          )
 *      ),
 *      @OA\Parameter(
 *          name="limit",
 *          required=true,
 *          example="10",
 *          in="query",
 *          @OA\Schema(
 *              type="integer"
 *          )
 *      ),
 *      @OA\Parameter(
 *          name="search",
 *          required=false,
 *          example="lorem ipsum",
 *          in="query",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 *      @OA\Response(response=200, description="Successful operation"),
 *      @OA\Response(response=400, description="Bad request"),
 *      @OA\Response(response=401, description="Unauthorized"),
 *      @OA\Response(response=402, description="Payment Required"),
 * )
 */

/**
 * @OA\Get(
 *      path="/module/post/v1/post/browse-analytics",
 *      operationId="browseAnalytics",
 *      tags={"post"},
 *      summary="Browse Post with Analytics Parameter",
 *      description="Returns list of Post with total view count",
 *      @OA\Parameter(
 *          name="order_field",
 *          required=false,
 *          example="updated_at",
 *          in="query",
 *          @OA\Schema(
 *              type="string"
 *          ),
 *          style="form"
 *      ),
 *      @OA\Parameter(
 *          name="order_direction",
 *          required=false,
 *          in="query",
 *          @OA\Schema(
 *              type="array",
 *              @OA\Items(
 *                   type="string",
 *                   enum={"asc", "desc"},
 *                   default="asc",
 *              )
 *          )
 *      ),
 *      @OA\Parameter(
 *          name="category",
 *          required=false,
 *          example="example-category",
 *          in="query",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 *      @OA\Parameter(
 *          name="tag",
 *          required=false,
 *          example="example-tag",
 *          in="query",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 *      @OA\Parameter(
 *          name="page",
 *          required=true,
 *          example="1",
 *          in="query",
 *          @OA\Schema(
 *              type="integer"
 *          )
 *      ),
 *      @OA\Parameter(
 *          name="limit",
 *          required=true,
 *          example="10",
 *          in="query",
 *          @OA\Schema(
 *              type="integer"
 *          )
 *      ),
 *      @OA\Parameter(
 *          name="search",
 *          required=false,
 *          example="lorem ipsum",
 *          in="query",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 *      @OA\Response(response=200, description="Successful operation"),
 *      @OA\Response(response=400, description="Bad request"),
 *      @OA\Response(response=401, description="Unauthorized"),
 *      @OA\Response(response=402, description="Payment Required"),
 *      security={
 *          {"bearerAuth": {}}
 *      }
 * )
 */

/**
 * @OA\Get(
 *      path="/module/post/v1/post/popular",
 *      operationId="browsePopular",
 *      tags={"post"},
 *      summary="Browse Popular Post",
 *      description="Returns list of Popular Post",
 *      @OA\Parameter(
 *          name="page",
 *          required=true,
 *          example="1",
 *          in="query",
 *          @OA\Schema(
 *              type="integer"
 *          )
 *      ),
 *      @OA\Parameter(
 *          name="limit",
 *          required=true,
 *          example="10",
 *          in="query",
 *          @OA\Schema(
 *              type="integer"
 *          )
 *      ),
 *      @OA\Response(response=200, description="Successful operation"),
 *      @OA\Response(response=400, description="Bad request"),
 *      @OA\Response(response=401, description="Unauthorized"),
 *      @OA\Response(response=402, description="Payment Required"),
 * )
 */

/**
 * @OA\Get(
 *      path="/module/post/v1/post/read",
 *      operationId="readPost",
 *      tags={"post"},
 *      summary="Get Post based on id",
 *      description="Returns Post based on id",
 *      @OA\Parameter(
 *          name="id",
 *          required=true,
 *          in="query",
 *          @OA\Schema(
 *              type="integer"
 *          )
 *      ),
 *      @OA\Response(response=200, description="Successful operation"),
 *      @OA\Response(response=400, description="Bad request"),
 *      @OA\Response(response=401, description="Unauthorized"),
 *      @OA\Response(response=402, description="Payment Required"),
 *      security={
 *          {"bearerAuth": {}}
 *      }
 * )
 */

/**
 * @OA\Get(
 *      path="/module/post/v1/post/read-slug",
 *      operationId="readPostBySlug",
 *      tags={"post"},
 *      summary="Get Post based on slug",
 *      description="Returns Post based on slug",
 *      @OA\Parameter(
 *          name="slug",
 *          required=true,
 *          in="query",
 *          example="post-example",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 *      @OA\Response(response=200, description="Successful operation"),
 *      @OA\Response(response=400, description="Bad request"),
 *      @OA\Response(response=401, description="Unauthorized"),
 *      @OA\Response(response=402, description="Payment Required"),
 * )
 */

/**
 * @OA\Post(
 *      path="/module/post/v1/post/add",
 *      operationId="addPost",
 *      tags={"post"},
 *      summary="Insert new Post",
 *      description="Insert new Post into database",
 *      @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(
 *                     property="title",
 *                     type="string",
 *                     example="Example Title"
 *                 ),
 *                 @OA\Property(
 *                     property="slug",
 *                     type="string",
 *                     example="example-title"
 *                 ),
 *                 @OA\Property(
 *                     property="content",
 *                     type="string",
 *                     example="Example content"
 *                 ),
 *                 @OA\Property(
 *                     property="metaTitle",
 *                     type="string",
 *                     example="example title"
 *                 ),
 *                 @OA\Property(
 *                     property="metaDescription",
 *                     type="string",
 *                     example="example description"
 *                 ),
 *                 @OA\Property(
 *                     property="summary",
 *                     type="string",
 *                     example="Example summary"
 *                 ),
 *                 @OA\Property(
 *                     property="published",
 *                     type="boolean",
 *                     example="true"
 *                 ),
 *                 @OA\Property(
 *                     property="tags",
 *                     type="array",
 *                     @OA\Items(
 *                         type="string",
 *                         example="1"
 *                     ),
 *                 ),
 *                 @OA\Property(
 *                     property="category",
 *                     type="string",
 *                     example="1"
 *                 ),
 *                 @OA\Property(
 *                     property="thumbnail",
 *                     type="string",
 *                     example="files/shares/logo.png"
 *                 ),
 *             )
 *         )
 *      ),
 *      @OA\Response(response=200, description="Successful operation"),
 *      @OA\Response(response=400, description="Bad request"),
 *      @OA\Response(response=401, description="Unauthorized"),
 *      @OA\Response(response=402, description="Payment Required"),
 *      security={
 *          {"bearerAuth": {}}
 *      }
 * )
 */

/**
 * @OA\Put(
 *      path="/module/post/v1/post/edit",
 *      operationId="editPost",
 *      tags={"post"},
 *      summary="Edit an existing Post",
 *      description="Edit an existing Post",
 *      @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(
 *                     property="id",
 *                     type="string",
 *                     example="1"
 *                 ),
 *                 @OA\Property(
 *                     property="title",
 *                     type="string",
 *                     example="Example Title"
 *                 ),
 *                 @OA\Property(
 *                     property="slug",
 *                     type="string",
 *                     example="example-title"
 *                 ),
 *                 @OA\Property(
 *                     property="content",
 *                     type="string",
 *                     example="Example content"
 *                 ),
 *                 @OA\Property(
 *                     property="metaTitle",
 *                     type="string",
 *                     example="example title"
 *                 ),
 *                 @OA\Property(
 *                     property="metaDescription",
 *                     type="string",
 *                     example="example description"
 *                 ),
 *                 @OA\Property(
 *                     property="summary",
 *                     type="string",
 *                     example="Example summary"
 *                 ),
 *                 @OA\Property(
 *                     property="published",
 *                     type="boolean",
 *                     example="true"
 *                 ),
 *                 @OA\Property(
 *                     property="tags",
 *                     type="array",
 *                     @OA\Items(
 *                         type="string",
 *                         example="1"
 *                     ),
 *                 ),
 *                 @OA\Property(
 *                     property="category",
 *                     type="string",
 *                     example="1"
 *                 ),
 *                 @OA\Property(
 *                     property="thumbnail",
 *                     type="string",
 *                     example="files/shares/logo.png"
 *                 ),
 *             )
 *         )
 *      ),
 *      @OA\Response(response=200, description="Successful operation"),
 *      @OA\Response(response=400, description="Bad request"),
 *      @OA\Response(response=401, description="Unauthorized"),
 *      @OA\Response(response=402, description="Payment Required"),
 *      security={
 *          {"bearerAuth": {}}
 *      }
 * )
 */

/**
 * @OA\Delete(
 *      path="/module/post/v1/post/delete",
 *      operationId="deletePost",
 *      tags={"post"},
 *      summary="Delete one record of Post",
 *      description="Delete one record of Post",
 *      @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(
 *                     property="id",
 *                     type="object",
 *                     example="1"
 *                 ),
 *             )
 *         )
 *     ),
 *      @OA\Response(response=200, description="Successful operation"),
 *      @OA\Response(response=400, description="Bad request"),
 *      @OA\Response(response=401, description="Unauthorized"),
 *      @OA\Response(response=402, description="Payment Required"),
 *      security={
 *          {"bearerAuth": {}}
 *      }
 * )
 */

/**
 * @OA\Delete(
 *      path="/module/post/v1/post/delete-multiple",
 *      operationId="deleteMultiplePost",
 *      tags={"post"},
 *      summary="Delete multiple record of Post",
 *      description="Delete multiple record of Post",
 *      @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(
 *                     property="ids",
 *                     type="object",
 *                     example="1,2,3,..."
 *                 ),
 *             )
 *         )
 *     ),
 *      @OA\Response(response=200, description="Successful operation"),
 *      @OA\Response(response=400, description="Bad request"),
 *      @OA\Response(response=401, description="Unauthorized"),
 *      @OA\Response(response=402, description="Payment Required"),
 *      security={
 *          {"bearerAuth": {}}
 *      }
 * )
 */
