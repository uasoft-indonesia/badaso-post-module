<?php

/**
  * @OA\Get(
  *      path="/module/blog/v1/category",
  *      operationId="browseCategory",
  *      tags={"category"},
  *      summary="Browse Category",
  *      description="Returns list of Category",
  *      @OA\Response(response=200, description="Successful operation"),
  *      @OA\Response(response=400, description="Bad request"),
  *      @OA\Response(response=401, description="Unauthorized"),
  *      @OA\Response(response=402, description="Payment Required"),
  * )
  *
  */

/**
  * @OA\Get(
  *      path="/module/blog/v1/category/read",
  *      operationId="readCategory",
  *      tags={"category"},
  *      summary="Get Category based on id",
  *      description="Returns Category based on id",
  *      @OA\Parameter(
  *          name="id",
  *          required=true,
  *          in="query",
  *          @OA\Schema(
  *              type="string"
  *          )
  *      ),
  *      @OA\Parameter(
  *          name="except",
  *          required=false,
  *          in="query",
  *          description="Get all categories except category on the parameter.",
  *          @OA\Schema(
  *              type="boolean"
  *          )
  *      ),
  *      @OA\Response(response=200, description="Successful operation"),
  *      @OA\Response(response=400, description="Bad request"),
  *      @OA\Response(response=401, description="Unauthorized"),
  *      @OA\Response(response=402, description="Payment Required"),
  * )
  *
  */

/**
  * @OA\Get(
  *      path="/module/blog/v1/category/read-slug",
  *      operationId="readCategoryBySlug",
  *      tags={"category"},
  *      summary="Get Category based on slug",
  *      description="Returns Category based on slug",
  *      @OA\Parameter(
  *          name="slug",
  *          required=true,
  *          in="query",
  *          example="category-example",
  *          @OA\Schema(
  *              type="string"
  *          )
  *      ),
  *      @OA\Parameter(
  *          name="except",
  *          required=false,
  *          in="query",
  *          description="Get all categories except category on the parameter.",
  *          @OA\Schema(
  *              type="boolean"
  *          )
  *      ),
  *      @OA\Response(response=200, description="Successful operation"),
  *      @OA\Response(response=400, description="Bad request"),
  *      @OA\Response(response=401, description="Unauthorized"),
  *      @OA\Response(response=402, description="Payment Required"),
  * )
  *
  */

/**
  * @OA\Post(
  *      path="/module/blog/v1/category/add",
  *      operationId="addCategory",
  *      tags={"category"},
  *      summary="Insert new Category",
  *      description="Insert new Category into database",
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
  *                     property="parentId",
  *                     type="object",
  *                     example="baccbc08-cd44-468c-9f91-e428615bd7d9"
  *                 ),
  *                 @OA\Property(
  *                     property="metaTitle",
  *                     type="object",
  *                     example="example"
  *                 ),
  *                 @OA\Property(
  *                     property="slug",
  *                     type="object",
  *                     example="example-category"
  *                 ),
  *                 @OA\Property(
  *                     property="content",
  *                     type="object",
  *                     example="An example of create new category."
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
  *
  */

/**
  * @OA\Put(
  *      path="/module/blog/v1/category/edit",
  *      operationId="editCategory",
  *      tags={"category"},
  *      summary="Edit an existing Category",
  *      description="Edit an existing Category",
  *      @OA\RequestBody(
  *         @OA\MediaType(
  *             mediaType="application/json",
  *             @OA\Schema(
  *                 @OA\Property(
  *                     property="id",
  *                     type="object",
  *                     example="79b6e6ed-b54d-430e-9f2e-761b89033aad"
  *                 ),
  *                 @OA\Property(
  *                     property="title",
  *                     type="object",
  *                     example="example"
  *                 ),
  *                 @OA\Property(
  *                     property="parentId",
  *                     type="object",
  *                     example="baccbc08-cd44-468c-9f91-e428615bd7d9"
  *                 ),
  *                 @OA\Property(
  *                     property="metaTitle",
  *                     type="object",
  *                     example="example"
  *                 ),
  *                 @OA\Property(
  *                     property="slug",
  *                     type="object",
  *                     example="example-category"
  *                 ),
  *                 @OA\Property(
  *                     property="content",
  *                     type="object",
  *                     example="An example of create new category."
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
  *
  */

/**
  * @OA\Delete(
  *      path="/module/blog/v1/category/delete",
  *      operationId="deleteCategory",
  *      tags={"category"},
  *      summary="Delete one record of Category",
  *      description="Delete one record of Category",
  *      @OA\RequestBody(
  *         @OA\MediaType(
  *             mediaType="application/json",
  *             @OA\Schema(
  *                 @OA\Property(
  *                     property="id",
  *                     type="object",
  *                     example="79b6e6ed-b54d-430e-9f2e-761b89033aad"
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
  *
  */

/**
  * @OA\Delete(
  *      path="/module/blog/v1/category/delete-multiple",
  *      operationId="deleteMultipleCategory",
  *      tags={"category"},
  *      summary="Delete multiple record of Category",
  *      description="Delete multiple record of Category",
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
  *
  */
