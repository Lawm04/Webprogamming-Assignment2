<!DOCTYPE html>
<html>
<head>
    <title>Book List</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Roboto', sans-serif;
        }
        h1 {
            font-family: 'Pacifico', cursive;
            color: #ff6f61;
        }
        .btn-primary {
            background-color: #ff6f61;
            border-color: #ff6f61;
        }
        .btn-primary:hover {
            background-color: #ff4d4d;
            border-color: #ff4d4d;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Book List</h1>

        <!-- Search Form -->
        <form class="form-inline mb-3" method="GET" action="">
            <input class="form-control mr-sm-2" type="search" placeholder="Search by title or author" aria-label="Search" name="query" style="width: 300px;">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>

        <a href="?action=add" class="btn btn-primary mb-3">Add New Book</a>

        <?php
        include "db.php";

        // Handle add, edit, and delete actions
        $action = isset($_GET['action']) ? $_GET['action'] : '';

        if ($action == 'add') {
            // Include the add form
            include "add.php";
        } elseif ($action == 'edit' && isset($_GET['id'])) {
            // Include the edit form
            include "edit.php";
        } elseif ($action == 'delete' && isset($_GET['id'])) {
            // Include the delete logic
            include "delete.php";
        } 

        // Display the list of books
        $query = isset($_GET['query']) ? $_GET['query'] : '';
        $sql = "SELECT id, title, author, published_year FROM books";
        if ($query) {
            $sql .= " WHERE title LIKE ? OR author LIKE ?";
        }
        $stmt = $conn->prepare($sql);
        if ($query) {
            $searchTerm = "%$query%";
            $stmt->bind_param('ss', $searchTerm, $searchTerm);
        }
        $stmt->execute();
        $result = $stmt->get_result();

        echo '<div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Published Year</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>';
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>{$row['id']}</td>
                    <td>" . htmlspecialchars($row['title']) . "</td>
                    <td>" . htmlspecialchars($row['author']) . "</td>
                    <td>" . htmlspecialchars($row['published_year']) . "</td>
                    <td>
                        <a href='?action=edit&id={$row['id']}' class='btn btn-warning btn-sm'>Edit</a>
                        <a href='?action=delete&id={$row['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this book?\")'>Delete</a>
                    </td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No books found</td></tr>";
        }
        echo '</tbody>
            </table>
        </div>';

        $stmt->close();
        $conn->close();
        ?>

    </div>

</body>
</html>
