@props(['faculty' => $faculty])
{{-- add \App\Models\Faculties::all() --}}
@php
    $courses = \App\Models\Courses::all();
    $user = \App\Models\User::where('id', $faculty->user_id)->get();
    $faculty = $user[0];
    $facultyCourses = \App\Models\Faculties::where('user_id', $faculty->id)->get();
@endphp

<div class="strip_list wow fadeIn">
    <figure>
        <a href="/profile/{{ $faculty->id }}">
            <img src="https://api.dicebear.com/5.x/bottts-neutral/svg?seed={{ md5($faculty->id . $faculty->created_at) }}&rotate=20&scale=110"
                alt="{{ $faculty->id . $faculty->created_at }}" />
        </a>
    </figure>
    <small>{{ $faculty->university_id }}</small>
    <a href="/profile/{{ $faculty->id }}">
        <h3>{{ $faculty->name }}</h3>
    </a>
    <p>
        <b>Email:</b> {{ $faculty->email }} <br />
        <b>Created at:</b> {{ $faculty->created_at }}
    </p>

    <span>
        <x-faculty-courses :facultyCourses="$facultyCourses" :courses="$courses" />
    </span>

    <span style="font-weight: 400; margin-left: 8px; margin-right: 8px; color: #ccc; user-select: none;">|</span>
    <span class="rating">
        <i class="icon_star voted"></i>
        <i class="icon_star voted"></i>
        <i class="icon_star voted"></i>
        <i class="icon_star"></i>
        <i class="icon_star"></i>
        <small>(145)</small>
    </span>
    <ul>
        <li>
            <a href="#0" class="btn_listing">View Profile</a>
        </li>
        <li>
            <b>{{ $faculty->department }}</b>
        </li>
        <li><a href="detail-page.html">Book Consultation</a></li>
    </ul>
</div>
