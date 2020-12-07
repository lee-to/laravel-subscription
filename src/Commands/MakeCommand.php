<?php

namespace Leeto\Subscription\Commands;

use Illuminate\Console\Command;
use Leeto\Subscription\Models\SubscriptionPlan;

class MakeCommand extends Command
{
    protected $signature = 'subscription:make {name}';

    protected $description = '';

    public function handle()
    {
        $name = $this->argument('name');

        switch ($name) {
            case "plan": {
                $this->makePlan();
            }
        }

    }

    protected function makePlan() {
        $id = $this->ask("ID (optional)?");
        $name = $this->ask("Name?");
        $price = $this->ask("Price?");

        if($name && $price) {
            if($id) {
                SubscriptionPlan::where(["id" => $id])->update(["name" => $name, "price" => $price]);

                $this->info("Plan ID = {$id} updated");
            } else {
                $plan = SubscriptionPlan::create(["name" => $name, "price" => $price]);

                $this->info("Plan is created. ID = {$plan->id}");
            }

        } else {
            $this->error("All params is required");
        }
    }
}
