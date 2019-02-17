<!-- Sidebar -->

<ul class="sidebar navbar-nav">
    <li class="nav-item active">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

<!--    Admin Functions -->

    <?php if ($this->session->userdata('type') == 'Admin'): ?>


    <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fa fa-user-circle"></i>
            <span>Users</span>
          </a>
          <div class="dropdown-menu" aria-labelledby="pagesDropdown">
            <a class="dropdown-item" href="<?php echo base_url();?>index.php/adminController/userRegistration">Register User</a>
            <a class="dropdown-item" href="<?php echo base_url();?>index.php/adminController/manageUser">Manage User</a>
            <a class="dropdown-item" href="<?php echo base_url();?>index.php/adminController/assignUsers">Assign User Access</a>
          </div>
    </li>
    
    <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fa fa-calendar"></i>
            <span>Events</span>
          </a>
          <div class="dropdown-menu" aria-labelledby="pagesDropdown">
            <a class="dropdown-item" href="<?php echo base_url();?>index.php/adminController/createEvent">Create Event</a>
              <a class="dropdown-item" href="<?php echo base_url();?>index.php/adminController/viewEvents">View</a>
          </div>
    </li>
    
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-graduation-cap"></i>
            <span>Students</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
            <a class="dropdown-item" href="<?php echo base_url();?>index.php/adminController/addStudent">Add Student</a>
            <a class="dropdown-item" href="<?php echo base_url();?>index.php/adminController/importStudents">Import Student List</a>
            <a class="dropdown-item" href="<?php echo base_url();?>index.php/adminController/manageStudents">Manage Students</a>
            <a class="dropdown-item" href="<?php echo base_url();?>index.php/adminController/allStudents">Search Students</a>
        </div>
    </li>
    
    <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fa fa-th-large"></i>
            <span>Projects</span>
          </a>
          <div class="dropdown-menu" aria-labelledby="pagesDropdown">
            <a class="dropdown-item" href="<?php echo base_url();?>index.php/adminController/createProject">Create new project</a>
             <a class="dropdown-item" href="<?php echo base_url();?>index.php/adminController/viewProjects">View projects</a>
          </div>
    </li>
    
    <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-users"></i>
            <span>Groups</span>
          </a>
          <div class="dropdown-menu" aria-labelledby="pagesDropdown">
            <a class="dropdown-item" href="<?php echo base_url();?>index.php/adminController/mainGroups">Manage groups</a>
            <a class="dropdown-item" href="<?php echo base_url();?>index.php/adminController/createSubGroup">Create new group</a>
          </div>
    </li>
    
    <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fa fa-graduation-cap"></i>
            <span>Leads</span>
          </a>
          <div class="dropdown-menu" aria-labelledby="pagesDropdown">
            <a class="dropdown-item" href="<?php echo base_url();?>index.php/adminController/ViewLeads">View leads</a>
            <a class="dropdown-item" href="<?php echo base_url();?>index.php/adminController/CreateLeadsGroup">Assign Leads</a>
            <a class="dropdown-item" href="<?php echo base_url();?>index.php/adminController/LeadsGroups">View leads groups</a>
          </div>
    </li>



     <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fa fa-file"></i>
            <span>Forms</span>
          </a>
          <div class="dropdown-menu" aria-labelledby="pagesDropdown">
            <a class="dropdown-item" href="<?php echo base_url();?>index.php/newform/createAForm">Create forms</a>
            <a class="dropdown-item" href="<?php echo base_url();?>index.php/newform/viewForms">Manage form</a>
          </div>
    </li>
    <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-question"></i>
            <span>Manage Form Fields</span>
          </a>
          <div class="dropdown-menu" aria-labelledby="pagesDropdown">
            <a class="dropdown-item" href="<?php echo base_url();?>index.php/newform/changeAllOptionView">View Form Field</a>
          </div>
    </li>
    
	 <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-question"></i>
            <span>Questionnaire</span>
          </a>
          <div class="dropdown-menu" aria-labelledby="pagesDropdown">
            <a class="dropdown-item" href="<?php echo base_url();?>index.php/newformquestion/createAForm">Create questinnaire</a>
            <a class="dropdown-item" href="<?php echo base_url();?>index.php/newformquestion/viewForms">Manage questionnaire</a>
          </div>
    </li>
    

    


    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url();?>index.php/adminController/viewFollowupTypes">
            <i class="fa fa-phone-square"></i>
            <span>Follow-ups</span></a>
    </li>

    


    <?php endif; ?>
<!--    Manager Functions-->
    <?php if ($this->session->userdata('type') == 'Manager'): ?>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-user-circle"></i>
                <span>Users</span>
            </a>
            <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                <a class="dropdown-item" href="<?php echo base_url();?>index.php/adminController/userRegistration">Register User</a>
                <a class="dropdown-item" href="<?php echo base_url();?>index.php/adminController/manageUser">Manage User</a>
                <a class="dropdown-item" href="<?php echo base_url();?>index.php/adminController/assignUsers">Assign User Access</a>
            </div>
        </li>
        
         <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-calendar"></i>
                <span>Events</span>
            </a>
            <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                <a class="dropdown-item" href="<?php echo base_url();?>index.php/adminController/createEvent">Create Event</a>
                <a class="dropdown-item" href="<?php echo base_url();?>index.php/adminController/viewEvents">View</a>
                <a class="dropdown-item" href="<?php echo base_url();?>index.php/adminController/uploadEventDetails">Upload new</a>
            </div>
        </li>
        
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-graduation-cap"></i>
                <span>Students</span>
            </a>
            <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                <a class="dropdown-item" href="<?php echo base_url();?>index.php/adminController/addStudent">Add Student</a>
                <a class="dropdown-item" href="<?php echo base_url();?>index.php/adminController/importStudents">Import Student List</a>
                <a class="dropdown-item" href="<?php echo base_url();?>index.php/adminController/manageStudents">Manage Students</a>
                <a class="dropdown-item" href="<?php echo base_url();?>index.php/adminController/allStudents">Search Students</a>
            </div>
        </li>
        
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fa fa-th-large"></i>
            <span>Projects</span>
          </a>
          <div class="dropdown-menu" aria-labelledby="pagesDropdown">
            <a class="dropdown-item" href="<?php echo base_url();?>index.php/adminController/createProject">Create new project</a>
             <a class="dropdown-item" href="<?php echo base_url();?>index.php/adminController/viewProjects">View projects</a>
          </div>
    </li>
    
    <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-users"></i>
            <span>Groups</span>
          </a>
          <div class="dropdown-menu" aria-labelledby="pagesDropdown">
            <a class="dropdown-item" href="<?php echo base_url();?>index.php/adminController/mainGroups">Manage groups</a>
            <a class="dropdown-item" href="<?php echo base_url();?>index.php/adminController/createSubGroup">Create new group</a>
          </div>
    </li>
        
       <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fa fa-graduation-cap"></i>
            <span>Leads</span>
          </a>
          <div class="dropdown-menu" aria-labelledby="pagesDropdown">
            <a class="dropdown-item" href="<?php echo base_url();?>index.php/adminController/ViewLeads">View leads</a>
            <a class="dropdown-item" href="<?php echo base_url();?>index.php/adminController/CreateLeadsGroup">Assign Leads</a>
            <a class="dropdown-item" href="<?php echo base_url();?>index.php/adminController/LeadsGroups">View leads groups</a>
          </div>
    </li>


       

       <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fa fa-file"></i>
            <span>Forms</span>
          </a>
          <div class="dropdown-menu" aria-labelledby="pagesDropdown">
            <a class="dropdown-item" href="<?php echo base_url();?>index.php/newform/createAForm">Create forms</a>
            <a class="dropdown-item" href="<?php echo base_url();?>index.php/newform/viewForms">Manage form</a>
          </div>
    </li>
    <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-question"></i>
            <span>Manage Form Fields</span>
          </a>
          <div class="dropdown-menu" aria-labelledby="pagesDropdown">
            <a class="dropdown-item" href="<?php echo base_url();?>index.php/newform/changeAllOptionView">View Form Field</a>
          </div>
    </li>
	 <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-question"></i>
            <span>Questionnaire</span>
          </a>
          <div class="dropdown-menu" aria-labelledby="pagesDropdown">
            <a class="dropdown-item" href="<?php echo base_url();?>index.php/newformquestion/createAForm">Create questinnaire</a>
            <a class="dropdown-item" href="<?php echo base_url();?>index.php/newformquestion/viewForms">Manage questionnaire</a>
          </div>
    </li>

   

    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url();?>index.php/adminController/viewFollowupTypes">
            <i class="fa fa-phone-square"></i>
            <span>Follow-ups</span></a>
    </li>



    <?php endif; ?>
<!--    Course Councilor-->
    <?php if ($this->session->userdata('type') == 'Course Counselor'): ?>
    
    <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url();?>index.php/teleController/teleGroups">
            <i class="fa fa-id-card"></i>
            <span>Allocated Groups</span></a>
    </li>
    





    <?php endif; ?>
<!--    Telemarketing Executive-->
    <?php if ($this->session->userdata('type') == 'Tele Marketing Executive'): ?>
    
    
    <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url();?>index.php/teleController/teleGroups">
            <i class="fa fa-id-card"></i>
            <span>Allocated Groups</span></a>
    </li>




    <?php endif; ?>
    
    
    <!--    Data Entry Operator-->
<?php if ($this->session->userdata('type') == 'Data Entry Operator'): ?>
    
    <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-id-card"></i>
                <span>Students</span>
            </a>
            <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                <a class="dropdown-item" href="<?php echo base_url();?>index.php/adminController/addStudent">Add Student</a>
                <a class="dropdown-item" href="<?php echo base_url();?>index.php/adminController/manageStudents">Manage Students</a>
            </div>
        </li>
    
    




    <?php endif; ?>


    <!-- <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url();?>index.php/adminController/userRegistration">
            <i class="fas fa-id-card"></i>
            <span>User Registration</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url();?>index.php/adminController/manageUser">
            <i class="fas fa-edit"></i>
            <span>Manage Users</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url();?>index.php/adminController/createFormFields">
            <i class="fas fa-file"></i>
            <span>Create Form Fields</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url();?>index.php/adminController/uploadEventDetails">
            <i class="fas fa-upload"></i>
            <span>Upload Event Details</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url();?>index.php/adminController/createQuestionnaire">
            <i class="fas fa-question"></i>
            <span>Create Questionnaire</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url();?>index.php/adminController/generateReports">
            <i class="fas fa-pen"></i>
            <span>Generate Reports</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url();?>index.php/adminController/viewLogs">
            <i class="fas fa-landmark"></i>
            <span>View Log and Student Details</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url();?>index.php/adminController/studentGroups">
            <i class="fas fa-file"></i>
            <span>Create Student Groups</span></a>
    </li> -->

</ul>