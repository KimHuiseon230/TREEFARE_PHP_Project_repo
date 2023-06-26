<?php
include $_SERVER['DOCUMENT_ROOT']."/ilhase/common/lib/db_connector.php";

    $num   = $_GET["num"];
    $page   = $_GET["page"];

    // $copied_name = $row["file_copied"];

	if ($copied_name)
	{
		$file_path = "./data/".$copied_name;
		unlink($file_path);
    }

    $sql = "delete from qna where num = $num";
    mysqli_query($conn, $sql);
    mysqli_close($conn);

    echo "
	     <script>
	         location.href = 'qna.php?page=$page';
	     </script>
	   ";
?>
