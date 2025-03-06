 @props(['step1' => true, 'step2' => true, 'step3' => false, 'step4' => false, 'step5' => false, 'step6' => false])
 @php
     $normalIcon = 'bg-slate-200 text-slate-500 dark:bg-navy-500 dark:text-navy-100';
     $activeIcon = 'bg-primary text-white dark:bg-accent';
     $activeTitle = 'text-primary dark:text-accent-light';
 @endphp
 {{-- lg:place-items-center --}}
 <div class="col-span-12 grid lg:col-span-3">
     <div>
         <ol class="steps is-vertical line-space [--size:2.75rem] [--line:.5rem]">
             <li class="step space-x-4 pb-12 before:bg-slate-200 dark:before:bg-navy-500">
                 <div class="step-header mask is-hexagon {{ $step1 ? $activeIcon : $normalIcon }}">
                     <i class="fa-solid fa-layer-group text-base"></i>
                 </div>
                 <div class="text-left">
                     <p class="text-xs text-slate-400 dark:text-navy-300">
                         Step 1
                     </p>
                     <h3 class="text-base font-medium {{ $step1 ? $activeTitle : '' }}">
                         Create Account
                     </h3>
                 </div>
             </li>
             <a href="{{ route('sponsors.plans.index') }}"
                 class="step space-x-4 pb-12 before:bg-slate-200 dark:before:bg-navy-500">
                 <div class="step-header mask is-hexagon {{ $step2 ? $activeIcon : $normalIcon }}">
                     <i class="fa-solid fa-list text-base"></i>
                 </div>
                 <div class="text-left">
                     <p class="text-xs text-slate-400 dark:text-navy-300">
                         Step 2
                     </p>
                     <h3 class="text-base font-medium {{ $step2 ? $activeTitle : '' }}">Subscription</h3>
                 </div>
             </a>

             <a href="{{ route('sponsors.basic-settings') }}"
                 class="step space-x-4 pb-12 before:bg-slate-200 dark:before:bg-navy-500">
                 <div class="step-header mask is-hexagon {{ $step3 ? $activeIcon : $normalIcon }}">
                     <i class="fa-solid fa-gear text-base"></i>
                 </div>
                 <div class="text-left">
                     <p class="text-xs text-slate-400 dark:text-navy-300">
                         Step 3
                     </p>
                     <h3 class="text-base font-medium {{ $step3 ? $activeTitle : '' }}">Basic Settings</h3>
                 </div>
             </a>
             <a href="{{ route('sponsors.basic-settings.address') }}"
                 class="step space-x-4 pb-12 before:bg-slate-200 dark:before:bg-navy-500">
                 <div class="step-header mask is-hexagon {{ $step4 ? $activeIcon : $normalIcon }}">
                     <i class="fa-solid fa-truck-fast text-base"></i>
                 </div>
                 <div class="text-left">
                     <p class="text-xs text-slate-400 dark:text-navy-300">
                         Step 4
                     </p>
                     <h3 class="text-base font-medium {{ $step4 ? $activeTitle : '' }}">Shipping</h3>
                 </div>
             </a>

             <a href="{{ route('sponsors.basic-settings.templates') }}"
                 class="step space-x-4 pb-12 before:bg-slate-200 dark:before:bg-navy-500">
                 <div class="step-header mask is-hexagon {{ $step5 ? $activeIcon : $normalIcon }}">
                     <i class="fa-solid fa-money-bill-wave text-base"></i>
                 </div>
                 <div class="text-left">
                     <p class="text-xs text-slate-400 dark:text-navy-300">
                         Step 5
                     </p>
                     <h3 class="text-base font-medium {{ $step5 ? $activeTitle : '' }}">Select Template</h3>
                 </div>
             </a>

             {{-- <li class="step space-x-4 before:bg-slate-200 dark:before:bg-navy-500">
                 <div class="step-header mask is-hexagon {{ $step6 ? $activeIcon : $normalIcon }}">
                     <i class="fa-solid fa-check text-base"></i>
                 </div>
                 <div class="text-left">
                     <p class="text-xs text-slate-400 dark:text-navy-300">
                         Step 6
                     </p>
                     <h3 class="text-base font-medium {{ $step6 ? $activeTitle : '' }}">Confirm</h3>
                 </div>
             </li> --}}
         </ol>
     </div>
 </div>
