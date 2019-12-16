<?php

/**
 * Created by PhpStorm.
 * User: DavidS
 * Date: 2019-07-10
 * Time: 16:11
 */

namespace App\Repositories\Eventsforce;


use App\Models\Events\Event;

/**
 * Interface EventsforceInterface
 * @package App\Repositories\Eventsforce
 */
interface EventsforceInterface {

	/**
	 * This resource lists all events for a client.
	 *
	 * @return \App\Services\Eventsforce\Objects\Event[]
	 * @throws \App\Services\Eventsforce\EventforceException
	 */
	public function events();



	/**
	 * This resource returns detailed information about an event.
	 *
	 * @param int $eventId
	 * @return Event
	 * @throws \App\Services\Eventsforce\EventforceException
	 */
	public function event( int $eventId );


}