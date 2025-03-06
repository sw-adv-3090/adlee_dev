<x-layouts.website-layout>
    <div class="max-w-4xl mx-auto w-full pb-6 pt-3">
        @if ($type === 'sponsor')
            <h1 class="text-[#07277c] text-2xl font-semibold text-center">Become an Adlee Sponsor</h1>
            <div class="space-y-3 text-gray-800 dark:text-white text-base mt-6">
                <p>Sponsors can use the platform to commit funding to causes they care about, gain transparency into how
                    their funds are allocated, and track funding activities over time.</p>
                <p>Sponsorship funds are allocated using “coupons,” which are issued to ad space owners via physical
                    coupons or virtual (emailed) redemption codes. </p>
                <p>Adlee coupons function like a fully customizable themed template coupon and can be validated for any
                    amount you choose minimum of $50 per coupon. </p>
                <p>Coupon redemption is done on our secure online platform and is designed to prevent fraud using QR
                    codes on the coupons and matching stubs, which must be scanned and activated to validate.</p>
                <p>All coupon redemptions are tracked on the Adlee platform. Access reports for all your sponsorships or
                    track relationships and milestones over time. </p>
                <p>Branded tax-compliant invoices are generated automatically and stored in your online account for easy
                    access. </p>
                <p>Getting started is easy:</p>
                <ol class="list-decimal list-inside text-gray-800 pl-3 space-y-2">
                    <li>Create an account on the <a href="{{ route('register') }}" class="text-[#07277c]">Adlee Sponsor
                            Portal</a>.</li>
                    <li>Provide your legal business information, including your EIN and company logo, which will be used
                        in your sponsored advertisements.</li>
                    <li>Create virtual campaigns: send sponsorship coupons via email for Ad Space owners to redeem.</li>
                    <li>Create physical campaigns: order coupon booklets and set the coupon value of each book ordered.
                        Each booklet contains 50 coupons and can be assigned any value (minimum of $50 per coupon).
                    </li>
                    <li>Physical coupon books will be automatically printed and mailed to you via national carriers
                        backed with email notifications.</li>
                    <li>Each coupon stub represents a physical, historical record of the payment. </li>
                    <li>Coupons must be activated in the portal to prevent theft, duplication, or unlawful redemption.
                    </li>
                    <li>Sponsor controls the default coupon payout period. </li>
                    <li>Approve which ad templates can be associated with your brand. </li>
                    <li>Receive redemption or payout notifications in real-time. </li>
                </ol>
            </div>
            <div class="mt-12 text-center">
                <a href="{{ route('register') }}"
                    class="btn rounded-full border border-slate-200 font-medium text-[#07277c] hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-500 dark:text-accent-light dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90 ">
                    CREATE YOUR SPONSOR ACCOUNT
                </a>
            </div>
        @elseif ($type === 'ad-space-owner')
            <h1 class="text-[#07277c] text-2xl font-semibold text-center">Connect with Sponsors to Accelerate Your
                Success</h1>
            <div class="space-y-3 text-gray-800 dark:text-white text-base mt-6">
                <p>Adlee removes the barriers associated with pitching ad space owners for your campaigns. Adlee
                    sponsors are vetted and verified to ensure meaningful, mutually beneficial connections. </p>
                <p>Sponsors can access Ad space owner’s profiles to pitch their campaigns, or you can invite your Ad
                    Space Owners with a Campaign of Coupons to join Adlee and gain all the benefits of our integrated
                    platform. </p>
                <p>We take care of the business end of sponsorship so you can focus on making your mark in the world.
                    Sponsors provide payment access using “coupons,” which are redeemed securely on the site, ensuring
                    you receive your funds on a verified timeline. </p>

                <p>Getting started is easy:</p>
                <ol class="list-decimal list-inside text-gray-800 pl-3 space-y-2">
                    <li>Create an account on the <a href="{{ route('register', ['type' => 'ad-space-owner']) }}"
                            class="text-[#07277c]">Adlee Ad Space
                            Owner Portal</a>.</li>
                    <li>Provide your business information, including EIN and company logo</li>
                    <li>Sponsors will either email or provide physical coupons.</li>
                    <li>To redeem your coupon, simply scan the QR code or type in the unique URL and coupon password on
                        the portal.
                    </li>
                    <li>Choose an approved template from the Sponsor’s profile for this campaign.</li>
                    <li>Download your print-ready 8 ½ x 11 templated Ad from the portal and post away! </li>
                    <li>Adlee automatically issues branded tax-compliant invoices to the sponsor once Ad Is Posted and
                        Terms and Agreement is authorized.
                    </li>
                </ol>
            </div>
            <div class="mt-12 text-center">
                <a href="{{ route('register', ['type' => 'ad-space-owner']) }}"
                    class="btn rounded-full border border-slate-200 font-medium text-[#07277c] hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-500 dark:text-accent-light dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90 ">
                    CREATE YOUR ACCOUNT
                </a>
            </div>
        @endif

    </div>
</x-layouts.website-layout>
