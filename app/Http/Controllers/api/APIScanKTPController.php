<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\ScanKTP;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class APIScanKTPController extends Controller
{
    public function scancard(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|file|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'File size exceeds 2MB.'], 400);
        }

        $uploadedImage = $request->file('image');
        $extension = $uploadedImage->getClientOriginalExtension();

        if (!in_array(strtolower($extension), ['jpeg', 'png', 'jpg', 'pdf'])) {
            return response()->json(['error' => 'Unsupported file format.'], 400);
        }

        $imagePath = $uploadedImage->store('public/uploads');
        $client = new Client();

        try {
            $response = $client->post('https://api.ocr.space/parse/image', [
                'headers' => [
                    'apikey' => 'K81576001488957',
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
                'verify' => false,
            ]);

            $parsedResults = json_decode($response->getBody()->getContents(), true);
            $extractedData = [];

            foreach ($parsedResults['ParsedResults'] as $parsedResult) {
                if (isset($parsedResult['ParsedText'])) {
                    $nik = $this->extrakNIK($parsedResult['ParsedText']);
                    $names = $this->extrakNama($parsedResult['ParsedText']);
                    $addressDetails = $this->extrakAlamat($parsedResult['ParsedText']);

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
            }

            $hasValidData = false;
            foreach ($extractedData as $data) {
                if (!empty($data['nik']) && !empty($data['nama']) && !empty($data['addressDetails'])) {
                    $hasValidData = true;
                    break;
                }
            }

            if ($hasValidData) {
                Cache::put('extracted_data', $extractedData, now()->addMinutes(30));
                return response()->json(['success' => true, 'message' => 'Data successfully extracted.']);
            } else {
                $errorMessage = 'Gagal mengambil data KTP.' . "\n" . 'Mohon unggah ulang file KTP.';
                return response()->json(['error' => $errorMessage], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'OCR service error: ' . $e->getMessage()], 500);
        }
    }

    private function extrakNIK($parsedText)
    {
        $parsedText = str_replace('}', '1', $parsedText);
        preg_match_all('/\b\d{16}\b/', $parsedText, $matches);
        return isset($matches[0]) ? array_map('trim', $matches[0]) : [];
    }

    private function extrakNama($parsedText)
    {
        preg_match_all('/(?:Nama|Name)\s*:?[\s-]*(.*?)(?=\s+Tempat|\b[A-Z][a-z]*\b|$)/s', $parsedText, $matches);
        return isset($matches[1]) ? array_map('trim', $matches[1]) : [];
    }

    private function extrakAlamat($parsedText)
    {
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
                'rtRw' => $rtRw,
                'kelDesa' => $kelDesa,
                'kecamatan' => $kecamatan,
            ];
        }

        return $addressDetails;
    }


    public function scanKtp(Request $request)
    {
        $parsedResult = $this->scanKtpAndExtractInfo($request);
        $nik = $this->extrakNIK($parsedResult);
        $nama = $this->extrakNama($parsedResult);

        if (!$nik || !$nama) {
            return redirect()->back()->with('error', 'Data KTP tidak lengkap atau tidak ditemukan.' . `\n` . 'Mohon unggah ulang KTP.');
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

    public function submitAllKTP(Request $request)
    {
        try {
            $xData = $request->input('x_data');

            DB::beginTransaction();

            $updatedCount = 0;
            $newCount = 0;

            foreach ($xData as $data) {
                $nama = str_replace(["\t", "\r", "\n"], "", $data['nama']);
                if ($data['found']) {
                    if (!empty($data['id'])) {
                        ScanKTP::where('id', $data['id'])->update([
                            'nama' => $nama,
                            'nik' => $data['nik'],
                            'alamat' => $data['alamat'],
                        ]);
                        $updatedCount++;
                    } else {
                        ScanKTP::where('nik', $data['nik'])->update([
                            'nama' => $nama,
                            'alamat' => $data['alamat'],
                        ]);
                        $updatedCount++;
                    }
                } else {
                    ScanKTP::create([
                        'nama' => $nama,
                        'nik' => $data['nik'],
                        'alamat' => $data['alamat'],
                    ]);
                    $newCount++;
                }
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil disimpan.',
                'updated_count' => $updatedCount,
                'new_count' => $newCount,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
