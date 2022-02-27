<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="theme-color" content="#000000" />

	<link rel="shortcut icon" href="media/favicon.ico" type="image/x-icon" />
	
	<title>
		@if($page->slug !== "index")
		{{ $page->title }} |
		@endif
		{{ $siteName }}
	</title>

	@if($realtime)
	<!-- Realtime Styles -->
	<style>
		{{ $realtimeStyles }}
	</style>
	@else
	<link rel="stylesheet" href="media/app.css">
	@endif

	<!-- Prevent FOUC -->
	<style>
		.prose .table-of-contents {
			display: none;
		}
	</style>

	@if(config('laradocgen.useTorchlight'))
	<!-- Torchlight -->
	<style>
		/* Unset Tailwind Style */ .prose pre { padding: unset; } /* Margin and rounding are personal preferences, overflow-x-auto is recommended. */ pre { border-radius: 0.25rem; margin-top: 1rem; margin-bottom: 1rem; overflow-x: auto; } /* Add some vertical padding and expand the width to fill its container. The horizontal padding comes at the line level so that background colors extend edge to edge. */ pre code.torchlight { display: block; min-width: -webkit-max-content; min-width: -moz-max-content; min-width: max-content; padding-top: 1rem; padding-bottom: 1rem; } /* Horizontal line padding to match the vertical padding from the code block above. */ pre code.torchlight .line { padding-left: 1rem; padding-right: 1rem; } /* Push the code away from the line numbers and summary caret indicators. */ pre code.torchlight .line-number, pre code.torchlight .summary-caret { margin-right: 1rem; } /* Blur and dim the lines that don't have the `.line-focus` class, but are within a code block that contains any focus lines. */ .torchlight.has-focus-lines .line:not(.line-focus) { transition: filter 0.35s, opacity 0.35s; filter: blur(.095rem); opacity: .65; } /* When the code block is hovered, bring all the lines into focus. */ .torchlight.has-focus-lines:hover .line:not(.line-focus) { filter: blur(0px); opacity: 1; } /* Style the filepath */ :not(code)>.filepath { display: none; } pre>code>.filepath { position: relative; top: -.25rem; right: 1rem; float: right; opacity: .5; transition: opacity 0.25s; } pre>code>.filepath:hover { opacity: 1; }
	</style>
	@endif

	<script>
		// On page load or when changing themes, best to add inline in `head` to avoid FOUC
		if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
			document.documentElement.classList.add('dark');
		} else {
			document.documentElement.classList.remove('dark')
		}
	</script>

		
	{{-- Uncomment the following line to enable the TailwindCSS CDN (for development only) --}}
	{{-- <script src="https://cdn.tailwindcss.com"></script> <script> tailwind.config = { darkMode: 'class', } </script> --}}

</head>

<body class="text-zinc-700 dark:text-gray-300 antialiased bg-white dark:bg-gray-900 min-h-screen flex flex-col">
	
	@include('laradocgen::sidebar')

	<main class="md:ml-64 lg:ml-72 xl:pl-8 mb-auto">
		<article class="prose dark:prose-invert max-w-3xl p-6 lg:p-8">
			{{-- Print the Markdown HTML from the page object. --}}
			{!! $page->markdown !!}
		</article>
	</main>

	@include('laradocgen::footer')

	<script>
		// Move the dynamic table of contents to the sidebar // @todo this should be done in the Markdown parser/static page builder instead.
		let toc = document.querySelector('ul.table-of-contents');
		if (toc) {
			let destination = document.getElementById('sidebar-active');
			if (destination) {
				destination.insertAdjacentHTML('beforeend', toc.outerHTML);
				toc.remove();
			}
		}
	</script>

	<script>
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
	</script>

	<script>
		// Toggle darkmode
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
	</script>

	<script type="text/javascript">
		/* Sidebar - Side navigation menu on mobile/responsive mode */
	function toggleNavbar(collapseID) {
		document.getElementById(collapseID).classList.toggle("hidden");
		document.getElementById(collapseID).classList.toggle("bg-white dark:bg-gray-900");
		document.getElementById(collapseID).classList.toggle("m-2");
		document.getElementById(collapseID).classList.toggle("py-3");
		document.getElementById(collapseID).classList.toggle("px-6");
	}
	</script>

	@if($realtime)
	@else
	<script src="media/app.js"></script>
	@endif
</body>

</html>