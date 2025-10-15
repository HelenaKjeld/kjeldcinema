<?php
include 'components/header.php';
?>
<a href="movies_management_page.php"><button class="border border-amber-400 text-amber-400 m-6 px-8 py-3 rounded-full font-bold hover:bg-amber-400 hover:text-black transition">
        Back
    </button></a>
<div class="p-6">
    <h2 class="text-2xl font-bold mb-6"> Manage Movies</h2>
    <form action="movies_create.php" method="POST" class="bg-white p-6 rounded-lg shadow mb-8" enctype="multipart/form-data">
        <h3 class="text-xl font-semibold mb-4 text-slate-800">Add New Movie</h3>
        <input type="text" name="Titel" placeholder="Title" class="border p-2 w-full mb-3" required>
        <textarea name="Description" placeholder="Description" class="border p-2 w-full mb-3" required></textarea>
        <input type="file" name="Poster" placeholder="Poster image" class=" p-1 w-full mb-3">
        <input type="number" name="ageRating" placeholder="Age Rating" class="border p-2 w-full mb-3" required>
        <input type="number" name="Duration" placeholder="Duration (minutes)" class="border p-2 w-full mb-3" required>
        <button type="submit" name="addMovie" class="bg-amber-500 hover:bg-amber-600 text-white px-6 py-2 rounded">Add Movie</button>
    </form>
</div>