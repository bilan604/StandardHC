document.addEventListener("DOMContentLoaded", () => {
    console.log("Script loaded!");

    // Add a hover effect to navigation links
    const navLinks = document.querySelectorAll("nav ul li a");

    navLinks.forEach(link => {
        link.addEventListener("mouseover", () => {
            link.style.color = "#007BFF";
        });

        link.addEventListener("mouseout", () => {
            link.style.color = "#000";
        });
    });
});
