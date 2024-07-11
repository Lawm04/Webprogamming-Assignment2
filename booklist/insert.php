<?php
include 'db.php';

$title = $_POST['title'];
$author = $_POST['author'];
$published_year = $_POST['published_year'];
$image_path = '';

if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $extensions_arr = array("jpg", "jpeg", "png", "gif");

    if (in_array($imageFileType, $extensions_arr)) {
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $image_path = $target_file;
        } else {
            echo "Sorry, there was an error uploading your file.";
            exit();
        }
    } else {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        exit();
    }
}

$sql = "INSERT INTO books (title, author, published_year) VALUES ('$title', '$author', '$published_year')";


if ($conn->query($sql) === TRUE) {
    echo "New book added successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

header('Location: index.php');
?>
