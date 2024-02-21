# Limit keywords usage in YOURLS

This plugin gives several limitations on allowed keywords for YOURLS.
Right now, there are 3 limitations that are already implemented:
1. Limit keyword length as provided in https://github.com/adigitalife/yourls-limit-keyword-length
2. Limit usage of blacklisted keywords
3. Limit usage of keywords by using RegEx

## Instructions
1. Copy the 'keyword-check' folder to user/plugins/.
2. If needed, there is a dictionary that can be modified as needed in plugin.php file:
  * $kwlist is a dictionary for blacklisted keywords.
3. Activate the plugin in the YOURLS admin interface.
4. Voila!

## Notes
1. Now maximum keyword length can be edited via administration page.
2. We face spam problems with repeated keywords. That's why default blacklisted keywords may seems chaotic.
3. This plugin is still under development. Adding dictionary editor to the admin page is the one that we are trying to implement right now.
