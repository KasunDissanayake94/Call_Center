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
                <li class="breadcrumb-item active">Allocated Contacts</li>
            </ol>
            <div>
                <a class="btn btn-outline-info btn-md" href="teleGroups">Back to Groups</a>
            </div>
            <br>
            
                <div class="table-responsive">
                  <table class="table table-bordered"  width="100%" cellspacing="0">
                  
                      <thead>
                              <tr>
                                  <th>Full name</th>
                                  <th>Email</th>
                                  <th>Mobile Number</th>
                                  <th>Residence Number</th>
                                  <th>Note</th>
                                  <th>More</th>                              
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
                                  <td>$row->residence_number</td>
                                  <td>";
                                  if($row->comment){ echo "$row->comment<br><small>Time: $row->commentTime</small>"; }else{ echo "";};
                                  echo"</td>
                                  <td><a href='userEdit?userid=$row->id&group_id=$gid'><button";
                                  if(($row->answered_or_not_answered)==1){ echo " "; };
                                  echo" class='btn btn-";
                                  if(($row->answered_or_not_answered)==1){ echo "default"; }else{echo "primary";};
                                  echo"' name='more'>Fill Details</button></a>";
                                  if(($row->answered_or_not_answered)==1){ echo ""; };
                                  echo" <a href='viewStudentDetails?sid=$row->id&group_id=$gid'><button class='btn btn-success' name='more'>View</button></a></td>
                              </tr>
                              ";
                          }
                      }else{echo"<tr><td colspan='6'>No Data to Show</td></tr>";}

                      ?>
                  </table>
                  </div>
                  <input type="text" id="address" hidden readonly value="<?php echo $gid; ?>" name="form_id" class="form-control" placeholder="Address" >
              </div>
                    
                    

                </form>
           
            



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
    $("#btnmove").click(function(){
		if ($('input:checkbox').filter(':checked').length < 1){
        alert("Select atleast one student");
		return false;
		}
    });
});
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




