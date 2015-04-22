<?php require 'airlogger.php'; 
$menu = getMenuJSON();?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>KUPS Airlogger</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/calendar.min.css">
    <link rel="Shortcut Icon" type="image/ico" href="img/kupsIco.png"/>
        <style>
    body {
        padding-top: 100px;
        /* Required padding for .navbar-fixed-top. Remove if using .navbar-static-top. Change if height of navigation changes. */
    }
    </style>
   
  </head>
  <body>


    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
              <a class="navbar-brand" href="">
                <!-- <img alt="Brand" src="img/kupsIco.png" height="100%"> -->
                KUPS AIRLOGGER
              </a>       
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul id="year_nav" class="nav navbar-nav">


                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

          
    

      <div class="col-xs-6">
        <h1> Listen </h1>
        
        <div id="shows">
          
        </div>


      </div>

      <div class="col-xs-6" id="cal">


      </div>

  


  </body>

    <!-- jQuery Version 1.11.0 -->
    <script src="js/jquery.min.js"></script>
    <script src="dist/js/bootstrap.min.js"></script>
    <script src="js/calendar.min.js"></script>
    <script src="airlogger.js"></script>
    <script type="text/javascript">


  // pass PHP variable declared above to JavaScript variable
 

    $(document).ready(function() {
       
        // alert('sanity');
        var menu = <?php echo $menu;?> ;
        // console.log(menu);
        yeargen(menu);
        calInit();



         
        $('.mon').click(function(){

          // console.log(this.id);
          var raw = this.id;
          var date = raw.split('#');

          $.ajax({
            type: "POST",
            url: "airlogger.php",
            dataType: "json",
            data: {data : this.id}, 
            success: function(data) {
              getDaysInMonth(data, date[1], date[0]);
            }
          });

        });

        $('.down').click(function(event){
          event.preventDefault();
        });




    });

    // $('.play').ready(function() {
    //    // do stuff when DOM is ready
    //    alert("im ready!");
       
    // });



//   HOW TO GET ALL OF THE KEYS!!

  </script>
</html>