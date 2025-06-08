<nav class="sidebar" id="sidebar">
    <div class="hamburger">
        <i class="fas fa-bars"></i>
    </div>
    <div class="nav-items">
        <a href="dashboard.php" class="nav-item">
            <i class="fas fa-home"></i>
            <span>Dashboard</span>
        </a>
        <div class="nav-item dropdown">
            <div class="nav-label">
                <i class="far fa-folder-open " id="inventory_logo"></i>
                <span>Inventory</span>
            </div>
            <i class="fas fa-chevron-down arrow"></i>
            <div class="dropdown-content">
                <a href="uniform.php" class="dropdown-item">
                    <i class="fas fa-shirt"></i>
                    <span>Uniform</span>
                </a>
                <a href="machine.php" class="dropdown-item">
                    <i class="fas fa-industry"></i>
                    <span>Machine</span>
                </a>
                <a href="consumable.php" class="dropdown-item">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Consumable</span>
                </a>
            </div>
        </div>
        <a href="reservation.php" class="nav-item">
            <i class="fas fa-calendar-check"></i>
            <span>Reservation</span>
        </a>
        <a href="supplier.php" class="nav-item active">
            <i class="fas fa-truck-fast"></i>
            <span>Supplier</span>
        </a>
             <a href="archive.php" class="nav-item active">
            <i class="fas fa-truck-fast"></i>
            <span>Archive</span>
        </a>




        <a href="login_page.html" class="nav-item logout" id="logoutBtn">
            <i class="fas fa-right-from-bracket"></i>
            <span>Logout</span>
        </a>
    </div>
</nav>