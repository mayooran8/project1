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
<form method="POST" action="">
    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" value="<?php echo $row['name']; ?>" class="form-control">
    </div>

    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" value="<?php echo $row['email']; ?>" class="form-control">
    </div>

    <div class="mb-3">
        <label>Phone</label>
        <input type="text" name="phone" value="<?php echo $row['phone']; ?>" class="form-control">
    </div>

    <button type="submit" name="update" class="btn btn-success">Update</button>
</form>
<?php else: ?>
    <p>No record found or invalid ID.</p>
<?php endif; ?>
</body>
</html>
