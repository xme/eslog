esLog
=====

Send ownCloud users activities to an Elasticsearch server for remote logging.
The idea of this app is based on SuperLog wrote by Bastien Ho
(https://github.com/EELV-fr/Owncloud-Superlog)

The captured events are:
- User login
- User logout
- User creation
- User deletion
- Password change
- Group creation
- Group deletion
- User added/removed to/from a group
- Read file
- Write file
- Delete file
- Copy/rename file
- Share file
- Enable/disablle 3rd party apps

#
# Changelog
#

v1.0
* First version released

#
# Installation
#
This app requires the Elasticsearch PHP API.
See: http://www.elasticsearch.org/guide/en/elasticsearch/client/php-api/current/

Once installed, place the vendor in the root path of the app (ie: /eslog/vendor)

Go to your admin and acive the app then you can configure Elasticsearch in the admin panel



#
# Tests
#

Owncloud 
* OC 8