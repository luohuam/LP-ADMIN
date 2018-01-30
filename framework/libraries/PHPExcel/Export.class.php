<?php

require_once('PHPExcel.php');
require_once('PHPExcel/IOFactory.php');
require_once('PHPExcel/Reader/Excel5.php');
set_time_limit(0);

class Export
{
	
	public static function Exportuser($data)
	{
		// Create new PHPExcel object
	
		$objPHPExcel = new \PHPExcel();
	
		// Set document properties
		$objPHPExcel->getProperties()->setCreator("WX")
		->setLastModifiedBy("WX")
		->setTitle("Office 2007 XLSX Test Document")
		->setSubject("Office 2007 XLSX Test Document")
		->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
		->setKeywords("office 2007 openxml php")
		->setCategory("data file");

		//set width  
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
	
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A1', '编号')
		->setCellValue('B1', '活动主题')
		->setCellValue('C1', '单位')
		->setCellValue('D1', '使用场地')
		->setCellValue('E1', '活动人数')
		->setCellValue('F1', '预约人')
		->setCellValue('G1', '预约人电话')
		->setCellValue('H1', '使用时间')
		->setCellValue('I1', '录入时间',\PHPExcel_Cell_DataType::TYPE_STRING);
	
		$dat=$data['data'];
	
		for ($i = 0;$i < count($dat); $i++){
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A'.($i+2), $dat[$i]['num'])
			->setCellValue('B'.($i+2), $dat[$i]['title'])
			->setCellValue('C'.($i+2), $dat[$i]['danwei'])
			->setCellValue('D'.($i+2), $dat[$i]['place'])
			->setCellValue('E'.($i+2), $dat[$i]['people'])
			->setCellValue('F'.($i+2), $dat[$i]['user'])
			->setCellValue('G'.($i+2), $dat[$i]['phone'])
			->setCellValue('H'.($i+2), $dat[$i]['date'].' '.$dat[$i]['start'].'-'.$dat[$i]['end'])
			->setCellValue('I'.($i+2), $dat[$i]['created']);
		}
	
		// Rename worksheet
		$objPHPExcel->getActiveSheet()->setTitle('list');
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);
		// 		$objPHPExcel->ini_set("memory_limit", "1024M"); // 不够继续加大
		// 		$objPHPExcel->set_time_limit(0);
		// Redirect output to a client’s web browser (Excel2007)
		@header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		@header('Content-Disposition: attachment;filename="Output.xls"');
		@header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		@header('Cache-Control: max-age=10');
		
		// If you're serving to IE over SSL, then the following may be needed
		@header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		@header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		@header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		@header ('Pragma: public'); // HTTP/1.0
		@header("Content-type: text/csv");
		$objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		
		exit();
	
	}
	
	public static function Import($file)
	{
		$basePath=\yii::$app->basePath.'/web'.$file;
	
		@chmod($basePath, 0777);
		@chmod($basePath,0755);
	
		//echo $basePath;exit;
	
		//$inputFileName = '/extra_disk/jit/web/res/xls/test.xlsx'.$file;
		$inputFileName = $basePath;
		$objPHPExcel = \PHPExcel_IOFactory::load($inputFileName);
// 		$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
// 		foreach ($sheetData as $item)
// 		{
// 			$model = new Student();
// 			$model->name = $item['A'];
// 			$model->call_name = $item['B'];
// 			$model->phone = $item['C'];
// 			$model->ke = $item['D'];
// 			$model->created = $item['E'];
// 			$model->save();
// 		}
		$sheet = $objPHPExcel->getSheet(0);
		$highestRow = $sheet->getHighestRow(); // 取得总行数
		
		// $highestColumn = $sheet->getHighestColumn(); // 取得总列数
		
		//循环读取excel表格,读取一条,插入一条
		//j表示从哪一行开始读取  从第二行开始读取，因为第一行是标题不保存
		//$a表示列号
		for($j=2;$j<=$highestRow;$j++)
		{
			$a = $objPHPExcel->getActiveSheet()->getCell("A".$j)->getValue();//获取A(业主名字)列的值
			$b = $objPHPExcel->getActiveSheet()->getCell("B".$j)->getValue();//获取B(密码)列的值
			$c = $objPHPExcel->getActiveSheet()->getCell("C".$j)->getValue();//获取C(手机号)列的值
			$d = $objPHPExcel->getActiveSheet()->getCell("D".$j)->getValue();//获取D(地址)列的值
			$e = $objPHPExcel->getActiveSheet()->getCell("E".$j)->getValue();//获取D(地址)列的值
		
			$model = new Student();
			$model->name = "$a";
			$model->call_name = "$b";
			$model->phone = "$c";
			$model->ke = "$d";
			$model->created = $e;
			$model->save();
			
			if(!$model->save()){
				var_dump($model->errors);
			}
		}
	}
	
	function ExcelIn(){
		//判断表格是否上传成功
		if (is_uploaded_file($_FILES['file_stu']['tmp_name'])) {	
			$objReader = \PHPExcel_IOFactory::createReader('Excel5');//use excel2007 for 2007 format
			//接收存在缓存中的excel表格
			$filename = $_FILES['file_stu']['tmp_name'];
			$objPHPExcel = $objReader->load($filename); //$filename可以是上传的表格，或者是指定的表格
			$sheet = $objPHPExcel->getSheet(0);
			$highestRow = $sheet->getHighestRow(); // 取得总行数
			// $highestColumn = $sheet->getHighestColumn(); // 取得总列数
	
			//循环读取excel表格,读取一条,插入一条
			//j表示从哪一行开始读取  从第二行开始读取，因为第一行是标题不保存
			//$a表示列号
			for($j=2;$j<=$highestRow;$j++)
			{
				$a = $objPHPExcel->getActiveSheet()->getCell("A".$j)->getValue();//获取A(业主名字)列的值
				$b = $objPHPExcel->getActiveSheet()->getCell("B".$j)->getValue();//获取B(密码)列的值
				$c = $objPHPExcel->getActiveSheet()->getCell("C".$j)->getValue();//获取C(手机号)列的值
				$d = $objPHPExcel->getActiveSheet()->getCell("D".$j)->getValue();//获取D(地址)列的值
				$e = $objPHPExcel->getActiveSheet()->getCell("E".$j)->getValue();//获取D(地址)列的值
				
				$model = new Student();
				$model->name = $a;
				$model->call_name = $b;
				$model->phone = $c;
				$model->ke = $d;
				$model->created = $e;
				$model->save();
			}
		}
	}
}