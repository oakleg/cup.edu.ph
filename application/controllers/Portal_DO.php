<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Portal_DO extends CI_Controller {


	public function __construct()
	{
		parent::__construct();
		$this->load->library(array('ion_auth','form_validation'));
		$this->load->model('portal_do_m', 'do');
		$this->load->helper(array('url','language'));

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');

		$group='Deans_Office';
		if (!$this->ion_auth->in_group($group))
		{
			$this->session->set_flashdata('message', 'You must be a DO(Dean\'s Office) to view this page');
			echo "false group";
		}
		if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('dportal/login', 'refresh', 301);
		}
	}

	public function logout(){
		$logout=$this->ion_auth->logout();
		redirect('dportal/login','refresh',301);

	}

	public function index()
	{
		$data['title']="DO Portal";
		$this->load->view('portal/dportal/template/header',$data);
		$this->load->view('portal/dportal/template/menuBar');
		$this->load->view('portal/dportal/index');
		$this->load->view('portal/dportal/template/footer');
		$this->load->view('portal/dportal/template/js');
	}

	public function courses()
	{
		$data['get_courses'] = $this->do->get_courses();
		$data['title']="DO Portal";

		$this->load->view('portal/dportal/template/header',$data);
		$this->load->view('portal/dportal/template/menuBar');
		$this->load->view('portal/dportal/course/index', $data);
		$this->load->view('portal/dportal/template/footer');
		$this->load->view('portal/dportal/template/js');
	}
	
	public function list_curriculums($id=null, $cu=null)
	{
		$data['get_curriculum'] = $this->do->list_curriculums();

		$data['title']="DO Portal";

		$this->load->view('portal/dportal/template/header',$data);
		$this->load->view('portal/dportal/template/menuBar');
		$this->load->view('portal/dportal/curriculum/index', $data);
		$this->load->view('portal/dportal/template/footer');
		$this->load->view('portal/dportal/template/js');
	}

	public function delete_curriculum($id=null, $cu=null)
	{
		$url = $this->uri->segment(4) ;
		$cu	= $this->uri->segment(5);
		$this->do->delete_curriculum($cu);

		redirect(site_url('do/curriculums/'.$url ,'refresh'));
	}

	public function view_curriculum($id=null, $cu=null)
	{
		$data['get_year1_1'] = $this->do->get_year1_1();
		$data['get_year1_2'] = $this->do->get_year1_2();
		$data['get_year2_1'] = $this->do->get_year2_1();
		$data['get_year2_2'] = $this->do->get_year2_2();
		$data['get_year3_1'] = $this->do->get_year3_1();
		$data['get_year3_2'] = $this->do->get_year3_2();
		$data['get_year4_1'] = $this->do->get_year4_1();
		$data['get_year4_2'] = $this->do->get_year4_2();

		$this->load->view('portal/dportal/template/header',$data);
		$this->load->view('portal/dportal/template/menuBar');
		$this->load->view('portal/dportal/curriculum/list_subjects', $data);
		$this->load->view('portal/dportal/template/footer');
		$this->load->view('portal/dportal/template/js');
	}


	public function addCourse(){
	
		//validate form input
		
		$this->form_validation->set_rules( 'course', 'Course', 'trim|required|is_unique[portal_courses.course_name]', array('is_unique' => 'This Course Name already exists. Please choose another one.')); 
		$this->form_validation->set_rules('years', 'Year', 'trim|required|numeric|min_length[1]');
		$this->form_validation->set_rules('abbrv', 'Abbriviation', 'trim|required'); 

		if($this->form_validation->run() === false){
			$this->load->view('portal/do/add_course');
		}
		else{
			$course = $this->input->post('course') ;
			$years = $this->input->post('years') ;
			$abbrv = $this->input->post('abbrv') ;
			
			$this->do->add_course($course, $years ,$abbrv);
			redirect('do/courses','refresh');
		}
	}

	public function addSubjects($id=null, $cu=null){
		$url = $this->uri->segment(4) ;
		$cu	= $this->uri->segment(5);
		//validate form input
		$this->form_validation->set_rules( 'subject_id[]', 'Subject ID', 'trim|required|is_unique[portal_subjects.subj_code]', array('is_unique' => 'This Course Name already exists. Please choose another one.')); 
		$this->form_validation->set_rules('description[]', 'Description', 'trim|required'); 
		$this->form_validation->set_rules('units[]', 'Number of Units', 'trim|required'); 
		$this->form_validation->set_rules('sem[]', 'Number of Units', 'trim|required'); 
		$this->form_validation->set_rules('year[]', 'Year', 'trim|required|numeric|min_length[1]');

		if($this->form_validation->run() == false){
			$this->load->view('portal/do/add_subject', array('url' => $url , 'cu' => $cu  ));
		}
		else{
			$limit = $this->input->post('count');	
			$count = 0;
		
			do {
				$subject_id = $this->input->post('subject_id['.$count.']') ;
				$description = $this->input->post('description['.$count.']') ;
				$units = $this->input->post('units['.$count.']') ;
				$sem = $this->input->post('sem['.$count.']') ;
				$year = $this->input->post('year['.$count.']') ;

				$this->do->add_subjects($subject_id, $description, $units, $sem, $year);
				$count++;

			} while ($count<$limit);
			
			redirect('do/curriculum/'.$url.'/'.$cu ,'refresh');
		}
	}

	public function upload_subject(){
		$url = $this->uri->segment(4) ;
		$cu	= $this->uri->segment(5);

		$config['upload_path'] 		= './uploads/subjects/';
		$config['allowed_types']	= 'xls|xlsx';

		$this->upload->initialize($config);

		if (!$this->upload->do_upload('userFile'))
		{		
            $data = array('error' => $this->upload->display_errors());
		
			$this->load->view('portal/do/upload_subject', $data);
		}
		else
		{
			$file_name = $this->upload->data('file_name');

			$file = './uploads/subjects/'.$file_name;
			//load the excel library
			$this->load->library('excel');
			$objReader = PHPExcel_IOFactory::createReader('Excel2007');
			$objReader->setReadDataOnly(TRUE);
			$excelReader = PHPExcel_IOFactory::createReaderForFile($file);
			$excelObj = $excelReader->load($file);
			$worksheet = $excelObj->getSheet(0);
			$lastRow = $worksheet->getHighestRow();
			
			//NILOOP MO DITO YUNG CELLS SA EXCEL FILE
			for ($row = 3; $row <= $lastRow; $row++) {
				$cellA = $worksheet->getCell('A'.$row)->getValue();
				$cellB = $worksheet->getCell('B'.$row)->getValue();
				$cellC = $worksheet->getCell('C'.$row)->getValue();
				$cellD = $worksheet->getCell('D'.$row)->getValue();
				$cellE = $worksheet->getCell('E'.$row)->getValue();
				$this->do->add_subjects($cellA ,$cellB ,$cellC ,$cellD ,$cellE );
			}
		
			redirect(site_url('do/curriculum/'.$url.'/'.$cu ,'refresh'));
		}
	}
}

/* End of file portal_DO.php */
/* Location: ./application/controllers/portal_DO.php */