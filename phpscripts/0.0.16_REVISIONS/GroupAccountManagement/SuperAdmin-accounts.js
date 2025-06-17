console.log("JS is loaded!");

// Event delegation
document.addEventListener('click', function (e) {
    const editBtn = e.target.closest('.edit-btn');
    if (editBtn) {
        const row = editBtn.closest('tr');
        if (row) {
            const userId = row.getAttribute('data-id');
            handleEdit(userId, row);
        }
    }

    const deleteBtn = e.target.closest('.delete-btn');
    if (deleteBtn) {
        const row = deleteBtn.closest('tr');
        if (row) {
            const userId = row.getAttribute('data-id');
            handleDelete(userId, row);
        }
    }
});

function handleEdit(userId, row) {
    // Get current data
    const currentFirstname = row.children[1].textContent.trim();
    const currentLastname = row.children[2].textContent.trim();
    const currentUsername = row.children[3].textContent.trim();
    const currentPassword = row.children[4].textContent.trim();
    const currentRole = row.children[5].textContent.trim();

    // Populate form fields
    const formContainer = document.getElementById("edit-form-container");
    const form = document.getElementById("edit-user-form");
    form.elements['id'].value = userId;
    form.elements['firstname'].value = currentFirstname;
    form.elements['lastname'].value = currentLastname;
    form.elements['username'].value = currentUsername;
    form.elements['password'].value = currentPassword;
    form.elements['role'].value = currentRole;

    // Show form, hide table
    document.getElementById("table-container").style.display = "none";
    formContainer.style.display = "block";

    // Clear old error messages
    form.querySelectorAll(".error-msg").forEach(el => el.remove());
}

document.getElementById("edit-user-form").addEventListener("submit", function (e) {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);
    const formContainer = document.getElementById("edit-form-container");

    // Clear old error messages
    form.querySelectorAll(".error-msg").forEach(el => el.remove());
    document.getElementById("username-error").textContent = "";
    document.getElementById("password-error").textContent = "";

    fetch('GroupAccountManagement/update_account.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            // Update row data
            const row = document.querySelector(`tr[data-id="${formData.get('id')}"]`);
            row.children[1].textContent = form.elements['firstname'].value;
            row.children[2].textContent = form.elements['lastname'].value;
            row.children[3].textContent = form.elements['username'].value;
            row.children[4].textContent = form.elements['password'].value;
            row.children[5].textContent = form.elements['role'].value;

            formContainer.style.display = "none";
            document.getElementById("table-container").style.display = "block";
            
              Swal.fire({
            icon: 'success',
            title: 'Update Successful',
            text: 'The admin user has been updated successfully.',
            confirmButtonColor: '#4CAF50'
        });
        } else {
            if (data.field === 'username') {
                document.getElementById("username-error").textContent = data.error;
            } else if (data.field === 'password') {
                document.getElementById("password-error").textContent = data.error;
            } else {
                const generalError = document.createElement("div");
                generalError.className = "error-msg";
                generalError.style.color = "red";
                generalError.style.fontSize = "12px";
                generalError.textContent = data.error || "Update failed.";
                form.appendChild(generalError);
            }
        }
    })
    .catch(() => {
        const generalError = document.createElement("div");
        generalError.className = "error-msg";
        generalError.style.color = "red";
        generalError.style.fontSize = "12px";
        generalError.textContent = "Request failed.";
        form.appendChild(generalError);
    });
});

document.getElementById("cancel-edit").addEventListener("click", function () {
    document.getElementById("edit-form-container").style.display = "none";
    document.getElementById("table-container").style.display = "block";
});

function handleDelete(userId, row) {
    Swal.fire({
        title: 'Are you sure?',
        text: "Do you really want to delete this account?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('GroupAccountManagement/delete_account.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: userId })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    row.remove();
                    Swal.fire(
                        'Deleted!',
                        'The account has been deleted.',
                        'success'
                    );
                } else {
                    Swal.fire(
                        'Error!',
                        data.message || 'Delete failed.',
                        'error'
                    );
                }
            })
            .catch(() => {
                Swal.fire(
                    'Error!',
                    'Request failed.',
                    'error'
                );
            });
        }
    });
}
