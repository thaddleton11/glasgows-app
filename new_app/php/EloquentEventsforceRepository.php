<?php

namespace App\Repositories\Eventsforce;

use Carbon\Carbon;
use App\Models\Events\Event;

class EloquentEventsforceRepository implements EventsforceInterface {


	protected $repository;



	public function __construct( EventsforceInterface $repository ) {

		$this->repository = $repository;
	}



	/**
	 * This resource lists all events for a client.
	 */
	public function events() {

		$events = $this->repository->events();

		$list = [];

		foreach( $events as $event ) {

			$this->updateOrCreateEvent( $event );

			$list[] = $event->eventId();
		}

		return Event::with( 'meta' )->find( $list );
	}



	/**
	 * This resource returns detailed information about an event.
	 */
	public function event( int $eventId ) {

		try {
			// -- Gets the event from Eventsforce
			$event = $this->repository->event( $eventId );

			// -- This will either update an existing event in the DB or create a new one
			$this->updateOrCreateEvent( $event );
		} catch( EventforceException $exception ) {
			throw new \Exception( $exception->getMessage(), $exception->getCode() );
		} catch( \Exception $exception ) {

			dd( $exception->getMessage() );
		}

		// -- Return the event model
		return Event::with( 'meta' )
		            ->where( 'event_id', $eventId )
		            ->first();
	}



	protected function updateOrCreateEvent( \App\Services\Eventsforce\Objects\Event $event ) {

		Event::updateOrCreate( [

			'id'       => $event->eventId(),
			'event_id' => $event->eventId(),
		],
			[
				'datestamp'           => time(),
				'event_name'          => $event->name(),
				'event_host'          => '',
				'event_template'      => '',
				'event_template_type' => '',
				'app_template'        => '',
				'order_count'         => 0,
				'created'             => Carbon::now()->toDateTimeString(),
				'last_edited'         => 1,
				'user_id'             => 2,
				'event_status'        => $event->status(),
				'record_status'       => 1,
			] )
		     ->meta()->updateOrCreate( [], [

				'datestamp'     => time(),
				'venue_name'    => $event->venueName(),
				'email'         => '',
				'created'       => Carbon::now()->toDateTimeString(),
				'last_edited'   => Carbon::now()->toDateTimeString(),
				'event_status'  => 1,
				'record_status' => 1,
			] );
	}

}