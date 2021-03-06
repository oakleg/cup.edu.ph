<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Portal_DO_M extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}
	
	//assign schedule
	public function setAssignSched($faculty_id, $id_sched)
	{	

		$data = array(
			'faculty_id' => $faculty_id,
			'id_sched'   => $id_sched,
			);
		return $this->db->insert('portal_schedules_assigned', $data);
	}

	//info
	public function get_specific($id)
	{
		$this->db->select('*');
		$this->db->from('portal_schedules_assigned');
		$this->db->join('portal_schedules', 'portal_schedules_assigned.id_sched = portal_schedules.id_sched');
		$this->db->where('portal_schedules_assigned.faculty_id', $id);
		
		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_coursename($id)
	{
		$query = $this->db->get_where('portal_courses', array('course_id' => $id , ));
		$row = $query->row();

		if (isset($row))
		{
	        return $row->course_name;
		}
	}

	public function registerStudent($username, $first_name, $mi, $last_name, $course, $college_dept)
	{
		$data = array(
           'id'     => $username,
 		   'first_name'	  => $first_name,
 		   'middle_initial'=> $mi,
 		   'last_name'	  => $last_name,
 		   'course'		  => $course,
 		   'college_dept' => $college_dept,
            
        );

        return $this->db->insert('students_informations', $data);
	}

	public function registerSection($id, $section_id, $course_id)
	{

		$string = $section_id;
		preg_match_all('!\d!', $string, $matches);
		$year = (int)implode('',$matches[0]);
		
		$data = array(
            'section' => $section_id,
            'year'	=> $year
        );

        $this->db->where('id', $id);
        return $this->db->update('students_informations', $data);
	}

	//faculty sched
	public function get_assigned()
	{	
		$course = $this->uri->segment(3);
		$section_name = $this->uri->segment(4);
		$college_dept = $this->session->college_dept;
		$query = $this->db->get_where('portal_schedules', array('course_id' => $course, 'section' => $section_name, 'college_dept'=> $college_dept));
		return $query->result_array();
	}

	public function get_sections($course)
	{
		$college_dept = $this->session->college_dept;

		$query = $this->db->query('SELECT MIN(id_sched) AS id_sched,section FROM portal_schedules WHERE college_dept= "'.$college_dept.'" AND course_id="'.$course.'" GROUP BY section');

		return $query->result_array();
	}

	public function get_schedules($course , $section_name)
	{
		$college_dept = $this->session->college_dept;
		$query = $this->db->get_where('portal_schedules', array('course_id' => $course, 'section' => $section_name, 'college_dept'=> $college_dept));
		return $query->result_array();
	}

	//setting the session
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
	         	 'sem'		=> $year->sem,
	         ];
	         $this->session
	              ->set_userdata($logindata);
	         return true;
	   }
	   else {
	         return false;
   		}
	}
	
	public function insert_sched($cellA, $cellB, $cellC, $cellD, $year, $section, $course_id){
		$data = array(
            'year'   => $year,
            'subject_code' => $cellA,
            'description' => $cellB,
            'days' 	 	  => $cellC,
            'time' 	 	  => $cellD,
            'section'	  => $section,
            'college_dept'=> $this->session->college_dept,
            'course_id'	  => $course_id	,
        );

		return   $this->db->insert('portal_schedules', $data);
	}
	
	public function delete_class($course, $section_name, $id)
	{	
		$items = array(
				'id_sched' 		=> $id,
				'course_id' => $course ,
				'section'   => $section_name , 
				);

		return $this->db->delete('portal_schedules', $items);
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
		$query = $this->db->get_where('portal_curriculums', array('college_dept' => $college_dept , 'course_id' => $id  ));
		return $query->result_array();
	}

	public	function add_curriculum($curriculum_name){
		$course_id	=$this->uri->segment(4);
		
		$data = array(
            'course_id'	  => $course_id	,
            'curriculum_name' => $curriculum_name,
            'college_dept'=> $this->session->college_dept,
        );

		if($this->db->insert('portal_curriculums', $data)){
			$this->db->select_max('curriculum_id');
			$query = $this->db->get('portal_curriculums');
			$row = $query->row();
			
			$id = $row->curriculum_id;
			return $id;
		}
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