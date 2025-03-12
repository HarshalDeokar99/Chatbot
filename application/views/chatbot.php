<!DOCTYPE html>
<html lang="en">

<head>
   <!-- PAGE TITLE HERE -->
	<title>Chat Bot PHP</title>
    <link rel="icon" type="image/x-icon" href="<?php echo base_url(); ?>assets/images/logo.png">
	<!-- FAVICONS ICON -->
	<link href="<?php echo base_url(); ?>assets/vendor/chartist/css/chartist.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url(); ?>assets/vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet" type="text/css"/>
	
</head>
<body>

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
    <div class="sk-three-bounce">
        <div class="sk-child sk-bounce1"></div>
        <div class="sk-child sk-bounce2"></div>
        <div class="sk-child sk-bounce3"></div>
    </div>
</div>
    <!--*******************
        Preloader end
    ********************-->

    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">


		
	

		
		<!--**********************************
            Content body start
        ***********************************-->
        <div class=" pt-1">
            <!-- row -->
			<div class="container-fluid">
				<div class="form-head d-flex mb-3 align-items-start">
					<div class="me-auto d-none d-lg-block ms-auto">
						<h2 class="text-primary font-w600 mb-0 text-center ms-auto">PHP CHAT bot</h2>
						<!-- <p class="mb-0">Welcome to Chat Bot Admin!</p> -->
					</div>
					
					
				</div>
        <div class="row">
					<div class="col-xl-7 col-xxl-7 col-lg-7 col-md-7 ms-auto me-auto" style="height:400px;">
						<div id="user-activity" class="card">
							<div class="card-header border-0 pb-0 d-sm-flex d-block">
								<div>
									<h4 class="card-title mb-1">Ask Me </h4>
									<!-- <small class="mb-0">Frequently Asked Questions</small> -->
								</div>
								
							</div>
							<div class="card-body" style="overflow:auto;">
								<div class="tab-content" id="myTabContent">
									<div class="tab-pane fade show active" id="chatarea" role="tabpanel">
										
									</div>
								</div>
							</div>
							<div class="card-footer d-sm-flex justify-content-between align-items-center">
                                <div class="card-footer-link mb-4 mb-sm-0" style="width:100%;">
																	<input type="text" class="form-control input-rounded" placeholder="Type Message" id="question">
                                </div>

                                <a href="#" onclick="findreply();" class="btn btn-primary ms-3">Send</a>
                            </div>
						</div>
					</div>

				 </div>
            </div>
        </div>
        <!--**********************************
            Content body end
        ***********************************-->

        <!--**********************************
            Footer start
        ***********************************-->
        <div class="footer">
    <div class="copyright">
        <p>Copyright © Designed &amp; Developed by <a href="https://youtu.be/r3RNtUX_Ios?si=77R7MH2w0_Ui01Nb" target="_blank">Harshal</a>2024</p>
    </div>
</div>        <!--**********************************
            Footer end
        ***********************************-->

		<!--**********************************
           Support ticket button start
        ***********************************-->

        <!--**********************************
           Support ticket button end
        ***********************************-->


    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
	<script> var enableSupportButton = '1'</script>
<script> var asset_url = 'assets/'</script>

<script src="<?php echo base_url(); ?>assets/vendor/global/global.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/vendor/bootstrap-select/dist/js/bootstrap-select.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/vendor/chart-js/chart.bundle.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/vendor/waypoints/jquery.waypoints.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/vendor/jquery.counterup/jquery.counterup.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/vendor/peity/jquery.peity.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/dashboard/dashboard-1.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/custom.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/deznav-init.js" type="text/javascript"></script>
<script>
function findreply()
{
	var question=document.getElementById("question").value;
    var chatarea= document.getElementById("chatarea");
	if(question !="")
	{
        $.ajax({
            url: '<?php echo base_url(); ?>Chatbot/getAnswer', 
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({ question: question }),
            success: function(response) {
                response = JSON.parse(response);
              
                if(response.message=="success")
                {
                    console.log(response.result);
                    chatarea.innerHTML += `<div class="text-end"><span class="chat-message">${question}</span><img src="<?php echo base_url(); ?>assets/images/logo.png" style="width:40px;height:40px;border-radius:100px;margin-left: 10px;"></div>`;
                    chatarea.innerHTML += `<div><img src="<?php echo base_url(); ?>assets/images/logo.png" style="width:40px;height:40px;border-radius:100px; margin-right: 10px;"><span class="chat-message">${response.result}</span></div>`;
                }
                
            },
            error: function(xhr, status, error) {
                // Handle error response
                console.error('Error:', error);
                alert('An error occurred: ' + error);
            }
        });
	}
	
}
</script>
</body>


</html>