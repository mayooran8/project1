<?php
include 'config.php';

$row = ['id' => '', 'name' => '', 'email' => '', 'phone' => '']; // default empty

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM entries WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    }
}

if (isset($_POST['update'])) {
    $id    = $_POST['id'];
    $name  = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $stmt = $conn->prepare("UPDATE entries SET name=?, email=?, phone=? WHERE id=?");
    $stmt->bind_param("sssi", $name, $email, $phone, $id);

    if ($stmt->execute()) {
        header("Location: view.php");
        exit;
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<html>
    <head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>View Entries - Your Project Title</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
rel="stylesheet">
</head>
<body>
<?php if (!empty($row['id'])): ?>
<form method="POST" action="" onsubmit="return validateForm()">

    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

    <div class="mb-3">
        <label>Name</label>
        <input type="text" id="name" name="name" class="form-control" oninput="this.value =
this.value.toUpperCase()">
      <!--  <input type="text" name="name" value="<?php echo $row['name']; ?>" class="form-control">
--></div>

    <div class="mb-3">
    <label>Email</label>
    <input type="email" id="email" name="email" value="<?php echo $row['email']; ?>" class="form-control">
</div>

<div class="mb-3">
    <label>Phone</label>
    <input type="text" id="phone" name="phone" value="<?php echo $row['phone']; ?>" class="form-control">
</div>

        
</div>

    <button type="submit" name="update" class="btn btn-success">Update</button>
</form>
<?php else: ?>
    <p>No record found or invalid ID.</p>
<?php endif; ?>

<script>
document.getElementById("name").addEventListener("input", function() {
let name = this.value;
if(name.length < 3){
this.style.borderColor = "red";
} else {
this.style.borderColor = "green";
}
});

function validateForm() {
let name = document.getElementById("name").value;
let email = document.getElementById("email").value;
let phone = document.getElementById("phone").value;
if (name=="" || email=="" || phone=="") { alert("All fields required!"); return false; }
if (!email.includes("@")) { alert("Invalid email!"); return false; }

if (phone.length !== 10 || isNaN(phone)) { alert("Phone must be 10 digits!"); return false; }
return true;
}

</script>
</body>
</html>

