<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class adminController extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->model('adminModel');
        $this->load->library('excel');
    }
    
    public function addMoreStudentsLG(){
        $this->load->view('AddMoreStudentsLG');
    }
    
     public function addMoreStudentsMG(){
        $this->load->model('adminModel');
        $data['keys'] = $this->adminModel->fetchKeys();
        $data['events'] = $this->adminModel->fetchEvents(); 
        
        $this->load->view('AddMoreStudentsMG', $data);
    }
    
    public function viewLeads(){
        $this->load->view('ViewLeads');
    }
    
    public function viewProjects(){
        $this->load->model('adminModel');
        $data['projects'] = $this->adminModel->fetchProjects();
        $data['groups'] = $this->adminModel->fetchMainGroups();
        
        $this->load->view('ViewProjects', $data);
    }
    
    public function createLeadsGroup(){
         $this->load->model('adminModel');
        
        $data['CCs'] = $this->adminModel->fetchCourseCounselors();
        $data['student'] = $this->adminModel->fetchLeads();
        
        $this->load->view('CreateLeadsGroup', $data);
    }
    
    public function createProject(){
        $this->load->view('CreateProject');
    }

    public function UserRegistration(){
        $this->load->view('UserRegistration');
    }
    public function userView(){
        $this->load->view('ViewUser');
    }
    public function manageUser(){
        $this->load->view('ManageUser');
    }
    public function createFormFields(){
        $this->load->view('CreateFormFields');
    }
    public function uploadEventDetails(){
        $this->load->view('UploadEventDetails');
    }
    public function createQuestionnaire(){
        $this->load->view('CreateQuestionnaire');
    }
    public function generateReports(){
        $this->load->view('Generatereports');
    }
    public function viewLogs(){
        $this->load->view('ViewLogs');
    }
    public function studentGroups(){
        $this->load->view('StudentGroups');
    }

    public function createEvent(){
        $this->load->model('adminModel');
        $data['forms_for_event'] = $this->adminModel->selectFormsForEvent();
        $this->load->view('CreateEvent',$data);
    }
    public function createForms(){
        $this->load->view('CreateForms');
    }
    public function viewGroups(){
        $this->load->view('ViewGroups');
    }
    public function assignUsers(){
        $this->load->view('AssignUsers');
    }
    public function importStudents(){
//        $this->load->view('ImportStudentsList');

        $this->load->model('adminModel');
        $event_names =$this->adminModel->selectEventList();
        $data['event_names'] = $event_names;
        $data['type'] = 1; //Type of input process(Import)
        $this->load->view('SelectEventName',$data);
    }
//    public function selectEventList(){
//        $event_id = $this->input->get('event_id');
//        $this->load->model('adminModel');
//        $event_names =$this->adminModel->selectEventList($event_id);
//        $data['event_names'] = $event_names;
//
//    }
    public function addStudent(){
//        $this->load->view('AddStudent');

        $this->load->model('adminModel');
        $event_names =$this->adminModel->selectEventList();
        $data['event_names'] = $event_names;
        $data['type'] = 2; //Type of input process(Manually Input)
        $this->load->view('SelectEventName',$data);
    }
    public function selectEventToForm(){
        $event_id = $this->input->get('event_id');
        $type = $this->input->get('type');
        $this->load->model('adminModel');
        $data['instant_req'] = $this->adminModel->selectFormsForSelectedEvent($event_id);
        $data['type'] = $type;
        $data['event_id'] = $event_id;
        $this->load->view('SelectEvent',$data);

    }
    public function manageStudents(){
//        $this->load->view('ManageStudents');
        $this->load->view('ManageStudents');
    }
    public function userEdit(){
        if($this->input->get()){
            $id = $this->input->get('user_id');
            $this->load->model('adminModel');
            $data['instant_req'] = $this->adminModel->edit_User($id);
            $this->load->view('EditUser',$data);


        }

    }

    public  function userDelete(){
        if($this->input->get())
        {
            $id = $this->input->get('user_id');
            $this->load->model('adminModel');
            $result = $this->adminModel->delete_User($id);
            if($result){
                $this->manageUser();
            }else{
                $this->manageUser();
            }
        }


    }
    public function createNewEvent(){
        $name = $this->input->post('name');
        $date = $this->input->post('date');
        $venue = $this->input->post('venue');
        $file_name = $this->input->post('file_name');

        $this->load->model('adminModel');
        $insert_id = $this->adminModel->createEvent($name,$date,$venue,$file_name);
        $result= $this->adminModel->assignEventToForm($insert_id,$file_name);

        if($result){
            $this->session->set_flashdata('add_success','Event Added Successfully!');
            $this->createEvent();
        }else{
            $this->session->set_flashdata('add_failed','Failed to Add Event!');
            $this->createEvent();
        }

    }

    public function addStudentsForEvent(){
        $form_id = $this->input->get('form_id');
        $event_id = $this->input->get('event_id');
        $this->load->model('adminModel');
        $fixed_result = $this->adminModel->assignFormFixed($form_id);
        $form_title =$this->adminModel->getFormName($form_id);
        $data['form_name'] = $form_title;
        $data['form_id'] = $form_id;
        $data['event_id'] = $event_id;

        $type = $this->input->get('type');
        if($type == 1){
            $this->load->view('ImportStudentsList',$data);
        }else if($type == 2){
            $data['form_field_result'] =$this->adminModel->getFormFields($form_id);
            $this->load->view('AddStudentManually',$data);
        }

    }

    public function printExcelSheet(){
        $form_id = $this->input->get('form_id');
        $event_id = $this->input->get('event_id');
        $this->load->model("adminModel");
        $result = $this->adminModel->getKeys($form_id);
        $form_name = $this->adminModel->getFormName($form_id);
        $this->load->library("excel");
        $object = new PHPExcel();

        $object->setActiveSheetIndex(0);

        $table_columns = array("Title","First Name", "Last Name", "Email", "Mobile Number" , "Residence Number", "Address");
        if($result->num_rows() > 0)
        {
            foreach($result->result() as $row)
            {
                $column =  $row->name;
                array_push($table_columns,$column);
            }}


        $column = 0;
        foreach($table_columns as $field)
        {
            $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
            $column++;
        }
        $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$form_name.'.xls"');
        $object_writer->save('php://output');

    }
    public function registerUser(){
        $this->form_validation->set_rules('firstname','First Name','required');
        $this->form_validation->set_rules('lastname','Last Name','required');
        $this->form_validation->set_rules('email','Email','required');
        $this->form_validation->set_rules('type','Type','required');
        $this->form_validation->set_rules('contactnumber','Contact Number','required');

        //echo form_open_multipart('upload/do_upload');


        if($this->form_validation->run()== FALSE){
            $this->session->set_flashdata('register_failed','Please fill all the fields');
            $this->load->view('UserRegistration');

        }else if ($this->input->post('password') != $this->input->post('confirmpassword')) {
            $this->session->set_flashdata('register_failed','Please add the same password');
            $this->load->view('UserRegistration');
        }
        else{
            $firstname = $this->input->post('firstname');
            $lastname = $this->input->post('lastname');
            $email = $this->input->post('email');
            $type = $this->input->post('type');
            $contact_number = $this->input->post('contactnumber');
            $password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
            $image_url = $this->input->post('imageurl');
            if(!$image_url){
                $image_url = 'user.jpg';
            }

            $this->load->model('adminModel');
            $user_id = $this->adminModel->register_User($firstname,$lastname,$email,$type,$contact_number,$password,$image_url);

            if($user_id){
                $this->session->set_flashdata('register_success','User Registered Successfully!');
                $this->load->view('UserRegistration');

            }else{
                $this->session->set_flashdata('register_failed','Failed to Register User.Try again..');
                $this->load->view('UserRegistration');
            }




        }
    }
    public function editUser(){
        $this->form_validation->set_rules('firstname','First Name','required');
        $this->form_validation->set_rules('lastname','Last Name','required');
        $this->form_validation->set_rules('email','Email','required');
        $this->form_validation->set_rules('type','Type','required');
        $this->form_validation->set_rules('contactnumber','Contact Number','required');
        $this->form_validation->set_rules('password','Password','required');
        $this->form_validation->set_rules('confirmpassword','Confirm Password','required');

        //echo form_open_multipart('upload/do_upload');


        if($this->form_validation->run()== FALSE){
            $this->session->set_flashdata('register_failed','Please fill all the fields');
            $this->load->view('EditUser');

        }else if ($this->input->post('password') != $this->input->post('confirmpassword')) {
            $this->session->set_flashdata('register_failed','Please add the same password');
            $this->load->view('EditUser');
        }
        else{
            $id = $this->input->post('id');
            $firstname = $this->input->post('firstname');
            $lastname = $this->input->post('lastname');
            $email = $this->input->post('email');
            $type = $this->input->post('type');
            $contact_number = $this->input->post('contactnumber');
            $password = $this->input->post('password');
            

            $this->load->model('adminModel');
                        $user_id = $this->adminModel->edit_User_Final($id,$firstname,$lastname,$email,$type,$contact_number,$password);


            $this->load->view('ViewUser');

        }
    }

    public function createNewLogin(){
        if($this->input->get()){
            $id = $this->input->get('user_id');
            //pass user id and status whether this user is a new user or assign to already alocated user
            $this->load->model('adminModel');
            $data['instant_req'] = $this->adminModel->edit_User($id);
            $this->load->view('CreateNewLogin',$data);
        }
    }
    public function createExistingLogin(){
        $id = $this->input->get('user_id');
        $this->load->model('adminModel');
        $data['instant_req'] = $this->adminModel->edit_User($id);
        $this->load->view('CreateExistingLogin',$data);
    }

    public function assignNewUser(){
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $uid = $this->input->post('uid');
        $type = $this->input->post('userType');

        $this->load->model('adminModel');
        $user_id = $this->adminModel->assign_User($uid,$username,$password,$type);

        if($user_id){
            $this->session->set_flashdata('register_success','User Assigned Successfully!');
            $this->load->view('AssignUsers');

        }else{
            $this->session->set_flashdata('register_failed','Failed to Asign User');
            $this->load->view('AssignUsers');
        }
    }
    //Assign already registered user
    public function assignExistingUser(){
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $uid = $this->input->post('uid');
        //Admin wants to change the password too or not
        if($password != null){
            $this->load->model('adminModel');
            $user_id = $this->adminModel->assign_ExUserwithPassword($uid,$username,$password);

            if($user_id){
                $this->session->set_flashdata('register_success','User Assigned Successfully!');
                $this->load->view('AssignUsers');

            }else{
                $this->session->set_flashdata('register_failed','Failed to Asign User');
                $this->load->view('AssignUsers');
            }
        }else{
            $this->load->model('adminModel');
            $user_id = $this->adminModel->assign_ExUser($uid,$username);

            if($user_id){
                $this->session->set_flashdata('register_success','User Assigned Successfully!');
                $this->load->view('AssignUsers');

            }else{
                $this->session->set_flashdata('register_failed','Failed to Asign User');
                $this->load->view('AssignUsers');
            }

        }

    }



    //Excel Import
    public function fetch()
    {
        $data = $this->adminModel->select();
        $output = '
  <h3 align="center">Total Users - '.$data->num_rows().'</h3>
  <table class="table table-striped table-bordered">
   <tr>
    <th>First Name</th>
    <th>Last Name</th>
    <th>Email</th>
    <th>Type</th>
    <th>Contact Number</th>
   </tr>
  ';
        foreach($data->result() as $row)
        {
            $output .= '
   <tr>
    <td>'.$row->firstname.'</td>
    <td>'.$row->lastname.'</td>
    <td>'.$row->email.'</td>
    <td>'.$row->type.'</td>
    <td>'.$row->contact_number.'</td>
   </tr>
   ';
        }
        $output .= '</table>';
        echo $output;
    }

    public function import()
    {
        if (isset($_FILES["file"]["name"]) && $_POST['form_id']) {
            $form_id = $_POST['form_id'];
            $event_id = $_POST['event_id'];
            $path = $_FILES["file"]["tmp_name"];
            $object = PHPExcel_IOFactory::load($path);
            //Get the Table Columns
            $this->load->model("adminModel");
            $result = $this->adminModel->getKeys($form_id);
            $table_columns = array("Title","First Name", "Last Name", "Email", "Mobile Number", "Residence Number" , "Address");
            if($result->num_rows() > 0)
            {
                foreach($result->result() as $row)
                {
                    $column =  $row->name;
                    array_push($table_columns,$column);
                }
            }
            $highestColumn = sizeof($table_columns);
            $data_insertion_status = 0; //Success 1 => Duplicate Found
            $duplicate_array = [];
            $duplicate_additional_data = [];
            $verify_correct_file = 1; //Correct File

            foreach ($object->getWorksheetIterator() as $worksheet) {
                $highestRow = $worksheet->getHighestRow();

                }
                    //Check the correct Form format
            $row_number = 0;
            // for($col = 0; $col < $highestColumn; $col++){

            //     $title_name = $worksheet->getCellByColumnAndRow($col, $row_number)->getValue();
            //     $table_columns_title_name = $table_columns[$col];
                
            //     if($title_name != $table_columns_title_name){
            //         $verify_correct_file = 0; //Wrong File
            //     }

            // }
            if($verify_correct_file == 0){
                echo 'Please Upload Correct Excel File';
            }else{
                for ($row = 2; $row <= $highestRow; $row++) {
                    $title = ucfirst($worksheet->getCellByColumnAndRow(0, $row)->getValue());
                    $first_name = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                    $last_name = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                    $email = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                    $mobile_number = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                    $residence_number = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                    $address = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                    $event_id = $event_id;

                    //Check Duplicates
                    $result = $this->adminModel->check_Duplicates($mobile_number,$residence_number);

                    if($result){
                        //This array for frontend development
                        unset($message);
                        $message[] = array(
                            'Old' => $result[0]->first_name.' '.$result[0]->last_name,
                            'New' =>$first_name." ".$last_name,
                        );

                        unset($Old_Data);
                        //Put old data to an array
                        $Old_Data[] = array(
                            'id' => $result[0]->id ,
                            'title' => $title,
                            'first_name' => $first_name,
                            'last_name' => $last_name,
                            'email' => $email,
                            'mobile_number' => $mobile_number,
                            'residence_number' => $residence_number,
                            'address' => $address,
                            'event_id' => $event_id,
                        );
                        //This array for  backend development
                        unset($duplicate_fields);
                        $duplicate_fields[] = array(
                            'Old' => $result,
                            'New' =>$Old_Data,
                        );


                        $additional_data = 0;
                        $data_insertion_status = 1;
                        echo "Duplicate Found : ",  json_encode($message), "\n";
                        array_push($duplicate_array,$duplicate_fields);
                        //Get additional data respect to duplicate field
                        for($col = 7; $col < $highestColumn; $col++){

                            //Get the Additional Data set
                            //$check_element_name = $table_columns[$col];
                            //$check_element_value = $worksheet->getCellByColumnAndRow($col, $row)->getValue();
                            //$result1 = $this->adminModel->check_option($check_element_name,$check_element_value);
                            //unset($duplicate_additional_data);
                            $duplicate_additional_data[] = array(
                                'student_id' => $result[0]->id,
                                'key' => $table_columns[$col],
                                'value' => $worksheet->getCellByColumnAndRow($col, $row)->getValue(),
                            );
                            //Type 1 -> Data inserted from Excel Sheet
                        }

                    }else{
                        unset($data);

                        //Check New Options and add them to Database

                        $data[] = array(
                            'title' => $title,
                            'first_name' => $first_name,
                            'last_name' => $last_name,
                            'email' => $email,
                            'mobile_number' => $mobile_number,
                            'residence_number' => $residence_number,
                            'address' => $address,
                            'event_id' => $event_id,
                        );

                        $last_row = $this->adminModel->insert($data);

                        //Get the Additional Data set
                        unset($additional_data);


                        for($col = 7; $col < $highestColumn; $col++){

                            //Get the Additional Data set
                            $check_element_name = $table_columns[$col];
                            $check_element_value = $worksheet->getCellByColumnAndRow($col, $row)->getValue();
                            $result1 = $this->adminModel->check_option($check_element_name,$check_element_value);

                            $additional_data[] = array(
                                'student_id' => $last_row,
                                'key' => $table_columns[$col],
                                'value' => $worksheet->getCellByColumnAndRow($col, $row)->getValue(),
                                'type' => 1,

                            );
                            //Type 1 -> Data inserted from Excel Sheet
                        }

                        $this->adminModel->insert_additional_data($additional_data);
                        $data_insertion_status = 0;



                    }


                }
            }
                
            if($data_insertion_status == 0 && $verify_correct_file == 1){
                echo 'Data Successfully Inserted to the System';
                    }

            }
        $this->load->library('session');
        $_SESSION['duplicate'] = $duplicate_array;
        $_SESSION['duplicate_additional_data'] = $duplicate_additional_data;

        }
        public function addStudentManually(){

            $form_id = $this->input->post('form_id');
            $event_id = $this->input->post('event_id');

            $this->load->model("adminModel");
            $result = $this->adminModel->get_Additional_Fields($form_id);
            $additional_fields = array();
            $additional_fields_values = array();

            $first_name = $this->input->post('first_name');
            $title = $this->input->post('title');
            $last_name = $this->input->post('last_name');
            $email = $this->input->post('email');
            $mobile_number = $this->input->post('mob_number');
            $residence_number = $this->input->post('res_number');
            $address = $this->input->post('address');
            $insertion_type = 1;    //No 1 is Manually Insertion Data No 2 is Insert Data from Excel Sheet
            $count = 0;
            
            //Add data to the Student Table and Check Duplicates
            $this->load->model('adminModel');
            $result_duplicates = $this->adminModel->check_Duplicates($mobile_number,$residence_number);
            if($result_duplicates){
                $form_title =$this->adminModel->getFormName($form_id);
                $data['form_name'] = $form_title;
                $data['form_id'] = $form_id;
                $data['event_id'] = $event_id;
                $data['form_field_result'] =$this->adminModel->getFormFields($form_id);
                $this->session->set_flashdata('failed','This Student Already in the System!');
                $this->load->view('AddStudentManually',$data);

            }else{
                $result_row = $this->adminModel->add_Student_Data($title,$first_name,$last_name,$email,$mobile_number,$residence_number,$address,$event_id);
                $count = $result_row;

                foreach($result as $row)
                {
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
                    $message = $this->adminModel->add_Student_Ex_Data($count,$var,$value,$insertion_type);

                }
                if($message){
                    $form_title =$this->adminModel->getFormName($form_id);
                    $data['form_name'] = $form_title;
                    $data['form_id'] = $form_id;
                    $data['event_id'] = $event_id;
                    $data['form_field_result'] =$this->adminModel->getFormFields($form_id);
                    $this->session->set_flashdata('success','Student Added Successfully!');
                    $this->load->view('AddStudentManually',$data);
                }else{
                    $form_title =$this->adminModel->getFormName($form_id);
                    $data['form_name'] = $form_title;
                    $data['form_id'] = $form_id;
                    $data['event_id'] = $event_id;
                    $data['form_field_result'] =$this->adminModel->getFormFields($form_id);
                    $this->session->set_flashdata('failed','Failed to Add Student!');
                    $this->load->view('AddStudentManually',$data);
                }
            }


        }
        public function check_duplicates(){
            $this->load->view('ManageDuplicates');

        }
        public function manageDulpicates(){

            if(isset($_POST['str_var'])){
                $str_var = $_POST["str_var"];
                $array_var = unserialize(base64_decode($str_var));
                foreach ($array_var as $item){
                    $result = $this->adminModel->update_Extra_duplicate_Fields($item['student_id'],$item['key'],$item['value']);
                }


            }
            if(isset($_POST['duplicates_id'])){
                $dup_id_array = $this->input->post('duplicates_id');
                $duplicate_solved_status = 0; //Failed

                foreach ($dup_id_array as $dup_id_array=>$value) {
                    if(isset($_POST[$value.'real_array_first_name'])){
                        $real_first_name = $this->input->post($value.'real_array_first_name');
                        $real_last_name = $this->input->post($value.'real_array_last_name');
                        $real_email = $this->input->post($value.'real_array_email');
                        $real_address = $this->input->post($value.'real_array_address');

                        $this->load->model("adminModel");
                        $result = $this->adminModel->update_duplicate_fields($value,$real_first_name[0],$real_last_name[0],$real_email[0],$real_address[0]);

                        if($result){
                            $duplicate_solved_status = 1;
                        }else{
                            $duplicate_solved_status = 0;
                        }
                    }
                }

                if($duplicate_solved_status == 1){
                    $this->session->set_flashdata('success1','Duplicates Solved Successfully!');
                    $this->importStudents();


                }else{
                    $this->session->set_flashdata('success1','Duplicates Solved Successfully!');
                    $this->importStudents();
                }
            }


        }

        //Thanushi
    public function viewEvents(){
        $this->load->model('adminModel');
        $data['events'] = $this->adminModel->fetchEvents();

        $this->load->view('ViewEvents', $data);
    }
    public function mainGroups(){
        $this->load->model('adminModel');
        $data['main_groups'] = $this->adminModel->fetchMainGroups();
        $data['projects'] = $this->adminModel->fetchProjects();
        $data['events'] = $this->adminModel->fetchEvents();
        $data['filter_criteria'] = $this->adminModel->fetchFilterCriteria();

        $this->load->view('MainGroups', $data);
    }
    public function subGroups(){
        $this->load->model('adminModel');
        $data['sub_groups'] = $this->adminModel->fetchSubGroups();

        $this->load->view('SubGroups', $data);
    }
    
    public function LeadsGroups(){
        $this->load->model('adminModel');
        $data['leads_groups'] = $this->adminModel->fetchLeadsGroups();

        $this->load->view('ViewLeadsGroups', $data);
    }
    
    public function eventParticipants(){
        if($this->input->get())
        {
            $event_id = $this->input->get('event_id');

            $this->load->model('adminModel');
            $data['event_det'] = $this->adminModel->fetchSingleEvent($event_id);
            $data['participants'] = $this->adminModel->fetchEventparticipants($event_id);
            $data['main_groups'] = $this->adminModel->fetchMainGroups();
            $data['TLEs'] = $this->adminModel->fetchTLES();

            $this->load->view('EventParticipants', $data);

        }
    }


    public function addStudentsMG($student_id, $group_id)
    {
        $this->load->model('adminModel');
        $this->adminModel->addStudentsMG($student_id, $group_id);
        
    }


    public function createMainGroup()
    {
        $event_id = $this->input->get('event_id');

        if(isset($_POST['newgroup']))
        {
            if(!empty($_POST['student_id']))
            {
                $title = $_POST['title'];
                $tme = $_POST['tme'];

                $this->load->model('adminModel');
                $group_id = $this->adminModel->newMainGroup($title, $tme);

                $student_id = $_POST['student_id'];

                $this->addStudentsMG($student_id, $group_id);

                $data['event_det'] = $this->adminModel->fetchSingleEvent($event_id);
                $data['participants'] = $this->adminModel->fetchEventparticipants($event_id);
                $data['TLEs'] = $this->adminModel->fetchTLES();
                $data['main_groups'] = $this->adminModel->fetchMainGroups();

                $this->load->view('EventParticipants', $data);
            }
        }
    }

    public function addToExistingGroup()
    {
        $event_id = $this->input->get('event_id');
        if(isset($_POST['submittwo']))
        {
            if(!empty($_POST['student_id']))
            {
                $student_id = $_POST['student_id'];
                $group_id = $_POST['group_id'];
                
                $this->load->model('adminModel');
                $this->adminModel->moveStudentsMG($group_id,$student_id);

                $data['event_det'] = $this->adminModel->fetchSingleEvent($event_id);
                $data['participants'] = $this->adminModel->fetchEventparticipants($event_id);
                $data['TLEs'] = $this->adminModel->fetchTLES();
                $data['main_groups'] = $this->adminModel->fetchMainGroups();

                $this->load->view('EventParticipants', $data);

            }
        }
    }

    public function groupsOfTme()
    {
        $output = '';
        $tme_id = '';

        $this->load->model('adminModel');
        if($this->input->post('id'))
        {   
            $tme_id = $this->input->post('id');
        }
        $data = $this->adminModel->fetchTleGroups($tme_id);

        if($data->num_rows() > 0 )
        {
            
            foreach($data->result() as $row)
            {
                $output .= "<li class=\"list-group-item\">$row->title</li>";
            }
        }else
        {
            
            //$output .= "<li class=\"list-group-item\">No groups found</li>";
        }
        echo $output;
    }

    public function removeStudentsOfMG()
    {
        if(isset($_POST['submit']))
        {
            if(!empty($_POST['student_id']))
            {
                $group_id = $_GET['group_id'];

                $this->load->model('adminModel');
                $this->adminModel->removeStudentsOfMG($_POST['student_id']);

                $data['tme_name'] = $this->adminModel->fetchMainGroupTmeName($group_id);
                $data['group_title'] = $_GET['group_title'];
                $data['gid'] = $_GET['group_id'];
                $data['members'] = $this->adminModel->fetchGroupMembers($group_id);
                $data['TLEs'] = $this->adminModel->fetchTLEs();
                $data['main_groups'] = $this->adminModel->fetchOtherMainGroups($group_id);

                $this->load->view('ViewMainGroup', $data);
            }
        }
    }

    public function removeStudentsOfLG()
    {
        if(isset($_POST['submit']))
        {
            if(!empty($_POST['student_id']))
            {
                $group_id = $_GET['group_id'];

                $this->load->model('adminModel');
                $this->adminModel->removeStudentsOfLG($_POST['student_id'], $group_id);

                $data['tme_name'] = $this->adminModel->fetchMainGroupTmeName($group_id);
                $data['group_title'] = $_GET['group_title'];
                $data['gid'] = $_GET['group_id'];
                $data['members'] = $this->adminModel->fetchGroupMembers($group_id);
                $data['TLEs'] = $this->adminModel->fetchCourseCounselors();
                $data['main_groups'] = $this->adminModel->fetchOtherMainGroups($group_id);

                $this->load->view('ViewLeadsGroup', $data);
            }
        }
    }

    public function moveStudentsMG()
    {
        if(isset($_POST['submitOne']))
        {
            if(!empty($_POST['student_id']))
            {
                $group_id = $_GET['group_id'];

                $this->load->model('adminModel');
                $this->adminModel->moveStudentsMG($_POST['newgroup_id'],$_POST['student_id']);

                $data['tme_name'] = $this->adminModel->fetchMainGroupTmeName($group_id);
                $data['group_title'] = $_GET['group_title'];
                $data['gid'] = $_GET['group_id'];
                $data['members'] = $this->adminModel->fetchGroupMembers($group_id);
                $data['TLEs'] = $this->adminModel->fetchTLES();
                $data['main_groups'] = $this->adminModel->fetchOtherMainGroups($group_id);

                $this->load->view('ViewMainGroup', $data);
            }
        }
    }

    public function viewMainGroup()
    {
        if($this->input->get())
        {
            $group_id= $this->input->get('group_id');
            $data['group_title'] = $this->input->get('group_title');
            $data['tme_name'] = $this->input->get('tme_name');
            $data['gid'] = $this->input->get('group_id');

            $this->load->model('adminModel');
            $data['members'] = $this->adminModel->fetchGroupMembers($group_id);
            $data['TLEs'] = $this->adminModel->fetchTLEs();
            $data['main_groups'] = $this->adminModel->fetchOtherMainGroups($group_id);

            $this->load->view('ViewMainGroup', $data);
        }
        
    }
    
    public function viewLeadsGroup()
    {
        if($this->input->get())
        {
            $group_id= $this->input->get('group_id');
            $data['group_title'] = $this->input->get('group_title');
            $data['tme_name'] = $this->input->get('tme_name');
            $data['gid'] = $this->input->get('group_id');

            $this->load->model('adminModel');
            $data['members'] = $this->adminModel->fetchGroupMembers($group_id);
            $data['TLEs'] = $this->adminModel->fetchCourseCounselors();
            $data['main_groups'] = $this->adminModel->fetchOtherMainGroups($group_id);

            $this->load->view('ViewLeadsGroup', $data);
        }
        
    }

    public function viewSubGroup()
    {
        if($this->input->get())
        {   
            $group_id= $this->input->get('group_id');
            $data['group_title'] = $this->input->get('group_title');
            $data['tme_name'] = $this->input->get('tme_name');
            $data['gid'] = $this->input->get('group_id');

            $this->load->model('adminModel');
            $data['members'] = $this->adminModel->fetchSubGroupMembers($group_id);
            $data['CCs'] = $this->adminModel->fetchCourseCounselors();
        
            $this->load->view('ViewSubGroup', $data);
        }
    }

    public function changeTme()
    {       
            if(!empty($_POST['tme']))
            {
                $user_id = $_POST['tme'];
                $group_id = $_GET['group_id'];

                $this->load->model('adminModel');
                $this->adminModel->changeTme($user_id,$group_id);

                $data['tme_name'] = $this->adminModel->fetchTmeName($user_id);
                $data['group_title'] = $_GET['group_title'];
                $data['gid'] = $_GET['group_id'];
                $data['members'] = $this->adminModel->fetchGroupMembers($group_id);
                $data['TLEs'] = $this->adminModel->fetchTLES();
                $data['main_groups'] = $this->adminModel->fetchOtherMainGroups($group_id);

                $this->load->view('ViewMainGroup', $data);

            }
        
    }

    public function changeCC()
    {       
            if(!empty($_POST['tme']))
            {
                $user_id = $_POST['tme'];
                $group_id = $_GET['group_id'];

                $this->load->model('adminModel');
                $this->adminModel->changeTme($user_id,$group_id);

                $data['tme_name'] = $this->adminModel->fetchTmeName($user_id);
                $data['group_title'] = $_GET['group_title'];
                $data['gid'] = $_GET['group_id'];
                $data['members'] = $this->adminModel->fetchGroupMembers($group_id);
                $data['TLEs'] = $this->adminModel->fetchCourseCounselors();
                $data['main_groups'] = $this->adminModel->fetchOtherMainGroups($group_id);

                $this->load->view('ViewLeadsGroup', $data);

            }
        
    }

    //create sub group

    public function createSubGroup()
    {
        $this->load->model('adminModel');
        $data['keys'] = $this->adminModel->fetchKeys();
        $data['events'] = $this->adminModel->fetchEvents();

        $this->load->view('CreateSubGroup', $data);
    }
    
    public function allStudents()
    {
        $this->load->model('adminModel');
        $data['keys'] = $this->adminModel->fetchKeys();
        $data['events'] = $this->adminModel->fetchEvents();
        $data['student'] = $this->adminModel->fetchAllStudents();

        $this->load->view('AllStudents', $data);
    }

    // public function filterOptions()
    // {
    //     $output = "";

    //     $criteria = $this->input->post('criteria[]');

    //     $this->load->model('adminModel');
    //     $values= $this->adminModel->filterOptions($criteria);

    //     foreach($criteria as $x)
    //     {
    //         $output .= "<div class=\"col-4\"><div class=\"input-group mb-3\">";

    //         $key_name = $this->adminModel->fetchKeyName($x);

    //         $output .= "<div class=\"input-group-prepend\">
    //                         <label class=\"input-group-text\" for=\"inputGroupSelect01\">$key_name</label>
    //                     </div>
    //                     <input type=\"hidden\" name=\"key_name[]\" value=\"$key_name\">
    //                     <select class=\"custom-select\" name=\"option[]\" id=\"inputGroupSelect01\">
    //                     <option  value=\"choose\" selected>choose</option>";
            
    //         foreach($values->result() as $row)
    //         {
    //             if($row->id == $x)
    //             {
    //                 $output .= "<option  value=\"$row->value\">$row->value</option>";
    //             }
                
    //         }

    //         $output .= "</select>
    //                     </div>
    //                     </div>";
    //     }
    //     $output .= "<div class=\"float-left\">
    //                 <input type=\"submit\" name=\"submitoptions\" class=\"btn btn-sm btn-outline-secondary\" value=\"Apply\"/></div>";
    //     echo $output;
       
    // }
    
    public function filterOptions()
    {
        $output = "";

        $criteria = $this->input->post('criteria[]');

        $this->load->model('adminModel');
        $values= $this->adminModel->filterOptions($criteria);
        $events = $this->adminModel->fetchEvents();

        if(!empty($_POST['criteria']) && sizeof($_POST['criteria']) > 1)
        {
            $output .= "<div class=\"col-12\">
                            <div class=\"form-check form-check-inline\">
                            <input class=\"form-check-input\" type=\"radio\" id=\"inlineCheckbox2\" name=\"filtertype\" value=\"intersection\">
                            <label class=\"form-check-label\" for=\"inlineCheckbox2\">select students matching all criteria</label>
                            </div>
                            <div class=\"form-check form-check-inline\">
                            <input class=\"form-check-input\" type=\"radio\" id=\"inlineCheckbox3\" name=\"filtertype\" value=\"union\">
                            <label class=\"form-check-label\" for=\"inlineCheckbox3\">select students matching atleast one criteria</label>
                            </div>
                        </div>
                        ";
        }
        
        if(!empty($_POST['event']))
        {
            $output .="
                            <div class=\"col-12\">
                            <div class=\"form-group\">
                                <select multiple name=\"event_id[]\" class=\"form-control\" id=\"sel1\">
                                ";
                                
                                        foreach($events->result() as $row)
                                        {
                                            $output .= "<option value=\"$row->id\">$row->title</option>";
                                        }
                                
        $output .=             "</select>
                            </div>
                        
                        </div>";

        }

        if(!empty($_POST['criteria']))
        {
            foreach($criteria as $x)
            {
                $output .= "<div class=\"col-4\"><div class=\"input-group mb-3\">";

                $key_name = $this->adminModel->fetchKeyName($x);

                $output .= "<div class=\"input-group-prepend\">
                                <label class=\"input-group-text\" for=\"inputGroupSelect01\">$key_name</label>
                            </div>
                            <input type=\"hidden\" name=\"key_name[]\" value=\"$key_name\">
                            <select class=\"custom-select\" name=\"option[]\" id=\"inputGroupSelect01\">
                            <option  value=\"choose\" selected>choose</option>";
                
                foreach($values->result() as $row)
                {
                    if($row->id == $x)
                    {
                        $output .= "<option  value=\"$row->value\">$row->value</option>";
                    }
                    
                }

                $output .= "</select>
                            </div>
                            </div>";
            }
        }
        $output .= "<div class=\"float-left\">
                    <input type=\"submit\" name=\"submitoptions\" class=\"btn btn-sm btn-outline-secondary\" value=\"Show students\"></div>";
        echo $output;
       
    }

    // public function getFilteredStudents()
    // {
    //     if(isset($_POST['submitoptions']))
    //     {
    //         if(!empty($_POST['option']))
    //         {
    //             $filter_criteria = "";
    //             $filter_type = "";
    //             $event_id = $_POST['event_id'];
    //             $options = array();
    //             $options_string = "(";
    //             foreach($_POST['option'] as $x)
    //             {
    //                 if($x != "choose")
    //                 {
    //                     array_push($options,$x);
    //                 }
    //             }

    //             if(!empty($options))
    //             {
    //                 foreach($_POST['key_name'] as $key)
    //                 {
    //                     $filter_criteria .= $key." ";
    //                 }

    //                 $count = sizeof($options);
    //                 $last_index = sizeof($options)-1;
    //                 $sql = "";
                    
    //                 foreach($options as $y)
    //                 {
    //                     if($y != $options[$last_index] )
    //                     {
    //                         $options_string .= "'".$y."', ";
    //                     }
    //                 } 
                    
    //                 $options_string .= "'".$options[$last_index]."')";
        
    //                 if($_POST['event_id'] == "select")
    //                 {
    //                     $event_id = "IS NOT NULL";
    //                 }else
    //                 {
    //                     $event_id = "= '".$_POST['event_id']."'";
    //                 }

    //                 if(isset($_POST['filtertype']))
    //                 {
    //                     if($_POST['filtertype'] == "null")
    //                     {
    //                         $sql = "SELECT student.id, student.first_name, student.last_name, student.email, student.mobile_number, 
    //                         student.residence_number, student.address, student_ex.key, student_ex.value FROM student
    //                         LEFT JOIN student_ex ON student.id=student_ex.student_id
    //                         WHERE student_ex.value IN ".$options_string." OR student_ex.value IS NULL AND student.event_id ".$event_id.";";

    //                         $filter_type .= "null";
    //                     }
    //                     else if($_POST['filtertype'] == "intersection")
    //                     {
    //                         $sql = "SELECT student.id, student.first_name, student.last_name, student.email, student.mobile_number, 
    //                         student.residence_number, student.address, student_ex.key, student_ex.value FROM student
    //                         LEFT JOIN student_ex ON student.id=student_ex.student_id
    //                         WHERE student_ex.value IN ".$options_string." AND student.event_id ".$event_id." GROUP BY student.id HAVING COUNT(*) = ".$count.";";

    //                         $filter_type .= "intersection";
    //                     }
    //                     else if($_POST['filtertype'] == "union")
    //                     {
    //                         $sql = "SELECT student.id, student.first_name, student.last_name, student.email, student.mobile_number, 
    //                         student.residence_number, student.address, student_ex.key, student_ex.value FROM student
    //                         LEFT JOIN student_ex ON student.id=student_ex.student_id
    //                         WHERE student_ex.value IN ".$options_string." AND student.event_id ".$event_id." GROUP BY student.id;";

    //                         $filter_type .= "union";
    //                     }
    //                 }
    //                 else
    //                 {
    //                     $sql = "SELECT student.id, student.first_name, student.last_name, student.email, student.mobile_number, 
    //                     student.residence_number, student.address, student_ex.key, student_ex.value FROM student
    //                     LEFT JOIN student_ex ON student.id=student_ex.student_id
    //                     WHERE student_ex.value IN ".$options_string." AND student.event_id ".$event_id." GROUP BY student.id HAVING COUNT(*) = ".$count.";";

    //                     $filter_type .= "intersection";
    //                 }
                
    //                 $this->load->model('adminModel');
    //                 $data['filtered_students'] = $this->adminModel->fetchFilteredStudents($sql);
    //                 $data['TMEs'] = $this->adminModel->fetchTLEs();
    //                 $data['CCs'] = $this->adminModel->fetchCourseCounselors();
    //                 $data['filter_criteria'] = $filter_criteria;
    //                 $data['filter_type'] = $filter_type;
    //                 $data['event_id'] = $_POST['event_id'];

    //                 $this->load->view('FilteredStudents', $data);

    //             }
    //             else
    //             {
    //                 $this->session->set_flashdata('msg', 'Select atleast one filter option');
    //                 redirect('adminController/createSubGroup');
    //             }

    //         }
    //     }
        
    // }
    
    public function getFilteredStudents()
    {
            $event_id = "";

            if(isset($_POST['event_id']))
            {  
                $events = array();
            
                foreach($_POST['event_id'] as $a)
                {
                    array_push($events,$a);
                }

                
                $event_array = "(";

                if(sizeof($events) != 0)
                {
                    foreach($events as $b)
                    {
                        if($b != $events[sizeof($events)-1])
                        {
                            $event_array .= $b.", ";
                        }
                    }

                    $event_array .= $events[sizeof($events)-1]." )";

                    $event_id .= "IN ".$event_array;
                }
                else
                {
                    $event_id .= "IS NOT NULL";
                }
            }else
            {
                $event_id .= "IS NOT NULL";
            } 

            if(!empty($_POST['option']))
            {
                $filter_criteria = "";
                $filter_type = "";
                // $event_id = $_POST['event_id'];
                $options = array();
                $options_string = "(";
                
                foreach($_POST['option'] as $x)
                {
                    if($x != "choose")
                    {
                        array_push($options,$x);
                    }
                }

                if(!empty($options))
                {
                    foreach($_POST['key_name'] as $key)
                    {
                        $filter_criteria .= $key." ";
                    }

                    $count = sizeof($options);
                    $last_index = sizeof($options)-1;
                    $sql = "";
                    
                    foreach($options as $y)
                    {
                        if($y != $options[$last_index] )
                        {
                            $options_string .= "'".$y."', ";
                        }
                    } 
                    
                    $options_string .= "'".$options[$last_index]."')";
        
                    // if($_POST['event_id'] == "select")
                    // {
                    //     $event_id = "IS NOT NULL";
                    // }else
                    // {
                    //     $event_id = "= '".$_POST['event_id']."'";
                    // }

                    if(isset($_POST['filtertype']))
                    {
                        if($_POST['filtertype'] == "null")
                        {
                            $sql = "SELECT student.id, student.first_name, student.last_name, student.email, student.mobile_number, 
                            student.residence_number, student.address, student.tme_group, student_ex.key, student_ex.value FROM student
                            LEFT JOIN student_ex ON student.id=student_ex.student_id
                            WHERE student_ex.value IN ".$options_string." OR student_ex.value IS NULL AND student.event_id ".$event_id.";";

                            $filter_type .= "null";
                        }
                        else if($_POST['filtertype'] == "intersection")
                        {
                            $sql = "SELECT student.id, student.first_name, student.last_name, student.email, student.mobile_number, 
                            student.residence_number, student.address, student.tme_group, student_ex.key, student_ex.value FROM student
                            LEFT JOIN student_ex ON student.id=student_ex.student_id
                            WHERE student_ex.value IN ".$options_string." AND student.event_id ".$event_id." GROUP BY student.id HAVING COUNT(*) = ".$count.";";

                            $filter_type .= "intersection";
                        }
                        else if($_POST['filtertype'] == "union")
                        {
                            $sql = "SELECT student.id, student.first_name, student.last_name, student.email, student.mobile_number, 
                            student.residence_number, student.address, student.tme_group, student_ex.key, student_ex.value FROM student
                            LEFT JOIN student_ex ON student.id=student_ex.student_id
                            WHERE student_ex.value IN ".$options_string." AND student.event_id ".$event_id." GROUP BY student.id;";

                            $filter_type .= "union";
                        }
                    }
                    else
                    {
                         $sql = "SELECT student.id, student.first_name, student.last_name, student.email, student.mobile_number, 
                            student.residence_number, student.address, student.tme_group, student_ex.key, student_ex.value FROM student
                            LEFT JOIN student_ex ON student.id=student_ex.student_id
                            WHERE student_ex.value IN ".$options_string." AND student.event_id ".$event_id." GROUP BY student.id;";

                            $filter_type .= "union";
                    }
                
                    $this->load->model('adminModel');
                    $data['filtered_students'] = $this->adminModel->fetchFilteredStudents($sql);
                    $data['TMEs'] = $this->adminModel->fetchTLEs();
                    $data['CCs'] = $this->adminModel->fetchCourseCounselors();
                    $data['filter_criteria'] = $filter_criteria;
                    $data['filter_type'] = $filter_type;
                    $data['event_id'] = $event_id;
                    $data['projects'] = $this->adminModel->fetchProjects();

                    $this->load->view('FilteredStudents', $data);

                }
            }
                else
                {
                    if(!isset($_POST['event_id']))
                    {
                        $this->session->set_flashdata('msg', 'Select atleast one filter option or event');
                        redirect('adminController/createSubGroup');
                    }
                    else
                    {
                        // $event_id = "= '".$_POST['event_id']."'";

                        $sql = "SELECT student.id, student.first_name, student.last_name, student.email, student.mobile_number, 
                        student.residence_number, student.address, student.tme_group, student_ex.key, student_ex.value FROM student
                        LEFT JOIN student_ex ON student.id=student_ex.student_id WHERE student.event_id ".$event_id." GROUP BY student.id;";

                        $this->load->model('adminModel');
                        $data['filtered_students'] = $this->adminModel->fetchFilteredStudents($sql);
                        $data['TMEs'] = $this->adminModel->fetchTLEs();
                        $data['CCs'] = $this->adminModel->fetchCourseCounselors();
                        $data['filter_criteria'] = "None";
                        $data['filter_type'] = "None";
                        $data['event_id'] = $_POST['event_id'];
                        $data['projects'] = $this->adminModel->fetchProjects();

                        $this->load->view('FilteredStudents', $data);
                    }
                }      
    }
    
    
    public function getAllStudents()
    {
        $this->load->model('adminModel');
        $data['filtered_students'] = $this->adminModel->fetchAllStudents();
        $data['TMEs'] = $this->adminModel->fetchTLEs();
        $data['CCs'] = $this->adminModel->fetchCourseCounselors();
        $data['filter_criteria'] = "None";
        $data['filter_type'] = "None";
        $data['event_id'] = 0;
        $data['projects'] = $this->adminModel->fetchProjects();

        
        $this->load->view('FilteredStudents', $data);
        
        
    }
    
    
    
    ///add more students to existing group
    
     public function getFilteredMoreStudents()
    {
            $event_id = "";

            if(isset($_POST['event_id']))
            {  
                $events = array();
            
                foreach($_POST['event_id'] as $a)
                {
                    array_push($events,$a);
                }

                
                $event_array = "(";

                if(sizeof($events) != 0)
                {
                    foreach($events as $b)
                    {
                        if($b != $events[sizeof($events)-1])
                        {
                            $event_array .= $b.", ";
                        }
                    }

                    $event_array .= $events[sizeof($events)-1]." )";

                    $event_id .= "IN ".$event_array;
                }
                else
                {
                    $event_id .= "IS NOT NULL";
                }
            }else
            {
                $event_id .= "IS NOT NULL";
            } 

            if(!empty($_POST['option']))
            {
                $filter_criteria = "";
                $filter_type = "";
                // $event_id = $_POST['event_id'];
                $options = array();
                $options_string = "(";
                
                foreach($_POST['option'] as $x)
                {
                    if($x != "choose")
                    {
                        array_push($options,$x);
                    }
                }

                if(!empty($options))
                {
                    foreach($_POST['key_name'] as $key)
                    {
                        $filter_criteria .= $key." ";
                    }

                    $count = sizeof($options);
                    $last_index = sizeof($options)-1;
                    $sql = "";
                    
                    foreach($options as $y)
                    {
                        if($y != $options[$last_index] )
                        {
                            $options_string .= "'".$y."', ";
                        }
                    } 
                    
                    $options_string .= "'".$options[$last_index]."')";
        
                    // if($_POST['event_id'] == "select")
                    // {
                    //     $event_id = "IS NOT NULL";
                    // }else
                    // {
                    //     $event_id = "= '".$_POST['event_id']."'";
                    // }

                    if(isset($_POST['filtertype']))
                    {
                        if($_POST['filtertype'] == "null")
                        {
                            $sql = "SELECT student.id, student.first_name, student.last_name, student.email, student.mobile_number, 
                            student.residence_number, student.address, student.tme_group, student_ex.key, student_ex.value FROM student
                            LEFT JOIN student_ex ON student.id=student_ex.student_id
                            WHERE student_ex.value IN ".$options_string." OR student_ex.value IS NULL AND student.event_id ".$event_id.";";

                            $filter_type .= "null";
                        }
                        else if($_POST['filtertype'] == "intersection")
                        {
                            $sql = "SELECT student.id, student.first_name, student.last_name, student.email, student.mobile_number, 
                            student.residence_number, student.address, student.tme_group, student_ex.key, student_ex.value FROM student
                            LEFT JOIN student_ex ON student.id=student_ex.student_id
                            WHERE student_ex.value IN ".$options_string." AND student.event_id ".$event_id." GROUP BY student.id HAVING COUNT(*) = ".$count.";";

                            $filter_type .= "intersection";
                        }
                        else if($_POST['filtertype'] == "union")
                        {
                            $sql = "SELECT student.id, student.first_name, student.last_name, student.email, student.mobile_number, 
                            student.residence_number, student.address, student.tme_group, student_ex.key, student_ex.value FROM student
                            LEFT JOIN student_ex ON student.id=student_ex.student_id
                            WHERE student_ex.value IN ".$options_string." AND student.event_id ".$event_id." GROUP BY student.id;";

                            $filter_type .= "union";
                        }
                    }
                    else
                    {
                         $sql = "SELECT student.id, student.first_name, student.last_name, student.email, student.mobile_number, 
                            student.residence_number, student.address, student.tme_group, student_ex.key, student_ex.value FROM student
                            LEFT JOIN student_ex ON student.id=student_ex.student_id
                            WHERE student_ex.value IN ".$options_string." AND student.event_id ".$event_id." GROUP BY student.id;";

                            $filter_type .= "union";
                    }
                
                    $this->load->model('adminModel');
                        $data['filtered_students'] = $this->adminModel->fetchFilteredStudents($sql);
                        $data['filter_criteria'] = "None";
                        $data['filter_type'] = "None";
                        $data['groups'] = $this->adminModel->fetchMainGroups();

                    $this->load->view('AddMoreStudentList', $data);

                }
            }
                else
                {
                    if(!isset($_POST['event_id']))
                    {
                        $this->session->set_flashdata('msg', 'Select atleast one filter option or event');
                        redirect('adminController/addMoreStudentsMG');
                    }
                    else
                    {
                        // $event_id = "= '".$_POST['event_id']."'";

                        $sql = "SELECT student.id, student.first_name, student.last_name, student.email, student.mobile_number, 
                        student.residence_number, student.address, student.tme_group, student_ex.key, student_ex.value FROM student
                        LEFT JOIN student_ex ON student.id=student_ex.student_id WHERE student.event_id ".$event_id." GROUP BY student.id;";

                        $this->load->model('adminModel');
                        $data['filtered_students'] = $this->adminModel->fetchFilteredStudents($sql);
                        $data['filter_criteria'] = "None";
                        $data['filter_type'] = "None";
                        $data['groups'] = $this->adminModel->fetchMainGroups();
                       

                        $this->load->view('AddMoreStudentList', $data);
                    }
                }      
    }
    
    
    public function getAllMoreStudents()
    {
        $this->load->model('adminModel');
        $data['filtered_students'] = $this->adminModel->fetchAllStudents();
        $data['filter_criteria'] = "None";
        $data['filter_type'] = "None";
        $data['groups'] = $this->adminModel->fetchMainGroups();

        
        $this->load->view('AddMoreStudentList', $data);
        
        
    }
    
    public function addMoreStudentsToGroup()
    {
        if(isset($_POST['student_id']))
        {
           $this->load->model('adminModel');
           
           $this->adminModel->addStudentsMG($_POST['student_id'], $_POST['group']);
           
           $data['filtered_students'] = $this->adminModel->fetchAllStudents();
           $data['groups'] = $this->adminModel->fetchMainGroups();

           $this->session->set_flashdata('successfullyAdded', 'Successfully added');
           $this->load->view('AddMoreStudentList', $data);
        }
    }

    
    // public function viewFilteredStudents()
    // {
    //     if(isset($_POST['submitoptions']))
    //     {
    //         if(!empty($_POST['option']))
    //         {
    //             $filter_criteria = "";
    //             $filter_type = "";
    //             $event_id = $_POST['event_id'];
    //             $options = array();
    //             $options_string = "(";
    //             foreach($_POST['option'] as $x)
    //             {
    //                 if($x != "choose")
    //                 {
    //                     array_push($options,$x);
    //                 }
    //             }

    //             if(!empty($options))
    //             {
    //                 foreach($_POST['key_name'] as $key)
    //                 {
    //                     $filter_criteria .= $key." ";
    //                 }

    //                 $count = sizeof($options);
    //                 $last_index = sizeof($options)-1;
    //                 $sql = "";
                    
    //                 foreach($options as $y)
    //                 {
    //                     if($y != $options[$last_index] )
    //                     {
    //                         $options_string .= "'".$y."', ";
    //                     }
    //                 } 
                    
    //                 $options_string .= "'".$options[$last_index]."')";
        
    //                 if($_POST['event_id'] == "select")
    //                 {
    //                     $event_id = "IS NOT NULL";
    //                 }else
    //                 {
    //                     $event_id = "= '".$_POST['event_id']."'";
    //                 }

    //                 if(isset($_POST['filtertype']))
    //                 {
    //                     if($_POST['filtertype'] == "null")
    //                     {
    //                         $sql = "SELECT student.id, student.first_name, student.last_name, student.email, student.mobile_number, 
    //                         student.residence_number, student.address, student_ex.key, student_ex.value FROM student
    //                         LEFT JOIN student_ex ON student.id=student_ex.student_id
    //                         WHERE student_ex.value IN ".$options_string." OR student_ex.value IS NULL AND student.event_id ".$event_id.";";

    //                         $filter_type .= "null";
    //                     }
    //                     else if($_POST['filtertype'] == "intersection")
    //                     {
    //                         $sql = "SELECT student.id, student.first_name, student.last_name, student.email, student.mobile_number, 
    //                         student.residence_number, student.address, student_ex.key, student_ex.value FROM student
    //                         LEFT JOIN student_ex ON student.id=student_ex.student_id
    //                         WHERE student_ex.value IN ".$options_string." AND student.event_id ".$event_id." GROUP BY student.id HAVING COUNT(*) = ".$count.";";

    //                         $filter_type .= "intersection";
    //                     }
    //                     else if($_POST['filtertype'] == "union")
    //                     {
    //                         $sql = "SELECT student.id, student.first_name, student.last_name, student.email, student.mobile_number, 
    //                         student.residence_number, student.address, student_ex.key, student_ex.value FROM student
    //                         LEFT JOIN student_ex ON student.id=student_ex.student_id
    //                         WHERE student_ex.value IN ".$options_string." AND student.event_id ".$event_id." GROUP BY student.id;";

    //                         $filter_type .= "union";
    //                     }
    //                 }
    //                 else
    //                 {
    //                     $sql = "SELECT student.id, student.first_name, student.last_name, student.email, student.mobile_number, 
    //                     student.residence_number, student.address, student_ex.key, student_ex.value FROM student
    //                     LEFT JOIN student_ex ON student.id=student_ex.student_id
    //                     WHERE student_ex.value IN ".$options_string." AND student.event_id ".$event_id." GROUP BY student.id HAVING COUNT(*) = ".$count.";";

    //                     $filter_type .= "intersection";
    //                 }
                
    //                 $this->load->model('adminModel');
    //                 $data['filtered_students'] = $this->adminModel->fetchFilteredStudents($sql);
    //                 $data['query'] = $sql;

    //                 $this->load->view('ExportStudents', $data);

    //             }
    //             else
    //             {
    //                 if(isset($_POST['event_id']))
    //                 {
    //                     $event_id = "= '".$_POST['event_id']."'";

    //                     $sql = "SELECT student.id, student.first_name, student.last_name, student.email, student.mobile_number, 
    //                     student.residence_number, student.address, student_ex.key, student_ex.value FROM student
    //                     LEFT JOIN student_ex ON student.id=student_ex.student_id
    //                     WHERE student.event_id ".$event_id." GROUP BY student.id;";

    //                     $this->load->model('adminModel');
    //                     $data['filtered_students'] = $this->adminModel->fetchFilteredStudents($sql);
    //                     $data['query'] = $sql;

    //                     $this->load->view('ExportStudents', $data);
    //                 }
    //                 else
    //                 {
    //                     echo $sql;

    //                     $this->session->set_flashdata('msg', 'No filter criteria was selected');
    //                     redirect('adminController/allStudents');
    //                 }
    //             }

    //         }
    //     }
    // }
    
    public function viewFilteredStudents()
    {
        $event_id = "";

            if(isset($_POST['event_id']))
            {  
                $events = array();
            
                foreach($_POST['event_id'] as $a)
                {
                    array_push($events,$a);
                }

                
                $event_array = "(";

                if(sizeof($events) != 0)
                {
                    foreach($events as $b)
                    {
                        if($b != $events[sizeof($events)-1])
                        {
                            $event_array .= $b.", ";
                        }
                    }

                    $event_array .= $events[sizeof($events)-1]." )";

                    $event_id .= "IN ".$event_array;
                }
                else
                {
                    $event_id .= "IS NOT NULL";
                }
            }else
            {
                $event_id .= "IS NOT NULL";
            } 

            if(!empty($_POST['option']))
            {
                $filter_criteria = "";
                $filter_type = "";
                // $event_id = $_POST['event_id'];
                $options = array();
                $options_string = "(";
                
                foreach($_POST['option'] as $x)
                {
                    if($x != "choose")
                    {
                        array_push($options,$x);
                    }
                }

                if(!empty($options))
                {
                    foreach($_POST['key_name'] as $key)
                    {
                        $filter_criteria .= $key." ";
                    }

                    $count = sizeof($options);
                    $last_index = sizeof($options)-1;
                    $sql = "";
                    
                    foreach($options as $y)
                    {
                        if($y != $options[$last_index] )
                        {
                            $options_string .= "'".$y."', ";
                        }
                    } 
                    
                    $options_string .= "'".$options[$last_index]."')";
        
                    // if($_POST['event_id'] == "select")
                    // {
                    //     $event_id = "IS NOT NULL";
                    // }else
                    // {
                    //     $event_id = "= '".$_POST['event_id']."'";
                    // }

                    if(isset($_POST['filtertype']))
                    {
                        if($_POST['filtertype'] == "null")
                        {
                            $sql = "SELECT student.id, student.first_name, student.last_name, student.email, student.mobile_number, 
                            student.residence_number, student.address, student_ex.key, student_ex.value FROM student
                            LEFT JOIN student_ex ON student.id=student_ex.student_id
                            WHERE student_ex.value IN ".$options_string." OR student_ex.value IS NULL AND student.event_id ".$event_id.";";

                            $filter_type .= "null";
                        }
                        else if($_POST['filtertype'] == "intersection")
                        {
                            $sql = "SELECT student.id, student.first_name, student.last_name, student.email, student.mobile_number, 
                            student.residence_number, student.address, student_ex.key, student_ex.value FROM student
                            LEFT JOIN student_ex ON student.id=student_ex.student_id
                            WHERE student_ex.value IN ".$options_string." AND student.event_id ".$event_id." GROUP BY student.id HAVING COUNT(*) = ".$count.";";

                            $filter_type .= "intersection";
                        }
                        else if($_POST['filtertype'] == "union")
                        {
                            $sql = "SELECT student.id, student.first_name, student.last_name, student.email, student.mobile_number, 
                            student.residence_number, student.address, student_ex.key, student_ex.value FROM student
                            LEFT JOIN student_ex ON student.id=student_ex.student_id
                            WHERE student_ex.value IN ".$options_string." AND student.event_id ".$event_id." GROUP BY student.id;";

                            $filter_type .= "union";
                        }
                    }
                    else
                    {
                        $sql = "SELECT student.id, student.first_name, student.last_name, student.email, student.mobile_number, 
                            student.residence_number, student.address, student_ex.key, student_ex.value FROM student
                            LEFT JOIN student_ex ON student.id=student_ex.student_id
                            WHERE student_ex.value IN ".$options_string." AND student.event_id ".$event_id." GROUP BY student.id;";

                            $filter_type .= "union";
                    }
                
                    $this->load->model('adminModel');
                    $data['filtered_students'] = $this->adminModel->fetchFilteredStudents($sql);
                    $data['query'] = $sql;

                    $this->load->view('ExportStudents', $data);

                }
            }
                else
                {
                    if(!isset($_POST['event_id']))
                    {
                        $this->session->set_flashdata('msg', 'Select atleast one filter option or event');
                        redirect('adminController/createSubGroup');
                    }
                    else
                    {
                        // $event_id = "= '".$_POST['event_id']."'";

                        $sql = "SELECT student.id, student.first_name, student.last_name, student.email, student.mobile_number, 
                        student.residence_number, student.address, student_ex.key, student_ex.value FROM student
                        LEFT JOIN student_ex ON student.id=student_ex.student_id WHERE student.event_id ".$event_id." GROUP BY student.id;";

                        $this->load->model('adminModel');
                        $data['filtered_students'] = $this->adminModel->fetchFilteredStudents($sql);
                        $data['query'] = $sql;

                        $this->load->view('ExportStudents', $data);
                    }
                }      
    }

    public function viewAllStudents()
    {
        $this->load->model('adminModel');
        $data['student'] = $this->adminModel->fetchAllStudents();
        $data['TLEs'] = $this->adminModel->fetchTLES();
        $data['main_groups'] = $this->adminModel->fetchMainGroups();

        $this->load->view('CreateMainGroup', $data);
    }

    public function moveToExistingGroup()
    {
        if(isset($_POST['submittwo']))
        {
            if(!empty($_POST['student_id']))
            {
                $student_id = $_POST['student_id'];
                $group_id = $_POST['group_id'];
                
                $this->load->model('adminModel');
                $this->adminModel->moveStudentsMG($group_id,$student_id);

                $data['student'] = $this->adminModel->fetchAllStudents();
                $data['TLEs'] = $this->adminModel->fetchTLES();
                $data['main_groups'] = $this->adminModel->fetchMainGroups();

                $this->load->view('CreateMainGroup', $data);                

            }
        }
    }

    public function createNewMainGroup()
    {
        if(isset($_POST['newgroup']))
        {
            if(!empty($_POST['student_id']))
            {
                $user_name = $this->adminModel->fetchTmeName($_POST['tme']);
                
                $title = "Leads group -".$user_name;
                $tme = $_POST['tme'];

                $this->load->model('adminModel');
                $group_id = $this->adminModel->newMainGroup($title, $tme);

                $student_id = $_POST['student_id'];

                $this->addStudentsMG($student_id, $group_id);
                $this->adminModel->insertLeads($student_id, $group_id);

                $data['CCs'] = $this->adminModel->fetchCourseCounselors();
                $data['student'] = $this->adminModel->fetchLeads();
        
                $this->load->view('CreateLeadsGroup', $data);
            }
        }
    }

    public function viewSubGroupQuestionnaire()
    {
        $group_id= $this->input->get('group_id');
        $data['group_title'] = $this->input->get('group_title');
        $data['tme_name'] = $this->input->get('tme_name');
        $data['gid'] = $this->input->get('group_id');

        $this->load->model('adminModel');
        $data['questionnaire'] = $this->adminModel->fetchSubGroupQuestionnaire($group_id);
        $data['other_ques'] = $this->adminModel->fetchOtherQuestionnaireSG($group_id);


        $this->load->view('SubGroupQuestionnaire', $data);
    }

    public function viewMainGroupQuestionnaire()
    {
        $group_id= $this->input->get('group_id');
        $data['group_title'] = $this->input->get('group_title');
        $data['tme_name'] = $this->input->get('tme_name');
        $data['gid'] = $this->input->get('group_id');

        $this->load->model('adminModel');
        $data['questionnaire'] = $this->adminModel->fetchMainGroupQuestionnaire($group_id);
        $data['other_ques'] = $this->adminModel->fetchOtherQuestionnaireMG($group_id);

        $this->load->view('MainGroupQuestionnaire', $data);
    }

    public function removeMGQuestionnaire()
    {
        if(isset($_POST['submitOne']))
        {
            if(!empty($_POST['questionnaire_id']))
            {
                $group_id= $this->input->get('group_id');
                $data['group_title'] = $this->input->get('group_title');
                $data['tme_name'] = $this->input->get('tme_name');
                $data['gid'] = $this->input->get('group_id');
                $questionnaire_id = $_POST['questionnaire_id'];

                $this->load->model('adminModel');
                $this->adminModel->removeMGQuestionnaire($group_id,$questionnaire_id);  
                
                $data['questionnaire'] = $this->adminModel->fetchMainGroupQuestionnaire($group_id);
                $data['other_ques'] = $this->adminModel->fetchOtherQuestionnaireMG($group_id);

                $this->load->view('MainGroupQuestionnaire', $data);

            }
        }
    }

    public function removeSGQuestionnaire()
    {
        if(isset($_POST['submitOne']))
        {
            if(!empty($_POST['questionnaire_id']))
            {
                $group_id= $this->input->get('group_id');
                $data['group_title'] = $this->input->get('group_title');
                $data['tme_name'] = $this->input->get('tme_name');
                $data['gid'] = $this->input->get('group_id');
                $questionnaire_id = $_POST['questionnaire_id'];

                $this->load->model('adminModel');
                $this->adminModel->removeSGQuestionnaire($group_id,$questionnaire_id);  
                
                $data['questionnaire'] = $this->adminModel->fetchSubGroupQuestionnaire($group_id);
                $data['other_ques'] = $this->adminModel->fetchOtherQuestionnaireSG($group_id);

                $this->load->view('SubGroupQuestionnaire', $data);

            }
        }
    }

    public function addMGQuestionnaire()
    {
        if(isset($_POST['submitTwo']))
        {
                $group_id= $this->input->get('group_id');
                $data['group_title'] = $this->input->get('group_title');
                $data['tme_name'] = $this->input->get('tme_name');
                $data['gid'] = $this->input->get('group_id');
                $questionnaire_id = $_POST['questionnaire'];

                $this->load->model('adminModel');
                $this->adminModel->addMGQuestionnaire($group_id,$questionnaire_id);  
                
                $data['questionnaire'] = $this->adminModel->fetchMainGroupQuestionnaire($group_id);
                $data['other_ques'] = $this->adminModel->fetchOtherQuestionnaireMG($group_id);

                $this->load->view('MainGroupQuestionnaire', $data);
        }
    }

    public function addSGQuestionnaire()
    {
        if(isset($_POST['submitTwo']))
        {
                $group_id= $this->input->get('group_id');
                $data['group_title'] = $this->input->get('group_title');
                $data['tme_name'] = $this->input->get('tme_name');
                $data['gid'] = $this->input->get('group_id');
                $questionnaire_id = $_POST['questionnaire'];

                $this->load->model('adminModel');
                $this->adminModel->addSGQuestionnaire($group_id,$questionnaire_id);  
                
                $data['questionnaire'] = $this->adminModel->fetchSubGroupQuestionnaire($group_id);
                $data['other_ques'] = $this->adminModel->fetchOtherQuestionnaireSG($group_id);

                $this->load->view('SubGroupQuestionnaire', $data);

        }
    }

    public function deleteMainGroup()
    {
        $group_id = $this->input->get('group_id');

        $this->load->model('adminModel');
        $this->adminModel->deleteMainGroup($group_id);

        $this->mainGroups();
    }

    public function deleteLeadsGroup()
    {
        $group_id = $this->input->get('group_id');

        $this->load->model('adminModel');
        $this->adminModel->deleteLeadsGroup($group_id);

        $this->LeadsGroups();
    }
    
    public function removeLead()
    {
         $this->load->model('adminModel');
         $this->adminModel->removeLead($_GET['student_id']);
         $this->viewLeads();
    }

    // public function createGroup()
    // {
    //     $student_id = $_POST['student_id'];
    //     $title = $_POST['title'];
    //     $filter_criteria = $_POST['filter_criteria'];
    //     $filter_type = $_GET['filter_type'];
        
    //     $user_id;
    //     if(isset($_POST['assigntme']))
    //     {
    //         $user_id = $_POST['tme'];
    //     }
    //     if(isset($_POST['assigncc']))
    //     {
    //         $user_id = $_POST['cc'];
    //     }
    //     $user_id;

    //     $event_id;
    //     if($_GET['event_id'] == "select")
    //     {
    //         $event_id = 0;
    //     }
    //     else
    //     {
    //         $event_id = $_GET['event_id'];
    //     }
    //     $event_id;

    //     $this->load->model('adminModel');
    //     $group_id = $this->adminModel->createGroup($title, $user_id, $event_id, $filter_criteria, $filter_type);

    //     $this->addStudentsMG($student_id, $group_id);

    //     echo 'successfull';
    // }
    
     public function createGroup()
    {
        
        if(isset($_POST['move']))
        {
            echo 'yes';
        }
        
        // $this->load->model('adminModel');
        // $user_name = $this->adminModel->fetchTmeName($_POST['tme']);
        // $project_name = $this->adminModel->fetchProjectName($_POST['project']);

        // $student_id = $_POST['student_id'];
        // $title = $project_name." - ".$user_name;
        // $filter_criteria = $_GET['filter_criteria'];
        // $filter_type = $_GET['filter_type'];
        // $user_id = $_POST['tme'];
        // $event_id = $_GET['event_id'];
        // $project_id = $_POST['project']; 


        // $this->load->model('adminModel');
        // $group_id = $this->adminModel->createGroup($title, $user_id, $event_id, $filter_criteria, $filter_type, $project_id);

        // $this->addStudentsMG($student_id, $group_id);

        // $this->session->set_flashdata('msgone', 'Successfully created the group');
        // //redirect('adminController/createSubGroup');
        // $this->createSubGroup();
    }
    
    
    public function movestudents()
    {
        echo 'yes';
    }

    public function filterGroups()
    {
        $output = '';
        $data = '';
        $data1 = '';
        $data2 = '';
        $data3 = '';

        $data1 = $this->input->post('data1');
        $data2 = $this->input->post('data2');
        $data3 = $this->input->post('data3');

        $this->load->model('adminModel');
        $data = $this->adminModel->filterGroups($data1,$data2,$data3);

        if($data->num_rows() > 0)
        {
            foreach($data->result() as $row)
            {
            $output .= "
            <ul class=\"list-group list-group-flush\">
            <li class=\"list-group-item d-flex justify-content-between align-items-center\">$row->title
            <div class=\"btn-group\" role=\"group\" aria-label=\"Basic example\">
            <a class=\"btn btn-outline-info btn-sm\" href=\"viewMainGroup?group_id=$row->id&group_title=$row->title&tme_name=$row->first_name $row->last_name\">View details</a>
            <a class=\"btn btn-outline-warning btn-sm\" href=\"viewMainGroupQuestionnaire?group_id=$row->id&group_title=$row->title&tme_name=$row->first_name $row->last_name\">Questionnaire</a>
            <a class=\"btn btn-outline-danger btn-sm\" data-toggle=\"modal\" data-target=\"#exampleModalTwo\">delete</a>
            </div>
            </li>
            </ul>

            ";
            
             $gid = $row->id;
            }
            
            $output .= "
            <div class=\"modal fade\" id=\"exampleModalTwo\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"exampleModalLabel\" aria-hidden=\"true\">
                      <div class=\"modal-dialog\" role=\"document\">
                        <div class=\"modal-content\">
                          <div class=\"modal-header\">
                            <h5 class=\"modal-title\" id=\"exampleModalLabel\">Remove students</h5>
                            <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
                              <span aria-hidden=\"true\">&times;</span>
                            </button>
                          </div>
                          <div class=\"modal-body\">
                                Are you sure to romove the selected set of students from the group?
                          </div>
                          <div class=\"modal-footer\">
                            <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Close</button>
                            <a class=\"btn btn-info\" href=\"deleteMainGroup?group_id=$gid\">Yes</a>
                          </div>
                        </div>
                      </div>
                    </div>
            ";
            
        }else
        {
            $output .= "
            <ul class=\"list-group list-group-flush\">
            <li class=\"list-group-item d-flex justify-content-between align-items-center\">No data found
            </li>
            </ul>
            ";
        }

        echo $output;
    }



        public function exportAllStudents(){
            
            $this->load->library("excel");
                $object = new PHPExcel();
                $form_name = 'all students';
                
                 $this->load->model("adminModel");
                 $student = $this->adminModel->fetchAllStudents();
                
        
                $object->setActiveSheetIndex(0);
                    $table_columns = array("First Name", "Last Name", "Email", "Mobile Number" , "Residence Number", "Address");
                    
                    $column = 0;
                foreach($table_columns as $field)
                {
                    $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
                    $column++;
                }
                
                $rowCount = 2;
                 foreach ($student->result_array() as $element) {
                    $object->getActiveSheet()->SetCellValue('A' . $rowCount, $element['first_name']);
                    $object->getActiveSheet()->SetCellValue('B' . $rowCount, $element['last_name']);
                    $object->getActiveSheet()->SetCellValue('C' . $rowCount, $element['email']);
                    $object->getActiveSheet()->SetCellValue('D' . $rowCount, $element['mobile_number']);
                    $object->getActiveSheet()->SetCellValue('E' . $rowCount, $element['residence_number']);
                    $object->getActiveSheet()->SetCellValue('E' . $rowCount, $element['address']);
                     $rowCount++;
                }
        
                $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="'.$form_name.'.xls"');
                $object_writer->save('php://output');
        
        }



        public function exportFilteredStudents(){
            
            $this->load->library("excel");
                $object = new PHPExcel();
                $form_name = 'student list';
                
                 $this->load->model("adminModel");
                 $student = $this->adminModel->fetchFilteredStudents($_GET['query']);
                
        
                $object->setActiveSheetIndex(0);
                    $table_columns = array("First Name", "Last Name", "Email", "Mobile Number" , "Residence Number", "Address");
                    
                    $column = 0;
                foreach($table_columns as $field)
                {
                    $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
                    $column++;
                }
                
                $rowCount = 2;
                 foreach ($student->result_array() as $element) {
                    $object->getActiveSheet()->SetCellValue('A' . $rowCount, $element['first_name']);
                    $object->getActiveSheet()->SetCellValue('B' . $rowCount, $element['last_name']);
                    $object->getActiveSheet()->SetCellValue('C' . $rowCount, $element['email']);
                    $object->getActiveSheet()->SetCellValue('D' . $rowCount, $element['mobile_number']);
                    $object->getActiveSheet()->SetCellValue('E' . $rowCount, $element['residence_number']);
                    $object->getActiveSheet()->SetCellValue('E' . $rowCount, $element['address']);
                     $rowCount++;
                }
        
                $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="'.$form_name.'.xls"');
                $object_writer->save('php://output');
        
        }



    public function eventForms(){
        if($this->input->get())
        {
            $event_id = $this->input->get('event_id');
            $event_title = $this->input->get('event_title');

            $this->load->model('adminModel');
            $data['forms'] = $this->adminModel->fetchEventForm($event_id);
            $data['other_forms'] = $this->adminModel->fetchOtherforms($event_id);
            $data['event_id'] = $event_id;
            $data['event_title'] = $event_title;
            
            $this->load->view('EventForms', $data);

        }
    }

    public function addEventForms()
    {
        if(isset($_POST['submitTwo']))
        {
                $event_id= $this->input->get('event_id');
                $data['event_title'] = $this->input->get('event_title');
                $data['event_id'] = $this->input->get('event_id');
                $form_id = $_POST['form'];

                $this->load->model('adminModel');
                $this->adminModel->addEventForm($event_id,$form_id);  
                
                $data['forms'] = $this->adminModel->fetchEventForm($event_id);
                $data['other_forms'] = $this->adminModel->fetchOtherforms($event_id);

                $this->load->view('EventForms', $data);
        }
    }

    public function removeEventForm()
    {
        if(isset($_POST['submitOne']))
        {
            if(!empty($_POST['form_id']))
            {
                $event_id= $this->input->get('event_id');
                $data['event_title'] = $this->input->get('event_title');
                $data['event_id'] = $this->input->get('event_id');
                $form_id = $_POST['form_id'];

                $this->load->model('adminModel');
                $this->adminModel->removeEventForm($event_id,$form_id);   
                
                $data['forms'] = $this->adminModel->fetchEventForm($event_id);
                $data['other_forms'] = $this->adminModel->fetchOtherforms($event_id);

                $this->load->view('EventForms', $data);

            }
        }
    }
    
    public function saveProject()
    {
        echo 'yes';
        if(isset($_POST['submit']))
        {
            $this->load->model('adminModel');
            $this->adminModel->saveProject($_POST['title']);

            $this->session->set_flashdata('scpmsg', 'Successfully created the project');
            redirect('adminController/createProject');
        }
    }
    
    
    
    //warren
        public function logViewGroups(){
            $this->load->model('adminModel');
            $data['main_groups'] = $this->adminModel->fetchMainGroups();
    
            $this->load->view('LogViewGroups', $data);
        }
    
           public function logMainGroup()
        {
            if($this->input->get())
            {
                $group_id= $this->input->get('group_id');
                $data['group_title'] = $this->input->get('group_title');
                $data['tme_name'] = $this->input->get('tme_name');
                $data['gid'] = $this->input->get('group_id');
    
                $this->load->model('adminModel');
                $data['members'] = $this->adminModel->fetchGroupMembers($group_id);
                $data['TLEs'] = $this->adminModel->fetchTLES();
                $data['main_groups'] = $this->adminModel->fetchOtherMainGroups($group_id);
    
                $this->load->view('LogMainGroup', $data);
            }
            
        }

        public function logStudent(){
            if($this->input->get()){
                $id = $this->input->get('student_id');
                $this->load->model('adminModel');
                $data['details'] = $this->adminModel->studentLog($id);
                $data['exDetails'] = $this->adminModel->studentLogEx($id);
                $this->load->view('LogStudent',$data);  
    
    
            }

        }
        public function get_student($lid = FALSE){
            $this->db->order_by('posts.lid','DESC');
            $this->db->join('categories','categories.id=posts.category_id');
            $this->db->join('schoolcontacts','schoolcontacts.cid=posts.cid');
            $this->db->join('user','user.uid=posts.uid');
            $this->db->join('flags','flags.flag=posts.flag');
            // $this->db->where('posts.flag',1);
            
        if ($lid == FALSE){
            $query = $this->db->get('posts');
            return $query->result_array()   ;
        }
        $query = $this->db->get_where('posts',array('lid' => $lid));
        return $query->row_array();
    }
        //followup features
    public function viewFollowups(){
        $follow_id = $this->input->get('follow_id');
        $data['followups'] = $this->adminModel->fetchFollowups($follow_id);
        $this->load->view('ViewFollowups',$data);
    }
    public function viewFollowupTypes(){
        $data['types'] = $this->adminModel->fetchFollowupTypes();
        $this->load->view('ViewFollowupTypes',$data);
    }
    public function addFollowup()
        {   
            $name = $this->input->post('followupType');
            $this->adminModel->addFollowup($name);
            $this->viewFollowupTypes();
            
        }
        
    //new log features
        function viewLogStudentDetails(){
            $id = $this->input->get('sid');
            $data['remarks'] = $this->adminModel->remarkDetails($id);
            $group_id = $this->input->get('group_id');
            $this->load->model('Student_search_model');
            $data['student_data'] = $this->Student_search_model->edit_Student($id);
            $data['student_ex_data'] = $this->Student_search_model->edit_Student_Ex($id);
            $data['group_id'] = $group_id;
            $this->load->view('ViewLogStudent',$data);

        }











    }
