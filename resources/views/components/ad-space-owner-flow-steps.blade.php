 @props(['step1' => true, 'step2' => true, 'step3' => false, 'step4' => false, 'step5' => false])
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

             <a href="{{ route('ad-space-owner.basic-settings.index') }}"
                 class="step space-x-4 pb-12 before:bg-slate-200 dark:before:bg-navy-500">
                 <div class="step-header mask is-hexagon {{ $step2 ? $activeIcon : $normalIcon }}">
                     <i class="fa-solid fa-building text-base"></i>
                 </div>
                 <div class="text-left">
                     <p class="text-xs text-slate-400 dark:text-navy-300">
                         Step 2
                     </p>
                     <h3 class="text-base font-medium {{ $step2 ? $activeTitle : '' }}">Company Information</h3>
                 </div>
             </a>

             <a href="{{ route('ad-space-owner.basic-settings.ein.index') }}"
                 class="step space-x-4 pb-12 before:bg-slate-200 dark:before:bg-navy-500">
                 <div class="step-header mask is-hexagon {{ $step3 ? $activeIcon : $normalIcon }}">
                     <i class="fa-solid fa-check-circle text-base"></i>
                 </div>
                 <div class="text-left">
                     <p class="text-xs text-slate-400 dark:text-navy-300">
                         Step 3
                     </p>
                     <h3 class="text-base font-medium {{ $step3 ? $activeTitle : '' }}">EIN Verification</h3>
                 </div>
             </a>

             <a href="{{ route('ad-space-owner.basic-settings.onboarding.index') }}"
                 class="step space-x-4 pb-12 before:bg-slate-200 dark:before:bg-navy-500">
                 <div class="step-header mask is-hexagon {{ $step4 ? $activeIcon : $normalIcon }}">
                     <i class="fa-solid fa-money-bill-wave text-base"></i>
                 </div>
                 <div class="text-left">
                     <p class="text-xs text-slate-400 dark:text-navy-300">
                         Step 4
                     </p>
                     <h3 class="text-base font-medium {{ $step4 ? $activeTitle : '' }}">Stripe Onboarding</h3>
                 </div>
             </a>

             <a href="{{ route('ad-space-owner.basic-settings.plans.index') }}"
                 class="step space-x-4 pb-12 before:bg-slate-200 dark:before:bg-navy-500">
                 <div class="step-header mask is-hexagon {{ $step5 ? $activeIcon : $normalIcon }}">
                     <i class="fa-solid fa-list text-base"></i>
                 </div>
                 <div class="text-left">
                     <p class="text-xs text-slate-400 dark:text-navy-300">
                         Step 2
                     </p>
                     <h3 class="text-base font-medium {{ $step5 ? $activeTitle : '' }}">Subscription</h3>
                 </div>
             </a>
         </ol>
     </div>
 </div>
