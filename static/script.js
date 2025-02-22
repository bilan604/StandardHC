

document.addEventListener("DOMContentLoaded", function() {
    console.log("Script Loaded");

    let navLinks = document.querySelectorAll("nav ul li a");
    navLinks.forEach(link => {
        link.addEventListener("mouseover", function() {
            this.style.color = "#007bff";
        });
        link.addEventListener("mouseout", function() {
            this.style.color = "black";
        });
    });

    let heroText = document.querySelector(".hero-text h2");
    heroText.addEventListener("click", function() {
        alert("Welcome to SHC!");
    });
});

