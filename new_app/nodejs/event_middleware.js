'use strict';
var eventModel = require('../models/eventModel');
var sessionService = require('../services/session');


exports.checker = async function (req, res, next) {
    console.log("eventchecker");
    // check the session
    var event = req.session.event;
    var event_settings = req.session.event_settings;

    console.log("CHecker");
    console.log(event);

    if( event === undefined || event.id === undefined || event === false ) {

        sessionService.setEventSession();

    } else {
        console.log("I HAZ EVENT: " + event.event_id);
    }

    // put in 'flash' data
    res.locals.event = req.session.event;
    res.locals.event_settings = req.session.event_settings;

    console.log("eventchecker next");
    next();
}
