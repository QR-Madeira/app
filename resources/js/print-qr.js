const print = new URL(window.location.href).searchParams.get("print");

window.addEventListener("DOMContentLoaded", () => {
    if (print == "true") {
        window.print();
    }

    print = document.getElementById("share")?.addEventListener("click", () => {
        window.print();
    });
});
