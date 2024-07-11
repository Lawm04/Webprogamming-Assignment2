<!DOCTYPE html>
<html>
<head>
    <title>Edit Book</title>
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
        <h1 class="text-center mb-4">Edit Book</h1>
        <?php
        include "db.php";

        if ($conn->connect_error) {
            die('Connection failed: ' . $conn->connect_error);
        }

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $sql = "SELECT * FROM books WHERE id = $id";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $title = $row['title'];
                $author = $row['author'];
                $published_year = $row['published_year'];
            } else {
                echo "<div class='alert alert-danger'>No book found with the provided ID</div>";
                exit;
            }
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $title = $_POST['title'];
            $author = $_POST['author'];
            $published_year = $_POST['published_year'];

            $sql = "UPDATE books SET title='$title', author='$author', published_year='$published_year' WHERE id=$id";

            if ($conn->query($sql) === TRUE) {
                echo "<div class='alert alert-success'>Record updated successfully</div>";
            } else {
                echo "Error updating record: " . $conn->error;
            }
        }
        ?>

        <form action="edit.php?id=<?php echo $id; ?>" method="post">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo $title; ?>" required>
            </div>
            <div class="form-group">
                <label for="author">Author:</label>
                <input type="text" class="form-control" id="author" name="author" value="<?php echo $author; ?>" required>
            </div>
            <div class="form-group">
                <label for="published_year">Published Year:</label>
                <input type="number" class="form-control" id="published_year" name="published_year" value="<?php echo $published_year; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Book</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
