<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class APIScanKTPController extends Controller
{
    public function scancard(Request $request)
    {
        $request->validate([
            'image' => 'required|file|mimes:jpeg,png,jpg,gif,bmp,tiff,webp,pdf|max:1024',
        ]);
        $uploadedImage = $request->file('image');
        $extension = $uploadedImage->getClientOriginalExtension();
        if (!in_array(strtolower($extension), ['jpeg', 'png', 'jpg', 'gif', 'bmp', 'tif', 'tiff', 'webp', 'pdf'])) {
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
        $parsedResults = json_decode($response->getBody()->getContents(), true);
        // dd($parsedResults);
        $extractedData = [];
        if (is_array($parsedResults)) {
            $nik = $this->extrakNIK($parsedResults);
            $names = $this->extrakNama($parsedResults);
            $addressDetails = $this->extrakAlamat($parsedResults);
            $tempData = [];
            foreach ($names as $index => $nama) {
                $tempData[] = [
                    'nama' => $nama,
                    'nik' => isset($nik[$index]) ? $nik[$index] : null,
                    'addressDetails' => isset($addressDetails[$index]) ? $addressDetails[$index] : null,
                ];
            }
            $extractedData = array_merge($extractedData, $tempData);
        }
        return redirect()->route('hasil-scan-ktp', compact('extractedData'));
    }

    private function extrakNIK($parsedResult)
    {
        if (isset($parsedResult['ParsedResults'][0]['ParsedText'])) {
            $parsedText = $parsedResult['ParsedResults'][0]['ParsedText'];
            preg_match_all('/\b\d{16}\b/', $parsedText, $matches);
            $niks = isset($matches[0]) ? array_map('trim', $matches[0]) : [];

            return $niks;
        }

        return null;
    }

    private function extrakNama($parsedResult)
    {
        if (isset($parsedResult['ParsedResults'][0]['ParsedText'])) {
            $parsedText = $parsedResult['ParsedResults'][0]['ParsedText'];

            preg_match_all('/(?:Nama|Name)\s*:?[\s-]*(.*?)(?=\s+Tempat|\b[A-Z][a-z]*\b|$)/s', $parsedText, $matches);
            $names = isset($matches[1]) ? array_map('trim', $matches[1]) : [];

            return $names;
        }

        return null;
    }

    private function extrakAlamat($parsedResult)
    {
        if (isset($parsedResult['ParsedResults'][0]['ParsedText'])) {
            $parsedText = $parsedResult['ParsedResults'][0]['ParsedText'];
            preg_match_all('/Alamat(.*?)Agama/s', $parsedText, $matches, PREG_SET_ORDER);

            $addressDetails = [];

            foreach ($matches as $match) {
                $alamat = isset($match[1]) ? trim($match[1]) : null;

                // preg_match('/RT\/RW\s*:?([\d\/]+).*?(?:Kel\/Desa|Kei\/Desa|Kelurahan\/Desa)\s*:?([\s\w]+).*?Kecamatan\s*:?([\s\w]+)/s', $alamat, $addressInfo);

                $rtRw = isset($addressInfo[1]) ? trim($addressInfo[1]) : null;
                $kelDesa = isset($addressInfo[2]) ? trim($addressInfo[2]) : null;
                $kecamatan = isset($addressInfo[3]) ? trim($addressInfo[3]) : null;

                $addressDetails[] = [
                    'alamat' => $alamat,
                    // 'rtRw' => $rtRw,
                    // 'kelDesa' => $kelDesa,
                    // 'kecamatan' => $kecamatan,
                ];
            }

            return $addressDetails;
        }

        return null;
    }

    public function scanKtp(Request $request)
    {
        $parsedResult = $this->scanKtpAndExtractInfo($request);
        $nik = $this->extrakNIK($parsedResult);
        $nama = $this->extrakNama($parsedResult);

        if (!$nik || !$nama) {
            return redirect()->back()->with('error', 'Data KTP tidak lengkap atau tidak ditemukan. Mohon unggah ulang KTP.');
        }
        return redirect()->route('hasil-scan-ktp', [
            'nik' => $nik,
            'nama' => $nama,
        ]);
    }

    public function submit(Request $request)
    {
        $nikArray = $request->nik;
        $namaArray = $request->nama;
        $alamatArray = $request->alamat;

        DB::transaction(function () use ($nikArray, $namaArray, $alamatArray) {
            foreach ($nikArray as $key => $nik) {
                if (!empty($nik) && !empty($namaArray[$key]) && !empty($alamatArray[$key])) {
                    $nama = $namaArray[$key];
                    $alamat = $alamatArray[$key];

                    DB::table('ktp')->insert([
                        'nik' => $nik,
                        'nama' => $nama,
                        'alamat_lkp' => $alamat,
                    ]);
                }
            }
        });
        return redirect()->route('Scan-KTP');
    }
}
