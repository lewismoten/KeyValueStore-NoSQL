# Key/ValueStore-NoSQL

This is a Key/Value Store, also known as a NoSQL database. It is written using PHP & hosten on a MySQL database.

The idea is simple. You can store a value by giving it a key, and get a value in the store by providing its key.

JSON objects are posted to the api, and a JSON object is returned in the response


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
