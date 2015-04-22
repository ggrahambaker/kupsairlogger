<?php 

// ini_set(‘error_log’, ‘script_errors.log’);
// ini_set(‘log_errors’, ‘On’);
// ini_set(‘display_errors’, ‘Off’);

function getShowYears(){
  // get all folders in the dir
  $wDir = getcwd();
  // get all of the things in our dir
  $items = scandir($wDir);
  // use this to push the year directories on
  $years = array();
  foreach ($items as $folder) {
    # code...
    if (!is_dir($wDir . '/' . $folder)) {
      // echo "this is not a dir! --- > " . $result;
      continue;
    } elseif (strpos($folder, '.') !== FALSE) {
      # code...
      // echo $folder;
      continue;
    } elseif (!is_numeric($folder)) {
      # code...
      continue;
    }

      // echo $folder;
      // echo "<br>";
      array_push($years, $folder);
  }
  
return $years;
}

function getShowsByMonth($mon){

  $wDir = getcwd();
  $dir    = $wDir . '/' . $mon;
  $result = scandir($dir);
  $months = array();

  foreach ($result as $result) {
      if (!is_dir($dir . '/' . $result)) {
        // echo "this is not a dir! --- > " . $result;
        continue;
      } else {
        if (strpos($result, '.') !== FALSE){
          // echo $result;
          continue;
        }
        array_push($months, $result);
      }
    }

  //    print_r($months);
  return $months;
}

function getMenuJSON(){
  $data = array();

  $years = getShowYears();

  foreach ($years as $year) {
    # code...
    $data[$year] = getShowsByMonth($year);
  }
  return json_encode($data);
}


function getShowsInMonth($year, $month){
  // echo $month ." this is the month" ."<br>";
  $wDir = getcwd(); 
  
  $dir = $wDir . "/" . $year . "/" . $month . "/";
  $content = glob($dir . "*.mp3");
  $dateArr = array();
  
  foreach ($content as $show) {
    # code...
    // echo $show;
    $usablePath = trim($show, $wDir);
    
    $date = date ("F d Y H:i:s.", filemtime($usablePath));
    $dateArr[$usablePath] = date_parse($date);
    // array_push($dateArr, );
  }

  // print_r($dateArr);
  // NOW THAT WE HAVE ALL OF THE SHOWS IN THE MONTH, 
  // we want to sort by days
  $days = array();

  $times = array_values($dateArr);

  foreach ($times as $array) {
   //  echo "the value of month" . $array["day"];
    // echo "<br>";
    if(!in_array($array["day"], $days)){
      // if its not already in here, put it in;
      array_push($days, $array["day"]);
    }
    
  }
  // echo "<br>";
  sort($days);


  // we have a sorted asending list of days of shows
  // now we have to put it in the key of the array that will be returned
  // and we have to use the value to search for the shows we want to include in the new array

  $final = array();
  foreach ($days as $day) {


    // WHAT I SHOULD BE DOING
    // array_push($final, getShowsByDay($dateArr,$day));
    $final[$day] = getShowsByDay($dateArr,$day);  
  }  
  return $final;
}
// this is a helper method for getShowsInMonth
// its going to format the day into an array of shows
// that will be passed into the month
// we want to give back the time of the show and the mp3 path
function getShowsByDay($month, $indexDay){

  // echo "WE ARE IN HELPER<br>" . $indexDay . "<br>";
  // print_r($month);

  $day = array();

  $times = array_values($month);

  foreach ($times as $array) {
    // temp! gets erased errytime
    $show = array();
    if($indexDay == $array["day"]){
      $mp3 = array_search($array, $month);
      $hour = $array["hour"];
      $minute = $array["minute"];
      $year = $array["year"];
      $date = $array["day"];
      $monthD = $array["month"];

      $show["mp3"] = $mp3;
      $show["hour"] = $hour;
      $show["minute"] = $minute;
      $show["year"] = $year;
      $show["day"] = $date;
      $show["month"] = $monthD;
      //$day[$indexDay] = $show;
      array_push($day, $show);
    }
  }
  // $hr = array();
  // foreach ($day as $key => $row)
  // {
  //     $hr[$key] = $row['hour'];
  // }
  // array_multisort($day, SORT_ASC, $hr);
  // print_r($day);
  return $day;
}


function getMonthJSON($year, $month){
  $data = getShowsInMonth($year, $month);
  // print_r($data);
  return json_encode($data);
}

// utility methods for the arrays that comes back from
// getShowsInMonth(year, month)

function getDay($data, $day){
  $dayRet = $data[$day];
  return $dayRet;
}



// THIS SECTION HANDLES ALL THE AJAX CALLS
if (isset($_POST['data'])) {
  $data = $_POST['data'];
  $dates = explode("#", $data);
  $ret = getMonthJSON($dates[1], $dates[0]);

  echo $ret;
}


















// NOT USED YET????
// NOT USED YET????
// NOT USED YET????
// NOT USED YET????
// NOT USED YET????
// NOT USED YET????
// NOT USED YET????

function getDaysByMonth($month){

  

  $times = array_values($month);
  // $numDays = 0;
  echo "printing daysby month times getting passed in<br>";
  // print_r($times);
  
  foreach ($times as $array) {
   //  echo "the value of month" . $array["day"];
    echo "<br>";
    if(!in_array($array["day"], $days)){
      // echo "WOOWW";
      array_push($days, $array["day"]);
    }
    
  }
  // echo "<br>";
  sort($days);
  // print_r($days);
  // echo "<br> MAX DAYS!" . max($days) . "<br>";
  // print_r($days);
  return $days;
}







  function directoryTrimmer($dir){
    foreach ($dir as $file) {
      if(!strpos($file, ".mp3")){
        echo 'not an MP3';
        echo $file;
        unset($dir[$file]);
      }
    }

    foreach ($dir as $file) {
        echo "<br>" . $file;
    }
  }

function folderExt(){
  $wDir = getcwd();
  $dir    = $wDir . "/2014";
}









  function init(){
    $ar = getDaysByMonth(10);
    echo sizeof($ar);
    echo "<br>";
    print_r(getDaysByMonth(10));
  }

  function getAll(){

    $arr = getShowsByMonth();
    // spit out all of the months
    $data = array();
    foreach ($arr as $month) {
      # code...

      // first assign the month to key
      foreach ($variable as $key) {
         # code...

       }

       $data[$month]; 
    }
    $showsInMon = getShowsInMonth(10);
    $dayOfShows = getShowsByDay($showsInMon, 24);

    print_r($dayOfShows);
  }



  // if($_REQUEST["month"]) {
  //    $month = $_REQUEST['month'];

  //    $shows = getShowsInMonth($month);
  //    echo json_encode($shows);
  // }


  // if($_REQUEST["month"]) {
  //    $month = $_REQUEST['month'];

  //    $shows = getShowsInMonth($month);
  //    echo json_encode($shows);
  // }

  ?>