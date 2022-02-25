<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="theme-color" content="#000000" />
	<link rel="shortcut icon" href="./assets/img/favicon.ico" />
	<link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png" />

	<!-- Untill we have something stable enough to warrant compiling the tailwind ourselves -->
	{{--
	<link rel="stylesheet" href="https://unpkg.com/tailwindcss@1.4.6/dist/base.min.css">
	<link rel="stylesheet" href="https://unpkg.com/tailwindcss@1.4.6/dist/components.min.css">
	<link rel="stylesheet" href="https://unpkg.com/@tailwindcss/typography@0.1.2/dist/typography.min.css">
	<link rel="stylesheet" href="https://unpkg.com/tailwindcss@1.4.6/dist/utilities.min.css"> --}}

	<link rel="stylesheet" href="{{
								$realtime
									? '/vendor/docgen/app.css'
									: 'media/app.css'
							}}">

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

	<!-- Table of Contents -->
	<style>
		html {
			scroll-behavior: smooth;
		}

		.table-of-contents {
			margin-bottom: 1rem;
		}

		.table-of-contents ul {
			margin-left: 1rem;
		}

		.table-of-contents li::before {
			content: "# ";
			color: #6b7280;
			transition: color 0.25s;
		}

		.heading-permalink {
			opacity: 0.25;
			color: #6b7280;
			padding: 1rem 0.75rem;
		}

		h1:hover .heading-permalink,
		h2:hover .heading-permalink,
		h3:hover .heading-permalink,
		h4:hover .heading-permalink,
		h5:hover .heading-permalink,
		h6:hover .heading-permalink {
			opacity: 1;
			color: #6366f1;
		}
	</style>

	<!-- Tailwind -->
	<style>
		.subheading {
			color: #1a202c;
			font-weight: 600;
			font-size: 1.2em;
			margin-top: 2em;
			margin-bottom: 1em;
			line-height: 1.3333333
		}

		.prose blockquote p:first-of-type::before,
		.prose blockquote p:last-of-type::after {
			content: none;
		}
	</style>

	@if(config('docgen.useTorchlight'))
	<!-- Torchlight -->
	<style>
		/* Unset Tailwind Style */
		.prose pre {
			padding: unset;
		}

		/*
		Margin and rounding are personal preferences,
		overflow-x-auto is recommended.
		*/
		pre {
			border-radius: 0.25rem;
			margin-top: 1rem;
			margin-bottom: 1rem;
			overflow-x: auto;
		}

		/*
		Add some vertical padding and expand the width
		to fill its container. The horizontal padding
		comes at the line level so that background
		colors extend edge to edge.
		*/
		pre code.torchlight {
			display: block;
			min-width: -webkit-max-content;
			min-width: -moz-max-content;
			min-width: max-content;
			padding-top: 1rem;
			padding-bottom: 1rem;
		}

		/*
		Horizontal line padding to match the vertical
		padding from the code block above.
		*/
		pre code.torchlight .line {
			padding-left: 1rem;
			padding-right: 1rem;
		}

		/*
		Push the code away from the line numbers and
		summary caret indicators.
		*/
		pre code.torchlight .line-number,
		pre code.torchlight .summary-caret {
			margin-right: 1rem;
		}
	</style>
	@endif
</head>

<body class="text-blueGray-700 antialiased">
	<noscript>You need to enable JavaScript to run this app.</noscript>
	<div id="root">
		<nav
			class="md:left-0 md:block md:fixed md:top-0 md:bottom-0 md:overflow-y-auto md:flex-row md:flex-nowrap md:overflow-hidden shadow-xl bg-white flex flex-wrap items-center justify-between relative md:w-64 lg:w-72 z-10 py-4 px-6">
			<div
				class="md:flex-col md:items-stretch md:min-h-full md:flex-nowrap px-0 flex flex-wrap items-center justify-between w-full mx-auto">
				<a class="md:block text-left md:pb-2 text-blueGray-600 mr-0 inline-block  text-sm uppercase font-bold p-4 px-0"
					href="index{{ $realtime == false ? '.html' : '' }}">
					{{ $siteName }}
				</a>
				<button
					class="cursor-pointer text-black opacity-50 md:hidden px-3 py-1 text-xl leading-none bg-transparent rounded border border-solid border-transparent"
					type="button" onclick="toggleNavbar('example-collapse-sidebar')">
					<svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
						<path d="M0 0h24v24H0z" fill="none" />
						<path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z" />
					</svg></button>

				<div class="md:flex md:flex-col md:items-stretch md:opacity-100 md:relative md:shadow-none shadow absolute top-0 left-0 right-0 z-40 overflow-y-auto overflow-x-hidden h-auto items-center flex-1 rounded hidden"
					id="example-collapse-sidebar">
					<div class="md:min-w-full md:hidden block pb-4 mb-4 border-b border-solid border-blueGray-200">
						<div class="flex flex-wrap">
							<div class="w-9/12">
								<a class="md:block text-left md:pb-2 text-blueGray-600 mr-0 inline-block whitespace-nowrap text-sm uppercase font-bold p-4 px-0"
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
								class="px-3 py-2 h-12 border border-solid  border-blueGray-500 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-base leading-snug shadow-none outline-none focus:outline-none w-full font-normal" />
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
							<a class="text-blueGray-700 hover:text-blueGray-500 text-xs uppercase py-3 font-bold block"
								href="{{ $link->slug }}{{ $realtime == false ? '.html' : '' }}">
								{{ $link->title }}
							</a>
						</li>
						@endif
						@endforeach
					</ul>

					<hr class="my-4 md:min-w-full" />

					<h6
						class="md:min-w-full text-blueGray-500 text-xs uppercase font-bold block pt-1 pb-4 no-underline">
						<a href="/">
							Back to App
						</a>
					</h6>

				</div>
			</div>
		</nav>
		<main class="relative md:ml-64 lg:ml-72 xl:pl-8 bg-blueGray-50">
			<article class="prose max-w-3xl m-4 mx-6 lg:mx-8 p-6">
				{!!
				// Print the Markdown HTML from the page object.
				// If this is a realtime request we replace the media path first.
				$realtime
				? str_replace('<img src="media/', '<img src=" /docs/media/', $page->markdown)
				: $page->markdown;
				!!}
			</article>
		</main>
	</div>


	<footer>
		@if(config('docgen.useTorchlight'))
		<small>
			Syntax highlighting by <a href="https://torchlight.dev/"
				rel="noopener noreferrer nofollow">Torchlight.dev</a>
		</small>
		@endif
	</footer>

	<script>
		// Move the dynamic table of contents to the sidebar
		let toc = document.querySelector('ul.table-of-contents');
		if (toc) {
			let destination = document.getElementById('sidebar-active');
			if (destination) {
				destination.insertAdjacentHTML('beforeend', toc.outerHTML);
				toc.remove();
			}
		}
	</script>


	<script type="text/javascript">
		/* Sidebar - Side navigation menu on mobile/responsive mode */
	function toggleNavbar(collapseID) {
		document.getElementById(collapseID).classList.toggle("hidden");
		document.getElementById(collapseID).classList.toggle("bg-white");
		document.getElementById(collapseID).classList.toggle("m-2");
		document.getElementById(collapseID).classList.toggle("py-3");
		document.getElementById(collapseID).classList.toggle("px-6");
	}
	</script>
</body>

</html>