<?php

use Illuminate\Database\Migrations\Migration;

class CreateEmailLogTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('email_log', function ($table) {
			$table->increments('id');
			$table->string('to')->nullable();
			$table->string('bcc')->nullable();
			$table->string('cc')->nullable();
			$table->string('replyTo')->nullable();
			$table->string('priority')->nullable();
			$table->string('messageId')->nullable()->unique();
			$table->string('sender')->nullable();
			$table->string('subject')->nullable();
			$table->string('body')->nullable();
			$table->dateTimeTz('date')->nullable();

			$table->timestamps();

			$table->index('to');
			$table->index('subject');
			$table->index('date');

			$table->engine = 'InnoDB'; // http://dev.mysql.com/doc/refman/5.7/en/storage-engines.html
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('email_log');
	}
}
