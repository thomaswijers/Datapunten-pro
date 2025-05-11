// Function to handle the search process via AJAX
function handleSearch(query = "") {
	const searchBox = document.getElementById("searchBar").value;

	// If the user has typed something in the search box, use it for the query
	const searchQuery = query || searchBox;

	// Send an AJAX request to fetch the data
	const xhr = new XMLHttpRequest();
	xhr.open("GET", `includes/handleDatapuntenSearch.php?search=${encodeURIComponent(searchQuery)}`, true);
	xhr.onreadystatechange = function () {
		if (xhr.readyState === 4 && xhr.status === 200) {
			const data = JSON.parse(xhr.responseText);

			// Insert the response data into the page
			const datapuntenList = document.getElementById("datapuntenList");
			datapuntenList.innerHTML = ""; // Clear existing data

			// Iterate through the grouped datapunten and append them
			for (const cursusTitle in data) {
				const cursusGroup = data[cursusTitle];

				// Sort cursussen by their 'order' field to display them in the correct order
				cursusGroup.sort((a, b) => a.order - b.order);

				// Create the container for the cursus
				const datapointContainer = document.createElement("div");
				datapointContainer.classList.add("datapoint-container");

				// Add the cursus title inside the datapoint-container
				const groupTitle = document.createElement("h2");
				groupTitle.textContent = cursusTitle;
				datapointContainer.appendChild(groupTitle);

				// Add the datapunten under this cursus group
				cursusGroup.forEach((datapunt) => {
					const listItem = document.createElement("div");
					listItem.classList.add("single-datapoint");
					listItem.innerHTML = `
                        <h3>${datapunt.title}</h3>
                        ${datapunt.herkansing ? "<span class='label'>Herkansing</span>" : ""}
                        <a href="${datapunt.file}" class='btn primary-btn' download>Download</a>
                    `;
					datapointContainer.appendChild(listItem);
				});

				// Append the datapoint-container to the main list
				datapuntenList.appendChild(datapointContainer);
			}
		}
	};
	xhr.send();
}

// Call the function when the page loads to show all datapunten
document.addEventListener("DOMContentLoaded", function () {
	handleSearch(); // Load all datapunten initially
});

// Trigger the AJAX search when the user types in the search bar
document.getElementById("searchBar").addEventListener("input", function () {
	handleSearch(); // Trigger search on input change
});
