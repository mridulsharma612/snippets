  <?php  
require_once "function.php";
require_once "pagination.php";
checkIfNotLogin();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset='utf-8'>
      <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <title>Welcome Page</title>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
				<link rel='stylesheet' type='text/css' media='screen' href='css/welcome.css'>
	      <script src="js/welcome.js"></script>
          </head>
			<body>
			 <h2>Welcome 
              <?php echo $_SESSION['login_user']; ?>
            </h2>
            <div class="search">
              <form action="welcome.php" method="post">
                <input type="text" name="query" value="<?php echo $vs; ?>">
                  <input type="submit" name="subm" value="Search">
                  </form>
                </div>
                <div class="navbar">
                  <a href="#">Home</a>
                  <a href="registration.php">Add User</a>
                  <a href="logout.php">Logout</a>
                </div>
                <table class='info' border='1'>
                  <tr>
                    <th>Serial No.</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Gender</th>
                    <th>address</th>
                    <th>Subjects</th>
                    <th>Photo Upload</th>
                    <th colspan='2'>Action</th>
                  </tr>
<?php
	$found=0;
    $user_arr = array();
	$counter = (($pagenum-1) * $page_rows)+1;
    while ($ro = mysqli_fetch_array($qu)){
        $found=1;
		
        $user_arr[] = array($ro["first_name"],$ro["last_name"],$ro["email"],$ro["gender"],$ro["address"],$ro["subjects"]);
        $subject = explode(',', $ro['subjects']); 
?> 
       <tr class="mainTr<?php echo $ro['id']; ?>">
	   <input type="hidden" name="idd" value=<?php echo $ro["id"];?>>
        <td><?php echo $counter; ?> </td>
		<td>
		<span id="TextVal"><?php echo $ro["first_name"]; ?> </span>
		<input type="text" name="first_name" value="<?php echo $ro["first_name"]; ?>" id="edit">
		</td>
		<td>
		<span id="TextVal"><?php echo $ro["last_name"]; ?> </span>
		<input type="text" name="last_name" value="<?php echo $ro["last_name"]; ?>"  id="edit">
		</td>
		<td>
      	<span id="TextVal"><?php echo $ro["email"]; ?> </span>	
		<input type="text" name="email_name" value="<?php echo $ro["email"]; ?>"  id="edit">
		 </td>
		<td>
		<span id="TextVal"><?php echo $ro["gender"]; ?> </span>	
		<select name="gender"  id="edit">
		<option value="male" <?php if($ro["gender"]=="male"){ ?> select="select"<?php }?>>male</option>
		<option value="female" <?php if($ro["gender"]=="female"){ ?> select="select"<?php }?>>female</option>

		</select>
		</td>
		<td>
		 <span id="TextVal"><?php echo $ro["address"]; ?> </span>	
		 <textarea  id="edit" name="address"><?php echo $ro["address"]; ?></textarea>
         </td>
		<td>
				 <span id="TextVal"><?php echo $ro['subjects']; ?> </span>	

		    <span id="edit">
            <input type="checkbox" name="subjects[]" class="sub1" value="English" <?php if (in_array("English", $subject)) {?>checked='checked'<?php }?> >English
            <input type="checkbox"  name="subjects[]" class="sub1" value="Hindi" <?php if (in_array("Hindi", $subject)) { ?>checked='checked'<?php }?>>Hindi
            <input type="checkbox"  name="subjects[]" class="sub1" value="Punjabi" <?php if (in_array("Punjabi", $subject)) { ?>checked='checked'<?php }?>>Punjabi
			</span>
		</td>
		<td><?php  if (isset($ro['upload_photo']) && !empty($ro['upload_photo'])){ ?>
        <img src="images/<?php echo $ro['upload_photo'];?>" width='100' height='100'>
		<?php } else {
			?>
		<img src="images/unknown.jpg" width ='100' height = '100'></td>
       <?php } ?> </td>
		
      
	   <td><a href="javascript:showInput_1(<?php echo $ro['id']; ?>)">Edit</a>
	   <a href="javascript:showInput_2(<?php echo $ro['id']; ?>)">Save</a>
	   </td>

       <td><a onclick="javascript:myFunction();return false;" href="delete.php?id=<?php echo $ro['id'];?>">Delete</a></td>
        </tr>
<?php		
		$counter++;
}
echo "</table>";
if ($found==0){
    echo "No Results Found";
}
mysqli_close($conn);
?>
<div class="pagination">
<?php
$serialize_user_arr = serialize($user_arr);
?> 

<?php
echo $paginationCtrls;
?>
<form method="post" action="download.php">
  <textarea style="display:none" name='export_data'>
    <?php
    echo $serialize_user_arr;
    ?>
  </textarea>
	<input type='submit' value='Download Table' name='Export'>
     </form>
   </div> 
  </body>
</html>

