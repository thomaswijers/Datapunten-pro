const follower = document.getElementById("cat-cursor");

// Hide the default cursor
document.body.classList.add("hidden-cursor");

// Move the frog-cursor on mousemove
document.addEventListener("mousemove", (event) => {
	// Show the frog-cursor when the mouse moves
	follower.classList.add("show");

	// Position the frog-cursor at the mouse position
	follower.style.left = `${event.pageX - 25}px`; // Center the frog on the cursor
	follower.style.top = `${event.pageY - 25}px`; // Center the frog on the cursor
});
