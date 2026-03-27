<?php
session_start();
include 'db.php';

$result = mysqli_query($conn, "SELECT * FROM students ORDER BY id DESC");
$edit_row = null;
if (isset($_GET['edit_id'])) {
    $edit_id  = (int) $_GET['edit_id'];
    $edit_res = mysqli_query($conn, "SELECT * FROM students WHERE id=$edit_id");
    $fetched  = mysqli_fetch_assoc($edit_res);
    $edit_row = $fetched ?: null; // normalize false → null
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container-fluid my-4 px-4">
        <h3 class="fw-bold mb-4">Student Information</h3>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card shadow h-100">
                    <div class="card-header bg-primary text-light fw-bold">Add Information</div>

                    <div class="card-body">
                        <form action="insert.php" method="post">
                            <div class="mb-3">
                                <label class="form-label">First Name:</label>
                                <input type="text" name="firstname" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Last Name:</label>
                                <input type="text" name="lastname" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Gender:</label><br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" value="Male" required>
                                    <label class="form-check-label">Male</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" value="Female">
                                    <label class="form-check-label">Female</label>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Course</label>
                                <select name="course" class="form-select" required>
                                    <option value="">-- Select Course --</option>
                                    <option value="BSIT">BSIT</option>
                                    <option value="BSCS">BSCS</option>
                                    <option value="BSIS">BSIS</option>
                                    <option value="BSECE">BSECE</option>
                                </select>
                            </div>


                            <div class="mb-3">
                                <label class="form-label">Email:</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Phone Number:</label>
                                <input type="text" name="phone" class="form-control" required>
                            </div>

                            <div class="d-grid">
                                <button type="submit" name="add" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-secondary text-white fw-bold">
                        Student Records
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover mb-0">
                                <thead class="table-secondary">
                                    <tr>
                                        <th>#</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Gender</th>
                                        <th>Course</th>
                                        <th>Email</th>
                                        <th>Phone Number</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (mysqli_num_rows($result) > 0):
                                        $i = 1;
                                        while ($row = mysqli_fetch_array($result)):
                                    ?>
                                            <tr>
                                                <td><?= $i++ ?></td>
                                                <td><?= $row["firstname"] ?></td>
                                                <td><?= $row["lastname"] ?></td>
                                                <td><?= $row["gender"] ?></td>
                                                <td><?= $row["course"] ?></td>
                                                <td><?= $row["email"] ?></td>
                                                <td><?= $row["phone"] ?></td>
                                                <td>

                                                    <a href="index.php?edit_id=<?= $row['id'] ?>"
                                                        class="btn btn-warning btn-sm edit-btn">
                                                        <i class="fa fa-pencil"></i>
                                                    </a>

                                                    <a href="delete.php?id=<?= $row['id'] ?>"
                                                        class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Delete this student?')">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="8" class="text-center text-muted py-3">No records found.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="update.php">
                    <div class="modal-body">
                        <input type="hidden" name="id" value="<?= $edit_row['id'] ?? '' ?>">
                        <div class="mb-3">
                            <label class="form-label">First Name:</label>
                            <input type="text" name="firstname" class="form-control" required
                                value="<?= htmlspecialchars($edit_row['firstname'] ?? '') ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Last Name:</label>
                            <input type="text" name="lastname" class="form-control" required
                                value="<?= htmlspecialchars($edit_row['lastname'] ?? '') ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Gender:</label><br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" value="Male"
                                    <?= ($edit_row['gender'] ?? '') === 'Male' ? 'checked' : '' ?>>
                                <label class="form-check-label">Male</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" value="Female"
                                    <?= ($edit_row['gender'] ?? '') === 'Female' ? 'checked' : '' ?>>
                                <label class="form-check-label">Female</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Course:</label>
                            <select name="course" class="form-select" required>
                                <?php foreach (['BSIT', 'BSCS', 'BSIS', 'BSECE'] as $c): ?>
                                    <option value="<?= $c ?>" <?= ($edit_row['course'] ?? '') === $c ? 'selected' : '' ?>>
                                        <?= $c ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email:</label>
                            <input type="email" name="email" class="form-control" required
                                value="<?= htmlspecialchars($edit_row['email'] ?? '') ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone Number:</label>
                            <input type="text" name="phone" class="form-control" required
                                value="<?= htmlspecialchars($edit_row['phone'] ?? '') ?>">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="update" class="btn btn-primary">Update</button>
                        <a href="index.php" class="btn btn-danger">Close</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php if ($edit_row): ?>
        <script>
            window.addEventListener('DOMContentLoaded', function() {
                new bootstrap.Modal(document.getElementById('editModal')).show();
            });
        </script>
    <?php endif; ?>
</body>

</html>