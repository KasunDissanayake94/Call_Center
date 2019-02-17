<?php

class FormModelquestion extends CI_Model {

    public function saveFormName($data){
        $newData = array(
            'title' => $data['formname']
        );
        
        $this->db->insert('questionnaire',$newData);

        
        $this->db->select('id');
        $this->db->from('questionnaire');
        $this->db->where('title',$data['formname']);
        return $this->db->get()->row()->id;
    }
    public function getCurrentKeyNames(){
        $this->db->distinct();
        $this->db->select("name"); 
        $this->db->select("id"); 
        $this->db->from('keys_table');
        $query = $this->db->get();
        return $query->result();
    }
    
    public function saveInFormFieldTable($formFieldTable){
        $newData = array(
            'questionnaire_id' => $formFieldTable['form_id'],
            'key_id' => $formFieldTable['key_id']
        );
        $this->db->insert('question',$newData);
      return 'inserted to form field table';
    }

    public function saveInFormElement($element_id){
        $newData = array(
            'element_id' => $element_id
        );
        $this->db->insert('form_element',$newData);
        $form_element_id = $this->db->insert_id();
        return $form_element_id;

    }
    public function saveInFormElementWithOptions($element_id,$optons){
        $newData = array(
            'element_id' => $element_id,
            'options' => $optons
        );
        $this->db->insert('form_element',$newData);
        $form_element_id = $this->db->insert_id();
        return $form_element_id;

    }
    public function saveInKeysTable( $formElementId, $form_field_name){
        $newData = array(
            'form_element_id' => $formElementId,
            'name' => $form_field_name
        );
        $this->db->insert('keys_table',$newData);
        $key_id = $this->db->insert_id();
        return $key_id;
    }

    public function saveInFormField( $formId, $keyId){
        $newData = array(
            'questionnaire_id' => $formId,
            'key_id' => $keyId
        );
        $this->db->insert('question',$newData);
        $key_id = $this->db->insert_id();
        return 'fully inserted';
    }



    public function getTextFields(){
        $this->db->select('*');
        $this->db->from('keys_table');
        $this->db->join('form_element', 'form_element.id = keys_table.form_element_id',true);
        $this->db->where('form_element.element_id', 1);
        $query = $this->db->get();
        
        return $query->result();
    
    }

    public function getDropDowns(){
       
        $this->db->select('*');
        $this->db->from('keys_table');
        $this->db->join('form_element', 'form_element.id = keys_table.form_element_id',true);
        $this->db->where('form_element.element_id',2);
        $query = $this->db->get();
        
        return $query->result();
    }

    public function getCheckBoxes(){
        $this->db->select('*');
        $this->db->from('keys_table');
        $this->db->join('form_element', 'form_element.id = keys_table.form_element_id',true);
        $this->db->where('form_element.element_id', 3);
        $query = $this->db->get();
        
        return $query->result();
    }

    public function getOptionString($data){
        $this->db->from('form_element');
 
        $this->db->where('id', $data['form_element_id']);
        
        $query = $this->db->get();
        
         if($query->num_rows()>0) {      
            $data = $query->row_array();     
            $value = $data['options'];       
            return $value;
        }
        
    }

    public function updateOptions($data){
        
        $updateData = array(
            'options'=> $data['options']
         );
         $this->db->where('id', $data['form_element_id']);
         $this->db->update('form_element', $updateData); 
        
    }

// form management
public function selectForms(){
	$this->db->select('*');
	$form_data = $this->db->get('questionnaire');
	if($form_data->num_rows() > 0)
	{
		foreach ($form_data->result() as $row)
		{
			$data[] = $row;
		}
		return $data;
	}
}

public function getFormName($form_id){
	$this->db->where('id',$form_id);
	$this->db->select('title');
	$user_data = $this->db->get('questionnaire');
	if($user_data->num_rows() > 0)
	{
		return $user_data->row(0)->title;
	}
	return false;
}


public function getFormFields($form_id){

	$this->db->select('keys_table.name,form_element.id,element.title,form_element.options');
	$this->db->from('keys_table');
	$this->db->join('question','question.key_id=keys_table.id');
	$this->db->join('form_element','form_element.id=keys_table.form_element_id');
	$this->db->join('element','element.id=form_element.element_id');
	$this->db->where('question.questionnaire_id', $form_id);


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

public function deleteForm($form_id){
	$this->db->where('questionnaire_id', $form_id);
	$this->db->delete('question');

	$this->db->where('id', $form_id);
	$this->db->delete('questionnaire');

	
	return true;

}




}
