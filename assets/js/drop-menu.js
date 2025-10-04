document.addEventListener("DOMContentLoaded", function () {
	const menu = document.querySelector(".user-menu");
	if (menu) {
		const button = menu.querySelector(".user-button");
		button.addEventListener("click", function (e) {
			e.stopPropagation();
			menu.classList.toggle("open");
		});
		document.addEventListener("click", function (e) {
			menu.classList.remove("open");
		});
	}
});
