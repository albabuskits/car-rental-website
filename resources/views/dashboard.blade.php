@extends('layouts.admin')
@section('content')
<div class="text-center py-xl">
    <p class="text-on-surface-variant font-body-lg">مرحباً بك في لوحة تحكم عرب لتأجير السيارات</p>
    <a href="{{ route('admin.dashboard') }}" class="inline-block mt-md px-xl py-md bg-primary text-on-primary rounded-lg font-label-md">الانتقال إلى لوحة التحكم</a>
</div>
@endsection
