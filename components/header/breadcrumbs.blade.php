@if(!is_front_page())
    <section class="pa-breadcrumb">
        <div class="container">
            <div class="row">
                <div class="col">
                    <ul class="list-inline py-2 my-1">
                        <li class="list-inline-item m-0"><a href="{{ bloginfo('url') }}"><i class="fas fa-home"></i></a></li>
                        <li class="list-inline-item m-0"><a href="">@php(new PaHeaderTitle('title'))</a></li>
                        <li class="list-inline-item m-0"><a href="">{{ the_title() }}</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
@endif