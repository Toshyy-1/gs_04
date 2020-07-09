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


//   if(@$_POST["title"] != "" OR @$_POST["title"] != ""){ //IDおよびユーザー名の入力有無を確認
//     $stmt = $pdo->query("SELECT * FROM gs_bool_db WHERE title='".$_POST["title"] ."' OR Title LIKE  '%".$_POST["title"]."%')"); //SQL文を実行して、結果を$stmtに代入する。
// }




//２．データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM gs_bool_db WHERE title='".$_POST["title"] ."' OR title LIKE  '%".$_POST["title"]."%'");
$status = $stmt->execute();

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

		<h2>検索結果一覧</h2>
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
            <!-- ここでPHPのforeachを使って結果をループさせる -->
            <?php foreach ($stmt as $row): ?>
                <tr><td>
                <a href="detail.php?id=<?php echo $row[0] ?>"><?php echo $row[1]; ?></a>
                </td><td><?php echo $row[2]?></td><td><?php echo $row[3]?></td><td><?php echo $row[4]?></td><td><?php echo $row[5]?></td><td><?php echo $row[6]?></td><td><?php echo $row[7]?></td><td><?php echo $row[8]?></td><td>                    <a href="detail.php?id=<?php echo $row[0] ; ?>">更新</a>
                    <a href="delete.php?id=<?php echo $row[0] ; ?>" class="delete">削除</a></tr>
            <?php endforeach; ?>
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