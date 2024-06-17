<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class ApiScanTTDController extends Controller
{
    public function upload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Jika validasi gagal, kembalikan respons dengan error
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Ambil data gambar dari request
        $dokumen = $request->file('file');
        $nama_file = $dokumen->getClientOriginalName();

        // Memotong gambar sebelum menyimpannya
        $img = Image::make($dokumen);
        $cropWidth = 200; // Lebar gambar yang diinginkan untuk tanda tangan
        $cropHeight = 100; // Tinggi gambar yang diinginkan untuk tanda tangan
        $x = $img->width() - $cropWidth - 20; // Koordinat x untuk pojok kanan bawah (20 adalah jarak dari tepi)
        $y = $img->height() - $cropHeight - 20; // Koordinat y untuk pojok kanan bawah (20 adalah jarak dari tepi)
        $img->crop($cropWidth, $cropHeight, $x, $y);

        // Simpan gambar hasil crop di dalam direktori public/file-crop
        $img->save(public_path('file-crop/' . $nama_file));

        // Kembalikan respons dengan pesan sukses atau url gambar hasil crop
        return redirect()->back()->with('success', 'File berhasil diunggah dan dipotong.');
    }
}
