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
                <li class="breadcrumb-item active">Main Groups</li>
            </ol>

           

            <!-- <div class="row">
                <div class="col-9">

                <div class="row">
                    <div class="col-4">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">filter criteria</label>
                            </div>
                            <select id="event" class="custom-select" id="inputGroupSelect01">
                                <option value="select" selected>Choose...</option>
                                <?php
                                    // foreach($events->result() as $row)
                                    // {
                                    //     echo "<option value=\"$row->id\" >$row->title</option>";
                                    // }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">filter criteria</label>
                            </div>
                            <select id="filter_criteria" class="custom-select" id="inputGroupSelect01">
                                <option value="select" selected>Choose...</option>
                                
                                <?php
                                    // foreach($filter_criteria->result() as $row)
                                    // {
                                    //     echo "<option value=\"$row->filter_criteria\" >$row->filter_criteria</option>";
                                    // }
                                ?>

                            </select>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">filter type</label>
                            </div>
                            <select id="filter_type" class="custom-select" id="inputGroupSelect01">
                                <option value="select" selected>Choose...</option>
                                <option value="null">null</option>
                                <option value="intersection">intersetion</option>
                                <option value="union">union</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div id="result"></div>
                
            </div> -->


            <div class="row">
            <div class="col-12">
                
                 <?php
            
                foreach($projects->result() as $x)
                {
                    echo "<label><b>$x->title</b></label><br> <ul class=\"list-group list-group-flush\">";
                    foreach($main_groups->result() as $y)
                    {
                        if($x->id == $y->project_id)
                        {
                            echo "
                    
                                <li class=\"list-group-item d-flex justify-content-between align-items-center\">$y->title
                                <div class=\"btn-group\" role=\"group\" aria-label=\"Basic example\">
                               
                                <a class=\"btn btn-outline-success btn-sm\" href=\"addMoreStudentsMG?group_id=$y->id&group_title=$y->title&tme_name=$y->first_name $y->last_name\">Add more students</a>
                                <a class=\"btn btn-outline-info btn-sm\" href=\"viewMainGroup?group_id=$y->id&group_title=$y->title&tme_name=$y->first_name $y->last_name\">View details</a>
                                <a class=\"btn btn-outline-warning btn-sm\" href=\"viewMainGroupQuestionnaire?group_id=$y->id&group_title=$y->title&tme_name=$y->first_name $y->last_name\">Questionnaire</a>
                                </div>
                                </li>
                                
                                    ";
                        }
                    }
                    echo "<hr></ul><br>";
                }
            
            ?>
                
            <!--<ul class=\"list-group list-group-flush\">-->
                <?php
                // foreach($main_groups->result() as $row)
                // {
                //     echo "
                    
                // <li class=\"list-group-item d-flex justify-content-between align-items-center\">$row->title
                // <div class=\"btn-group\" role=\"group\" aria-label=\"Basic example\">
                // <a class=\"btn btn-outline-info btn-sm\" href=\"viewMainGroup?group_id=$row->id&group_title=$row->title&tme_name=$row->first_name $row->last_name\">View details</a>
                // <a class=\"btn btn-outline-warning btn-sm\" href=\"viewMainGroupQuestionnaire?group_id=$row->id&group_title=$row->title&tme_name=$row->first_name $row->last_name\">Questionnaire</a>
                // </div>
                // </li>
                
                //     ";

                // echo "
                // <div class=\"modal fade\" id=\"exampleModalTwo\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"exampleModalLabel\" aria-hidden=\"true\">
                //           <div class=\"modal-dialog\" role=\"document\">
                //             <div class=\"modal-content\">
                //               <div class=\"modal-header\">
                //                 <h5 class=\"modal-title\" id=\"exampleModalLabel\">Remove students</h5>
                //                 <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
                //                   <span aria-hidden=\"true\">&times;</span>
                //                 </button>
                //               </div>
                //               <div class=\"modal-body\">
                //                     Are you sure to romove the selected set of students from the group?
                //               </div>
                //               <div class=\"modal-footer\">
                //                 <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Close</button>
                //                 <a class=\"btn btn-info\" href=\"deleteMainGroup?group_id=$row->id\">Yes</a>
                //               </div>
                //             </div>
                //           </div>
                //         </div>
                // ";
                // }
                ?>
                <!--</ul>-->
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

<!-- <script>
    $(document).ready(function(){
        var event='';
        var filter_criteria='';
        var filter_type='';
        load_data();
        function load_data()
        {
            $.ajax({
                url:"<?php echo base_url(); ?>adminController/filterGroups",
                method:"POST",
                data:{data1:event,data2:filter_criteria,data3:filter_type},
                success:function(data){
                    $('#result').html(data);
                }
            })
        }


        $('#event').change(function(){
            event = $(this).val();
            load_data()

        });
        $('#filter_criteria').change(function(){
            filter_criteria = $(this).val();
            load_data()
        });
        $('#filter_type').change(function(){
            filter_type = $(this).val();
            load_data()
        });
    });
</script> -->

<script>
    $(document).ready(function(){
        var group_id = $(#group_id).val();
        get_groups();
        function get_groups()
        {
            $.ajax({
                url:"<?php echo base_url(); ?>adminController/groupsOfProjects",
                method:"POST",
                data:{data1:group_id},
                success:function(data){
                    $('#groups').html(data);
                }
            })
        }

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




