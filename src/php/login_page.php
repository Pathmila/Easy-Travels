<?php require_once('../../config/connect.php');
    session_start();
?>
<?php require_once('user_nonnavigation.php')?> 
<?php 
	//echo md5("admin");
	//$_SESSION['loggedin']=1;
	if(isset($_POST['submit'])){
        $uname=$_POST['username'];
		$pwd=$_POST['password'];
		$_SESSION['pwd']=$pwd;

        $sql="SELECT * FROM account WHERE username='".$uname."'";
		//echo $sql;
        $result=mysqli_query($connection,$sql);

		//echo "dd";
		//print_r ($result);
		if($result->num_rows==1){
			$user=$result->fetch_assoc();
			$enpass=$user['password'];
			
			$encryption=checkencryptpassword((string)$pwd,(string)$enpass);
			//echo $encryption;
			
			if($encryption == 1){
				$_SESSION['loggedin']=1;
				$_SESSION['username']=$user['username'];
				//$_SESSION['pwd']=$user['password'];
				$_SESSION['aid']=$user['aid'];
				$_SESSION['uid']=$user['uid'];
				
				
				if($user['admin']==1){
					$_SESSION['admin']=1;
				}else if($user['admin']==0){
					$_SESSION['admin']=0;
				}else if($user['admin']==2){
					$_SESSION['admin']=2;
				}else if($user['admin']==3){
					$_SESSION['admin']=3;
				}else if($user['admin']==4){
					$_SESSION['admin']=4;
				}else{
					
				}
				
				if($_SESSION['admin']==1){
					header("Location: admin_home_page.php");
				}else if($_SESSION['admin']==0){
					header("Location: user_home_page.php");
				}else if($_SESSION['admin']==2){
					header("Location: guide_home.php");
				}else if($_SESSION['admin']==3){
					header("Location: hotel_home_page.php");
				}else if($_SESSION['admin']==4){
					header("Location: vehicle_home_page.php");
				}else{
					header("Location: login_page.php");
				}
			}else{
				echo "<script type='text/javascript'>alert('Invalid Password');</script>";
			}
        }else{
            echo "<script type='text/javascript'>alert('Invalid Username or Password');</script>";
        }
	}
?>
<?php
	function checkencryptpassword($pwd,$enpass){
		if(md5($pwd)== $enpass){
			return 1;
		}else{
			return 0;
		}
	}
			
?>
<?php include('../../public/html/login_page.html')?>
<?php require_once('footer.php')?>
