<?php
namespace App\Repositories;

class CheckoutRepository {
    private $path;

    public function __construct() {
        $this->path = __DIR__ . '/../../storage/tmp/';
    }

    public function save(string $checkoutId, array $data): void {
        $file = $this->path . "checkout_{$checkoutId}.json";
        file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
    }

    public function find(string $checkoutId): ?array {
        $file = $this->path . "checkout_{$checkoutId}.json";
        if (!file_exists($file)) return null;

        return json_decode(file_get_contents($file), true);
    }

    public function delete(string $checkoutId): void {
        $file = $this->path . "checkout_{$checkoutId}.json";
        if (file_exists($file)) unlink($file);
    }
}
