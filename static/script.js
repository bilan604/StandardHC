

document.addEventListener("DOMContentLoaded", function() {
    console.log("Script Loaded");

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
