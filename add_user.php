<?php include 'components/header.php'; ?>

<a href="login_page.php">
    <button class="border border-amber-400 text-amber-400 m-6 px-8 py-3 rounded-full font-bold hover:bg-amber-400 hover:text-black transition">
        Back
    </button>
</a>

<div class="p-6 max-w-xl mx-auto">
    <h2 class="text-3xl font-bold mb-8 text-center text-white">Add New User</h2>

    <form method="POST" action="signup_page.php" class="bg-slate-800 p-6 rounded-xl shadow-lg space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="firstName" class="block text-sm font-medium text-gray-300 mb-1">First Name</label>
                <input id="firstName" name="firstName" type="text" required
                       class="border border-slate-600 bg-slate-700 text-white rounded-lg w-full p-2.5 focus:ring-amber-500 focus:border-amber-500 transition">
            </div>
            <div>
                <label for="lastName" class="block text-sm font-medium text-gray-300 mb-1">Last Name</label>
                <input id="lastName" name="lastName" type="text" required
                       class="border border-slate-600 bg-slate-700 text-white rounded-lg w-full p-2.5 focus:ring-amber-500 focus:border-amber-500 transition">
            </div>
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-300 mb-1">E-Mail</label>
            <input id="email" name="email" type="email" required
                   class="border border-slate-600 bg-slate-700 text-white rounded-lg w-full p-2.5 focus:ring-amber-500 focus:border-amber-500 transition">
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-300 mb-1">Password</label>
            <input id="password" name="password" type="password" required
                   class="border border-slate-600 bg-slate-700 text-white rounded-lg w-full p-2.5 focus:ring-amber-500 focus:border-amber-500 transition">
        </div>

        <div class="pt-4 text-center">
            <button type="submit" name="submit"
                    class="ticket-button bg-amber-500 hover:bg-amber-600 text-white px-6 py-2.5 rounded-full font-semibold transition">
                Add User
            </button>
        </div>
    </form>
</div>

<?php include 'components/footer.php'; ?>
