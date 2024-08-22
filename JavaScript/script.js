document.addEventListener('DOMContentLoaded', (event) => {
    const accountIcon = document.getElementById('accountIcon');
    const dropdown = document.querySelector('.user .dropdown');

    accountIcon.addEventListener('click', () => {
        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
    });

    //close the dropdown if clicked outside
    window.addEventListener('click', (e) => {
        if (!accountIcon.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.style.display = 'none';
        }
    });
});

