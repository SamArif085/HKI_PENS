<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Smalot\PdfParser\Parser;

class PDFController extends Controller
{
    public function parse(Request $request)
    {
        if ($request->hasFile('pdf_file')) {
            $pdfFile = $request->file('pdf_file');
            $parser = new Parser();
            $pdf = $parser->parseFile($pdfFile);
            $pages = $pdf->getPages();

            $data = [];
            $currentData = [];

            foreach ($pages as $pageNumber => $page) {
                $text = $page->getText();

                // Parsing pencipta
                preg_match_all('/I\.\s*Pencipta\s*:(.*?)(?=II|$)/s', $text, $matches, PREG_SET_ORDER);
                // dd($text);
                foreach ($matches as $match) {
                    $currentData['pencipta'] = $this->parsePencipta($match[1]);
                }

                // Parsing pemegang hak cipta
                preg_match_all('/II\.\s*Pemegang\s+Hak\s+Cipta\s*:(.*?)(?=III|$)/s', $text, $matches, PREG_SET_ORDER);
                foreach ($matches as $match) {
                    $currentData['pemegang_hak'] = $this->parsePemegangHak($match[1]);
                }

                // Parsing jenis ciptaan, tanggal dan tempat, dan uraian ciptaan
                preg_match('/III\.\s*Jenis\s+dari\s+judul\s+ciptaan\s+yang\s+dimohonkan\s*:\s*([^IV]+)/s', $text, $matches);
                $jenisCiptaan = trim($matches[1] ?? '');

                preg_match('/Di\s+([^,\n\r]+,\s+\d+\s+\w+\s+\d+)/', $text, $matches);
                $tanggalDanTempat = trim($matches[1] ?? '');



                preg_match('/V\.\s*Uraian\s+ciptaan\s*:\s*(.*?)\s*(?=VI|IV|V\.|$)/s', $text, $matches);
                $uraianCiptaan = trim($matches[1] ?? '');



                // Combine jenis ciptaan, tanggal dan tempat, dan uraian ciptaan into currentData
                $currentData['jenis_ciptaan'] = $jenisCiptaan;
                $currentData['tanggal_dan_tempat'] = $tanggalDanTempat;
                $currentData['uraian_ciptaan'] = $uraianCiptaan;

                // Push currentData to data array and reset currentData
                $data[] = $currentData;
                $currentData = [];
            }

            $hasilDokumen = ['data' => $data];
            return redirect()->route('hasil-Dokumen', compact('hasilDokumen'));
        }

        return back()->withErrors('Please upload a PDF file.');
    }

    private function parsePencipta($text)
    {
        $no_hp = '';
        $email = '';

        preg_match('/1\.\s*Nama\s*:\s*([^\n]+)/', $text, $matches);
        $nama = trim($matches[1] ?? '');

        preg_match('/2\.\s*Kewarganegaraan\s*:\s*([^\n]+)/', $text, $matches);
        $kewarganegaraan = trim($matches[1] ?? '');

        preg_match('/3\.\s*Alamat\s*:\s*(.*?)(?:(?:\s*\d+\.|\z)(?!\s*No\. HP & E-mail))/', $text, $matches);
        $alamat = isset($matches[1]) ? trim($matches[1]) : '';

        preg_match('/5\.\s*No\. HP & E-mail\s*:\s*\+(\d+)\s*&\s*([^\n]+)/', $text, $matches);
        if (isset($matches[1])) {
            $no_hp = '+' . trim($matches[1]);
            $email = trim($matches[2]);
        } else {
            preg_match('/5\.\s*No\. HP & E-mail\s*:\s*([^\n]+)/', $text, $matches);
            if (isset($matches[1])) {
                if (filter_var($matches[1], FILTER_VALIDATE_EMAIL)) {
                    $email = trim($matches[1]);
                } else {
                    $no_hp = trim($matches[1]);
                }
            }
        }
        return [
            'nama' => $nama,
            'kewarganegaraan' => $kewarganegaraan,
            'alamat' => $alamat,
            'no_hp' => $no_hp,
            'email' => $email,
        ];
    }

    private function parsePemegangHak($text)
    {
        preg_match('/1\.\s*Nama\s*:\s*([^\n]+)/', $text, $matches);
        $nama = trim($matches[1] ?? '');

        preg_match('/2\.\s*Kewarganegaraan\s*:\s*([^\n]+)/', $text, $matches);
        $kewarganegaraan = trim($matches[1] ?? '');

        preg_match('/3\.\s*Alamat\s*:\s*([^\n]+)/', $text, $matches);
        $alamat = trim($matches[1] ?? '');

        preg_match('/No\. HP & E-mail\s*:\s*([^&]+)/', $text, $matches);
        $email = trim($matches[1] ?? '');

        return [
            'nama' => $nama,
            'kewarganegaraan' => $kewarganegaraan,
            'alamat' => $alamat,
            'email' => $email,
        ];
    }
}
