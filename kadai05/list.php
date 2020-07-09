<?php

// セッションスタート
session_start();

require "funcs.php";
//ログインチェック
loginCheck();

//1.  DB接続します
$pdo = db_conn();


	//データベース接続用ファイルを読み込む
	// require_once("dbprocess.php");



	// $login_name = $_SESSION['lid']


//２．データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM gs_bool_db");
$status = $stmt->execute();



//２．データ登録SQL作成
$stmt01 = $pdo->prepare("SELECT * FROM gs_user_table WHERE lid");
$status01 = $stmt01->execute();

// $stmt01 = $pdo->prepare("SELECT * FROM gs_user_table");
// $stmt01->bindValue(':lid', $lid, PDO::PARAM_STR);
// $status01 = $stmt01->execute();

//３．データ表示
$view="";
if($status==false) {
    //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);

}else{
  //Selectデータの数だけ自動でループしてくれる
  //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
	//  $result = $stmt->fetch(PDO::FETCH_ASSOC);
}




	//書籍タイトルに該当する書籍データを取得するSQL文を用意
	// $sql = "SELECT * FROM bookinfo WHERE title LIKE '%{$title}%' ORDER BY isbn";

	//SQL文を発行し、結果セットを取得
	// $result = executeQuery($sql);


// if(!isset($_SESSION["lid"])) {
// 	echo "<p>未ログイン</p>";
// } else {
// 	$test = $_SESSION[''];
// 	echo "<p>ようこそ!</p>";
// 	echo "<a href='logout.php'>ログアウトする</p>"	 
// }


?>
	<!DOCTYPE html>
	<html lang="ja">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="css/reset.css">
		<link rel="stylesheet" type="text/css" href="css/main.css">
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<style>div{padding: 10px;font-size:16px;}</style>
	<title>書籍一覧ページ | 書籍管理システム</title>
</head>
<body>




	<div id="container">
		<header class="clearfix">
			<div class="title">
			<h1><a href="index.php">書籍管理システム</a></h1>
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
				<li><a href="about.php">ブックとは？</a></li>
				<li><a href="faq.php">Q&A</a></li>
			</ul>
		</nav>

		<nav id="menu">
			<ul class="clearfix">
				<li class="active"><a href="list.php">書籍一覧</a></li>
				<li><a href="entry.php">書籍登録</a></li>
			</ul>
		</nav>




		<h2>書籍一覧</h2>
		<table>
			<tr>
				<th>ISBN番号</th>
				<th>書籍タイトル</th>
				<th>著者</th>
				<th>ジャンル</th>
				<th>評価</th>
				<th>コメント</th>
				<th>回数</th>
				<th>登録日時</th>
				<th>更新/削除</th>
			</tr>
			<?php
			// 結果セットから1行データを取得し、変数$rowに格納し、全件取得するまで繰り返す
			// while ($row = mysql_fetch_array($result)) {

  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){ 

			?>


			<tr id="row_<?php echo $result["isbn"] ?>">
                <td class="isbn">
                    <a href="detail.php?id=<?php echo $result["id"]; ?>"><?php echo $result["isbn"]; ?></a>
                </td>
                <td class="title"><?php echo $result["title"]; ?></td>
								<td class="author"><?php echo $result["author"]; ?></td>
								<td class="genre"><?php echo $result["genre"]; ?></td>
								<td class="evaluation"><?php echo $result["evaluation"]; ?></td>
								<td class="comment"><?php echo $result["comment"]; ?></td>
                <td class="number_times"><?php echo $result["number_times"]; ?>回</td>
								<td class="indate"><?php echo $result["indate"]; ?></td>
                <td>
                    <a href="detail.php?id=<?php echo $result["id"]; ?>">更新</a>
                    <a href="delete.php?id=<?php echo $result["id"]; ?>" class="delete">削除</a>



                </td>
            </tr>
			<?php
			} // while終わり
			?>
		</table>


		<nav id="menu">
			<ul class="clearfix">
			<li><a href="all_delete.php" class="delete">全て削除</a></li>
			</ul>
		</nav>




		<footer>

		<p class="copyright">2020 TK Copyright © all rights reserved.</p>
		</footer>
	</div>

	<script type="text/javascript" src="js/main.js"></script>
</body>
</html>