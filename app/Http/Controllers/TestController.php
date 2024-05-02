<?php

namespace App\Http\Controllers;
use PhpOffice\PhpWord\IOFactory;

class TestController extends Controller
{
    public function test()
    {
        $file1path = 'test/file1.docx';
        $file1=IOFactory::load($file1path);
        $sections = $file1->getSections();
        dd($sections);
//        $file2path = 'test/file2.docx';
//        $newFile = 'test/file3.docx';
//        $mergedZip = new ZipArchive();
//        $mergedZip->open('test/file2.docx', ZipArchive::CREATE);
//
//        $dm = new DocxMerge();
//        $dm->merge( [
//            $file1path,
//            $file2path
//        ], $newFile);
    }
}
