<?php require_once('user_nonnavigation.php')?> 
<?php 
    require_once('../../config/connect.php');
    session_start();
    $sql4="select max(photo) from vehicle";
    $result4=mysqli_query($connection,$sql4);
    $max=mysqli_fetch_assoc($result4);
    $maxid=$max['max(photo)'];
    $nextid=$maxid+1;
	//echo $maxid;
?>
<?php
    if(isset($_POST['formsubmit'])){
		$targetdir = '../../public/images/vehicle/';   
		$name=$nextid;
		$ext=".jpg";
		$targetfile = $targetdir.$name.$ext;
		if (move_uploaded_file($_FILES['image']['tmp_name'], $targetfile)) {
		}
    }        
?>
<?php
	$_GLOBAL['accountdone']=0;
    $_GLOBAL['vehicledone']=0;

    if(isset($_POST['formsubmit'])){
		$vid=$_POST['vid'];
		$owner=$_POST['owner'];
		$charge=$_POST['charge'];
		$uname=$_POST['uname'];
		$pass=$_POST['password'];
        $cpassword=$_POST['cpassword'];
        $address=$_POST['address'];
        $type=$_POST['type'];
        $description = $_POST['description'];
        $email= $_POST['email'];
        $telephone =$_POST['telephone'];
		$photo=$nextid;
		
		$hash = md5($cpassword);
			
		$checked = checkusername($uname,$connection);
		$checkedemail = checkemail($email,$connection);
				
		if(($checked==1) && ($checkedemail==1)){
			
			//insert data to guide  table

			$insertguide = "INSERT INTO vehicle(vid,name,charge,email,address,telephone,type,details,photo) values ('".$vid."','".$owner."','".$charge."','".$email."','".$address."','".$telephone."','".$type."','".$description."','".$photo."')";
			$result2=$connection->query($insertguide);
					
			if($result2){
				$_GLOBAL['vehicledone']=1;
			}else{
				$_GLOBAL['vehicledone']=0;
			}
					

			//insert in to account table
			$insertaccount = "INSERT INTO account(uid,username,password,admin) values ('".$vid."','".$uname."','".$hash."',4)";
			//echo $insertaccount;
			$result=$connection->query($insertaccount);
			if($result){
				$_GLOBAL['accountdone']=1;
			}else{
				$_GLOBAL['accountdone']=0;
			}
			  
			if(($_GLOBAL['accountdone']==1) && ($_GLOBAL['vehicledone']==1)){
				echo "<script> alert('Registration is Sucessfull') </script>";
				header("Location: login_page.php");
			}else{
				//echo "failed";
				echo "<script> alert('Registration is Failed') </script>";
			}
		}else if($checked==0){
			//echo 'failed';
			//header("Location: account_page.php");
			$uname="";
			echo "<script> alert('Username already used..') </script>";
		}else if($checkedemail==0){
			//echo 'failed';
			//header("Location: account_page.php");
			$email="";
			echo "<script> alert('Email already used..') </script>";
		}else{
			
		}
    }        
?>
<?php
	function checkusername($uname,$connection){
		$sql10="select * from account where username='".$uname."'";
		//echo $sql10;
		$result10=mysqli_query($connection,$sql10);
		if($row10=$result10->fetch_assoc()){
			return 0;
		}else{
			return 1;
		} 
	}
?>

<?php
	function checkemail($email,$connection){
		$sql11="select * from vehicle where email='".$email."'";
		//echo $sql10;
		$result11=mysqli_query($connection,$sql11);
		if($row11=$result11->fetch_assoc()){
			return 0;
		}else{
			return 1;
		} 
	}
?>

<?php include('../../public/html/vehicle_signup_page.html')?>
<?php require_once('footer.php')?>
