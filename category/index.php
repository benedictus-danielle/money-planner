<?php
$title = "Category";
require_once "$_SERVER[DOCUMENT_ROOT]/helpers/require.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if ($_POST["action"] === "delete") :
        $id = $_POST["id"];
        $deleteQuery = "DELETE FROM category WHERE id = ?";
        $stmt = $conn->prepare($deleteQuery);
        $stmt->bind_param("i", $id);
        $stmt->execute();
    elseif ($_POST["action"] === "insert") :
        $name = $_POST["name"];
        $insertQuery = "INSERT INTO category VALUES(null, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("s", $name);
        $stmt->execute();
    endif;
    header('location:/category');
    exit;
}
require_once "../layouts/head.php";

$query = "SELECT * FROM category";
$result = $conn->query($query);
?>
<table>
    <thead>
        <th>Name</th>
        <th>Action</th>
    </thead>
    <tbody>
        <?php
        while ($row = $result->fetch_assoc()) {
        ?>
            <tr>
                <td><?= $row["name"] ?></td>
                <td><a href="./category/update.php?id=<?= $row["id"] ?>">Update</a></td>
                <td>
                    <form action="" method="POST">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id" value="<?= $row["id"] ?>">
                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>


<form action="" method="post">
    <input type="hidden" name="action" value="insert">
    <div>
        <label for="">Name: </label><input type="text" name="name" required>
    </div>

    <button type="submit">Insert</button>

</form>