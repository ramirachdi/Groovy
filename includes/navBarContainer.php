<div id="navBarContainer">
    <div class="titreNavBar">
        <div class="titre" onclick="openPage('browse.php')">
            <img class="logo" src="assets/icons/logo.svg" >
            <div class="roovy">ROOVY</div>
        </div>
    </div>
    <div class="contenuNavBar">
        <div class="groupMenu">
            <span class="grandText">Menu</span>
            <div class="menuTools">
                <div class="browse" onclick="openPage('browse.php')">
                    <img src="assets/icons/browse.svg" alt="" class="icon">
                    <span class="text">Browse</span>
                </div>
                <div class="search" onclick="openPage('search.php')">
                    <img src="assets/icons/search.svg" alt="" class="icon" >
                    <span class="text">Search</span>
                </div>
                <div class="library" onclick="openPage('yourMusic.php')">
                    <img src="assets/icons/library.svg" alt="" class="icon" >
                    <span class="text">Library</span>
                </div>
            </div>
        </div>
        <div class="groupSettings">
            <div class="settings">
                <span class="grandText">Settings</span>
            </div>
            <div class="settingsTools">
                <div class="username" onclick="openPage('updateDetails.php')">
                    <img src="assets/icons/username.svg" alt="" class="icon">
                    <div class="text"><?=$username?> </div>
                </div>
                <div class="logout" onclick="logout()">
                    <img src="assets/icons/logout.svg" alt="" class="icon">
                    <div class="text">Logout</div>
                </div>
            </div>
        </div>
    </div>
</div>

