# Key/ValueStore-NoSQL

This is a Key/Value Store, also known as a NoSQL database. It is written using PHP & hosted on a MySQL database.

The idea is simple. You can store a value by giving it a key, and get a value in the store by providing its key.

I primarily need a small and simple database from time to time to use with different projects. This is a handy solution to have a small amount of persistent data that can be accessed and updated.

JSON objects are posted to the api, and a JSON object is returned in the response. 
Javascript and an HTML page is provided to demonstrate how to interact with the database.

## Setting a value

The data is posted to set.php

```javascript
{
  "key": "first name",
  "value": "Lewie"
}
```

The response:

```javascript
{
   "success": true,
   "key": "first name",
   "value": "Lewie"
}
```

## Getting a value

The data is posted to get.php

```javascript
{
  "key": "first name"
}
```

The response:

```javascript
{
   "success": true,
   "key": "first name",
   "value": "Lewie"
}
```

##Errors

Errors are returned by providing a "message" property.

The response:

```javascript
{
   "success": false,
   "message": "key does not exist"
}
```

#Setting things up
Rename the configuration.example.php file and setup the connection credentials.
Run the schema.sql file to create the database table
To support raw post data, you will need to set you php.ini file
* always_populate_raw_post_data = -1
* If you are unable to modify your php.ini file, make sure all requests content-type are set to application/x-www-form-urlencoded

Note: This is essentially a public database that anyone can update. There are no security restrictions in place for people retrieving and updating content.

The following rules are in place:
* Keys can not be more than 255 characters in length
* Keys are trimmed
* Zero-Length keys are not allowed
* Values can not be more than 1024 characters in length
* Pages only respond to "POST" methods
* Posted data can not contain more than 2048 characters
* The posted content must be a JSON object
* Only the most recent 500 modified keys are stored

The following actions happen:
* the returned content type is application/json
* The headers are setup to prevent the values from being cached
* The table is optimized when a key value is set