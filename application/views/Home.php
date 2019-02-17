<!--Header Start-->
<?php
$this->load->view('header');
?>
<!--Header End-->
<style>
    body {
	font-family: 'Lato', sans-serif;
}
.background {
	background: url('http://oxotrips.com/assets/img/background.png');
	background-size: cover;
	background-position: center;
	background-repeat: no-repeat;
	min-height: 70vh;
	color: white;
	display: flex;
	align-items: center;
	justify-content: center;
	position: relative;
	
	&:before {
		content: '';
		position: absolute;
		top: 0;
		right: 0;
		bottom: 0;
		left: 0;
		background: linear-gradient(to bottom, rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0));
	}
	h1 {
		font-size: 4rem;
		font-weight: 700;
	}
}
.custom-input, .btn-custom {
	border: 0;
	background: transparent;
	border-bottom: 4px solid white;
	border-radius: 0;
	margin-bottom: 0;
}
.custom-input:focus {
	border-color: white;
	background: transparent;
	color: white;
}
.btn-custom {
	color: white;
	cursor: pointer;
}
.display-5 {
	font-size: 1.5rem;
}
#greeting {
	margin-top: 2rem;
	font-size: 2rem;
}
@media (min-width: 576px) {
	.background h1 {
		font-size: 5.5rem;
	}
	.display-5 {
		font-size: 2.5rem;
	}
	#greeting {
		margin-top: 2rem;
		font-size: 2.5rem;
	}
}
@media (min-width: 992px) {
	.background h1 {
		font-size: 6rem;
	}
	#greeting {
		font-size: 3rem;
	}
}

@media (min-width: 1200px) {
	.background h1 {
		font-size: 7.5rem;
	}
	#greeting {
		font-size: 3.6rem;
	}
}

</style>
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
            </ol>

            <!-- Icon Cards-->
            <div class="background">
 <div class="container">
  <div class="row flex-column justify-content-center align-items-center text-center">
   <div class="col-sm-12 col-md-10 col-lg-8">
    <h1 id="time">12:00 AM</h1>
    <h3 id="day" class="display-5">Monday, January 01</h3>
    <h2 id="greeting">Good Morning, <?php echo $this->session->userdata('fullname'); ?></h2>
   </div><!-- /.col -->
   
  </div><!-- /.row -->
	 
 </div><!-- /.container -->   

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
<script>
    $(function() {
	
	// Time function to get the date/time
	function time() {
		
		// Create new date var and init other vars
		var date = new Date(),
			hours = date.getHours(), // Get the hours
			minutes = date.getMinutes().toString(), // Get minutes, convert to string
			ante, // Will be used for AM and PM later
			greeting, // Set the appropriate greeting for the time of day
			dd = date.getDate().toString(), // Get the current day
			userName = "<?php echo $this->session->userdata('fullname'); ?>"; // Can be used to insert a unique name

		/* Set the AM or PM according to the time, it is important to note that up
			to this point in the code this is a 24 clock */
		if (hours < 12) {
			ante = "AM";
			greeting = "Morning";
		} else if (hours === 12 || hours <= 15) {
			ante = "PM";
			greeting = "Afternoon"
		} else {
			ante = "PM";
			greeting = "Evening";
		}

		/* Since it is a 24 hour clock, 0 represents 12am, if that is the case
		then convert that to 12 */
		if (hours === 0) {
			hours = 12;
			
			/* For any other case where hours is not equal to twelve, let's use modulus
			to get the corresponding time equivilant */
		} else if (hours !== 12) {
			hours = hours % 12;
		}

		// Minutes can be in single digits, hence let's add a 0 when the length is less than two
		if (minutes.length < 2) {
			minutes = "0" + minutes;
		}

		// Let's do the same thing above here for the day
		if (dd.length < 2) {
			dd = "0" + dd;
		}

		// Months
		Date.prototype.monthNames = [
			"January",
			"February",
			"March",
			"April",
			"May",
			"June",
			"July",
			"August",
			"September",
			"October",
			"November",
			"December"
		];

		// Days
		Date.prototype.weekNames = [
			"Sunday",
			"Monday",
			"Tuesday",
			"Wednesday",
			"Thursday",
			"Friday",
			"Saturday"
		];
		
		// Return the month name according to its number value
		Date.prototype.getMonthName = function() {
			return this.monthNames[this.getMonth()];
		};
		
		// Return the day's name according to its number value
		Date.prototype.getWeekName = function() {
			return this.weekNames[this.getDay()];
		};

		// Display the following in html
		$("#time").html(hours + ":" + minutes + " " + ante);
		$("#day").html(date.getWeekName() + ", " + date.getMonthName() + " " + dd);
		$("#greeting").html("Good " + greeting + ", " + userName);
		
		// The interval is necessary for proper time syncing
		setInterval(time, 1000);
	}
	time();
});

</script>
</body>

</html>




	