<div class="projects__item">
    <x-inc.previews.project.user :photo="$photo" :name="$name" type="{!! $type !!}"/>
    <x-inc.previews.project.body content="{!! $content !!}" :posted="$posted" :country="$country" :price="$price" :expiry="$expiry" :proposals="$proposals" :job="$job" />
    <x-inc.previews.footer  :link="$link" />
</div>
