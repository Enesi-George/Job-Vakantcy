@props(['requirementCsv'])


@php
    $requirements = explode('.', $requirementCsv);
@endphp
<ul class=" mx-8">
    @foreach ( $requirements as $requirement  )
        
    <li
        class="text-left my-1 text-lg list-disc"
    >
        <a href="/?requirement={{$requirement}}">{{$requirement}}</a>
    </li>
    @endforeach

</ul>