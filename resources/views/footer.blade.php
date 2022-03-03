	<footer class="md:ml-64 lg:ml-72 xl:pl-8 py-2 bg-slate-100 dark:bg-slate-900 dark:text-gray-100">
		<div class="max-w-3xl mx-4 lg:mx-8 p-2">
			<div class="px-2 my-1">
				<small>
					This site was generated using the free and open-source
					<a class="text-indigo-700 dark:text-indigo-400" 
						href="https://github.com/desilva/laradocgen/">Laradocgen package</a>.
					License MIT.
				</small>
			</div>
			
			@if(config('laradocgen.useTorchlight')) 
			<small class="px-2 my-1 whitespace-nowrap opacity-75">
				Syntax highlighting by
				<a class="text-indigo-700 dark:text-indigo-400"
					href="https://torchlight.dev/"
					rel="noopener noreferrer nofollow">Torchlight.dev</a>
			</small>
			@endif 
			@if(config('laradocgen.copyright.enabled', false)) 
			<small class="px-2 my-1 whitespace-nowrap opacity-75">
				Documentation Copyright:
				<a class="text-indigo-700 dark:text-indigo-400"
					href="{{ config('laradocgen.copyright.licenseUri') }}"
					rel="noopener noreferrer nofollow license">
					{{ config('laradocgen.copyright.licenseName') }}
				</a>
			</small>
			@endif 
		</div>
	</footer>