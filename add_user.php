<h3>add new user</h3>

        <form  name="contact" method="post" action="addEntry.php">
            <div >
                <div>
                    <input id="firstName" name="firstName" type="text"  required="" aria-required="true">
                    <label for="firstName">First Name</label>
                </div>
                <div >
                    <input id="lastName" name="lastName" type="text"  required="" aria-required="true">
                    <label for="lastName">Last Name</label>
                </div>
            </div>
            <div>
                <div>
                    <input id="email" name="email" type="email"  required="" aria-required="true">
                    <label for="email">E-Mail</label>
                </div>
            </div>
            <div>
                <div>
                    <input id="password" name="password" type="password"  required="" aria-required="true">
                    <label for="password">Password</label>
                </div>
            </div>
            <button  type="submit" name="submit">Add
            </button>
        </form>
    </div>