<?php if (!session_id()) { session_start(); } ?>
<?php include_once('_conn.php');

    $adminID = $_POST['adminID'];
    $adminPW = $_POST['adminPW'];

    if($adminID!="")
    {
        $sql="select * from tb_admin where adminID='$adminID' and adminPW='$adminPW'";
        $result = mysqli_query($conn, $sql);
        $row=$result->num_rows;
        if($row==1)
        {

            $_SESSION["ADMINID"]=$adminID;

            echo("session:" . $_SESSION["ADMINID"]);
            echo("<script>location.href='/admin'</script>");
        }
    }

  //  echo("<script>location.href='login.php'</script>");
?>
