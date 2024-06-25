<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\BenefitsApplicant;
use App\Models\DtrTicket;
use App\Models\EmployeeInformation;
use App\Models\LeaveRequests;
use App\Models\RequestOff;
use App\Models\RequestSchedule;
use App\Models\TrainingApplicant;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('cancel-schedule-request', function (User $user, RequestSchedule $requestSchedule){
            return $user->employee_id === $requestSchedule->employee_id;
        });

        Gate::define('cancel-leave-request', function (User $user, LeaveRequests $leaveRequests){
            return $user->employee_id === $leaveRequests->employee_id;
        });

        Gate::define('cancel-off-request', function (User $user, RequestOff $requestOff){
            return $user->employee_id === $requestOff->employee_id;
        });

        Gate::define('cancel-schedule-request', function (User $user, RequestSchedule $requestSchedule){
            return $user->employee_id === $requestSchedule->employee_id;
        });

        Gate::define('cancel-dtr-ticket', function (User $user, DtrTicket $dtrTicket){
                return $user->employee_id === $dtrTicket->employee_id;
        });

        Gate::define('cancel-benefit-application', function (User $user, BenefitsApplicant $benefitsApplicant){
            return $user->employee_id === $benefitsApplicant->employee_id;
        });

        Gate::define('request-update', function(User $user){
            return $user->role === 2;
        });

        Gate::define('admin', function(User $user){
            return $user->role === 2;
        });

        Gate::define('employee', function(User $user){
            return $user->role === 1;
        });

        Gate::define('employee-information', function (User $user, EmployeeInformation $employeeInformation){
            return $user->employee_id === $employeeInformation->employee_id;
        });

        Gate::define('head', function(User $user) {
            $position = explode(' ', $user->position);
            return $position[1] === 'Head';
        });

        Gate::define('cancel-training-application', function(User $user, TrainingApplicant $trainingApplicant) {
            return $user->employee_id === $trainingApplicant->employee_id;
        });

    }
}
