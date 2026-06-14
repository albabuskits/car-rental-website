<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\UploadedFile;

class OcrService
{
    public function extract($imagePath): array
    {
        $fullPath = storage_path('app/public/' . $imagePath);

        if (!file_exists($fullPath)) {
            return $this->fallbackExtract(pathinfo($imagePath, PATHINFO_FILENAME));
        }

        try {
            $apiKey = config('services.ocr.api_key', 'helloworld');
            $imageData = base64_encode(file_get_contents($fullPath));

            $response = Http::timeout(30)->asMultipart()
                ->post('https://api.ocr.space/parse/image', [
                    'apikey' => $apiKey,
                    'base64Image' => 'data:image/jpeg;base64,' . $imageData,
                    'language' => 'ara',
                    'isOverlayRequired' => false,
                ]);

            if ($response->successful()) {
                $data = $response->json();
                $parsed = $data['ParsedResults'][0]['ParsedText'] ?? '';
                return $this->parseLicenseText($parsed);
            }
        } catch (\Exception $e) {
            Log::warning('OCR API failed: ' . $e->getMessage());
        }

        return $this->fallbackExtract(pathinfo($imagePath, PATHINFO_FILENAME));
    }

    protected function parseLicenseText(string $text): array
    {
        $lines = array_filter(explode("\n", $text));
        $lines = array_map('trim', $lines);
        $lines = array_values(array_filter($lines));

        $result = [
            'full_name' => '',
            'license_number' => '',
            'date_of_birth' => '',
            'issue_date' => '',
            'expiration_date' => '',
            'address' => '',
            'raw_text' => $text,
        ];

        $joined = implode(' ', $lines);
        $joined = preg_replace('/\s+/', ' ', $joined);

        if (preg_match('/\b(\d{1,2}[/-]\d{1,2}[/-]\d{2,4})\b/', $joined, $m)) {
            $result['issue_date'] = $this->normalizeDate($m[1]);
        }
        if (preg_match('/\b(\d{1,2}[/-]\d{1,2}[/-]\d{2,4})\b(?!.*\1)/', $joined, $m)) {
            $result['expiration_date'] = $this->normalizeDate($m[1]);
        }
        if (preg_match('/\b\d{6,15}\b/', $joined, $m)) {
            $result['license_number'] = $m[0];
        }
        foreach ($lines as $line) {
            $clean = trim($line);
            if (mb_strlen($clean) > 3 && preg_match('/^[\p{Arabic}\s]+$/u', $clean)) {
                if (empty($result['full_name'])) {
                    $result['full_name'] = $clean;
                } elseif (empty($result['address'])) {
                    $result['address'] = $clean;
                }
            }
        }

        return $result;
    }

    protected function fallbackExtract($filename): array
    {
        return [
            'full_name' => '',
            'license_number' => preg_replace('/[^0-9]/', '', $filename),
            'date_of_birth' => '',
            'issue_date' => '',
            'expiration_date' => '',
            'address' => '',
            'raw_text' => '',
        ];
    }

    protected function normalizeDate($date): string
    {
        $parts = preg_split('/[\/-]/', $date);
        if (count($parts) === 3) {
            if (strlen($parts[2]) === 2) {
                $parts[2] = '20' . $parts[2];
            }
            return $parts[2] . '-' . str_pad($parts[1], 2, '0', STR_PAD_LEFT) . '-' . str_pad($parts[0], 2, '0', STR_PAD_LEFT);
        }
        return $date;
    }
}
