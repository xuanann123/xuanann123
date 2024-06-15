{{-- Dữ liệu nhận được như là đối tượng của menu con đó => đi duyệt ra thì lại nhật được dữ liệu như này --}}
@foreach ($subcatalogues as $sub)
    <option @if ( isset($catalogue) && $catalogue->parent_id == $sub->id)
        selected
    @endif   @if ( isset($product->catalogue) && $product->catalogue->id == $sub->id)
        selected
    @endif  value="{{ $sub->id }}"> {{ $level }} {{ $sub->name }}</option>
    @if (count($sub->childrenRecursive) > 0)
    @php
         $incr_level = $level."--";
    @endphp
        @include('admin.layouts.submenu', [
            'subcatalogues' => $sub->childrenRecursive,
            'level' => $incr_level,
        ])
    @endif
@endforeach