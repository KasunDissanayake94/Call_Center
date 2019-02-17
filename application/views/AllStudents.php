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
                <li class="breadcrumb-item active">All students</li>
            </ol>


            <div class="container">
            <div class="row">
              <div class="col-5">
                <a data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                <b><label>Select filter criteria</label></b>
                </a>
              </div>
            </div>

            <form name="filter" id="filterform" action="<?php echo base_url(); ?>adminController/filterOptions" method="POST">
              <div class="collapse" id="collapseExample">
                <div class="row">
                    <div class="col-4">
                        <div class="row">
                            <div class="col-3"><label>Event</label></div>
                            <div><input name="event[]" type="checkbox" value="1"></div>
                        </div>
                    </div>
                    <?php 
                      foreach($keys->result() as $row)
                      {
                        echo "
                        
                          <div class=\"col-4\">
                            <div class=\"row\">
                              <div class=\"col-3\">
                                <label>$row->name</label>
                              </div>
                              <div class=\"col-1\">
                                <input name=\"criteria[]\" type=\"checkbox\" value=\"$row->id\">
                              </div>
                            </div>
                          </div>
                      
                        ";
                      
                      }
                    ?>
                </div>
                <div class="row">
                    <div class="float-left"><input id="submit" type="submit" class="btn btn-sm btn-outline-secondary" value="Add criteria" name="submit" /></div>
                </div>
              </div>
            </form>
        </div>
        <div class="container">
        <form method="POST" action="<?php echo base_url(); ?>adminController/viewFilteredStudents">
            <div class="row">
                <!-- <div class="col-6"> -->
                    <!-- <div class="form-group">
                        <select name="event_id" class="form-control" id="sel1">
                        <option value="select">Select event</option> -->
                            <?php
                                // foreach($events->result() as $row)
                                // {
                                //     echo "<option value=\"$row->id\">$row->title</option>";
                                // }
                            ?>
                            <!-- </select>
                    </div> -->
                <!-- </div> -->
                <!-- <div class="col-6">
                    <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="inlineCheckbox1" name="filtertype" value="null">
                    <label class="form-check-label" for="inlineCheckbox1">Include null</label>
                    </div>
                    <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="inlineCheckbox2" name="filtertype" value="intersection">
                    <label class="form-check-label" for="inlineCheckbox2">Only intersection</label>
                    </div>
                    <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="inlineCheckbox3" name="filtertype" value="union">
                    <label class="form-check-label" for="inlineCheckbox3">union</label>
                    </div>
                </div> -->
            </div>
            <div class="row" id="result"></div>
        </form>
        </div>

        <hr>        
        <div class="container">
            <b><label>All Students</label></b>
            <div class="float-right">
            <a class="pull-right btn btn-primary btn-xs" href="<?php echo base_url()?>adminController/exportAllStudents"><i class="fa fa-file-excel-o"></i> Export Data</a>
            </div>
        </div>
        <!-- student table -->
        <div class="container">
        <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                                <tr>
                                    <th>Full name</th>
                                    <th>Email</th>
                                    <th>mobile</th>
                                    <th>Telephone</th>
                                    <th>address</th>
                                </tr>
                        </thead>
                        <?php

                        if($student->num_rows() >0)
                        {
                            foreach($student->result() as $row)
                            {
                                echo "
                                <tr>
                                    <td>$row->first_name $row->last_name</td>
                                    <td>$row->email</td>
                                    <td>$row->mobile_number</td>
                                    <td>$row->residence_number</td>
                                    <td>$row->address</td>
                                </tr>
                                    ";
                            }
                        }

                        ?>
                    </table>
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

<script type="text/javascript">
    $("#filterform").submit(function(e) { 
        e.preventDefault();
        var postData = $(this).serializeArray();
 
        var formActionURL = $(this).attr("action");
        $("#submit").val('please wait...');
       $.ajax({
            url: formActionURL,
            type: "POST",
            data: postData,
            success: function(result)    
                    {
                        $("#result").html(result);
                    },

         }).always(function() {
            $("#submit").val('Add criteria');
        });
    });
</script>

<script>
$(document).ready(function(){
    $("#submit").click(function(){
		if ($('input:checkbox').filter(':checked').length < 1){
        alert("Select atleast one filter criteria");
		return false;
		}
    });
});
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




