<?php
if(isset($errormsg))
{
if ($errortype=='message') { 

 echo '<div class="alert alert-block alert-success">'.$errormsg.'</div>';

} 
else if($errortype=='success')
{

 echo '<div class="alert alert-block alert-success">'.$errormsg.'</div>';

}
else if($errortype=='error')
{

 echo '<div class="alert alert-danger">'.$errormsg.'</div>';

}
else if($errortype=='warning')
{

 echo '<div class="alert alert-block alert-warning">'.$errormsg.'</div>';

}else{

//   if($message!=''){
  
//   echo '<div class="alert alert-block alert-success">'.$message.'</div>';
// }
}
}
 ?>