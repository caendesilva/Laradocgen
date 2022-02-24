<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="theme-color" content="#000000" />
	<link rel="shortcut icon" href="./assets/img/favicon.ico" />
	<link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

	<!-- Untill we have something stable enough to warrant compiling the tailwind ourselves -->
	<link rel="stylesheet" href="https://unpkg.com/tailwindcss@1.4.6/dist/base.min.css">
	<link rel="stylesheet" href="https://unpkg.com/tailwindcss@1.4.6/dist/components.min.css">
	<link rel="stylesheet" href="https://unpkg.com/@tailwindcss/typography@0.1.2/dist/typography.min.css">
	<link rel="stylesheet" href="https://unpkg.com/tailwindcss@1.4.6/dist/utilities.min.css">

	<base href="{{ $rootRoute }}">

	<title>{{ $page->title }} | {{ config('app.name') }} Docs</title>

	<!-- Prevent FOUC -->
	<style> .prose .table-of-contents { display: none; } </style>

	<!-- Table of Contents -->
	<style>
		html {
			scroll-behavior: smooth;
		}
		.table-of-contents {
			list-style-type: "none";
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
		h6:hover .heading-permalink
		{
			opacity: 1;
			color: #6366f1;
		}
	</style>

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
</head>

<body class="text-blueGray-700 antialiased">
	<noscript>You need to enable JavaScript to run this app.</noscript>
	<div id="root">
		<nav
			class="md:left-0 md:block md:fixed md:top-0 md:bottom-0 md:overflow-y-auto md:flex-row md:flex-nowrap md:overflow-hidden shadow-xl bg-white flex flex-wrap items-center justify-between relative md:w-64 lg:w-72 z-10 py-4 px-6">
			<div
				class="md:flex-col md:items-stretch md:min-h-full md:flex-nowrap px-0 flex flex-wrap items-center justify-between w-full mx-auto">
				<button
					class="cursor-pointer text-black opacity-50 md:hidden px-3 py-1 text-xl leading-none bg-transparent rounded border border-solid border-transparent"
					type="button" onclick="toggleNavbar('example-collapse-sidebar')">
					<i class="fas fa-bars"></i></button>
				<a class="md:block text-left md:pb-2 text-blueGray-600 mr-0 inline-block  text-sm uppercase font-bold p-4 px-0"
					href="">
					{{ config('app.name') }} Docs
				</a>
				<ul class="md:hidden items-center flex flex-wrap list-none">
					<li class="inline-block relative">
						<a class="text-blueGray-500 block py-1 px-3" href="#pablo"
							onclick="openDropdown(event,'notification-dropdown')"><i class="fas fa-bell"></i></a>
						<div class="hidden bg-white text-base z-50 float-left py-2 list-none text-left rounded shadow-lg mt-1"
							style="min-width: 12rem;" id="notification-dropdown">
							<a href="#pablo"
								class="text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-blueGray-700">Action</a><a
								href="#pablo"
								class="text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-blueGray-700">Another
								action</a><a href="#pablo"
								class="text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-blueGray-700">Something
								else here</a>
							<div class="h-0 my-2 border border-solid border-blueGray-100"></div>
							<a href="#pablo"
								class="text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-blueGray-700">Seprated
								link</a>
						</div>
					</li>
					<li class="inline-block relative">
						<a class="text-blueGray-500 block" href="#pablo"
							onclick="openDropdown(event,'user-responsive-dropdown')">
							<div class="items-center flex">
								<span
									class="w-12 h-12 text-sm text-white bg-blueGray-200 inline-flex items-center justify-center rounded-full"><img
										alt="..." class="w-full rounded-full align-middle border-none shadow-lg"
										src="./assets/img/team-1-800x800.jpg" /></span>
							</div>
						</a>
						<div class="hidden bg-white text-base z-50 float-left py-2 list-none text-left rounded shadow-lg mt-1"
							style="min-width: 12rem;" id="user-responsive-dropdown">
							<a href="#pablo"
								class="text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-blueGray-700">Action</a><a
								href="#pablo"
								class="text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-blueGray-700">Another
								action</a><a href="#pablo"
								class="text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-blueGray-700">Something
								else here</a>
							<div class="h-0 my-2 border border-solid border-blueGray-100"></div>
							<a href="#pablo"
								class="text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-blueGray-700">Seprated
								link</a>
						</div>
					</li>
				</ul>
				<div class="md:flex md:flex-col md:items-stretch md:opacity-100 md:relative md:mt-4 md:shadow-none shadow absolute top-0 left-0 right-0 z-40 overflow-y-auto overflow-x-hidden h-auto items-center flex-1 rounded hidden"
					id="example-collapse-sidebar">
					<div class="md:min-w-full md:hidden block pb-4 mb-4 border-b border-solid border-blueGray-200">
						<div class="flex flex-wrap">
							<div class="w-6/12">
								<a class="md:block text-left md:pb-2 text-blueGray-600 mr-0 inline-block whitespace-nowrap text-sm uppercase font-bold p-4 px-0"
									href="javascript:void(0)">
									Tailwind Starter Kit
								</a>
							</div>
							<div class="w-6/12 flex justify-end">
								<button type="button"
									class="cursor-pointer text-black opacity-50 md:hidden px-3 py-1 text-xl leading-none bg-transparent rounded border border-solid border-transparent"
									onclick="toggleNavbar('example-collapse-sidebar')">
									<i class="fas fa-times"></i>
								</button>
							</div>
						</div>
					</div>
					<form class="mt-6 mb-4 md:hidden">
						<div class="mb-3 pt-0">
							<input type="text" placeholder="Search"
								class="border-0 px-3 py-2 h-12 border border-solid  border-blueGray-500 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-base leading-snug shadow-none outline-none focus:outline-none w-full font-normal" />
						</div>
					</form>
					
					<hr class="my-4 md:min-w-full" />

					<ul class="md:flex-col md:min-w-full flex flex-col list-none">
						@foreach ($links as $link)
							@if($link == $page->slug)
							<li id="sidebar-active" class="items-center">
								<a class="text-pink-500 hover:text-pink-600 text-xs uppercase py-3 font-bold block"
									href="{{ $link->slug }}">
									{{ $link->title }}
								</a>
							</li>
							@else
							<li class="items-center">
								<a class="text-blueGray-700 hover:text-blueGray-500 text-xs uppercase py-3 font-bold block"
									href="{{ $link->slug }}">
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
				{!! $page->markdown!!}
			</article>
		</main>
	</div>

	<script>
		let toc = document.querySelector('ul.table-of-contents');
		if (toc) {
			let destination = document.getElementById('sidebar-active');
			// toc.classList.add('prose');
			destination.insertAdjacentHTML('beforeend', toc.outerHTML);
			toc.remove();
		}
	</script>
	

	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" charset="utf-8"></script>
	<script src="https://unpkg.com/@popperjs/core@2.9.1/dist/umd/popper.min.js" charset="utf-8"></script>
	<script type="text/javascript">
		/* Sidebar - Side navigation menu on mobile/responsive mode */
	function toggleNavbar(collapseID) {
		document.getElementById(collapseID).classList.toggle("hidden");
		document.getElementById(collapseID).classList.toggle("bg-white");
		document.getElementById(collapseID).classList.toggle("m-2");
		document.getElementById(collapseID).classList.toggle("py-3");
		document.getElementById(collapseID).classList.toggle("px-6");
	}
	/* Function for dropdowns */
	function openDropdown(event, dropdownID) {
		let element = event.target;
		while (element.nodeName !== "A") {
			element = element.parentNode;
		}
		var popper = Popper.createPopper(element, document.getElementById(dropdownID), {
			placement: "bottom-end"
		});
		document.getElementById(dropdownID).classList.toggle("hidden");
		document.getElementById(dropdownID).classList.toggle("block");
	}
	
	
	(function() {
		/* Add current date to the footer */
		document.getElementById("javascript-date").innerHTML = new Date().getFullYear();
		/* Chart initialisations */
		/* Line Chart */
		var config = {
			type: "line",
			data: {
				labels: [
				"January",
				"February",
				"March",
				"April",
				"May",
				"June",
				"July"
				],
				datasets: [
				{
					label: new Date().getFullYear(),
					backgroundColor: "#4c51bf",
					borderColor: "#4c51bf",
					data: [65, 78, 66, 44, 56, 67, 75],
					fill: false
				},
				{
					label: new Date().getFullYear() - 1,
					fill: false,
					backgroundColor: "#ed64a6",
					borderColor: "#ed64a6",
					data: [40, 68, 86, 74, 56, 60, 87]
				}
				]
			},
			options: {
				maintainAspectRatio: false,
				responsive: true,
				title: {
					display: false,
					text: "Sales Charts",
					fontColor: "white"
				},
				legend: {
					labels: {
						fontColor: "white"
					},
					align: "end",
					position: "bottom"
				},
				tooltips: {
					mode: "index",
					intersect: false
				},
				hover: {
					mode: "nearest",
					intersect: true
				},
				scales: {
					xAxes: [
					{
						ticks: {
							fontColor: "rgba(255,255,255,.7)"
						},
						display: true,
						scaleLabel: {
							display: false,
							labelString: "Month",
							fontColor: "white"
						},
						gridLines: {
							display: false,
							borderDash: [2],
							borderDashOffset: [2],
							color: "rgba(33, 37, 41, 0.3)",
							zeroLineColor: "rgba(0, 0, 0, 0)",
							zeroLineBorderDash: [2],
							zeroLineBorderDashOffset: [2]
						}
					}
					],
					yAxes: [
					{
						ticks: {
							fontColor: "rgba(255,255,255,.7)"
						},
						display: true,
						scaleLabel: {
							display: false,
							labelString: "Value",
							fontColor: "white"
						},
						gridLines: {
							borderDash: [3],
							borderDashOffset: [3],
							drawBorder: false,
							color: "rgba(255, 255, 255, 0.15)",
							zeroLineColor: "rgba(33, 37, 41, 0)",
							zeroLineBorderDash: [2],
							zeroLineBorderDashOffset: [2]
						}
					}
					]
				}
			}
		};
		var ctx = document.getElementById("line-chart").getContext("2d");
		window.myLine = new Chart(ctx, config);
		
		/* Bar Chart */
		config = {
			type: "bar",
			data: {
				labels: [
				"January",
				"February",
				"March",
				"April",
				"May",
				"June",
				"July"
				],
				datasets: [
				{
					label: new Date().getFullYear(),
					backgroundColor: "#ed64a6",
					borderColor: "#ed64a6",
					data: [30, 78, 56, 34, 100, 45, 13],
					fill: false,
					barThickness: 8
				},
				{
					label: new Date().getFullYear() - 1,
					fill: false,
					backgroundColor: "#4c51bf",
					borderColor: "#4c51bf",
					data: [27, 68, 86, 74, 10, 4, 87],
					barThickness: 8
				}
				]
			},
			options: {
				maintainAspectRatio: false,
				responsive: true,
				title: {
					display: false,
					text: "Orders Chart"
				},
				tooltips: {
					mode: "index",
					intersect: false
				},
				hover: {
					mode: "nearest",
					intersect: true
				},
				legend: {
					labels: {
						fontColor: "rgba(0,0,0,.4)"
					},
					align: "end",
					position: "bottom"
				},
				scales: {
					xAxes: [
					{
						display: false,
						scaleLabel: {
							display: true,
							labelString: "Month"
						},
						gridLines: {
							borderDash: [2],
							borderDashOffset: [2],
							color: "rgba(33, 37, 41, 0.3)",
							zeroLineColor: "rgba(33, 37, 41, 0.3)",
							zeroLineBorderDash: [2],
							zeroLineBorderDashOffset: [2]
						}
					}
					],
					yAxes: [
					{
						display: true,
						scaleLabel: {
							display: false,
							labelString: "Value"
						},
						gridLines: {
							borderDash: [2],
							drawBorder: false,
							borderDashOffset: [2],
							color: "rgba(33, 37, 41, 0.2)",
							zeroLineColor: "rgba(33, 37, 41, 0.15)",
							zeroLineBorderDash: [2],
							zeroLineBorderDashOffset: [2]
						}
					}
					]
				}
			}
		};
		ctx = document.getElementById("bar-chart").getContext("2d");
		window.myBar = new Chart(ctx, config);
	})();
	</script>
</body>

</html>