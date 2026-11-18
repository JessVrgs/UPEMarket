<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class CloudinaryService
{
    private function http()
    {
        $c = config('services.cloudinary');

        return Http::withBasicAuth($c['api_key'], $c['api_secret'])->timeout(30);
    }

    private function url(string $accion): string
    {
        return 'https://api.cloudinary.com/v1_1/' . config('services.cloudinary.cloud_name') . '/image/' . $accion;
    }

    public function subir(UploadedFile $archivo): array
    {
        $respuesta = $this->http()
            ->attach('file', fopen($archivo->getRealPath(), 'r'), $archivo->getClientOriginalName())
            ->post($this->url('upload'), ['folder' => 'upemarket']);

        if ($respuesta->failed()) {
            Log::error('Cloudinary: fallo al subir', ['respuesta' => $respuesta->body()]);
            throw new RuntimeException('No se pudo subir la imagen.');
        }

        return [
            'url'       => $respuesta->json('secure_url'),
            'public_id' => $respuesta->json('public_id'),
        ];
    }

    public function borrar(string $publicId): void
    {
        $respuesta = $this->http()->asForm()->post($this->url('destroy'), ['public_id' => $publicId]);

        if ($respuesta->failed()) {
            Log::warning('Cloudinary: fallo al borrar', ['public_id' => $publicId]);
        }
    }
}