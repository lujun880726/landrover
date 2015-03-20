<?php
/**
 * PhpExcelToArray
 * 提取Excel文件里面的数据保存到数据里面
 */
class PHPExcelToArray{

private $sFileName;

function __construct($sFileName){
	$this->sFileName = $sFileName;
}

public function getExcelData($iSheetNumber=0){

    $sExt = strrchr($this->sFileName,'.');
	switch ($sExt) {
		case '.xls':
			$sExcelName = 'Excel5';
			break;
		case '.xlsx':
			$sExcelName = 'Excel2007';
			break;
		default:
			return FALSE;
			break;
	}
        $sDirName = dirname(__FILE__) . '/';
	require_once $sDirName.'PHPExcel.php';
	require_once $sDirName.'PHPExcel/IOFactory.php';
	require_once $sDirName.'PHPExcel/Reader/'.$sExcelName.'.php';
	/*Excel5 for 2003 excel2007 for 2007*/
	$objReader = PHPExcel_IOFactory::createReader($sExcelName);
	//Excel 路径
	$objPHPExcel = $objReader->load($this->sFileName);
	$oSheet = $objPHPExcel->getSheet($iSheetNumber);
	// 取得总行数
	$highestRow = $oSheet->getHighestRow();
	// 取得总列数
	$highestColumn = $oSheet->getHighestColumn();
	//总列数
	$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
	$aOutArray = array();
	for ($row = 0;$row <= $highestRow;$row++)         {
		$aInArray=array();
		//注意highestColumnIndex的列数索引从0开始
		for ($col = 0;$col < $highestColumnIndex;$col++){
			$aInArray[$col] =$oSheet->getCellByColumnAndRow($col, $row)->getValue();
		}
		$aOutArray[$row] = $aInArray;
	}
	array_shift($aOutArray);
        array_shift($aOutArray);
	return $aOutArray;
}

}
