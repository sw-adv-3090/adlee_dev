<x-layouts.app-layout title="Templates Categories" is-sidebar-open="true">
    <div
        class="mt-6 flex flex-col items-center justify-between space-y-2 text-center sm:flex-row sm:space-y-0 sm:text-left">
        <div class="flex items-center space-x-1">
            <h2 class="text-xl font-medium text-slate-700 line-clamp-1 dark:text-navy-50">
                Templates Categories
            </h2>
        </div>

        <a href="{{ route('admin.templates.categories.create') }}"
            class="btn space-x-2 bg-primary font-medium text-white shadow-lg shadow-primary/50 hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:shadow-accent/50 dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-indigo-50" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            <span> New Category </span>
        </a>
    </div>

    @include('partials.alert')

    <div class="is-scrollbar-hidden min-w-full overflow-x-auto mt-8">
        <table class="is-hoverable w-full text-left">
            <thead>
                <tr>
                    <th
                        class="whitespace-nowrap rounded-l-lg bg-slate-200 px-3 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                        #
                    </th>
                    <th
                        class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                        Name
                    </th>
                    <th
                        class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                        Sub Sategories
                    </th>
                    <th
                        class="whitespace-nowrap bg-slate-200 px-3 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                        Templates
                    </th>
                    <th
                        class="whitespace-nowrap rounded-r-lg bg-slate-200 px-3 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                    <tr class="border border-transparent border-b-slate-200 dark:border-b-navy-500">
                        <td class="whitespace-nowrap rounded-l-lg px-4 py-3 sm:px-5">{{ $loop->iteration }}</td>
                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">{{ $category->name }}</td>
                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                            {{ $category->sub_categories_count }}
                        </td>
                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">{{ $category->templates_count }}
                        </td>
                        <td class="whitespace-nowrap rounded-r-lg px-4 py-3 sm:px-5">
                            <div class="flex space-x-4">
                                <div class="relative cursor-pointer">
                                    <a href="{{ route('admin.templates.categories.edit', $category) }}"
                                        class="btn size-7 rounded-full bg-primary/10 p-0 text-primary hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                            fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                            <path
                                                d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                            <path fill-rule="evenodd"
                                                d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                        </svg>
                                    </a>
                                </div>
                                <div class="relative cursor-pointer">
                                    <form method="POST"
                                        action="{{ route('admin.templates.categories.destroy', $category) }}"
                                        method="POST" onsubmit="return confirm('Are you sure to delete category?')">
                                        @csrf
                                        @method('delete')
                                        <button
                                            class="btn size-7 rounded-full bg-error/10 p-0 text-error hover:bg-error/20 focus:bg-error/20 active:bg-error/25">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4.5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </form>

                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr class="border border-transparent border-b-slate-200 dark:border-b-navy-500">
                        <td class="whitespace-nowrap rounded-lg px-4 py-3 sm:px-5" colspan="5">No category</td>
                    </tr>
                @endforelse

            </tbody>
        </table>
    </div>
</x-layouts.app-layout>
