<style>
    nav{
        opacity: 0.7;
        margin-bottom: 160px;
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
                <li class="nav-item active"><a href="index.php" class="nav-link">Home</a></li>
                <li class="nav-item"><a href="#" class="nav-link">Help</a></li>
                <li class="nav-item"><a href="#" class="nav-link">Contact us</a></li>
            </ul>
            <form class="form-inline ml-auto">
                <button type="button" class="btn btn-info" data-target="#loginModal" data-toggle="modal">Login</button>
            </form>
        </div>
    </div>
</nav>