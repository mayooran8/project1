<?php
include 'config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$sql = "INSERT INTO entries (name, email, phone) VALUES ('$name','$email','$phone')";
$sql_check = "SELECT * FROM entries WHERE email='$email'";
$result = $conn->query($sql_check);
if($result->num_rows > 0){
die("Email already exists!");
}

if ($conn->query($sql) === TRUE) {
echo "<p>Entry added successfully!</p>";
} else {
echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Form </title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
<h2 class="mb-4">Add Entry</h2>
<form method="POST" action="form.php" onsubmit="return validateForm()">
<div class="mb-3">
<label class="form-label">Name</label>
<input type="text" id="name" name="name" class="form-control" placeholder="Enter Name">
</div>
<div class="mb-3">
<label class="form-label">Email</label>
<input type="email" id="email" name="email"  class="form-control" placeholder="Enter Email">
</div>
<div class="mb-3">
<label class="form-label">Phone</label>
<input type="text" id="phone" name="phone" class="form-control" placeholder="Enter Phone">
</div>
<button type="submit" class="btn btn-success">Submit</button>
<button type="reset" class="btn btn-secondary">Clear Form</button>
</form>
</div>


<script>
function validateForm() {
    let name = document.getElementById("name").value;
    let email = document.getElementById("email").value;
    let phone = document.getElementById("phone").value;

    if (name == "" || email == "" || phone == "") { 
        alert("All fields required!"); 
        return false; 
    }

    if (!email.includes("@")) { 
        alert("Invalid email!"); 
        return false; 
    }

    if (phone.length !== 10 || isNaN(phone)) { 
        alert("Phone must be 10 digits!"); 
        return false; 
    }

    return true; // ✅ End validation correctly
}

// ✅ Live validation for name field
document.getElementById("name").addEventListener("input", function() {
    let name = this.value;
    if (name.length < 3) {
        this.style.borderColor = "red";
    } else {
        this.style.borderColor = "green";
    }
});
</script>



</body>
</html>