<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Portal_DO_M extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}
	

	public function get_college_dept($username){
		$user = $this->db
	        ->select("first_name, last_name, college_dept")
	        ->where(
	             [
	                'username' => $username
	             ]
	         )
	        ->get("do_accounts")
	        ->row();

	   if ($user) {
		   	 $query = $this->db->get_where('school_years', array('active' => 1));
		   	 $year = $query->row();

	         $logindata = [
	             'first_name' => $user->first_name,
	             'last_name' => $user->last_name,
	             'college_dept' => $user->college_dept,
	         	  'school_year'		=> $year->school_year,
	         ];
	         $this->session
	              ->set_userdata($logindata);
	         return true;
	   }
	   else {
	         return false;
   		}
	}
	

	
	public function get_courses(){
		$college_dept = $this->session->college_dept;
		$query 		  = $this->db->get_where('portal_courses', array('college_dept' => $college_dept));
        return $query->result_array();
	}
	
	public function add_course($course, $years ,$abbrv){
		
		 $data = array(
            'course_name' => $course,
            'abbrv'	  	  => $abbrv,
            'college_dept'=> $this->session->college_dept,
            'years' 	  => $years,
           
        );

		return   $this->db->insert('portal_courses', $data);
	}

	public function add_subjects($subject_id, $description, $units, $sem, $year){
		$course_id	=$this->uri->segment(4);
		$curriculum_id = $this->uri->segment(5);
		 $data = array(
            'subj_code'   => $subject_id,
            'description' => $description,
            'no_units' 	  => $units,
            'sem' 	 	  => $sem,
            'year' 	 	  => $year,
            'college_dept'=> $this->session->college_dept,
            'course_id'	  => $course_id	,
           	'curriculum_id' => $curriculum_id	,
        );

		return   $this->db->insert('portal_subjects', $data);
	}

	public	function list_curriculums(){
		$college_dept = $this->session->college_dept;
		$id = $this->uri->segment(3);
		$query = $this->db->get_where('portal_curriculums', array('college_dept' => $college_dept ,  ));
		return $query->result_array();
	}

	public	function add_curriculum(){
		$course_id	=$this->uri->segment(4);
		$curriculum_id = $this->uri->segment(5);
		 $data = array(
            'course_id'	  => $course_id	,
            'curriculum_name' => $subject_id,
            'college_dept'=> $this->session->college_dept,
        );

		return   $this->db->insert('portal_curriculums', $data);
	}

	public function delete_curriculum($cu){
		if (isset($cu)) {
			$this->db->where('curriculum_id', $cu);
			$this->db->delete('portal_curriculums');
		}
		$this->db->where('curriculum_id', $cu);
		$this->db->delete('portal_subjects');

	}

	public function get_curriculum($id=null, $cu=null){
			
		$college_dept = $this->session->college_dept;
		$id = $this->uri->segment(3);
		$cu = $this->uri->segment(4);

		if ($id===0) {
			$query = $this->db->get_where('portal_curriculums', array('college_dept' => $college_dept));
	        return $query->result_array();
		}

		$query = $this->db->get_where('portal_curriculums', array('course_id' => $id, 'curriculum_id'=>$cu, 'college_dept'=>$college_dept));
        return $query->result_array();

	}

	public function get_year1_1(){
		$id = $this->uri->segment(3);
		$curriculum = $this->uri->segment(4);
		$query = $this->db->get_where('portal_subjects', array('course_id' => $id, 'curriculum_id' => $curriculum, 'year' => 1, 'sem' => 1));
		return $query->result_array();
	}

	public function get_year1_2(){
		$id = $this->uri->segment(3);
		$curriculum = $this->uri->segment(4);
		$query = $this->db->get_where('portal_subjects', array('course_id' => $id, 'curriculum_id' => $curriculum, 'year' => 1, 'sem' => 2));
		return $query->result_array();
	}

	public function get_year2_1(){
		$id = $this->uri->segment(3);
		$curriculum = $this->uri->segment(4);
		$query = $this->db->get_where('portal_subjects', array('course_id' => $id, 'curriculum_id' => $curriculum, 'year' => 2, 'sem' => 1));
		return $query->result_array();
	}

	public function get_year2_2(){
		$id = $this->uri->segment(3);
		$curriculum = $this->uri->segment(4);
		$query = $this->db->get_where('portal_subjects', array('course_id' => $id, 'curriculum_id' => $curriculum, 'year' => 2, 'sem' => 2));
		return $query->result_array();
	}

	public function get_year3_1(){
		$id = $this->uri->segment(3);
		$curriculum = $this->uri->segment(4);
		$query = $this->db->get_where('portal_subjects', array('course_id' => $id, 'curriculum_id' => $curriculum, 'year' => 3, 'sem' => 1));

		return $query->result_array();
	}

	public function get_year3_2(){
		$id = $this->uri->segment(3);
		$curriculum = $this->uri->segment(4);
		$query = $this->db->get_where('portal_subjects', array('course_id' => $id, 'curriculum_id' => $curriculum, 'year' => 3, 'sem' => 2));		
		return $query->result_array();
	}

	public function get_year4_1(){
		$id = $this->uri->segment(3);
		$curriculum = $this->uri->segment(4);
		$query = $this->db->get_where('portal_subjects', array('course_id' => $id, 'curriculum_id' => $curriculum, 'year' => 4, 'sem' => 1));
		return $query->result_array();
	}

	public function get_year4_2(){
		$id = $this->uri->segment(3);
		$curriculum = $this->uri->segment(4);
		$query = $this->db->get_where('portal_subjects', array('course_id' => $id, 'curriculum_id' => $curriculum, 'year' => 4, 'sem' => 2));
		return $query->result_array();
	}

}

/* End of file portal_DO_M.php */
/* Location: ./application/models/portal_DO_M.php */