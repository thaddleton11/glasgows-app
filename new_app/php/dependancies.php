<?php

/**
 * API dependency
 * Uses the decorator and repository design patterns to fetch data from the db or an external API
 */

$container->set('EventsforceRepository', function (ContainerInterface $container) {

	$repository = new App\Repositories\Eventsforce\ApiEventsforceRepository($container->get('Eventsforce'));
	$repository = new App\Repositories\Eventsforce\EloquentEventsforceRepository($repository);

	return $repository;
});