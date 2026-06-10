<?php
session_start();
if(!isset($_SESSION['id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit;
}
include "../../includes/db.php";

$query1 = "SELECT e.*, d.name AS department_name FROM employees e LEFT JOIN departments d ON e.department_id = d.id ORDER BY e.id DESC";
$result1 = mysqli_query($conn,$query1);
$count = mysqli_num_rows($result1);
$no_of_rows_perpage = 5;
$total_page = ceil($count/$no_of_rows_perpage);

if(!isset($_GET['page_no'])){
    $page = 1;
}else{
    $page = $_GET['page_no'];
}

$offset = ($page-1)*$no_of_rows_perpage;
$query = $query1." limit ".$offset.",".$no_of_rows_perpage;
$result = mysqli_query($conn,$query);
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    function search(x){
        //alert(x);
           jQuery.ajax({
                            url: "ajaxsearch.php",
                            type: "post",
                            data: "name="+x ,
                            success: function (response) {
                                jQuery('#output').html(response);

                               // You will get response from your PHP page (what you echo or print)
                            },
       
                        });
                    }
    
</script>
<?php include "../../includes/header.php"; ?>

<div class="d-flex">

<?php include "../../includes/sidebar.php"; ?>

<div class="flex-grow-1" style="background-color: var(--body-bg); min-height: 100vh;">
    <!-- Topbar -->
    <div class="d-flex justify-content-between align-items-center p-3 bg-white border-bottom">
        <div>
            <button class="btn btn-light d-md-none"><i class="bi bi-list"></i></button>
            <i class="bi bi-list fs-4 ms-2 d-none d-md-inline-block text-secondary"></i>
        </div>
        <div class="d-flex align-items-center">
            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px; font-weight: 600; font-size: 0.9rem;">
                SA
            </div>
            <span class="fw-medium text-secondary" style="font-size: 0.9rem;"><?php echo htmlspecialchars($_SESSION['name']); ?></span>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container-fluid p-4">
        
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-4">
                
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="mb-0 text-dark fw-bold"><i class="bi bi-people-fill text-purple me-2" style="color: #a855f7;"></i> All Employees</h4>
                    <a href="add_employee.php" class="btn btn-primary rounded-pill px-3"><i class="bi bi-plus-lg me-1"></i> Add Employee</a>
                </div>
                
                <div class="search-wrapper mb-4">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control border-start-0 ps-0" placeholder="Search employees by name or email..." onkeyup="search(this.value)">
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-custom mb-0">
                        <thead>
                            <tr>
                                <th class="ps-4">Employee</th>
                                <th>Email</th>
                                
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="output">
                            <?php
                            while($row = mysqli_fetch_assoc($result)) {
                            ?>
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-3" style="width: 36px; height: 36px; overflow: hidden;">
                                            <?php if(!empty($row['profile_pic'])): ?>
                                                <img src="../../uploads/profiles/<?php echo $row['profile_pic']; ?>" alt="Profile" style="width: 100%; height: 100%; object-fit: cover;">
                                            <?php else: ?>
                                                <i class="bi bi-person-fill text-secondary"></i>
                                            <?php endif; ?>
                                        </div>
                                        <div>
                                            <span class="text-dark fw-bold d-block" style="font-size: 0.95rem;"><?php echo htmlspecialchars($row['name']); ?></span>
                                            <span class="text-muted" style="font-size: 0.8rem;"><?php echo htmlspecialchars($row['designation'] ?? 'Employee'); ?></span>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="text-secondary" style="font-size: 0.9rem;"><?php echo htmlspecialchars($row['email']); ?></span></td>
                                
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="edit_employee.php?id=<?php echo $row['id']; ?>" class="btn btn-outline-warning btn-sm d-flex align-items-center" style="border-radius: 20px; font-weight: 600; font-size: 0.75rem;" title="Edit"><i class="bi bi-pencil-fill me-1"></i> Edit</a>
                                        <a href="view_single.php?id=<?php echo $row['id']; ?>" class="btn btn-outline-info btn-sm d-flex align-items-center" style="border-radius: 20px; font-weight: 600; font-size: 0.75rem;" title="View Profile"><i class="bi bi-eye-fill me-1"></i> View</a>
                                        <a href="action.php?id=<?php echo $row['id']; ?>&action=delete" class="btn btn-outline-danger btn-sm d-flex align-items-center" style="border-radius: 20px; font-weight: 600; font-size: 0.75rem;" onclick="return confirm('Are you sure you want to delete this employee?')" title="Delete"><i class="bi bi-trash-fill me-1"></i> Delete</a>
                                        
                                        <?php if($row['role'] != 'admin'): ?>
                                            <?php if($row['status'] == 1): ?>
                                                <a href="action.php?id=<?php echo $row['id']; ?>&status=0" class="btn btn-outline-secondary btn-sm d-flex align-items-center" style="border-radius: 20px; font-weight: 600; font-size: 0.75rem;" onclick="return confirm('Disable Employee?')" title="Disable"><i class="bi bi-slash-circle-fill me-1"></i> Disable</a>
                                            <?php else: ?>
                                                <a href="action.php?id=<?php echo $row['id']; ?>&status=1" class="btn btn-outline-primary btn-sm d-flex align-items-center" style="border-radius: 20px; font-weight: 600; font-size: 0.75rem;" onclick="return confirm('Enable Employee?')" title="Enable"><i class="bi bi-check-circle-fill me-1"></i> Enable</a>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <nav aria-label="Page navigation" class="mt-4">
                    <ul class="pagination justify-content-end mb-0">
                        <?php if($page != 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="view_employee.php?page_no=<?php echo $page-1; ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo; Previous</span>
                            </a>
                        </li>
                        <?php endif; ?>

                        <?php for($x=1; $x<=$total_page; $x++): ?>
                        <li class="page-item <?php if($page == $x) echo 'active'; ?>">
                            <a class="page-link" href="view_employee.php?page_no=<?php echo $x; ?>"><?php echo $x; ?></a>
                        </li>
                        <?php endfor; ?>

                        <?php if($page != $total_page && $total_page > 0): ?>
                        <li class="page-item">
                            <a class="page-link" href="view_employee.php?page_no=<?php echo $page+1; ?>" aria-label="Next">
                                <span aria-hidden="true">Next &raquo;</span>
                            </a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </nav>

            </div>
        </div>
    </div>
</div>
</div>

<?php include "../../includes/footer.php"; ?>
</body>
</html>
