<?php

include "../includes/db.php";

$department_id = $_GET['department_id'];

$query =
"SELECT *
FROM job_roles
WHERE department_id='$department_id'
ORDER BY title";

$result = mysqli_query($conn,$query);

echo '<option value="">Select Job Role</option>';

while($row = mysqli_fetch_assoc($result))
{
    ?>

    <option value="<?php echo $row['id']; ?>">
        <?php echo $row['title']; ?>
    </option>

    <?php
}
?>