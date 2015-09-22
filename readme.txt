Changelog

Version 0.1
- release of v0.0.12 as v0.1

Version 0.0.12
- localization support added
- added german translation
- check_info function from updater returns an object to avoid error messages in changelog when using two or more plugins using this update method
- better validation checks of plugin settings

Version 0.0.11
- little changes in update function to remove conflicts with other plugins using the same update method

Version 0.0.10
- new option to compare how many users are on a page after different elapsed times
- category of this event is "time_track", action the page which fired the event, label the elapsed seconds "<x>_seconds"
- default tracking after 0, 10, 20, 30 and 60 seconds
- tracking is disabled when field is empty
- bounce timeout is now disabled when value is 0
- bounce timeout default value after activation or wrong values is now 0 (was 10)
- bounce timeout event category is now "bounce_timeout" (was "<x>_seconds")
- bounce timeout event tracks page which fired the event as event action (like in other events, was "read")
- "<x>_seconds" is now the event label for bounce timeout events (like in time_track events)
- better validation checks of plugin settings
- plugin sourcecode refactored for better maintainability

Version 0.0.9
- added plugin update feature

Version 0.0.8
- customizable code position (head or footer, default head)
- missing or empty plugin options will be replaced with the default values

Version 0.0.7
- changed default for link tracking to enabled

Version 0.0.6
- new option for link tracking (default disabled)

Version 0.0.5
- fixed error with link tracking (all links were reported as internal for the async code and outbound for sync code)

Version 0.0.4
- first version with working link tracking

Version 0.0.3
- first test version for link tracking

Version 0.0.2
- bounce timeout in seconds (was milliseconds)
- category for bounce track event is <seconds>_seconds
- added bounce timeout to async code
- plugin deletes the settings on delete, not on deactivation

Version 0.0.1
- initial version