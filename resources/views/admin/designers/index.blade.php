<x-layouts.app-layout title="Templates Overview" is-sidebar-open="false" main="true">
    @php
    $sponsor_bg = 'bg-gradient-to-br from-amber-400 to-orange-600';
    $coupon_bg = 'bg-gradient-to-br from-pink-500 to-rose-500';
    @endphp

    <style>
        /* Modal background */
        #approveModal {
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
        #approveModal .bg-white {
            background-color: white;
            border-radius: 0.5rem;
            padding: 2rem;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            position: relative;
        }

        /* Close button */
        #approveModal .close-btn {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
        }

        /* Modal title */
        #approveModal h3 {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: #333;
        }

        /* Form label */
        #approveModal label {
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
            display: block;
            color: #555;
        }

        /* Input and select fields */
        #approveModal .form-input,
        #approveModal .form-select {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ccc;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        #approveModal .form-input:disabled,
        #approveModal .form-select:disabled {
            background-color: #f5f5f5;
            cursor: not-allowed;
        }

        /* Buttons */
        #approveModal .btn {
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        #approveModal .btn-secondary {
            background-color: #6b7280;
            color: white;
            border: none;
        }

        #approveModal .btn-secondary:hover {
            background-color: #4b5563;
        }

        #approveModal .btn-primary {
            background-color: #2563eb;
            color: white;
            border: none;
        }

        #approveModal .btn-primary:hover {
            background-color: #1d4ed8;
        }

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
            overflow-y: auto;
            /* Enable scrolling */
            padding: 1rem;
            /* Add padding for better spacing on small screens */
        }

        /* Modal container */
        #previewModal .bg-white {
            background-color: white;
            border-radius: 0.5rem;
            padding: 2rem;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 800px;
            position: relative;
            max-height: 90vh;
            /* Limit height to prevent overflow */
            overflow-y: auto;
            /* Enable scrolling inside the modal if content overflows */
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
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: #333;
        }

        /* Image styling */
        #previewModal img {
            max-width: 100%;
            /* Ensure image doesn't overflow modal width */
            height: auto;
            /* Maintain aspect ratio */
            display: block;
            margin: 0 auto;
            /* Center image */
            border-radius: 0.5rem;
            /* Optional: Add rounded corners */
        }
        .text-center{
            text-align: center;
        }
        .approve-btn{
            background: #098909; color: white;
            font-size: 14px;
            padding: 10px 10px 10px 10px;
        }
        .reject-btn{
            background: red; color: white;
            font-size: 14px;
            padding: 10px 10px 10px 10px;
        }
    </style>
    <!-- Main Content Wrapper -->
    <main class="main-content w-full pb-8">
        <div class="card">
            <div class="mt-3 flex items-center justify-between px-4 sm:px-5">
                <h2 class="text-base font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100">
                    {{ __('Designers') }}
                </h2>

                <div class="flex">
                    <div class="flex items-center">
                        <label class="block">
                            <input id="searchInput" class="form-input bg-transparent px-1 text-right transition-all duration-100 placeholder:text-slate-500 dark:placeholder:text-navy-200 border-0 ring-0 outline-none focus:ring-0"
                                placeholder="Search here..." type="text" wire:model.live="search" />
                        </label>
                        <button class="btn size-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
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
            <div class=" mt-5 min-w-full">
                <table class="is-hoverable w-full text-left">
                    <tbody id="templateTableBody">
                        @forelse ($designers as $designer)
                        <tr class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500 list-item"
                            data-profile-picture="{{ $designer->profile_photo_url }}"
                            data-name="{{ strtolower($designer->name) }}"
                            data-email="{{ $designer->email }}"
                            data-status="{{ $designer->is_active ? 'approved' : 'unapproved' }}">

                            <td class="whitespace-nowrap px-4 py-3 sm:px-5" style="width:15%;">
                                <div class="flex items-center space-x-4">
                                    <div class="size-12">
                                        <img class="h-full w-full rounded-lg" src="{{ $designer->profile_photo_url ? asset($designer->profile_photo_url) : asset('images/100x100.png') }}" alt="image" />
                                    </div>
                                    <div>
                                        <p class="font-medium text-slate-600 dark:text-navy-100">
                                            {{ $designer->name }}
                                        </p>
                                        <p class="mt-1 text-xs text-slate-400 dark:text-navy-300 capitalize">
                                            {{ $designer->email }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center whitespace-nowrap px-4 py-3 sm:px-5" style="width:10%;">
                                <span>{{ $designer->is_active ? 'Active' : 'InActive'}}</span>
                            </td>
                            
                            <td class="text-center whitespace-nowrap px-4 py-3 sm:px-5" style="width:10%;">
                                <span>{{ $designer->created_at->format('F j, Y') }}</span>
                            </td>
                            <td class="text-center whitespace-nowrap px-4 py-3 sm:px-5" style="width:10%;">
                                @if(!$designer->is_active)
                                <a href="{{ url('admin/designers/approve-designer' , [$designer->id, 1]) }}" class="btn btn-success approve-btn">Activate</a>
                                @else
                                <a href="{{ url('admin/designers/approve-designer' , [$designer->id, 0]) }}" class="btn btn-danger reject-btn">Deactivate</a>
                                @endif
                            </td>
                            
                        </tr>
                        @empty
                        <tr class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                            <td class="whitespace-nowrap px-4 py-3 sm:px-5 text-center" colspan="7">
                                <p class="text-md py-3">No Designers created yet</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
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

        function openModal(templateId) {
            document.getElementById('approveModal').style.display = 'flex';
            document.getElementById('category').disabled = false;
            document.getElementById('inputField').disabled = false;
            document.getElementById('templateId').value = templateId; // Set template ID
        }

        // Close Modal
        function closeApproveModal() {
            let approveModal = document.getElementById('approveModal');
            if (approveModal) approveModal.style.display = 'none';
        }

        // Handle Dropdown Change
        function handleDropdownChange() {
            const category = document.getElementById('category');
            const inputField = document.getElementById('inputField');

            if (category.value !== "") {
                inputField.disabled = true;
            } else {
                inputField.disabled = false;
            }
        }

        // Handle Input Change
        function handleInputChange() {
            const category = document.getElementById('category');
            const inputField = document.getElementById('inputField');

            if (inputField.value !== "") {
                category.disabled = true;
            } else {
                category.disabled = false;
            }
        }

        // Validate Form before Submission
        function validateAndSubmitForm() {
            const category = document.getElementById('category').value;
            const inputField = document.getElementById('inputField').value;
            const errorMessage = document.getElementById('error-message');

            // If both category and inputField are empty, show error
            if (!category && !inputField) {
                errorMessage.style.display = 'block'; // Show error message
                return false; // Stop form submission
            } else {
                errorMessage.style.display = 'none'; // Hide error message
                document.getElementById('approveForm').submit(); // Manually submit form if validation passes
            }
        }

        document.getElementById('category').addEventListener('change', function() {
            document.getElementById('error-message').style.display = 'none'; // Hide error on dropdown change
        });

        document.getElementById('inputField').addEventListener('input', function() {
            document.getElementById('error-message').style.display = 'none'; // Hide error on input field change
        });

        document.getElementById('searchInput').addEventListener('keyup', function() {
            const query = this.value.toLowerCase();
            const rows = document.querySelectorAll('#templateTableBody .list-item');

            rows.forEach(row => {
                const title = row.getAttribute('data-title');
                const creator = row.getAttribute('data-creator');
                const category = row.getAttribute('data-category');
                const status = row.getAttribute('data-status');

                // Show row if it matches any of the data attributes
                if (category.includes(query) || creator.includes(query)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
</x-layouts.app-layout>