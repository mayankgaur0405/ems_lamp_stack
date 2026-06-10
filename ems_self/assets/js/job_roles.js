document
.getElementById("department")
.addEventListener("change", function()
{
    let departmentId = this.value;

    fetch(
    "../../api/get_job_roles.php?department_id="
    + departmentId
    )

    .then(response => response.text())

    .then(data =>
    {
        document.getElementById("job_role").innerHTML = data;
    });

});