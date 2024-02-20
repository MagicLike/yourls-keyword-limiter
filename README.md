# Limit keywords usage in YOURLS

This plugin gives several limitations on allowed keywords for YOURLS.
Right now, there are 3 limitations that are already implemented:
1. Limit keyword length as provided in https://github.com/adigitalife/yourls-limit-keyword-length
2. Limit usage of blacklisted keywords
3. Limit usage of keywords by using RegEx

## Instructions
1. Copy the 'keyword-check' folder to user/plugins/.
2. If needed, there are several parameters that can be modified as needed in plugin.php file:
  * $max_keyword_length to limit the keyword length,
  * $pattern to check forbidden keyword in RegEx format, and
  * $kwlist as a dictionary for blacklisted keywords.
3. Activate the plugin in the YOURLS admin interface.
4. Voila!

## Notes
1. Default keyword length is 20 characters.
2. We face spam problems with repeated keyword. That's why default blacklisted keywords may seems chaotic :D.
3. Default blacklisted RegEx pattern used is 6-digits keyword. Again, this is based on our spam problems.
