# Sybil

## About

This is just a little Nostr tool for publishing, that I'm slowly going to build out, as the use cases arise.

It's written in PHP 8 with the yaml extension, and some of the underlying functionality is from [NAK v0.7.5](https://github.com/fiatjaf/nak/releases/tag/v0.7.5) or [PHP Helper](https://github.com/nostrver-se/nostr-php), so those are three things that'll need to be installed and configured, for this to work properly.

I've set this repo up with composer, so `composer install` might be enough to get you setup. Please ask for help, if it doesn't work, so that I can fix it! 😊

## Setup

### Define your relays

Check the `relays.yml` file, to see if you want to add or delete any from this personal list. It's the relay list used for performing most of the functions.

### Define your private key

Make sure to set the environment variable `NOSTR_SECRET_KEY` with your nsec, as that's how the info is passed to the script, for logging into private or authorized relays, or for signing events.
This can be done under Linux with ` export NOSTR_SECRET_KEY=<nsec or hex>`

### Figure out which type of encoding you need

If you need to change an event's encoding to call a specific program, you can do so easily at the online [NAK](https://nak.nostr.com/) website. You can even add relay hints, there, which is pretty cool.

### Create a folder for your events

In the root directory, create a `usr` folder.

## Functions

TBD

## Contact

If you have further questions, I can be reached nostr:npub1l5sga6xg72phsz5422ykujprejwud075ggrr3z2hwyrfgr7eylqstegx9z

You can see my other repos on [GitWorkshop](https://gitworkshop.dev/p/npub1l5sga6xg72phsz5422ykujprejwud075ggrr3z2hwyrfgr7eylqstegx9z) or [GitHub](https://github.com/SilberWitch).