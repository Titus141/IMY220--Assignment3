<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>IMY 220 - Assignment 3</title>
	<meta name="author" content="Titus Matlejoane">
	<!-- Replace Name Surname with your name and surname -->
	
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<?php
	// See all errors and warnings
	error_reporting(E_ALL);
	ini_set('error_reporting', E_ALL);

	// Your database details might be different
	$mysqli = mysqli_connect("localhost", "root", "", "dbUser");

	$email = isset($_POST["loginName"]) ? $_POST["loginName"] : false;
	$pass = isset($_POST["loginPassw"]) ? $_POST["loginPassw"] : false;	
?>


<!DOCTYPE html>
<html>
<head>
	<title>IMY 220 - Assignment 3</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="style.css" />
	<meta charset="utf-8" />
	<meta name="author" content="Name Surname">
	<!-- Replace Name Surname with your name and surname -->
</head>
<body>
	<div class="container">
		<?php
			if($email && $pass)
			{
				$query = "SELECT * FROM tbusers WHERE email = '$email' AND password = '$pass'";
				$res = $mysqli->query($query);
				if($row = mysqli_fetch_array($res))
				{
					echo 	"<table class='table table-bordered mt-3'>
								<tr>
									<td>Name</td>
									<td>" . $row['name'] . "</td>
								<tr>
								<tr>
									<td>Surname</td>
									<td>" . $row['surname'] . "</td>
								<tr>
								<tr>
									<td>Email Address</td>
									<td>" . $row['email'] . "</td>
								<tr>
								<tr>
									<td>Birthday</td>
									<td>" . $row['birthday'] . "</td>
								<tr>
							</table>";
							
							
							
							
							
							
							
				
					echo 	"<form action='login.php' method='POST' enctype='multipart/form-data'>
								<div class='form-group'>
									<input type='file' class='form-control' name='pic' id='picToUpload' /><br/>
									<button><input type='submit' class='btn btn-basic' value='Upload Image' name='submit' /></button>
								</div>
						  	</form>";
							
							
							
					
					echo '<h3>Image Gallery</h3>';
							
								$query4 = "select * from tbgallery";
								$res3 = mysqli_query($mysqli, $query4);
							echo '<div class="row imageGallery">';
								while($row1=mysqli_fetch_assoc($res3))
								{
									$img = $row1['filename'];
							?>
							<!--<img src="gallery/<?php echo $img; ?>" class="rounded-circle" width="200" height="200">-->
									<div class="col-3" style="background-image: url(gallery/<?php echo $img?>)"></div>
								<?php
								}
					
					
				
				}
				else{
					echo 	'<div class="alert alert-danger mt-3" role="alert">
	  							You are not registered on this site!
	  						</div>';
				}
		?>
		</div>
				
				
		<?php
			} 
			else{
				echo 	'<div class="alert alert-danger mt-3" role="alert">
	  						Could not log you in
	  					</div>';
			}
		?>
		
		
			<?php
			
							
				if(isset($_POST['submit']))
				{
					
					$Image = $_FILES['pic']['name'];
					$Type = $_FILES['pic']['type'];
					$Temp = $_FILES['pic']['tmp_name'];
					$Size = $_FILES['pic']['size'];
			
					$ImageExt = explode('.', $Image);
					$AllowExt = strtolower(end($ImageExt));
					$Allow = array('jpg', 'jpeg');
					$Target = "gallery/".$Image;
			
					if(in_array($AllowExt, $Allow))
					{
						if($Size<1000000)
						{
							
							$queryId = "SELECT * FROM tbusers";
							$resId = mysqli_query($mysqli, $queryId);
								$rowId = mysqli_fetch_assoc($resId);
								$user_id = $rowId['user_id'];
							
								$Query = "INSERT INTO tbgallery (user_id, filename) VALUES ('$user_id','$Image')";
								$mysqli->query($Query);
							move_uploaded_file($Temp, $Target);
							$query3 = "select * from tbgallery";
							$res2 = mysqli_query($mysqli, $query3);
							while($row1=mysqli_fetch_assoc($res2))
							{
								$img = $row1['filename'];
			?>
							<img src="gallery/<?php echo $img; ?>" class="rounded-circle" width="200" height="200">
			<?php
							}
						}
						else
						{
							echo '<div class="alert alert-danger mt-3" role="alert">
											Image size is too large!
										</div>';
						}
					}
					else
					{
						echo  '<div class="alert alert-danger mt-3" role="alert">
									This type of image is not supported in this system, please upload jpg/jpeg images!
								</div>';
					}
			
				}
					
			?>
	</div>
</body>
</html>