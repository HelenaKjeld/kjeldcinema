<?php include 'sql/Table.sql'; ?>
<?php include 'components/header.php'; ?>

<h2 class="text-2xl font-bold mb-6"> Manage Movies</h2>

<!-- Add Movie Form -->
<form action="" method="POST" class="bg-white p-6 rounded-lg shadow mb-8">
    <h3 class="text-xl font-semibold mb-4">Add New Movie</h3>
    <input type="text" name="Titel" placeholder="Title" class="border p-2 w-full mb-3" required>
    <textarea name="Description" placeholder="Description" class="border p-2 w-full mb-3" required></textarea>
    <input type="text" name="Poster" placeholder="Poster URL" class="border p-2 w-full mb-3">
    <input type="number" name="ageRating" placeholder="Age Rating" class="border p-2 w-full mb-3" required>
    <input type="number" name="Duration" placeholder="Duration (minutes)" class="border p-2 w-full mb-3" required>
    <button type="submit" name="addMovie" class="bg-amber-500 hover:bg-amber-600 text-white px-6 py-2 rounded">Add Movie</button>
</form>

<?php
if (isset($_POST['addMovie'])) {
    $titel = $_POST['Titel'];
    $desc = $_POST['Description'];
    $poster = $_POST['Poster'];
    $age = $_POST['ageRating'];
    $duration = $_POST['Duration'];

    $sql = "INSERT INTO Movie (Titel, Description, Poster, ageRating, Duration) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssii", $titel, $desc, $poster, $age, $duration);
    if ($stmt->execute()) {
        echo "<p class='text-green-600'> Movie added successfully!</p>";
    } else {
        echo "<p class='text-red-600'> Error: " . $conn->error . "</p>";
    }
}
?>

<!-- Display Existing Movies -->
<h3 class="text-xl font-semibold mb-4 mt-8">All Movies</h3>
<table class="w-full bg-white border-collapse shadow rounded-lg">
    <thead class="bg-gray-200 text-left">
        <tr>
            <th class="p-3">ID</th>
            <th class="p-3">Title</th>
            <th class="p-3">Age</th>
            <th class="p-3">Duration</th>
            <th class="p-3">Poster</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $result = $conn->query("SELECT * FROM Movie");
        while ($row = $result->fetch_assoc()):
        ?>
            <tr class="border-b hover:bg-gray-50">
                <td class="p-3"><?= $row['MovieID'] ?></td>
                <td class="p-3"><?= htmlspecialchars($row['Titel']) ?></td>
                <td class="p-3"><?= $row['ageRating'] ?></td>
                <td class="p-3"><?= $row['Duration'] ?> min</td>
                <td class="p-3"><img src="<?= $row['Poster'] ?>" alt="poster" class="w-12 h-auto rounded"></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php include 'includes/footer.php'; ?>