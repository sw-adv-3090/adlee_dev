<x-layouts.app-layout title="Templates Overview" is-sidebar-open="false" main="true">
    @php
    $sponsor_bg = 'bg-gradient-to-br from-amber-400 to-orange-600';
    $coupon_bg = 'bg-gradient-to-br from-pink-500 to-rose-500';
    @endphp

    <style>
        /* Modal background */
        /* Modal background */
        #previewModal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(0, 0, 0, 0.5);
            /* semi-transparent background */
            z-index: 1000;
        }

        /* Modal container */
        #previewModal .bg-white {
            background-color: white;
            border-radius: 0.5rem;
            padding: 2rem;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            position: relative;
            /* max-width: 500px; */
            /* Set the max-width for a medium modal */
            /* width: 90%; */
            /* Adjust width for responsiveness */
            max-height: 90vh;
            /* Ensure it doesn't overflow the screen height */
            overflow-y: auto;
            scroll-behavior: auto;
        }

        /* Close button */
        #previewModal .close-btn {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
        }

        /* Modal title */
        #previewModal h3 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: #333;
            border-bottom: 1px solid #ddd;
            padding-bottom: 0.5rem;
        }

        /* Image styling */
        #previewModal img {
            max-width: 100%;
            height: auto;
            border-radius: 0.5rem;
        }
    </style>
    <!-- Main Content Wrapper -->
    <main class="main-content w-full pb-8">
        @if(Auth::user()->is_active == 0)
        <div class="card">
            <div class="w-full max-w-[26rem] p-4 sm:px-5" style="position: absolute; right: 37%;">
            <div class="card mt-5 rounded-lg p-5 lg:p-7">
                <p class="text-slate-400 dark:text-navy-300">
                    Your Account is not Approved yet. 
                </p>

                <div class="mt-2 font-medium text-sm">
                    Please contact admin for your account approval 
                    

                </div>
            </div>
            </div>
            
        </div>
        @else
        <div class="card">
            <div class="mt-3 flex items-center justify-between px-4 sm:px-5">
                <h2 class="text-base font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100">
                    {{ __('Templates Overview') }}
                </h2>
                <a href="{{route('designer.upload-template')}}" class="btn btn-primary" style="background: #4f46e5; color: white;">Upload Template</a>
                <div class="flex">
                    <div class="flex items-center" x-data="{ isInputActive: false }">
                        <label class="block">
                            <input id='serachField' x-effect="isInputActive === true && $nextTick(() => { $el.focus()});"
                                :class="isInputActive ? 'w-32 lg:w-48' : 'w-0'"
                                class="form-input bg-transparent px-1 text-right transition-all duration-100 placeholder:text-slate-500 dark:placeholder:text-navy-200 border-0 ring-0 outline-none focus:ring-0"
                                placeholder="Search here..." type="text" wire:model.live="search" />
                        </label>
                        <button @click="isInputActive = !isInputActive"
                            class="btn size-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4.5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            @if($errors->any())
            <p class="text-base font-normal text-slate-700 dark:text-navy-100" style="color: red">{{$errors->first()}}</p>
            @endIf
            <div class="scrollbar-sm mt-5 min-w-full overflow-x-auto">
                <table class="is-hoverable w-full text-left">
                    <tbody id="templateTableBody">
                        @forelse ($templates as $template)

                        <tr class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500"
                            data-title="{{ strtolower($template->title) }}"
                            data-category="{{ strtolower($template->category ? $template->category->name : 'No Category') }}"
                            data-status="{{ $template->approve ? 'approved' : 'not approved' }}">

                            <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                <div class="flex items-center space-x-4">
                                    <div class="size-12">
                                        <img class="h-full w-full rounded-lg" src="{{ asset($template->preview) }}" alt="image" />
                                    </div>
                                    <div>
                                        <p class="font-medium text-slate-600 dark:text-navy-100">
                                            {{ $template->title }}
                                        </p>
                                        <p class="mt-1 text-xs text-slate-400 dark:text-navy-300 capitalize">
                                            {{ $template->type }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $template->category ? $template->category->name : 'No Category' }}</td>
                            <td>{{ $template->approve ? 'Approved' : 'Not Approved' }}</td>
                            <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                <span>{{ $template->created_at->format('F j, Y') }}</span>
                            </td>
                            <td>
                                <button onclick="openPreviewModal('{{ asset($template->preview) }}')" class="btn btn-primary">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </td>
                            <td><a href="{{ route('designer.delete-template', $template->id) }}" class="btn btn-danger"><i class="fa fa-trash"></i></a></td>
                        </tr>

                        @empty
                        <tr class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                            <td class="whitespace-nowrap px-4 py-3 sm:px-5 text-center" colspan="6">
                                <p class="text-md py-3">No templates created yet</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>


        </div>
        @endIf
        <div id="previewModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50" style="display: none;">
            <div class="bg-white p-5 rounded-lg max-w-lg mx-auto">
                <button class="close-btn" onclick="closePreviewModal()">×</button>
                <h3 class="text-lg font-medium mb-4">Preview</h3>
                <img id="previewImage" src="" alt="Preview" class="w-full rounded-lg" />
            </div>
        </div>

    </main>

    <script>
        function openPreviewModal(imageUrl) {
            document.getElementById('previewImage').src = imageUrl;
            document.getElementById('previewModal').style.display = 'flex';
        }

        function closePreviewModal() {
            document.getElementById('previewModal').style.display = 'none';
        }

        document.getElementById('serachField').addEventListener('input', function() {
            const searchText = this.value.toLowerCase();
            const rows = document.querySelectorAll('#templateTableBody tr');

            rows.forEach(row => {
                const title = row.getAttribute('data-title');
                const category = row.getAttribute('data-category');
                const status = row.getAttribute('data-status');

                // Check if any of the attributes contain the search text
                if (category.includes(searchText) || status.includes(searchText)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
    <!-- Main Content Wrapper End -->
</x-layouts.app-layout>