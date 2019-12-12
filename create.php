<?php

/**
 * Use an HTML form to create a new entry in the
 * users table.
 *
 */


if (isset($_POST['submit'])) {
    require "../config.php";
    require "../common.php";

    try  {
        $connection = new PDO($dsn, $username, $password, $options);
        
        $new_user = array(
            "firstname" => $_POST['firstname'],
            "lastname"  => $_POST['lastname'],
            "email"     => $_POST['email'],
            "age"       => $_POST['age'],
            "location"  => $_POST['location']
        );
		//SERVER SIDE
		$x=0;
		 
		
			if($_POST['firstname']=="")
			{
				echo "First name is not entered <br>";
				$x++;
			}
	        else if(preg_match("/^[a-zA-Z -]+$/", $_POST['firstname'])===0)
			{
				echo "Name not be numeric <br>";
				$x++;
			}
			if(preg_match("/^[a-zA-Z -]+$/",$_POST['lastname'])===0)
			{
				echo "Last name is not entered <br>";
				$x++;
			}
			if($_POST['email']=="")
			{
				echo "Email is not entered <br>";
				$x++;
			}
			 if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
			{//
		    }
			else{
		
				echo "Email is not Valid <br>";
				$x++;
			}
			if($_POST['age']=="")
			{
				echo "Age is not entered <br>";
				$x++;
			}
			if(!is_numeric($_POST['age']))
			{
				echo"Invalid Age,Check it is number <br>";
				$x++;
			}
			if(preg_match("/^[a-zA-Z -]+$/", $_POST['location'])===0)
			{
				echo "Location is not entered <br>";
				$x++;
			}
        
		if($x<1)
		{
        $sql = sprintf(
                "INSERT INTO %s (%s) values (%s)",
                "users",
                implode(", ", array_keys($new_user)),
                ":" . implode(", :", array_keys($new_user))
        );
        
        $statement = $connection->prepare($sql);
        $statement->execute($new_user);
		}
		else
		{
			echo "ENTERED DETAILS ARE INCORRECT";
		}
    } 
	catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }

}
?>

<?php require "templates/header.php"; ?>

<?php if (isset($_POST['submit']) && $statement) { ?>
    <blockquote><?php echo $_POST['firstname']; ?> successfully added.</blockquote>
<?php } ?>

<h2>Add a user</h2>

<script>
//CLIENT SIDE
/*
function validate()
{
	var fname=document.forms["register"]["firstname"].value;
	if(fname=="")
	{
	 	alert("Enter your firstame");
		document.forms["register"]["firstname"].focus();
		return false;
	}
	
	var lname=document.forms["register"]["lastname"].value;
	if(lname=="")
	{
		alert("Enter your lastname");
		document.forms["register"]["lastname"].focus();
		return false;
	}
	
	var eml=document.forms["register"]["email"].value;
	var atposition=eml.indexOf("@");  
	var dotposition=eml.lastIndexOf(".");  
	if(eml=="")
	{
		alert("Enter your email");
		document.forms["register"]["email"].focus();
		return false;
	}
	if (atposition<1 || dotposition<atposition+2 || dotposition+2>=eml.length)
	{
		alert("please check the format of email joe@gmail.com");
		document.forms["register"]["email"].focus();
		return false;
	}
	var age=document.forms["register"]["age"].value;
	if(age=="")
	{
		alert("Enter your age");
		document.forms["register"]["age"].focus();
		return false;
	}
	else if(isNaN(age))
	{
		alert("Make sure AGE should be digital");
		document.forms["register"]["age"].focus();
		return false;
	}
  	var lctn=document.forms["register"]["location"].value;
	if(lctn=="")
	{
		alert("Enter your location");
		document.forms["register"]["location"].focus();
		return false;
	}
return true;
	

}*/
</script>


<form method="post" onsubmit="return validate()" name="register">
    <label for="firstname">First Name</label>
    <input type="text" name="firstname" id="firstname">
    <label for="lastname">Last Name</label>
    <input type="text" name="lastname" id="lastname">
    <label for="email">Email Address</label>
    <input type="text" name="email" id="email">
    <label for="age">Age</label>
    <input type="text" name="age" id="age">
    <label for="location">Location</label>
    <input type="text" name="location" id="location">
    <input type="submit" name="submit" value="Submit">
</form>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>
