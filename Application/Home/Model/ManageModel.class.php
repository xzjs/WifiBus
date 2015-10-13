<?php
namespace Home\Model;
use Think\Model;
use Org\Util\PHPExcel;
class ManageModel extends Model{
	public function read($filename,$encode='utf-8')
	{
		import("Org.Util.PHPExcel");
		import("Org.Util.PHPExcel.Writer.Excel5");
		import("Org.Util.PHPExcel.IOFactory.php");
		$inputFileType = \PHPExcel_IOFactory::identify($filename);
		
		$objReader = \PHPExcel_IOFactory::createReader($inputFileType);
		$objReader->setReadDataOnly(true);
		$objPHPExcel = $objReader->load($filename);
		$objWorksheet = $objPHPExcel->getActiveSheet();
		$highestRow = $objWorksheet->getHighestRow();
		$highestColumn = $objWorksheet->getHighestColumn();
		$highestColumnIndex = \PHPExcel_Cell::columnIndexFromString($highestColumn);
		$excelData = array();
		for ($row = 1; $row<= $highestRow;$row++){
			for ($col=0;$col<$highestColumnIndex;$col++) {
				$excelData[$row][]=(string)$objWorksheet->getCellByColumnAndRow($col,$row)->getValue();
			}
		}
		return $excelData;
	}

}