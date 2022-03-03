<div id="algolia-scripts">
    <!--
        To use Algolia you must enter your credentials.
        Remember to reference the environment variables through a config if you use caching
    -->

    <div id="docsearch" class="absolute top-4 right-4 z-10"></div>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3"/>
    <script src="https://cdn.jsdelivr.net/npm/@docsearch/js@3"></script>

    <script type="text/javascript">
        docsearch({
            appId: 'ALGOLIA_APP_ID',
            apiKey: 'ALGOLIA_API_KEY',
            indexName: 'ALGOLIA_INDEX_NAME',
            container: '#docsearch',
            debug: false // Set debug to true if you want to inspect the modal
        });
    </script>
</div>