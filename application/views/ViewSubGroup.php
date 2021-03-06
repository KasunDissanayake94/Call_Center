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
                    <a href="#">Sub Groups</a>
                </li>
                <li class="breadcrumb-item active"><?php echo $group_title?></li>
            </ol>

            <div class="row">
              <div class="col-6">
                <div class="p-3 mb-2 bg-light text-dark">
                  <div class="row">
                    <div class="col-9">
                      <p class="left-align"><b>Course Counselor: <?php echo $tme_name?></b></p>
                    </div>
                    <div class="col-3">
                      <a class="btn btn-outline-secondary btn-sm" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                        Change CC
                      </a>
                    </div>
                  </div>
                  <form action="<?php echo base_url();?>adminController/changeCC?group_id=<?php echo $gid?>&group_title=<?php echo $group_title?>" method="POST">
                  <div class="row">
                  <div class="container">
                          <div class="collapse" id="collapseExample">
                            <div class="card card-body">
                                <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Select</label>
                                  <div class="col-sm-9">
                                    <select class="form-control" id="sel1" name="cc">
                                    <?php
                                        foreach($CCs->result() as $row)
                                        {
                                            echo "<option value=\"$row->id\">$row->first_name $row->last_name</option>";
                                        }
                                    ?>
                                    </select>
                                  </div>
                                </div>
                            </div>
                            <div class="card card-footer">
                                <button type="button" class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#exampleModalOne">
                                  Change
                                </button>
                            </div>
                          </div>
                    </div>
                  </div>

                  <!-- change CC confirmation modal -->
                  <div class="modal fade" id="exampleModalOne" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Change Course Counselor</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                                Are you sure to save changes?
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-info">Yes</button>
                          </div>
                        </div>
                      </div>
                    </div>

                  </form>
                </div>
              </div>

              <div class="col-6">
                  <div class="p-3 mb-2 bg-light text-dark">
                    <div class="row">
                      <div class="col-4">
                      <form id="frm-example1" action="<?php echo base_url();?>adminController/removeStudentsOfSG?group_id=<?php echo $gid?>&group_title=<?php echo $group_title?>" method="POST">
                        <div class="float-left">
                          <label><input type="checkbox" name="selectall" class="select-all"> Select all students</label>
                        </div>
                      </div>
                      <div class="col-8">
                        <div class="float-right">
                          <button id="btndelete" type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#exampleModalTwo">Remove</button>
                        </div>
                      </div>
                    </div>
                  </div>
              </div>
  
            </div>

            <hr>

            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                            <tr>
                                <th>Full name</th>
                                <th>Email</th>
                                <th>Telephone</th>
                                <th>Select</th>
                            </tr>
                    </thead>
                    <?php

                    if($members->num_rows() >0)
                    {
                        foreach($members->result() as $row)
                        {
                            echo "
                            <tr>
                                  <td>$row->first_name $row->last_name</td>
                                  <td>$row->email</td>
                                  <td>$row->mobile_number</td>
                                  <td><input type=\"checkbox\" name=\"student_id[]\" value=\"$row->id\" class=\"list-item-checkbox\"></td>
                            </tr>
                                ";
                            }
                        }
                    

                    ?>
                </table>
            </div>

             <!-- delete selected students confirmation modal -->

                    <div class="modal fade" id="exampleModalTwo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Remove students</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                                Are you sure to romove the selected set of students from the group?
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" name="submit" class="btn btn-info">Yes</button>
                          </div>
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

<script>
$('.select-all').click(function(e){
  var checked = e.currentTarget.checked;
  $('.list-item-checkbox').prop('checked', checked);
  countChecked((checked) ? 20 : 0);
});

var lastChecked = null;
$('.list-item-checkbox').click(function(e){
  var selectAllChecked = $('.select-all:checked').length ? true : false;
  console.log(selectAllChecked)

  if (selectAllChecked) {
    var itemsTotal = $('.list-item-checkbox').length;
    var uncheckedItemsTotal = itemsTotal - checkedItemsTotal();
    var selected = 20 - uncheckedItemsTotal;
    countChecked(selected);
  } else {
    countChecked();
  }

  if(!lastChecked) {
    lastChecked = this;
    return;
  }  

  if(e.shiftKey) {
    var from = $('.list-item-checkbox').index(this);
    var to = $('.list-item-checkbox').index(lastChecked);

    var start = Math.min(from, to);
    var end = Math.max(from, to) + 1;

    $('.list-item-checkbox').slice(start, end)
      .filter(':not(:disabled)')
      .prop('checked', lastChecked.checked);
    countChecked();
  }
  lastChecked = this;

  if(e.altKey){

    $('.list-item-checkbox')
      .filter(':not(:disabled)')
      .each(function () {
      var $checkbox = $(this);
      $checkbox.prop('checked', !$checkbox.is(':checked'));
      countChecked();

    });
  }  

});
function countChecked(number){
  number = number ? number : checkedItemsTotal();
  $('#counter-selected').html(number);
}

function checkedItemsTotal(){
  return $('.list-item-checkbox:checked').length;
}
</script>

<script>
$(document).ready(function(){
    $("#btndelete").click(function(){
		if ($('input:checkbox').filter(':checked').length < 1){
        alert("Select atleast one student");
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




