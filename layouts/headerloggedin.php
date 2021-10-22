<style>
    nav{
        opacity: 0.7;
        margin-bottom: 60px;
    }
    .navbar-right{
        position: absolute;
        right: 10px;
    }
</style>
<!--Navigation bar-->
<nav class="navbar navbar-expand-md navbar-dark bg-dark navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <a href="#" class="navbar-brand">Online Notes</a>
            <button class="navbar-toggler navbar-right" type="button" data-target="#navbarContents" data-toggle="collapse">
                <span class="sr-only">navbar toggle icon</span>
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
        <div class="navbar-collapse collapse" id="navbarContents">
            <ul class="nav navbar-nav">
                <li class="nav-item"><a href="profile.php" class="nav-link">Profile</a></li>
                <li class="nav-item"><a href="#" class="nav-link">Help</a></li>
                <li class="nav-item"><a href="#" class="nav-link">Contact us</a></li>
                <li class="nav-item active"><a href="mainpageloggedin.php" class="nav-link">My Notes</a></li>
            </ul>
            <ul class="nav navbar-nav ml-auto">
                <li class="nav-item"><a href="#" class="nav-link">Logged in as <strong><?php echo $_SESSION["username"]; ?></strong></a></li>
                <li class="nav-item"><a href="index.php?logout=1" class="btn btn-info">Log out</a></li>
            </ul>
        </div>
    </div>
</nav>