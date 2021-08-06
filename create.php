<?php
// Include config file
require_once "config.php";
include "header.php";

// Define variables and initialize with empty values
$productname = $quantity =  "";
$productname_err = $quantity_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
// Validate name
$input_productname = trim($_POST["productname"]);

if(empty($input_productname))
{
$productname_err = "Please enter a name.";

} elseif(!filter_var($input_productname, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/"))))
{
$productname_err = "Please enter a valid name.";
} else{
$productname = $input_productname;
}



// Validate quantity
$input_quantity = trim($_POST["quantity"]);
if(empty($input_quantity))
{
$quantity_err = "Please enter the quantity amount.";     
} elseif(!ctype_digit($input_quantity))
{
$quantity_err = "Please enter a positive integer value.";
} else{
$quantity = $input_quantity;
}

// Check input errors before inserting in database
if(empty($productname_err)  && empty($quantity_err))
{
    $sql = "INSERT INTO kitcheninventory
     (productname, quantity) 
     VALUES (:productname,:quantity)";

if($stmt = $pdo->prepare($sql))
{
// Bind variables to the prepared statement as parameters
$stmt->bindParam(":productname", $param_productname);

$stmt->bindParam(":quantity", $param_quantity);

// Set parameters
$param_productname = $productname;

$param_quantity = $quantity;

// Attempt to execute the prepared statement
if($stmt->execute())
{
// Records created successfully. Redirect to landing page
header("location: index.php");
exit();
} else{
echo "Oops! Something went wrong. Please try again later.";
}
}

// Close statement
unset($stmt);
}

// Close connection
unset($pdo);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
<h2 class="mt-5">Add product to the pantry</h2>
<p></p>
<form 
action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

<div class="form-group">
<label>Product</label>
<input type="text" name="productname" class="form-control 
<?php echo (!empty($productname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $productname; ?>">
<span class="invalid-feedback"><?php echo $productname_err;?></span>
</div>


<div class="form-group">
<label>How many?</label>
<input type="number" name="quantity" class="form-control 
<?php echo (!empty($quantity_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $quantity; ?>">
<span class="invalid-feedback"><?php echo $quantity_err;?></span>
</div>

<input type="submit" class="btn btn-primary" value="Submit">
<a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
</form>
</div>
</div>        
</div>
</div>
</body>
</html>