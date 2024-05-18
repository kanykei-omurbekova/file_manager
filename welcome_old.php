<div class="main-panel">
    <div class="content-wrapper">
        <?php
        if ($_SESSION['role'] == 0) {
            // Customer Dashboard
            include 'partials/customer_dashboard.php';
        } elseif ($_SESSION['role'] == 1) {
            // Admin Dashboard
        ?>
            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Admin Dashboard - Document Approvals</h4>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Document Name</th>
                                            <th>Uploaded By</th>
                                            <th>Approval Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = "SELECT d.*, u.username AS uploader, a.username AS approver 
                                                FROM documents d
                                                LEFT JOIN users u ON d.doc_user = u.user_id
                                                LEFT JOIN users a ON d.approved_by = a.user_id";
                                        $result = $conn->query($sql);

                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($row['doc_name']) ?></td>
                                                    <td><?= htmlspecialchars($row['uploader']) ?></td>
                                                    <td>
                                                        <?php
                                                        if ($row['approved'] == 1) {
                                                            echo "Approved by " . htmlspecialchars($row['approver']) . " on " . htmlspecialchars($row['approved_at']);
                                                        } else {
                                                            echo "Pending Approval";
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($row['approved'] == 0): ?>
                                                            <form action="admin/approve_document.php" method="post">
                                                                <input type="hidden" name="doc_id" value="<?= $row['doc_id'] ?>">
                                                                <button type="submit" class="btn btn-success">Approve</button>
                                                            </form>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        } else {
                                            echo "<tr><td colspan='4'>No documents found.</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        } else {
            echo "Invalid user role.";
        }
        ?>
    </div>
    <!-- content-wrapper ends -->
</div>
<!-- main-panel ends -->
