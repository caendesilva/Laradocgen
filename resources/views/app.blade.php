<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="theme-color" content="#000000" />

	@if($realtime)
	<link rel="shortcut icon" href="/realtime-docs-compiler/media/favicon.ico" />

	<link rel="stylesheet" href="/realtime-docs-compiler/media/app.css">
	@if($appmeta->customStylesheet)
	<link rel="stylesheet" href="/realtime-docs-compiler/media/custom.css">
	@endif
	@else
	<link rel="shortcut icon" href="media/favicon.ico" />

	<link rel="stylesheet" href="media/app.css">
	@endif

	<title>
		@if($page->slug !== "index")
		{{ $page->title }} |
		@endif
		{{ $siteName }}
	</title>

	<!-- Prevent FOUC -->
	<style>
		.prose .table-of-contents {
			display: none;
		}
	</style>

	@if(config('laradocgen.useTorchlight'))
	<!-- Torchlight -->
	<style>
		/* Unset Tailwind Style */
		.prose pre {
			padding: unset;
		}

		/* Margin and rounding are personal preferences, overflow-x-auto is recommended. */
		pre {
			border-radius: 0.25rem;
			margin-top: 1rem;
			margin-bottom: 1rem;
			overflow-x: auto;
		}

		/* Add some vertical padding and expand the width to fill its container. The horizontal padding comes at the line level so that background colors extend edge to edge. */
		pre code.torchlight {
			display: block;
			min-width: -webkit-max-content;
			min-width: -moz-max-content;
			min-width: max-content;
			padding-top: 1rem;
			padding-bottom: 1rem;
		}

		/* Horizontal line padding to match the vertical padding from the code block above. */
		pre code.torchlight .line {
			padding-left: 1rem;
			padding-right: 1rem;
		}

		/* Push the code away from the line numbers and summary caret indicators. */
		pre code.torchlight .line-number,
		pre code.torchlight .summary-caret {
			margin-right: 1rem;
		}

		/*
			Blur and dim the lines that don't have the `.line-focus` class,
			but are within a code block that contains any focus lines.
		*/
		.torchlight.has-focus-lines .line:not(.line-focus) {
			transition: filter 0.35s, opacity 0.35s;
			filter: blur(.095rem);
			opacity: .65;
		}

		/* When the code block is hovered, bring all the lines into focus. */
		.torchlight.has-focus-lines:hover .line:not(.line-focus) {
			filter: blur(0px);
			opacity: 1;
		}

		/* Style the filepath */
		:not(code)>.filepath {
			display: none;
		}
		pre>code>.filepath {
			position: relative;
			top: -.25rem;
			right: 1rem;
			float: right;
			opacity: .5;
			transition: opacity 0.25s;
		}
		pre>code>.filepath:hover {
			opacity: 1;
		}
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
</head>

{{-- Uncomment the following line to enable the TailwindCSS CDN (for development only) --}}
{{-- <script src="https://cdn.tailwindcss.com"></script> <script> tailwind.config = { darkMode: 'class', } </script> --}}

<body class="text-zinc-700 dark:text-gray-300 antialiased bg-white dark:bg-gray-900 min-h-screen flex flex-col">
	<nav
		class="md:left-0 md:block md:fixed md:top-0 md:bottom-0 md:overflow-y-auto md:flex-row md:flex-nowrap md:overflow-hidden shadow-xl bg-white dark:bg-gray-900 flex flex-wrap items-center justify-between relative md:w-64 lg:w-72 z-10 py-4 px-6">
		<div
			class="md:flex-col md:items-stretch md:min-h-full md:flex-nowrap px-0 flex flex-wrap items-center justify-between w-full mx-auto">
			<div class="flex flex-row justify-between items-center overflow-visible md:pb-2 py-4 w-full">
				<a class="md:block text-left text-zinc-600 dark:text-gray-100 mr-0 inline-block  text-sm uppercase font-bold px-0 w-fit"
					href="index{{ $realtime == false ? '.html' : '' }}">
					{{ $siteName }}
				</a>
				<!-- Dark mode switch -->
				<button id="theme-toggle" type="button" class="ml-auto md:ml-0 text-gray-500 dark:text-gray-400 dark:hover:text-gray-100 hover:text-gray-700 " title="Toggle Dark Mode">
					<svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
					<svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path></svg>
				</button>
				<button
				class="cursor-pointer text-black opacity-50 md:hidden px-3 py-1 text-xl leading-none bg-transparent rounded border border-solid border-transparent"
				type="button" onclick="toggleNavbar('example-collapse-sidebar')">
				<svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
					<path d="M0 0h24v24H0z" fill="none" />
					<path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z" />
				</svg></button>

			</div>
			
			<div class="md:flex md:flex-col md:items-stretch md:opacity-100 md:relative md:shadow-none shadow absolute top-0 left-0 right-0 z-40 overflow-y-auto overflow-x-hidden h-auto items-center flex-1 rounded hidden"
				id="example-collapse-sidebar">
				<div class="md:min-w-full md:hidden block pb-4 mb-4 border-b border-solid border-zinc-200">
					<div class="flex flex-wrap">
						<div class="w-9/12">
							<a class="md:block text-left md:pb-2 text-zinc-600 mr-0 inline-block whitespace-nowrap text-sm uppercase font-bold p-4 px-0"
								href="index{{ $realtime == false ? '.html' : '' }}">
								{{ $siteName }}
							</a>
						</div>
						<div class="w-3/12 flex justify-end">
							<button type="button"
								class="cursor-pointer text-black opacity-50 md:hidden px-3 py-1 text-xl leading-none bg-transparent rounded border border-solid border-transparent"
								onclick="toggleNavbar('example-collapse-sidebar')">
								<svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
									<path d="M0 0h24v24H0z" fill="none" />
									<path
										d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z" />
								</svg>
							</button>
						</div>
					</div>
				</div>
				<form class="mt-6 mb-4 md:hidden">
					<div class="mb-3 pt-0">
						<input type="text" placeholder="Search"
							class="px-3 py-2 h-12 border border-solid  border-zinc-500 placeholder-zinc-300 text-zinc-600 bg-white rounded text-base leading-snug shadow-none outline-none focus:outline-none w-full font-normal" />
					</div>
				</form>

				<hr class="my-4 md:min-w-full" />

				<ul class="md:flex-col md:min-w-full flex flex-col list-none">
					@foreach ($links as $link)
					@if($link->slug == $page->slug)
					<li id="sidebar-active" class="items-center">
						<a class="text-pink-500 hover:text-pink-600 text-xs uppercase py-3 font-bold block"
							href="{{ $link->slug }}{{ $realtime == false ? '.html' : '' }}">
							{{ $link->title }}
						</a>
					</li>
					@else
					<li class="items-center">
						<a class="text-zinc-700 dark:text-gray-200 hover:text-zinc-500 text-xs uppercase py-3 font-bold block"
							href="{{ $link->slug }}{{ $realtime == false ? '.html' : '' }}">
							{{ $link->title }}
						</a>
					</li>
					@endif
					@endforeach
				</ul>

				<div class="mt-auto">
					<hr class="my-3 md:min-w-full" />
					<h6
						class="md:min-w-full text-zinc-600 dark:text-gray-300 text-xs uppercase font-bold block py-1 no-underline">
						<a href="/">
							Back to App
						</a>
					</h6>
				</div>
			</div>
		</div>
	</nav>
	
	<main class="md:ml-64 lg:ml-72 xl:pl-8 mb-auto">
		<article class="prose dark:prose-invert max-w-3xl p-6 lg:p-8">
			{!!
			// Print the Markdown HTML from the page object.
			// If this is a realtime request we replace the media path first.
			$realtime
			? str_replace('<img src="media/', '<img src="/realtime-docs-compiler/media/', $page->markdown)
			: $page->markdown;
			!!}
		</article>
	</main>


	<footer class="md:ml-64 lg:ml-72 xl:pl-8 py-2 bg-slate-100 dark:bg-slate-900 dark:text-gray-100">
		<div class="max-w-3xl mx-6 lg:mx-8 p-2">
			@if(config('laradocgen.useTorchlight'))
			<small>
				This site was generated using the free and open source <a class="text-indigo-700 dark:text-indigo-400" href="https://github.com/desilva/laradocgen/">Laradocgen</a> package. License MIT.
			</small>
			<small class="ml-3">
				Syntax highlighting by <a class="text-indigo-700 dark:text-indigo-400" href="https://torchlight.dev/"
					rel="noopener noreferrer nofollow">Torchlight.dev</a>
			</small>
			@endif
		</div>
	</footer>

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
</body>

</html>