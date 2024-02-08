<a {{$attribute ?? ''}} href="{{$href ?? ''}}" class="btn btn-{{$color}} btn-dev {{$class ?? ''}}">
	{{$title}}
</a>

@push('css')
<style>
.btn-dev {
	padding: 12px 26px;
	font-weight: 600;
	font-size: 16px;
	width: fit-content;
}
</style>
@endPush