<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once FCPATH  ."application/third_party/Classes/PHPExcel.php";
//require_once FCPATH  .'application/third_party/Classes/PHPExcel/IOFactory.php';

class Excelread extends MY_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('user', '', TRUE);
        $this->load->model('inquiry_model', '', TRUE);
        $this->load->helper('url');	
		$this->load->model('Blog_model');
    }

	public function index()
	{
		error_reporting(0);
		set_time_limit(0);
		if(isset($_FILES) && !empty($_FILES)){
			require_once FCPATH  ."application/third_party/Classes/PHPExcel/IOFactory.php";
			$str = base_url();
			$arr = explode("/",$str);
			$key = max(array_keys($arr));

			$file_path = APPPATH . '../files';
			
			$name= rand(1111,9999).'_'.$_FILES["xls_files"]["name"];
			$type= $_FILES["xls_files"]["type"];
			$size= $_FILES["xls_files"]["size"];
			$temp= $_FILES["xls_files"]["tmp_name"];
			$error= $_FILES["xls_files"]["error"];

			if ($error > 0)
				die("Error uploading file! code $error.");
			else
			{
				move_uploaded_file($temp, $file_path.'/'.$name);
			}

			$objPHPExcel = PHPExcel_IOFactory::load($file_path.'/'.$name);
			$cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
			foreach ($cell_collection as $cell) {
				$column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
				$row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
				$data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
				
				if ($row == 1) {
					$header[$row][$column] = $data_value;
				} else {
					$arr_data[$row-1][$column] = $data_value;
				}
			}
			$data['header'] = $header;
			$data['values'] = $arr_data;
			
			$error = array();
			$i = 0;
			foreach($header as $fieldkey=>$fieldvalue){
				if(
				    $fieldvalue['A'] == 'Reference No' && $fieldvalue['B'] == 'Agent' 
					&& $fieldvalue['C'] == 'Rent Price â‚¬' && $fieldvalue['D'] == 'Common expenses ( 1 - incl. common expenses, 0- Plus common expenses )' 
					&& $fieldvalue['E'] == 'Selling Price â‚¬' && $fieldvalue['F'] == 'VAT ( 1 - No V.A.T, 0 â€“ Plus V.A.T )' 
					&& $fieldvalue['G'] == 'Address' && $fieldvalue['H'] == 'City' 
					&& $fieldvalue['I'] == 'City Area' && $fieldvalue['J'] == 'Property Type' 
					&& $fieldvalue['K'] == 'Property Status (Sale / Rent / Both)' && $fieldvalue['L'] == 'Furnished Type' 
					&& $fieldvalue['M'] == 'Size of rooms' && $fieldvalue['N'] == 'Bedrooms' 
					&& $fieldvalue['O'] == 'Bathrooms' && $fieldvalue['P'] == 'Kitchen' 
					&& $fieldvalue['Q'] == 'URL Link1' && $fieldvalue['R'] == 'URL Link2' 
					&& $fieldvalue['S'] == 'URL Link3' && $fieldvalue['T'] == 'Covered area (mÂ²)' 
					&& $fieldvalue['U'] == 'Uncovered area: (mÂ²)' && $fieldvalue['V'] == 'Plot/land area (mÂ²)' 
					&& $fieldvalue['W'] == 'Description' && $fieldvalue['X'] == 'Pets'
					&& $fieldvalue['Y'] == 'Architectural Design' && $fieldvalue['Z'] == 'Make Year' 
					&& $fieldvalue['AA'] == 'General Facility' && $fieldvalue['AB'] == 'Electronics Faciliteis'
					&& $fieldvalue['AC'] == 'Owner Name' && $fieldvalue['AD'] == 'Owner Surname'
					&& $fieldvalue['AE'] == 'Company Name' && $fieldvalue['AF'] == 'Mobile' && $fieldvalue['AG'] == 'E-Mail'
					)
				{
					$tablefor_result = "true";	
				}else{
					$tablefor_result = "false";
				}
					
				foreach ($data['values'] as $key => $value) {
         			$city_id = $this->Blog_model->get_city($value['H']);
         			
         			$city_area_id = $this->Blog_model->get_city_area($city_id, $value['I']);
         			

         			$rs_userid = $this->Blog_model->get_adduser($value,$city_id);


         			 $prop_type = array('1'=>'Duplex','2' =>'Apartment','3' =>'Penthouse','4' =>'Garden Apartments','5'=>'Studio','6' =>'Townhouse','7' =>'Villa','8' =>'Bungalow','9'=>'Land','10' =>'Shop','11' =>'Office','12' =>'Business','13'=>'Hotel','14' =>'Restaurant','15' =>'Building','16' =>'Industrial estate','17' =>'House','18' =>'Upper-House','19' =>'Maisonette');

         			$propkey = array_search("".$value['J']."", $prop_type);

					$propsell_type = array('1'=>'Sale','2' =>'Rent','3' =>'Both');         			
         			$proprty_typekey = array_search("".$value['K']."", $propsell_type);

					$furnished_type = array('1'=>'Furnished','2' =>'semi-Furnished','3' =>'Un-Furnished');
         			$furnished_typekey = array_search("".$value['L']."", $furnished_type);

         			$pets_type = array('0'=>'Allowed','1' =>'Not Allowed');
         			$pets_typekey = array_search("".$value['X']."", $pets_type);

         			$artich_design = array('1'=>'Contemporary','2' =>'Modern','3' =>'Classic');
         			$artich_designkey = array_search("".$value['Y']."", $artich_design);

         			$size_rm = array('1'=>'Small','2' =>'Medium','3' =>'Large');
         			$size_rmkey = array_search("".$value['M']."", $size_rm);


         			if (!empty($value['Q'])) {
         				$link_str = $value['Q'].',';
         			}
         			if (!empty($value['R'])) {
         				$link_str .= $value['R'].',';
         			}
         			if (!empty($value['S'])) {
         				$link_str .= $value['S'].',';
         			}
         			$link_str = rtrim($link_str, ",");
         			

         			$country_id1 = $this->Blog_model->get_country_code($value['AF']);

         			$value['AA'] = explode(",", $value['AA']);
         			$value['AB'] = explode(",", $value['AB']);

         			$data_prop = array(
         				'reference_no' => $value['A'],
         			 	'agent_id' => $rs_userid, 
         			 	'rent_price' => $value['C'], 
         			 	'rent_val' => $value['D'], 
         			 	'sale_price' => $value['E'],
         			 	'sale_val' => $value['F'], 
         				'address' => $value['G'],
         				'city_id' => $city_id, 
         				'city_area' => $city_area_id, 
         				'property_type' => $propkey, 
         				'type' => $proprty_typekey,
         				'furnished_type' => $furnished_typekey, 
         				'room_size'=> $size_rmkey, 
         				'bedroom'=> $value['N'], 
         				'bathroom'=> $value['O'], 
         				'kitchen'=> $value['P'], 
         				'kitchen'=> $value['P'], 
         				'url_link' => $link_str, 
         				'cover_area' =>$value['T'],
         				'uncover_area' =>$value['U'], 
         				'plot_lan_area' =>$value['V'], 
         				'short_decs' =>$value['W'], 
         				'pets'=> $pets_typekey,
         				'architectural_design'=> $artich_designkey,
         				'make_year'=> $value['Z'],
         				'fname'=> $value['AC'],
         				'lname'=> $value['AD'],
         				'compny_name'=> $value['AE'],
         				'coutry_code'=> $country_id1,
         				'mobile'=> $value['AG'],
         				'email'=>$value['AH'],
         				'created_date'=>date('Y-m-d H:i:s'),
         				'updated_date'=>date('Y-m-d H:i:s')
         				);
						
						$property_id = $this->Blog_model->propertyinsert_entry($data_prop);
         				
         				//$delete_id = $this->Blog_model->delete_fecelity($property_id);
         				
         				/*if (!empty($value['AA'])) {
         					foreach ($value['AA'] as $generaldatakey => $generaldatavalue) 
         					{
         						$generalfec_id = $this->Blog_model->insert_facilities($generaldatavalue,$property_id,'1');
         					}
         				}
         				if (!empty($value['AB'])) {
         					foreach ($value['AB'] as $elecdatakey => $elecdatavalue) 
         					{
         						$elecfec_id = $this->Blog_model->insert_facilities($elecdatavalue,$property_id,'2');
         					}
						}*/
				}
				 unlink($file_path.'/'.$name);
				 redirect('home/property_manage');
			}
		}else{
			redirect('home/property_manage');
			//$this->load->view('excel_reader');
		}
	}
	public function inquire_export()
	{

		error_reporting(0);
		set_time_limit(0);
		$this->load->helper('url');	
		$this->load->model('Blog_model');
		
		if(isset($_FILES) && !empty($_FILES)){

			require_once FCPATH  ."application/third_party/Classes/PHPExcel/IOFactory.php";		
			$str = base_url();

			$arr = explode("/",$str);
			$key = max(array_keys($arr));

			$file_path = APPPATH . '../files';

			$name= rand(1111,9999).'_'.$_FILES["inquire_xls_files"]["name"];
			$type= $_FILES["inquire_xls_files"]["type"];
			$size= $_FILES["inquire_xls_files"]["size"];
			$temp= $_FILES["inquire_xls_files"]["tmp_name"];
			$error= $_FILES["inquire_xls_files"]["error"];

			if ($error > 0)
				die("Error uploading file! code $error.");
			else
			{
				move_uploaded_file($temp, $file_path.'/'.$name);
			}

			$objPHPExcel = PHPExcel_IOFactory::load($file_path.'/'.$name);
			$cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
			foreach ($cell_collection as $cell) {
				$column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
				$row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
				$data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
				
				if ($row == 1) {
					$header[$row][$column] = $data_value;
				} else {
					$arr_data[$row-1][$column] = $data_value;
				}
			}
			$data['header'] = $header;
			$data['values'] = $arr_data;
			
			$error = array();
			$i = 0;
			foreach($header as $fieldkey=>$fieldvalue){
				if(
				       $fieldvalue['A'] == 'Date (dd/mm/yyyy)' && $fieldvalue['B'] == 'First Name' 
					&& $fieldvalue['C'] == 'Last Name' && $fieldvalue['D'] == 'Mobile' 
					&& $fieldvalue['E'] == 'Pass Over (Yes / No)' && $fieldvalue['F'] == 'Name Of Agent' 
					&& $fieldvalue['G'] == 'Area' && $fieldvalue['H'] == 'Bathrooms' 
					&& $fieldvalue['I'] == 'Bedrooms' && $fieldvalue['J'] == 'Furnished Type' 
					&& $fieldvalue['K'] == 'Property Status' && $fieldvalue['L'] == 'Property Type' 
					&& $fieldvalue['M'] == 'Reference Number' && $fieldvalue['N'] == 'Budget Min € ' 
					&& $fieldvalue['O'] == 'Budget Max €')
				{
					$tablefor_result = "true";	
				}else{
					$tablefor_result = "false";	
				}
			}		
			
			foreach ($data['values'] as $key => $value) {
	         	if ((empty($value['E'])) && (empty($value['F']))) {

	         	}else
	         	{

	         		$value['E'] = trim($value['E']);

	         		$country_id1 = $this->Blog_model->get_country_code($value['D']);
	         			
	         		if (!empty($country_id1)) {
	         			$country_id1 = $country_id1[0]->id;
	         		}else{
	         			$country_id1 = "24";
	         		}
	         			
	         		$value['country_id1'] = $country_id1;

	         		$value['A'] = trim($value['A']);

					//excel date convert to php date
					$PHPTimeStamp = PHPExcel_Shared_Date::ExcelToPHP($value['A']);
					$value['A'] = date('Y-m-d',$PHPTimeStamp);

	         		if (!empty($value['I'])) {
	         			$area_id1 = $this->Blog_model->get_area($value['I']);
	         			$value['area_id1'] = $area_id1;
	         		}
         			else{
         				$area_id1 = "";
         				$value['area_id1'] = "";
         			}

         			if (!empty($value['J'])) {
         				$area_id2 = $this->Blog_model->get_area($value['J']);
         				$value['area_id2'] = $area_id2;
         			}else{
         				$area_id2 = "";
         				$value['area_id2'] = "";
         			}

         			if (!empty($value['K'])) {
         				$area_id3 = $this->Blog_model->get_area($value['K']);
         				$value['area_id3'] = $area_id3;
         			}else{
         				$area_id3 = "";
         				$value['area_id3'] = "";
         			}
         			if (!empty($value['L'])) {
         				$area_id4 = $this->Blog_model->get_area($value['L']);
         				$value['area_id4'] = $area_id4;
         			}else{
         				$area_id4 = "";
         				$value['area_id4'] = "";
         			}
	         			
         			$customer_id = $this->Blog_model->get_inquirecustomer($value);
         			$value['customer_id'] = $customer_id;

         			$agent_id = "";
         			if ($value['G'] == "Yes") {
						$agent_id = $this->Blog_model->get_inquireuser($value['H'],$value['A']);
         			}
         			$value['agent_id'] = $agent_id;
						
         			if (empty($value['Q'])) {
         				$propkey = "";
         			}else{
         				 $prop_type = array('1'=>'Duplex','2' =>'Apartment','3' =>'Penthouse','4' =>'Garden Apartments','5'=>'Studio','6' =>'Townhouse','7' =>'Villa','8' =>'Bungalow','9'=>'Land','10' =>'Shop','11' =>'Office','12' =>'Business','13'=>'Hotel','14' =>'Restaurant','15' =>'Building','16' =>'Industrial estate','17' =>'House','18' =>'Upper-House','19' =>'Maisonette');
         				$propkey = array_search("".$value['Q']."", $prop_type);
         			}

         			if (empty($value['P'])) {
         				$proprty_typekey = "";
         			}else{
         				$propsell_type = array('1'=>'Sale','2' =>'Rent','3' =>'Both');         			
         				$proprty_typekey = array_search("".$value['P']."", $propsell_type);
         			}

         			if (empty($value['O'])) {
         				$furnished_typekey = "";
         			}else{
         				$furnished_type = array('1'=>'Furnished','2' =>'semi-Furnished','3' =>'Un-Furnished');
         				$furnished_typekey = array_search("".$value['O']."", $furnished_type);
					}
						
					$value['R']  = trim($value['R']);
					$ref = array();
					if (!empty($value['R'])) {
						if (stripos($value['R'], "/") == true){
							$ref = explode('/', $value['R']);
						}elseif (stripos($value['R'], "-") == true) {
							$ref = explode('-', $value['R']);
						}
						elseif (stripos($value['R'], ",") == true) {
							$ref = explode(',', $value['R']);
						}
						elseif (stripos($value['R'], " ") == true) {
							$ref = explode(' ', $value['R']);
						}
						else{
							$ref[0] = $value['R'];
						}
					}
         			else{
         				//$ref[0] = $this->unic_inquiry_prop_refconf_num();
         				$ref[0] =  array();
         			}
         				if (count($ref) > 1) {
         					$propid = $this->Blog_model->get_inquire_property($data_prop);
							if ($propid == -1) {
								$propid = "";
							}
         					if ($propid == -1) {
								$propid = "";
							}

							if($this->session->userdata('logged_in_super_user')){
						            $sessionData = $this->session->userdata('logged_in_super_user');
						            $created_id = $sessionData['id'];
						    }
						    if($this->session->userdata('logged_in_agent')){
						            $sessionData = $this->session->userdata('logged_in_agent');
						            $created_id = $sessionData['id'];
						    }

						    if($this->session->userdata('logged_in_employee')){
						            $sessionData = $this->session->userdata('logged_in_employee');
						            $id = $sessionData['id'];
						            $created_id = $sessionData['id'];
						    }else{
						            $id="";
						    }
         					$inquiry_num = $this->unic_inquiry_num();
							
							$data_inquire = array(
	         				'customer_id' => $customer_id,
	         				'property_ref_no' => $refvalue,
	         				'incquiry_ref_no' => $inquiry_num,
	         			 	'property_id' => $propid,
	         			 	'agent_id' => $agent_id, 
	         				'created_date' => $value['A'],
	         				'updated_date' => $value['A'],
	         				'created_by' => $created_id
	         				);
							
							$inquireid = $this->Blog_model->get_inquire_inquiredata($data_inquire);

							$data_inquiry_details = array(
							'inquiry_id' => $inquireid,
							'city_area' => $area_id1.",".$area_id2.",".$area_id3.",".$area_id4,
							'bathroom' => $value['M'],
							'badroom' => $value['N'],
							'reference_no' => $refvalue,
							//'furnished_type'=> $furnished_typekey,
							'property_status' => $proprty_typekey,
							'property_type' => $furnished_typekey,
	         				'minprice' => $value['S'],
	         			 	'maxprice' => $value['T'],
	         				'created_date' => $value['A'],
	         				'updated_date' => $value['A']
	         				);

							$inquire_detid = $this->Blog_model->insertdata($data_inquiry_details,'inquiry_history');
							
         				}else{
						foreach ($ref as $refkey => $refvalue) {
							
							$refvalue = trim($refvalue);
	         				$data_prop = array(
	         				'reference_no' => $refvalue,
	         			 	'agent_id' => $agent_id,
	         			 	'city_id' => '1', 
	         				'city_area' => $area_id1,
	         				'property_type' => $propkey, 
	         				'type' => $proprty_typekey,
	         				'furnished_type' => $furnished_typekey, 
	         				'bedroom'=> $value['N'], 
	         				'bathroom'=> $value['M'],
	         				'fname'=> $value['B'],
	         				'lname'=> $value['C'],
	         				'coutry_code'=> '7840',
	         				'mobile'=> $value['E'],
	         				'created_date'=>$value['A']
	         				);

	         				
							$propid = $this->Blog_model->get_inquire_property($data_prop);
							if ($propid == -1) {
								$propid = "";
							}

							if($this->session->userdata('logged_in_super_user')){
						            $sessionData = $this->session->userdata('logged_in_super_user');
						            $created_id = $sessionData['id'];
						    }
						    if($this->session->userdata('logged_in_agent')){
						            $sessionData = $this->session->userdata('logged_in_agent');
						            $created_id = $sessionData['id'];
						    }

						    if($this->session->userdata('logged_in_employee')){
						            $sessionData = $this->session->userdata('logged_in_employee');
						            $id = $sessionData['id'];
						            $created_id = $sessionData['id'];
						    }else{
						            $id="";
						    }
							
							$inquiry_num = $this->unic_inquiry_num();
							
							$data_inquire = array(
	         				'customer_id' => $customer_id,
	         				'property_ref_no' => $refvalue,
	         				'incquiry_ref_no' => $inquiry_num,
	         			 	'property_id' => $propid,
	         			 	'agent_id' => $agent_id, 
	         				'created_date' => $value['A'],
	         				'created_by' => $created_id
	         				);
							
							$inquireid = $this->Blog_model->get_inquire_inquiredata($data_inquire);

							$data_inquiry_details = array(
							'inquiry_id' => $inquireid,
							'city_area' => $area_id1.",".$area_id2.",".$area_id3.",".$area_id4,
							'bathroom' => $value['M'],
							'badroom' => $value['N'],
							'reference_no' => $refvalue,
							//'furnished_type'=> $furnished_typekey,
							'property_status' => $proprty_typekey,
							'property_type' => $furnished_typekey,
	         				'minprice' => $value['S'],
	         			 	'maxprice' => $value['T'],
	         				'created_date' => $value['A'],
	         				'updated_date' => $value['A']
	         				);

							$inquire_detid = $this->Blog_model->insertdata($data_inquiry_details,'inquiry_history');
							
						}
					}
				}
				
			}
				 unlink($file_path.'/'.$name);

				redirect('inquiry/inquiry_manage');	 
			//}
		}else{
			
			redirect('inquiry/inquiry_manage');
			//$this->load->view('inqire_excelreader');
		}
	}
	function unic_inquiry_num() {
        $inquiry_num = rand(10000000,99999999);
        $unic_number = $this->inquiry_model->check_unic_inquiry_num($inquiry_num);
        if(!empty($unic_number))
        {
           $this->unic_inquiry_num();
        }
        else
        {
           return $inquiry_num;
        }
    }
    function unic_inquiry_prop_refconf_num() {
        $inquiry_prop_num = rand(10000000,99999999);

        $unic_prop_number = $this->Blog_model->check_unic_prop_refno_num($inquiry_prop_num);

                if(!empty($unic_prop_number)){
                   $this->unic_inquiry_prop_refconf_num();
                }else{
                   return $inquiry_prop_num;
                }
    }

    function export_data(){
    	require_once FCPATH  ."application/third_party/Classes/PHPExcel/IOFactory.php";
    	$objPHPExcel = new PHPExcel(); 
    	$objPHPExcel->setActiveSheetIndex(0); 
		// Initialise the Excel row number
		$rowCount = 1; 
		// Iterate through each result from the SQL query in turn
		// We fetch each database result row into $row in turn
		//while($row = mysql_fetch_array($result)){ 
		    // Set cell An to the "name" column from the database (assuming you have a column called name)
		    //    where n is the Excel row number (ie cell A1 in the first row)
		    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, "kaushik"); 
		    $objPHPExcel->getActiveSheet()->SetCellValue('A2', "kaushik111"); 

		    // Set cell Bn to the "age" column from the database (assuming you have a column called age)
		    //    where n is the Excel row number (ie cell A1 in the first row)
		    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, "kothiya"); 
			$objPHPExcel->getActiveSheet()->SetCellValue('B2', "kothiya111"); 
		    // Increment the Excel row counter
		    //$rowCount++; 
		//} 

		// Instantiate a Writer to create an OfficeOpenXML Excel .xlsx file
		// Redirect output to a client’s web browser (Excel5) 
		header('Content-Type: application/vnd.ms-excel'); 
		header('Content-Disposition: attachment;filename="Limesurvey_Results.xls"'); 
		header('Cache-Control: max-age=0'); 
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
		$objWriter->save('php://output');
    }
}
?>