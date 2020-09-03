<?php
$title = "Home";

require_once "$_SERVER[DOCUMENT_ROOT]/helpers/connection.php";
require_once "$_SERVER[DOCUMENT_ROOT]/helpers/function.php";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = $_POST["action"];
    $type = $_POST["type"];
    if ($type === "spending") {
        if ($action === "insert") :
            $category_id = $_POST["category"];
            $amount = $_POST["amount"];
            $description = $_POST["description"] !== "" ? $_POST["description"] : "-";
            $insertQuery = "INSERT INTO spending(category_id, amount, description) VALUES(?,?,?)";
            $stmt = $conn->prepare($insertQuery);
            $stmt->bind_param("iis", $category_id, $amount, $description);
            $stmt->execute();
        elseif ($action === "delete") :
            $id = $_POST["id"];
            $deleteQuery = "DELETE FROM spending WHERE id = ?";
            $stmt = $conn->prepare($deleteQuery);
            $stmt->bind_param("i", $id);
            $stmt->execute();
        endif;
    } else if ($type === "income") {
        if ($action === "insert") :
            $source = $_POST["source"];
            $amount = $_POST["amount"];
            $insertQuery = "INSERT INTO income(source, amount) VALUES(?,?)";
            $stmt = $conn->prepare($insertQuery);
            $stmt->bind_param("si", $source, $amount);
            $stmt->execute();
        elseif ($action === "delete") :
            $id = $_POST["id"];
            $deleteQuery = "DELETE FROM income WHERE id = ?";
            $stmt = $conn->prepare($deleteQuery);
            $stmt->bind_param("i", $id);
            $stmt->execute();
        endif;
    }
    header('location:/');
    exit;
}
require_once './layouts/head.php';

$query = '
    SELECT 
        spending.id,
        category.name as category_name,
        description,
        amount,
        spending.created_at
    FROM 
        spending
        JOIN category ON category_id = category.id
    ' . (isset($_GET["date"]) === true ? (' WHERE CONVERT(spending.created_at, DATE) = \'' . $_GET["date"] . '\' ') : " ") . '
    ORDER BY
        spending.created_at DESC';

$result = $conn->query($query);
$categories = $conn->query("SELECT * FROM category");
$grand_total = $conn->query("SELECT SUM(amount) as total FROM spending")->fetch_assoc()["total"];
$income_total = $conn->query("SELECT SUM(amount) as total FROM income")->fetch_assoc()["total"];
$dates = $conn->query("SELECT DISTINCT CONVERT(created_at, DATE) as insert_date FROM spending");
?>
<div class="current-money <?= ($income_total - $grand_total) >= 1000000 ? "safe" : "danger" ?>">
    <h2>Current Money: IDR <?= formattingNumber($income_total - $grand_total) ?></h2>
</div>
<div class="parent-container">
    <div class="spending">
        <div>
            <div class="filter">
                <label for="">Filter:</label>
                <form action="" method="get">
                    <select name="date" id="">
                        <?php
                        while ($row = $dates->fetch_assoc()) {
                            ?>
                            <option value="<?= $row["insert_date"] ?>" <?= isset($_GET["date"]) && $_GET["date"] === $row["insert_date"] ? "selected" : "" ?>><?= $row["insert_date"] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                    <button type="submit">Filter</button>
                </form>
                <button onclick="window.location.href = '/'">Clear filter</button>
            </div>
            <div class="table-container">
                <table cellspacing=0>
                    <thead>
                    <th>Kategori</th>
                    <th>Deskripsi</th>
                    <th>Jumlah</th>
                    <th>Tanggal</th>
                    <th>Action</th>
                    </thead>
                    <tbody>
                    <?php
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?= $row["category_name"] ?> </td>
                            <td><?= $row["description"] ?></td>
                            <td>IDR <?= formattingNumber($row["amount"]) ?> </td>
                            <td><?= $row["created_at"] ?> </td>
                            <td>
                                <form action="" method="POST">
                                    <input type="hidden" name="type" value="spending">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?= $row["id"] ?>">
                                    <button class="delete-button" type="submit">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="spending-category">
            <?php
            $spending_by_category = "
                    SELECT
                        category.name as category_name,
                        sum(amount) as total
                    FROM
                        spending
                        JOIN category ON category_id = category.id
                    " . (isset($_GET["date"]) === true ? (' WHERE CONVERT(spending.created_at, DATE) = \'' . $_GET["date"] . '\' ') : " ") . "
                    GROUP BY
                        category.name
                    ORDER BY
                        total DESC
                ";
            $grouped = $conn->query($spending_by_category);
            while ($row = $grouped->fetch_assoc()) {
                ?>
                <div>
                    <label for="">
                        <?= $row["category_name"] ?>
                    </label>
                    <label for="">
                        :
                    </label>
                    <label for="">
                        IDR <?= formattingNumber($row["total"]) ?>
                    </label>
                </div>
                <?php
            }
            ?>
            <br>
            <div>
                <label for="">Grand total</label>
                <label for="">:</label>
                <label for="">IDR <?= formattingNumber($grand_total) ?></label>
            </div>
        </div>

        <div class="spending-form">
            <center><h3>Pengeluaran</h3></center>
            <br>
            <form autocomplete="off" action="" method="POST">
                <input type="hidden" name="action" value="insert">
                <input type="hidden" name="type" value="spending">
                <div>
                    <label for="">Kategori:</label>
                    <select name="category" id="">
                        <?php
                        while ($row = $categories->fetch_assoc()) {
                            ?>
                            <option value="<?= $row["id"] ?>"><?= $row["name"] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="">Deskripsi:</label>
                    <input type="text" name="description">
                </div>
                <div>
                    <label for="">Total:</label>
                    <input type="number" name="amount" id="" required>
                </div>
                <button class="insert-button" type="submit">Insert</button>
            </form>
        </div>
    </div>
    <div class="income">
        <div>
            <div class="table-container">
                <table cellspacing=0 cellpadding=6>
                    <thead>
                    <th>Sumber</th>
                    <th>Jumlah</th>
                    <th>Tanggal</th>
                    <th>Action</th>
                    </thead>
                    <tbody>
                    <?php
                    $income = $conn->query("SELECT * FROM income ORDER BY created_at DESC");

                    while ($row = $income->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?= $row["source"] ?></td>
                            <td>IDR <?= formattingNumber($row["amount"]) ?></td>
                            <td><?= $row["created_at"] ?></td>
                            <td>
                                <form action="" method="POST">
                                    <input type="hidden" name="type" value="income">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?= $row["id"] ?>">
                                    <button class="delete-button" type="submit">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <?php
                    }

                    ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="income-form">
            <center><h3>Pemasukan</h3></center>
            <br>
            <form autocomplete="off" action="" method="post">
                <input type="hidden" name="type" value="income">
                <input type="hidden" name="action" value="insert">
                <div>
                    <label for="">Sumber:</label>
                    <input type="text" name="source" required>
                </div>
                <div>
                    <label for="">Total:</label>
                    <input type="text" name="amount" required>
                </div>
                <button class="insert-button" type="submit">Insert</button>
            </form>
        </div>
    </div>
</div>