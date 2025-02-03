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
    <div class="container d-flex justify-content-center mt-5">
        <div class="col-6">
            <div class="row">
            <p class="display-5 fw-bold">Detailing</p>
            </div>
            <div class="row">
                <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo htmlspecialchars($_GET['error']); ?>
                    </div>
                <?php endif; ?>
                <form id="infoForm" action="handlers/add_info_handler.php" method="POST">
                    <div class="form-group col-6">
                        <label for="fname">First Name:</label>
                        <input type="text" class="form-control" id="fname" name="fname">
                    </div>
                    <div class="form-group col-6">
                        <label for="mname">Middle Name:</label>
                        <input type="text" class="form-control" id="mname" name="mname">
                    </div>
                    <div class="form-group col-6">
                        <label for="lname">Last Name:</label>
                        <input type="text" class="form-control" id="lname" name="lname">
                    </div>
                    <div class="form-group col-6">
                        <label for="email">Email address:</label>
                        <input type="email" class="form-control" id="email" name="email">
                    </div>
                    <div class="form-group col-6">
                        <label for="city">City:</label>
                        <input type="text" class="form-control" id="city" name="city">
                    </div>
                    <div class="form-group col-6">
                        <label for="bgry">Barangay:</label>
                        <input type="text" class="form-control" id="bgry" name="bgry">
                    </div>
                    <div class="form-group col-6">
                        <button type="button" class="btn btn-primary mt-3" onclick="showModal()">Submit</button>
                        <button type="button" class="btn btn-warning mt-3" data-bs-toggle="modal" data-bs-target="#editModal">Edit</button>
                        <button type="button" class="btn btn-danger mt-3" data-bs-toggle="modal" data-bs-target="#deleteModal">Delete</button>
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

    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="handlers/edit_info_handler.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Information</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="editName">Name:</label>
                            <input type="text" class="form-control" id="editName" name="editName">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
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
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function showModal() {
            document.getElementById('modalFname').innerText = document.getElementById('fname').value;
            document.getElementById('modalMname').innerText = document.getElementById('mname').value;
            document.getElementById('modalLname').innerText = document.getElementById('lname').value;
            document.getElementById('modalEmail').innerText = document.getElementById('email').value;
            document.getElementById('modalCity').innerText = document.getElementById('city').value;
            document.getElementById('modalBgry').innerText = document.getElementById('bgry').value;
            var submitModal = new bootstrap.Modal(document.getElementById('submitModal'));
            submitModal.show();
        }

        function submitForm() {
            document.getElementById('infoForm').submit();
        }

        function editDetails() {
            var personId = document.getElementById('personId').value;
            fetch('handlers/get_details.php?id=' + personId)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('fname').value = data.fname;
                    document.getElementById('mname').value = data.mname;
                    document.getElementById('lname').value = data.lname;
                    document.getElementById('email').value = data.email;
                    document.getElementById('city').value = data.city;
                    document.getElementById('bgry').value = data.bgry;
                })
                .catch(error => console.error('Error:', error));
        }
    </script>
</body>

</html>