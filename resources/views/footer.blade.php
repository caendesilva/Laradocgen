<footer class="md:ml-64 lg:ml-72 xl:pl-8 py-2 bg-slate-100 dark:bg-slate-900 dark:text-gray-100">
	<div class="max-w-3xl mx-4 lg:mx-8 p-2">
		<small class="mx-2 my-1">
			This site was generated using the free and open source 
			<a class="text-indigo-700 dark:text-indigo-400" href="https://github.com/desilva/laradocgen/">
				Laradocgen
			</a> package.
			License MIT.
		</small>
		@if(config('laradocgen.useTorchlight'))
		<small class="mx-2 my-1 whitespace-nowrap opacity-75">
			Syntax highlighting by <a class="text-indigo-700 dark:text-indigo-400" href="https://torchlight.dev/"
				rel="noopener noreferrer nofollow">Torchlight.dev</a>
		</small>
		@endif
	</div>
</footer>