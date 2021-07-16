<?php

/**
 * @OA\Get(
 *      path="/module/post/v1/comment",
 *      operationId="browseComment",
 *      tags={"comment"},
 *      summary="Browse Comment",
 *      description="Returns list of Comment",
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
 *      path="/module/post/v1/comment/post",
 *      operationId="readTagByPostSlug",
 *      tags={"comment"},
 *      summary="Get Comment based on post slug",
 *      description="Returns Comment based post slug",
 *      @OA\Parameter(
 *          name="slug",
 *          required=true,
 *          in="query",
 *          example="example-slug-post",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 *      @OA\Parameter(
 *          name="page",
 *          required=true,
 *          in="query",
 *          example="1",
 *          @OA\Schema(
 *              type="integer"
 *          )
 *      ),
 *      @OA\Parameter(
 *          name="per_page",
 *          required=false,
 *          in="query",
 *          example="10",
 *          @OA\Schema(
 *              type="integer"
 *          )
 *      ),
 *      @OA\Parameter(
 *          name="sort",
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
 *      @OA\Response(response=200, description="Successful operation"),
 *      @OA\Response(response=400, description="Bad request"),
 *      @OA\Response(response=401, description="Unauthorized"),
 *      @OA\Response(response=402, description="Payment Required"),
 * )
 */

/**
 * @OA\Get(
 *      path="/module/post/v1/comment/read",
 *      operationId="readTag",
 *      tags={"comment"},
 *      summary="Get Comment based on id",
 *      description="Returns Comment based on id",
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
 * @OA\Post(
 *      path="/module/post/v1/comment/add",
 *      operationId="addTag",
 *      tags={"comment"},
 *      summary="Insert new Comment",
 *      description="Insert new Comment into database",
 *      @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(
 *                     property="postId",
 *                     type="object",
 *                     example="1"
 *                 ),
 *                 @OA\Property(
 *                     property="parentId",
 *                     type="object",
 *                     example="1"
 *                 ),
 *                 @OA\Property(
 *                     property="content",
 *                     type="object",
 *                     example="Lorem ipsum dolor sit amet"
 *                 ),
 *             )
 *         )
 *      ),
 *      @OA\Response(response=200, description="Successful operation"),
 *      @OA\Response(response=400, description="Bad request"),
 *      @OA\Response(response=401, description="Unauthorized"),
 *      @OA\Response(response=402, description="Payment Required"),
 * )
 */

/**
 * @OA\Put(
 *      path="/module/post/v1/comment/edit",
 *      operationId="editTag",
 *      tags={"comment"},
 *      summary="Edit an existing Comment",
 *      description="Edit an existing Comment",
 *      @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(
 *                     property="id",
 *                     type="object",
 *                     example="1"
 *                 ),
 *                 @OA\Property(
 *                     property="postId",
 *                     type="object",
 *                     example="1"
 *                 ),
 *                 @OA\Property(
 *                     property="parentId",
 *                     type="object",
 *                     example="1"
 *                 ),
 *                 @OA\Property(
 *                     property="content",
 *                     type="object",
 *                     example="Lorem ipsum dolor sit amet Edit"
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
 *      path="/module/post/v1/comment/delete",
 *      operationId="deleteTag",
 *      tags={"comment"},
 *      summary="Delete one record of Comment",
 *      description="Delete one record of Comment",
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
 *      path="/module/post/v1/comment/delete-multiple",
 *      operationId="deleteMultipleTag",
 *      tags={"comment"},
 *      summary="Delete multiple record of Comment",
 *      description="Delete multiple record of Comment",
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
