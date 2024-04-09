<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ScanCardController extends Controller
{
    public function scancard(Request $request)
    {
        if ($request->hasFile('pdf_file')) {
            $image = $request->file('pdf_file');

            $client = new Client();
            $formData  = [
                [
                    'name' => 'file',
                    'contents' => fopen($image->getPathname(), 'r'),
                ],
                [
                    'name' => 'OCREngine',
                    'contents' => '2',
                ],
            ];

            try {
                $response = $client->request('POST', 'https://api.ocr.space/parse/image', [
                    'headers' => [
                        'apikey' => 'K88613240888957',
                    ],
                    'multipart' => $formData,
                    'verify' => false,
                ]);

                $result = json_decode($response->getBody());

                if (isset($result->ParsedResults) && !empty($result->ParsedResults)) {
                    $parsedText = $result->ParsedResults[0]->ParsedText;

                    return redirect()->route('hasilscan', ['parsedText' => $parsedText]);
                } else {
                    return redirect()->route('hasilscan', ['error' => 'OCR processing failed']);
                }
            } catch (\Exception $e) {
                return redirect()->route('hasilscan', ['error' => $e->getMessage()]);
            }
        } else {
            return redirect()->route('hasilscan', ['error' => 'File not provided']);
        }
    }
}
