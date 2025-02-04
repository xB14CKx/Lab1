<?php include 'database/database.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detailing</title>
    <link rel="stylesheet" href="statics/css/bootstrap.css">
    <script src="statics/js/bootstrap.bundle.js"></script>

</head>

<body>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="col-4">
            <div class="row mb-4">
                <p class="display-5 fw-bold text-center">Detailing</p>
            </div>
            <div class="row">
                <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo htmlspecialchars($_GET['error']); ?>
                    </div>
                <?php endif; ?>
                <form id="infoForm" action="handlers/add_info_handler.php" method="POST">
                    <div class="form-group mb-3">
                        <label for="fname">First Name:</label>
                        <input type="text" class="form-control" id="fname" name="fname">
                    </div>
                    <div class="form-group mb-3">
                        <label for="mname">Middle Name:</label>
                        <input type="text" class="form-control" id="mname" name="mname">
                    </div>
                    <div class="form-group mb-3">
                        <label for="lname">Last Name:</label>
                        <input type="text" class="form-control" id="lname" name="lname">
                    </div>
                    <div class="form-group mb-3">
                        <label for="email">Email address:</label>
                        <input type="email" class="form-control" id="email" name="email">
                    </div>
                    <div class="form-group mb-3">
                        <label for="city">City:</label>
                        <input type="text" class="form-control" id="city" name="city">
                    </div>
                    <div class="form-group mb-3">
                        <label for="bgry">Barangay:</label>
                        <input type="text" class="form-control" id="bgry" name="bgry">
                    </div>
                    <div class="d-grid">
                        <button type="button" class="btn btn-primary mt-3"
                            onclick="validateAndShowModal()">Submit</button>
                        <button type="button" class="btn btn-warning mt-3" onclick="showEditModal()">Edit</button>
                        <button type="button" class="btn btn-secondary mt-3" data-bs-toggle="modal"
                            data-bs-target="#grabDetailsModal">Grab Details</button>
                        <button type="button" class="btn btn-danger mt-3" data-bs-toggle="modal"
                            data-bs-target="#deleteModal">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="submitModal" tabindex="-1" aria-labelledby="submitModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="submitModalLabel">Confirm Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>First Name:</strong> <span id="modalFname"></span></p>
                    <p><strong>Middle Name:</strong> <span id="modalMname"></span></p>
                    <p><strong>Last Name:</strong> <span id="modalLname"></span></p>
                    <p><strong>Email:</strong> <span id="modalEmail"></span></p>
                    <p><strong>City:</strong> <span id="modalCity"></span></p>
                    <p><strong>Barangay:</strong> <span id="modalBgry"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="submitForm()">Confirm</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="grabDetailsModal" tabindex="-1" aria-labelledby="grabDetailsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editForm" onsubmit="fetchDetails(event)">
                    <div class="modal-header">
                        <h5 class="modal-title" id="grabDetailsModalLabel">Edit Information</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="editName">First Name:</label>
                            <input type="text" class="form-control" id="editName" name="editName">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Fetch Details</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editConfirmModal" tabindex="-1" aria-labelledby="editConfirmModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editConfirmModalLabel">Confirm Edit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>First Name:</strong> <span id="editModalFname"></span></p>
                    <p><strong>Middle Name:</strong> <span id="editModalMname"></span></p>
                    <p><strong>Last Name:</strong> <span id="editModalLname"></span></p>
                    <p><strong>Email:</strong> <span id="editModalEmail"></span></p>
                    <p><strong>City:</strong> <span id="editModalCity"></span></p>
                    <p><strong>Barangay:</strong> <span id="editModalBgry"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="submitEdit()">Confirm Edit</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="handlers/delete_info_handler.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Delete Information</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="deleteName">Name:</label>
                            <input type="text" class="form-control" id="deleteName" name="deleteName">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-danger" onclick="showDeleteConfirmModal()">Delete</button>

                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this record?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" onclick="confirmDelete()">Yes, Delete</button>
                </div>
            </div>
        </div>
    </div>


    <script>
        function validateAndShowModal() {
            var fname = document.getElementById('fname').value;
            var mname = document.getElementById('mname').value;
            var lname = document.getElementById('lname').value;
            var email = document.getElementById('email').value;
            var city = document.getElementById('city').value;
            var bgry = document.getElementById('bgry').value;

            if (!fname || !mname || !lname || !email || !city || !bgry) {
                alert('All fields are required.');
                return;
            }

            document.getElementById('modalFname').innerText = fname;
            document.getElementById('modalMname').innerText = mname;
            document.getElementById('modalLname').innerText = lname;
            document.getElementById('modalEmail').innerText = email;
            document.getElementById('modalCity').innerText = city;
            document.getElementById('modalBgry').innerText = bgry;

            var submitModal = new bootstrap.Modal(document.getElementById('submitModal'));
            submitModal.show();
        }

        function submitForm() {
            document.getElementById('infoForm').submit();
        }

        function fetchDetails(event) {
            event.preventDefault();
            var editName = document.getElementById('editName').value;
            if (!editName.trim()) {
                alert("Please enter a name to fetch details.");
                return;
            }

            fetch('handlers/get_details.php?name=' + encodeURIComponent(editName))
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        alert(data.error);
                    } else {
                        document.getElementById('fname').value = data.fname;
                        document.getElementById('mname').value = data.mname;
                        document.getElementById('lname').value = data.lname;
                        document.getElementById('email').value = data.email;
                        document.getElementById('city').value = data.city;
                        document.getElementById('bgry').value = data.bgry;

                        var grabDetailsModal = bootstrap.Modal.getOrCreateInstance(document.getElementById('grabDetailsModal'));
                        grabDetailsModal.hide();
                    }
                })
                .catch(error => {
                    console.error('Error fetching details:', error);
                    alert('Failed to fetch details.');
                });
        }

        function showEditModal() {
            var fname = document.getElementById('fname').value;
            var mname = document.getElementById('mname').value;
            var lname = document.getElementById('lname').value;
            var email = document.getElementById('email').value;
            var city = document.getElementById('city').value;
            var bgry = document.getElementById('bgry').value;

            if (!fname || !mname || !lname || !email || !city || !bgry) {
                alert('All fields are required before editing.');
                return;
            }

            document.getElementById('editModalFname').innerText = fname;
            document.getElementById('editModalMname').innerText = mname;
            document.getElementById('editModalLname').innerText = lname;
            document.getElementById('editModalEmail').innerText = email;
            document.getElementById('editModalCity').innerText = city;
            document.getElementById('editModalBgry').innerText = bgry;

            var editConfirmModal = new bootstrap.Modal(document.getElementById('editConfirmModal'));
            editConfirmModal.show();
        }

        function submitEdit() {
            var editConfirmModal = bootstrap.Modal.getInstance(document.getElementById('editConfirmModal'));
            if (editConfirmModal) {
                editConfirmModal.hide();
            }

            setTimeout(() => {
                window.location.href = "index.php";
            }, 300);
        }

        function showDeleteConfirmModal() {
            var deleteConfirmModal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
            deleteConfirmModal.show();
        }

        function confirmDelete() {
            // Close the confirmation modal first
            var deleteConfirmModal = bootstrap.Modal.getInstance(document.getElementById('deleteConfirmModal'));
            if (deleteConfirmModal) {
                deleteConfirmModal.hide();
            }

            // Submit the delete form
            setTimeout(() => {
                document.querySelector("#deleteModal form").submit();
            }, 300); // Delay ensures smooth closing of modal before submission
        }

    </script>
</body>

</html>