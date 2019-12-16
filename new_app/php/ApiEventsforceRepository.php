<?php
/**
 * Created by PhpStorm.
 * User: DavidS
 * Date: 2019-07-10
 * Time: 16:10
 */

namespace App\Repositories\Eventsforce;


use App\Services\Eventsforce\Eventsforce;
use App\Models\Events\Event;

class ApiEventsforceRepository implements EventsforceInterface {


	protected $eventsforce;



	public function __construct( Eventsforce $eventsforce ) {

		$this->eventsforce = $eventsforce;
	}



	public function events() {

		return $this->eventsforce
			->events()
			->all();
	}



	public function event( int $eventId ) {

		return $this->eventsforce
			->events()
			->setEventId( $eventId )
			->event();
	}


}