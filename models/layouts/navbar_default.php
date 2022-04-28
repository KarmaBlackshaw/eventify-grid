<?php  
  if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in']  === false){
      $_SESSION['logged_in'] = false;
      header('Location: ' . base_views('error/session_error'));
      exit();
  } else{
    switch ($_SESSION['user_level_id']) {
      case '5':
        $user = "Student";
        break;
      
      case '6':
        $user = "Supreme Student Council";
        break;
      
      case '7':
        $user = "Building Coordinator";
        break;
      
      case '2':
        switch ($_SESSION['office_id']) {
          case '11':
            $user = "Management Information System";
            break;

          case '12':
            $user = "Plant and Facilities";
            break;

          case '6':
            $user = "Office of Student Affairs";
            break;
          
          default:
            $user = "";
            break;
        }
        break;
      
      default:
        $user = "";
        break;
    }

    define('user_level', $user);
  }
  
?>