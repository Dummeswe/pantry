<?php
//check existense of id parameter first
if(isset($_GET["id"]) && !empty(trim($_GET["id"])))
{
    //include config file
    require_once "config.php";


//prepare a select statement with pdo
$sql = "SELECT * FROM kitcheninventory WHERE id = :id";

if($stmt = $pdo->prepare($sql))
{ //beginning of if
    //bind vars to prepared statement as parameters
    $stmt->bindParam(":id", $param_id);

    //set parameters
    $param_id = trim($_GET["id"]);

    //execute prepares statement
    if ($stmt->execute())
    {
        if($stmt->rowCount() == 1)
        {
            //fetch result row as assoc array
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            //get individual field value
            $productname = $row["productname"];
            $quantity = $row["quantity"];
        } else{
            //no valid par, get error page
            header("location: error.php");
            exit();
        }
    } else{
        echo "Sorry something went wrong";

    }
} //end of if

//close statement
unset($stmt);
//close connecetion
unset($pdo);
} else{ //URL doesnt contain id parameter. Redirect to error page
    header("location: error.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>View Record</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<style>
.wrapper{
width: 600px;
margin: 0 auto;
}
</style>
</head>
<body>
<div class="wrapper">
<div class="container-fluid">
<div class="row">
<div class="col-md-12">
<h1 class="mt-5 mb-3">View Record</h1>

<div class="form-group">
<label>productName</label>
<p><b><?php echo $row["productname"]; ?></b></p>

<div class="form-group">
<label>quantity</label>
<p><b><?php echo $row["quantity"]; ?></b></p>
</div>
<p><a href="index.php" class="btn btn-primary">Back</a></p>
</div>
</div>        
</div>
</div>
</body>
</html>











