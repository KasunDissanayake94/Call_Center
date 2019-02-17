<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class TeleModel extends CI_Model {
    public function fetchMainGroups($userid)
    {
        $this->db->select('main_group.id,main_group.title,main_group.user_id');
        $this->db->from('main_group');
        $this->db->join('user', 'user.id=main_group.user_id', 'inner');
        $this->db->where('user.id', $userid);
        $query = $this->db->get();
        return $query;
    }
    public function fetchGroupMembers($id)
    {
        $this->db->where('group_id', $id);
        $this->db->select('student.id,student.first_name,student.last_name,student.email,student.mobile_number,student.residence_number,main_group_allocation.answered_or_not_answered,main_group_allocation.comment,main_group_allocation.commentTime');
        $this->db->from('main_group');
        $this->db->join('main_group_allocation', 'main_group_allocation.group_id=main_group.id', 'inner');
        $this->db->join('student', 'student.id=main_group_allocation.student_id', 'inner');

        $query = $this->db->get();
        return $query;
    }
    public function getQuestionnaireId($group_id){
        $this->db->where('group_id',$group_id);
        $this->db->select('questionnaire_id');
        $group_data = $this->db->get('main_group_questionnaire');
        if($group_data->num_rows() > 0)
        {
            return $group_data->row(0)->questionnaire_id;
        }
        return false;
    }
    public function getQuestionnaireIds($group_id){
        $this->db->select('main_group_questionnaire.questionnaire_id,questionnaire.title');
        $this->db->from('main_group_questionnaire');
        $this->db->join('questionnaire', 'main_group_questionnaire.questionnaire_id=questionnaire.id');
        $this->db->where('main_group_questionnaire.group_id',$group_id);      
        $questions = $this->db->get();
        return $questions->result_array();

    }

    public function getFormFields($questionnaire_id){

        $this->db->select('*');
        $this->db->from('keys_table');
        $this->db->join('question','question.key_id=keys_table.id');
        $this->db->join('form_element','form_element.id=keys_table.form_element_id');
        $this->db->join('element','element.id=form_element.element_id');
        $this->db->where('question.questionnaire_id', $questionnaire_id);


//        $this->db->select('key_id');
//        $this->db->where('form_id', $form_id);
        $key_data = $this->db->get();



        if($key_data->num_rows() > 0)
        {
            // we will store the results in the form of class methods by using $q->result()
            // if you want to store them as an array you can use $q->result_array()
            foreach ($key_data->result() as $row)
            {
                $data[] = $row;
            }
            return $data;
        }
    }
    public function add_Student_Data($first_name,$last_name,$email,$mobile_number,$residence_number,$address,$event_id){
        $data = array(
            'first_name'=>$first_name,
            'last_name'=>$last_name,
            'email'=>$email,
            'mobile_number'=>$mobile_number,
            'residence_number'=>$residence_number,
            'address'=>$address,
            'event_id'=> $event_id
        );

        $this->db->insert('student',$data);
        return $this->db->insert_id();
    }

    public function add_Student_Ex_Data($id,$var1,$value,$insertion_type,$user_id){
        $keyavailable = $this->keyAvailable($id,$var1);
        if($keyavailable){
            if($value){
            $data = array(
                'student_id'=>$id,
                'key'=>$var1,
                'value'=>$value,
                'type'=>$insertion_type,
                'user_id'=>$user_id,
    
            );
            $this->db->where('student_id',$id)->where('key',$var1);
            $this->db->update('student_ex', $data);
            return ($this->db->affected_rows() != 1) ? false : true;
            }

        }else{
            $data = array(
                'student_id'=>$id,
                'key'=>$var1,
                'value'=>$value,
                'type'=>$insertion_type,
                'user_id'=>$user_id,
    
            );
    
            $this->db->insert('student_ex',$data);
            return ($this->db->affected_rows() != 1) ? false : true;
        }
        

    }
    public function keyAvailable($sid,$key){
        $where = "student_id=$sid AND key=$key";
        $this->db->select('student_id,key');
        $this->db->where('student_id',$sid)->where('key',$key);
        $query = $this->db->get('student_ex');
        if($query->num_rows() > 0)
        {   
            return true;
        }else{
            return false;
        }
    }
    public function get_Additional_Fields($questionnaire_id){
        $this->db->select('keys_table.name');
        $this->db->from('keys_table');
        $this->db->join('question','question.key_id=keys_table.id');
        $this->db->where('question.questionnaire_id', $questionnaire_id);
        $key_data = $this->db->get();

        if($key_data->num_rows() > 0)
        {
            // we will store the results in the form of class methods by using $q->result()
            // if you want to store them as an array you can use $q->result_array()
            foreach ($key_data->result() as $row)
            {
                $data[] = $row;
            }
            return $data;
        }



    }
    public function studentDuplicate($sid){
        $this->db->select('*');
        $this->db->from('student');
        $this->db->where('id',$sid);      
        $questions = $this->db->get();
        return $questions->result_array();

    }
    public function callAnswered($sid,$group_id){
        $where = "student_id=$sid AND group_id=$group_id";
        $this->db->set('answered_or_not_answered', 1);
        $this->db->where($where);
        $this->db->update('main_group_allocation');
    }
    public function callNotAnswered($sid){
        $this->db->set('answered_or_not_answered', 0);
        $this->db->where('id',$sid);
        $this->db->update('student');
    }
    public function groupTitle($id){
        $this->db->select('title');
        $this->db->from('main_group');
        $this->db->where('id',$id);
        $query = $this->db->get();
        return $query->row_array();
    }
    public function addFollowup($id,$user_id){
        $follow = $this->input->post('followup');
        $array= $this->followupNames();
        $emp = array();
        foreach($follow as $rec){
            $rec=$rec-1;
            $x = $array[$rec]['name'];
            array_push($emp, $x );
        }
        $str = implode(', ', $emp);
        $data = array(
            'student_id' => $id,
            'user_id'  => $user_id,
            'remark'  => $this->input->post('remark'),
            'followups'  => $str,
            'time'  => $this->input->post('time'),
            'date'  => $this->input->post('date')
        );
        $this->db->insert('remark',$data);
        $remark_id = $this->db->insert_id();
        foreach($follow as $rec){
            $data = array(
                'remark_id' => $remark_id,
                'follow_id' => $rec
            );
            $this->db->insert('remark_followup',$data);
        }
    }
    
    public function addLead($id){
        $lead = $this->input->post('lead');
        if ($lead==1){
            $this->db->set('response', 1);
        }else{
            $this->db->set('response', 0);
        }  
        $this->db->where('id',$id);
        $this->db->update('student');
    }
    
    public function get_followups(){
        $query = $this->db->get('followup');
        return $query->result_array();
    }
    public function followupNames(){
        $this->db->select('*');
        $query = $this->db->get('followup');
        return $query->result_array();
    }
    //comment
    public function addComment($gid,$sid,$comment){
        $data = array(
            'comment'=>$comment,
            'commentTime'=>date('Y-m-d G:i:s', mktime(date("G")+5, date("i")+30, date("s"), date("m"), date("d"), date("Y")))
        );
        $this->db->where('student_id',$sid)->where('group_id',$gid);
        $this->db->update('main_group_allocation',$data);
    }

}
