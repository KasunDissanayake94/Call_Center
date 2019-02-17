<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class teleController extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->model('teleModel');
    }

    public function teleGroups(){
        $userid = $this->session->userdata('user_id');
        $this->load->model('teleModel');
        $data['main_groups'] = $this->teleModel->fetchMainGroups($userid);

        $this->load->view('TeleGroups', $data);
    }
    public function teleViewGroup()
    {
        if($this->input->get())
        {
            $group_id= $this->input->get('group_id');
            $data['gid'] = $this->input->get('group_id');


            $this->load->model('teleModel');
            $data['members'] = $this->teleModel->fetchGroupMembers($group_id);

            $this->load->view('TeleViewGroup', $data);
        }
        
    }
    function userEdit(){

        if($this->input->get()){
            $id = $this->input->get('userid');
            $data['userid'] = $this->input->get('userid');
            $group_id= $this->input->get('group_id');
            $this->load->model('teleModel');
            $data['followups'] = $this->teleModel->get_followups();
            // $questionnaire_id =$this->teleModel->getQuestionnaireId($group_id);
            $questions = $this->teleModel->getQuestionnaireIds($group_id);
            $data['qdetails'] = $this->teleModel->getQuestionnaireIds($group_id);
            $data['qid'] = $this->teleModel->getQuestionnaireId($group_id);
            $data['gid'] = $this->input->get('group_id');
            $this->load->model('Student_search_model');
            $data['student_data'] = $this->Student_search_model->edit_Student($id);
            $data['student_ex_data'] = $this->Student_search_model->edit_Student_Ex($id);
            $fields = array();
            if($questions){
                foreach ($questions as $row)
                {
                    $var = $row['questionnaire_id'];
                    $array = $this->teleModel->getFormFields($var);
                    array_push($fields, $array );
                    $data['form_field_result'] = $fields;
                }
            }
            $this->load->view('TeleEditStudent',$data);


        }

}

public function addStudentManually(){
    $group_id = $this->input->post('gid');
    $id = $this->input->post('userid');
    $user_id = $this->session->userdata('user_id');
    $data['student_id'] = $this->input->post('userid');
    $this->teleModel->callAnswered($id,$group_id);
    $this->teleModel->addFollowup($id,$user_id);
    $this->teleModel->addLead($id);
    $this->load->model("teleModel");
    $sid = $this->input->post('userid');
    $qids = $this->teleModel->getQuestionnaireIds($group_id);
    // $additional_fields = array();
    // $additional_fields_values = array();

    $first_name = $this->input->post('first_name');
    $last_name = $this->input->post('last_name');
    $email = $this->input->post('email');
    $mobile_number = $this->input->post('mob_number');
    $residence_number = $this->input->post('res_number');
    $address = $this->input->post('address');

    $event_id = 1;
    $insertion_type = 0;    //No 1 is Manually Insertion Data No 2 is Insert Data from Excel Sheet
    $count = 0;
    //Add data to the Student Table
    $this->load->model('teleModel');
    // $result_row = $this->teleModel->add_Student_Data($first_name,$last_name,$email,$mobile_number,$residence_number,$address,$event_id);
    $count = $id;
    $fields = array();
    foreach ($qids as $row)
            {
                $var = $row['questionnaire_id'];
                $array = $this->teleModel->get_Additional_Fields($var);
                array_push($fields, $array );
                
            }
    
    foreach($fields as $list){
        if($list){
        foreach($list as $row){
        if($row){
            $var = $row->name;
                $var1 = strtolower(str_replace(" ","_",$var));
                $value = $this->input->post($var1);
                $real_value = '';
                    if (is_array($value)){
                        foreach ($value as $item){
                            $real_value = $real_value.$item.'_';
                        }
                        $value = $real_value;

                    }
                //Add data to Student Ex table
                $message = $this->teleModel->add_Student_Ex_Data($id,$var,$value,$insertion_type,$user_id);
        }

    
        }
    }
    }
    if($message){
		$this->session->set_flashdata('formSuccess', '<div class="alert alert-success  text-center">  Successfully Added The Details!</div>');
		
	 }
     $this->userDetail($id,$group_id);  


}
function userDetail($id,$group_id){
        $this->load->model('Student_search_model');
        $data['student_data'] = $this->Student_search_model->edit_Student($id);
        $data['student_ex_data'] = $this->Student_search_model->edit_Student_Ex($id);
        $data['group_id'] = $group_id;
        $this->load->view('ViewStudent',$data);



}
function viewStudentDetails(){
    $id = $this->input->get('sid');
    $group_id = $this->input->get('group_id');
    $this->load->model('Student_search_model');
    $data['student_data'] = $this->Student_search_model->edit_Student($id);
    $data['student_ex_data'] = $this->Student_search_model->edit_Student_Ex($id);
    $data['group_id'] = $group_id;
    $this->load->view('ViewStudent',$data);

}
//comment
public function addComment()
        {   $group_id = $this->input->post('gid');
            $sid = $this->input->post('sid');
            $comment = $this->input->post('comment');
            $this->teleModel->addComment($group_id,$sid,$comment);
            $this->teleViewGroup2($group_id,$sid);
            
        }
        public function teleViewGroup2($group_id,$sid)
    {
            
            $data['gid'] = $group_id;
            $this->load->model('teleModel');
            $data['members'] = $this->teleModel->fetchGroupMembers($group_id);

            $this->load->view('TeleViewGroup', $data);
        
        
    }

}