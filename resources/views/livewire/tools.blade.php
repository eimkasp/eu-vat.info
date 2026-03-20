@section('seo')
    <x-seo-meta
        :title="__('ui.tools.seo_title')"
        :description="__('ui.tools.seo_description')"
        :url="url()->current()"
    />
@endsection

<div class="container">
    <h1>{{ __('ui.tools.heading') }}</h1>

    <p>
        {{ __('ui.tools.intro_text') }}
    </p>

    <div class="tools">
        <h2>{{ __('ui.tools.calculator_heading') }}</h2>
        <p>
            {{ __('ui.tools.calculator_description') }}
        </p>
    </div>
</div>
