<div class="paginator">
	@if ($page->previousPageUrl() != null)
	<div class="pull-left">
		<a href="{{ $page->previousPageUrl() }}">Prev</a>
	</div>
	@endif
	@if ($page->hasMorePages())
		<div class="pull-right">	
		<a href="{{ $page->nextPageUrl() }}">Next</a>
		</div>
	@endif
</div>