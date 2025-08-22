<?php
include 'config.php';

// Handle search
$search = isset($_GET['search']) ? $_GET['search'] : '';
$search = $conn->real_escape_string($search); // prevent SQL injection

$sql = "SELECT * FROM entries 
        WHERE name LIKE '%$search%' OR email LIKE '%$search%' 
        ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>View Entries - Your Project Title</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>All Entries</h2>

    <!-- Search Form -->
    <form method="GET" class="mb-3">
        <input type="text" name="search" class="form-control" 
               placeholder="Search by Name or Email" 
               value="<?php echo htmlspecialchars($search); ?>">
    </form>

    <!-- Table -->
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                 <th onclick="sortTable(1)">Name</th>
                 <th onclick="sortTable(2)">Email</th>
                <th>Phone</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
           
        </thead>
        <tbody>
        <?php
        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
             echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['phone']}</td>
                        <td>{$row['created_at']}</td>
                        <td>
                            <a href='update.php?id={$row['id']}' class='btn btn-warning btn-sm'>Update</a>
                            <a href='delete.php?id={$row['id']}' class='btn btn-danger btn-sm' onclick=\"return confirm('Are you sure?');\">Delete</a>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='6' class='text-center'>No entries found</td></tr>";
        }
        ?>
        </tbody>
    </table>
</div>
<script>
function sortTable(n) {
let table, rows, switching, i, x, y, shouldSwitch;
table = document.getElementById("entriesTable");
switching = true;
while (switching) {
switching = false;
rows = table.rows;
for (i = 1; i < (rows.length - 1); i++) {
shouldSwitch = false;
x = rows[i].getElementsByTagName("TD")[n];
y = rows[i + 1].getElementsByTagName("TD")[n];
if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
shouldSwitch = true;
break;
}
}
if (shouldSwitch) {
rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
switching = true;
}
}
}
</script>
</body>
</html>
