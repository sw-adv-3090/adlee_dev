<?php

namespace App\Console\Commands;

use App\Models\Shipment;
use App\Notifications\ShipmentStatusChanged;
use App\Services\ShipEngineService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class TrackShipment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:track-shipment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will track every booklet shipment record and update its status accordingly.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $service = new ShipEngineService();

        $shipments = Shipment::with(['bookletPrint.user'])->whereNotIn('tracking_status', packet_delivered_status())->get();

        foreach ($shipments as $shipment) {
            $priviousStatus = $shipment->tracking_status;

            // Get tracking information from ShipEngine API
            $tracking = $service->tracking($shipment->carrier_code, $shipment->tracking_number);

            $currentStatus = tracking_status($tracking['status_code']);

            // Shipment status changed
            if ($priviousStatus !== $currentStatus) {
                $this->info("Shipment #{$shipment->id} changed from $priviousStatus to $currentStatus");
                // update shipment status in the database
                $shipment->update(['tracking_status' => $currentStatus]);

                // send email to user about status change
                Notification::send($shipment->bookletPrint->user, new ShipmentStatusChanged($shipment, $priviousStatus));
            }
        }

        $this->info("success");
    }
}
