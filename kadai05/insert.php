<?php
//1. POSTデータ取得
//$name = filter_input( INPUT_GET, ","name" ); //こういうのもあるよ
//$email = filter_input( INPUT_POST, "email" ); //こういうのもあるよ


	//登録ボタンが押されたら
	// if (isset($_POST["isbn"])) {
		//POSTデータを取得
		$isbn  = $_POST["isbn"];
		$title = $_POST["title"];
		$author = $_POST["author"];
		$genre  = $_POST["genre"];
		$evaluation = $_POST["evaluation"];
		$comment = $_POST["comment"];
		$number_times = $_POST["number_times"];


//データベース接続用ファイルを読み込む
	// require_once("dbprocess.php");
	require "funcs.php";
	$pdo = db_conn();	


//入力チェック（受信確認処理）
if(
  !isset($_POST["isbn"]) || $_POST["isbn"]=="" ||
  !isset($_POST["title"]) || $_POST["title"]=="" ||
	!isset($_POST["author"]) || $_POST["author"]=="" ||
	!isset($_POST["genre"]) || $_POST["genre"]=="" ||
	!isset($_POST["evaluation"]) || $_POST["evaluation"]="" ||
	!isset($_POST["comment"]) || $_POST["comment"]=="" ||
	!isset($_POST["number_times"]) || $_POST["number_times"]==""

){
  exit('ParamError');
}



	//2. DB接続します
	// try {
	// 	//Password:MAMP='root',XAMPP=''
	// 	$pdo = new PDO('mysql:dbname=gs_book_db;charset=utf8;host=localhost','root','root');
	// } catch (PDOException $e) {
	// 	exit('DBConnectError:'.$e->getMessage());
	// }

	
	//３．データ登録SQL作成
	$stmt = $pdo->prepare("INSERT INTO gs_bool_db(id,isbn,title,author,genre,evaluation,comment,number_times,indate)VALUES(NULL,:a1,:a2,:a3,:a4,:a5,:a6,:a7,sysdate())");
	$stmt->bindValue(':a1', $isbn, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
	$stmt->bindValue(':a2', $title, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
	$stmt->bindValue(':a3', $author, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
	$stmt->bindValue(':a4', $genre, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
	$stmt->bindValue(':a5', $evaluation, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
	$stmt->bindValue(':a6', $comment, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
	$stmt->bindValue(':a7', $number_times, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)

	$status = $stmt->execute();
		
	
	
	
	
	
	
	//書籍情報を登録するSQL文を用意
		// $sql = "INSERT INTO bookinfo VALUES('{$isbn}', '{$title}', '{$price}')";

		//SQL文を発行
		// executeQuery($sql);



		//４．データ登録処理後
		if($status==false){
			//SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
			$error = $stmt->errorInfo();
			exit("ErrorMassage:".$error[2]);
		}else{

	// 	//書籍一覧ページに遷移
		header("Location: index.php");
		exit;
	}


?>


<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="css/reset.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<title>書籍登録ページ | 書籍管理システム</title>
</head>
<body>
	<div id="container">
		<header class="clearfix">
			<div class="title">
				<h1>書籍管理システム</h1>
			</div>
			<div class="search">
			<form action="search_results.php" method="post">
					<p class="keyword">
						<input type="text" name="title" placeholder="検索したい書籍タイトルを入力" value="">
					</p>
					<p class="submit">
						<input type="submit" value="検索">
					</p>
				</form>
			</div>
		</header>

		<nav id="menu">
			<ul class="clearfix">
				<li><a href="list.php">書籍一覧</a></li>
				<li class="active"><a href="entry.php">書籍登録</a></li>
			</ul>
		</nav>

		<h2>書籍登録</h2>
		<div id="insert">
			<form action="insert.php" method="post">
				<table>
					<tr>
						<th>ISBN</th>
						<td><input type="text" name="isbn" value=""></td>
					</tr>
					<tr>
						<th>TITLE</th>
						<td><input type="text" name="title" value=""></td>
					</tr>
					<tr>
						<th>価格</th>
						<td><input type="text" name="price" value=""></td>
					</tr>
				</table>
				<input type="submit" value="登録" class="button">
			</form>
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
	</div>
</body>
</html>