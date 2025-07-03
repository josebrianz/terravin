<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Stakeholder;
use App\Services\ReportService;
use App\Mail\StakeholderReportMail;
use Illuminate\Support\Facades\Mail;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $stakeholders = Stakeholder::with('reportPreference')->get();
            foreach ($stakeholders as $stakeholder) {
                $pref = $stakeholder->reportPreference;
                if (!$pref) continue;
                // In production, filter by frequency and date
                $data = ReportService::generateForStakeholder($stakeholder);
                Mail::to($stakeholder->email)->send(new StakeholderReportMail($stakeholder, $data));
            }
        })->daily();
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
} 