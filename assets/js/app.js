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

    const setupTarget = toggler => {
        const dataTargetId = toggler.getAttribute("data-target");
        const dataTarget = document.getElementById(dataTargetId);
        const dataCloseId = toggler.getAttribute("data-close");
        const dataClose = document.getElementById(dataCloseId);

        toggler.addEventListener("click", event => {
            event.preventDefault();
            dataTarget.classList.toggle("noshow");
            dataClose.classList.add("noshow");
        });
    };

    const commentReplyTogglers =
        Array.from(document.querySelectorAll(".comment-edit-reply-toggler"));

    commentReplyTogglers.forEach(setupTarget);

    // const commentEditTogglers = Array.from(document.querySelectorAll(".comment-edit-toggler"));

    // commentEditTogglers.forEach(setupTarget);

    const commentCancelTogglers = Array.from(document.querySelectorAll(".comment-cancel"));

    commentCancelTogglers.forEach(cancel => {
        const dataCloseId = cancel.getAttribute("data-close");
        const dataClose = document.getElementById(dataCloseId);

        cancel.addEventListener("click", event => {
            event.preventDefault();
            dataClose.classList.add("noshow");
        });
    });
})();
