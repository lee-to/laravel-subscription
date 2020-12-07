<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionItemHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscription_item_histories', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('subscription_item_id');
            $table->foreign('subscription_item_id')->references('id')->on('subscription_items')->onDelete('cascade');

            $table->double("price", 12, 2);

            $table->integer("bank_card_id")->nullable();

            $table->index(["bank_card_id"]);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscription_histories');
    }
}
