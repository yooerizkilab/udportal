<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Services\QontakSevices;
use App\Models\Vehicle;
use App\Models\Contract;
use App\Models\IncomingShipments;
use Carbon\Carbon;

class SendNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command All Notifications';

    /**
     *  @var QontakSevices
     */
    protected $qontakServices;

    /**
     * Create a new command instance.
     *
     * @return void
     */

    public function __construct(QontakSevices $qontakServices)
    {
        parent::__construct();
        $this->qontakServices = $qontakServices;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // 30 days, 21 days, 14 days, 7 days, 3 days, 0 days
        $intervals = [30, 21, 14, 7, 3, 0];

        $this->contractNotifications($intervals);

        $this->vehicleTaxNotifications($intervals);

        $this->incomingInventoryPlanNotifications($intervals);

        $this->info('Notifications sent successfully');
    }

    private function contractNotifications($intervals)
    {
        foreach ($intervals as $interval) {
            $targetDate = now()->addDays($interval);

            $contracts = Contract::whereDate('masa_berlaku', '=', $targetDate)
                ->orWhere('masa_berlaku', '<', now()) // Sudah lewat jatuh tempo
                ->get();

            if ($contracts->isEmpty()) {
                Log::info("No contracts found for interval: {$interval}");
                continue;
            }

            foreach ($contracts as $contract) {
                $formatDate = Carbon::parse($contract->masa_berlaku)->format('d F Y');
                $phone = '62895341341001';
                $name = 'John Doe';
                $templateId = 'a61a84b8-2e50-4590-a1a8-cdf3c5c2ddba';
                $body = [
                    [
                        'key' => '1',
                        'value_text' => $contract->name,
                        'value' => 'name',
                    ],
                    [
                        'key' => '2',
                        'value_text' => $contract->nama_perusahaan,
                        'value' => 'company',
                    ],
                    [
                        'key' => '3',
                        'value_text' => $formatDate,
                        'value' => 'expired',
                    ],
                ];
                try {
                    $response = $this->qontakServices->sendMessage($phone, $name, $templateId, $body);
                    Log::info("Notification sent for contract {$contract->id}: {$response}");
                } catch (\Exception $e) {
                    Log::error("Error sending notification for contract {$contract->id}: {$e->getMessage()}");
                }
            }
        }
    }

    private function vehicleTaxNotifications($intervals)
    {
        foreach ($intervals as $interval) {
            $targetDate = now()->addDays($interval);

            $vehicles = Vehicle::with('assigned', 'ownership')
                ->where(function ($query) use ($targetDate) {
                    $query->whereDate('tax_year', '=', $targetDate)
                        ->orWhereDate('tax_five_year', '=', $targetDate)
                        ->orWhereDate('inspected', '=', $targetDate)
                        ->orWhere('tax_year', '<', now())
                        ->orWhere('tax_five_year', '<', now())
                        ->orWhere('inspected', '<', now());
                })
                ->get();

            if ($vehicles->isEmpty()) {
                Log::info("No vehicles found for interval: {$interval}");
                continue;
            }

            foreach ($vehicles as $vehicle) {
                $contacts = [
                    [
                        // Assign Notification Phone Number
                        'phone' => $vehicle->assigned->phone,
                        'name' => $vehicle->assigned->full_name
                    ],
                    [
                        // Owner Notification Phone Number
                        'phone' => $vehicle->ownership->phone,
                        'name' => $vehicle->ownership->name
                    ],
                    [
                        // PIC or Custom Notification Phone Number
                        'phone' => '62895341341001',
                        'name' => 'John Doe'
                    ]

                ];
                foreach ($contacts as $contact) {

                    $phone = $contact['phone'];
                    $name = $contact['name'];

                    $templateId = '0b6481c3-bf0b-41b9-a52b-f6fe13ceb976';

                    $notificationType = null;
                    $dateField = null;

                    // Tax Notification
                    if (!empty($vehicle->tax_year) && Carbon::parse($vehicle->tax_year)->isSameDay($targetDate)) {
                        $notificationType = 'ANNUAL TAX';
                        $dateField = Carbon::parse($vehicle->tax_year)->format('d M Y');
                    } elseif (!empty($vehicle->tax_five_year) && Carbon::parse($vehicle->tax_five_year)->isSameDay($targetDate)) {
                        $notificationType = 'FIVE YEAR TAX';
                        $dateField = Carbon::parse($vehicle->tax_five_year)->format('d M Y');
                    } elseif (!empty($vehicle->inspected) && Carbon::parse($vehicle->inspected)->isSameDay($targetDate)) {
                        $notificationType = 'INSPECTION';
                        $dateField = Carbon::parse($vehicle->inspected)->format('d M Y');
                    }

                    if ($notificationType) {
                        $body = [
                            [
                                'key' => '1',
                                'value_text' => $notificationType,
                                'value' => 'type',
                            ],
                            [
                                'key' => '2',
                                'value_text' => $vehicle->license_plate,
                                'value' => 'nopol',
                            ],
                            [
                                'key' => '3',
                                'value_text' => $vehicle->model,
                                'value' => 'model',
                            ],
                            [
                                'key' => '4',
                                'value_text' => $dateField,
                                'value' => 'expired',
                            ],
                        ];

                        try {
                            Log::info("Prepared notification for vehicle ID {$vehicle->id}", ['body' => $body]);
                            $response = $this->qontakServices->sendMessage($phone, $name, $templateId, $body);

                            if ($response['status'] !== 'success') {
                                Log::error("Failed to send notification for vehicle ID {$vehicle->id}: ", $response);
                            } else {
                                Log::info("Notification sent successfully for vehicle ID {$vehicle->id}");
                            }
                        } catch (\Exception $e) {
                            Log::error("Failed to send notification for vehicle ID {$vehicle->id}. Error: {$e->getMessage()}");
                        }
                    }
                }
            }
        }
    }

    private function incomingInventoryPlanNotifications($interval)
    {
        // Implement incoming inventory plan notifications
        foreach ($interval as $interval) {
            $targetDate = now()->addDays($interval);
            $incomings = IncomingShipments::with('branch', 'supplier', 'item', 'drop')
                ->whereDate('eta', '=', $targetDate)
                ->orWhere('eta', '<', now())
                ->get();

            if ($incomings->isEmpty()) {
                Log::info("No incoming shipments found for interval: {$interval}");
                continue;
            }

            $formatDate = Carbon::parse($incomings->eta)->format('d F Y');
            $phone = '62895341341001';
            $name = 'John Doe';
            $templateId = 'a61a84b8-2e50-4590-a1a8-cdf3c5c2ddba';
            $body = [
                [
                    'key' => '1',
                    'value_text' => $incomings->branch->name,
                    'value' => 'name',
                ],
                [
                    'key' => '2',
                    'value_text' => $incomings->supplier->name,
                    'value' => 'company',
                ],
                [
                    'key' => '3',
                    'value_text' => $formatDate,
                    'value' => 'expired',
                ],
            ];
            try {
                $response = $this->qontakServices->sendMessage($phone, $name, $templateId, $body);
                Log::info("Notification sent for contract {$incomings->id}: {$response}");
            } catch (\Exception $e) {
                Log::error("Error sending notification for contract {$incomings->id}: {$e->getMessage()}");
            }
        }
    }
}
