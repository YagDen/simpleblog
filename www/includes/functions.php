<?php
	$db = false;
	function connectDB()
	{
		global $db;
		$db = new mysqli("localhost", "root", "", "simpleblog");
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
		$res = $db->query("SELECT id, title, date FROM articles ORDER BY id DESC LIMIT $start, $limit");
		closeDB();
		return toArray($res);
	}
	
	function getArticleById($id)
	{
		global $db;
		connectDB();
		$res = $db->query("SELECT * FROM articles WHERE id = $id");
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
?>