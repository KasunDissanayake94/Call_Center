<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class AdminModel extends CI_Model {
    public function register_User($firstname,$lastname,$email,$type,$contact_number,$password,$image_url){

        $data = array(
            'first_name'=>$firstname,
            'last_name'=>$lastname,
            'email'=>$email,
            'type'=>$type,
            'contact_number'=>$contact_number,
            'img_url'=>$image_url
        );

        $this->db->insert('user',$data);

        return ($this->db->affected_rows() != 1) ? false : true;
    }
    public function delete_User($user_id){

        $data = array(
            'flag' => 0,

        );

        $this->db->where('id', $user_id);
        $this->db->update('user', $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }
    public function edit_User($user_id){
        $this->db->where('id', $user_id);
        $this->db->select('id,first_name,last_name,email,type,contact_number');
        $user_data = $this->db->get('user');
        if($user_data->num_rows() > 0)
        {
            // we will store the results in the form of class methods by using $q->result()
            // if you want to store them as an array you can use $q->result_array()
            foreach ($user_data->result() as $row)
            {
                $data[] = $row;
            }
            return $data;
        }
    }
    public function edit_User_Final($id,$firstname,$lastname,$email,$type,$contact_number,$password){
        $data1 = array(
            'type' => $type,
            'password' => $password
        );

        $this->db->where('user_id', $id);
        $this->db->update('user_role', $data1);

        $data = array(
            'first_name'=>$firstname,
            'last_name'=>$lastname,
            'contact_number'=>$contact_number,
            'email'=>$email,
            'type'=>$type,
        );
        $this->db->where('id', $id);
        $this->db->update('user', $data);



        return ($this->db->affected_rows() != 1) ? false : true;
    }

    //Assign User to database
    public function assign_User($uid,$username,$password,$type){
        $data = array(
            'user_id'=>$uid,
            'username'=>$username,
            'password'=>$password,
            'type'=>$type,

        );

        $this->db->insert('user_role',$data);

        return ($this->db->affected_rows() != 1) ? false : true;
    }
    public function assign_ExUserwithPassword($uid,$username,$password){

        $data = array(
            'uid'=>$uid,
            'userName'=>$username,
            'password'=>$password,

        );
        $this->db->where('username', $username);
        $this->db->update('user_role', $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function select()
    {
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get('user_details');
        return $query;
    }

    public function insert($data)
    {
        $this->db->insert_batch('student', $data);
        return $this->db->insert_id();
    }
    public function insert_additional_data($data){

        $this->db->insert_batch('student_ex', $data);
    }
    public function selectForms(){

        $this->db->select('title,id');
        $user_data = $this->db->get('form');
        if($user_data->num_rows() > 0)
        {
            // we will store the results in the form of class methods by using $q->result()
            // if you want to store them as an array you can use $q->result_array()
            foreach ($user_data->result() as $row)
            {
                $data[] = $row;
            }
            return $data;
        }
    }
    public function selectFormsForSelectedEvent($event_id){

        $this->db->select('form.title,form.id');
        $this->db->from('form');
        $this->db->join('event_form','event_form.form_id=form.id','Left');
        $this->db->where('event_form.event_id', $event_id);
        $user_data = $this->db->get();

        if($user_data->num_rows() > 0)
        {
            // we will store the results in the form of class methods by using $q->result()
            // if you want to store them as an array you can use $q->result_array()
            foreach ($user_data->result() as $row)
            {
                $data[] = $row;
            }
            return $data;
        }


    }
    public function selectEventNames(){

        $this->db->select('title,id');
        $user_data = $this->db->get('events');
        if($user_data->num_rows() > 0)
        {
            // we will store the results in the form of class methods by using $q->result()
            // if you want to store them as an array you can use $q->result_array()
            foreach ($user_data->result() as $row)
            {
                $data[] = $row;
            }
            return $data;
        }
    }
    public function createEvent($name,$date,$venue,$file_name){

        $data = array(
            'title'=>$name,
            'date'=>$date,
            'venue'=>$venue,
            'form_id'=>$file_name,

        );

        $this->db->insert('events',$data);

        return $this->db->insert_id();
    }
    
    public function assignEventToForm($event,$form){
        $data = array(
            'event_id'=>$event,
            'form_id'=>$form,
        );

        $this->db->insert('event_form',$data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }
    //get all keys for the perticular form
    public function getKeys($form_id){
        $this->db->select('keys_table.name');
        $this->db->from('keys_table');
        $this->db->join('form_field','form_field.key_id=keys_table.id','Left');
        $this->db->where('form_field.form_id', $form_id);
        return $this->db->get();


    }
    
    //Form Convert to Fixed .Cannot Delete Form
    public function assignFormFixed($form_id){
        $data = array('used' => 1);
        $this->db->where('id', $form_id);
        $this->db->update('form', $data);

        return ($this->db->affected_rows() != 1) ? false : true;
    }
    //Get the Foem Name
    public function getFormName($form_id){
        $this->db->where('id',$form_id);
        $this->db->select('title');
        $user_data = $this->db->get('form');
        if($user_data->num_rows() > 0)
        {
            return $user_data->row(0)->title;
        }
        return false;
    }
    //To get all the Form Fields of selected form
    public function getFormFields($form_id){

        $this->db->select('keys_table.name,form_element.id,element.title,form_element.options');
        $this->db->from('keys_table');
        $this->db->join('form_field','form_field.key_id=keys_table.id');
        $this->db->join('form_element','form_element.id=keys_table.form_element_id');
        $this->db->join('element','element.id=form_element.element_id');
        $this->db->where('form_field.form_id', $form_id);


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

    public function get_Additional_Fields($form_id){
        $this->db->select('keys_table.name');
        $this->db->from('keys_table');
        $this->db->join('form_field','form_field.key_id=keys_table.id');
        $this->db->where('form_field.form_id', $form_id);
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
    public function add_Student_Data($title,$first_name,$last_name,$email,$mobile_number,$residence_number,$address,$event_id){
        $data = array(
            'title'=>$title,
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

    public function add_Student_Ex_Data($count,$var1,$value,$insertion_type){
        $data = array(
            'student_id'=>$count,
            'key'=>$var1,
            'value'=>$value,
            'type'=>$insertion_type,

        );

        $this->db->insert('student_ex',$data);
        return ($this->db->affected_rows() != 1) ? false : true;

    }

    public function check_Duplicates($mobile_number,$residence_number){
        
        if(!$mobile_number){

            $where = "mobile_number=$residence_number OR residence_number=$residence_number";

            
        }else if(!$residence_number){
            
            $where = "mobile_number=$mobile_number OR residence_number=$mobile_number";

        }else{
            
            $where = "mobile_number=$mobile_number OR residence_number=$residence_number OR mobile_number=$residence_number OR residence_number=$mobile_number";
        }
        
        $this->db->select('id');


        $this->db->where($where);
        $user_data = $this->db->get('student');
        if($user_data->num_rows() > 0)
        {
            // we will store the results in the form of class methods by using $q->result().
            // if you want to store them as an array you can use $q->result_array()
            foreach ($user_data->result() as $row)
            {
                $data[] = $row;
            }
            return $data;
        }

    }
    //Check Ex details duplicates
    public function check_Ex_Duplicates($id,$key,$value){

        $this->db->where('student_id',$id);
        $this->db->or_where('key',$key);
        $this->db->or_where('value',$value);
        $this->db->select('id');
        $user_data = $this->db->get('student_ex');
        if($user_data->num_rows() > 0)
        {
            return $user_data->row(0)->id;
        }
        return false;


    }
 //Check Extra entered options from Excel and add them to options
    public function check_option($check_element_name,$check_element_value){
        $this->db->select('form_element.options,form_element.id,form_element.element_id');
        $this->db->from('form_element');
        $this->db->join('keys_table','keys_table.form_element_id=form_element.id');
        unset($array);
        $array = array('keys_table.name' => $check_element_name);
        $this->db->where($array);
        $key_data = $this->db->get();
        if($key_data->num_rows() > 0){
            foreach ($key_data->result() as $row)
            {
                if (strpos(strtolower($row->options), strtolower($check_element_value)) !== false){

                }else{
                    $options = $row->options.$check_element_value.'_';
                    $data=array('options'=>$options);
                    $this->db->where('id',$row->id);
                    $this->db->update('form_element',$data);


                }
            }
        }else{
            return 0;
        }
    }
    public function update_Extra_duplicate_Fields($id,$key,$value){
        $this->db->where('student_id',$id);
        $this->db->or_where('key',$key);
        $this->db->select('*');
        $user_data = $this->db->get('student_ex');
        if($user_data->num_rows() > 0)
        {
            return false;
        }else{
            $data = array(
                'student_id'=>$id,
                'key'=>$key,
                'value'=>$value,
                'type'=>1,
            );
            $this->db->insert('student_ex',$data);
            return true;
        }


    }
    public function update_duplicate_fields($id,$first_name,$last_name,$email,$address){
        $data = array('first_name' => $first_name,'last_name' => $last_name, 'email' => $email , 'address'=> $address );
        $this->db->where('id', $id);
        $this->db->update('student', $data);

        return ($this->db->affected_rows() != 1) ? false : true;

    }

    public function selectFormsForEvent(){
        $this->db->select("*");
        $this->db->from("form");

        $this->db->order_by('id', 'DESC');
        $result_data =  $this->db->get();

        if($result_data->num_rows() > 0)
        {
            // we will store the results in the form of class methods by using $q->result().
            // if you want to store them as an array you can use $q->result_array()
            foreach ($result_data->result() as $row)
            {
                $data[] = $row;
            }
            return $data;
        }
    }
    public function selectEventList(){
        $this->db->select("*");
        $this->db->from("events");

        $this->db->order_by('id', 'DESC');
        $result_data =  $this->db->get();

        if($result_data->num_rows() > 0)
        {
            // we will store the results in the form of class methods by using $q->result().
            // if you want to store them as an array you can use $q->result_array()
            foreach ($result_data->result() as $row)
            {
                $data[] = $row;
            }
            return $data;
        }
    }
    
///////////////////////////////////thanushi

    //fetch events

    public function fetchEvents()
    {
        $this->db->select('*');
        $this->db->from('events');

        $query = $this->db->get();
        return $query;
    }

    //fetch event participants

    public function fetchEventparticipants($event_id)
    {
        
        $this->db->select('student.id,student.first_name,student.last_name,student.email,student.mobile_number,student.residence_number,student.address,main_group_allocation.group_id');
        $this->db->from('student');
        $this->db->join('main_group_allocation', 'main_group_allocation.student_id=student.id', 'left');
        $this->db->where('student.event_id', $event_id);

        $query = $this->db->get();
        return $query;
    }

    //fetch single event
    

    public function fetchSingleEvent($id)
    {
        $this->db->where('id', $id);
        $this->db->select('*');
        $query = $this->db->get('events');
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row)
            {
                $data[] = $row; 
            }
            return $data;
        }
    }

    public function fetchTLEs()
    {
        $this->db->select('user.id,user.first_name,user.last_name,user.contact_number,user.email,user.img_url,user.flag');
        $this->db->from('user_role');
        $this->db->join('user','user.id=user_role.user_id', 'left');
        $this->db->where('user.type', 'Tele Marketing Executive');

        $query = $this->db->get();
        return $query;
    }

    public function fetchUsers()
    {
        $this->db->select('user.id,user.first_name,user.last_name,user.contact_number,user.email,user.img_url,user.flag');
        $this->db->from('user_role');
        $this->db->join('user','user.id=user_role.user_id', 'left');
        $this->db->where('user.type', 'Tele Marketing Executive');
        $this->db->or_where('user.type', 'Course Counselor');

        $query = $this->db->get();
        return $query;
    }

    public function fetchCourseCounselors()
    {
        $this->db->select('user.id,user.first_name,user.last_name,user.contact_number,user.email,user.img_url,user.flag');
        $this->db->from('user_role');
        $this->db->join('user','user.id=user_role.user_id', 'left');
        $this->db->where('user.type', 'Course Counselor');

        $query = $this->db->get();
        return $query;
    }

    public function fetchTleGroups($user_id)
    { 
        $this->db->where('user_id', $user_id);
        $this->db->select('id,title');

        $query = $this->db->get('main_group');
        return $query;
    }

    public function fetchMainGroups()
    {   
        $this->db->where('main_group.project_id !=', 0);
        $this->db->select('main_group.id,main_group.project_id,main_group.title,main_group.user_id,user.first_name,user.last_name');
        $this->db->from('main_group');
        $this->db->join('user', 'user.id=main_group.user_id', 'left');

        $query = $this->db->get();
        return $query;
    }
    
    public function fetchLeadsGroups()
    {
        $this->db->where('main_group.project_id', 0);
        $this->db->select('main_group.id,main_group.title,main_group.user_id,user.first_name,user.last_name');
        $this->db->from('main_group');
        $this->db->join('user', 'user.id=main_group.user_id', 'left');

        $query = $this->db->get();
        return $query;
    }

    public function fetchOtherMainGroups($group_id)
    {
        $this->db->where('main_group.id !=', $group_id);
        $this->db->select('main_group.id,main_group.title,main_group.user_id,user.first_name,user.last_name');
        $this->db->from('main_group');
        $this->db->join('user', 'user.id=main_group.user_id', 'left');

        $query = $this->db->get();
        return $query;
    }

    public function fetchGroupMembers($id)
    {
        $this->db->where('group_id', $id);
        $this->db->select('student.id,student.first_name,student.last_name,student.email,student.mobile_number');
        $this->db->from('main_group');
        $this->db->join('main_group_allocation', 'main_group_allocation.group_id=main_group.id', 'inner');
        $this->db->join('student', 'student.id=main_group_allocation.student_id', 'inner');

        $query = $this->db->get();
        return $query;
    }

    public function fetchSubGroupMembers($id)
    {
        $this->db->where('group_id', $id);
        $this->db->select('student.id,student.first_name,student.last_name,student.email,student.mobile_number');
        $this->db->from('sub_group');
        $this->db->join('sub_group_allocation', 'sub_group_allocation.group_id=sub_group.id', 'inner');
        $this->db->join('student', 'student.id=sub_group_allocation.student_id', 'inner');

        $query = $this->db->get();
        return $query;
    }

    public function changeTme($user_id, $group_id)
    {
        $data = array(
            'user_id' => $user_id,
        );

        $this->db->where('id', $group_id);
        $this->db->update('main_group', $data);
    }

    public function changeCC($user_id, $group_id)
    {
        $data = array(
            'user_id' => $user_id,
        );

        $this->db->where('id', $group_id);
        $this->db->update('sub_group', $data);
    }

    public function fetchTmeName($id)
    {
        $this->db->where('id', $id);
        $this->db->select('first_name,last_name');
        $query = $this->db->get('user');
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row)
            {
                $tme_name = $row->first_name." ".$row->last_name;
            }
            
            return $tme_name;
        }
    }

    public function fetchMainGroupTmeName($group_id)
    {
        $this->db->where('main_group.id', $group_id);
        $this->db->select('user.first_name,user.last_name');
        $this->db->from('main_group');
        $this->db->join('user', 'user.id=main_group.user_id', 'inner');

        $query = $this->db->get();

        if($query->num_rows() > 0)
        {
            foreach($query->result() as $row)
            {
                $tme_name = $row->first_name." ".$row->last_name;
            }
            return $tme_name;
        }
    }

    public function fetchSubGroupCCName($group_id)
    {
        $this->db->where('sub_group.id', $group_id);
        $this->db->select('user.first_name,user.last_name');
        $this->db->from('sub_group');
        $this->db->join('user', 'user.id=sub_group.user_id', 'inner');

        $query = $this->db->get();

        if($query->num_rows() > 0)
        {
            foreach($query->result() as $row)
            {
                $tme_name = $row->first_name." ".$row->last_name;
            }
            return $tme_name;
        }
    }

    public function removeStudentsOfMG($student_id)
    {
        foreach($student_id as $selected)
        {

            $this->db->where('student_id', $selected);
            $this->db->delete('main_group_allocation');
            
            $this->db->where('id', $selected);
            $this->db->set('tme_group', 0);
            $this->db->update('student');
        }
    }

    public function removeStudentsOfLG($student_id, $group_id)
    {
        foreach($student_id as $selected)
        {
            $this->db->where('student_id', $selected);
            $this->db->delete('main_group_allocation');
            
            $this->db->where('id', $selected);
            $this->db->set('leads_group', 0);
            $this->db->update('student');
        }
        
       
    }

    public function moveStudentsMG($new_gid,$student_id)
    {
        foreach($student_id as $selected)
        {
            $this->db->where('student_id', $selected);
            $this->db->delete('main_group_allocation');
        }

        foreach($student_id as $selected)
        {
            $data = array(
                'group_id' => $new_gid,
                'student_id' => $selected
            );
    
            $this->db->insert('main_group_allocation', $data);
        }
    }


   public function fetchAllStudents()
    {
        $this->db->select('student.id,student.first_name,student.last_name,student.email,student.mobile_number,student.residence_number,student.address,student.tme_group,main_group_allocation.group_id');
        $this->db->from('student');
        $this->db->join('main_group_allocation', 'main_group_allocation.student_id=student.id', 'left');

        $query = $this->db->get();
        return $query;
    }
    
    public function fetchLeads()
    {
        $this->db->where('response', 1);
        $this->db->select('*');

        $query = $this->db->get('student');
        return $query;
    }
    
    public function insertLeads($student_id, $group_id)
    {
        foreach($student_id as $selected)
        {
            $this->db->set('leads_group', $group_id);
            $this->db->where('id', $selected);
            $this->db->update('student');
        }
    }
    

    public function fetchSubGroups()
    {
        $this->db->select('sub_group.id,sub_group.title,sub_group.user_id,user.first_name,user.last_name');
        $this->db->from('sub_group');
        $this->db->join('user', 'user.id=sub_group.user_id', 'left');

        $query = $this->db->get();
        return $query;
    }

    public function fetchKeys()
    {
        $this->db->select('*');
        $this->db->from('keys_table');

        $query = $this->db->get();
        return $query;
    }

    public function filterOptions($criteria)
    {
        $this->db->select('student_ex.value,keys_table.id');
        $this->db->from('student_ex');
        $this->db->distinct('student_ex.value');
        $this->db->join('keys_table', 'keys_table.name=student_ex.key', 'inner');
        $this->db->where_in('keys_table.id', $criteria);

        $query = $this->db->get();
        return $query;
    }

    public function fetchKeyName($id)
    {
        $this->db->where('id', $id);
        $this->db->select('name');
        $query = $this->db->get('keys_table');

        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row)
            {
                $key_name = $row->name;
            }
            
            return $key_name;
        }
    
    }

    public function fetchFilteredStudents($sql)
    {
        $query = $this->db->query($sql);

      return $query;
    }


    //create new main group
    public function newMainGroup($title, $user_id)
    {
        $this->db->from('main_group');
        $this->db->like('title', $title);
        
        $groups = $this->db->count_all_results()+1;
        $concad = '-Group '.$groups;

        $title = $title.$concad;
        
        $data = array
        (
            'title' => $title,
            'user_id' => $user_id
        );

        $this->db->insert('main_group', $data);

        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    // public function createGroup($title, $user_id, $event_id, $filter_criteria, $filter_type)
    // {
    //     $data = array
    //     (
    //         'title' => $title,
    //         'user_id' => $user_id,
    //         'event_id' => $event_id,
    //         'filter_criteria' => $filter_criteria,
    //         'filter_type' => $filter_type
    //     );

    //     $this->db->insert('main_group', $data);

    //     $insert_id = $this->db->insert_id();
    //     return $insert_id;
    // }
    
    public function createGroup($title, $user_id, $event_id, $filter_criteria, $filter_type, $project_id)
    {
       
        $this->db->from('main_group');
        $this->db->like('title', $title);
        
        $groups = $this->db->count_all_results()+1;
        $concad = '-Group '.$groups;

        $title = $title.$concad;
        
        $data = array
        (
            'title' => $title,
            'user_id' => $user_id,
            'event_id' => $event_id,
            'filter_criteria' => $filter_criteria,
            'filter_type' => $filter_type,
            'project_id' => $project_id
        );

        $this->db->insert('main_group', $data);

        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    // public function addStudentsMG($student_id, $group_id)
    // {
    //     foreach($student_id as $selected)
    //     {
    //         $data = array(
    //             'group_id' => $group_id,
    //             'student_id' => $selected
    //         );
    
    //         $this->db->insert('main_group_allocation', $data);
    //     }
    // }
    
    public function addStudentsMG($student_id, $group_id)
    {
        foreach($student_id as $selected)
        {
            $data = array(
                'group_id' => $group_id,
                'student_id' => $selected
            );
    
            $this->db->insert('main_group_allocation', $data);

            $this->db->set('tme_group', $group_id);
            $this->db->where('id', $selected);
            $this->db->update('student');
        }
    }


    public function fetchMainGroupQuestionnaire($group_id)
    {
        $this->db->where('group_id', $group_id);
        $this->db->select('questionnaire.title,questionnaire.id');
        $this->db->from('questionnaire');
        $this->db->join('main_group_questionnaire', 'main_group_questionnaire.questionnaire_id=questionnaire.id', 'inner');

        $query = $this->db->get();
        return $query;
    }

    public function fetchSubGroupQuestionnaire($group_id)
    {
        $this->db->where('group_id', $group_id);
        $this->db->select('questionnaire.title,questionnaire.id');
        $this->db->from('questionnaire');
        $this->db->join('sub_group_questionnaire', 'sub_group_questionnaire.questionnaire_id=questionnaire.id', 'inner');

        $query = $this->db->get();
        return $query;
    }

    public function fetchOtherQuestionnaireMG($group_id)
    {
        $sql = "SELECT title,id FROM questionnaire WHERE id NOT IN (SELECT questionnaire_id FROM main_group_questionnaire WHERE group_id='$group_id')";

        $query = $this->db->query($sql);
        return $query;
    }

    public function fetchOtherQuestionnaireSG($group_id)
    {
        $sql = "SELECT title,id FROM questionnaire WHERE id NOT IN (SELECT questionnaire_id FROM sub_group_questionnaire WHERE group_id='$group_id')";

        $query = $this->db->query($sql);
        return $query;
    }

    public function removeMGQuestionnaire($group_id, $questionnaire_id)
    {
        foreach($questionnaire_id as $selected)
        {
            $data = array(
                'group_id' => $group_id,
                'questionnaire_id' => $selected
            );
    
            $this->db->delete('main_group_questionnaire', $data);
        }
    }

    public function removeSGQuestionnaire($group_id, $questionnaire_id)
    {
        foreach($questionnaire_id as $selected)
        {
            $data = array(
                'group_id' => $group_id,
                'questionnaire_id' => $selected
            );
    
            $this->db->delete('sub_group_questionnaire', $data);
        }
    }

    public function addMGQuestionnaire($group_id, $questionnaire_id)
    {
        $data = array(
            'group_id' => $group_id,
            'questionnaire_id' => $questionnaire_id
        );

        $this->db->insert('main_group_questionnaire', $data);
        
         $this->db->set('used', 1);
        $this->db->where('id', $questionnaire_id);
        $this->db->update('questionnaire');
    }

    public function addSGQuestionnaire($group_id, $questionnaire_id)
    {
        $data = array(
            'group_id' => $group_id,
            'questionnaire_id' => $questionnaire_id
        );

        $this->db->insert('sub_group_questionnaire', $data);
    }

    public function deleteMainGroup($id)
    {
        $this->db->where('group_id', $id);
        $this->db->delete('main_group_allocation');
        
        $this->db->where('group_id', $id);
        $this->db->delete('main_group_questionnaire');
        
        $this->db->where('tme_group', $id);
        $this->db->set('tme_group', 0);
        $this->db->update('student');


        $this->db->where('id', $id);
        $this->db->delete('main_group');
    }

    public function deleteLeadsGroup($id)
    {
        $this->db->where('group_id', $id);
        $this->db->delete('main_group_allocation');
        
        $this->db->where('group_id', $id);
        $this->db->delete('main_group_questionnaire');

        $this->db->where('leads_group', $id);
        $this->db->set('leads_group', 0);
        $this->db->update('student');

        $this->db->where('id', $id);
        $this->db->delete('main_group');
    }
    
    public function removeLead($id)
    {
        $this->db->where('id', $id);
        $this->db->set('response', 0);
        $this->db->update('student');
    }


    public function fetchFilterCriteria()
    {
        $this->db->select('filter_criteria');
        $query = $this->db->get('main_group');

        return $query;
    }

    public function filterGroups($event,$criteria,$type)
    {
        $this->db->select('main_group.id,main_group.title,main_group.user_id,user.first_name,user.last_name');
        $this->db->from('main_group');
        $this->db->join('user', 'user.id=main_group.user_id', 'left');

        if ($event != 'select' || $criteria != 'select' || $type != 'select' ){
            $this->db->like('main_group.event_id', $event);
            $this->db->like('main_group.filter_criteria', $criteria);
            $this->db->like('main_group.filter_type', $type);

        }

        return $this->db->get();
    }
    
    
    public function fetchEventForm($event_id)
    {
        $this->db->where('event_id', $event_id);
        $this->db->select('form.title,form.id');
        $this->db->from('form');
        $this->db->join('event_form', 'event_form.form_id=form.id', 'inner');

        $query = $this->db->get();
        return $query;
    }

    public function fetchOtherforms($event_id)
    {
        $sql = "SELECT title,id FROM form WHERE id NOT IN (SELECT form_id FROM event_form WHERE event_id='$event_id')";

        $query = $this->db->query($sql);
        return $query;
    }

    public function addEventForm($event_id, $form_id)
    {
        $data = array(
            'event_id' => $event_id,
            'form_id' => $form_id
        );

        $this->db->insert('event_form', $data);
    }

    public function removeEventForm($event_id,$form_id)
    {
        foreach($form_id as $selected)
        {
            $data = array(
                'event_id' => $event_id,
                'form_id' => $selected
            );
    
            $this->db->delete('event_form', $data);
        }
    }
    
    public function saveProject($title)
    {
        $data = array( 'title'=> $title);

        $this->db->insert('project', $data);
    }

    public function fetchProjects()
    {
        $this->db->select('*');
        $query = $this->db->get('project');

        return $query;
    }

    public function fetchProjectName($id)
    {
        $this->db->where('id', $id);
        $this->db->select('title');

        $query = $this->db->get('project');

        foreach($query->result() as $row)
        {
            $group_title = $row->title;
        }

        return $group_title;
    }

    
    
    
       //log features
    public function studentLog($id){
        $this->db->select('*');
        $this->db->where('id', $id);      
        $query = $this->db->get('student');

        if($query->num_rows() > 0)
        {   
            return $query->row_array();
        }
    }
    public function studentLogEx($id){
        $this->db->select('student_ex.key,student_ex.value,student_ex.time,user.first_name,user.last_name,user.type');
        $this->db->from('student_ex');
        $this->db->join('user', 'student_ex.user_id=user.id' , 'inner');
        $this->db->where('student_ex.student_id', $id);
        $query = $this->db->get();

        if($query->num_rows() > 0)
        {
            return $query->result_array();
        }
    }
    //followup Features
    public function fetchFollowups($follow_id)
    {   
        $this->db->select('*');
        $this->db->from('remark');
        $this->db->join('student', 'student.id=remark.student_id');
        $this->db->join('remark_followup', 'remark.id=remark_followup.remark_id');
        $this->db->where('remark_followup.follow_id', $follow_id);

        $query = $this->db->get();
        return $query;
    }
    
    public function fetchFollowupTypes()
    {
        $this->db->select('*');
        $this->db->from('followup');

        $query = $this->db->get();
        return $query;
    }
    public function addFollowup($name){
        $data = array(
            'name'=>$name
        );

        $this->db->insert('followup',$data);
    }
    
    //log
    public function remarkDetails($sid){
        $this->db->select('*');
        $this->db->from('remark');
        $this->db->where('remark.student_id', $sid);
        $this->db->join('student', 'remark.student_id=student.id');
        $this->db->join('user', 'remark.user_id=user.id');
        

        $query = $this->db->get();
        if($query->num_rows() > 0)
        {
            return $query->result_array();
        }
    }



}



?>
