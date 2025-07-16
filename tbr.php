<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Manage your reading journey with Novel Nook's TBR list. Track books to be read, books already read, and books you wish to order.">
  <title>TBR List - Novel Nook</title>
  <link rel="stylesheet" href="tbr.css">
</head>
<body>

<div class="dropdown">
    <button class="dropdown-btn">&#9776;</button>
    <div class="dropdown-content">
        <a href="login.html">Login</a>
        <a href="register.html">Sign In</a>
        <a href="home.html">Home Page</a>
        <a href="logout.php">Log Out</a>
        <a href="about.html">About Us</a>
    </div>
</div>

<header>
  <h1><center>Your TBR List</center></h1>
</header>

<div class="container">
  <div class="tbr-grid">

    <?php
    $isLoggedIn = isset($_SESSION['username']);
    $alertAttr = $isLoggedIn ? "" : "onclick=\"alert('Please login to add books to your list.')\" type='button'";
    ?>

    <!-- To Be Read -->
    <div class="column">
        <h2>To Be Read</h2>
        <form id="tbrForm">
            <input type="text" id="tbrInput" placeholder="Enter book title" />
            <input <?= $alertAttr ?> type="submit" value="Add to TBR List" />
        </form>
        <table id="tbrTable"><thead><tr><th>Book Title</th></tr></thead><tbody></tbody></table>
    </div>

    <!-- Read -->
    <div class="column">
        <h2>Read</h2>
        <form id="readForm">
            <input type="text" id="readInput" placeholder="Enter book title" />
            <input <?= $alertAttr ?> type="submit" value="Add to Read List" />
        </form>
        <table id="readTable"><thead><tr><th>Book Title</th></tr></thead><tbody></tbody></table>
    </div>

    <!-- To Be Ordered -->
    <div class="column">
        <h2>To Be Ordered</h2>
        <form id="toOrderForm">
            <input type="text" id="toOrderInput" placeholder="Enter book title" />
            <input <?= $alertAttr ?> type="submit" value="Add to Order List" />
        </form>
        <table id="toOrderTable"><thead><tr><th>Book Title</th></tr></thead><tbody></tbody></table>
    </div>

    <!-- Ordered -->
    <div class="column">
        <h2>Ordered</h2>
        <form id="orderedForm">
            <input type="text" id="orderedInput" placeholder="Enter book title" />
            <input <?= $alertAttr ?> type="submit" value="Add to Ordered List" />
        </form>
        <table id="orderedTable"><thead><tr><th>Book Title</th></tr></thead><tbody></tbody></table>
    </div>

  </div>
</div>

<script>
function handleFormSubmission(formId, inputId, tableId, category) {
    document.getElementById(formId).addEventListener('submit', function(e) {
        e.preventDefault();
        const inputValue = document.getElementById(inputId).value;
        if (inputValue.trim() !== "") {
            <?php if ($isLoggedIn): ?>
            fetch('save_tbr.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `book_title=${encodeURIComponent(inputValue)}&category=${category}`
            })
            .then(response => response.text())
            .then(data => {
                if (data === "Success") {
                    addRowToTable(tableId, inputValue);
                } else {
                    alert(data);
                }
            });
            <?php else: ?>
            alert("Please login to add books to your list.");
            <?php endif; ?>
        }
        document.getElementById(inputId).value = "";
    });
}

function addRowToTable(tableId, title) {
    const table = document.getElementById(tableId).getElementsByTagName('tbody')[0];
    const newRow = table.insertRow();
    const newCell = newRow.insertCell(0);
    newCell.textContent = title;
}

handleFormSubmission('tbrForm', 'tbrInput', 'tbrTable', 'tbr');
handleFormSubmission('readForm', 'readInput', 'readTable', 'read');
handleFormSubmission('toOrderForm', 'toOrderInput', 'toOrderTable', 'to_order');
handleFormSubmission('orderedForm', 'orderedInput', 'orderedTable', 'ordered');
</script>

<?php if ($isLoggedIn):
include 'dbconn.php';
$username = $_SESSION['username'];
$categories = ['tbr', 'read', 'to_order', 'ordered'];
$data = [];

foreach ($categories as $cat) {
    $stmt = $conn->prepare("SELECT book_title FROM tbr_list WHERE username = ? AND category = ?");
    $stmt->bind_param("ss", $username, $cat);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $data[$cat][] = $row['book_title'];
    }
    $stmt->close();
}
$conn->close();
?>
<script>
const preloadedBooks = <?php echo json_encode($data); ?>;
function loadPreloadedBooks() {
    for (const category in preloadedBooks) {
        const tableId = {
            tbr: 'tbrTable',
            read: 'readTable',
            to_order: 'toOrderTable',
            ordered: 'orderedTable'
        }[category];

        preloadedBooks[category].forEach(title => {
            addRowToTable(tableId, title);
        });
    }
}
loadPreloadedBooks();
</script>
<?php endif; ?>

</body>
</html>
