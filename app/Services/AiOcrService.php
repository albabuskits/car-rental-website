<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AiOcrService
{
    protected string $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.gemini.api_key', '');
    }

    public function extract(string $imagePath): array
    {
        if (!file_exists($imagePath)) {
            Log::warning('AiOcrService: Image not found at ' . $imagePath);
            return $this->emptyResult();
        }

        if (empty($this->apiKey)) {
            Log::warning('AiOcrService: GEMINI_API_KEY not configured');
            return $this->emptyResult();
        }

        try {
            $imageData = base64_encode(file_get_contents($imagePath));
            $mimeType = mime_content_type($imagePath) ?: 'image/jpeg';

            $payload = [
                'contents' => [
                    [
                        'parts' => [
                            [
                                'inline_data' => [
                                    'mime_type' => $mimeType,
                                    'data' => $imageData,
                                ],
                            ],
                            [
                                'text' => 'استخرج معلومات رخصة القيادة من هذه الصورة. أعد البيانات بصيغة JSON بهذا التنسيق بالضبط: {"full_name": "", "license_number": "", "date_of_birth": "", "issue_date": "", "expiration_date": "", "address": ""}. استخدم تنسيق YYYY-MM-DD للتواريخ. إذا لم تجد قيمة، اترك الحقل فارغاً.',
                            ],
                        ],
                    ],
                ],
            ];

            $response = Http::timeout(30)
                ->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=' . $this->apiKey, $payload);

            if ($response->successful()) {
                $data = $response->json();
                $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? '';
                return $this->parseResponse($text);
            }

            Log::warning('AiOcrService: Gemini API returned ' . $response->status());
        } catch (\Exception $e) {
            Log::warning('AiOcrService: ' . $e->getMessage());
        }

        return $this->emptyResult();
    }

    protected function parseResponse(string $text): array
    {
        $text = trim($text);
        $text = preg_replace('/^```(?:json)?\s*|\s*```$/', '', $text);

        $decoded = json_decode($text, true);

        if (is_array($decoded)) {
            return [
                'full_name' => $decoded['full_name'] ?? '',
                'license_number' => $decoded['license_number'] ?? '',
                'date_of_birth' => $decoded['date_of_birth'] ?? '',
                'issue_date' => $decoded['issue_date'] ?? '',
                'expiration_date' => $decoded['expiration_date'] ?? '',
                'address' => $decoded['address'] ?? '',
            ];
        }

        return $this->emptyResult();
    }

    protected function emptyResult(): array
    {
        return [
            'full_name' => '',
            'license_number' => '',
            'date_of_birth' => '',
            'issue_date' => '',
            'expiration_date' => '',
            'address' => '',
        ];
    }
}
