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
                <li class="breadcrumb-item active">Change Options</li>
            </ol>



            <!-- Area Chart Example-->
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-chart-area"></i>
                    Change Options</div>
                <div class="card-body">





<div class="container">


<h4><?php echo $this->session->flashdata('formDeleted');?></h4>


<?php if($form_name){?>
	<?php foreach($form_name as $perreq){?>
		<?php echo form_open_multipart("newform/addStudentsForEvent?form_id=".$perreq->id);?>
		<div class="row">

			<div class="form-group col-4">

				<input type="text" name="scname" value="<?php echo $perreq->title;?>" disabled class="form-control" placeholder="Select Form"  >
	
			</div>
			<div class="form-group col-3">
				<input type="submit" value="View" class="form-control btn btn-primary">
			</div>
			<div class="form-group col-3">
				<?php if(($perreq->used)==0){?>
					<!-- <input type="submit" value="Delete" class="form-control btn btn-danger">
					<a href="<?php echo site_url('newform/deleteForm/') ?>">Link</a> -->
					<?php $id = $perreq->id; ?>
					<button type="button" class="form-control btn btn-danger" data-toggle="modal" data-target="#loginModal">Delete</button>
				<?php }?>
				
			</div>

			


		</div>
		<?php echo form_close();?>
	<?php }?>
	<?php }else{?>
	No Forms Found
	<?php }?>


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
 <!-- delete model -->
 <div class="modal fade" role="dialog" id="loginModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title"> Confirm Delete The Form</h3>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

               
			   <div class="form-group col-3">
					<div class="modal-footer">
					<a href="<?php echo base_url('newform/deleteForm/'.$id)?>" class="form-control btn btn-danger">Delete</a>
					</div>
				</div>

            </div>
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





<script type="text/javascript">

function addMoreFields(){
 

   var container = document.createElement("div");
	container.innerHTML = '<input class="form-control" pattern="^[a-zA-Z\s]+$"  type="text" name="extraOption[]"><br>';
	document.getElementById("field").appendChild(container); 
}
</script>

</body>
</html>


