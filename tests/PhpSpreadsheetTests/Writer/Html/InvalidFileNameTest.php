<?php

namespace PhpOffice\PhpSpreadsheetTests\Writer\Html;

use PhpOffice\PhpSpreadsheet\Shared\File;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Writer\Exception as WriterException;
use PhpOffice\PhpSpreadsheet\Writer\Html;
use PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf;
use PhpOffice\PhpSpreadsheetTests\Functional;

class InvalidFileNameTest extends Functional\AbstractFunctional
{
    public function testEmptyFileName()
    {
        $this->expectException(WriterException::class);
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getActiveSheet()->getCell('A1')->setValue('Cell 1');
        $writer = new Html($spreadsheet);
        $writer->save('');
    }

    public function testEmptyFileNamePdf()
    {
        $this->expectException(WriterException::class);
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getActiveSheet()->getCell('A1')->setValue('Cell 1');
        $writer = new Mpdf($spreadsheet);
        $writer->save('');
    }

    public function testEmptyTempdirNamePdf()
    {
        $this->expectException(WriterException::class);
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getActiveSheet()->getCell('A1')->setValue('Cell 1');
        $writer = new Mpdf($spreadsheet);
        $writer->setFont('Helvetica');
        self::assertEquals('Helvetica', $writer->getFont());
        $writer->setPaperSize(PageSetup::PAPERSIZE_LEDGER);
        self::assertEquals($writer->getPaperSize(), PageSetup::PAPERSIZE_LEDGER);
        self::assertEquals(File::sysGetTempDir() . '/phpsppdf', $writer->getTempDir());
        $writer->setTempDir('');
    }

    public function testWinFileNames()
    {
        self::assertEquals('file:///C:/temp/filename.xlsx', Html::winFileToUrl('C:\\temp\filename.xlsx'));
        self::assertEquals('/tmp/filename.xlsx', Html::winFileToUrl('/tmp/filename.xlsx'));
        self::assertEquals('a:bfile', Html::winFileToUrl('a:bfile'));
    }
}
