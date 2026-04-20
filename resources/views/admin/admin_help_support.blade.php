@extends('layouts.admin_layout')
@section('content')

<h4 class="mb-4">{{ __('messages.admin.help_support.title') }}</h4>

<h6 class="fw-bold">{{ __('messages.admin.help_support.system_guide_title') }}</h6>
<p>
    {{ __('messages.admin.help_support.system_guide_desc') }}
</p>
<h6 class="fw-bold mt-4">{{ __('messages.admin.help_support.faq_title') }}</h6>

<p><strong>{{ __('messages.admin.help_support.faq_q1') }}</strong><br>
{!! __('messages.admin.help_support.faq_a1') !!}</p>

<p><strong>{{ __('messages.admin.help_support.faq_q2') }}</strong><br>
{!! __('messages.admin.help_support.faq_a2') !!}</p>

<p><strong>{{ __('messages.admin.help_support.faq_q3') }}</strong><br>
{!! __('messages.admin.help_support.faq_a3') !!}</p>

<h6 class="fw-bold mt-4">{{ __('messages.admin.help_support.contact_title') }}</h6>

<p>
    {{ __('messages.admin.help_support.email') }}: geemaolivia@gmail.com<br>
    {{ __('messages.admin.help_support.phone') }}: +6019 835 5025<br>
    {{ __('messages.admin.help_support.office_hours') }}: {{ __('messages.admin.help_support.work_days') }} (9AM – 5PM)
</p>

@endsection