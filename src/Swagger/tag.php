<?php

/**
 * @OA\Get(
 *      path="/module/post/v1/tag",
 *      operationId="browseTag",
 *      tags={"tag"},
 *      summary="Browse Tag",
 *      description="Returns list of Tag",
 *      @OA\Response(response=200, description="Successful operation"),
 *      @OA\Response(response=400, description="Bad request"),
 *      @OA\Response(response=401, description="Unauthorized"),
 *      @OA\Response(response=402, description="Payment Required"),
 * )
 */

/**
 * @OA\Get(
 *      path="/module/post/v1/tag/read",
 *      operationId="readTag",
 *      tags={"tag"},
 *      summary="Get Tag based on id",
 *      description="Returns Tag based on id",
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
 *      path="/module/post/v1/tag/read-slug",
 *      operationId="readTagBySlug",
 *      tags={"tag"},
 *      summary="Get Tag based on slug",
 *      description="Returns Tag based on slug",
 *      @OA\Parameter(
 *          name="slug",
 *          required=true,
 *          in="query",
 *          example="tag-example",
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
 *      path="/module/post/v1/tag/add",
 *      operationId="addTag",
 *      tags={"tag"},
 *      summary="Insert new Tag",
 *      description="Insert new Tag into database",
 *      @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(
 *                     property="title",
 *                     type="object",
 *                     example="example"
 *                 ),
 *                 @OA\Property(
 *                     property="metaTitle",
 *                     type="object",
 *                     example="example"
 *                 ),
 *                 @OA\Property(
 *                     property="slug",
 *                     type="object",
 *                     example="example-tag"
 *                 ),
 *                 @OA\Property(
 *                     property="content",
 *                     type="object",
 *                     example="An example of create new tag."
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
 *      path="/module/post/v1/tag/edit",
 *      operationId="editTag",
 *      tags={"tag"},
 *      summary="Edit an existing Tag",
 *      description="Edit an existing Tag",
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
 *                     property="title",
 *                     type="object",
 *                     example="example"
 *                 ),
 *                 @OA\Property(
 *                     property="metaTitle",
 *                     type="object",
 *                     example="example"
 *                 ),
 *                 @OA\Property(
 *                     property="slug",
 *                     type="object",
 *                     example="example-tag"
 *                 ),
 *                 @OA\Property(
 *                     property="content",
 *                     type="object",
 *                     example="An example of create new tag."
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
 *      path="/module/post/v1/tag/delete",
 *      operationId="deleteTag",
 *      tags={"tag"},
 *      summary="Delete one record of Tag",
 *      description="Delete one record of Tag",
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
 *      path="/module/post/v1/tag/delete-multiple",
 *      operationId="deleteMultipleTag",
 *      tags={"tag"},
 *      summary="Delete multiple record of Tag",
 *      description="Delete multiple record of Tag",
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
