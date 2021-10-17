function NotifyBox(text, color = null) {

    let toast = document.getElementById("toastNotify").cloneNode(true);
    toast.classList.remove("d-none");
    toast.removeAttribute("id");

    if (color) {
        toast.classList.add("text-white", "bg-gradient", "bg-" + color);
    }

    toast.querySelector(".toast-body").innerHTML = text;

    document.querySelector("#toastContainer").appendChild(toast);

    let toastBs = new bootstrap.Toast(toast);
    toastBs.show();
    window.setTimeout(function () {
        document.querySelector("#toastContainer").removeChild(toast);
    }, 10000);
}