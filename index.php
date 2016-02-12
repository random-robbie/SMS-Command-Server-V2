<?php
// SMS Server Commands V2
// By Robert Wiggins
// For use with SMSpi.co.uk API
// Donate something via paypal txt3rob@gmail.com
include ('config.php');
include ('functions.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SMS Server Command V2</title>

    <!-- Bootstrap Core CSS -->
    <link href="./bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="./bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="./dist/css/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="./dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="./bower_components/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="./bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	
	<!--jQuery Mobile -->
	<script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script> 
	
	<!-- jQuery -->
    <script src="./bower_components/jquery/dist/jquery.min.js"></script>
	
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html">SMS Server Command V2</a>
            </div>
            <!-- /.navbar-header -->

            
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        
                        <li>
                            <a href="index.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Dashboard</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-comments fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo countcommands ($dbh); ?></div>
                                    <div>Commands</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left"></span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-tasks fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo countservers ($dbh); ?></div>
                                    <div>Servers</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left"></span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
					
                </div>
                
            </div>
            <!-- /.row -->
            
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-clock-o fa-fw"></i> Server Commands
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body" id="SMSinput">
                            
        
          
		  <br>
		  

		  <br>
		  <form action="incoming.php" method="post" id="newSMSForm"> 
		  <label>Server</label>
		  <select class="form-control" name="server">
  
  <?php
   $servers = listservers($dbh);
   foreach ($servers AS $server)
   {
	   $server_name = $server['server_name'];
	   echo '<option value="'.$server_name.'">'.$server_name.'</option>';
   }
   ?>
</select>
		  <br>
		  <label>Command</label>
		  <select class="form-control" name="command">
		  <?php
   $commands = listcommands($dbh);
   foreach ($commands AS $command)
   {
	   $command_name = $command['command_name'];
	   echo '<option value="'.$command_name.'">'.$command_name.'</option>';
   }
   ?>
</select>
		 <input type="hidden" name="sms" value="0"><br>
		 <label>Mobile Number</label><br>
		 <input type="text" class="form-control" id="from" name="from"><br>
         <input name="submit" class="btn btn-lg btn-primary btn-block" type="submit" value="submit" /></form><br>
		  
		  <div id="result" align="center"></div>
		  <script>
$("#newSMSForm").on("submit", function(e){
        
        var $inputs = $('#newSMSForm :input'), 
            values = {};
        $inputs.each(function() {
          values[this.name] = this.value;
        });
        
        $.ajax({
          type : "POST",
          url : "incoming.php",
          data: values,
          success : function(res) {
            $("#result").html(res);
            $("input[type=text]").val("");
          }
        });
        
        return false;
      });
      
      $(".back").on("click", function(){
        $("#result").html("");
      });
	  </script>
                    
                        <!-- /.panel-body --> 
						<div class="panel-footer"></div>
                    </div> 
                    <!-- /.panel -->
					
                </div>
                <!-- /.col-lg-8 -->
                
                </div>
                <!-- /.col-lg-4 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
	
    

    <!-- Bootstrap Core JavaScript -->
    <script src="./bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="./bower_components/metisMenu/dist/metisMenu.min.js"></script>

    

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

</body>

</html>
