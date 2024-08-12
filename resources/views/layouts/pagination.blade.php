@if ($paginator->hasPages())
    <div wire:loading.remove>
        <div class="row mt-3">
            <div class="col-lg-6 text-lg-start text-center mb-lg-0 mb-3">
                <span>
                    Showing
                    {{ $paginator->firstItem() }}
                    to {{ $paginator->lastItem() }}
                    of {{ $paginator->total() }}
                    entries
                </span>
            </div>
            <div class="col-lg-6">
                <div class="btn-toolbar justify-content-lg-end justify-content-center" role="toolbar">
                    <div class="btn-group me-2" role="group">
                        @if ($paginator->onFirstPage())
                            <button type="button" class="btn btn-primary disabled">
                                <i class="bi bi-chevron-left"></i>
                            </button>
                        @else
                            <a type="button" class="btn btn-outline-primary"
                                wire:click="setPage('{{ $paginator->previousPageUrl() }}')">
                                <i class="bi bi-chevron-left"></i>
                            </a>
                        @endif
                        @foreach ($elements as $element)
                            @if (is_string($element))
                                <button type="button" class="btn btn-primary">
                                    {{ $element }}
                                </button>
                            @endif
                            @if (is_array($element))
                                @foreach ($element as $page => $url)
                                    @if ($page == $paginator->currentPage())
                                        <button type="button" class="btn btn-primary">
                                            {{ $page }}
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-outline-primary"
                                            wire:click="setPage('{{ $url }}')">
                                            {{ $page }}
                                        </button>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                        @if ($paginator->hasMorePages())
                            <a type="button" class="btn btn-outline-primary"
                                wire:click="setPage('{{ $paginator->nextPageUrl() }}')">
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        @else
                            <button type="button" class="btn btn-primary disabled">
                                <i class="bi bi-chevron-right"></i>
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
