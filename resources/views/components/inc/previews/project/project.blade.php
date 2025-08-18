<a href="{{$link}}" class="project__item">
    <x-inc.previews.project.user  :name="$nameAuthor" :posted="$posted" />
    <x-inc.previews.project.body :category="$category"  :name="$name" content="{!! $content !!}"  :country="$country" :price="$price" :expiry="$expiry" :proposals="$proposals" :job="$job" />
</a>
