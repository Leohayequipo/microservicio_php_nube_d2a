<?php
namespace App\Controllers;

use App\Services\WebhookService;

/**
 * @OA\Tag(
 *     name="Webhooks",
 *     description="Endpoints para procesamiento de webhooks de Tiendanube"
 * )
 */
class WebhookController {
    private $service;

    public function __construct() {
        $this->service = new WebhookService();
    }

    /**
     * @OA\Post(
     *     path="/webhook",
     *     operationId="processWebhook",
     *     summary="Procesar webhook de Tiendanube",
     *     description="Recibe eventos de webhook y los envía a D2A",
     *     tags={"Webhooks"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"event", "data"},
     *             @OA\Property(property="event", type="string", example="order/created"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="order_id", type="string", example="ORD-12345"),
     *                 @OA\Property(property="status", type="string", example="pending"),
     *                 @OA\Property(property="amount", type="number", format="float", example=99.99)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Webhook procesado exitosamente",
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

        $this->service->processWebhook($data);
        echo json_encode(['status' => 'ok']);
    }
}
