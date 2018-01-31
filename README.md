# yii2basic

Installation (развертывание проекта)



Practical task A - web application "Presentations Exchange"

during migration there was created a user 'admin' with password 'admin'.





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









Practical task B - REST API for modile applications

Request to get access token:
curl -X POST \
  http://api.loc/v1/oauth2/token \
  -H 'Content-Type: application/json' \
  -d '{"grant_type":"password","username":"admin","password":"admin","client_id":"testclient","client_secret":"testpass"}'

Request current user profile:
curl -X GET \
  http://api.loc/v1/profile \
  -H 'Authorization: Bearer <ACCESS_TOKEN>'
where <ACCESS_TOKEN> is 'access_token' from the previous response

Update current user profile:
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

Request to get list of presentations:
curl -X GET \
  http://api.loc/v1/presentations \
  -H 'Authorization: Bearer <ACCESS_TOKEN>'


