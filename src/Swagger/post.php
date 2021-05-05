<?php

/**
 * @OA\Get(
 *      path="/module/blog/v1/post",
 *      operationId="browsePost",
 *      tags={"post"},
 *      summary="Browse Post",
 *      description="Returns list of Post",
 *      @OA\Parameter(
 *          name="sortby",
 *          required=false,
 *          example="updated_at",
 *          in="query",
 *          @OA\Schema(
 *              type="string"
 *          ),
 *          style="form"
 *      ),
 *      @OA\Parameter(
 *          name="sorttype",
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
 *      @OA\Response(response=200, description="Successful operation"),
 *      @OA\Response(response=400, description="Bad request"),
 *      @OA\Response(response=401, description="Unauthorized"),
 *      @OA\Response(response=402, description="Payment Required"),
 * )
 */

/**
 * @OA\Get(
 *      path="/module/blog/v1/post/read",
 *      operationId="readPost",
 *      tags={"post"},
 *      summary="Get Post based on id",
 *      description="Returns Post based on id",
 *      @OA\Parameter(
 *          name="id",
 *          required=true,
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
 *      path="/module/blog/v1/post/read-slug",
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
 *      path="/module/blog/v1/post/add",
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
 *                         example="4568ae72-a8c8-4a51-8d93-5e5638e75747"
 *                     ),
 *                 ),
 *                 @OA\Property(
 *                     property="category",
 *                     type="string",
 *                     example="40781427-6a29-4571-847e-076d05839db2"
 *                 ),
 *                 @OA\Property(
 *                     property="commentCount",
 *                     type="number",
 *                     example="0"
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
 *      path="/module/blog/v1/post/edit",
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
 *                     example="b601cfbe-9ce7-4257-bc6f-c1b8a7323873"
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
 *                         example="4568ae72-a8c8-4a51-8d93-5e5638e75747"
 *                     ),
 *                 ),
 *                 @OA\Property(
 *                     property="category",
 *                     type="string",
 *                     example="40781427-6a29-4571-847e-076d05839db2"
 *                 ),
 *                 @OA\Property(
 *                     property="commentCount",
 *                     type="number",
 *                     example="0"
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
 *      path="/module/blog/v1/post/delete",
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
 *                     example="b601cfbe-9ce7-4257-bc6f-c1b8a7323873"
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
 *      path="/module/blog/v1/post/delete-multiple",
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
 *                     example="5733880e-c272-4608-b3bb-36efab1237ec,3a03f833-3e8e-4c16-b215-a0cf4957a016,..."
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
