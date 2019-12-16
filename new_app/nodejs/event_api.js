var request = require('request');
var logging = require('../services/logging');
var settings    = require('../config/config');
var api_url = settings.api.base_url;


exports.getEvent = function(id) {
    return new Promise( resolve => {
        console.log("getEvent API: " + id);

        request.get(api_url + "/event/" + id, function(err, res, body) {
            console.log(err);
            if( err ) {
                logging.error("API Event failed: " + err);
                resolve(false);
            }
            if( !body ) {
                logging.error("API Event, no body");
                resolve(false);
            }

            try {
                console.log(body);

                resolve(JSON.parse(body));
            } catch (e) {
                resolve(false);
            }


        })
    });
}

