<?php
namespace App\Controllers;

use App\Services\CheckoutService;

/**
 * @OA\Info(
 *     title="Microservicio D2A API",
 *     version="1.0.0",
 *     description="API para integración con D2A - Checkout y Webhooks de Tiendanube"
 * )
 * 
 * @OA\Server(
 *     url="http://localhost:8000",
 *     description="Servidor de desarrollo"
 * )
 * 
 * @OA\Tag(
 *     name="Checkout",
 *     description="Endpoints para procesamiento de checkout"
 * )
 */
class CheckoutController {
    private $service;

    public function __construct() {
        $this->service = new CheckoutService();
    }

    /**
     * @OA\Post(
     *     path="/checkout-temp",
     *     operationId="processCheckout",
     *     summary="Procesar checkout temporal",
     *     description="Recibe datos de checkout y los envía a D2A",
     *     tags={"Checkout"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"order_id", "amount", "currency"},
     *             @OA\Property(property="order_id", type="string", example="ORD-12345"),
     *             @OA\Property(property="amount", type="number", format="float", example=99.99),
     *             @OA\Property(property="currency", type="string", example="ARS"),
     *             @OA\Property(property="customer_email", type="string", format="email", example="cliente@ejemplo.com"),
     *             @OA\Property(property="items", type="array", @OA\Items(
     *                 @OA\Property(property="name", type="string", example="Producto 1"),
     *                 @OA\Property(property="quantity", type="integer", example=2),
     *                 @OA\Property(property="price", type="number", format="float", example=49.99)
     *             ))
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Checkout procesado exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="ok")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Datos inválidos",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Invalid JSON")
     *         )
     *     )
     * )
     */
    public function receive() {
        $data = json_decode(file_get_contents('php://input'), true);
        if (!$data) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid JSON']);
            return;
        }

        $this->service->processCheckout($data);
        echo json_encode(['status' => 'ok']);
    }
}
