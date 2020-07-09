<?php

// セッションスタート
session_start();


//1.  DB接続します
include("funcs.php");
$pdo = db_conn();


if( isset($_SESSION['user']) != "") {
	// ログイン済みの場合はリダイレクト
  header("Location: list.php");
}

if (!empty($_POST)) {
    if ($_POST['lid'] === '') {
        $error['lid'] = 'blank';
    }
    if ($_POST['email'] === '') {
        $error['email'] = 'blank';
    } 
    if ($_POST['lpw'] === '') {
        $error['lpw'] = 'blank';
    }

    if (!isset($error)) {
      $users_info = $db->prepare('SELECT * FROM gs_user_table WHERE email=?');
      $users_info->execute(array(
          $_POST['email']
      ));
      $user_id = $users_info->fetch();
      if (!empty($user_id)) {
          $error['email'] = 'joined';
      }
  }
  
  if (!isset($error)) {
      $_SESSION['join'] = $_POST;
      header("Location: check.php");
      exit();
  }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=, initial-scale=1.0">
  <title>会員登録</title>
  <link rel="stylesheet/less" type="text/css" href="css/login.less">
  <link rel="stylesheet" type="text/css" href="css/reset.css">

<script src="http://cdnjs.cloudflare.com/ajax/libs/less.js/2.5.1/less.min.js"></script>
<script src="js/main.js"></script>


</head>
<body>
  

<?php
// signupがPOSTされたときに下記を実行
if(isset($_POST['signup'])) {

	$lid = $mysqli->real_escape_string($_POST['username']);
	$email = $mysqli->real_escape_string($_POST['email']);
	$lpw = $mysqli->real_escape_string($_POST['password']);
	$lpw = password_hash($password, PASSWORD_DEFAULT);

	// POSTされた情報をDBに格納する
	$query = "INSERT INTO gs_user_table(lid,email,lpw) VALUES('$lid','$email','$lpw')";

	if($mysqli->query($query)) {  ?>
		<div class="alert alert-success" role="alert">登録しました</div>
		<?php } else { ?>
		<div class="alert alert-danger" role="alert">エラーが発生しました。</div>
		<?php
	}
} ?>


<div class="wrapper">
    <div class="container">
        <h1>会員登録フォーム</h1>

        <form class="form" action="login_act.php" method = "post">
            <input type="text" placeholder="Username" name="lid" value ="<?php echo htmlspecialchars($_POST['lid'], ENT_QUOTES); ?>" required><?php if($error['name'] === 'blank'): ?>
        <p class="error">＊名前を入力してください</p>
        <?php endif ?>
            <input type="email" placeholder="メールアドレス" name="email" value ="<?php echo htmlspecialchars($_POST['email'], ENT_QUOTES); ?>" required><?php if($error['email'] === 'blank'): ?>
        <p class="error">＊メールアドレスを入力してください</p>
        <?php elseif ($error['email'] === 'joined'): ?>
        <p class="error">＊既に登録されたメールアドレスです</p>
        <?php endif ?>
            <input type="password" placeholder="Password" name="lpw" value = "" required><?php if($error['password'] === 'blank'): ?>
        <p class="error">＊パスワードを入力してください</p>
        <?php endif ?>
            <input type="submit" id="login-button" name ="signup" value = "会員登録する" />

            <a href="login.php">ログインはこちら</a>
        </form>
    </div>
    
    <ul class="bg-bubbles">
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
    </ul>
</div>

<nav id="menu">
			<ul class="clearfix">
				<li><a href="about.php">ブックとは？</a></li>
				<li><a href="faq.php">Q&A</a></li>
			</ul>
		</nav>
		<footer>

		<p class="copyright">2020 TK Copyright © all rights reserved.</p>
		</footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
</body>
</html>

