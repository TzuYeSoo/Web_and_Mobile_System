<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet" href="dashboard_query.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   
</head>
<body>
  <div class="container">
        <nav class="sidebar" id="sidebar">
            <div class="hamburger">
                <i class="fas fa-bars"></i>
            </div>
            <div class="nav-items">
                <a href="dashboard.php" class="nav-item">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
                       <a href="uniform.php" class="nav-item">
                            <i class="fas fa-shirt"></i>
                            <span>Uniform</span>
                        </a>
                        <a href="machine.php" class="nav-item">
                            <i class="fas fa-industry"></i>
                            <span>Machine</span>
                        </a>
                       
                        <a href="consumable.php" class="nav-item">
                            <i class="fas fa-shopping-cart"></i>
                            <span>Consumable</span>
                        </a>


                <a href="reservation.php" class="nav-item">
                    <i class="fas fa-calendar-check"></i>
                    <span>Reservation</span>
                </a>
                <a href="supplier.php" class="nav-item active">
                    <i class="fas fa-truck-fast"></i>
                    <span>Supplier</span>
                </a>
                <a href="#" class="nav-item logout">
                    <i class="fas fa-right-from-bracket"></i>
                    <span>Logout</span>
                </a>
            </div>
        </nav>

    


        <main class="main-content">
            <header>
                <div class="logo-section">
                    <img src="stilogo.png" alt="STI Logo" class="logo">
                    <h1>Dashboard</h1>
                </div>
                <div class="user-account" onclick="openModal()">
                    <img src="<?php echo isset($_SESSION['profile_image']) && !empty($_SESSION['profile_image']) ? $_SESSION['profile_image'] : 'alden.png'; ?>" alt="User" class="avatar" id="header-avatar">
                    <span id="admin-name"><?php echo htmlspecialchars($_SESSION['firt_name'] . ' ' . $_SESSION['last_name']); ?></span>
                </div>
            </header>

            <div class="dashboard-stats">
                <a href="uniform.php" class="stat-card uniform">
                    <i class="fas fa-shirt"></i>
                    <div class="stat-number" id="uniform-count">...</div>
                    <div class="stat-label">Total Uniforms</div>
                </a>
                <a href="machine.php" class="stat-card machine">
                    <i class="fas fa-industry"></i>
                    <div class="stat-number" id="machine-count">...</div>
                    <div class="stat-label">Total Machines</div>
                </a>
                <a href="reservation.php" class="stat-card reservation">
                    <i class="fas fa-calendar-check"></i>
                    <div class="stat-number" id="reservation-count">...</div>
                    <div class="stat-label">Total Reservations</div>
                </a>
            </div>
            
        </main>
    </div>

    <div id="adminModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Edit User Information</h2>
                <button class="close-btn" onclick="closeModal()">&times;</button>
            </div>
            <div class="modal-body">
                <form id="adminForm" action="query_edit_user.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="firstName">First Name</label>
                        <input type="text" id="firstName" name="fname" required>
                    </div>
                    <div class="form-group">
                        <label for="lastName">Last Name</label>
                        <input type="text" id="lastName" name="lname" required>
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">New Password</label>
                        <input type="password" id="password" name="password" placeholder="Leave blank to keep current password">
                    </div>
                    <input type="hidden" id="userId" name="user_id">
                    <button type="submit" class="update-btn">Update Information</button>
                    <div id="successMessage" class="success-message">Information updated successfully!</div>
                    <div id="errorMessage" class="error-message"></div>
                </form>
            </div>
        </div>
    </div>

    <script src="dashboard.js"></script>
    
    <script> 
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.stat-card');
        cards.forEach(card => card.classList.add('loading'));

        fetch('get_counts.php')
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    console.error('Error:', data.message);
                    return;
                }

                updateCount('uniform-count', data.uniform_count);
                updateCount('machine-count', data.machine_count);
                updateCount('reservation-count', data.reservation_count);

                cards.forEach(card => card.classList.remove('loading'));
            })
            .catch(error => {
                console.error('Error fetching counts:', error);
                document.querySelectorAll('.stat-number').forEach(el => {
                    el.textContent = 'Error';
                });
                cards.forEach(card => card.classList.remove('loading'));
            });
    });

    function updateCount(elementId, value) {
        const element = document.getElementById(elementId);
        element.textContent = value;
        element.classList.add('count-animation');
    }

        function openModal(){
             document.getElementById('adminModal').style.display = 'block';
        fetch('get_user_info.php')
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    document.getElementById('errorMessage').textContent = data.message;
                    document.getElementById('errorMessage').style.display = 'block';
                    return;
                }
                document.getElementById('firstName').value = data.firt_name;
                document.getElementById('lastName').value = data.last_name;
                document.getElementById('username').value = data.username;
                document.getElementById('position').value = data.position;
                document.getElementById('userId').value = data.user_id;
                document.getElementById('password').value = '';
            
                removeImagePreview();
            })
            .catch(error => {
            });
        }

        function closeModal(){
            const modal = document.getElementById('adminModal');
            const backdrop = document.getElementById('backdrop');

            modal.style.display = 'none';
            backdrop.style.display = 'none';
        }
    </script>
</body>
</html>