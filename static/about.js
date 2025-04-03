// ----------------------------

// ----------------------------

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




document.addEventListener('DOMContentLoaded', function () {
    const twitterBtn = document.querySelector('.footer-twitter-btn');
    const linkedinBtn = document.querySelector('.footer-linkedin-btn');

    if (twitterBtn) {
        twitterBtn.addEventListener('click', function () {
            window.open('https://x.com/STANDARD_H_C', '_blank');
        });
    }

    if (linkedinBtn) {
        linkedinBtn.addEventListener('click', function () {
            window.open('https://www.linkedin.com/company/standard-huamn-capital', '_blank');
        });
    }
});