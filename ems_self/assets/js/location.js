document
.getElementById("country")
.addEventListener("change", function()
{
    let countryId = this.value;

    fetch(
    "../../api/get_states.php?country_id="
    + countryId
    )

    .then(response => response.text())

    .then(data =>
    {
        document.getElementById("state").innerHTML = data;

        document.getElementById("city").innerHTML =
        '<option value="">Select City</option>';
    });

});

document
.getElementById("state")
.addEventListener("change", function()
{
    let stateId = this.value;

    fetch(
    "../../api/get_cities.php?state_id="
    + stateId
    )

    .then(response => response.text())

    .then(data =>
    {
        document.getElementById("city").innerHTML = data;
    });

});