<?php
require_once "config.php";

	$db = false;
	
	function connectDB()
	{
		global $DBhost;
		global $DBlogin;
		global $DBpassword;
		global $DBname;
		global $db;
		$db = new mysqli($DBhost, $DBlogin, $DBpassword, $DBname);
		$db->query("SET NAMES 'utf8'");
	}
	
	function closeDB()
	{
		global $db;
		$db->close();
	}
	
	function toArray($res)
	{
		while($row = $res->fetch_assoc())
			$arr[] = $row;
		return $arr;
	}
	
	function getArticleList($start, $limit)
	{
		global $db;
		connectDB();
		$res = $db->query("SELECT articles.id AS id, title, date, login 
							FROM articles LEFT JOIN users ON articles.user_id = users.id 
							ORDER BY id DESC LIMIT $start, $limit");
		closeDB();
		return toArray($res);
	}
	
	function getArticleById($id)
	{
		global $db;
		connectDB();
		$res = $db->query("SELECT articles.id AS id, title, date, text, login 
							FROM articles LEFT JOIN users ON articles.user_id = users.id WHERE articles.id = $id");
		closeDB();
		return $res->fetch_assoc();
	}
	
	function countArticles()
	{
		global $db;
		connectDB();
		$res = $db->query("SELECT COUNT(id) FROM articles");
		closeDB();
		$result = $res->fetch_row();
		return $result[0];
	}
	
	function getStart($page, $limit)
	{
		return ($page - 1) * $limit;
	}
	
	function pagination($page, $limit, $nearPagesCount)
	{
		$numPages = ceil(countArticles() / $limit);
		if($numPages == 1)
			return;
		if($page > $numPages)
			$page = $numPages;
		$prev = $page - 1;
		$next = $page + 1;
		if($prev < 1)
			$prev = 1;
		if($next > $numPages)
			$next = $numPages;
		
		$pagination = "";
		if($page == 1)
			$pagination .= "<span id=\"curPage\">1</span>";
		else
		{
			if($prev == 1)
				$pagination .= "<a href=\"index.php\">&lArr;</a>";
			else
				$pagination .= "<a href=\"index.php?page=".$prev."\">&lArr;</a>";
			$pagination .= "<a href=\"index.php\">1</a>";
		}
		if($page - $nearPagesCount > 2)
			$pagination .= "<span>...</span>";
		for($i = $page - $nearPagesCount; $i < $page; $i++)
		{
			if($i < 2)
				continue;
			else
				$pagination .= "<a href=\"index.php?page=".$i."\">".$i."</a>";
		}
		if($page != 1 && $page != $numPages)
			$pagination .= "<span id=\"curPage\">".$page."</span>";
		for($i = $page + 1, $end = $page + $nearPagesCount; $i <= $end; $i++)
		{
			if($i >= $numPages)
				break;
			else
				$pagination .= "<a href=\"index.php?page=".$i."\">".$i."</a>";
		}
		if($end + 1 < $numPages)
			$pagination .= "<span>...</span>";
		
		if($page == $numPages)
			$pagination .= "<span id=\"curPage\">".$numPages."</span>";
		else
		{
			$pagination .= "<a href=\"index.php?page=".$numPages."\">".$numPages."</a>";
			$pagination .= "<a href=\"index.php?page=".$next."\">&rArr;</a>";
		}
		return $pagination;
	}
	
	function filterLogin($login)
	{
		$login = trim($login);
		$login = strip_tags($login);
		$login = htmlspecialchars($login);
		return mysql_escape_string($login);
	}
	
	function filterText($text)
	{
		$text = get_magic_quotes_gpc() ? $text : addslashes($text);
		return $text;
	}
	
	function decodeText($text)
	{
		$text = get_magic_quotes_gpc() ? stripslashes($text) : $text;
		return $text;
	}
	
	function checkLogin($login)
	{
		global $db;
		connectDB();
		$res = $db->query("SELECT COUNT(id) FROM users WHERE login = '$login'");
		closeDB();
		$result = $res->fetch_row();
		return $result[0];
	}
	
	function getUserID($login, $pass)
	{
		global $db;
		connectDB();
		$res = $db->query("SELECT id FROM users WHERE login = '$login' AND password = '".md5($pass)."'");
		closeDB();
		$result = $res->fetch_assoc();
		return $result['id'];
	}
	
	function addUser($login, $pass)
	{
		global $db;
		connectDB();
		$res = $db->query("INSERT INTO users SET login='$login', password='".md5($pass)."'");
		$id = $db->insert_id;
		closeDB();
		return $id;
	}
	
	function addArticle($title, $text, $user_id)
	{
		global $db;
		connectDB();
		$title = mysql_escape_string($title);
		$text = mysql_escape_string($text);
		$res = $db->query("INSERT INTO articles SET title='$title', text='$text', user_id=$user_id");
		$id = $db->insert_id;
		closeDB();
		return $id;
	}
?>