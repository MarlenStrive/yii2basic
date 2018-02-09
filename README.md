Yii2 & Restfull API course
=================================================

# Installation of the project "Presentation Exchange" #
Run next steps inside the 'yii2project' folder:
- composer install 
- ./init 
- ./yii migrate 

During the migration it would be created database structure and 3 users:

- 'admin' with password 'admin' and 'admin' role
- 'moderator' with password 'moderator' and 'moderator' role
- 'user' with password 'user' and 'user' role


## Available console commands

- **user/password** Resetting a user’s password
- **user/delete** Deleting a user
- **presentation/delete** Deleting presentations
- **presentation/clear-counter** Clearing the counters of presentations

### user/password
Resetting a user’s password.

```sh

./yii user/password <search> <password>

- search (required): string
  Email or username

- password (required): string
  New password

```

### user/delete
Deletes a user.

```sh

./yii user/delete <search>

- search (required): string
  Email or username

```

### presentation/delete
Deleting presentations.

```sh

./yii presentation/delete <id1,id2,id3>

- ids (required): string
  comma separated list of ids to delete

```

### presentation/clear-counter
Clearing the counters of presentations.

```sh

./yii presentation/clear-counter <id1,id2,id3>

- ids (optional): string
  comma separated list of ids to delete
  if ids are not specified, counters would be cleared for all presentations

```


# REST API for modile applications #

Request to get access token:
```
curl -X POST \
  http://api.loc/v1/oauth2/token \
  -H 'Content-Type: application/json' \
  -d '{"grant_type":"password","username":"admin","password":"admin","client_id":"testclient","client_secret":"testpass"}'
```

Request current user profile:
```
curl -X GET \
  http://api.loc/v1/profile \
  -H 'Authorization: Bearer <ACCESS_TOKEN>'
```
where <ACCESS_TOKEN> is 'access_token' from the previous response

Update current user profile:
```
curl -X POST \
  http://api.loc/v1/profile \
  -H 'Authorization: Bearer <ACCESS_TOKEN>' \
  -H 'Content-Type: application/json' \
  -d '{
    "name": "A new name",
    "second_name": "Surname",
    "public_email": "some@email.com",
    "website": "github.com",
    "country": "Ukraine",
    "city": "Kyiv",
    "timezone": "Pacific/Apia",
    "language": "English",
    "gravatar_email": "some@email.com",
    "bio": "Biography story"
}'
```

Request list of presentations for the current user:
```
curl -X GET \
  http://api.loc/v1/presentations \
  -H 'Authorization: Bearer <ACCESS_TOKEN>'
```

Change the current page in the presentation:
```
curl -X GET \
  http://api.loc/v1/presentation/<presentation-public-url>/<page-number> \
  -H 'Authorization: Bearer <ACCESS_TOKEN>' \
  -H 'Content-Type: application/json' \
  -d '{
    "content": "Some new page content",
    "note": "Some new note"
}'
```


# Testing #
To run testing there should be done next steps:
- create database 'yii2advanced_test' (or other one, that is specified in the config files 'test-local.php')
- run ./yii_test migrate
- run vendor/bin/codecept build
- to run acceptance tests need to install and start Selenium server with ChromeDriver (found a good instraction here https://gist.github.com/ziadoz/3e8ab7e944d02fe872c3454d17af31a5)
- change if needed values 'WebDriver.url' inside the file 'frontend/tests/acceptance.suite.yml' and 'REST.url' inside the file 'api/tests/api.suite.yml'

Run tests:
- vendor/bin/codecept run

