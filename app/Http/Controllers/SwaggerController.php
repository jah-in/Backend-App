<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

#[OA\Info(
    version: "1.0.0",
    title: "LibTrack System API",
    description: "API documentation for the LibTrack Library Tracking System"
)]

#[OA\Server(
    url: "http://127.0.0.1:8000",
    description: "Local Development Server"
)]

#[OA\SecurityScheme(
    securityScheme: "sanctum",
    type: "http",
    scheme: "bearer",
    bearerFormat: "Bearer Token"
)]

class SwaggerController extends Controller
{
    //
}