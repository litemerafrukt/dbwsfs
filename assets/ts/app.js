// import {sayHello} from "./helloworld"

(() => {
    const deleteLinks = Array.from(document.querySelectorAll(".delete"));

    deleteLinks.forEach(element => {
        element.addEventListener("click", event => {
            event.preventDefault();
            if (confirm(event.target.getAttribute("data-confirm"))) {
                window.location.href = event.target.getAttribute("href");
            }
        });
    });

    const commentReplyTogglers =
        Array.from(document.getElementsByClassName("comment-next-sibling-toggler"));

    commentReplyTogglers.forEach(element => {
        element.addEventListener("click", event => {
            event.preventDefault();
            event.target.nextElementSibling.classList.toggle('noshow');
        });
    });
})();
