<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ScanCardController extends Controller
{
    public function scancard(Request $request)
    {
        $request->validate([
            'image' => 'required|file|mimes:jpeg,png,jpg,gif,bmp,tiff,webp|max:1024',
        ]);

        $uploadedImage = $request->file('image');
        $extension = $uploadedImage->getClientOriginalExtension();

        if (!in_array(strtolower($extension), ['jpeg', 'png', 'jpg', 'gif', 'bmp', 'tif', 'tiff', 'webp'])) {
            return response()->json(['error' => 'Unsupported file format.'], 400);
        }

        $imagePath = $uploadedImage->store('public/uploads');
        $client = new Client();
        $response = $client->post('https://api.ocr.space/parse/image', [
            'headers' => [
                'apikey' => 'K88613240888957',
            ],
            'multipart' => [
                [
                    'name' => 'file',
                    'contents' => fopen(storage_path('app/' . $imagePath), 'r'),
                ],
                [
                    'name' => 'OCREngine',
                    'contents' => '2',
                ],
                [
                    'name' => 'isTable',
                    'contents' => 'true',
                ],
            ],
        ]);


        $parsedResult  = json_decode($response->getBody()->getContents(), true);
        // dd($parsedResult);
        $nik = $this->extractNIK($parsedResult);
        $nama = $this->extractName($parsedResult);
        $addressDetails = $this->extractAddressDetails($parsedResult);

        return redirect()->route('hasil-scan-ktp', [
            'nik' => $nik,
            'nama' => $nama,
            'addressDetails' => $addressDetails,
        ]);
    }

    private function extractNIK($parsedResult)
    {
        if (isset($parsedResult['ParsedResults'][0]['ParsedText'])) {
            $parsedText = $parsedResult['ParsedResults'][0]['ParsedText'];
            preg_match('/NIK\s+(\d{16})/', $parsedText, $matches);
            if (isset($matches[1])) {
                return $matches[1];
            }
        }

        return null;
    }

    private function extractName($parsedResult)
    {
        if (isset($parsedResult['ParsedResults'][0]['ParsedText'])) {
            $parsedText = $parsedResult['ParsedResults'][0]['ParsedText'];
            preg_match('/Nama\s*:?[\s-]*(.*?)(?:\s+Tempat|\b[A-Z][a-z]*\b|$)/s', $parsedText, $matches);
            $nama = isset($matches[1]) ? trim($matches[1]) : null;

            return $nama;
        }

        return null;
    }

    private function extractAddressDetails($parsedResult)
    {
        if (isset($parsedResult['ParsedResults'][0]['ParsedText'])) {
            $parsedText = $parsedResult['ParsedResults'][0]['ParsedText'];
            preg_match('/Alamat\s*:?[\s-]*(.*?)\s*(RTIRW|RT\/RW)?\s*:?([\d\/]+)?\s*Kel\/Desa\s*:?([\s\w]+)?\s*Kecamatan\s*:?([\s\w]+)?(?:\s*Agama|\b[A-Z][a-z]*\b|$)/s', $parsedText, $matches);
            $alamat = isset($matches[1]) ? trim($matches[1]) : null;
            $rtRwType = isset($matches[2]) ? trim($matches[2]) : null;
            $rtRwNumber = isset($matches[3]) ? trim($matches[3]) : null;
            $kelDesa = isset($matches[4]) ? trim($matches[4]) : null;
            $kecamatan = isset($matches[5]) ? trim($matches[5]) : null;

            $addressDetails = [
                'alamat' => $alamat,
                'rtRw' => $rtRwNumber,
                'kelDesa' => $kelDesa,
                'kecamatan' => $kecamatan,
            ];

            return $addressDetails;
        }

        return null;
    }

    public function scanKtp(Request $request)
    {
        $parsedResult = $this->scanKtpAndExtractInfo($request);
        $nik = $this->extractNIK($parsedResult);
        $nama = $this->extractName($parsedResult);

        if (!$nik || !$nama) {
            return redirect()->back()->with('error', 'Data KTP tidak lengkap atau tidak ditemukan. Mohon unggah ulang KTP.');
        }
        return redirect()->route('hasil-scan-ktp', [
            'nik' => $nik,
            'nama' => $nama,
        ]);
    }
}
