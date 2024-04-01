<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Smalot\PdfParser\Parser;
use Carbon\Carbon;


class PDFController extends Controller
{
    public function parse(Request $request)
    {
        // Proses PDF yang diunggah
        if ($request->hasFile('pdf_file')) {
            $pdfFile = $request->file('pdf_file');
            $parser = new Parser();
            $pdf = $parser->parseFile($pdfFile);
            $pages = $pdf->getPages();

            // $pattern = '/Nama\s*:\s*(.*?)\s*Perusahaan\/Badan Hukum\*\s*:\s*(.*?)\s*Alamat\s*:\s*(.*?)\s*Kuasa dan Alamat Kuasa\*\*\s*:\s*(.*?)\s*Nomor Telepon\/HP\s*:\s*(.*?)\s*Email\s*:\s*([^\s@]+@[^\s@]+\.[^\s@]+).*?Dengan ini mengajukan permohonan pencatatan perjanjian lisensi:\s*(.*?)\s+Antara \(Pemilik Hak\) : (.*?)\s+Dengan \(Penerima Hak\) : (.*?)\s*Yang berlaku sejak tanggal : (.*?)\s*Sampai dengan tanggal : ([^\n]+)/s';

            $pattern = '/Nama\s*:\s*(.*?)\s*Perusahaan\/Badan Hukum\*\s*:\s*(.*?)\s*Alamat\s*:\s*(.*?)\s*Kuasa dan Alamat Kuasa\*\*\s*:\s*(.*?)\s*Nomor Telepon\/HP\s*:\s*(.*?)\s*Email\s*:\s*([^\s@]+@[^\s@]+\.[^\s@]+).*?Dengan ini mengajukan permohonan pencatatan perjanjian lisensi:\s*(.*?)(?:\s*\.\s*){10,}\s+Antara \(Pemilik Hak\) : (.*?)\s*Dengan \(Penerima Hak\) : (.*?)\s*Yang berlaku sejak tanggal : (.*?)\s*Sampai dengan tanggal : ([^\n]+)/s';

            // Variabel untuk menyimpan hasil parsing
            $nama = $perusahaan = $alamat = $kuasa = $telepon = $email = $lisensi = $pemilik_hak =  $penerima_hak =  $sejak_tanggal = $sampai_tanggal = $tanggal = $tanggal1 =  '';

            // Loop melalui setiap halaman PDF
            foreach ($pages as $pageNumber => $page) {
                // Dapatkan teks dari halaman PDF
                $text = $page->getText();
                if (preg_match($pattern, $text, $matches)) {
                    // Memeriksa apakah $matches memiliki nilai
                    if (isset($matches[0])) {
                        $nama = $matches[1] ?? '';
                        $perusahaan = $matches[2] ?? '';
                        $alamat = $matches[3] ?? '';
                        $kuasa = $matches[4] ?? '';
                        $telepon = $matches[5] ?? '';
                        $email = $matches[6] ?? '';
                        $lisensi = $matches[7] ?? '';
                        $pemilik_hak = $matches[8] ?? '';
                        $penerima_hak =  $matches[9] ?? '';
                        $sejak_tanggal = $matches[10] ?? '';
                        $sampai_tanggal = $matches[11] ?? '';

                        $tanggalString = $sejak_tanggal;
                        // Cek apakah string tanggal mengandung tanda hubung (-)
                        if (strpos($tanggalString, '-') !== false) {
                            // Jika iya, formatnya adalah "d - m - Y"
                            $tanggalString = str_replace(' ', '', $tanggalString); // Hapus spasi
                            $tanggal = Carbon::createFromFormat('d-m-Y', $tanggalString)->toDateString();
                        } else {
                            // Jika tidak, maka coba format "d F Y"
                            $tanggal = Carbon::createFromFormat('d F Y', $tanggalString)->toDateString();
                        }

                        $tanggalString1 = $sampai_tanggal;
                        // Cek apakah string tanggal mengandung tanda hubung (-)
                        if (strpos($tanggalString1, '-') !== false) {
                            // Jika iya, formatnya adalah "d - m - Y"
                            $tanggalString1 = str_replace(' ', '', $tanggalString1); // Hapus spasi
                            $tanggal1 = Carbon::createFromFormat('d-m-Y', $tanggalString1)->toDateString();
                        } else {
                            // Jika tidak, maka coba format "d F Y"
                            $tanggal1 = Carbon::createFromFormat('d F Y', $tanggalString1)->toDateString();
                        }

                        break;
                    } else {
                        print 'hasil kosong';
                        echo 'hasil kosong';
                    }
                }
            }

            $data = [
                'title' => 'Hasil Surat',
                'cardTitle' => 'Hasil Surat',
                'nama' => $nama,
                'perusahaana' => $perusahaan,
                'alamata' => $alamat,
                'kuasa' => $kuasa,
                'telepon' => $telepon,
                'emails' => $email,
                'lisensi' => $lisensi,
                'pemilik_hak' => $pemilik_hak,
                'penerima_hak'  => $penerima_hak,
                'sejak_tanggal' => $tanggal,
                'sampai_tanggal' => $tanggal1,
            ];
            // dd($data);
            return redirect()->route('hasilpermohonan', compact('data'));
        }

        return back()->withErrors('Please upload a PDF file.');
    }
}
