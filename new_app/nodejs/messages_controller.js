var logging = require('../../services/logging');
var userModel = require('../../models/userModel');
var validation = require('../../validation/message');



exports.getInbox = async function( req, res ) {
    // get inbox info

    res.render('app/messages/inbox');
};



exports.getThread = async function( req, res ) {
    // get message thread

    res.render('app/messages/thread');
};



exports.getCompose = async function( req, res ) {
    let params = req.params;

    // get 'to' user details
    res.locals.user = await userModel.getUserDetails(params['user_id']);

    res.render('app/messages/compose');
};



exports.setCompose = async function( req, res ) {
    let message_validation = await validation.compose(
        req.body.subject,
        req.body.message,
        req.body.user_id
    );

    if( message_validation.errors ) {
        res.locals.form_errors = message_validation;
        res.render('app/message/compose');
        return;
    }

    try {
        await messagesModel.composeMessage(
            req.body.subject,
            req.body.message,
            req.body.user_id,
            1
        );

        res.locals.success = "Your message has successfully sent!";

    } catch (e) {
        logging.error("Compose Message Failed: " + e.message);
        res.locals.error = "Sorry but there was a problem sending your message. Please try again."
    }
    res.redirect('/app/messages/inbox');
    return;
}
