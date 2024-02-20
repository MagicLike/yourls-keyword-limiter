# Limit keywords usage in YOURLS

This plugin gives several limitations on allowed keywords for YOURLS.
Right now, there are 3 limitations that are already implemented:
1. Limit keyword length as provided in https://github.com/adigitalife/yourls-limit-keyword-length
2. Limit usage of blacklisted keywords
3. Limit usage of keywords by using RegEx

## Instructions:
1. Copy the 'keyword-check' folder to user/plugins/.
2. If needed, there are several parameters that can be modified as needed in plugin.php file:
   a. $max_keyword_length to limit the keyword length,
   b. $pattern to check forbidden keyword in RegEx format, and
   c. $kwlist as a dictionary for blacklisted keywords.
3. Activate the plugin in the YOURLS admin interface.

Voila!
