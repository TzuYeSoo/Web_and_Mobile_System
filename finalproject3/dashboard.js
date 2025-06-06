document.addEventListener('DOMContentLoaded', function() {
    const hamburger = document.querySelector('.hamburger');
    const sidebar = document.getElementById('sidebar');
    const dropdown = document.querySelector('.dropdown');
    

    // Toggle sidebar on hamburger click
    hamburger.addEventListener('click', function() {
        sidebar.classList.toggle('collapsed');
    });

    // Toggle dropdown on click
    dropdown.addEventListener('click', function(e) {
        e.stopPropagation(); // Prevent event from bubbling up
        dropdown.classList.toggle('active');
    });
    
    // Optional: Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(event) {
        if (window.innerWidth <= 768 && 
            !sidebar.contains(event.target) && 
            !hamburger.contains(event.target) && 
            sidebar.classList.contains('active')) {
            sidebar.classList.remove('active');
        }
    });

    // Handle window resize (optional - adjust if sidebar behavior changes on resize)
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            sidebar.classList.remove('active'); // Or handle differently based on design
             sidebar.classList.remove('collapsed'); // Ensure it's not collapsed on wider screens if design requires
        }
    });
}); 