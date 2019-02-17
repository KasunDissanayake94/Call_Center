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

            <h5><?php echo $this->session->flashdata('formSuccess');?></h5>

            <!-- Area Chart Example-->
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-chart-area"></i>
                    Basic Student Details</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <a class="btn btn-info btn-md" href="manageStudents">Back</a>
                            <hr>
                            <form action="<?php echo base_url();?>StudentSearch/editStudentBasicDetails" method="POST">

                                <?php if($this->session->flashdata('success')):  ?>
                                    <div class="alert alert-success" role="alert">
                                        <?php echo $this->session->flashdata('success');?>
                                    </div>
                                <?php endif;?>

                                <?php if($this->session->flashdata('failed')):  ?>
                                    <div class="alert alert-danger" role="alert">
                                        <?php echo $this->session->flashdata('failed');?>
                                    </div>
                                <?php endif;?>
                                
                                

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
                                                <input type=\"text\" id='first_name' value='$perreq->first_name' readonly name='first_name' class=\"form-control\" placeholder=\"First name\" required=\"required\" >
                                                <label for='first_name'>First name</label>
                                            </div>
                                        </div>
                                        <input type=\"text\" id=\"id\" name=\"id\" value='$perreq->id' readonly class=\"form-control\" required=\"required\" hidden autofocus=\"autofocus\">
                                        

                                        <div class=\"col-md-6\">
                                            <div class=\"form-label-group\">
                                                <input type=\"text\" id='last_name' value='$perreq->last_name' readonly name='last_name' class=\"form-control\" placeholder=\"Last name\" required=\"required\">
                                                <label for='last_name'>Last name</label>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class=\"form-group\">
                                    <div class=\"form-row\">
                                        <div class=\"col-md-6\">
                                            <div class=\"form-label-group\">
                                                <input type=\"email\" value='$perreq->email' readonly  id='email' name='email' class=\"form-control\" placeholder=\"Email address\" required=\"required\">
                                                <label for='email'>Email address</label>
                                            </div>
                                        </div>
                                       <div class=\"col-md-6\">
                                    <div class=\"form-label-group\">
                                        <input type=\"text\" id='address' value='$perreq->address' readonly name='address' class=\"form-control\" placeholder=\"Email address\" required=\"required\">
                                        <label for='address'>Home Address</label>
                                    </div>
                                        </div>
                                    </div>
                                </div>
                                <div class=\"form-group\">
                                    <div class=\"form-row\">
                                        <div class=\"col-md-6\">
                                        <div class=\"form-label-group\">
                                        <input type='text' id='mobile_number' name='mobile_number' value='$perreq->mobile_number' readonly class=\"form-control\" placeholder=\"Email address\" required=\"required\">
                                        <label for='mobile_number'>Mobile_Number</label>
                                    </div>
                                            
                                        </div>
                                        <div class=\"col-md-6\">
                                            <div class=\"form-label-group\">
                                                <input type=\"text\" value='$perreq->residence_number' readonly  name='residence_number' id='residence_number' class=\"form-control\" placeholder=\"Contact Number\" required=\"required\">
                                                <label for='residence_number'>Residence Number</label>
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
                                </div>
                                <div class="form-group">
                                
                                <h6>Log Details</h6>
                                <ul>
                                <!-- if condition -->
                                <?php if($remarks){ ?>
                                    <?php foreach($remarks as $remark) : ?>
                                    <br>
                                                    <li>
                                                        <label style="color:#042030;" ><?php echo $remark['first_name']; ?> <?php echo $remark['last_name']; ?> (<?php echo $remark['type']; ?>)</label>
                                                        <br>
                                                        <small>Remark:</small>
                                                        <label style="color:#44443c;font-size:18px;"><b> <?php echo $remark['remark']; ?></b></label>
                                                        <br>
                                                        <small>Follow-Up types: </small>
                                                        <?php echo $remark['followups']; ?>
                                                        <br>
                                                        <small>Log Time:</small>
                                                        <label style="color:#39637c;"><?php echo $remark['timestamp']; ?></label>

                                                        <br>
                                                        
                                                        
                                                        
                                                        </li>
                                                    <hr>
                                                        

                                                    
                                                <?php endforeach; ?>
                                                <?php }else{echo"<small>No Logs to show</small>";}?>
                                            </ul>
                                            </div>

                            </form>
                            <div class="col-md-4 text-center">
                                
                            </div>
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




