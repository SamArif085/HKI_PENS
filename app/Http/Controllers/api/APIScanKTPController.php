<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\ScanKTP;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

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
            ], 'verify' => false,
        ]);
        $parsedResults = json_decode($response->getBody()->getContents(), true);
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
            Cache::put('extracted_data', $extractedData, now()->addMinutes(30));
        }
        return redirect()->route('hasil-scan-ktp');
        // return redirect()->route('hasil-scan-ktp', compact('extractedData'));
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
                $alamat = preg_replace('/\s+/', ' ', $alamat);

                preg_match('/RT\/RW\s*:?([\d\/]+).*?(?:Kel\/Desa|Kei\/Desa|Kelurahan\/Desa)\s*:?([\s\w]+).*?Kecamatan\s*:?([\s\w]+)/s', $alamat, $addressInfo);

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
            // dd($addressDetails);
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
        $data = $request->all();
        $existingData = DB::table('ktp')
            ->where('nik', $data['nik'])
            ->first();

        if ($existingData) {
            DB::table('ktp')
                ->where('id', $existingData->id)
                ->update([
                    'nik' => $data['nik'],
                    'nama' => $data['nama'],
                    'alamat' => $data['alamat'],
                ]);

            $message = 'Data berhasil diperbarui.';
        } else {
            DB::table('ktp')->insert([
                'nik' => $data['nik'],
                'nama' => $data['nama'],
                'alamat' => $data['alamat'],
            ]);

            $message = 'Data berhasil disimpan.';
        }

        return response()->json(['message' => $message]);
    }

    public function edit(Request $request)
    {

        $id = $request->input('id');
        $nama = $request->input('nama');
        $nik = $request->input('nik');
        $alamat = $request->input('alamat');

        $insetrt = ScanKTP::find($id);
        if (!$insetrt) {
            return response()->json(['error' => 'Data not found.'], 404);
        }
        $insetrt->nama = $nama;
        $insetrt->nik = $nik;
        $insetrt->alamat = $alamat;
        $insetrt->save();

        return response()->json(['message' => 'Data updated successfully.']);
    }
}
