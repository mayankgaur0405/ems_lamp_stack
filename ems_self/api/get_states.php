<?php

include "../includes/db.php";

$country_id = $_GET['country_id'];

$query =
"SELECT *
FROM states
WHERE country_id='$country_id'
ORDER BY name";

$result = mysqli_query($conn,$query);

echo '<option value="">Select State</option>';

while($row = mysqli_fetch_assoc($result))
{
    ?>

    <option value="<?php echo $row['id']; ?>">
        <?php echo $row['name']; ?>
    </option>

    <?php
}
?>