import './bootstrap';
import '~resources/scss/app.scss';
import * as bootstrap from 'bootstrap';
import.meta.glob([
    '../img/**'
])
// Modal to confirm deletion of on element

// Step 1.
// Remove default behaviour from Delete button we created with CRUD destroy
// Select all Delete buttons
const allDeleteBtns = document.querySelectorAll(".js-delete-btn");
// Remove default behaviours
allDeleteBtns.forEach((deleteBtn) => {
    deleteBtn.addEventListener("click", function (event) {
        event.preventDefault();
        console.log("you clicked me!");
        // Step 2a.
        // Populate the modal with his correspondig element's body
        // Select the modal
        const deleteModal = document.getElementById("confirmModal");
        // Populate del modal's body by fetching the current element's title via dataset
        const projectName = this.dataset.projectName;
        deleteModal.querySelector(".modal-title").innerHTML = `${projectName}`;
        console.log(projectName);
        // Step 2b.
        // On click on 'Delete', we open the modal
        const bootstrapsDeleteModal = new bootstrap.Modal(deleteModal);
        bootstrapsDeleteModal.show();
        // Step 3.
        // Send the original form (CRUD destroy button)
        // Select the 'Delete' button in the modal
        const modalDeleteBtn = document.getElementById("modalDeleteBtn");
        modalDeleteBtn.addEventListener("click", function () {
            // Send the original form
            deleteBtn.parentElement.submit();
            console.log("bye bye title!");
        });
    });
});
