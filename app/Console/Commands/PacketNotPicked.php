<?php

namespace App\Console\Commands;

use App\Enums\UserRole;
use App\Models\User;
use App\Notifications\PacketNotPickedNotification;
use Illuminate\Console\Command;
use App\Models\Shipment;
use Illuminate\Support\Facades\Notification;

class PacketNotPicked extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:packet-not-picked';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will check weather the shipment package was not picked by the shipper after 24 hours of creating labels. If package found then send email to shipper and asdmin as well.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $NotPickedStatus = ["Not Yet In System", "in_transit", "In Transit", "IT", "NY"];

        $shipments = Shipment::query()
            ->with(['bookletPrint.user.sponsor'])
            ->select(['id', 'booklet_print_id', 'shipment_id', 'tracking_number', 'label_id'])
            ->where('created_at', '<', now()->subDay())
            ->whereIn('tracking_status', packet_not_picked_status())
            ->get();

        $count = $shipments->count();

        if ($count > 0) {
            $emails = settings('print-emails') ? json_decode(settings('print-emails'), true) : [];
            foreach (User::where('role_id', UserRole::Admin->value)->select(['email'])->get() as $admin) {
                $emails[] = $admin->email;
            }

            // sending notifications for all packages
            foreach ($shipments as $shipment) {
                foreach ($emails as $email) {
                    Notification::route('mail', $email)->notify(new PacketNotPickedNotification($shipment));
                }
            }
        }

        $this->info("Sending emails for shipments: " . $count);


    }
}
