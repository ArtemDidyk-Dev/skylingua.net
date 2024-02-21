<a href="{{$link}}" class="project__item">
    <x-inc.previews.developer.user  :name="$name" :posted="$data" />
    <x-inc.previews.developer.body :category="$position"  content="{!! $content !!}" :subTitle="$subTitle"    :price="$price"  />
</a>
