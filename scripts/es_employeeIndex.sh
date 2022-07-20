# !bin/bash

#============================================================
#   ES - Drop Existing if exits, then Create and Index Media Model
#============================================================
set +e 
php artisan scout:flush "App\Models\Employee";
php artisan elastic:migrate:rollback 2022_07_18_050803_employee_index;
php artisan elastic:migrate 2022_07_18_050803_employee_index;
php artisan scout:import "App\Models\Employee";