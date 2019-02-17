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
                <li class="breadcrumb-item active">Edit Student</li>
            </ol>

            <div class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-chart-area"></i>
                    <h2>Student Details</h2>
                    


                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col md-4">
                            <h4>Full Name</h4>
                            <?php echo $details['first_name']; ?> <?php echo $details['last_name']; ?>
                        </div>
                    
                    <div class="col md-4">
                            <h4>Email</h4>
                            <?php echo $details['email']; ?>
                        </div>
                        <div class="col md-4">
                        </div>
                    </div>
                    <div class="row">
                    <div class="col md-4">
                            <h4>Mobile Number</h4>
                            <?php echo $details['mobile_number']; ?>
                        </div>
                        <div class="col md-4">
                            <h4>Residence Number</h4>
                            <?php echo $details['residence_number']; ?>
                        </div>
                        <div class="col md-4">
                        </div>
                    </div>

                    <div class="row">
                    <div class="col md-4">
                            <h4>Address</h4>
                            <?php echo $details['address']; ?>
                        </div>
                    </div>
                    
                    </div>
                    <div>
                    <hr>
                    <br>
                    <h4> Question Log</h4>
                     
                    <ul>
                    <?php foreach($exDetails as $exDetails) : ?>
                                        <li>
                                            <label style="color:#042030;" ><?php echo $exDetails['key']; ?>?</label>
                                            <label style="color:#44443c;font-size:18px;"><strong> <?php echo $exDetails['value']; ?></strong></label>
                                            <label style="color:#39637c;" class="float-right"><?php echo $exDetails['first_name']; ?> <?php echo $exDetails['last_name']; ?> (<?php echo $exDetails['type']; ?>) - <?php echo $exDetails['time']; ?></label>

                                            <br>
                                            
                                            
                                            
                                            </li>
                                        
                                        
                                        
                                    <?php endforeach; ?>
                                </ul>
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




