<?php

session_start();

if(
    !isset($_SESSION['id'])
    ||
    $_SESSION['role'] != 'admin'
)
{
    header("Location: ../index.php");
    exit;
}

include "../../includes/db.php";

 $query1 =
"SELECT d.*,
(
SELECT COUNT(*)
FROM employees e
WHERE e.department_id = d.id
) AS total_employees
FROM departments d
ORDER BY d.id DESC";

$result1 = mysqli_query($conn,$query1);

$count = mysqli_num_rows($result1);

$row_per_page = 5;
$pages = ceil($count/$row_per_page);

if(!isset($_GET['page_no'])){
$curr_page = 1;
}else{
    $curr_page = $_GET['page_no'];
}

$offset = ($curr_page-1)*($row_per_page);

 $query =
$query1. " limit ".$offset.",".$row_per_page;

$result = mysqli_query($conn,$query);

?>

<?php include "../../includes/header.php"; ?>

<div class="d-flex">

<?php include "../../includes/sidebar.php"; ?>

<div class="flex-grow-1" style="background-color: var(--body-bg); min-height: 100vh;">
    <div class="d-flex justify-content-between align-items-center p-3 bg-white border-bottom">
        <div><i class="bi bi-list fs-4 ms-2 text-secondary"></i></div>
        <div class="d-flex align-items-center">
            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px; font-weight: 600; font-size: 0.9rem;">SA</div>
            <span class="fw-medium text-secondary" style="font-size: 0.9rem;"><?php echo htmlspecialchars($_SESSION['name']); ?></span>
        </div>
    </div>

    <div class="container-fluid p-4">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0 text-dark fw-bold"><i class="bi bi-building me-2" style="color: #38bdf8;"></i> Company Departments</h4>
            <a href="add_department.php" class="btn btn-primary rounded-pill px-3"><i class="bi bi-plus-lg me-1"></i> Add Department</a>
        </div>
        
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-0">

                <div class="search-wrapper p-3">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-search"></i></span>
                        <input type="text" id="deptSearch" class="form-control border-start-0 ps-0" placeholder="Search departments..." onkeyup="filterTable()">
                    </div>
                </div>

                <script>
                function filterTable() {
                    let input = document.getElementById("deptSearch").value.toUpperCase();
                    let table = document.getElementById("deptTable");
                    let tr = table.getElementsByTagName("tr");
                    for (let i = 1; i < tr.length; i++) {
                        let td = tr[i].getElementsByTagName("td")[1];
                        if (td) {
                            let txtValue = td.textContent || td.innerText;
                            if (txtValue.toUpperCase().indexOf(input) > -1) {
                                tr[i].style.display = "";
                            } else {
                                tr[i].style.display = "none";
                            }
                        }       
                    }
                }
                </script>

                <div class="table-responsive">
                    <table class="table table-custom mb-0" id="deptTable">
                        <thead>
                            <tr>
                                <th class="ps-4">ID</th>
                                <th>Department Name</th>
                                <th>Total Employees</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td class="ps-4 text-muted"><?php echo $row['id']; ?></td>
                                <td><span class="fw-bold text-dark"><?php echo htmlspecialchars($row['name']); ?></span></td>
                                <td>
                                    <span class="badge-role employee"><?php echo $row['total_employees']; ?> employee<?php echo $row['total_employees'] != 1 ? 's' : ''; ?></span>
                                </td>
                                <td class="text-muted"><?php echo date('d M Y', strtotime($row['created_at'])); ?></td>
                                <td>
                                    <a href="delete_department.php?id=<?php echo $row['id']; ?>" class="btn btn-outline-danger btn-sm" style="border-radius: 20px; font-weight: 600; font-size: 0.75rem;" onclick="return confirm('Delete Department?')"><i class="bi bi-trash me-1"></i> Delete</a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <nav aria-label="Page navigation" class="mt-4">
            <ul class="pagination justify-content-end mb-0">
                <?php if($curr_page != 1): ?>
                <li class="page-item">
                    <a class="page-link" href="view_department.php?page_no=<?php echo $curr_page-1; ?>">&laquo; Previous</a>
                </li>
                <?php endif; ?>

                <?php for($x=1; $x<=$pages; $x++): ?>
                <li class="page-item <?php if($curr_page == $x) echo 'active'; ?>">
                    <a class="page-link" href="view_department.php?page_no=<?php echo $x; ?>"><?php echo $x; ?></a>
                </li>
                <?php endfor; ?>

                <?php if($curr_page != $pages && $pages > 0): ?>
                <li class="page-item">
                    <a class="page-link" href="view_department.php?page_no=<?php echo $curr_page+1; ?>">Next &raquo;</a>
                </li>
                <?php endif; ?>
            </ul>
        </nav>

    </div>
</div>
</div>

<?php include "../../includes/footer.php"; ?>