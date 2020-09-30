<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Load library phpspreadsheet
require($_SERVER['DOCUMENT_ROOT'].'/logistik/assets/excel/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
// End load library phpspreadsheet

class Excel 
{


    // Load 
    private $spreadsheet, $header=array(), $sheetName, $judul, $fileName, $created_by;

    public function __construct()
    {
        $this->spreadsheet = new Spreadsheet();
    }

    function _setter($params=array()) {
        $this->header = $params['header'];
        $this->sheetName = $params['sheetName'];
        $this->judul = $params['judul'];
        $this->fileName = $params['fileName'];
        $this->created_by = $params['createdBy'];

        // Set document properties
        $this->spreadsheet->getProperties()->setCreator($this->created_by)
        ->setLastModifiedBy($this->created_by)
        ->setTitle($this->judul)
        ->setSubject('Pegawai Terdampak')
        ->setDescription('Daftar Pegawai Terdampak')
        ->setKeywords('pegawai logistik terdampak')
        ->setCategory('Excel');

    }

    // Export ke excel
    public function export($data, $header, $sheetName, $fileName, $title, $createdBy)
    {

        //Setter;
       // $this->_setter($);
        

        $styleArray = [
			'borders' => [
				'allBorders' => [
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
				],
			],
        ];
        
        
        $this->spreadsheet->setActiveSheetIndex(0);

        // Tambah Header Kolom
        $kol = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");
        $i = 0;
        while ($i < count($header)) {
           $this->spreadsheet->setActiveSheetIndex(0)->setCellValue($kol[$i].'1', $header[$i]);
           $this->spreadsheet->getActiveSheet()->getStyle($kol[$i].'1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('c7c7c7');
           $this->spreadsheet->getActiveSheet()->getStyle($kol[$i].'1')->applyFromArray($styleArray);
            $i++;
        }
        

        // Isi Data
        $i=2;
        $v=0; 
        foreach($data as $key => $dt) {
           foreach($dt as $val) {
               
                $this->spreadsheet->getActiveSheet()->getCell($kol[$v].$i)->setValueExplicit(strval($val), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                //Atur lebar kolom biar ga ada yang kepotong
                $this->spreadsheet->getActiveSheet()->getColumnDimension($kol[$v])->setAutoSize(true);
                $this->spreadsheet->getActiveSheet()->getStyle($kol[$v].$i)->applyFromArray($styleArray);
                $v++;
            }
        $v=0;
        $i++;
        }

        // Rename worksheet
       $this->spreadsheet->getActiveSheet()->setTitle($sheetName);

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
       $this->spreadsheet->setActiveSheetIndex(0);

       

        // Redirect output to a client’s web browser (Xlsx)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$fileName.'".xlsx"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $writer = IOFactory::createWriter($this->spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;
		
    }
}