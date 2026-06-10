<?php

include "../includes/db.php";

$state_id = $_GET['state_id'];

$query =
"SELECT *
FROM cities
WHERE state_id='$state_id'
ORDER BY name";

$result = mysqli_query($conn,$query);

echo '<option value="">Select City</option>';

while($row = mysqli_fetch_assoc($result))
{
    ?>

    <option value="<?php echo $row['id']; ?>">
        <?php echo $row['name']; ?>
    </option>

    <?php
}
?>