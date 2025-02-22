document.addEventListener("DOMContentLoaded", () => {
    console.log("Script loaded!");

    document.querySelector(".submit-btn").addEventListener("click", (event) => {
        event.preventDefault();
        alert("Your message has been sent!");
    });
});
