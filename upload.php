<?php
//session autheniticaiton
session_start();
if(!$_SESSION['auth']){
	header('location:login.php');
}
//upload csv file to DB
if($_POST){
$target_dir = "uploads/";
$target_file = $target_dir.basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if csv is actuall csv 
if(isset($_POST["submit"])) {
    $mimes = array('application/vnd.ms-excel','text/plain','text/csv','text/tsv');
    if(!in_array($_FILES['fileToUpload']['type'],$mimes) || $fileType != "csv") {
		echo "Sorry, only CSV file is allowed.";
		$uploadOk = 0;
    }
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 50000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// if Everything is ok, try to upload file
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
         echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
		$db="sample_db"; //DB table
		$db_table = "sample";
		$uploadfile = $_FILES["fileToUpload"]["tmp_name"];
		$conn=mysqli_connect($_SESSION['host'], $_SESSION['user'], $_SESSION['pass'], $db);
		$query="CREATE TABLE IF NOT EXISTS $db.$db_table (`COL 1` int(3), `COL 2` varchar(95), `COL 3` varchar(18), `COL 4` int(5), `COL 5` decimal(7,2), `COL 6` decimal(6,2), `COL 7` decimal(4,2), `COL 8` varchar(21), `COL 9` varchar(30), `COL 10` varchar(3)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;";
		$load = "LOAD DATA LOCAL INFILE \"".addslashes (realpath($target_file))."\" INTO TABLE $db_table
				FIELDS TERMINATED BY ',' 
				ENCLOSED BY '\"' 
				LINES TERMINATED BY '\r\n'";
		//echo $load;
		$result=mysqli_query($conn, $query) or trigger_error(mysqli_error()." ".$query);
		$result=mysqli_query($conn, $load) or trigger_error(mysqli_error()." ".$load);
		if($result){
			echo "SUCCESSFULLY UPLOADED CSV INTO DB";
			unlink($target_file); //clean up file
		}
		else{
			echo $result;
			echo "FAILED TO UPLOAD CSV INTO DB";
		}
	} else {
        echo "Sorry, there was an error uploading your file.";
    }
}
	//TODO validate csv format
	//TODO validate csv content
	//reference: https://stackoverflow.com/questions/5593473/how-to-upload-and-parse-a-csv-file-in-php
	//https://stackoverflow.com/questions/11448307/importing-csv-data-using-php-mysql
	
	//TODO SQL injection
	//TODO hash password
	//reference: https://www.youtube.com/watch?v=kJGbxoRir_4&t=2s
	//https://www.youtube.com/watch?v=KXj-cZXoXZk
}	
?>


<h1>You are authenticated!</h1>
<form action="upload.php" method="POST" enctype="multipart/form-data">
    Select file to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload File" name="submit">
</form>
<form action="logout.php">
	<input type="submit" value="Logout" />
</form>