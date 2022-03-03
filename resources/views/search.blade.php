<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = {
	darkMode: 'class',
  }
</script>

<style>
	#searchresult a {
		margin: 0.25rem 0;
	}
	#searchresult {
		display: none;
	}
	#searchresult.hasresults, #searchresult.noresult {
		display: block;
	}
	#searchresult.hasresults::before {
		content: "Search results:";
		position: relative;
		opacity: 0.75;
		width: 100%;
		float: left;
		margin-bottom: 4px;
	}
	#searchresult.noresult::before {
		content: "No results found!";
		position: relative;
		opacity: 0.75;
		width: 100%;
		float: left;
	}
</style>

<!-- The search component is very crude and is very much work in progress. It is not yet accessible. -->

<form class="lg:fixed top-8 right-8 my-3 md:mb-1 lg:my-0 ">
	<input id="searchfield" type="search" class="w-full px-3 bg-gray-100 dark:bg-gray-800 py-2 text-sm text-gray-800 overflow-visible dark:text-gray-100 rounded-lg focus:outline-none focus:ring-2 opacity-9 focus:opacity-100 hover:opacity-100 transition-opacity peer "
	placeholder="Search" title="Search in the documentation">
	<div id="searchresult" class="w-full absolute rounded-lg bg-gray-50 dark:bg-gray-700 z-10 text-gray-800 dark:text-gray-100  shadow mt-2 px-3 py-2 text-sm text-dark opacity-0 peer-focus:opacity-100 transition-opacity">
	</div>
</form>

<script>
const url = "/docs/searchindex.json";
function getData(url, cb) {
  fetch(url)
    .then(response => response.json())
    .then(result => cb(result));
}

var xhReq = new XMLHttpRequest();
xhReq.open("GET", url, false);
xhReq.send(null);
var srcData = JSON.parse(xhReq.responseText);

document.getElementById('searchfield').addEventListener('keyup', function(){
  let pattern = new RegExp(this.value, 'i');
  let resultSet = srcData.filter(item => item.body.match(pattern) && this.value != '').map(item => `<a href="${item.url}">${item.title}</a>`).join('<br> ');

  document.getElementById('searchresult').innerHTML = resultSet;

  if (resultSet.length == 0) {
	document.getElementById('searchresult').classList.add('noresult');
	document.getElementById('searchresult').classList.remove('hasresults');
  } else {
	document.getElementById('searchresult').classList.remove('noresult');
	document.getElementById('searchresult').classList.add('hasresults');
  }
  if (document.getElementById('searchfield').value == '') {
	document.getElementById('searchresult').classList.remove('noresult');
	document.getElementById('searchresult').classList.remove('hasresults');
	  
  }
});

</script>