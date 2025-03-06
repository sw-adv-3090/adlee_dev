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
            <span>Book Number:</span>
            <span>{{ $book_number }}</span>
        </div>
        <div class="flex items-center justify-between">
            <span>Coupon Number:</span>
            <span>{{ $coupon_number }}</span>
        </div>
        <div class="flex items-center justify-between">
            <span>Sponsor QR Code:</span>
            <span>{{ $sponsor_qr_code }}</span>
        </div>
        <div class="flex items-center justify-between">
            <span>Sponsor Logo:</span>
            <span>{{ $sponsor_logo }}</span>
        </div>
        <div class="flex items-center justify-between">
            <span>Sponsor Name:</span>
            <span>{{ $sponsor_name }}</span>
        </div>
        <div class="flex items-center justify-between">
            <span>Sponsor Address:</span>
            <span>{{ $sponsor_address }}</span>
        </div>
        <div class="flex items-center justify-between">
            <span>Sponsor City:</span>
            <span>{{ $sponsor_city }}</span>
        </div>
        <div class="flex items-center justify-between">
            <span>Sponsor ZipCode:</span>
            <span>{{ $sponsor_zipcode }}</span>
        </div>
        <div class="flex items-center justify-between">
            <span>Amount in Words:</span>
            <span>{{ $amount_in_words }}</span>
        </div>
        <div class="flex items-center justify-between">
            <span>Amount in Digits:</span>
            <span>{{ $amount_in_digits }}</span>
        </div>
        <div class="flex items-center justify-between">
            <span>BBO QR Code:</span>
            <span>{{ $bbo_qr_code }}</span>
        </div>
        <div class="flex items-center justify-between">
            <span>Shorten URL:</span>
            <span>{{ $shorten_url }}</span>
        </div>
    </div>
</template>
