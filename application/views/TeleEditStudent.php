<!--Header Start-->
<?php
$this->load->view('header');
?>
<!--Header End-->


<body id="page-top">

<!--Nav Bar Start-->
<?php
$this->load->view('navbar');
?>
<!--Nav Bar End-->

<div id="wrapper">
    <!--Side Bar Start-->
    <?php
    $this->load->view('sidebar');
    ?>
    <!--Side Bar End-->

    <div id="content-wrapper">

        <div class="container-fluid">

            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Student Details</li>
            </ol>



            <!-- Area Chart Example-->
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-chart-area"></i>
                    Basic Student Details</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <a class="btn btn-info btn-md" href="teleViewGroup?group_id=<?php echo $_GET['group_id'] ?>">Back to Group</a>
                            <button type="button" class="btn btn-warning btn-md" data-toggle="modal" data-target="#myModal">Call Back Later</button>
                            <hr>
                            <form action="<?php echo base_url();?>teleController/addStudentManually" method="POST">

                                <?php if($this->session->flashdata('edit_success')):  ?>
                                    <div class="alert alert-success" role="alert">
                                        <?php echo $this->session->flashdata('edit_success');?>
                                    </div>
                                <?php endif;?>

                                <?php if($this->session->flashdata('edit_failed')):  ?>
                                    <div class="alert alert-danger" role="alert">
                                        <?php echo $this->session->flashdata('edit_failed');?>
                                    </div>
                                <?php endif;?>
                                <div>
                                <input type="text"   hidden readonly value="<?php echo $qid; ?>" name="qid" class="form-control" placeholder="Address" >
                                <input type="text"   hidden readonly value="<?php echo $_GET['group_id']; ?>" name="gid" class="form-control" placeholder="Address" >
                                <input type="text"   hidden readonly value="<?php echo $userid; ?>" name="userid" class="form-control" placeholder="Address" >
                                <?php
                                /* first we will make sure we have data to display. $users variable is actually the $data['users'] that we sent from the controller to the view... */
                                foreach ($student_data as $perreq)
                                {
                                    echo "
                                <div class=\"form-group\">
                                <div class=\"form-row\">
                                        <div class=\"col-md-6\">
                                        
                                            <div class=\"form-label-group\">
                                                <input type=\"text\" id='$perreq->title' value='$perreq->title' readonly name=\"first_name\" class=\"form-control\" placeholder=\"title\" required=\"required\">
                                                <label for='$perreq->title'>Title</label>
                                            </div>
                                        </div>
                                        

                                        

                                    </div>
                                    <br>
                                    <div class=\"form-row\">
                                        <div class=\"col-md-6\">
                                        
                                            <div class=\"form-label-group\">
                                                <input type=\"text\" id='$perreq->first_name' value='$perreq->first_name' readonly name=\"first_name\" class=\"form-control\" placeholder=\"First name\" required=\"required\">
                                                <label for='$perreq->first_name'>First name</label>
                                            </div>
                                        </div>
                                        <input type=\"text\" id=\"id\" name=\"id\" value='$perreq->id' readonly class=\"form-control\" required=\"required\" hidden autofocus=\"autofocus\">

                                        <div class=\"col-md-6\">
                                            <div class=\"form-label-group\">
                                                <input type=\"text\" id=\"lastName\" value='$perreq->last_name' readonly name=\"last_name\" class=\"form-control\" placeholder=\"Last name\" required=\"required\">
                                                <label for=\"lastName\">Last name</label>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class=\"form-group\">
                                    <div class=\"form-row\">
                                        <div class=\"col-md-6\">
                                            <div class=\"form-label-group\">
                                                <input type=\"email\" value='$perreq->email'  readonly id=\"inputEmail\" name=\"email\" class=\"form-control\" placeholder=\"Email address\" required=\"required\">
                                                <label for=\"inputEmail\">Email address</label>
                                            </div>
                                        </div>
                                       <div class=\"col-md-6\">
                                    <div class=\"form-label-group\">
                                        <input type=\"text\" id=\"inputEmail\" value='$perreq->address' readonly name=\"address\" class=\"form-control\" placeholder=\"Email address\" required=\"required\">
                                        <label for=\"inputEmail\">Home Address</label>
                                    </div>
                                        </div>
                                    </div>
                                </div>
                                <div class=\"form-group\">
                                    <div class=\"form-row\">
                                        <div class=\"col-md-6\">
                                        <div class=\"form-label-group\">
                                        <input type=\"text\" id=\"inputEmail\" value='$perreq->mobile_number' readonly name=\"mob_number\" class=\"form-control\" placeholder=\"Email address\" required=\"required\">
                                        <label for=\"inputEmail\">Mobile_Number</label>
                                    </div>
                                            
                                        </div>
                                        <div class=\"col-md-6\">
                                            <div class=\"form-label-group\">
                                                <input type=\"text\" value='$perreq->residence_number' readonly name=\"res_number\" id=\"residence_number\" class=\"form-control\" placeholder=\"Contact Number\" required=\"required\">
                                                <label for=\"contactnumber\">Residence Number</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                ";
                                ?>
                                <h6>Extra Details</h6>
                                <?php
                                    if($student_ex_data){
                                        foreach ($student_ex_data as $student_ex_data) {
                                            $my_str = $student_ex_data->value;
$arraynama = str_replace("_", ",", $my_str);
$newarraynama=rtrim($arraynama,", ");
                                            echo "<div class=\"form-group\">
                                    <div class=\"form-row\"><div class=\"col-md-6\">
                                    <div class=\"form-label-group\">
                                        <input type=\"text\" readonly id='$student_ex_data->key' name='$student_ex_data->key' value='$newarraynama' class=\"form-control\" placeholder=\"Email address\" required=\"required\">
                                        <label for='$student_ex_data->key'>$student_ex_data->key</label>
                                    </div>
                                    </div>
                                    </div>
                                        </div>";
                                        }
                                    }

                                    echo "
                                
                               
                            </div>
                            ";

                                }

                                ?>
                            


 
                            
                            <h4>Fill Questions Below</h4>
                            <?php if($form_field_result){ ?>
                                        <?php foreach($form_field_result as $fields){?>
                                            <?php if($fields){ ?>
                                            <?php foreach($fields as $field){?>
                                            <?php if($field->title == 'textbox'){

                                            echo '<div class="form-row">
                                            <div class="col-md-6">
                                            <label for="inputState">'.$field->name.'?</label>
                                                <div class="form-label-group">
                                                    <input type="text" id='.strtolower(str_replace(" ","_",$field->name)).' name='.strtolower(str_replace(" ","_",$field->name)).' class="form-control" placeholder="Email address" required="required">
                                                    
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <br>';

                                            }else if($field->title == 'dropdown'){
                                                echo '<div class="form-row">
                                            <div class="col-md-6">
                                              <label for="inputState">'.$field->name.'?</label>
                                              <select id="inputState" required="required" class="form-control" name='.strtolower(str_replace(" ","_",$field->name)).'>';
                                                $myArray = explode('_',substr($field->options, 0, -1));
                                                foreach($myArray as $option ){
                                                    echo '<option value='.$option.'>'.$option.'</option>';
                                                }
                                                echo '
                                              </select>
                                            </div>
                                        </div>';

                                            }else if($field->title == 'checkbox'){
                                                echo '<div class="form-row">
                                            <div class="col-md-6">
                                            <label for="inputState">'.$field->name.'?</label>
                                                <div class="form-check">';

                                                $myArray = explode('_',substr($field->options, 0, -1));

                                                foreach($myArray as $option ){
                                                    echo '<input class="form-check-input"  type="checkbox" name='.strtolower(str_replace(" ","_",$field->name))."[]".' value="'.$option.'" id="'.$option.'">
                                                  <label class="form-check-label" for="'.$option.'">
                                                    '.$option.'
                                                  </label><br>';
                                                }

                                                echo '
                                                </div>
                                                
                                            </div>
                                        </div>';

                                            }else if($field->title == 'label'){
                                                echo '<div class="form-row">
                                            <div class="col-md-6">
                                                <div class="form-label-group">
                                                    <input type="email" id="inputEmail" name="email" class="form-control" placeholder="Email address" required="required">
                                                    <label for="inputEmail">'.$field->name.'</label>
                                                </div>
                                            </div>
                                        </div>';

                                            }else if($field->title == 'fieldset'){
                                                echo '<div class="form-row">
                                            <div class="col-md-6">
                                                <fieldset class="form-group">                                                    
                                                    <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input" name="optionsRadios" id="optionsRadios2" value="option2">
                                                        Option two can be something else and selecting it will deselect option one
                                                      </label>
                                                    </div>               
                                                  </fieldset>
                                            </div>
                                        </div>';

                                            }
                                            ?>
                                        <?php }?>


                                        <?php }?>


                                        <?php }?>


                                    <?php }?>
                                    <hr>
                                    <h4>FollowUp Information</h4>
                                    <br>
                                        <div class="form-group">
                                            <input type="checkbox" name="lead" value="1"> Add To <b><strong>LEADS</strong></b> <small> (Mark as a Prospect)</small><br>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label><h6>FollowUp Type</h6></label>
                                            <br>
                                            
                                                <?php foreach($followups as $followup): ?>
                                                    
                                                <input type="checkbox" name="followup[]" value="<?php echo $followup['id']; ?>"><?php echo $followup['name']; ?> <br>
                                                <?php endforeach; ?>
                                            
                                            <small class="hours">Please Select the FollowUp Type</small>
                                        </div>
                                        <div class="form-group">
                                            <label><h6>Remark</h6></label>
                                            <textarea  required class="form-control" name="remark" placeholder="" ></textarea>
                                        </div>
                                        <label><h6>FollowUp Date & Time</h6></label>
                                        <div>
                                            <label for="start"><h6>Date</h6></label>
                                            <input type="date" id="start" name="date"
                                                value=""
                                                min="2018-01-01"  required/>
                                        </div>
                                        <div class="control">
                                            <label for="appt-time"><h6>Time</h6></label>
                                            <input type="time" id="appt-time" name="time"
                                                required />
                                            
                                        </div>
                                    <button class="btn btn-primary btn-block" type="submit" value="upload">Submit</button>
                            </form>
                        </div>

                    </div>
                </div>


            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

<!-- Sticky Footer Start-->
<?php
$this->load->view('footer');
?>
<!--Sticky Footer Ens-->

</div>
<!-- /.content-wrapper -->

</div>
<!-- /#wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>
<!-- add comment Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"></h4>
        
      </div>
      
      <form action="<?php echo base_url();?>teleController/addComment" name="submitOne" method="post">
      <div class="modal-body">
      <label>Keep a note on Call Back</label>
                    <div class="form-group">
                            <input type="text"   hidden readonly value="<?php echo $_GET['group_id']; ?>" name="gid" class="form-control" placeholder="Address" >
                            <input type="text"   hidden readonly value="<?php echo $userid; ?>" name="sid" class="form-control" placeholder="Address" >
                            <input type="text" name="comment" class="form-control" placeholder="" required>
                    </div>

                </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
        <button type="submit" class="btn btn-info" >Submit, Back to Group</button>
      </div>
    </div>
    </form>

  </div>
</div>
<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="<?php echo base_url();?>users/logout"><?php if($this->session->userdata('logged_in')):?>Logout<?php endif;?></a>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript-->
<script src="<?php echo base_url();?>assets/assets1/vendor/jquery/jquery.min.js"></script>
<script>
    ClassicEditor
        .create( document.querySelector( '#editor' ) )
        .catch( error => {
        console.error( error );
    } );
</script>
<script>
    window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function(){
            $(this).remove();
        });
    }, 10000);
</script>
<script src="<?php echo base_url();?>assets/assets1/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="<?php echo base_url();?>assets/assets1/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Page level plugin JavaScript-->
<script src="<?php echo base_url();?>assets/assets1/vendor/chart.js/Chart.min.js"></script>
<script src="<?php echo base_url();?>assets/assets1/vendor/datatables/jquery.dataTables.js"></script>
<script src="<?php echo base_url();?>assets/assets1/vendor/datatables/dataTables.bootstrap4.js"></script>

<!-- Custom scripts for all pages-->
<script src="<?php echo base_url();?>assets/assets1/js/sb-admin.min.js"></script>

<!-- Demo scripts for this page-->
<script src="<?php echo base_url();?>assets/assets1/js/demo/datatables-demo.js"></script>
<script src="<?php echo base_url();?>assets/assets1/js/demo/chart-area-demo.js"></script>
<script src="<?php echo base_url();?>assets/assets1/js/demo/image.js"></script>

</body>

</html>




