// Move the dynamic table of contents to the sidebar // @todo this should be done in the Markdown parser/static page builder instead.
let toc = document.querySelector('ul.table-of-contents');
if (toc) {
	let destination = document.getElementById('sidebar-active');
	if (destination) {
		destination.insertAdjacentHTML('beforeend', toc.outerHTML);
		toc.remove();
	}
}

// Move the filepath in code blocks // @todo this should be done in the Markdown parser/static page builder instead.
const filepaths = document.querySelectorAll(":not(pre)>.filepath");
// console.log(filepaths);
if (filepaths) {
	filepaths.forEach(filepath => {
		// console.log('filepath: ', filepath);
		var parent = filepath.parentNode;
		// console.log(parent);
		const codeblock = parent.nextElementSibling;
		// console.log(codeblock);
		codeblock.firstChild.insertAdjacentHTML('afterBegin', filepath.outerHTML);
	});
}

// Toggle darkmode (by Flowbite)
var themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
var themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

// Change the icons inside the button based on previous settings
if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
	themeToggleLightIcon.classList.remove('hidden');
} else {
	themeToggleDarkIcon.classList.remove('hidden');
}

var themeToggleBtn = document.getElementById('theme-toggle');

themeToggleBtn.addEventListener('click', function() {
	
	// toggle icons inside button
	themeToggleDarkIcon.classList.toggle('hidden');
	themeToggleLightIcon.classList.toggle('hidden');
	
	// if set via local storage previously
	if (localStorage.getItem('color-theme')) {
		if (localStorage.getItem('color-theme') === 'light') {
			document.documentElement.classList.add('dark');
			localStorage.setItem('color-theme', 'dark');
		} else {
			document.documentElement.classList.remove('dark');
			localStorage.setItem('color-theme', 'light');
		}
		
		// if NOT set via local storage previously
	} else {
		if (document.documentElement.classList.contains('dark')) {
			document.documentElement.classList.remove('dark');
			localStorage.setItem('color-theme', 'light');
		} else {
			document.documentElement.classList.add('dark');
			localStorage.setItem('color-theme', 'dark');
		}
	}
	
});

/* Sidebar - Side navigation menu on mobile/responsive mode */
function toggleNavbar(collapseID) {
	document.getElementById(collapseID).classList.toggle("hidden");
	document.getElementById(collapseID).classList.toggle("bg-white");
	document.getElementById(collapseID).classList.toggle("dark:bg-gray-900");
	document.getElementById(collapseID).classList.toggle("m-2");
	document.getElementById(collapseID).classList.toggle("py-3");
	document.getElementById(collapseID).classList.toggle("px-6");
}