<?php
//include config file
require_once "config.php";

//define variables and initialize with empty values
$productname = $quantity = "";
$productname_err = $quantity_err = "";


//process form it it has been submitted

if (isset($_POST["id"]) && !empty($_POST["id"]))
{
    //Get the hidden input value
    $id = $_POST["id"];

    //validate productname
    $input_productname = trim($_POST["productname"]);
    if(empty($input_productname))
    {
        $productname_err = "please enter a name";
    } elseif(!filter_var($input_productname, FILTER_VALIDATE_REGEXP,
    array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/"))))
    {
        $name_err = "Filter_var failed enter a valid name";
        //make this simpler!!
    } else{
        $productname = $input_productname;
    }


//validate the quantity to make sure it is a digit
$input_quantity = trim($_POST["quantity"]);
if(empty($input_quantity))
{
    $quantity_err = "Please enter the quantity amount";

} elseif(!ctype_digit($input_quantity))
{
$quantity_err = "Please enter a positive integer value";
} else {//if no errors
$quantity = $input_quantity;
}


//error checking before database insertion
if(empty($productname_err) && empty($quantity_err))
{
    //no errors continue with update statement
    $sql = "UPDATE kitcheninventory
            SET productname=:productname,
                quantity=:quantity
            WHERE id=:id";
    if ($stmt = $pdo->prepare($sql))
    {
        //bind variables as parameters
        $stmt->bindParam(":productname", $param_productname);
        $stmt->bindParam(":quantity", $param_quantity);
        $stmt->bindParam(":id",$param_id);

        //set parameters
        $param_productname = $productname;
        $param_quantity = $quantity;
        $param_id = $id;

        //execute the prepared statement
        if($stmt->execute())
        {
            //records successfully updated redirect to homepage
            header("location: index.php");
            exit();
        }else{
            echo "Something is wrong";
        }
}

//close statement
unset($stmt);
}
//close connection
unset($pdo);
} else{
    //check existenct of if parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"])))
    {

    //get url parameter
    $id = trim($_GET["id"]);

    //prepare a select staement
    $sql = "SELECT * FROM kitcheninventory 
                    WHERE id = :id";
    if ($stmt = $pdo->prepare($sql))
    {
        //bind variables as parameters
        $stmt->bindParam(":id",$param_id);
        //set parameters
        $param_id = $id;
        // attempt to execute the prepared statement
        if($stmt->execute())
        {
            if($stmt->rowCount() == 1)
            {
                //fetch result row as associative array
                //result set is single row so no while loop
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                //retrieve individual field values
                $productname = $row["productname"];
                $quantity = $row["quantity"];
            } else{
                //no valid id in URL , you'r screwd
                header("location: error.php");
                exit();
            }
        }else{
            echo "Sorry something is wrong, try again later";
        }
    }
    //close satement 
    unset($stmt);
    //close connection
    unset($pdo);

} else{
    //url has no id paramter. Redirect to error page
    header("location: error.php");
    exit();
}
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Record</title>
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
<h2 class="mt-5">Update Record</h2>
<p>Please edit the input values and submit to update the employee record.</p>
<form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
    <div class="form-group">
        <label>productName</label>
        <input type="text" name="productname" class="form-control <?php echo (!empty($productname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $productname; ?>">
        <span class="invalid-feedback"><?php echo $productname_err;?></span>
    </div>

  

    <div class="form-group">
        <label>quantity</label>
        <input type="text" name="quantity" class="form-control <?php echo (!empty($quantity_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $quantity; ?>">
        <span class="invalid-feedback"><?php echo $quantity_err;?></span>
    </div>
    <input type="hidden" name="id" value="<?php echo $id; ?>"/>
    <input type="submit" class="btn btn-primary" value="Submit">
    <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
</form>
</div>
</div>        
</div>
</div>





</body>
</html>




















