<?php
    $default=[
        'cover'=>false,
        'advice'=>false,
    ];
    $conf=array_merge($default,$conf);
?>

<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <title>{{$contest["name"]}}</title>
    <meta name="author" content="{{config('app.name')}}">
    <meta name="keywords" content="problemset,{{$contest["shortName"]}}">
</head>

<style>
    .pagenum:before {
        content: counter(page);
    }

    .header {
        position: fixed;
        top: -30px;
        left: 0px;
        right: 0px;
        border-bottom: 1px solid #000;
    }

    .footer {
        position: fixed;
        bottom: 0px;
        left: 0px;
        right: 0px;
        font-style: italic;
    }

    .footer > span:last-of-type{
        position: absolute;
        right: 0;
    }

    div.page-breaker {
        page-break-after: always;
    }

    body{
        font-size: 20px;
        font-family: "DejaVu Serif", serif;
    }

    h1,h2,h3,h4,h5,h6{
        font-family: "DejaVu Sans", sans-serif;
    }

    div.sample-container,
    img.sample-container{
        page-break-inside: avoid;
    }
</style>

<div class="header">Generated by NOJ - https://acm.njupt.edu.cn</div>
<div class="footer"><span>{{$contest["shortName"]}}</span> <span>Page <span class="pagenum"></span></span></div>

{{-- Cover Page --}}
@if($conf['cover']) @include('pdf.contest.cover',['contest'=>$contest,'problemset'=>$problemset]) @endif

{{-- Advice Page --}}
@if($conf['advice']) @include('pdf.contest.advice') @endif

{{-- ProblemSet --}}
@foreach ($problemset as $problem)

@include('pdf.contest.problem', ['problem'=>$problem])

@unless($loop->last)<div class="page-breaker"></div>@endunless

@endforeach

<script type="text/php">
    if (isset($pdf))
    {
        $pdf->add_info('Subject', "{{$contest["shortName"]}} ProblemSet");
        $pdf->add_info('Producer', "{{config('app.displayName')}}");
        $pdf->add_info('Creator', "{{config('app.name')}} Contest PDF Auto-Generater");
        $pdf->add_info('CreatorTool', "{{config('app.url')}}");
        $pdf->add_info('BaseURL', "{{route('contest.detail',['cid'=>$contest["cid"]])}}");
    }
</script>
