<?php require_once('../../config/connect.php');
    session_start();
    if($_SESSION['admin']!=0){
        header('Location: login_page.php');
    }
?>


<?php
    if(isset($_GET['submit'])){
        $_SESSION['cate']=$_GET['cat'];
		$_SESSION['subcate']=$_GET['subcat'];
        //echo "asini";
        header('Location: user_package_page.php');    
    } 
?>
        
<?php require_once('user_navigation.php')?> 
<?php include('../../public/html/user_category_page.html')?>
<?php require_once('footer_user.php')?>
