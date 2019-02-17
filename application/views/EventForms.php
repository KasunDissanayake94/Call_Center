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
                    <a href="#">Main Groups</a>
                </li>
                <li class="breadcrumb-item active">Event forms - <?php echo $event_title?></li>
            </ol>

           <div class="container">
            <div class="row"><p class="left-align"></b></p></div>
          </div>

            <div class="row">
                <div class="col-6">
                <form method="POST" action="<?php echo base_url()?>adminController/removeEventForm?event_id=<?php echo $event_id?>&event_title=<?php echo $event_title?>">
                <?php

                    if($forms->num_rows() > 0)
                    {
                        foreach($forms->result() as $row)
                        {
                        echo "
                        <ul class=\"list-group list-group-flush\">
                        <li class=\"list-group-item d-flex justify-content-between align-items-center\">$row->title
                        <label><input type=\"checkbox\" name=\"form_id[]\" value=\"$row->id\" class=\"list-item-checkbox\"> Select</label>
                        </li>
                        </ul>
                        ";
                        }
                    }
                    // else
                    // {
                    //   echo "
                    //   <ul class=\"list-group list-group-flush\">
                    //   <li class=\"list-group-item>No allocated questinnaire found</li>
                    //   </ul>
                    //   ";
                    // }

                ?>
                </div>
                <div class="col-1">
                </div>
                <div class="col-4">
                 <button name="submitOne" type="submit" class="btn btn-outline-danger btn-block">Remove form</button>
                 </form>
                  <div class="row">
                  <hr>
                  <form method="POST" action="<?php echo base_url()?>adminController/addEventForms?event_id=<?php echo $event_id?>&event_title=<?php echo $event_title?>">
                  </div>
                    <div class="p-3 mb-2 bg-light text-dark">
                        <label><b>Add new form</b></label>
                        <div class="form-group">
                            <label>Select form:</label>
                            <select name="form" class="form-control" id="sel1">
                            <?php
                                foreach($other_forms->result() as $row)
                                {
                                    echo "<option value=\"$row->id\">$row->title</option>";
                                }
                            ?>
                            </select>
                        </div>
                        <input type="submit" name="submitTwo" value="Add form" class="btn btn-outline-secondary btn-block">
                        </form>
                    </div>
                </div>
            </div>



            <!-- Area Chart Example-->
            
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




