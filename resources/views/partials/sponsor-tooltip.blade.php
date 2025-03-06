<p class="my-1.5">Upload the file of your template either in html or php extension.
    Please make sure you have write the veriables name corrected as mention
    <span class="text-blue-400 cursor-pointer" x-tooltip.interactive.content="'#info'">here</span>. You can
    preview the template once you upload to system if any veriable name is missing
    or name incorrectly then system will through error so you can edit you template
    or delete this one and upload new one with having all the things correctly. Also
    make sure main tag is included because system will get the content between main
    tag and also make sure you have not design the body tag and main tag.
</p>
<template id="info">
    <div class="flex flex-col space-y-3 rounded-lg bg-slate-150 p-3 dark:bg-navy-500 w-[400px]">
        <div class="flex items-center justify-between">
            <span>Adlee Logo:</span>
            <span>{{ $adlee_logo }}</span>
        </div>
        <div class="flex items-center justify-between">
            <span>Person Title:</span>
            <span>{{ $person_title }}</span>
        </div>
        <div class="flex items-center justify-between">
            <span>Person Name:</span>
            <span>{{ $person_name }}</span>
        </div>
        <div class="flex items-center justify-between">
            <span>Company Logo:</span>
            <span>{{ $sponsor_logo }}</span>
        </div>
        <div class="flex items-center justify-between">
            <span>Company Name:</span>
            <span>{{ $sponsor_name }}</span>
        </div>
        <div class="flex items-center justify-between">
            <span>Commemoration:</span>
            <span>{{ $commemoration }}</span>
        </div>
        <div class="flex items-center justify-between">
            <span>QR Code:</span>
            <span>{{ $qr_code }}</span>
        </div>
    </div>
</template>
