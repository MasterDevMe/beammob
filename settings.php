<?php
include("includes/includedFiles.php");
?>

<div class="entityInfo">

	<div class="centerSection">
		<div class="userInfo">
			<div class="profile">
				<img src="<?php echo $userLoggedIn->getprofilePic(); ?>">
			</div>
			<h1><?php echo $userLoggedIn->getUsername(); ?></h1>

		</div>
	</div>

	<div class="buttonItems">
		<button class="button" onclick="openPage('fileUpload.php')">Upload Pic</button>

<?php


if (isset($_POST["submit"]))
 {
     #retrieve file title
        $title = $_POST["title"];

    #file name with a random number so that similar dont get replaced
     $pname = rand(1000,10000)."-".$_FILES["file"]["name"];

    #temporary file name to store file
    $tname = $_FILES["file"]["tmp_name"];

     #upload directory path
$uploads_dir = 'images';
    #TO move the uploaded file to specific location
    move_uploaded_file($tname, $uploads_dir.'/'.$pname);


   #sql query to insert into database
    $sql = "INSERT into fileup(title,image) VALUES('$title','$pname')";

    if(mysqli_query($con,$sql)){

    echo "File Sucessfully uploaded";
    }
    else{
        echo "Error";
    }
}


?>




		<button class="button" onclick="openPage('updateDetails.php')">USER DETAILS</button>
		<button class="button" onclick="logout()">LOGOUT</button>
	</div>


</div>
