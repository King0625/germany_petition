# Diplomatic petition api
*<p.s.> This petition has been ended since Oct 10th, 2019*

This is a php crawler to modify the register and signin actions.

Domain name: **https://germany-diplomatic-petition.appspot.com**

## api endpoints
method|URI|function
-|-|-
GET|/petition|Get the newest petition counts
POST|/register|Register the petition account
POST|/signin|Signin to make the petition

<p.s> In register function, if it fails, it only cares about email verification since other inputs will be validated by the front-end section first.
