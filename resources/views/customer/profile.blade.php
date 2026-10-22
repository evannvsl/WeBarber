@extends('layouts.app')
@section('title', 'WeBarber | Profile')

@section('content')

<div class="min-h-screen bg-[#f5f5f7] text-[#1d1d1f]">

    {{-- Page Heading --}}
    <section class="border-b border-[#d2d2d7] bg-white">
        <div class="mx-auto max-w-6xl px-6 py-12 md:px-10 md:py-16">
            <p class="mb-3 text-xs font-semibold uppercase tracking-[0.2em] text-[#86868b]">
                ACCOUNT
            </p>

            <h1 class="text-4xl font-semibold tracking-tight md:text-5xl">
                Your profile<span class="text-[#b8a060]">.</span>
            </h1>

            <p class="mt-4 max-w-lg text-sm leading-6 text-[#6e6e73]">
                Your details, your preferences, your WeBarber account.
            </p>
        </div>
    </section>

    <main class="mx-auto max-w-6xl px-5 py-8 md:px-10 md:py-12">

        {{-- Notifications --}}
        @if(session('success'))
            <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-sm text-green-800">
                ✓ {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700">
                <p class="mb-2 font-semibold">Please check your information.</p>
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        {{-- User Profile Card --}}
        <section class="mb-8 overflow-hidden rounded-2xl border border-[#dedee2] bg-white">

            <div class="h-1 bg-[#b8a060]"></div>

            <div class="flex flex-col items-center gap-6 p-6 sm:flex-row sm:items-center sm:p-9">

                {{-- Avatar --}}
                <div class="flex shrink-0 flex-col items-center gap-3">
                    <div class="h-28 w-28 overflow-hidden rounded-full border border-[#e5e5e5] bg-[#eeeeef]">
                        @if($user->profile_photo_path)
                            <img
                                src="{{ asset('storage/' . $user->profile_photo_path) }}"
                                alt="Foto profil {{ $user->name }}"
                                class="block h-full w-full object-cover"
                            >
                        @else
                            <div class="flex h-full w-full items-center justify-center bg-[#1d1d1f] text-4xl font-medium text-white">
                                {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                            </div>
                        @endif
                    </div>

                    <!-- <span class="text-xs text-[#86868b]">Profile Photo</span> -->
                </div>

                {{-- User Details --}}
                <div class="min-w-0 flex-1 text-center sm:text-left">
                    <p class="mb-2 text-xs font-semibold uppercase tracking-[0.15em] text-[#b8a060]">
                        YOUR ACCOUNT
                    </p>

                    <h2 class="break-words text-2xl font-semibold tracking-tight md:text-3xl">
                        {{ $user->name }}
                    </h2>

                    <p class="mt-2 break-all text-sm text-[#6e6e73]">
                        {{ $user->email }}
                    </p>

                    <div class="mt-4 inline-flex rounded-full bg-[#f5f5f7] px-3 py-1.5 text-xs font-medium text-[#555]">
                        {{ ucfirst($user->role ?? 'customer') }} Account
                    </div>
                </div>

                <div class="hidden text-right sm:block">
                    <p class="text-xs text-[#86868b]">Member since</p>
                    <p class="mt-1 text-sm font-medium">
                        {{ $user->created_at?->format('d M Y') ?? 'WeBarber Member' }}
                    </p>
                </div>

            </div>
        </section>

        {{-- Content Layout --}}
        <div class="grid grid-cols-1 items-start gap-8 lg:grid-cols-[1.15fr_0.85fr]">

            {{-- Personal Information --}}
            <section class="rounded-2xl border border-[#dedee2] bg-white">

                <div class="border-b border-[#eeeeef] px-6 py-6 md:px-8">
                    <h3 class="text-lg font-semibold">Personal Information</h3>
                    <p class="mt-1 text-sm text-[#86868b]">
                        Edit your personal details below.
                    </p>
                </div>

                <form
                    method="POST"
                    action="{{ route('customer.profile.update') }}"
                    enctype="multipart/form-data"
                    class="space-y-5 p-6 md:p-8"
                >
                    @csrf
                    @method('PUT')

                    {{-- Photo Upload --}}
                    <div>
                        <label for="profile_photo" class="mb-2 block text-sm font-medium">
                            Profile Photo
                        </label>

                        <input
                            type="file"
                            id="profile_photo"
                            name="profile_photo"
                            accept="image/jpeg,image/png,image/webp"
                            class="block w-full text-sm text-[#6e6e73] file:mr-4 file:rounded-full file:border-0 file:bg-[#f5f5f7] file:px-4 file:py-2.5 file:text-sm file:font-medium file:text-[#1d1d1f] hover:file:bg-[#e8e8ed]"
                        >

                        <p class="mt-2 text-xs text-[#86868b]">
                            JPG, PNG or WebP. Maximum 2 MB.
                        </p>
                    </div>

                    {{-- Name --}}
                    <div>
                        <label for="name" class="mb-2 block text-sm font-medium">
                            Full Name
                        </label>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name', $user->name) }}"
                            required
                            autocomplete="name"
                            class="w-full rounded-xl border border-[#d2d2d7] bg-white px-4 py-3 text-sm outline-none transition focus:border-[#1d1d1f] focus:ring-2 focus:ring-[#1d1d1f]/5"
                            placeholder="Your full name"
                        >
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email" class="mb-2 block text-sm font-medium">
                            Email Address
                        </label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email', $user->email) }}"
                            required
                            autocomplete="email"
                            class="w-full rounded-xl border border-[#d2d2d7] bg-white px-4 py-3 text-sm outline-none transition focus:border-[#1d1d1f] focus:ring-2 focus:ring-[#1d1d1f]/5"
                            placeholder="you@example.com"
                        >
                    </div>

                    {{-- Phone --}}
                    <div>
                        <label for="phone" class="mb-2 block text-sm font-medium">
                            Phone Number
                        </label>

                        <input
                            type="tel"
                            id="phone"
                            name="phone"
                            value="{{ old('phone', $user->phone) }}"
                            autocomplete="tel"
                            class="w-full rounded-xl border border-[#d2d2d7] bg-white px-4 py-3 text-sm outline-none transition focus:border-[#1d1d1f] focus:ring-2 focus:ring-[#1d1d1f]/5"
                            placeholder="08xxxxxxxxxx"
                        >
                    </div>

                    <div class="border-t border-[#eeeeef] pt-5">
                        <button
                            type="submit"
                            class="inline-flex w-full items-center justify-center gap-2 rounded-full bg-[#1d1d1f] px-6 py-3.5 text-sm font-medium text-white transition hover:bg-[#3a3a3c] sm:w-auto"
                        >
                            Save Changes <span>→</span>
                        </button>
                    </div>

                </form>
            </section>

            {{-- Account Settings --}}
            <div class="space-y-8">

                {{-- Password --}}
                <section class="rounded-2xl border border-[#dedee2] bg-white">

                    <div class="border-b border-[#eeeeef] px-6 py-6">
                        <h3 class="text-lg font-semibold">Password & Security</h3>
                        <p class="mt-1 text-sm text-[#86868b]">
                            Keep your account protected.
                        </p>
                    </div>

                    <form
                        method="POST"
                        action="{{ route('customer.profile.password') }}"
                        class="space-y-5 p-6"
                    >
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="current_password" class="mb-2 block text-sm font-medium">
                                Current Password
                            </label>
                            <input
                                type="password"
                                id="current_password"
                                name="current_password"
                                required
                                autocomplete="current-password"
                                class="w-full rounded-xl border border-[#d2d2d7] px-4 py-3 text-sm outline-none focus:border-[#1d1d1f]"
                                placeholder="Current password"
                            >
                        </div>

                        <div>
                            <label for="password" class="mb-2 block text-sm font-medium">
                                New Password
                            </label>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                required
                                autocomplete="new-password"
                                class="w-full rounded-xl border border-[#d2d2d7] px-4 py-3 text-sm outline-none focus:border-[#1d1d1f]"
                                placeholder="New password"
                            >
                        </div>

                        <div>
                            <label for="password_confirmation" class="mb-2 block text-sm font-medium">
                                Confirm New Password
                            </label>
                            <input
                                type="password"
                                id="password_confirmation"
                                name="password_confirmation"
                                required
                                autocomplete="new-password"
                                class="w-full rounded-xl border border-[#d2d2d7] px-4 py-3 text-sm outline-none focus:border-[#1d1d1f]"
                                placeholder="Repeat new password"
                            >
                        </div>

                        <button
                            type="submit"
                            class="w-full rounded-full border border-[#1d1d1f] px-5 py-3 text-sm font-medium transition hover:bg-[#1d1d1f] hover:text-white"
                        >
                            Update Password →
                        </button>
                    </form>
                </section>

                {{-- Logout --}}
                <section class="rounded-2xl border border-[#dedee2] bg-white p-6">

                    <h3 class="text-lg font-semibold">Sign Out</h3>

                    <p class="mt-2 text-sm leading-6 text-[#6e6e73]">
                        Sign out of your WeBarber account on this device.
                    </p>

                    <form method="POST" action="{{ route('logout') }}" class="mt-5">
                        @csrf

                        <button
                            type="submit"
                            class="rounded-full border border-[#e5caca] px-5 py-2.5 text-sm font-medium text-[#b42318] transition hover:bg-[#fff5f5]"
                        >
                            Logout from Account
                        </button>
                    </form>
                </section>

            </div>
        </div>

    </main>
</div>

@endsection
