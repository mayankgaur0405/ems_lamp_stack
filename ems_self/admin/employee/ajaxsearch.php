<?php
$a=$_POST['name'];
include "../../includes/db.php";
$query1 =
"SELECT e.*,
d.name AS department_name

FROM employees e

LEFT JOIN departments d
ON e.department_id = d.id
 where e.name like '%$a%' or e.email like '%$a%'
ORDER BY e.id DESC";

$result1 = mysqli_query($conn,$query1);
while($row=mysqli_fetch_assoc($result1)){
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
    <td><span class="text-secondary" style="font-size: 0.9rem;">India</span></td>
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
<?php
}
?>

