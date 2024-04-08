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

            $nama = $perusahaan = $alamat = $kuasa = $telepon = $email = $lisensi = $pemilik_hak =  $penerima_hak =  $sejak_tanggal = $sampai_tanggal = $tanggal = $tanggal1 =  '';

            foreach ($pages as $pageNumber => $page) {
                $text = $page->getText();
                if (preg_match($pattern, $text, $matches)) {
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
                        if (strpos($tanggalString, '-') !== false) {
                            $tanggalString = str_replace(' ', '', $tanggalString);
                            $tanggal = Carbon::createFromFormat('d-m-Y', $tanggalString)->toDateString();
                        } else {
                            $tanggal = Carbon::createFromFormat('d F Y', $tanggalString)->toDateString();
                        }

                        $tanggalString1 = $sampai_tanggal;
                        if (strpos($tanggalString1, '-') !== false) {
                            $tanggalString1 = str_replace(' ', '', $tanggalString1);
                            $tanggal1 = Carbon::createFromFormat('d-m-Y', $tanggalString1)->toDateString();
                        } else {
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
