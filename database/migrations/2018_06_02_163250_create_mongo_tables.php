<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMongoTables extends Migration {
	private $tableNames
		= [
			'reports'              => 'id',
			'subscriber_summaries' => 'id',
			'click_details'        => 'id',
			'click_detail_members' => ['campaign_id', 'email_id'],
			'recipients'           => ['campaign_id', 'email_id'],
			'activities'           => ['campaign_id', 'list_id', 'email_id'],
			'domain_performances'  => ['campaign_id', 'domain'],
			'unsubscribes'         => ['campaign_id', 'email_id'],
			'email_activities'     => ['campaign_id', 'email_address']
		];

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		foreach ($this->tableNames as $tableName => $primaryKey)
			Schema::connection( 'mongodb' )->create( $tableName, function ( $collection ) use($primaryKey) {
				$collection->unique( $primaryKey );
			} );
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		DB::connection( 'mongodb' )->drop( $this->tableNames );
	}
}
