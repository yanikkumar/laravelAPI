<?php

namespace App\Http\Controllers;

/**
 * @OA\Info(
 *     description="Simple role based authentication API Documentation in Laravel 11.x",
 *     version="1.0.0",
 *     title="Laravel API",
 *     termsOfService="http://swagger.io/terms/",
 *     @OA\Contact(
 *         email="admin@laravel-api.com"
 *     ),
 *      @OA\License(
 *          name="Apache 2.0",
 *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *      ),
 *  )
 *      @OA\Server(
 *          url=L5_SWAGGER_CONST_HOST,
 *          description="Admin API Service"
 *      )
 *
 *      @OA\SecurityScheme(
 *           securityScheme="bearerAuth",
 *           type="http",
 *           scheme="bearer"
 *       )
 */
abstract class Controller
{
    //
}
