@php
    $facultyCourses = \App\Models\Faculties::where('id', $user->id)->get();
    $courses = \App\Models\Courses::all();
    $faculty = \App\Models\Faculties::where('id', $user->id)->first();
    $page = request('page');
    if (!$page) {
        $page = 1;
    }
@endphp

<x-layout :header=true :footer=true>
    {{-- check for any session variable message --}}
    <x-alert type="info" />
    <div class="flex flex-wrap justify-center">
        <div class="w-5/6 xl:w-4/6 py-4">
            <section class="lg:pt-6">
                <div class="lg:px-8 sm:px-6 px-4 max-w-7xl mx-auto">
                    <div class="md:mt-12 shadow-xl bg-base-100 rounded-xl overflow-hidden max-w-6xl mt-8 mx-auto">
                        <div class="p-6">
                            <div class="flex">
                                <div class="self-center">
                                    <img class="object-cover h-auto mx-auto rounded-xl w-52 sm:mx-0"
                                        src="https://api.dicebear.com/5.x/bottts-neutral/svg?seed={{ md5($user->id . $user->created_at) }}&scale=110"
                                        alt="{{ $user->name }}" />
                                    <div class="mt-5"></div>
                                </div>
                                <div class="mt-6 sm:ml-8 sm:mt-0">
                                    <p class="text-sm font-medium text-base-content">{{ $user->university_id }}</p>
                                    <p class="text-2xl font-bold text-base-content">
                                        {{ $user->name }}
                                    </p>
                                    @if ($user->role == 'faculty')
                                        <x-average-stars :faculty="$faculty" />
                                        <x-faculty-courses :facultyCourses="$facultyCourses" :courses="$courses" />
                                    @endif
                                    <p class="mt-2 text-xs font-bold uppercase tracking-wide text-base-content/70">
                                        Email:
                                    </p>
                                    <p class="mt-1 text-xs font-medium uppercase tracking-wide text-base-content/70">
                                        {{ $user->email }}
                                    </p>

                                    <p class="mt-2 text-xs font-bold uppercase tracking-wide text-base-content/70">
                                        Department:
                                    </p>
                                    <p class="mt-1 text-xs font-medium uppercase tracking-wide text-base-content/70">
                                        {{ $user->department }}
                                    </p>
                                </div>
                                <div class="ml-auto mr-4">
                                    <label for="my-modal-4"
                                        class="box-border relative z-30 inline-flex items-center justify-center w-auto px-3 py-2 overflow-hidden font-bold text-base-100 transition-all duration-300 bg-primary rounded-md cursor-pointer group ring-offset-2 ring-1 ring-primary/30 ring-offset-primary/20 hover:ring-offset-primary/50 ease focus:outline-none">
                                        <span
                                            class="absolute bottom-0 right-0 w-8 h-20 -mb-8 -mr-5 transition-all duration-300 ease-out transform rotate-45 translate-x-1 bg-base-100 opacity-10 group-hover:translate-x-0"></span>
                                        <span
                                            class="absolute top-0 left-0 w-20 h-8 -mt-1 -ml-12 transition-all duration-300 ease-out transform -rotate-45 -translate-x-1 bg-base-100 opacity-10 group-hover:translate-x-0"></span>
                                        <span class="relative z-20 flex items-center text-sm">
                                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                stroke-width="1.5" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z">
                                                </path>
                                            </svg>
                                            <span class="ml-2 hidden md:block">Consult</span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- end of main content -->
            <!-- start of review content -->
            <section class="pb-6">
                <div class="lg:px-8 sm:px-6 px-4 max-w-7xl mx-auto">
                    <div
                        class="px-3 sm:px-6 py-12 md:mt-12 shadow-xl bg-base-100 rounded-xl overflow-hidden max-w-6xl mt-8 mx-auto">
                        <div class="max-w-3xl mx-auto">
                            @if ($user->role == 'faculty')
                                <x-review-summary :faculty="$faculty" />
                            @endif
                            <hr class="mt-10 border-base-300" />
                            <div class="flow-root mt-10">
                                {{-- Review Box --}}
                                @php
                                    if ($user->role == 'faculty') {
                                        $reviews = \App\Models\Reviews::where('faculty_id', $faculty->id)
                                            ->where('isApproved', 1)
                                            ->orderBy('created_at', 'desc')
                                            ->paginate(5);
                                    } elseif ($user->role == 'student') {
                                        $reviews = \App\Models\Reviews::where('user_id', $user->id)
                                            ->where('isApproved', 1)
                                            ->where('isAnonymous', 0)
                                            ->orderBy('created_at', 'desc')
                                            ->paginate(5);
                                    }
                                @endphp
                                @if ($user->role == 'faculty')
                                    @if ($reviews->count() == 0)
                                        <div class="alert alert-info" role="alert">
                                            No reviews yet! Be the first to review.
                                        </div>
                                    @else
                                        <ul class="divide-y divide-base-300 -my-9 gap-x-16">
                                            @foreach ($reviews as $review)
                                                <x-review-box :review="$review" :role="$user->role" />
                                            @endforeach
                                        </ul>
                                    @endif
                                @elseif ($user->role == 'student')
                                    @if ($reviews->count() == 0)
                                        <div class="alert alert-info" role="alert">
                                            No reviews yet! Be the first to review.
                                        </div>
                                    @else
                                        <ul class="divide-y divide-base-300 -my-9 gap-x-16">
                                            @foreach ($reviews as $review)
                                                <x-review-box :review="$review" :role="$user->role" />
                                            @endforeach
                                        </ul>
                                    @endif
                                @endif
                                <!-- End review-box -->
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- end of review content -->
        </div>
        {{-- if the user role is faculty --}}
        @if ($user->role == 'faculty')
            <div class="w-5/6 xl:w-2/6 py-4">
                <!-- Start of Give Review -->
                <section class="lg:pt-6">
                    <div class="lg:px-8 sm:px-6 px-4 max-w-7xl mx-auto">
                        <div
                            class="px-3 sm:px-6 py-12 md:mt-12 shadow-xl bg-base-100 rounded-xl overflow-hidden max-w-6xl mt-8 mx-auto">
                            <div class="px-3 pt-4 sm:pt-2">
                                <h3 class="text-2xl font-semibold text-center text-base-content">
                                    Drop a Review
                                </h3>

                                <form action="/" method="GET" class="mt-10">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
                                        <div class="lg:col-span-2 2xl:col-span-1">
                                            <label for="" class="text-base font-medium text-base-content">
                                                Course Name
                                            </label>
                                            <div class="mt-2.5 relative">
                                                <!-- course dropdown 1,23,34 -->
                                                <select name="course" id="course"
                                                    class="block w-full px-4 py-4 text-base-content placeholder-base-content/40 transition-all duration-200 bg-base-100 border border-base-300 rounded-md focus:outline-none focus:border-primary caret-primary">
                                                    {{-- get the courses of faculty --}}
                                                    <option value="0" selected disabled>Select a course</option>
                                                    @foreach ($facultyCourses as $facultycourse)
                                                        @php
                                                            $xcourses = explode(',', $facultycourse->courses);
                                                        @endphp
                                                        @foreach ($xcourses as $facultycoursex)
                                                            @foreach ($courses as $course)
                                                                @if ($course->id == $facultycoursex)
                                                                    <option value="{{ $course->id }}">
                                                                        {{ $course->course_code }}
                                                                    </option>
                                                                @endif
                                                            @endforeach
                                                        @endforeach
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="lg:col-span-2 2xl:col-span-1">
                                            <label for="" class="text-base font-medium text-base-content">
                                                Rating
                                            </label>
                                            <div class="mt-2.5 relative">
                                                <!-- half star rating radio input  -->

                                                <div class="rating rating-lg">
                                                    <input type="radio" name="rating" value="0"
                                                        class="bg-warning mask mask-star-2" checked disabled hidden />
                                                    <input type="radio" name="rating" value="1"
                                                        class="bg-warning mask mask-star-2" />
                                                    <input type="radio" name="rating" value="2"
                                                        class="bg-warning mask mask-star-2" />
                                                    <input type="radio" name="rating" value="3"
                                                        class="bg-warning mask mask-star-2" />
                                                    <input type="radio" name="rating" value="4"
                                                        class="bg-warning mask mask-star-2" />
                                                    <input type="radio" name="rating" value="5"
                                                        class="bg-warning mask mask-star-2" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="sm:col-span-2">
                                            <label for="" class="text-base font-medium text-base-content">
                                                Review
                                            </label>
                                            <div class="mt-2.5 relative">
                                                <textarea name="review" id="review" placeholder=""
                                                    class="block w-full px-4 py-4 text-base-content placeholder-base-content/40 transition-all duration-200 bg-base-100 border border-base-300 rounded-md resize-y focus:outline-none focus:border-primary caret-primary"
                                                    rows="4"></textarea>
                                            </div>
                                        </div>

                                        <div class="sm:col-span-2">
                                            <button type="submit"
                                                class="inline-flex items-center justify-center w-full px-4 py-4 mt-2 text-base font-semibold text-base-100 transition-all duration-200 bg-primary border border-transparent rounded-md focus:outline-none hover:bg-primary focus:bg-primary">
                                                Submit
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- End of Give Review -->
            </div>
        @endif
    </div>
    <input type="checkbox" id="my-modal-4" class="modal-toggle" />
    <label for="my-modal-4" class="modal cursor-pointer">
        <label class="modal-box px-4 mx-auto sm:px-6 lg:px-8 max-w-5xl" for="">
            {{-- <section class="py-12 bg-base-100/50 sm:py-16 lg:py-20"> --}}
            <div class="px-2 mx-auto sm:px-4 lg:px-6 max-w-7xl">
                <div class="flex items-center justify-center">
                    <h1 class="text-2xl font-bold text-base-content/80 uppercase">
                        Schedule A Consultation
                    </h1>
                </div>

                <div class="max-w-4xl mx-auto mt-8 md:mt-12">
                    <div class="overflow-hidden bg-base-100/40 shadow rounded-xl">
                        <form action="#">
                            <div class="grid grid-cols-1 md:grid-cols-2">
                                <div class="px-5 py-6 bg-base-200/60 md:px-8">
                                    <div class="flow-root">
                                        <ul class="divide-y divide-base-200 -my-7">
                                            <li class="flex items-stretch justify-between space-x-5 py-7">
                                                <div class="flex items-stretch flex-1">
                                                    <div class="flex-shrink-0">
                                                        <img class="w-20 h-20 border border-base-200 rounded-lg"
                                                            src="https://api.dicebear.com/5.x/bottts-neutral/svg?seed={{ md5($user->id . $user->created_at) }}&scale=110"
                                                            alt="{{ $user->name }}" />
                                                    </div>

                                                    <div class="flex flex-col justify-between ml-5">
                                                        <div class="flex-1">
                                                            <p class="text-sm font-bold text-base-content">
                                                                {{ $user->name }}
                                                            </p>
                                                            <p class="mt-1.5 text-sm font-medium text-base-content/50 lowercase">
                                                                {{ $user->email }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="flex flex-col items-end justify-between ml-auto">
                                                    <p class="text-sm font-bold text-right text-base-content">
                                                        {{ $user->university_id }}
                                                    </p>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>

                                    <hr class="mt-6 border-base-200" />

                                    <div
                                        class="sm:flex sm:space-x-2.5 md:flex-col lg:flex-row md:space-x-0 lg:space-x-2.5">
                                        <div class="flex-grow">
                                            <textarea name="message" id="message" cols="30" rows="10" placeholder="Enter the Message"
                                                class="textarea block w-full px-4 py-3 text-md font-normal text-base-content placeholder-base-content/50 bg-base-100 border border-base-200 rounded-md caret-base-content focus:ring-base-content focus:border-base-content"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="px-5 py-6 md:px-8">
                                    <div class="flow-root">
                                        <div class="-my-6 divide-y divide-base-200">
                                            <div class="py-6">
                                                <h2 class="font-bold text-base-content/90 text-base">
                                                    Student Information
                                                </h2>

                                                <div class="space-y-3">
                                                    <div>
                                                        <label for=""
                                                            class="text-sm font-medium text-base-content/80">
                                                            Student Name
                                                        </label>
                                                        <div class="mt-1">
                                                            <input type="text" name="studentName" id="studentName" value="{{ Auth::user()->name }}" readonly
                                                                class="block w-full px-4 py-3 text-sm font-normal text-base-content placeholder-base-content/50 border border-base-200 rounded-md bg-base-100/50 caret-base-content focus:ring-base-content focus:border-base-content" />
                                                        </div>
                                                    </div>

                                                    <div>
                                                        <label for=""
                                                            class="text-sm font-medium text-base-content/80">
                                                            Student ID
                                                        </label>
                                                        <div class="mt-1">
                                                            <input type="text" name="studentId" id="studentId" value="{{ Auth::user()->university_id }}" readonly
                                                                class="block w-full px-4 py-3 text-sm font-normal text-base-content placeholder-base-content/50 border border-base-200 rounded-md bg-base-100/50 caret-base-content focus:ring-base-content focus:border-base-content" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="pt-2 pb-4">
                                                <h2 class="font-bold text-base-content/90 text-base">
                                                    Time & Date
                                                </h2>

                                                <div class="space-y-3">
                                                    <div>
                                                        <label for=""
                                                            class="text-sm font-medium text-base-content/80">
                                                            Date
                                                        </label>
                                                        <div class="mt-1">
                                                            <input
                                                                class="block w-full px-4 py-3 text-sm font-normal text-base-content placeholder-base-content/50 border border-base-200 rounded-md bg-base-100/50 caret-base-content focus:ring-base-content focus:border-base-content"
                                                                name="date" id="date" type="text" />
                                                            <script>
                                                                // check how many days left in this month
                                                                var daysInMonth = new Date(
                                                                    new Date().getFullYear(),
                                                                    new Date().getMonth() + 1,
                                                                    0,
                                                                ).getDate()
                                                                daysInMonth = daysInMonth - new Date().getDate()
                                                                $('#date').flatpickr({
                                                                    minDate: 'today',
                                                                    maxDate: new Date().fp_incr(daysInMonth),
                                                                    disable: [
                                                                        function(date) {
                                                                            var disabledDates = [13, 16, 19, 21, 25]
                                                                            return (
                                                                                date.getDay() === 5 ||
                                                                                date.getDay() === 6 ||
                                                                                disabledDates.includes(date.getDate())
                                                                            )
                                                                        },
                                                                    ],
                                                                })
                                                            </script>
                                                        </div>
                                                    </div>

                                                    <div>
                                                        <label for=""
                                                            class="text-sm font-medium text-base-content/80">
                                                            Time
                                                        </label>
                                                        <div class="mt-1">
                                                            <input type="text" name="time" id="time"
                                                                class="block w-full px-4 py-3 text-sm font-normal text-base-content placeholder-base-content/50 border border-base-200 rounded-md bg-base-100/50 caret-base-content focus:ring-base-content focus:border-base-content" />
                                                        </div>
                                                        <script>
                                                            $('#time').flatpickr({
                                                                // only time picker
                                                                enableTime: true,
                                                                noCalendar: true,
                                                                dateFormat: 'H:i',
                                                                // office time only
                                                                minTime: '09:00',
                                                                maxTime: '17:00',
                                                            })
                                                        </script>
                                                    </div>

                                                    <div>
                                                        <button type="submit"
                                                            class="inline-flex items-center justify-center w-full px-6 py-4 text-sm font-bold text-base-100 transition-all duration-200 bg-base-content border border-transparent rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-base-content hover:bg-base-content/70">
                                                            Continue to Next
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- </section> --}}
        </label>
    </label>
</x-layout>
